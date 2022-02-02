<?php
include_once('../config/config.php'); 
if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');

include_once('../class/connect_db.php'); 
include_once('../class/admin.php'); 
include_once('../class/main.php');

 class OS_BR{

    private $agent = "";
    private $info = array();

    function __construct(){
        $this->agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
        $this->getBrowser();
        $this->getOS();
    }

    function getBrowser(){
        $browser = array("Navigator"            => "/Navigator(.*)/i",
                         "Firefox"              => "/Firefox(.*)/i",
                         "Internet Explorer"    => "/MSIE(.*)/i",
                         "Google Chrome"        => "/chrome(.*)/i",
                         "MAXTHON"              => "/MAXTHON(.*)/i",
                         "Opera"                => "/Opera(.*)/i",
                         );
        foreach($browser as $key => $value){
            if(preg_match($value, $this->agent)){
                $this->info = array_merge($this->info,array("Browser" => $key));
                $this->info = array_merge($this->info,array(
                  "Version" => $this->getVersion($key, $value, $this->agent)));
                break;
            }else{
                $this->info = array_merge($this->info,array("Browser" => "UnKnown"));
                $this->info = array_merge($this->info,array("Version" => "UnKnown"));
            }
        }
        return $this->info['Browser'];
    }

    function getOS(){
        $OS = array("Windows"   =>   "/Windows/i",
                    "Linux"     =>   "/Linux/i",
                    "Unix"      =>   "/Unix/i",
                    "Mac"       =>   "/Mac/i"
                    );

        foreach($OS as $key => $value){
            if(preg_match($value, $this->agent)){
                $this->info = array_merge($this->info,array("Operating System" => $key));
                break;
            }
        }
        return $this->info['Operating System'];
    }

    function getVersion($browser, $search, $string){
        $browser = $this->info['Browser'];
        $version = "";
        $browser = strtolower($browser);
        preg_match_all($search,$string,$match);
        switch($browser){
            case "firefox": $version = str_replace("/","",$match[1][0]);
            break;

            case "internet explorer": $version = substr($match[1][0],0,4);
            break;

            case "opera": $version = str_replace("/","",substr($match[1][0],0,5));
            break;

            case "navigator": $version = substr($match[1][0],1,7);
            break;

            case "maxthon": $version = str_replace(")","",$match[1][0]);
            break;

            case "google chrome": $version = substr($match[1][0],1,10);
        }
        return $version;
    }

    function showInfo($switch){
        $switch = strtolower($switch);
        switch($switch){
            case "browser": return $this->info['Browser'];
            break;

            case "os": return $this->info['Operating System'];
            break;

            case "version": return $this->info['Version'];
            break;

            case "all" : return array($this->info["Version"], 
              $this->info['Operating System'], $this->info['Browser']);
            break;

            default: return "Unkonw";
            break;

        }
    }
}
 
class TimerSSTConnected extends ConnectDB {

private $id_user;
private $dbh;
private $json;

private $page=null;
private $id=null;
private $last_name=null;
private $first_name=null;
private $ip=null;

private $timer_deconnected=null;
private $timer_connected=null;
private $navigator=null;

private $os=null;
private $count=null;
private $timer_all=null;
private $connected=null;
 								
									
private $main = null; 

public function __construct() { 
	 
	 $this->main = new Main();
	if ( class_exists('ConnectDB')) { 
		$this->dbh = new ConnectDB();	 
	}  else {
		$this->dbh = NULL; 
	}
}


private function ckeckTimer($result) {
	
	if( $this->getTimer()+10 < ($result['timer_connected']+20) ) { 
		 return true; // continue 
	} else {
		 return false; // stop
	}
}

private function getTimer() {
	list($usec,) = explode(".", microtime(true));
    return ( (float)$usec); 
}

function getIdUser( ) {
	return $this->id_user;
}

function setIdUser($id_user) {
	$this->id_user = $id_user;
}


function getPage( ) {
	return $this->page;
}

function setPage($page) {
	$this->page = $page;
}

private  function setJSONValue($s=null ) {
	
	$browser = new OS_BR();
	
	$admin = new AdminAuthority();
	$this->json = '{"status":"'.$s.'",
				"class":"connected",
				"id_user":"'.(is_null($this->id_user) ? '' : $this->id_user) .'",
				"timer_connected":"'.(is_null($this->timer_connected) ? '' : $this->timer_connected) .'", 
				"timer_deconnected":"'.(is_null($this->timer_deconnected) ? '' : $this->timer_deconnected).'",
				"first_name":"'.(is_null($this->first_name) ? '' : $this->first_name).'",
				"last_name":"'.(is_null($this->last_name) ? '' : $this->last_name).'", 
				"ip":"'.(is_null($this->ip) ? '' : $this->ip).'",
				"page":"'.(is_null($this->page) ? '' : $this->page).'",
				"navigator":"'.(is_null($this->navigator) ? '' : $this->navigator).'",
				"os":"'.(is_null($this->os) ? '' : $this->os).'",
				"timer_all" :"'.(( $admin->isSessionAdminSudo() || $admin->isSessionAdminSimple()) ? 'all' :'' ) .'"}';
	$this->json;
}

public function getJSONValue( ) {
	print( $this->json );
}

public function returnJSONValue( ) {
	return $this->json;
}


public function timerSelect($all=null) {
	
	 
	$ex = ConnectDB::DB();
	if(is_null( $all ) ) {
		if(!ConnectDB::isSession()) { return; }	
		
		$query = $ex->prepare("SELECT * FROM `timer` WHERE id_user='{$this->id_user}'");
		$query->execute();
		return  $query->fetch(PDO::FETCH_ASSOC);
	} else {
		$query = $ex->prepare("SELECT * FROM `timer`");
		$query->execute();
		return  $query->fetchAll(PDO::FETCH_ASSOC);
	}
	 
	 
}

private function timerInsert() {
	try {
		if(!ConnectDB::isSession()) { return; }
		$ex = ConnectDB::DB();  
		$query = $ex->prepare("INSERT INTO timer() 
							VALUES('".$this->dbh->guid()."',
									'".$this->id_user."',
									'".$this->last_name."',
									'".$this->first_name."',
									'".$this->timer_connected."',
									'".$this->timer_deconnected."',
									'".$this->connected."',
									'".$this->ip."',
									'".$this->page."',
									'".$this->navigator."',
									'".$this->os."',
									'".$this->timer_all."',
									'".$this->count."')"
							);			
		$query->execute();
		 
	} catch(Exception $e) {
 
		print  ('ERROR BD INSERT # 5005 '.$e->getMessage()); 
		exit ;
	}
}

 

public function timerConnected($how=null) {
	
	$browser = new OS_BR();
	if( $this->isID($this->id_user) && is_array($r = $this->timerSelect() ) && !empty($r)  ) {
	
		$this->last_name  = $r['last_name'];
		$this->first_name  = $r['first_name'];
		$this->timer_deconnected  = $r['timer_deconnected'];
		$this->timer_connected  = $r['timer_connected'];
		
			$this->ip = $this->main->getIP();
			$this->navigator = $browser->showInfo('browser');
			$page->page = $this->getPage();
			$this->os = $browser->showInfo('os');
			
			
		
	} else {
		$admin = new AdminAuthority();
		if($admin->isSessionAdminSudo() || $admin->isSessionAdminSimple()  ) {
			return ;
		}
		if( $this->isID($this->id_user) && is_array($r = $this->dbh->checkRegistration($this->id_user)) ) {
		 
			$this->last_name  = $r['last_name'];
			$this->first_name  = $r['first_name'];
			
			$this->timer_deconnected  = date(DATETIME);
			$this->timer_connected  = $this->getTimer();
			$this->connected = '1';
			$this->ip = $this->main->getIP();
			$this->navigator = $browser->showInfo('browser');
			$page->page = $this->getPage();
			$this->os = $browser->showInfo('os'); 
			$this->timer_all ="";
			$this->count = 1;
			 
			$this->timerInsert();
			
			return $this->timerConnected($how);
			
		}   
	}

	switch($how) {
	
		case 0: // user 
			 
			
			$this->updateTimerConnectedInBD(1, new AdminAuthority()); 
			$this->setJSONValue(777);
			return $this->getJSONValue() ;
			 
		break;
		
		case 1: // admin
			
			if( $this->ckeckTimer($r) ) {
				$this->setJSONValue(777);
				return $this->getJSONValue() ;

			} else {
				 
				$this->updateTimerConnectedInBD(0, new AdminAuthority()); 
				$this->setJSONValue(333);
				return $this->getJSONValue() ;
					
			} 
			
		break;
		
	}
		$this->setJSONValue(222);
		return $this->getJSONValue() ;
	 
}

public function updateTimerConnectedInBD($val=0, $admin) {
	 
	$timerd = (
			($admin->isSessionAdminSudo() || $admin->isSessionAdminSimple() ) ?
			'' : 
			"`timer_deconnected`='".date(DATETIME)."',"
	);
	
	$ip = (
			($admin->isSessionAdminSudo() || $admin->isSessionAdminSimple() ) ?
			'' : 
			"`ip`='".$this->main->getIP()."',"
	);
	$page = (
			($admin->isSessionAdminSudo() || $admin->isSessionAdminSimple() ) ?
			'' : 
			"`page`='".$this->getPage()."',"
	);
	 
		
	if($val == 0) {
		$timerc = 0;
		$val = 0;
	} else {
		$timerc = $this->getTimer() ;
		$val = 1;
	}
	 	
	  
	try {
	$ex = ConnectDB::DB(); 
	$query = $ex->prepare("UPDATE `timer` SET 
									`timer_connected`='{$timerc}', 
									{$timerd}
									`connected`='{$val}',	
									{$ip}
									{$page}	
									`timer_all`=''
							WHERE `timer`.`id_user` = '{$this->id_user}';");
	$query->execute();
	} catch(Exception $e) {
		$this->setJSONValue(222);
		return $this->getJSONValue() ;
	}
}

public function getAllConnected( ) { 
 
	$result =  $this->timerSelect('ALL');
	$h = '';
	
		if(!is_array($result) || empty($result) ) {
			$this->setJSONValue(222);
			return $this->getJSONValue() ;
		}
		
		foreach( $result as $k => $v ) {
			
			$this->id_user = $result[$k]['id_user']; 
			$this->last_name  = $result[$k]['last_name'];
			$this->first_name  = $result[$k]['first_name'];
			$this->timer_deconnected  = $result[$k]['timer_deconnected'];
			$this->timer_connected  = $result[$k]['timer_connected'];
			$this->ip  = $result[$k]['ip'];
			$this->page  = $result[$k]['page'];
			
			$this->navigator  = $result[$k]['navigator'];
			$this->os  = $result[$k]['os'];
			
			if( $this->ckeckTimer($result[$k]) ) {  
			
				$this->setJSONValue(777);
				$h .= '"con'.$k.'"'.':' .$this->returnJSONValue().','; 
				
			} else {
			  	
				$this->updateTimerConnectedInBD(0, new AdminAuthority()); 
				
			}
		}
		if(empty($h) )  {
			$this->setJSONValue(222);
			return $this->getJSONValue() ;
		}
		
	$s = substr($h, 0 , -1); 
	print ('{'.$s.'}'); 
   
}

}
 
// if user has been connected .

if(isset($_POST['iduser']) ) {

	$sst_connecter = new TimerSSTConnected();
	$admin = new AdminAuthority();
 
	if($admin->isSessionAdminSudo() || $admin->isSessionAdminSimple() ) {
		if($_POST['iduser']  == 0 ) {
		 
			$sst_connecter->getAllConnected( );
		} else {
		   
			$sst_connecter->setIdUser( $_POST['iduser'] ); 
			$sst_connecter->timerConnected(1);
		}	
	
	} else {
		$sst_connecter->setPage($_POST['page'] ); 
		$sst_connecter->setIdUser( ConnectDB::isSession() ); 
		$sst_connecter->timerConnected(0);

	} 
}
 


 
?>