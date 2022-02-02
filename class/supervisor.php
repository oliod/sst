<?php
//print_r(preg_replace('/\s+/', '', $this->get_all_fragment[0]['key_server'])); 
define('AUTH_SERVER_URL', '');
 
class Supervisor {

	public $authenticationServerUrl;
	private $dbh;
	private $page;
	private $main;
	
	public $new_key = null; 
	
	private $server_key = array(
		'rsa_key_doc_training' => 'AAAAB3NzaC1yc2EAAAABJQAAAQEA+uX1KYnm/UnRnYym5kCO4w1Ef5MXLYHG/1DqyI3ZgsXLGAnbOgiz7hWpZhETLR4op807DaRHJp80OoHc/FL69FjkHDd0IAtcBJIspap5rA86uM9RTAT/wp2uXc7UPPPWu94w/miGULraI+5xL5CwbuHR/13yvZbxUWYM4063qC49JTeIGCz+gSpL2pwppEAeIzWxMMU5HU5TNdu7EC3275M7AHjvjAp9bgVu2WwIn0PU9AWvhDmEPBJQe7VZwXjS/hISOxdvHjMLPme2oOdfMuuwQwyAV7TUjYZHa//m1UXdiJ42CmoCwObaj4l/gdPylUyFzuiWRF5w7Kq9nVk7OQ',
		'rsa_key_addmission' => 'AAAAB3NzaC1yc2EAAAABJQAAAQEAiK4KzSF2uP750R0GCmWErE960HMdcPBejeb40aP8pjRPmSIaRDliA4pbuhVxXEpC1op4JJ5As4WZpElvgVgl7XJbz0nf84aQjRbCfhtzR+6b+LVlyOK76Uaq//c6ULn56iCuFLokXVy/warHebVhuW01k0ubbjQiroxfDerQ8iJ5+9K7WaxP7ubLbF3qIvKWjMylzLw/puZFWD9bwE37T6hdpxNmD3ddRyN7P0jaJBnfPmobpE1mAKNqCM0N3TW72ScKdrPU5cMpyB9Nrz2Ksta56ZERxn9Vt1jtlqsjoGmtcoQ7z7aEYujpwklLyvZAEINNquwBLMYT08lG0j9IMw',
	);
	public $url_fragment =  array(0=>'id', 1=>'key');
	public $supervisory_link = '';
	public $get_all_fragment = array();

	public function __construct( ) { } 
	
	public function isValidSupervisor($authenticationServerUrl) { 
	
		$dbh = new ConnectDB();
		$main = new Main(); 
		
		$this->authenticationServerUrl = $authenticationServerUrl;
		
		if($this->isValidLinkSupervisor()) {
			$output = (($output = $this->setContentSupervisor(DIR_FOLDER_SUPERVISOR_SIMPLE.$this->get_all_fragment[0]['id'])) ? $output : 0) ;  
			if(is_object($output)) {
				if((isset($output->id_user[0])) && ($dbh->isID($output->id_user[0]))) {  
					if($dbh->checkRegistration($output->id_user[0])) {
						$this->createSession($output->id_user[0], $output->id_supervisor[0]);
					} else {
						print('ERROR CLASS SUPERVISOR # 2345564 USER NON EXISTS');
					}
				}	
			}
		}
	}
	
	public function getContentSupervisor($user_session) {
		return (($output = $this->setContentSupervisor(DIR_FOLDER_SUPERVISOR_SIMPLE.$user_session)) ? $output : false) ; 
	}
	
	private function setContentSupervisor($file) {
	
		$main = new Main();
		  
		if($path = $main->isDirectoryExists('', $file)) {
			$json_string = $main->showContentFile($path);
			return $main->jsonValidate($json_string);
		} else { 
			return false;
		}
	}
	
	private function createSession($id_user, $id_supervisor) {
		AdminAuthority::destroySessionAdmin(null, $id_user);
		$_SESSION['SST_SUPERVISOR'] = $id_supervisor;
	}
	
	private function isValidLinkSupervisor() {
		$url_uery = parse_url($this->authenticationServerUrl , PHP_URL_QUERY);
		if((strpos($url_uery, $this->url_fragment[0]) !== false) && (strpos($url_uery, $this->url_fragment[1]) !== false))  {
		
			$exp = explode($this->url_fragment[1], $url_uery);
			$epc = str_replace('%20', '', $exp[1]); 
			$epc = preg_replace('/[\s\=]/i', '', $epc); // this is &key= 
			
			$_GET[$this->url_fragment[0]] = str_replace(' ',   '', $_GET[$this->url_fragment[0]]);
			
			$k = $this->selectSupervisor($_GET[$this->url_fragment[0]], 'GET'); // this is key too &key= 
			  
			if(($epc == $this->server_key['rsa_key_doc_training']) || ($epc == $k)  ) { 
				 
				array_push($this->get_all_fragment, $_GET);
				return  true;
			 } else { 
				return false;
			 }
		} else {
			return false;
		}
	}
	
	public static function isSessionSupervisor() {
		if(isset($_SESSION['SST_SUPERVISOR'])) { 
			return $_SESSION['SST_SUPERVISOR'];
		} else {
			return false;
		}
	}

	public function getLinkSupervisory() {
		return $this->supervisory_link;
	}
	
	private  function setLinkSupervisor($supervisory_link) {
		$this->supervisory_link = $supervisory_link; 
	}

	public function buildAuthenticationUrl($link, $user_session, $test = null) { 
		$k = $this->selectSupervisor();
		if(!$k) return false;
		
		$link = SERVER_NAME.$link.'&'.$this->url_fragment[0].'='.$user_session.'&'.$this->url_fragment[1].'='.$k; 
		$this->setLinkSupervisor($link);
	}
	
	public function initAuthenticationAndRedirect($return_url){
		PageSST::disconn();
        if (headers_sent()) { throw new Exception('Cannot redirect at the moment.');}
        header('Location: '. $return_url);
        exit;
    }
	
	public function selectSupervisor($id=null, $test=null) {	
		try {
			$dbh = ConnectDB::DB();
			$s = (( $id == null || $test == 'GET' ) ? "" : " AND `id_init_supervisor`='{$id}'");	
			$sql = "SELECT * FROM `supervisor_mail` WHERE `id_user`= '".(($test == 'GET') ? $id : ConnectDB::isSession() ) ."' {$s}";  
			$query = $dbh->prepare($sql);
			$query->execute();
			if($query->rowCount() > 0 ) { 
				$result = $query->fetch(PDO::FETCH_ASSOC);
				return $result['id_init_supervisor'];
			} else {
				return false;
			}
		} catch(Exception $e) {
		return false;
		}
	}
 
	public function seekSupervisor($id=null, $n=0, $index=0) {
		$dbh = new ConnectDB();
		$page = new PageSST();		
		if(!$dbh->isID($id)) { return false; } 
		$arr = array(
					0 => array('adm_supervisory_panel' => 'id_adm_supervisory_panel'),
					1 => array('my_supervisory_panel'  => 'id_my_supervisory_panel'), 
					);

		if( $n > sizeof($arr) || (!isset($arr[$n])) ) { return; }
		try {  
			$dbh = ConnectDB::DB(); 
			$sql = "SELECT * FROM `".$page->getKeysInArray($arr[$n], 0)."` 
					WHERE `id_user`= '".ConnectDB::isSession()."'
					AND `".$page->getValuesInArray($arr[$n], 0)."` = '{$id}'";
			$query = $dbh->prepare($sql);
			$query->execute();
			if($query->rowCount() > 0 ) {  
				return $query->fetch(PDO::FETCH_ASSOC);  
			} else { 
				return $this->seekSupervisor($id, ++$n, 0);
			}
		} catch(Exception $e) { 
			 //print( $e->getMessage().' ERROR SUP#  255022 '); 
			return false;
		}
		//**************
	}
	 
	
	public function insertSupervisor($id) {
		if(!ConnectDB::isSession()) { return false; }
		$db = new ConnectDB();
		 
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("INSERT INTO `supervisor_mail` () 
								VALUES('{$db->guid()}',
											'".$id."',
											'".ConnectDB::isSession()."',
											'".ConnectDB::staticFormatDate()."');");
			$query->execute();
			return true;
		} catch(Exception $e) {
			return false;
		}
	}
	
	public function isMailCorrectSupervisor() {
		$dbh = new ConnectDB();
		if(!$this->selectSupervisor()) { 
			return false; 
		}
			if(is_array($sup = $this->seekSupervisor($this->selectSupervisor(), 0, 0))) {
				if(!$dbh->validMail($sup['email'])) {   return false; }
			} else {  
				return false;
			}
		return true;
	}
}
?>