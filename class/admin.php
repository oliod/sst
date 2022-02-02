<?php 

class AdminAuthority {

private $_login;
private $_pwd;
private $admin_id;
public $application_sst = false; 
public function __construct($login=null, $pwd=null) { 
	$this->_login = $login;
	$this->_pwd = $pwd;
}

private function setIdAdmin($admin_id) {
	return $this->admin_id = $admin_id;
}

public function getIdAdmin() {
	return $this->admin_id;
}

public static function getTitleAdmin() {
	$page = new PageSST();
	$admin = new AdminAuthority();
	$wp_data = $admin->getDataAdminSimpleWP();
	
	if(self::isSessionAdminSudo()) {
		return ' <H1 style="color:red;"> '.$page->showText('header_administrator_sudo').' </H1>'; // 
	} else if( $wp_data['wp_data']['mod'] == 2 ) { 
		return ' <H1 style="color:red;"> '.$page->showText('header_administrator_simple').' </H1>';
	} else if($wp_data['wp_data']['mod'] == 1 ) { 
		return ' <H1 style="color:red;">'.$page->showText('header_administrator_simple').' </H1>'; //   
	} else if(is_object(SignatureLink::getSessionSignature() ) ) {
		return ' <H1 style="color:red;">'.$page->showText('header_link_signatures').'</H1>'; // 
	} else {
		return ;
	}
}

public static function getJSEditText($test=null) {
	$admin = new AdminAuthority();
	$wp_data = $admin->getDataAdminSimpleWP();
	if( $wp_data['wp_data']['mod'] == 2 || self::isSessionAdminSudo()) {  
		$js  = 'ondblclick="chengeTextArea(this.id, \'class_text_area\', \'id_text_area\', 10, 59);"';
		$js .= 'onmouseover="modifMouseOver(this.id)"';
		$js .= 'onmouseout="modifMouseOut(this.id)"';
		return $js;
	} else {
		if($test == 1 ) {
			$js  = 'ondblclick="chengeTextArea(this.id, \'class_text_area\', \'id_text_area\', 10, 59);"';
			$js .= 'onmouseover="modifMouseOver(this.id)"';
			$js .= 'onmouseout="modifMouseOut(this.id)"';
			return $js;
		}
		
		return false;
	}
}

public function checkAuthAdmin() {
	if($this->getAdmin()) {
		return true;
	} else {
		return false;
	}
}

public function showLog($file=null) {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		return file_get_contents($file , null, null); 
	}	
}

public function writeLogFile($file=null, $content=null) {  
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		if(file_exists($file)){
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
		}
	}		 
}

private function _openSessionAdminSudo() {
	$_SESSION['SST_ADMIN_SIMPLE'] = array();
	unset($_SESSION['SST_ADMIN_SIMPLE']); 
	return $_SESSION['SST_ADMIN_SUDO'] = $this->getIdAdmin();
}

private function _openSessionAdminSimple() {
	$_SESSION['SST_ADMIN_SUDO'] = array();
	unset($_SESSION['SST_ADMIN_SUDO']); 
	return $_SESSION['SST_ADMIN_SIMPLE'] = $this->getIdAdmin();
}

public static function destroySessionAdmin($page=null, $id_user) {
	$dbh = new ConnectDB();
	if(isset($_SESSION['SST_ADMIN_SUDO'])) {
		unset($_SESSION['SST_ADMIN_SUDO']);
	} if(isset($_SESSION['SST_ADMIN_SIMPLE'])) {
		unset($_SESSION['SST_ADMIN_SIMPLE']);
	} if(isset($_SESSION['SST_GUID'])) {
		unset($_SESSION['SST_GUID']) ;
	} if(isset($_SESSION['SST_CONNEXION']) ) {
		unset($_SESSION['SST_CONNEXION']) ;
	}
	
	if($dbh->isID($id_user)) {
		$_SESSION['SST_GUID'] = $id_user;
		$_SESSION['SST_CONNEXION'] = "CONNECTED";
		if(ConnectDB::isSession()) {
			return;
		}
	} else {
		PageSST::disconn();
	}
	 
	$page = ($page == null ? SERVER_NAME : $page);
	header("location: {$page}");
}

public function listshowAllUserAdm() {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `registration`");
			$query->execute();
			if($query->rowCount() > 0 ) {
				return $query->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN SELECT # 9021544 '.$e->getMessage());
			exit;
		}
	} 
}

public static function isSessionAdminSudo() { 
	if(isset($_SESSION['SST_ADMIN_SUDO'])) {
		return true;
	} else {
		return false;
	}
}

public static function isSessionAdminSimple(){ 
	if(isset($_SESSION['SST_ADMIN_SIMPLE'])) {
		return true;
	} else {
		return false;
	}
}

public function getSessionAdmin() {
	if(isset($_SESSION['SST_ADMIN_SUDO'])) { return $_SESSION['SST_ADMIN_SUDO']; }
	if(isset($_SESSION['SST_ADMIN_SIMPLE'])) { return $_SESSION['SST_ADMIN_SIMPLE']; }
	
	return false;
}

private function getAdmin() {
	if($this->_checkAdminSudo())   { return $this->_openSessionAdminSudo(); }
	if($this->_checkAdminSimple()) { 
		if(isset($GLOBALS['sst']['application_sst'][0])) {
			if(is_numeric($status = $GLOBALS['sst']['application_sst'][0] ) ) {
				if($status == 1) {
					$this->setApplicationSST('ERROR ADMIN CONNEXION # 6020 ');
					return false;
				} 
			}
		}	
		return $this->_openSessionAdminSimple(); 
	}
	return false;
} 

public function getApplicationSST() {
	return $this->application_sst;
}

private function setApplicationSST($application_sst) {
	$this->application_sst = $application_sst;
}

private function _checkAdminSudo() { 
	$adm_login = 'b642b4217b34b1e8d3bd915fc65c4452'; //'64e1b8d34f425d19e1ee2ea7236d3028';
	$adm_pwd   = '098f6bcd4621d373cade4e832627b4f6'; // 'ee5a70b448ed2c231c48c0ad63f2968c'; ///21232f297a57a5a743894a0e4a801fc3
	if($adm_login == md5($this->_login) && $adm_pwd == md5($this->_pwd)) { 
		$dbh = new ConnectDB();
		return $this->setIdAdmin($dbh->status_default_value['id_admin']);
	} else {
		return false;
	}
}

public function getDataWP() {
	if(self::isSessionAdminSimple()) {
		$simple = $_SESSION['SST_ADMIN_SIMPLE'];
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `wp_user` WHERE `wp_user`.`id_wp_user` ='".$simple."'");
			$query->execute();
			if($query->rowCount() > 0 ) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return  $data;
			} else {
				return false;
			}
		}  	catch(Exception $e) {
			print ('ERROR DB ADMIN SELECT # 90555 '.$e->getMessage());
			exit;
		}
	}  
}

public function getDataAdminSimpleWP() {
	$main = new Main();
	$a['wp_data']['mod'] = -1;
	$a['wp_data']['data'] =  new stdClass();
	if($this->isSessionAdminSimple()) { 
		$this->getSessionAdmin();
	 
		$admin_simple = $this->getDataWP();
		if($admin_simple['delete'] != 0) {
			if($admin_simple['pw_adm'] == 1) {
				$a['wp_data']['mod'] = 2; // 'USER ADMIN '; // 2
				$a['wp_data']['data'] = $main->jsonValidate(json_decode(json_encode($admin_simple['wp_box']), true));	
				return $a; 
			} else {
				$a['wp_data']['mod'] = 1; // ' USER ADMIN SIMPLE '; // 1
				$a['wp_data']['data'] = $main->jsonValidate(json_decode(json_encode($admin_simple['wp_box']), true));	
				return $a; 
			}
		} else {	
			$a['wp_data']['mod'] = 0; // ' ADMIN SIMPLE BLOCKED'; // 0
			PageSST::disconnectPage();
		}	
	} else {
		return $a;
	}
}

public function getIMGWP($pos=0, $img=null) {

	if(self::isSessionAdminSimple()) { 
		$data = $this->getObjectWP();
		if(!is_null($img)) {
			if($data->{$pos} == 'true') {
				$main = new Main(); 
				return $main->getSrcImg($GLOBALS['sst']['icon']['comment_edit'], 'width="22"');
			} 
		}
		
		//echo '<pre>';
		//print_r($data->{$pos});
		//if($data->{$pos}) 
		//echo '</pre>';
	}
	
}

public function getObjectWP() {
	$main = new Main();
	$data = $this->getDataWP();
	return $main->jsonValidate(json_decode(json_encode($data['wp_box']), true));	
}

private function _checkAdminSimple() {
	if($id = $this->_authPWDB()) { 
		return $this->setIdAdmin($id);
	} else {
		return false;
	}
}

private function _authPWDB() {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `wp_user` 
								WHERE `wp_user`.`email` ='".$this->_login."' 
								AND `wp_user`.`pwd` ='".$this->_pwd."' 
								AND `wp_user`.`delete` ='1'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			$data = $query->fetch(PDO::FETCH_ASSOC);
			$this->_updateDate($data['id_wp_user']);
			return  $data['id_wp_user'];
		} else {
			return false;
		}
	}  catch(Exception $e) {
		print ('ERROR DB ADMIN SELECT # 90555 '.$e->getMessage());
		exit;
	}
}

private function _updateDate($id) {
	if(self::isSessionAdminSimple()) {
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `wp_user` SET 
											`last_visited` = '".ConnectDB::staticFormatDate()."'
								WHERE `wp_user`.`id_wp_user` = '".$id."';");
		$query->execute();
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN UPDATE # 9856 '.$e->getMessage());
			exit;
		} 
	}	
}

public function getImageUser() {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `registration` 
									WHERE `id_user` ='".ConnectDB::isSession()."'");
			$query->execute();
			if($query->rowCount() > 0 ) {
				$data = $query->fetch(PDO::FETCH_ASSOC);
				return   stripslashes($data['first_name']).' ' .stripslashes($data['last_name']);
			} else {
				return false;
			}
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN SELECT #  9021687 '.$e->getMessage());
			exit;
		}
	} 	 
}

public function insertText($r, $test=null) {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) { 
		try {
			$dbh = ConnectDB::DB();
			$db = new ConnectDB();
			switch($test) {
				case 1:
					 
					$query = $dbh->prepare("INSERT INTO `text_user` 
							(`id_text_user`, `id_user`, `text`, `id_admin`, `date`) 
							VALUES ('".$db->guid()."', 
							'".$r['id_user']."', 
							'".$r['text']."', 
							'".$r['id_admin']."',
							'".ConnectDB::staticFormatDate()."');");
				break;
				default:
					return false;
					
			}
			 
			$query->execute();
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN INSERT #  9024324536 '.$e->getMessage());
			exit;
		}
	
	}
	
}

public function updateText($r, $test=null) {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		try {
			$dbh = ConnectDB::DB();
			switch($test) {
				case 1:
					$query = $dbh->prepare("UPDATE `text_user` SET 
											`text`      = '".$r['text']."',
											`id_admin`  = '".$r['id_admin']."',
											`date`      = '".$r['date']."'
											WHERE `text_user`.`id_user` = '".$r['id_user']."';");
				break;
				default:
					$query = $dbh->prepare("UPDATE `text` SET 
											`text`      = '".$r['text']."',
											`id_admin`  = '".$r['id_admin']."',
											`date`      = '".$r['date']."'
											WHERE `text`.`id_text` = '".$r['id_text']."';");
			
			}
			 
			$query->execute();
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN UPDATE #  902177 '.$e->getMessage());
			exit;
		}
	} 	
}

public function adminSimpleAuthority() {
	//--- read or write or anything 
}

public function publicDefenceAdmin($r) {  
	if(is_array($this->publicDefenceAdminSelect())) {   
		return $this->publicDefenceAdminUpdate($r) ;
	} else {
		return  $this->publicDefenceAdminInsert($r) ;  
	}
}

public function publicDefenceAdminInsert($r) {
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		try {
			$dbh = ConnectDB::DB();
			$db = new ConnectDB();
			$query = $dbh->prepare("INSERT INTO `public_defence_admin` 
							(`id_public_defence_admin`, `id_admin`, `id_user`, `place`, `thesis_num`, `money`, `check`, `hypertext`, `create_date`) 
							VALUES ('".$db->guid()."', 
							'".$r['id_admin']."', 
							'".ConnectDB::isSession()."', 
							'".$r['place']."',
							'".$r['thesis_num']."',
							'".$r['money']."',
							'".$r['check']."', 
							'hyper', 
							'".ConnectDB::staticFormatDate()."');");
			$query->execute();
			return true;
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN INSERT #  905475 '.$e->getMessage());
			exit;
		}
	} 	 
}

public function publicDefenceAdminUpdate($r) { 
 
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple()) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `public_defence_admin` SET 
								`id_admin` = '".$r['id_admin']."',
								`place` = '".$r['place']."',
								`thesis_num` = '".$r['thesis_num']."' ,
								`money` = '".$r['money']."' ,
								`check` = '".$r['check']."' 							
								WHERE `public_defence_admin`.`id_user` = '".ConnectDB::isSession()."';");
			$query->execute();
			return true;
		}  catch(Exception $e) {
			print ('ERROR DB ADMIN UPDATE #  9055 '.$e->getMessage());
			exit;
		}
	} 	 
}

public function publicDefenceAdminSelect($id_user=null) {  
	
	if(self::isSessionAdminSudo() || self::isSessionAdminSimple() || ( !is_null(ConnectDB::isSession()) )) {
	try {
		$dbh = ConnectDB::DB(); 
		$query = $dbh->prepare("SELECT * FROM `public_defence_admin` 
								WHERE `public_defence_admin`.`id_user`='".($id_user == null ? ConnectDB::isSession() : $id_user )."'");
		$query->execute();
		if($query->rowCount() > 0 ) { 
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) {
		return false;
	}
	}
}

}
?>