<?php

class ConnectDB extends CreateGuid {

private $id;
private $info_total;
public $diploma_folder; //  
public $id_diploma; // 
public $id_year_academic;
private $dbh;
 
 
public  $status_default_value = array(
									'id_admin'           =>'362751b7-9af9-c218-c4c8-566fd860bb28',
									'user_request'       =>'0',
									'user_date_request'  =>'0000-00-00 00:00:00.000000',
									'admin_confirm'      =>'0',
									'admin_date_confirm' =>'0000-00-00 00:00:00.000000',
									'position'           =>'1',
									'position_phd'       =>'1'
									);
public $status_msg = '';				   
public $filling_table = array();	   
public $filling_data  = array();
public $array_mult    = array();

public static function staticFormatDate() {
	return date(FORMAT_DATE);
}

public static function staticFormatDateStandard() {
	return date('00-00-0000');
}

public static function DB() {
	
	echo null; // do not remove this null;
	try {
		 
		$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', ''.DB_USER.'', ''.DB_PWD.'', array(
		PDO::ATTR_PERSISTENT            => true,
		PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES utf8",
		PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION
		));
	} catch(Exception $e) {
		print ('ERROR DB PDO # 5000 '.$e->getMessage());
		exit;
	}	
	return $dbh;
}

public function getFillingData() {
	return $this->filling_data;
}

private function setFillingData($filling_data) {
	$this->filling_data = $filling_data;
}

public static function isArray($r) {
	if(!is_array($r)) return false;
}

public function getIDYearAcademic() {
	return $this->id_year_academic;
}

private function setIDYearAcademic($id_year_academic) {
	$this->id_year_academic = $id_year_academic;
}

public function getDiplomaFolder() {
	return $this->diploma_folder;
}

private function setDiplomaFolder($diploma_folder) {
	$this->diploma_folder = $diploma_folder;
}

public function getIDDiploma() {
	return $this->id_diploma;
}

private function setIDDiploma($id_diploma) {
	$this->id_diploma = $id_diploma;
}

public function itemDiscontinued($test=null) {
	try {   
		$dbh = ConnectDB::DB();
		$tableList = array();
		$result = $dbh->query("SHOW TABLES");
		while ($row = $result->fetch(PDO::FETCH_NUM)) {
			$col = ($this->countUpRecording($row[0]) > 0 ? 'green': 'red') ; 
			$tableList[] = $row[0].($test == 'COUNT' ? ' -> <span style="color:'.$col.';"><b>['.$this->countUpRecording($row[0]).']</b></span>' : '')  ;
		}
		return $tableList;
		}
	catch (PDOException $e) {
		print($e->getMessage());
	}
}

public function countUpRecording($name_table) {   
	try {   
		$dbh = ConnectDB::DB(); 
		$query = $dbh->prepare("SELECT * FROM `{$name_table}` WHERE id_user='".self::isSession()."'");
		$query->execute();
			if($query->rowCount() > 0) {
				return $query->rowCount();
			} else {
				return 0;
			}
	} catch (PDOException $e) {
		print("");
	}
}

public function deleteAllFiesOfUser() { }

public function insertMySpaceConnect($dbh, $r) {
	self::isArray($r);
	if(!$this->validMail($r['e-mail'])) return false; 
	try {
	if(ConnectDB::isSession()) {
		$this->updateMySpaceConnect($dbh, self::isSession(), $r);
		return; 
	}
		$main = new Main();
		$_SESSION['SST_GUID'] = $this->guid(); 
		$sth = $dbh->prepare("INSERT INTO registration() 
							VALUES('".self::isSession()."',
									'NULL',
									'".$r['phd']."',
									'".$r['last_name']."',
									'".$r['first_name']."',
									'".$r['e-mail']."',
									'".md5($r['pwd'])."',
									'".$r['institution']."',
									'".$r['sciences']."',
									'".$r['title']."',
									'".$r['mobile']."',
									'".$r['birth_place']."',
									'".$r['birth_date']."',
									'".$r['thesis']."',
									'0',
									'".$r['date_create']."', 
									'".$r['date_change']."')"
							);			
		$sth->execute();
		return self::isSession();
	} catch(Exception $e) {
		unset($_COOKIE[session_name()]); 
		session_destroy(); 
		print  ('ERROR BD INSERT # 5005 '.$e->getMessage()); 
		exit ;
	}
}

public function validMail($address) {  
   $test_mail='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
   if(preg_match($test_mail, $address))  
      return true;  
   else  
     return false;  
}

public function quoteIdent($str) {
	$dbh = ConnectDB::DB();
	return trim($dbh->quote($str), "\'");
 }
 
 
public function updateMySpaceConnect($dbh, $id, $r) {
	self::isArray($r);
	try {
		if(!$this->isID($id) && !self::isSession()) {
			throw new Exception();
		}
		$query = $dbh->prepare("UPDATE `registration` SET 
									`phd`        = '".$r['phd']."', 
									`last_name`  = '".$r['last_name']."', 
									`first_name` = '".$r['first_name']."', 
									`e-mail`     = '".$r['e-mail']."', 
									 ".($r['pwd'] == -1 ? ' ' : "`pwd`     = '".md5($r['pwd'])."',")."
									`sciences`   = '".$r['sciences']."',
									`title`      = '".$r['title']."',
									`institution`= '".$r['institution']."',
									`mobile`     = '".$r['mobile']."',
									`birth_place`= '".$this->quoteIdent($r['birth_place'])."',
									`birth_date` = '".$r['birth_date']."',
									`thesis`     = '".$r['thesis']."',
									`date_change`= '".$r['date_change']."'		
								WHERE `registration`.`id_user` = '".$id."';"); 
		$query->execute();

	} catch(Exception $e) { print ('ERROR DB UPDATE # 9001765 '.$e->getMessage()); return false; }
}

public function connexion($r) {
	 
	self::clearSessionGUID();
	self::isArray($r);
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `id_user`, `delete` 
								FROM `registration` 
								WHERE `e-mail` = '".$r['e-mail']."' 
								AND `pwd` = '".md5($r['pwd'])."';");
		$query->execute();
		if($query->rowCount() > 0 ) {
			$result = $query->fetch(PDO::FETCH_ASSOC);  
			if($result['delete'] == 1) {
				$this->writeLogFile(' [ PAGE IS: connexion ] ', $GLOBALS['sst']['log'][18]); 
				print ('ERROR DB SELECT # 6019 '); 
				return false;
			}
			if(!self::ispHdLocked($result['id_user'])) { return false; } 
			if(isset($GLOBALS['sst']['application_sst'][0])) {
				if(is_numeric($status = $GLOBALS['sst']['application_sst'][0] ) ) {
					if($status == 1) {
						$this->writeLogFile(' [ PAGE IS: connexion ] ', $GLOBALS['sst']['log'][19]); 
						print ('ERROR DB SELECT # 6020 '); return false;
					} 
				}
			}
			$main = new Main();
			if(!$main->isDirectoryExists('', FILE_LOG.$result['id_user'].'.log')) {
				print ('ERROR DB SELECT # 6021 '); return false;
			}

			print ('OK');
			$session = ($_SESSION['SST_GUID'] = $result['id_user']); 
			$this->writeLogFile(' [ PAGE IS: connexion ] ', $GLOBALS['sst']['log'][16]); 
			return $session; 
		} else {
			print ('ERROR DB SELECT # 6018 '); return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 6011 '.$e->getMessage()); return false; }
}

public function isEmailExists($r) {  
	self::isArray($r);
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `id_user` 
								FROM `registration` 
								WHERE `e-mail` = '".$r['e-mail']."';");
		$query->execute();
		if(isset($_SESSION['SST_GUID']) && ( !empty($_SESSION['SST_GUID']) )) { 
			return false;
		} else if($query->rowCount() > 0 ) {
			return  true; 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 946765 '.$e->getMessage()); return false; }
}

public static function clearSessionGUID() {  
	if(ConnectDB::isSession()){   
		$_SESSION['SST_GUID'] = array();
	} 
}
 // # 1 year, # 2 year, # 3 year
public function getSizeYearAcademic($folder) {
	if(ConnectDB::isSession()) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `diploma`
									LEFT JOIN `year_academic` ON `diploma`.`id_diploma`=`year_academic`.`id_diploma` 
									WHERE `diploma`.`dir` = '".$folder."' AND `diploma`.`id_user` = '".self::isSession()."';");
			$query->execute();
			if($query->rowCount() > 0 ) { 
				return $query->rowCount()+1;
			} else {
				return '1';
			}
		} catch(Exception $e) { print ('ERROR DB SELECT # 90045765 '.$e->getMessage()); return false; }
	}
}
 
 public function getStrSub($str) {
	if(strlen($str) > 40) {
		return substr($str, 0, 40).' ...'; 
	} else {
		return $str;
	}
 }
 
public function showRegistration() {
	if(ConnectDB::isSession() ) {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `registration` WHERE id_user='".self::isSession()."'");
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result; 
	}
}

public function registrationChangeVal($id_admin, $id_user, $test=0) {
	$dbh = ConnectDB::DB();
	$query = $dbh->prepare("UPDATE `registration` SET 
									`id_admin` = '{$id_admin}', 
									`delete`   = '{$test}', 
									`date_change`= '".self::staticFormatDate()."'		
							WHERE `registration`.`id_user` = '".$id_user."';");
	$query->execute();
}
 
public function checkRegistration($id_user) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `registration` WHERE `id_user`='{$id_user}'");
		$query->execute();
		if($query->rowCount() > 0 ) { 
			$result = $query->fetch(PDO::FETCH_ASSOC);
			return $result; 
		} else {
			return false;
		}
		 
	} catch(Exception $e) { print ('ERROR DB SELECT # 904565 '.$e->getMessage()); return false; }
}

public function idGenerator() {
	$letter = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','q','p','r','s','t','u','v','w','x','y','z');
	$microTime = microtime();	 
	list($a_dec,) = explode(" ", $microTime);
	$dec_hex = sprintf("%x", $a_dec * 1000000);
	return $dec_hex.'-'.$letter[mt_rand(0, 25)].mt_rand(0, 1000);
}

public function selectPhDSciences() {}

public function passwordGenerator() {
	$letter = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','q','p','r','s','t','u','v','w','x','y','z');
	$microTime = microtime();	 
	list($a_dec,) = explode(" ", $microTime);
	$dec_hex = sprintf("%x", $a_dec * 1000000);
	return $dec_hex.'-'.$letter[mt_rand(0, 25)];
}

public static function isSession() { 
	if (isset($_SESSION['GENERATED']) && (time() - $_SESSION['GENERATED'] > $GLOBALS['sst']['session_time'])) { // 1800
		//Last request was more than 30 minutes ago
		PageSST::exitPage();
	}
	$_SESSION['GENERATED'] = time(); //Update last activity time stamp

	if(isset($_SESSION['SST_GUID']) ) { 
		return $_SESSION['SST_GUID'];
	} else {
		return false;
	}
}

// type 3
public function deleteAllCol($r) {
	$dbh = ConnectDB::DB();
	$query = $dbh->prepare("DELETE FROM `".$r['table']."` WHERE `".$r['table']."`.`".$r['col']."` = '".$r['del']."'"); 
	$query->execute();
}

// type 2
public function changePWDInRegistration($r) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `registration` SET 
									`e-mail`= '".$r['e-mail']."', 
									`pwd`   = '".md5($r['pwd'])."'	
								WHERE `registration`.`e-mail` = '".$r['e-mail']."';"); 
		$query->execute();
		$r['table'] = 'pwd_forgot';
		$r['col']   = 'e-mail';
		$r['del']    = $r['e-mail'];
		$this->deleteAllCol($r);
	} catch(Exception $e) { print ('ERROR DB UPDATE # 9140155 '.$e->getMessage()); return false; }
}

// type 1 
public function seekPWDForgot($r) {
	if(!$this->validMail($r['e-mail'])) return false;
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * 
								FROM `pwd_forgot` 
								WHERE `e-mail` = '".$r['e-mail']."' AND `pwd` = '".$r['pwd']."';");
		$query->execute();
		if($query->rowCount() > 0 ) { 
			$this->changePWDInRegistration($query->fetch(PDO::FETCH_ASSOC));
			return true;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 91456476 '.$e->getMessage()); return false; }
}

// THIS MODIFY NULL sendMailToUserPWDForgot
public function insertInPwdForgot($r) {
	$main = new Main(); 
	if(!$this->validMail($r['e-mail'])) return false;
	$r['pwd'] = $this->passwordGenerator();
	$r['date'] = self::staticFormatDate() ;
	try {
		$dbh = ConnectDB::DB();
		$sth = $dbh->prepare("INSERT INTO `pwd_forgot` () 
							VALUES ('{$this->guid()}', 
									'".$r['e-mail']."', 
									'".$r['pwd']."', 
									'".$r['date']."', 
									'".($main->sendMailFromSST('PASSWORD_FORGOT', $r)  ? 1 : 0)."');");
		$sth->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 905055 '.$e->getMessage()); return false; }
}

public function showCountries() {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `langEN` FROM `countries` ORDER BY `countries`.`langEN` ASC");
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(Exception $e) { print ('ERROR DB SELECT # 1458801 '.$e->getMessage()); return false; }
}

public function sendDataAddress($arr_resid, $arr_cont) {
	if(ConnectDB::isSession()) { 
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `address_residence`, `contact_address` 
									WHERE  `contact_address`.`id_user`='".self::isSession()."' 
									and `address_residence`.`id_user`='".self::isSession()."'");
				$query->execute();					
				if($query->rowCount() > 0 ) { 
					$this->updateAddressResidence($arr_resid);
					$this->updateAddressContact($arr_cont);
				} else {
					$this->insertAddressResidence($arr_resid);
					$this->insertAddressContact($arr_cont);
				}
		} catch(Exception $e) { print ('ERROR DB SELECT # 90458501 '.$e->getMessage()); return false; }
	}
}

public function isIDUserExists() {
	if(!self::isSession()) { 
		self::destroy();
		return false; 
	}
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `registration` WHERE  `id_user`='".self::isSession()."'");
		$query->execute();	
		if($query->rowCount() > 0 ) { 
			return true;
		} else {
			self::destroy();
			return false;			
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 904566 '.$e->getMessage()); return false; }
}

private static function  destroy() {
	unset($_COOKIE[session_name()]); 
	setCookie(COOKIE_NUM_DIPLOMA, '', (time() - 3600), '/'); 
	session_destroy();
}

private function insertAddressContact($arr_cont) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$dbh = ConnectDB::DB();					
	$query = $dbh->prepare("INSERT INTO `contact_address` (`id_user`, `univ`, `street`, `box_num`, `postal_code`, `city`, `country`, `tel`, `date`) 
							VALUES (
							'".self::isSession()."', 
							'".$arr_cont['f2_univ']."', 
							'".$arr_cont['f2_street']."', 
							'".$arr_cont['f2_box_num']."', 
							'".$arr_cont['f2_postal_code']."', 
							'".$arr_cont['f2_city']."', 
							'".$arr_cont['f2_country']."',
							'".$arr_cont['f2_tel']."', 
							'".$arr_cont['date']."');");
	$query->execute();
}

private function insertAddressResidence($arr_resid) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$dbh = ConnectDB::DB();					
	$query = $dbh->prepare("INSERT INTO `address_residence` (`id_user`, `street`, `box_num`, `postal_code`, `city`, `country`, `tel`, `date`) 
							VALUES (
							'".self::isSession()."', 
							'".$arr_resid['f1_street']."', 
							'".$arr_resid['f1_box_num']."', 
							'".$arr_resid['f1_postal_code']."', 
							'".$arr_resid['f1_city']."', 
							'".$arr_resid['f1_country']."', 
							'".$arr_resid['f1_tel']."', 
							'".$arr_resid['date']."');");
	$query->execute();
}

public function updateAddressResidence($arr_resid) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$dbh = ConnectDB::DB();					
	$query = $dbh->prepare("UPDATE `address_residence` SET 
									`street`      = '".$arr_resid['f1_street']."', 
									`box_num`     = '".$arr_resid['f1_box_num']."', 
									`postal_code` = '".$arr_resid['f1_postal_code']."', 
									`city`        = '".$arr_resid['f1_city']."', 
									`country`     = '".$arr_resid['f1_country']."', 
									`tel`         = '".$arr_resid['f1_tel']."', 
									`date`        = '".$arr_resid['date']."'
									 WHERE `address_residence`.`id_user` = '".self::isSession()."';");
	$query->execute();	
}

public function updateAddressContact($arr_cont) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$dbh = ConnectDB::DB();					
	$query = $dbh->prepare("UPDATE `contact_address` SET 
									`univ`        = '".$arr_cont['f2_univ']."',
									`street`      = '".$arr_cont['f2_street']."', 
									`box_num`     = '".$arr_cont['f2_box_num']."', 
									`postal_code` = '".$arr_cont['f2_postal_code']."', 
									`city`        = '".$arr_cont['f2_city']."', 
									`country`     = '".$arr_cont['f2_country']."',
									`tel`         = '".$arr_cont['f2_tel']."', 
									`date`        = '".$arr_cont['date']."' 
									WHERE `contact_address`.`id_user` = '".self::isSession()."';");
	$query->execute();								
}

//---------- upload----
public function showAddressResidence($id_user=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * 
								FROM `address_residence` 
								WHERE `id_user` = '".((!is_null($id_user)) ? $id_user : self::isSession())."';");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 475501 '.$e->getMessage()); return false; }
}

public function showAddressContact($id_user=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * 
								FROM `contact_address` 
								WHERE `id_user` = '".((!is_null($id_user)) ? $id_user : self::isSession())."';");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 99838801 '.$e->getMessage()); return false; }
}

//default commit directories
public static function commitDirectories($n=0, $all=false) {

	$main = new Main();
	
	$r[0] = $main->isDirectoryExists(DIR_FOLDER_DIPLOMA_SIMPLE);
	$r[1] = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_RESULTS_SIMPLE);
	$r[2] = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_RESULTS_DOCTORAL_SIMPLE);
	$r[3] = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_RESULTS_SUPERVISORY_SIMPLE);
	$r[4] = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_PLANNING_SIMPLE);
	$r[5] = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_RESEARCH_SIMPLE);
	$r[6] = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_UCL_REG_SIMPLE);
	$r[7] = $main->isDirectoryExists(DIR_FOLDER_PUBLIC_DEFENCE_SUMMERY_SIMPLE);
	$r[8] = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE);
	$r[9] = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_OPENING_SIMPLE);
	$r[10] = $main->isDirectoryExists(DIR_FOLDER_PUBLIC_DEFENCE_PHOTO_SIMPLE);
	
	if(!is_numeric($n)) return false;
	
	return ( ($all) ? $r : $r[$n]); 
	 
}

public function createFolder($error=true, $folder = null) { 
  
	$folder = ( is_null($folder) ?  $this->guid() : $folder );
	
	$main = new Main();
	
	$i = 0; 
	do {
		$dir = self::commitDirectories($i ,false).$folder;
		if(!$error) {
			$this->unlinkDir($dir);
		} else {
			if(!mkdir($dir, 0777)) {
				return $this->createFolder(false, $folder);	
			}	
		}
		
		$i++;
		
	} while($i < count(self::commitDirectories(0, true)) );
	
	if(!$error) { return false; }

		$log = $main->isDirectoryExists(FILE_LOG); 
		 
		if($this->insertStatus($this->status_default_value)) {
			$this->status_msg =' [STATUS HAS BEEN CREATED] '; 
			$this->createLogFile($log.self::isSession().'.log');
		} else {
			$this->status_msg =' [STATUS ERROR FATAL] ';	
			$this->createLogFile($log.self::isSession().'.log');
		}
		
		return $this->insertFolderInDB($folder);
		
}

public function selectStatus($id_user=null, $pos=null) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `status` WHERE `id_user`='".($id_user != null ? $id_user : self::isSession())."'");
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	} catch(Exception $e) { print ('ERROR DB SELECT # 90588801 '.$e->getMessage()); return false; }
}

public function updateStatus($r=array()) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();	
		$query = $dbh->prepare("UPDATE `status` SET 
								`id_admin`           = '".$r['id_admin']."',
								`user_request`       = '".$r['user_request']."', 
								`user_date_request`  = '".$r['user_date_request']."', 
								`admin_confirm`      = '".$r['admin_confirm']."', 
								`admin_date_confirm` = '".$r['admin_date_confirm']."', 
								`position`           = '".$r['position']."',
								`position_phd`       = '".$r['position_phd']."',
								`date_time`          = '".date(DATETIME)."'								
								WHERE `status`.`id_user` = '".self::isSession()."'");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB UPDATE # 9988801 '.$e->getMessage()); return false; }
}
 
public function insertStatus($r=array(), $id_user = null ) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$id_user = ($id_user == null ? self::isSession() :  $id_user);
	try {
		$dbh = ConnectDB::DB();					
		$query = $dbh->prepare("INSERT INTO `status` (`id_status`, `id_user`, `id_admin`, `user_request`, `user_date_request`,
													`admin_confirm`, `admin_date_confirm`, `position`,  `position_phd`, `date_time`) 
							VALUES (
							'".$this->guid()."', 
							'".$id_user."', 
							'".$r['id_admin']."', 
							'".$r['user_request']."', 
							'".$r['user_date_request']."', 
							'".$r['admin_confirm']."', 
							'".$r['admin_date_confirm']."', 
							'".$r['position']."',
							'".$r['position_phd']."', '".date(DATETIME)."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 2017801 '.$e->getMessage()); return false; }
}

private function createLogFile($name) {
	file_put_contents($name, self::staticFormatDate().' ['.$GLOBALS['sst']['log'][0].'] '.$this->status_msg."\n");
}

public function writeLogFile($where=null, $str=null) {
	if(!self::isSession()) { return false; }
	$main = new Main();
	$file = $main->isDirectoryExists('', FILE_LOG.self::isSession().'.log');
	if(!empty($file) ) {
		file_put_contents($file, self::staticFormatDate().$where.' '.$str."\n", FILE_APPEND | LOCK_EX);	
	}
}

public function showLog() {
	if(!self::isSession()) { return false; }
		return file_get_contents(FILE_LOG.self::isSession().'.log', null, null); 
}

public function createFolderSimple($dir, $user_id=null, $name_folder=null) {

	$main = new Main();
	
	$folder = (
				$user_id != null ?
				$user_id :
				($name_folder != null ? $name_folder : $this->guid())
	);

	$dir = $main->isDirectoryExists($dir);
				
	if(is_dir($dir.$folder))  {
		return $folder;
	} 

	if(mkdir($dir.$folder, 0755)) {
		return $folder; 
	} else {  
		return 	false;
	}
}

public function isFolderNotExists($dir, $folder) {
	if(!file_exists($dir.$folder) ) {
		$this->createFolderSimple($dir, $folder, null);
	} 
}

// THIS MODIFY NULL 
private function insertFolderInDB($folder) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `dir` (`id_dir`, `id_user`, `dir`) VALUES ('{$this->guid()}', '".self::isSession()."', '".$folder."');");
		$query->execute();
		
	}catch(Exception $e) { print ('ERROR DB INSERT # 245801 '.$e->getMessage()); return false; }
}

// THIS MODIFY NULL 
public function insertDiploma($r) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `diploma` (
								`id_diploma`, 
								`id_user`,  
								`level_diploma`, 
								`official_title_diploma`, 
								`institution`, 
								`country`, 
								`awarding_date`, 
								`awarding_or_date`,
								`diploma_date`, 
								`diploma_or_date`, 
								`obtained_diploma`,
								`credits1`, 
								`credits2`, 
								`credits3`, 
								`dir`,
								`dir_year_academic`,
								`date_fixed`) 
							 VALUES ('{$this->guid()}', 
								'".self::isSession()."', 
								'".$r['level_diploma']."', 
								'".$r['official_title_diploma']."', 
								'".$r['institution']."', 
								'".$r['country']."', 
								'".$r['awarding_date']."', 
								'".$r['awarding_or_date']."', 
								'".$r['diploma_date']."', 
								'".$r['diploma_or_date']."', 
								'".$r['obtained_diploma']."', 
								'".$r['credits1']."',
								'".$r['credits2']."',
								'".$r['credits3']."',
								'".$r['dir']."',
								'".$r['dir_year_academic']."',
								'".Main::orderDateInDB()."');");												
		$query->execute();
		$this->setDiplomaFolder($r['dir']); // initial folder
	} catch(Exception $e) { print ('ERROR DB INSERT # 27788801 '.$e->getMessage()); return false; }
}	

public function createFolderInDiplomaAndInsertDB($r, $n = 0, $generator) {

	$main = new Main();
	
	$dir = $main->isDirectoryExists(DIR_FOLDER_DIPLOMA_SIMPLE); 
	if(!self::isSession()) {  self::destroy(); return false; }
	if($dip = $this->checkFolderInBD()) { 
		if($n == 0) {
			if(mkdir($dir.$dip['dir'].'/'.$generator, 0755)) { // create folder diploma
				$r['dir'] = $generator; 
				$r['dir_year_academic'] = 'empty';
				$this->insertDiploma($r);
				$this->createFolderInDiplomaAndInsertDB($r, 1, $generator);
			} else {  
				return 	false;
			}
		} if( $n == 1) {
			$dir_year = $this->idGenerator();
			if(mkdir($dir.$dip['dir'].'/'.$generator.'/'.$dir_year, 0755)) { // create folder year
					$r['dir_year_academic'] = $dir_year;
					$this->updateDiploma($r, $r['dir']);
			} else {  
				return 	false;
			}
		}
	} else {
		return false;
	}
}

// update diploma 
public function updateDiploma($r, $dir) {
	if(!self::isSession()) {  self::destroy(); return false; }
	if($this->checkDiploma($dir)) {
		$dbh = ConnectDB::DB();
		if(isset($r['dir_year_academic'])) 
			$dir_year_aca = ",`dir_year_academic` = '".$r['dir_year_academic']."'";
		else 
			$dir_year_aca = "";
			
		if($r['cred_opt'] != 0) {
			if(preg_match ("/^[1-3]+$/", $r['cred_opt']) ) {
				$found = true;
				$update_cred = ",`credits1` = '".$r['cred_opt'].','.$r['credits1']."', 
									`credits2` = '".$r['credits2']."', 
									`credits3` = '".$r['credits3']."'";
			} else {
				$update_cred = '';
			}
		} else {
			$update_cred = '';
		}
			
		$query = $dbh->prepare("UPDATE `diploma` SET 
								`level_diploma`          = '".$r['level_diploma']."',
								`official_title_diploma` = '".$r['official_title_diploma']."', 
								`institution`            = '".$r['institution']."', 
								`country`                = '".$r['country']."', 
								`awarding_date`          = '".$r['awarding_date']."', 
								`awarding_or_date`       = '".$r['awarding_or_date']."',
								`diploma_date`           = '".$r['diploma_date']."', 
								`diploma_or_date`        = '".$r['diploma_or_date']."', 
								`obtained_diploma`       = '".$r['obtained_diploma']."'".$update_cred."  
								".$dir_year_aca."								
								WHERE `diploma`.`id_user` = '".self::isSession()."' AND `diploma`.`dir`='".$dir."'");
		$query->execute();
	} else { }
}

private function checkDiploma($dir) { 
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `id_diploma`, `dir` FROM `diploma` WHERE `id_user`='".self::isSession()."' AND `dir`='".$dir."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			$this->setDiplomaFolder($dir); // initial folder
			$this->setIDDiploma($id = $query->fetchAll(PDO::FETCH_ASSOC));
			return true;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2743632 '.$e->getMessage()); return false; }
}

// submitted 
public function selectedDiploma($sel=0, $id_diploma=null) { 
	try {
		$dbh = ConnectDB::DB();
		$id = ($id_diploma == null ? '' : " AND `diploma`.`id_diploma` = '".$id_diploma."' "); 
		$query = $dbh->prepare("UPDATE `diploma` SET 
								`diploma_selected` = '{$sel}' 						
								WHERE `diploma`.`id_user` = '".self::isSession()."' {$id}");
		$query->execute();
		 
	} catch(Exception $e) { print ('ERROR DB SELECT # 275445 '.$e->getMessage());  }
}

// upload files 
public function getDataYearAcademic($id) {
	 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `year_academic` 
								LEFT JOIN `diploma` ON `year_academic`.`id_diploma`=`diploma`.`id_diploma` 
								WHERE `year_academic`.`id_year_academic`= '".$id."' 
								AND `year_academic`.`id_user`='".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2704001 '.$e->getMessage()); return false; }
}

public function getPathUpload($id, $file=null, $user) {
	if(!$this->isID($user))  return false ;
	$_SESSION['SST_GUID'] = $user;
	
	if($file == 'diploma') {
		$dir = $this->checkFolderInBD();
		if($this->checkDiploma($id)) {
			return $dir['dir'].'/'.$id.'/';
		}
	} 
	if($file == 'academic') {
	$dir = $this->checkFolderInBD();
		if(is_array($data = $this->getDataYearAcademic($id))) { 
			return $dir['dir'].'/'.$data['dir'].'/'.$data['dir_year_academic'].'/';
		}
	}
	return false;
}

// THIS MODIFY NULL 
public function insertUploadedYear($r) {
	if(!$this->isID($r['id_user']))  return false ;
	else $_SESSION['SST_GUID'] = $r['id_user'];
	if(!self::isSession()) { self::destroy(); return false; }
	if(!is_array($data = $this->getDataYearAcademic($r['iden']))) return false; 
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `upload_academic` (
											`id_upload_academic`, 
											`id_user`, 
											`id_diploma`,
											`id_year_academic`,
											`title`,
											`bytes`)
										VALUES ('{$this->guid()}',
											'".self::isSession()."',
											'".$data['id_diploma']."',
											'".$r['iden']."',
											'".$r['title']."',
											'".$r['byte']."');");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 27465564 '.$e->getMessage()); return false; }
}

 public function isID($id) {
	if(!empty($id)) {
		if ((preg_match('/^[0-9a-z-]+$/', $id)) ) { 
			if(strlen(trim($id)) == 36 ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else { return false; }
 }

// THIS MODIFY NULL 
public function insertUploadedDiploma($r) {
	if(!$this->isID($r['id_user']))  return false ;
	else $_SESSION['SST_GUID'] = $r['id_user'];
	if(!self::isSession()) { self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `upload_diploma` 
									(`id_upload_diploma`, `id_user`, `dir_dip`, `title`, `bytes`) 
								VALUES ('{$this->guid()}', '".self::isSession()."', '".$r['iden']."', '".$r['title']."', '".$r['byte']."');");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 270436564 '.$e->getMessage()); return false; }
}

public function showUploadedYear($id) {
	if(!self::isSession()) { self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `upload_academic` 
								WHERE `id_user`= '".self::isSession()."' AND `id_year_academic`= '".$id."';");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	}  catch(Exception $e) { print ('ERROR DB SELECT # 146353 '.$e->getMessage()); return false; }
}

public function showUploadedDiploma($dir_dip) {
	if(!self::isSession()) { self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `upload_diploma` 
								WHERE `id_user`= '".self::isSession()."' AND `dir_dip` = '".$dir_dip."';");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 245564 '.$e->getMessage()); return false; }
}

//---------- upload-----
public function checkFolderInBD($id_user=null) {
	if(!self::isSession()) { self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `dir` FROM `dir` WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user ) ."' ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2701264 '.$e->getMessage()); return false; }
}

public function getDiplomaByDir($dir) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `diploma` WHERE `id_user`='".self::isSession()."' AND `dir`='".$dir."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2712564 '.$e->getMessage()); return false; }
}

public function showDiploma($id_user=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `diploma` WHERE `id_user`='".((!is_null($id_user)) ? $id_user : self::isSession())."' ORDER BY `diploma`.`date_fixed` ASC");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2712564 '.$e->getMessage()); return false; }
}

// delete diploma and delete academic year
public function deleteDiploma($r) {

	$main = new Main();
	$dir = $r['val'];	
	 
	if($this->checkDiploma($dir) && ($dir_dip = $this->checkFolderInBD())) {   
		$path = $main->isDirectoryExists(DIR_FOLDER_DIPLOMA_SIMPLE.$dir_dip['dir'].'/'.$dir); 
		if($this->deleteFolderInDiploma($path)) {  
			$this->deleteLineDiploma($dir);
			$this->deleteUploadedDiplomaOrYear($dir, 'DIPLOMA'); 
			$arr = $this->getIDDiploma();
			
			$this->deleteDiplomaOrYear($arr['0']['id_diploma'], 'upload_academic', 'id_diploma');
			
			$this->deleteAcademicYear($arr['0']['id_diploma'], 'DIPLOMA');
			return true; // true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

// delete year
public function deleteYear($id_year) { 
	$main = new Main();
	
	$dir_dip = $this->checkFolderInBD();
	if($this->checkUploadAcademic($id_year)) {
		if(is_array($data = $this->getDataDipAndYear($id_year))) {
			foreach($data as $k => $v) {
			
				$path = DIR_FOLDER_DIPLOMA_SIMPLE.$dir_dip['dir'].'/'.$v['dir'].'/'.$v['dir_year_academic'].'/'.$v['title'];
				if($path = $main->isDirectoryExists('', $path)) {
					$this->deleteFilePath($path);				
					$this->deleteAcademicYear($id_year, 'YEAR');
					$this->deleteUploadedDiplomaOrYear($id_year, 'YEAR');
				}
			}
		return true;
		}
	} else {
		$this->deleteAcademicYear($id_year, 'YEAR');
		return true;
	}
}

public function checkUploadAcademic($id_year) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `upload_academic` WHERE `id_year_academic`='".$id_year."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return true; 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 2780564 '.$e->getMessage()); return false; }
}

private function getDataDipAndYear($id_year) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `upload_academic` 
								LEFT JOIN `diploma` 
								ON `diploma`.`id_diploma` = `upload_academic`.`id_diploma` 
								WHERE `upload_academic`.`id_year_academic` ='".$id_year."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
		 
	} catch(Exception $e) { print ('ERROR DB SELECT # 27864 '.$e->getMessage()); return false; }
}

private function deleteAcademicYear($id, $test=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	if($test == 'YEAR') 
		$test = "`year_academic`.`id_year_academic` = '".$id."'";
	 else 
		$test = "`year_academic`.`id_diploma` = '".$id."'";
		
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `year_academic` WHERE ".$test." AND `year_academic`.`id_user`='".self::isSession()."'");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB DELETE # 25018165 '.$e->getMessage()); return false; }
} 
 
private function deleteUploadedDiplomaOrYear($id, $test=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
	if($test == 'YEAR')
		$query = $dbh->prepare("DELETE FROM `upload_academic` 
								WHERE `upload_academic`.`id_year_academic` = '".$id."' 
								AND `upload_academic`.`id_user`='".self::isSession()."'");
	else if($test == 'DIPLOMA') 
		$query = $dbh->prepare("DELETE FROM `upload_diploma` 
								WHERE `upload_diploma`.`dir_dip` = '".$id."' 
								AND `upload_diploma`.`id_user`='".self::isSession()."'");
	else
		return false;
		
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB DELETE # 25250165 '.$e->getMessage()); return false; }
}

// delete all folders and files
public function deleteFolderInDiploma($directory, $empty = false) {
	if(substr($directory,-1) == '/') {
        $directory = substr($directory,0,-1);
    }

    if(!file_exists($directory) || !is_dir($directory)) {
        return false;
    } elseif(!is_readable($directory)) {
        return false;
    } else {
        $directory_handle = opendir($directory);
        while ($contents = readdir($directory_handle)) {
            if($contents != '.' && $contents != '..') {
                $path = $directory . '/' . $contents;
                if(is_dir($path)) {
                    $this->deleteFolderInDiploma($path);
                } else {
                    @unlink($path);
                }
            }
        }
        closedir($directory_handle);
        if($empty == false) {
            if(!rmdir($directory)) {
                return false;
            }
        }
        return true;
    } 
}

public function getFileNameInDB($id, $test) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		if( $test == 'diploma') {
			$query = $dbh->prepare("SELECT * FROM `upload_diploma` 
									WHERE `id_upload_diploma`='".$id."' 
									AND `id_user`= '".self::isSession()."'");
		} else if($test == 'year'){
			$query = $dbh->prepare("SELECT * FROM `upload_academic` 
									WHERE `id_upload_academic`='".$id."'  
									AND `id_user`= '".self::isSession()."'");
		} else { 
			return false; 
		}
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 0120165 '.$e->getMessage()); return false; }
}

public function cleanCarSpec($chaine) {
	$chaine = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $chaine);
	$chaine = preg_replace('#[^0-9a-z/./-]+#i', '-', $chaine);
	while(strpos($chaine, '--') !== false) {
		$chaine = str_replace('--', '-', $chaine);
	}
	$chaine = trim($chaine, '-');  
	return $chaine;
}

// this method mast be deleted 
public function deleteDiplomaOrYear($id, $tab=null, $id_tab=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `{$tab}` WHERE `{$id_tab}` = '".$id."' AND `id_user`='".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB DELETE # 0127865 '.$e->getMessage()); return false; }
}

public function deleteFileYear($id, $id_diploma) {
	$main = new Main(); 
	if(!self::isSession()) {  self::destroy(); return false; }
	$r = $this->getDataDiploma($id_diploma);
	$dir_dip = $this->checkFolderInBD();
	 
	if(!is_array($file_name = $this->getFileNameInDB($id, 'year'))) return false;  
		$path =  DIR_FOLDER_DIPLOMA_SIMPLE.$dir_dip['dir'].'/'.$r['dir'].'/'.$r['dir_year_academic'].'/'.$file_name['title'];
	if($path = $main->isDirectoryExists('', $path)) { 
		$this->deleteFilePath($path);
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE FROM `upload_academic` 
									WHERE `upload_academic`.`id_upload_academic` = '".$id."'
									AND `upload_academic`.`id_diploma` ='".$id_diploma."'");
			$query->execute();
			return true;
		} catch(Exception $e) { print ('ERROR DB DELETE # 001125 '.$e->getMessage()); return false; }
	} else {
		return false;
	} 
}

public function getDataDiploma($id_diploma) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `diploma` WHERE `id_diploma`='".$id_diploma."' AND `id_user`= '".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 40011125 '.$e->getMessage()); return false; }
}

public function getDataYear($id_year) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `year_academic` WHERE `id_year_academic`= '".$id_year."' AND `id_user`= '".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 40556045 '.$e->getMessage()); return false; }
}

public function deleteFileDiploma($id, $fol) {
	$main = new Main();
	
	if(!self::isSession()) {  self::destroy(); return false; }
	if(!is_array($file_name = $this->getFileNameInDB($id, 'diploma'))) return false;
	
	$dir = $this->checkFolderInBD();
	
	$path = DIR_FOLDER_DIPLOMA_SIMPLE.$dir['dir'].'/'.$fol.'/'.$file_name['title'];
	
	if($path = $main->isDirectoryExists('', $path) ) {
		$this->deleteFilePath($path);
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE FROM `upload_diploma`
									WHERE `upload_diploma`.`id_upload_diploma` = '".$id."' 
									AND `upload_diploma`.`dir_dip` ='".$fol."'");
			$query->execute();
			return true;
		} catch(Exception $e) { print ('ERROR DB DELETE # 455601045 '.$e->getMessage()); return false; }
	} else {
		return false;
	} 
}

public function deleteFilePath($name_file) {
	@unlink($name_file);
}

private function deleteLineDiploma($dir) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `diploma` 
								WHERE `diploma`.`id_user` = '".self::isSession()."' 
								AND `diploma`.`dir` ='".$dir."' ");
		$query->execute();
		
	} catch(Exception $e) { print ('ERROR DB DELETE # 4556045 '.$e->getMessage()); return false; }
}

public function saveError($err_msg) {
	if(LOG_ERRORS == true) error_log($err_msg."\n", 3, LOG_ERRORS_FILE);
}

public function encodeToUtf8($string) {
     return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}

public function filter($str) {
	$str = str_replace("\/","", $str);
	$str = str_replace("/", "", $str);
	$str = str_replace("<", "", $str);
	$str = str_replace(">", "", $str);
	$str = str_replace("{", "", $str);
	$str = str_replace("}", "", $str);
	$str = str_replace("*", "", $str);
	$str = str_replace("%", "", $str);
	$str = str_replace("?", "", $str);
	$str = str_replace(";", "", $str);
	return $str;
}

public function filterStr($str) { 
	$str = str_replace("<", "", $str);
	$str = str_replace(">", "", $str);
	$str = str_replace("{", "", $str);
	$str = str_replace("}", "", $str);
	$str = str_replace("*", "", $str);
	$str = str_replace("%", "", $str);
	$str = str_replace("?", "", $str);
	$str = str_replace(";", "", $str);
	return $str;
}

public function filterMinimum($str) { 
	$str = str_replace("<", "", $str);
	$str = str_replace(">", "", $str);
	$str = str_replace("{", "", $str);
	$str = str_replace("}", "", $str);
	$str = str_replace("*", "", $str);
	$str = str_replace("%", "", $str);
	$str = str_replace(";", "", $str);
	return $str;
}

public function filterSimple($str) {
	$str = str_replace("*", "", $str);
	$str = str_replace("%", "", $str);
	$str = str_replace("</", "", $str);
	return $str;
}

public function yearAcademic($r) {
	if($this->checkDiploma($r['dir_dip'])) {
		$res = $this->getIDDiploma();
		$r['id_diploma'] =  $res[0]['id_diploma'];
		if($r['r_id'] == 'null') {    
			$this->insertYearAcademicInDB($r);
			$r['r_id'] = $this->getIDYearAcademic()	;	
			 
		} else {
			$this->updateYearAcademicInDB($r);
		}
		return true;
	} else {
		print ('ERROR BD # 6093456');
		return false;
	}
}

private function updateYearAcademicInDB($r) {
	if(!self::isSession()) {  self::destroy(); return false; }
	$dbh = ConnectDB::DB();					
	$query = $dbh->prepare("UPDATE `year_academic` SET 
									`title_and_year`   = '".$r['title_and_year']."',
									`awarding_date`    = '".$r['awarding_date']."',
									`awarding_or_date` = '".$r['awarding_date']."',
									`diploma_date`     = '".$r['diploma_date']."',
									`diploma_or_date`  = '".$r['diploma_or_date']."',
									`degree_level`     = '".$r['degree_level']."',
									`score_min` = '".$r['score_min']."',
									`score_max` = '".$r['score_max']."',
									`obtained_year`    = '".$r['obtained_year']."',
									`institution`      = '".$r['institution']."'
									WHERE `id_year_academic` = '".$r['r_id']."' 
									AND `id_diploma`= '".$r['id_diploma']."' AND `id_user`='".self::isSession()."';");
	$query->execute();	
}

private function insertYearAcademicInDB($r) { 
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$guid = $this->guid();
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `year_academic` 
									(`id_year_academic`,
									 `id_user`, 
									 `id_diploma`,
									 `title_and_year`, 
									 `awarding_date`, 
									 `awarding_or_date`, 
									 `diploma_date`,
									 `diploma_or_date`,
									 `degree_level`, 
									 `score_min`, 
									 `score_max`,
									 `obtained_year`,
									 `institution`,
									 `date_fixed`) 
								VALUES ('".$guid."',
										'".self::isSession()."',
										'".$r['id_diploma']."', 
										'".$r['title_and_year']."',
										'".$r['awarding_date']."',
										'".$r['awarding_or_date']."', 
										'".$r['diploma_date']."',
										'".$r['diploma_or_date']."',
										'".$r['degree_level']."',
										'".$r['score_min']."', 
										'".$r['score_max']."', 
										'".$r['obtained_year']."', 
										'".$r['institution']."',
										'".Main::orderDateInDB()."');");						 						
		$query->execute();
		$this->setIDYearAcademic($guid);
	} catch(Exception $e) { print ('ERROR DB INSERT # 4560457655 '.$e->getMessage()); return false; }
}

public function showYearAcademic($id_diploma, $id_user=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `year_academic` 
								WHERE `id_user`='".(is_null($id_user) ? self::isSession() : $id_user )."' 
								AND `id_diploma`='".$id_diploma."' 
								ORDER BY `year_academic`.`date_fixed` ASC; ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 40100425 '.$e->getMessage()); return false; }
}

public function admissionHome($r) {
	if($data = $this->admissionHomeCheck()) {
		return $this->_admissionHomeUpdate($r, $data);
	} else {
		return $this->_admissionHomeInsert($r);
	}
} 

public function admissionHomeCheck ( $id_user=null) {
	if(!self::isSession()) { return false; }
	try {
	$dbh = ConnectDB::DB();
	if($id_user == null) {
		$query = $dbh->prepare("SELECT * FROM `adm_home` WHERE `id_user` = '".self::isSession()."' ");
	} else {
		$query = $dbh->prepare("SELECT * FROM `adm_home` WHERE `id_user` = '".$id_user."' ");
	}
		 
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 456500425 '.$e->getMessage()); return false; }
}

public function admissionHomeUpdateState($state=0, $r=null) {
	if(!self::isSession()) { return false; }
	$admin = new AdminAuthority( ); 
	$main = new Main(); 
	if($main->authenticity()) {
		$id = "`id_admin` = '".$admin->getSessionAdmin()."',";
	} else {
		$id = '';
	}
	try {
		$pr_sql = ( isset($r['date_preadmission'])  ? ", `date_preadmission` = '{$r['date_preadmission']}'" : ''  );  
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_home` SET 
								`state` = '".$state."',
								{$id}
								`date`  = '".($r == null ? self::staticFormatDate() : $r['date'])."'   {$pr_sql}
								WHERE `adm_home`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4565457235 '.$e->getMessage()); return false; }
}

private function _admissionHomeUpdate($r, $data=null) {
	if(!self::isSession()) { return false; }
	
	 
	 
	$pr_sql = ( isset($r['date_preadmission'])  ? ", `date_preadmission` = '{$r['date_preadmission']}'" : ''  ); 
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_home` SET 
								`employment` = '".$r['val_radio']."',
								`text`       = '".$r['val_area']."',
								`state`      = '".$data['state']."',
								`date`       = '".$r['date']."'  {$pr_sql}
								WHERE `adm_home`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4565004235 '.$e->getMessage()); return false; }
}

private function _admissionHomeInsert($r) {
	if(!self::isSession()) { return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `adm_home` (`id_adm_home`,
														`id_user`,
														`employment`,
														`text`,
														`date`,
														`date_preadmission`) 
								VALUES ('{$this->guid()}', 
										'".self::isSession()."', 
										'".$r['val_radio']."', 
										'".$r['val_area']."', 
										'".$r['date']."',
										'NULL');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 44576796 '.$e->getMessage()); return false; }
}

public function admissionResearchProject($r)  {
	if($this->admissionResearchProjectCheck()) {
		return $this->_admissionResearchProjectUpdate($r);
	} else {
		return $this->_admissionResearchProjectInsert($r);
	}
}

public function admissionResearchProjectCheck($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
	$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `adm_research` WHERE `id_user` = '".(is_null($id_user) ? self::isSession() : $id_user)."' ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 456576 '.$e->getMessage()); return false; }
}

private function _admissionResearchProjectInsert($r) {
	$main = new Main(); 
	
	$path = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_RESEARCH_SIMPLE) ; 
	
	if(!self::isSession()) { return false; } //  
	$folder = $this->createFolderAdmission($path);
	if($folder) {
		try{
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("INSERT INTO `adm_research` (`id_adm_research`, `id_user`, `text`, `folder`, `date`)
									VALUES ('{$this->guid()}', 
											'".self::isSession()."', 
											'".$r['val_txt']."', 
											'".$folder."', 
											'".$r['date']."');");
			$query->execute();
		} catch(Exception $e) {
			if (is_dir($path.$folder)) { mkdir($path.$folder); } 
			return false;
		}
	} else {
		return false;
	} 
}
private function _admissionResearchProjectUpdate($r) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_research` SET 
										`text` = '".$r['val_txt']."', 
										`date` = '".$r['date']."' 
										WHERE `adm_research`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 476475885 '.$e->getMessage()); return false; }
}

public function createFolderAdmission($dir) {
	$folder = $this->guid(); 
	 if(mkdir($dir.$folder, 0755)) {   //  notation octale : valeur du mode correcte
		return $folder;
	} else {  
		return 	false;
	}
}

public function disconnectDB() { 
	try {
		return $this->dbh = null;
	} catch (Exception $e) {
		$this->saveError($e->getMessage());
	}
}

public function __destruct() {
    $this->disconnectDB();
}

public function showAllImgPath($dir, $folder, $test=null) {  
	if(is_dir($path = $dir.$folder)) {  
		$arr_files = array();
		$i = 0;
		foreach (new DirectoryIterator($path) as $k) {
			if($k->isDot()) continue;
			$arr_files[$i] =  $path.'/'.$k->getFilename();
			$i++;
		}
		return $arr_files;
	} else {
		return false;
	}
}

public function myAnnualReports($r, $count=0) {
	$main = new Main(); 
	
	if(is_array($r) && (sizeof($r) > 0)) {
		if(is_array($this->myAnnualReportsSelect($r[$count][0]))) {
			$this->myAnnualReportsUpdate($r[$count]);
			array_shift($r);
			$this->myAnnualReports($r, $count++);			
		} else {
			$data['reports'] = $r[$count][1];

			$path = $main->isDirectoryExists(DIR_FOLDER_MY_ANNUAL_REPORTS); 
			 
			$data['dir'] = (($folder = $this->createFolderSimple($path)) ? $folder : '000000000000000000000000000000000000');
			$this->myAnnualReportsInsert($data);
			array_shift($r);
			$this->myAnnualReports($r, $count++);	
		}
	}
}


 
public function myAdditionalProgramme($r, $count=0) {
	$main = new Main(); 
	
	if(is_array($r) && (sizeof($r) > 0)) {
		if(is_array($this->myAdditionalProgrammeSelect($r[$count][0]))) {
			$this->myAdditionalProgrammeUpdate($r[$count]);
			array_shift($r);
			$this->myAdditionalProgramme($r, $count++);			
		} else {
			$data['course_code'] = $r[$count][1];
			$data['name_course'] = $r[$count][2];
			$data['ects'] = $r[$count][3];
			
			$path = $main->isDirectoryExists(DIR_FOLDER_MY_ADDITIONAL_PROGRAMME_SIMPLE); 
			 
			
			$data['dir'] = (($folder = $this->createFolderSimple($path)) ? $folder : '000000000000000000000000000000000000');
			$this->myAdditionalProgrammeInsert($data);
			array_shift($r);
			$this->myAdditionalProgramme($r, $count++);	
		}
	}
}

public function admissionAdditionalProgramme($r) {
	$this->_admissionAdditionalProgrammeDelete();
	if(is_array($r)) {
		$j = 0;
		while($j < count($r)) {
			$this->_admissionAdditionalProgrammeInsert($r[$j][0], $r[$j][1], $r[$j][2]);
			$j++;	
		}	
	}
}
 
private function _admissionAdditionalProgrammeDelete() {
	if(!self::isSession()) { return false; }
	$dbh = ConnectDB::DB();
	$query = $dbh->prepare("DELETE FROM `adm_additional` WHERE `adm_additional`.`id_user` = '".self::isSession()."'");
	$query->execute();
}
 
public function admissionAdditionalProgrammeDeleteLine($id) { 
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `adm_additional` 
								WHERE `adm_additional`.`id_adm_additional`='{$id}' 
								AND `adm_additional`.`id_user` = '".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB DELETE # 4654475 '.$e->getMessage()); return false; }
}

private function _admissionAdditionalProgrammeInsert($course_code, $name_course, $ects) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `adm_additional` (`id_adm_additional`, `id_user`, `course_code`, `name_course`, `ects`, `date`, `date_fixed`) 
								VALUES ('{$this->guid()}', 
										'".self::isSession()."', 
										'".$course_code."', 
										'".$name_course."', 
										'".$ects."', 
										'".self::staticFormatDate()."', '".Main::orderDateInDB()."');");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 7775847 '.$e->getMessage()); return false; }	
}

private function _admissionAdditionalProgrammeUpdate($r) { }

public function myAnnualReportsUpdate($r, $date=null) {
	if(!self::isSession()) { return false; }
									 
		$sql = (!is_null($date) ?  "`reports_date` = '".self::staticFormatDate()."',"  : ''); 
		
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `my_annual_reports` SET 
								`reports`      = '".$r[1]."', 
								{$sql} 
								`date`         = '".self::staticFormatDate()."'
								WHERE `my_annual_reports`.`id_my_annual_reports`='".$r[0]."' 
								AND `my_annual_reports`.`id_user`='".self::isSession()."'");
			$query->execute();

			return true;
		} catch(Exception $e) { print ('ERROR DB UPDATE # 4477878665 '.$e->getMessage()); return false; }
} 

public function myAnnualReportsInsert($r) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `my_annual_reports` ()
								VALUES ('{$this->guid()}',
										'".self::isSession()."',
										'".$r['reports']."',
										'".$r['dir']."',
										'".FORMAT_DATE_DEFAULT."',
										'".self::staticFormatDate()."');");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 4578644 '.$e->getMessage()); return false; }
} 

public function myAnnualReportsSelect($id_my_annual_reports=null, $id_user=null, $dir=null) { //my_annual_reports
	if(!self::isSession()) { return false; }
	try {
		
		$sql_d = ''; $sql_a = ''; 
		
		if(!is_null($dir)) {
			$sql_d = " AND `dir` = '{$dir}'";
		}
		
		if(!is_null($id_my_annual_reports)) {
			$sql_a = " AND `id_my_annual_reports` = '{$id_my_annual_reports}'";
		}
					
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `my_annual_reports` 
								WHERE `id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."' {$sql_d} {$sql_a} 
								ORDER BY `my_annual_reports`.`date` ASC");
		$query->execute();
		
		if($query->rowCount() > 0 ) {    
			return (is_null($id_my_annual_reports) ? $query->fetchAll(PDO::FETCH_ASSOC)  : $query->fetch(PDO::FETCH_ASSOC)); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 745745756 '.$e->getMessage()); return false; }
}

public function myAnnualReportsDelete($id, $directory, $main=null) {

	if( !is_null($main) ) {
		
		$this->deleteFolderInDiploma($main->isDirectoryExists($directory));
		
	} else {
	
		$this->deleteFolderInDiploma($directory);
		
	}

	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `my_annual_reports` 
								WHERE `my_annual_reports`.`id_my_annual_reports`='{$id}' 
								AND `my_annual_reports`.`id_user` = '".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB # DELETE 478456688 '.$e->getMessage()); return false; }
}

public function myAdditionalProgrammeSelect($id_my_additional_programme=null, $id_user=null) { 
	if(!self::isSession()) { return false; }
	try {
		$sql = ($id_my_additional_programme == null ? '' : " AND `id_my_additional_programme` = '{$id_my_additional_programme}'");
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `my_additional_programme` 
								WHERE `id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."' {$sql} 
								ORDER BY `my_additional_programme`.`date` ASC");
		$query->execute();
		if($query->rowCount() > 0 ) {   
			return ($id_my_additional_programme == null ? $query->fetchAll(PDO::FETCH_ASSOC)  : $query->fetch(PDO::FETCH_ASSOC)); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 745774456 '.$e->getMessage()); return false; }
}
 
public function myAdditionalProgrammeInsert($r) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `my_additional_programme` () 
								VALUES ('{$this->guid()}', 
										'".self::isSession()."', 
										'".$r['course_code']."', 
										'".$r['name_course']."', 
										'".$r['ects']."', 
										'".$r['dir']."',
										'".self::staticFormatDate()."');");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB INSERT # 4578885 '.$e->getMessage()); return false; }
}  
 
public function myAdditionalProgrammeUpdate($r) {
	if(!self::isSession()) { return false; }
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `my_additional_programme` SET 
								`course_code` = '".$r[1]."', 
								`name_course` = '".$r[2]."', 
								`ects`        = '".$r[3]."'
								WHERE `my_additional_programme`.`id_my_additional_programme`='".$r[0]."' 
								AND `my_additional_programme`.`id_user`='".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4477878887 '.$e->getMessage()); return false; }
} 

public function myAdditionalProgrammeDelete($id, $directory, $main=null) {


	if( !is_null($main) ) {
		
		$this->deleteFolderInDiploma($main->isDirectoryExists($directory));
		
	} else {
		$this->deleteFolderInDiploma($directory);
	}
	
	 
	
	
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `my_additional_programme` 
								WHERE `my_additional_programme`.`id_my_additional_programme`='{$id}' 
								AND `my_additional_programme`.`id_user` = '".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB # DELETE 478587845 '.$e->getMessage()); return false; }
} 
 
public function admissionAdditionalProgrammeSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `adm_additional` WHERE `id_user`='".(is_null($id_user) ? self::isSession() : $id_user ) ."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 74785745 '.$e->getMessage()); return false; }
}

public function privateJuryMembersUpdate($r) {
	if(!self::isSession()) { return false; }
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `private_jury_members` SET 
								`id_adm_supervisory_panel`   = '".$r['id_adm_supervisory_panel']."', 
								`titel`       = '".$r['titel']."', 
								`lastname`    = '".$r['lastname']."', 
								`firstname`   = '".$r['firstname']."', 
								`institution` = '".$r['institution']."', 
								`email`       = '".$r['email']."', 
								`employment`  = '".$r['employment']."', 
								`members`     = '".$r['members']."', 
								`dir`     = '".$r['dir']."', 
								`date`        = '".self::staticFormatDate()."' 
								WHERE `private_jury_members`.`id_private_jury_members`='".$r['id']."' 
								AND `private_jury_members`.`id_user`='".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB # UPDATE 4546545 '.$e->getMessage()); return false; }
}

public function privateJuryMembersDelete($r=array(), $test=null) { 
	if( $test == null ) {
		$sql = "DELETE FROM `private_jury_members` 
				WHERE `private_jury_members`.`id_adm_supervisory_panel`='{$r['id_adm_supervisory_panel']}' 
				AND  `private_jury_members`.`id_user` = '".self::isSession()."'";
	} else {
		$sql = "DELETE FROM `private_jury_members` 
				WHERE `private_jury_members`.`id_private_jury_members`='{$r['id_private_jury_members']}' 
				AND  `private_jury_members`.`id_user` = '".self::isSession()."'";
	}
	if(!self::isSession()) { return false; }
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare($sql);
			$query->execute();
			 
			return true;
	} catch(Exception $e) { print ('ERROR DB # DELETE 55745674456 '.$e->getMessage()); return false; }
}

public function privateJuryMembersInsertAndCreateFolder($r, $path) {
	if(! $folder = $this->createFolderSimple($path)) {  return false; }
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB(); 
		$query = $dbh->prepare("INSERT INTO `private_jury_members` (`id_private_jury_members`, 
		`id_adm_supervisory_panel`, `id_user`, `titel`, `lastname`, `firstname`, 
		`institution`, `email`, `employment`, `members`, `state`, `sent`, `sent_date`, `dir`, `date`) VALUES 
										('{$this->guid()}', 
										'0', 
										'".self::isSession()."',
										'".$r['titel']."', 
										'".$r['lastname']."',
										'".$r['firstname']."',
										'".$r['institution']."', 
										'".$r['email']."',
										'".$r['employment']."',
										'".$r['members']."',
										'0',
										'0',
										'".self::staticFormatDate()."',
										'".$folder."',
										'".self::staticFormatDate()."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB # INSERT 475676545 '.$e->getMessage()); return false; }
}
 
public function privateJuryMembersInsert($r) { 

	$main = new Main();
	
	if(!self::isSession()) { return false; }
	try {  
		
		if($main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_SIMPLE.$r['dir'])) {
			$dbh = ConnectDB::DB(); 
			$query = $dbh->prepare("INSERT INTO `private_jury_members` (
										`id_private_jury_members`, 
										`id_adm_supervisory_panel`,
										`id_user`,
										`titel`,
										`lastname`,
										`firstname`, 
										`institution`,
										`email`,
										`employment`,
										`members`,
										`state`,
										`sent`,
										`sent_date`,
										`dir`,
										`date`) 
									VALUES 
										('{$this->guid()}', 
										'".$r['id_adm_supervisory_panel']."', 
										'".self::isSession()."',
										'".$r['titel']."', 
										'".$r['lastname']."',
										'".$r['firstname']."',
										'".$r['institution']."', 
										'".$r['email']."',
										'".$r['employment']."',
										'".$r['members']."',
										'".$r['state']."',
										'".$r['sent']."',
										'".$r['sent_date']."',
										'".$r['dir']."',
										'".$r['date']."');");
			$query->execute();			
			return true;
		} else { return false; } 
	} catch(Exception $e) { print ('ERROR BD INSERT # 775775785 '.$e->getMessage()); return false; }
}
 
public function privateJuryMembersSelect($id_private=null, $id_user=null) {
	 
	try {
		$dbh = ConnectDB::DB();
		if($id_private == null || $id_user != null) {
			$sql = "SELECT * FROM `private_jury_members` 
							WHERE `id_user`= '".($id_user != null ? $id_user : self::isSession())."' 
							ORDER BY `lastname` ASC";
		} else {
			$sql = "SELECT * FROM `private_jury_members` 
							WHERE `private_jury_members`.`id_private_jury_members`='{$id_private}' 
							AND `id_user`= '".self::isSession()."'";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		 
		if($query->rowCount() > 0 ) {
 
			return (($id_private == null || $id_user != null) ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC) ); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR BD SELECT # 654645 '.$e->getMessage()); return false; }
}

public function copyFile($source, $dest, $permissions=0755) {
    if (is_link($source)) { return symlink(readlink($source), $dest); }
    if (is_file($source)) { return copy($source, $dest); }
    if (!is_dir($dest)) { mkdir($dest, $permissions); }
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        if ($entry == '.' || $entry == '..') {
            continue;
        }
        $this->copyFile("$source/$entry", "$dest/$entry");
    }
    $dir->close();
    return true;
}

public function admissionSupervisoryPanelInsert($r, $path) {
	if(!self::isSession()) { return false; }
	
	if(! $folder = $this->createFolderSimple($path)) {  return false; }
 	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `adm_supervisory_panel` (
									`id_adm_supervisory_panel`,
									`id_user`,
									`titel`,
									`lastname`,
									`firstname`,
									`institution`,
									`email`,
									`employment`,
									`dir`,
									`date`) 
								VALUES ('{$this->guid()}', 
										'".self::isSession()."',
										'".$r['titel']."', 
										'".$r['lastname']."',
										'".$r['firstname']."',
										'".$r['institution']."', 
										'".$r['email']."',
										'".$r['employment']."',
										'".$folder."',
										'".$r['date']."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB INSERT # 4670102901'.$e->getMessage()); return false; }
}

public function privateSupervisoryPanelSelectNotSession($id_user, $id, $dir=null) {  

	$s = (is_null($dir) ? "`id_my_supervisory_panel`='{$id}'" : "`dir`='{$dir}'" ); 
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `my_supervisory_panel` WHERE `id_user`= '{$id_user}' AND {$s}"; 
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 4567786'.$e->getMessage()); return false; }
}
 
public function privateSupervisoryPanelUpdateNotSession($r) {
	
	$state = (isset($r['state']) ? $r['state'] : 1);
	$sent = (isset($r['sent']) ? $r['sent'] : 1);
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `my_supervisory_panel` SET 
								`state`       = '{$state}',  
								`sent`        = '{$sent}', 
								`sent_date`   = '".self::staticFormatDate()."',  
								`date`        = '".self::staticFormatDate()."' 
								WHERE `my_supervisory_panel`.`id_my_supervisory_panel`='".$r['id']."' 
								AND `my_supervisory_panel`.`id_user`='".$r['id_user']."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB UPDATE # 46786901'.$e->getMessage()); return false; }
}

public function admissionSupervisoryPanelSelectNotSession($id_user, $id, $dir=null) {  
	
	$s = (is_null($dir) ? "`id_adm_supervisory_panel`='{$id}'" : "`dir`='{$dir}'" ); 
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `adm_supervisory_panel` WHERE `id_user`= '{$id_user}' AND {$s}"; 
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB UPDATE # 467869 '.$e->getMessage()); return false; }
}

public function getContentSignatures($type, $section) {
	switch($section) {
		case 'ADMISSION': 
			$state = $this->admissionSupervisoryPanelSelect($type);
			$state['folder'] = DIR_FOLDER_ADMISSION_SIGNATURES_SIMPLE;
		return $state;
		case 'PRIVATE_DEFENCE':
			$state = $this->privateSignaturesGetValues();
			$state['folder'] = DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE;
		return $state;
		case 'INSTITUTE':
			$state[0] = $this->instituteSelectSelected(ConnectDB::isSession(), null);
			$state['folder'] = DIR_FOLDER_ADMISSION_SIGNATURES_PRESIDENT_SIMPLE;
		return $state;
		default:
			return false;
	}
}

// section = ADMISSION , PRIVATE_DEFENCE , INSTITUTE
public function checkingSignatures($main, $type=null, $section) {

	$state = $this->getContentSignatures($type, $section) ; 
	 
	if(is_array($state)) {
		$folder = $state['folder'];
		unset($state['folder']);
		for($i = 0; $i < count($state); $i++ ) {

			if($state[$i]['state'] == 3 ) { 
				$push = $folder.$state[$i]['dir'];
				$cal = $main->countOpenDirectory($push);
			 
				if($cal <=  0) {
					$r['sent'] = $state[$i]['sent'];
					$r['state'] = (($state[$i]['sent'] == 1) ? 1 : 0) ;
					
					$r['id_user'] = ConnectDB::isSession();
					if($section == 'ADMISSION') {
						$r['id'] = $state[$i]['id_adm_supervisory_panel'];
						$this->admissionSupervisoryPanelUpdateNotSession($r);
					} else if($section == 'PRIVATE_DEFENCE') {
						$r['id'] = $state[$i]['id_my_supervisory_panel'];
						$this->privateSupervisoryPanelUpdateNotSession($r);
					} else if($section == 'INSTITUTE') {
						$data = $this->instituteSelectSelected(self::isSession(), null);
						if(is_array($data)) {
							$this->instituteUpdateSelected($data['id_institute']);
						} else {
							$this->instituteUpdateSelected($r);
						}	
					} else {
						return false;
					} 
				}
			}
		}
	}
}

public function admissionSupervisoryPanelUpdateNotSession($r) {  
	$state = (isset($r['state']) ? $r['state'] : 1);
	$sent = (isset($r['sent']) ? $r['sent'] : 1);
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_supervisory_panel` SET 
								`state`       = '{$state}',  
								`sent`        = '{$sent}', 
								`sent_date`   = '".self::staticFormatDate()."',  
								`date`        = '".self::staticFormatDate()."' 
								WHERE `adm_supervisory_panel`.`id_adm_supervisory_panel`='".$r['id']."' 
								AND `adm_supervisory_panel`.`id_user`='".$r['id_user']."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB UPDATE # 3254524 '.$e->getMessage()); return false; }
}

public function admissionSupervisoryPanelSelect($employment=null, $id=null) { 
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		if($employment == null) {
			$sql = "SELECT * FROM `adm_supervisory_panel` WHERE `id_user`= '".self::isSession()."' AND `id_adm_supervisory_panel`='{$id}' ";
		} else {
			$sql = "SELECT * FROM `adm_supervisory_panel` WHERE `id_user`= '".self::isSession()."' AND `employment`= '".$employment."' ORDER BY `date` ASC";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		 
		if($query->rowCount() > 0 ) {
		   
			return (($employment == null) ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC)); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 6045001454'.$e->getMessage()); return false; }
}
 
public function admissionSupervisoryPanelSelectAll($id_user=null) {
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `adm_supervisory_panel` 
								WHERE `id_user`= '".(is_null($id_user) ? self::isSession() : $id_user)."' 
								ORDER BY `adm_supervisory_panel`.`date` DESC");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 6045454'.$e->getMessage()); return false; }
}

public function unlinkDir($dir) {
    $dirs = array($dir);
    $files = array() ;
    for($i=0; ; $i++) {
        if(isset($dirs[$i]))  $dir =  $dirs[$i];
        else break ;
        if($openDir = opendir($dir)) {
            while($readDir = @readdir($openDir)) {
                if($readDir != "." && $readDir != "..") {  
                    if(is_dir($dir."/".$readDir)) {
                        $dirs[] = $dir."/".$readDir ;
                    } else {
                        $files[] = $dir."/".$readDir ;
                    }
                }
            }
        }
    }
    foreach($files as $file) {
        unlink($file) ;
    }
    $dirs = array_reverse($dirs) ;
    foreach($dirs as $dir) {
        rmdir($dir) ;
    }
}
 
public function admissionSupervisoryPanelDelete($id) { 
	$main = new Main();
	if(!self::isSession()) { return false; }
	$dir = $this->admissionSupervisoryPanelSelect(null, $id);
	try { 
		if(isset($dir['dir'])) {  
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE FROM `adm_supervisory_panel` WHERE `adm_supervisory_panel`.`id_adm_supervisory_panel` = '{$id}'");
			
			$r['id_adm_supervisory_panel'] = $id;
			$main->deleteLinkSupervisor($r);
					
			$query->execute();
				 
			if($path = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_SIMPLE.$dir['dir'])) {
				$this->unlinkDir($path);
				return true;
			} else {
				return false;
			}	
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB DELETE # 6002444'.$e->getMessage()); return false; }
}

public function admissionSupervisoryPanelUpdate($r) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_supervisory_panel` SET 
								`titel`       = '".$r['titel']."', 
								`lastname`    = '".$r['lastname']."', 
								`firstname`   = '".$r['firstname']."', 
								`institution` = '".$r['institution']."', 
								`email`       = '".$r['email']."', 
								`employment`  = '".$r['employment']."', 
								`date`        = '".$r['date']."' 
								WHERE `adm_supervisory_panel`.`id_adm_supervisory_panel`='".$r['id']."' 
								AND `adm_supervisory_panel`.`id_user`='".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB UPDATE # 65476544'.$e->getMessage()); return false; }
}
 
public function admissionSignaturesUpdate($id) { 
	if(!self::isSession()) { return false; }
	try {
		$date = self::staticFormatDate() ;
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `adm_supervisory_panel` SET 
									`state` = '1',	
									`sent` = '1',
									`sent_date` = '".$date."'
								WHERE `adm_supervisory_panel`.`id_adm_supervisory_panel` = '{$id}' 
								AND `adm_supervisory_panel`.`id_user`='".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB UPDATE # 67585600'.$e->getMessage()); return false; }
}

public function privateSignaturesUpdate($id) { 
	if(!self::isSession()) { return false; }
	try {
		$date = self::staticFormatDate() ;
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `my_supervisory_panel` SET
									`state` = '1',		
									`sent` = '1',
									`sent_date` = '".$date."'
								WHERE `my_supervisory_panel`.`id_my_supervisory_panel` = '{$id}' 
								AND `my_supervisory_panel`.`id_user`='".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR DB UPDATE # 6455600'.$e->getMessage()); return false; }
}

public function admissionSignaturesGetValues($id=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		if($id == null) {
			$query = $dbh->prepare("SELECT * FROM `adm_supervisory_panel` 
									WHERE `adm_supervisory_panel`.`id_user`='".self::isSession()."'");
		} else {
			$query = $dbh->prepare("SELECT * FROM `adm_supervisory_panel` 
									WHERE  `adm_supervisory_panel`.`id_adm_supervisory_panel`='{$id}' 
									AND `adm_supervisory_panel`.`id_user`='".self::isSession()."'");
		}
		$query->execute();
		if($query->rowCount() > 0 ) {
				return ($id == null  ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC)); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 60111400'.$e->getMessage()); return false; }
} 

public function privateSignaturesGetValues($id=null) {
	if(!self::isSession()) { return false; }
	 
	try {
		$dbh = ConnectDB::DB();
		if($id == null) {
			$sql = "SELECT * FROM `my_supervisory_panel` WHERE `my_supervisory_panel`.`id_user`='".self::isSession()."'";
		} else {
			$sql = "SELECT * FROM `my_supervisory_panel` 
									WHERE  `my_supervisory_panel`.`id_my_supervisory_panel`='{$id}' 
									AND `my_supervisory_panel`.`id_user`='".self::isSession()."'";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {  
				return ($id == null  ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC)); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 6445100'.$e->getMessage()); return false; }
}

public function showText($id, $test=null) {
	try {
		$dbh = ConnectDB::DB();
		switch($test) {
			case 1:
				$query = $dbh->prepare("SELECT * FROM `text_user` WHERE `id_user`='{$id}' ");
			break;
			default:
				$query = $dbh->prepare("SELECT * FROM `text` WHERE `id_text`='{$id}' ");
		}
		 
		
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 6544500'.$e->getMessage()); return false; }
}
 
public function insertPrivateHome($r) {
	if(!self::isSession()) { return false; }
	try {  
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `private_home` (
									`id_private_home`,
									`id_user`,
									`thesis1`,
									`thesis2`,
									`date`)
								VALUES ('{$this->guid()}',
									'".self::isSession()."',
									'".$r['thesis1']."',
									'".$r['thesis2']."',
									'".$r['date']."');");
		$query->execute();
	} catch(Exception $e) { print('ERROR DB INSERT # 65445'.$e->getMessage()); return false; }
}
 
public function updatePrivateHome($r) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `private_home` SET 
										`thesis1` = '".$r['thesis1']."', 
										`thesis2` = '".$r['thesis2']."', 
										`date` = '".$r['date']."'
										WHERE `private_home`.`id_user` = '".self::isSession()."';");
		$query->execute();
	} catch(Exception $e) { print('ERROR DB UPDATE # 254445510'.$e->getMessage()); return false; }
}
 
public function showPrivateHome($id_user=null) {   
	try {  
		$dbh = ConnectDB::DB();
		if( $id_user != null ) {
			if($this->isID($id_user)) {
				$query = $dbh->prepare("SELECT * FROM `private_home` WHERE `id_user`='".$id_user."'");
			} else {
				return false;
			}  
		} else {
			if(!self::isSession()) { return false; }
			$query = $dbh->prepare("SELECT * FROM `private_home` WHERE `id_user`='".self::isSession()."'");
		}
		$query->execute();
		if($query->rowCount() > 0 ) {  
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 25445252'.$e->getMessage()); return false; }
}
 
public function admSubmitSelect($id=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `adm_submit` 
								WHERE `id_user` = '".($id == null ? self::isSession() : $id)."' 
								ORDER BY `adm_submit`.`date` DESC");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 116652544'.$e->getMessage()); return false; }
}
 
// admin or user 
public function admSubmitInsert($r=null, $state=null, $test=null) { 
	$main = new Main();
	if(!self::isSession()) { return false; }
	 
	if( $test != null ){ // admin
		$sql = "INSERT INTO adm_submit() 
				VALUES ('{$this->guid()}',
						'".self::isSession()."',
						'{$r['id_admin']}', 
						'".$state."', 
						'".self::staticFormatDate()."',
						'".($state == 0 ? self::staticFormatDateStandard() : Main::addDate(self::staticFormatDate()) )."' );";
								
		$this->status_default_value['id_admin'] = $r['id_admin']; //  ;
		$this->status_default_value['admin_confirm'] = 2; 
		$this->status_default_value['admin_date_confirm'] = self::staticFormatDate(); 
		$this->status_default_value['position'] = 2; 
		$this->status_default_value['position_phd'] = 2; 
		$this->updateStatus($this->status_default_value);						 
	} else {
		$sql = "INSERT INTO adm_submit() 
				VALUES ('{$this->guid()}',
						'".self::isSession()."',
						0,
						'".(!isset($r['not_active']) ? 1 : 0 ) ."',
						'{$r['date']}',
						'".self::staticFormatDateStandard()."');";
								
		$this->status_default_value['user_request'] = 1;
		$this->status_default_value['user_date_request'] = self::staticFormatDate();
		if(!isset($r['not_active'])) { $this->updateStatus($this->status_default_value); }
		$this->status_default_value['user_request'];
	}
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB INSERT # 35665544 '.$e->getMessage()); return false; }
}
				
public function admSubmitUpdate($r=array(), $state=null, $test=null) { 
	$main = new Main();
	if(!self::isSession()) { return false; } 
		$sql = "UPDATE  `adm_submit` SET 
				`id_admin` = '{$r['id_admin']}', 
				`state` = '{$state}', 
				`date` = '".$r['date']."', 
				`add_years` = '".($state == 0 ? self::staticFormatDateStandard() : Main::addDate($r['date']))."' 
				WHERE `id_user` = '".self::isSession()."'";

		if($test != 'PRE') {  
			$this->status_default_value['id_admin'] = $r['id_admin'];
			$this->status_default_value['admin_confirm'] = ($state == 0 ? 0 : 2);
			$this->status_default_value['admin_date_confirm'] = self::staticFormatDate(); 
			$this->status_default_value['position'] = ($state == 0 ? 1 : 2);
			$this->status_default_value['position_phd'] = ($state == 0 ? 1 : 2);
			$this->updateStatus($this->status_default_value);
			
			$this->mySupervisoryPanelDelete();
			($state == 1 ? $this->mySupervisoryPanelInsert() : '');	
		}	
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR # UPDATE 245000645'.$e->getMessage()); return false; }
}

public function supervisoryPanelAll($tab, $id_user=null) { //my_supervisory_panel 
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$s = ($id_user == null ? '' : " and `id_user` = '{$id_user}'");
		$sql = "SELECT * FROM `{$tab}` {$s}";
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			return  $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR # SELECT 24574645 '.$e->getMessage()); return false; }

}

public function mySupervisoryPanelSelect($employment=null, $id=null, $test=null) { 
	if($test != 'SIGNATURES') {
		if(!self::isSession()) { return false; } 
	}
	try {
		$dbh = ConnectDB::DB();
		if($test == null) {
			if($employment == null) {
				$sql = "SELECT * FROM `my_supervisory_panel` WHERE `id_user`= '".self::isSession()."' AND `id_my_supervisory_panel`='{$id}'";
			} else {
				$sql = "SELECT * FROM `my_supervisory_panel` WHERE `id_user`= '".self::isSession()."' AND `employment`= '".$employment."' ORDER BY `date` ASC";
			}
		} else {
			$sql = "SELECT * FROM `my_supervisory_panel` WHERE `id_user`= '".($test == 'SIGNATURES' ? $id : self::isSession() )."' ORDER BY `lastname` ASC";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			if( $test == null )
				return (($employment == null) ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC)); 
			else 
				return $query->fetchAll(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR # SELECT 24574645 '.$e->getMessage()); return false; }
}

public function mySupervisoryPanelInsertReq($r) { 
	$main = new Main();
	$forlder = $this->guid();
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `my_supervisory_panel`( ) 
								VALUES ('{$this->guid()}', 
										'NULL',
										'".self::isSession()."',
										'{$r['titel']}',
										'{$r['lastname']}',
										'{$r['firstname']}',
										'{$r['institution']}',
										'{$r['email']}',
										'{$r['employment']}',
										'{$r['state']}',
										'{$r['sent']}',
										'".self::staticFormatDate()."',
										'{$forlder}',
										'{$r['date']}')");
										
		$path = $main->isDirectoryExists(DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE);
		
		if($this->createFolderSimple($path, null, $forlder)) {  
			$query->execute();
		} 
	} catch(Exception $e) { print( ' ERROR  DB INSER # 25475647'.$e->getMessage()); }
}

public function mySupervisoryPanelInsert() { 

	$main = new Main();
	if(!self::isSession()) { return false; } 
	try {
		$adm_supervis =  $this->admissionSupervisoryPanelSelectAll();
		if(!is_array($adm_supervis)) return false ; 
		$dbh = ConnectDB::DB();
		$index = 0;
		foreach ($adm_supervis as $k => $v) {
			$query = $dbh->prepare("INSERT INTO `my_supervisory_panel`( ) 
								VALUES ('{$this->guid()}', 
										'{$adm_supervis[$index]['id_adm_supervisory_panel']}',
										'".self::isSession()."',
										'{$adm_supervis[$index]['titel']}',
										'{$adm_supervis[$index]['lastname']}',
										'{$adm_supervis[$index]['firstname']}',
										'{$adm_supervis[$index]['institution']}',
										'{$adm_supervis[$index]['email']}',
										'{$adm_supervis[$index]['employment']}',
										'0',
										'0',
										'".self::staticFormatDate()."',
										'{$adm_supervis[$index]['dir']}',
										'{$adm_supervis[$index]['date']}')");
										
			$path = $main->isDirectoryExists(DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE);
			
			if($this->createFolderSimple($path, null, $adm_supervis[$index]['dir'])) {   
				$query->execute();
			} else {
				print('ERROR DB CREATE FOLDER # 6541454');
			}
		$index++;
		} 
	} catch(Exception $e) { print( 'ERROR DB INSERT # 25478'.$e->getMessage()); return false; }
}
 
public function mySupervisoryPanelDeleteReq($id) {  
	if(!self::isSession()) { return false; }
	$main = new Main();
	try {  
		$dbh = ConnectDB::DB();
		if(is_array($my_sp = $this->mySupervisoryPanelSelect(null, $id))) {
			if($path = $main->isDirectoryExists(DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE.$my_sp['dir'])) {
				$query = $dbh->prepare("DELETE FROM `my_supervisory_panel` 
										WHERE `my_supervisory_panel`.`id_my_supervisory_panel` = '{$id}'");
				$this->unlinkDir($path);	
				$r['id_my_supervisory_panel'] = $id;
				$main->deleteLinkSupervisor($r);	
				$query->execute();
			}
		} else {
			return false;
		}
		return true;
	} catch(Exception $e) { print ('ERROR DB DELETE # 2455455 '.$e->getMessage()); return false; }
}
 
public function mySupervisoryPanelDelete() { 
	if(!self::isSession()) { return false; } 
	$main = new Main();
	if(is_array($my_sp = $this->mySupervisoryPanelSelect(null, null, 'DELETE'))) {
		$index = 0;
		foreach($my_sp as $k => $v) {
			if($path = $main->isDirectoryExists(DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE.$my_sp[$index]['dir'])) {	 
				$this->unlinkDir($path);	
			}
			$index++;
		}
	}
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `my_supervisory_panel` WHERE `my_supervisory_panel`.`id_user` = '".self::isSession()."'");

		$query->execute();
	} catch(Exception $e) { print ('ERROR DB DELETE # 47575785 '.$e->getMessage()); return false; }	
}
 
public function mySupervisoryPanelUpdate($r) {
	if(!self::isSession()) { return false; }
		try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `my_supervisory_panel` SET 
								`titel`       = '".$r['titel']."', 
								`lastname`    = '".$r['lastname']."', 
								`firstname`   = '".$r['firstname']."', 
								`institution` = '".$r['institution']."', 
								`email`       = '".$r['email']."', 
								`employment`  = '".$r['employment']."', 
								`date`        = '".$r['date']."' 
								WHERE `my_supervisory_panel`.`id_my_supervisory_panel`='".$r['id']."' AND `my_supervisory_panel`.`id_user`='".self::isSession()."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 244555 '.$e->getMessage());return false; }
}
 
public function admDocTrainingUpdate($r=array(), $test=null) {
	if(!self::isSession()) { return false; } 
			if(isset($r['name_field'])) {
					$sql = "UPDATE  `adm_doc_training` SET 
						`{$r['name_field']}` = '".$r['modif_txt']."'
						WHERE `adm_doc_training`.`id_adm_doc_training` = '".$r['id_adm_doc_training']."'
						AND `adm_doc_training`.`id_user` = '".self::isSession()."'";
			} else {
				$sql = "UPDATE  `adm_doc_training` SET 
						`activities` = '".$r['select_activities']."'
						WHERE `adm_doc_training`.`id_adm_doc_training` = '".$r['select_id_doc_training']."'
						AND `adm_doc_training`.`id_user` = '".self::isSession()."'";
			}				
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB UPDATE # 247555 '.$e->getMessage()); return false; }
}
 
public function admDocTrainingInsert($r, $test=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO `adm_doc_training` (
										`id_adm_doc_training`,
										`id_user`, 
										`activities`,
										`description`,
										`place`,
										`acronym`,
										`ects`,
										`comment`,
										`date`)
									VALUES ('{$this->guid()}', 
										'".self::isSession()."', 
										'".$r['activities']."', 
										'".$r['desc']."', 
										'".$r['place']."', 
										'".$r['acronym']."', 
										'".$r['ects']."', 
										'".$r['comment']."', 
										'".self::staticFormatDate()."');"; 
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB INSERT # 246475 '.$e->getMessage()); return false; }
}
 
public function admDocTrainingSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `adm_doc_training`  
								WHERE `id_user` = '".(is_null($id_user) ? self::isSession() : $id_user)."' 
								ORDER BY `adm_doc_training`.`activities` ASC");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 24755 '.$e->getMessage()); return false; }
}
 
public function admDocTrainingDelete($id_adm_doc_training) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("DELETE FROM `adm_doc_training` 
								WHERE `adm_doc_training`.`id_adm_doc_training` = '".$id_adm_doc_training."' 
								AND `adm_doc_training`.`id_user` = '".self::isSession()."'"); 
		$query->execute();
		return true;
	}  catch(Exception $e) { print ('ERROR DB DELETE # 47545475 '.$e->getMessage()); return false; }	
}

public function docTrainingHomeInsert($radio) {
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `doc_training_home` 
								(`id_doc_training_home`, `id_user`, `radio`, `date_created`) 
									VALUES ('".$this->guid()."',
									'".self::isSession()."', '{$radio}', '".self::staticFormatDate()."');");
		$query->execute();							
	} catch(Exception $e) { print ('ERROR DB INSERT #  75745 '.$e->getMessage()); return false; }
}
 
public function docTrainingHomeSelect($id_user=null) {
	if(!self::isSession()) { return false; } 
	try {
	
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_home` WHERE `id_user` = '".(is_null($id_user) ? self::isSession() : $id_user)."'");
		$query->execute();
		
		if($query->rowCount() > 0 ) {  
			return $query->fetch(PDO::FETCH_ASSOC);  
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 7858999 '.$e->getMessage()); return false; }
}
 
public function docTrainingHomeUpdate($radio) {  
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `doc_training_home` SET
					`radio`     = '".$radio."' 
					WHERE `doc_training_home`.`id_user` = '".self::isSession()."';");
		$query->execute();
	} catch(Exception $e) { print ('ERROR DB UPDATE # 788988 '.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceFind($id_conference) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_conferences`  
								WHERE `id_user` = '".self::isSession()."' 
								AND `id_doc_training_conferences`='".$id_conference."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR BD SELECT # 1235565 '.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceListFind($id_list) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_conferences_list`  
								WHERE `id_user` = '".self::isSession()."' 
								AND `id_doc_training_conferences_list`='".$id_list."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR BD SELECT # 124447 '.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_conferences`  
								WHERE `id_user` = '".(is_null($id_user) ? self::isSession() : $id_user)."' 
								ORDER BY `doc_training_conferences`.`date` ASC");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR BD SELECT # 4255 '.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceListSelect($r, $test=null) {  
	$main = new Main(); 
	if(!self::isSession()) { return false; }
	$sql = ($test == 100 ? "AND `status` <> {$main->statusValue('accept')} AND `status` <> {$main->statusValue('final')}" : "AND `type_choice` = '".$test."'");		
	try {
		$dbh = ConnectDB::DB();
		if(is_numeric($test)) {
			$sql = "SELECT * FROM `doc_training_conferences_list`  
							WHERE `id_doc_training_conferences`= '".$r['id_doc_training_conferences']."' 
							{$sql}  
							AND  `id_user` = '".self::isSession()."'";
		} else {
		
			$sql = "SELECT * FROM `doc_training_conferences_list`  
							WHERE `id_doc_training_conferences`= '".$r['id_doc_training_conferences']."' 
							AND  `id_user` = '".self::isSession()."' ORDER BY `doc_training_conferences_list`.`date` ASC";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) {
		print ('ERROR DB SELECT # 47654765 '.$e->getMessage());
		return false;
	}
}

public function docTrainingConferenceListSelectItem($id_doc_training_conferences=null, $id_user=null) {  
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		if($id_doc_training_conferences == null) {
			$query = $dbh->prepare("SELECT * FROM `doc_training_conferences_list` 
									WHERE `id_user` = '".(is_null($id_user) ? self::isSession() : $id_user)."'");
		} else {
			$query = $dbh->prepare("SELECT * FROM `doc_training_conferences_list`  
									WHERE `id_doc_training_conferences`= '".$id_doc_training_conferences."' 
									AND  `id_user` = '".self::isSession()."'");
		}
		$query->execute();
		if($query->rowCount() > 0 ) {
			return ($id_doc_training_conferences == null ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC))  ; 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 114478'.$e->getMessage()); return false; }
}
 
 public function getStutusInConference($id_list) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT `doc_training_conferences`.`status` 
								FROM `doc_training_conferences_list` 
								LEFT JOIN `doc_training_conferences` 
								ON `doc_training_conferences_list`.`id_doc_training_conferences`=`doc_training_conferences`.`id_doc_training_conferences` 
								WHERE `doc_training_conferences_list`.`id_doc_training_conferences_list` = '{$id_list}'
								AND `doc_training_conferences_list`.`id_user`='".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {  
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 75781123'.$e->getMessage()); return false; }
}

public function docTrainingConferenceListSelectSimple($id_doc_training_conferences_list) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_conferences_list` 
								WHERE `id_doc_training_conferences_list`= '".$id_doc_training_conferences_list."' 
								AND  `id_user` = '".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {  
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 7758766'.$e->getMessage()); return false; }
}

public function docTrainingConferenceListDelete($id_doc_training_conferences_list, $dir) {
	$main = new Main();
	
	if(!self::isSession()) { return false; }
	try {
		 
		if($path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_LIST_SIMPLE.$dir)) {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE FROM `doc_training_conferences_list` 
								WHERE `doc_training_conferences_list`.`id_doc_training_conferences_list` = '{$id_doc_training_conferences_list}' 
								AND `doc_training_conferences_list`.`id_user`='".self::isSession()."'");
			$query->execute();
			$this->unlinkDir($path);
			return true;
		} else {  
			return false;
		}	 
	} catch(Exception $e) { print ('ERROR DB DELETE # 74576576'.$e->getMessage()); return false; }
}

public function docTrainingConferenceDelete($id_doc_training_conferences, $dir) {
	$main = new Main();
	
	if(!self::isSession()) { return false; }
	try {
		 
		
		if($path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_SIMPLE.$dir)) {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE FROM `doc_training_conferences` 
								WHERE `doc_training_conferences`.`id_doc_training_conferences` = '{$id_doc_training_conferences}' 
								AND `doc_training_conferences`.`id_user`='".self::isSession()."'");
			$query->execute();
			$this->unlinkDir($path);
			return true;
		} else {
			return false;
		}	 
	} catch(Exception $e) { print ('ERROR DB DELETE # 75675785 '.$e->getMessage()); return false; }
}

private function getDocTrainingNumCredits($num_credits2) {
	$admin = new AdminAuthority( ); 
	$main = new Main(); 
	$m_c2 = ($main->authenticity() ? 1 : 0);
		if($main->authenticity()) {
			if((int)$num_credits2 == -0) {
				$m_c2 = 0; 
			}
		}	
	return $m_c2;
}

private function statusModifNumCredits($num_credits2) {
	$admin = new AdminAuthority( ); 
	$main = new Main(); 
	$m_c2 = '';
	if( $main->authenticity()) {
		if(strlen($num_credits2 ) == 2) {  
			if(strpos($num_credits2 , '-0') !== false  ) {
				$m_c2 = ",`modif_credits2` = '0'";
			} else {
				$m_c2 = ",`modif_credits2` = '1'";
			}
		} else {
			$m_c2 = ",`modif_credits2` = '1'";
		}
	}
	return $m_c2;
}	

public function docTrainingConferenceListInsert($r) { 
	$admin = new AdminAuthority( ); 
	$main = new Main(); 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$insert_id = $this->guid();
		$c2 = ($main->authenticity() ? ((int)$r['num_credits2'] ==  -0 ? 0 : $r['num_credits2']) : '0');
		$m_c2 = $this->getDocTrainingNumCredits($r['num_credits2']);
		  
		$path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_LIST_SIMPLE); 
		
		if($folder = $this->createFolderSimple($path)){
			$query = $dbh->prepare("INSERT INTO `doc_training_conferences_list`() 
								VALUES ('".$insert_id."', 
								'".self::isSession()."', 
								'".$r['val_choice']."',
								'".$r['type_abstract']."', 
								'".$r['title']."',
								'".$folder."', 
								'".$r['reference_dial']."', 
								'".$r['num_credits1']."', 
								'{$c2}', 
								'".$r['num_credits3']."', 
								'".$r['id_conference']."',
								'1',
								'',
								'1','{$m_c2}','".self::staticFormatDate()."');");
			$query->execute();
			return $insert_id.'#'.$folder ;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB INSERT # 47578785 '.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceListUpdate($r) { 
	$main = new Main();   
	$admin = new AdminAuthority( ); 	
	$val = ($main->authenticity() ? "`value`= '2'" : "`value` = '1'");
	
	$c2 = ($main->authenticity() ? "`num_credits2` = '".($r['num_credits2'] == -0 ? 0 : $r['num_credits2'] )."', " : '');	
	$m_c2 = '';
	if( isset($r['id_conference']) ) {
		if(is_array($this->docTrainingConferenceListSelectSimple($r['id_conference']))) {
			//if($list['num_credits2'] != $r['credits2']) {
				$m_c2 = $this->statusModifNumCredits($r['num_credits2']);
			//}
		}
	}
	
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `doc_training_conferences_list` SET
					`type_choice`     = '".$r['val_choice']."', 
					`type_abstract`   = '".$r['type_abstract']."',
					`title`           = '".$r['title']."',
					`reference_dial`  = '".$r['reference_dial']."',
					`num_credits1`    = '".$r['num_credits1']."',
					{$c2}
					`num_credits3`    = '".$r['num_credits3']."',
					{$val}
					{$m_c2}
					WHERE `doc_training_conferences_list`.`id_doc_training_conferences_list` = '".$r['id_conference']."' 
					AND `doc_training_conferences_list`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 47587878'.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceListUpdateStatus($id_conference, $id_list, $status) { 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `doc_training_conferences_list` SET
					`status`     = '{$status}'
					WHERE `doc_training_conferences_list`.`id_doc_training_conferences_list` = '".$id_list."'
					AND `doc_training_conferences_list`.`id_doc_training_conferences` = '".$id_conference."'
					AND `doc_training_conferences_list`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 45454545'.$e->getMessage()); return false; }
}
 
public function docTrainingConferenceCreate($name_conference) {
	$main = new Main();
	
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_SIMPLE); 
		
		if($folder = $this->createFolderSimple($path)){
			$query = $dbh->prepare("INSERT INTO `doc_training_conferences`  () 
									VALUES ('".$this->guid()."', 
										'{$name_conference}', 
										'".self::isSession()."', 
										'".$folder."', 
										'1', 
										'', 
										' ', 
										' ', 
										'',
										'1', 
										'',									
										'".self::staticFormatDate()."');");
			$query->execute();
			return true;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB INSERT # 47578578'.$e->getMessage()); return false; }
}

public function docTrainingConferenceUpdate($r) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `doc_training_conferences` SET
									`name_conference` = '".$r['name_conference']."', 
									`type`         = '".$r['type']."',
									`place`        = '".$r['place']."',
									`date_from`    = '".$r['deles_from']."',
									`date_to`      = '".$r['deles_to']."',
									`numbers_days` = '".$r['participation']."'
								WHERE `doc_training_conferences`.`id_doc_training_conferences` = '".$r['id_conference']."' 
								AND `doc_training_conferences`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4777888785'.$e->getMessage()); return false; }
}
 
public function docTrainingCorsesCreate($title) {

	$main = new Main();

	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB(); 
		
		$path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_COURSES_SIMPLE); 
		
		
		if($folder = $this->createFolderSimple($path)) {
			$query = $dbh->prepare("INSERT INTO  `doc_training_courses` () 
										VALUES ('{$this->guid()}',
											'".self::isSession()."',
											'', '', '1', '{$title}', 
											'', 
											'',
											'', 
											'{$folder}',
											'0', '0', '', '1', '', '1', '0', '".self::staticFormatDate()."');");
			$query->execute();
			return true;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB INSERT # 464765777 '.$e->getMessage()); return false; }
}
 
public function docTrainingCoursesSelectSimple($id_course=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		if($id_course == null) {
			$query = $dbh->prepare("SELECT * FROM `doc_training_courses`  
								WHERE `id_user` = '".self::isSession()."'");
		} else {
			$query = $dbh->prepare("SELECT * FROM `doc_training_courses`  
								WHERE `id_doc_training_courses`= '".$id_course."' 
								AND  `id_user` = '".self::isSession()."'");
		}						
		$query->execute();
		if($query->rowCount() > 0 ) {
			return ($id_course == null ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC) ); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 46546546 '.$e->getMessage()); return false; }
}
 
public function docTrainingCoursesSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_courses` 
								WHERE `doc_training_courses`.`id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."'  
								ORDER BY `doc_training_courses`.`date` ASC ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 7879765751'.$e->getMessage()); return false; }
}

public function docTrainingCourseDelete($id_course, $dir) {
	$main = new Main();
	
	if(!self::isSession()) { return false; }  
	try {
		$dbh = ConnectDB::DB();
		$sql = "DELETE FROM `doc_training_courses` 
								WHERE `doc_training_courses`.`id_doc_training_courses` = '{$id_course}' 
								AND `doc_training_courses`.`id_user`='".self::isSession()."'";
								
		   
		
		if($path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_COURSES_SIMPLE.$dir)) {  
			$this->unlinkDir($path);
			$query = $dbh->prepare($sql);
			$query->execute();
			return true; 
		} else { 
			$query = $dbh->prepare($sql);
			$query->execute();
			return true;
		}
	} catch(Exception $e) { print ('ERROR DB DELETE # 43646465'.$e->getMessage()); return false; }
}

public function docTrainingCourseUpdate($r) {
	$admin = new AdminAuthority( ); 
	$main = new Main(); 
	
	$val = ($main->authenticity() ? "`value`= '2'" : "`value` = '1'");		
	$c2 = ($main->authenticity() ? "`num_credits2` = '".($r['credits2'] == -0 ? 0 : $r['credits2'] )."', " : '');
	$m_c2 = '';
	if( isset($r['id_course']) ) {  
		if(is_array($course = $this->docTrainingCoursesSelectSimple($r['id_course']))) {
			
			if($course['num_credits2'] != $r['credits2']) {
			 
				$m_c2 = $this->statusModifNumCredits($r['credits2']);
				//echo $m_c2;
			}  
		}
	}
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `doc_training_courses` SET
									`name_courses` = '', 
									`institution`  = '".$r['institution']."',
									`type`         = '".$r['type']."',
									`title`        = '".$r['title']."',
									`date_from`    = '".$r['date_from']."',
									`date_to`      = '".$r['date_to']."',
									`numbers_days` = '".$r['participation']."',
									`num_credits1` = '".$r['credits1']."',
									{$c2}
									`num_credits3` = '".$r['credits3']."',
									{$val}
									{$m_c2}
								WHERE `doc_training_courses`.`id_doc_training_courses` = '".$r['id_course']."' 
								AND `doc_training_courses`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 465465 '.$e->getMessage()); return false; }
}
 
public function docTrainingJournalPapersSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_journal_papers`
								WHERE `doc_training_journal_papers`.`id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."'  
								ORDER BY `doc_training_journal_papers`.`date` ASC ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 4646545 '.$e->getMessage()); return false; }
}
 
public function docTrainingJournalPapersCreate($title) {
	
	$main = new Main(); 

	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		
		$path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_JOURNAL_PAPERS_SIMPLE);
		
		if($folder = $this->createFolderSimple($path)) {
			$query = $dbh->prepare("INSERT INTO `doc_training_journal_papers` () 
										VALUES ('{$this->guid()}',
											'".self::isSession()."',
											'{$title}', '', '', '','1', '".FORMAT_DATE_DEFAULT."', '".FORMAT_DATE_DEFAULT."', 
											'".FORMAT_DATE_DEFAULT."', 
											'{$folder}',
											'0','0','1', '', '0', '".self::staticFormatDate()."');");
			$query->execute();
			return true;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB INSERT # 7567657'.$e->getMessage()); return false; }
}

public function docTrainingJournalPapersSelectSimple($id_journal_papers=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		if($id_journal_papers == null) {
			$query = $dbh->prepare("SELECT * FROM `doc_training_journal_papers`  
							WHERE `id_user` = '".self::isSession()."'");
		} else {
			$query = $dbh->prepare("SELECT * FROM `doc_training_journal_papers`  
							WHERE `id_doc_training_journal_papers`= '".$id_journal_papers."' 
							AND  `id_user` = '".self::isSession()."'");
		}			
		$query->execute();
		if($query->rowCount() > 0 ) {
			return ($id_journal_papers == null ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC) ); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 4646476'.$e->getMessage()); return false; }
}

public function docTrainingJournalPapersDelete($id_journal_papers, $dir) {

	$main = new Main(); 
	
	if(!self::isSession()) { return false; }  
	try {
		$dbh = ConnectDB::DB();
		$sql = "DELETE FROM `doc_training_journal_papers` 
								WHERE `doc_training_journal_papers`.`id_doc_training_journal_papers` = '{$id_journal_papers}' 
								AND `doc_training_journal_papers`.`id_user`='".self::isSession()."'";
		
		 
		
								
		if($path = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_JOURNAL_PAPERS_SIMPLE.$dir)) {  
			$this->unlinkDir($path);
			$query = $dbh->prepare($sql);
			$query->execute();
			return true; 
		} else { 
			$query = $dbh->prepare($sql);
			$query->execute();
			return true;
		}
	} catch(Exception $e) { print ('ERROR DB DELETE # 4564765785'.$e->getMessage()); return false; }
}

public function docTrainingJournalPapersUpdate($r) {
	$admin = new AdminAuthority( );
	$main = new Main();	

	$c2 = ($main->authenticity() ? "`num_credits2` = '".($r['credits2'] == -0 ? 0 : $r['credits2'] )."', " : '');	
	$m_c2 = ''; 
	if( isset($r['id_journal_papers']) ) {
		if(is_array($journal = $this->docTrainingJournalPapersSelectSimple($r['id_journal_papers']))) {
			if($journal['num_credits2'] != $r['credits2']) {
				$m_c2 = $this->statusModifNumCredits($r['credits2']);
			}
		}
	}
	 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `doc_training_journal_papers` SET
									`title`  = '".$r['title']."',
									`role`  = '".$r['role']."',
									`notice` = '".$r['notice']."', 									
									`date_journal` = '".$r['date_journal']."',
									`date_select`  = '".$r['date_select']."',
									{$c2}
									`num_credits1` = '".$r['credits1']."'
									{$m_c2}
								WHERE `doc_training_journal_papers`.`id_doc_training_journal_papers` = '".$r['id_journal_papers']."' 
								AND `doc_training_journal_papers`.`id_user` = '".self::isSession()."';");
			$query->execute();
			return true;
		
	} catch(Exception $e) { print ('ERROR DB UPDATE # 47867676'.$e->getMessage()); return false; }
}

 public function docTrainingSeminarsSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_seminars` 
								WHERE `doc_training_seminars`.`id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."'  
								ORDER BY `doc_training_seminars`.`date_created` ASC ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 465465'.$e->getMessage()); return false; }
}
 
public function docTrainingSeminarsCreate($title) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `doc_training_seminars` () 
											VALUES('{$this->guid()}',
											'".self::isSession()."','1',
											'{$title}', '1', ' ', '', 
											'0', 
											'0', '', '1', '', '0', '0', '".self::staticFormatDate()."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 456456'.$e->getMessage()); return false; }
}
 
public function docTrainingSeminarsSelectSimple($id_seminars) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_seminars`  
								WHERE `id_doc_training_seminars`= '".$id_seminars."' 
								AND  `id_user` = '".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 464646'.$e->getMessage()); return false; }
}
 
public function docTrainingSeminarsDelete($id_seminars) {
	if(!self::isSession()) { return false; }  
	try {
		$dbh = ConnectDB::DB();
		$sql = "DELETE FROM `doc_training_seminars` 
								WHERE `doc_training_seminars`.`id_doc_training_seminars` = '{$id_seminars}' 
								AND `doc_training_seminars`.`id_user`='".self::isSession()."'";
		
			$query = $dbh->prepare($sql);
			$query->execute();
			return true;
		
	} catch(Exception $e) { print ('ERROR DB DELETE # 565656'.$e->getMessage()); return false; }
}
 
public function docTrainingSeminarsUpdate($r) {
	$admin = new AdminAuthority( ); 
	$main = new Main();
	
	$val = ($main->authenticity() ? "`value`= '2'" : "`value` = '1'");	
	$c2 = ($main->authenticity() ? "`num_credits2` = '".($r['credits2'] == -0 ? 0 : $r['credits2'] )."', " : '');	
	$m_c2 = '';
	if( isset($r['id_seminars']) ) {
		if(is_array($seminars = $this->docTrainingSeminarsSelectSimple($r['id_seminars']))) {
			if($seminars['num_credits2'] != $r['credits2']) {
				$m_c2 = $this->statusModifNumCredits($r['credits2']);
			}
		}
	}
	 
	
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `doc_training_seminars` SET
									`function`  = '".$r['function']."', 
									`title`  = '".$r['title']."', 
									`type`  = '".$r['type']."',
									`institution`         = '".$r['institution']."',
									`date`        = '".$r['date']."',
									`num_credits1` = '".$r['credits1']."',
									{$c2}
									`num_credits3` = '".$r['credits3']."',
									{$val}
									{$m_c2}
								WHERE `doc_training_seminars`.`id_doc_training_seminars` = '".$r['id_seminars']."' 
								AND `doc_training_seminars`.`id_user` = '".self::isSession()."';");
			$query->execute();
			return true;
		
	} catch(Exception $e) { print ('ERROR DB UPDATE # 476546546'.$e->getMessage()); return false; }
}

public function docTrainingTeachingAndSupervisionCreate($title) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `doc_training_teaching_and_supervision` () 
											VALUES('{$this->guid()}',
											'".self::isSession()."',
											'{$title}', '1','', 
											'0', 
											'0', '', '1', '', '1', '0', '".self::staticFormatDate()."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 45645656'.$e->getMessage()); return false; }
}
 
public function docTrainingTeachingAndSupervisionSelect($id_user=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_teaching_and_supervision` 
								WHERE `doc_training_teaching_and_supervision`.`id_user`='".(is_null($id_user) ? self::isSession() : $id_user)."'  
								ORDER BY `doc_training_teaching_and_supervision`.`date_created` ASC ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 456564'.$e->getMessage()); return false; }
}
 
public function docTrainingTeachingAndSupervisionDelete($id_teaching_and_supervision) {
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB();
		$sql = "DELETE FROM `doc_training_teaching_and_supervision` 
								WHERE `doc_training_teaching_and_supervision`.`id_doc_training_teaching_and_supervision` = '{$id_teaching_and_supervision}' 
								AND `doc_training_teaching_and_supervision`.`id_user`='".self::isSession()."'";
		
			$query = $dbh->prepare($sql);
			$query->execute();
			return true;
		
	} catch(Exception $e) { print ('ERROR DB DELETE # 45645'.$e->getMessage()); return false; }
}
 
public function docTrainingTeachingAndSupervisionSelectSimple($id_teaching_and_supervision) {

	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `doc_training_teaching_and_supervision`  
								WHERE `id_doc_training_teaching_and_supervision`= '".$id_teaching_and_supervision."' 
								AND  `id_user` = '".self::isSession()."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 475675785'.$e->getMessage()); return false; }
}
 
public function docTrainingTeachingAndSupervisionUpdate($r) {

 	$admin = new AdminAuthority( ); 
	$main = new Main();
	
	$val = ($main->authenticity() ? "`value`= '2'" : "`value` = '1'");
 
	$c2 = ($main->authenticity() ? "`num_credits2` = '".($r['credits2'] == -0 ? 0 : $r['credits2'] )."', " : '');	
	$m_c2 = '';
	
	if( isset($r['id_teaching_and_supervision']) ) {
		if(is_array($teach = $this->docTrainingTeachingAndSupervisionSelectSimple($r['id_teaching_and_supervision']))) {
			if($teach['num_credits2'] != $r['credits2']) {
				$m_c2 = $this->statusModifNumCredits($r['credits2']);
			}
		}
	}
	 
	if(!self::isSession()) { return false; }
	
	try {
		$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `doc_training_teaching_and_supervision` SET
									`title`  = '".$r['title']."', 
									`type`  = '".$r['type']."',
									`institution`         = '".$r['institution']."',
									`num_credits1` = '".$r['credits1']."',
									{$c2}
									`num_credits3` = '".$r['credits3']."',
									{$val}
									{$m_c2}
								WHERE `doc_training_teaching_and_supervision`.`id_doc_training_teaching_and_supervision` = '".$r['id_teaching_and_supervision']."' 
								AND `doc_training_teaching_and_supervision`.`id_user` = '".self::isSession()."';");
			$query->execute();
			return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 47567574546 '.$e->getMessage()); return false; }
}
 
//submit and status 
public function docTrainingUpdateSR($id, $index_db, $name_db, $sql, $r) {
	$main = new Main();
	$xpl = explode('=', $sql);
	if( is_array($r) ) {
		if (array_key_exists('num_credits2', $r)) {
			if($main->authenticity() && $r['modif_credits2'] == 1) {
				$sql =  "`status` = '3'"; 
			} else {	
				$sql = ($main->authenticity() ?  "`num_credits2` = '".$r['num_credits1']."',".$sql." " : $sql); 
			}	
		}
	} else {
		if(preg_match ("/^(`num_credits1`|`num_credits2`)+$/", trim($xpl[0])) ) {
			$m_c2 = '' ;
			if(preg_match ("/^(`num_credits2`)+$/", trim($xpl[0])) ) {
				$expl = explode('=', $sql);
				$num_credits2 = preg_replace("/'/", '', $expl[1]); 
				$num_credits2 = trim($num_credits2); 
				//echo $num_credits2;
				if((string)$num_credits2 === '-0') {
					$m_c2 = ",`modif_credits2`= '0'";
					$sql = "`num_credits2`= '0'";
				} else {
					$m_c2 = ",`modif_credits2`= '1'";
				}
			}
			$sql = (!$main->authenticity() ?  "`num_credits1` = {$xpl[1]}" : $sql.$m_c2); 			
		}  
	}

	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `".$name_db."` SET
									{$sql}
									WHERE `".$name_db."`.`{$index_db}` = '{$id}' 
									AND `".$name_db."`.`id_user` = '".self::isSession()."';");
			$query->execute();
			return true;
		
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4546546 '.$e->getMessage()); return false; }
}

public function publicDefence($r) {
	if(is_array($data = $this->publicDefenceSelect())) { 
		
		if(isset($data['db'])) {
			if($data['db'] == 1) {
				return  $this->publicDefenceInsert($r) ;
			}
		}
		return $this->publicDefenceUpdate($r) ;
	} else {  
		return  $this->publicDefenceInsert($r) ;
	}
}

public function publicDefenceUpdate($r) {  
	if(!self::isSession()) { return false; }
	try { 
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `public_defence_user` SET  
										`title_of_thesis` = '".$r['title_of_thesis']."',
										`date`            = '".$r['date']."',
										`local`           = '".$r['local_upstaires']."',
										`thesis_time`     = '".$r['thesis_time']."',
										`thesis_place`    = '".$r['thesis_place']."',
										`j_date_time`     = '".$r['j_date_time']."',
										`j_date_place`    = '".$r['j_date_place']."'
										
								WHERE `public_defence_user`.`id_user` = '".self::isSession()."';");
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB UPDATE # 4536856856'.$e->getMessage()); return false; }
}

public function  publicDefenceInsert($r) {
	 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `public_defence_user` () 
								VALUES ('".$this->guid()."',
									'".self::isSession()."',
									'".$r['title_of_thesis']."',
									'".$r['date']."',
									'".$r['local_upstaires']."',
									'".$r['thesis_time']."',
									'".$r['thesis_place']."',
									'".$r['j_date_time']."',
									'".$r['j_date_place']."',
									'".self::staticFormatDate()."');");
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB INSERT # 5658656'.$e->getMessage()); return false; }
}
 
public function publicDefenceSelect($id_user = null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `public_defence_user`, `dir`
								WHERE `public_defence_user`.`id_user`='".($id_user == null ? self::isSession() : $id_user ) ."' 
								AND `public_defence_user`.`id_user`= `dir`.`id_user`");
		$query->execute();
		if($query->rowCount() > 0 ) {  
			$r = array('db' => 0);
			return array_merge($r, $query->fetch(PDO::FETCH_ASSOC));
		} else {
			$query = $dbh->prepare("SELECT * FROM `dir`
									WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user ) ."'");
			$query->execute();
			if($query->rowCount() > 0 ) { 
				$r = array('db' => 1 );
				return array_merge($r, $query->fetch(PDO::FETCH_ASSOC));
				 
			}
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 4563586'.$e->getMessage()); return false; }
}

public function myCotutelleSelect($id=null) {
	if(!self::isSession() && !is_null($id) ) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `cotutelle`  
								WHERE `cotutelle`.`id_user` = '".(is_null($id) ? self::isSession() : $id)."'");
		$query->execute();
		if($query->rowCount() > 0 ) {
			$res = $query->fetch(PDO::FETCH_ASSOC); 
			return $res;
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 7657678'.$e->getMessage()); return false; }
}
 
public function myCotutelleInsert($r) { 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `cotutelle` (
											`id_cotutelle`,
											`id_user`,
											`description`,
											`date`) 
								VALUES('{$this->guid()}',
											'".self::isSession()."',
											'".$r['description']."',
											'".self::staticFormatDate()."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 7657678'.$e->getMessage()); return false; }
}

public function myCotutelleUpdate($r=array()) { 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `cotutelle` SET 
										`description`  = '".$r['description']."',
										`date` = '".self::staticFormatDate()."'
								WHERE `cotutelle`.`id_user` = '".self::isSession()."' AND `cotutelle`.`id_cotutelle` = '".$r['id_cotutelle']."';");
		$query->execute();
		return true; 
	} catch(Exception $e) { print ('ERROR DB UPDATE # 78568686'.$e->getMessage()); return false; }
}

public function setTotalInfoSubmit($name_table=null, $test=null, $state=3, $id_user=null) {
	 
	if($id_user != null && $this->isID($id_user)) {
		$id_user = $id_user;
	} else {
		if(!self::isSession()) { 
			return false; 
		} else {
			$id_user = self::isSession();
		}
	}
	switch($test) {
	
		case'CONFERENCE_DATE':
			$sql = "SELECT * FROM `doc_training_conferences`  WHERE `id_user`='{$id_user}' AND `status`={$state}";
		break;
		
		case'CONFERENCE_LIST':
			$sql = "SELECT doc_training_conferences_list.num_credits2 FROM `doc_training_conferences_list` 
					LEFT JOIN `doc_training_conferences` 
					ON `doc_training_conferences`.`id_doc_training_conferences`= `doc_training_conferences_list`.`id_doc_training_conferences` 
					WHERE `doc_training_conferences_list`.`id_user`='{$id_user}' 
					AND `doc_training_conferences_list`.`status`={$state}";
		break;
		
		case'SEMINARS_PARTICIPER':
			$sql = "SELECT * FROM `doc_training_seminars` WHERE `id_user`='{$id_user}' and `function`=2 and `status`={$state}";
		break;
		
		case'SEMINARS_PRESENTER':
			$sql = "SELECT * FROM `doc_training_seminars` WHERE `id_user`='{$id_user}' and `function`=1 and `status`={$state}";
		break;
		
		case'TEACHING':
			$sql = "SELECT * FROM `doc_training_teaching_and_supervision` WHERE `id_user`='{$id_user}' and `type`=1 and `status`={$state}";
		break;
		
		case'OTHER':
			$sql = "SELECT * FROM `doc_training_teaching_and_supervision` WHERE `id_user`='{$id_user}' and `type`<>1 and `status`={$state}";
		break;
		
		case 'MY_DOCTORAL_TRAINING':
			$sql = "SELECT * FROM `doc_training_home` WHERE `id_user`='{$id_user}' and `radio`='{$state}'";
		break;
		
		default:
			if($name_table == null) 
				return false;
			else 
				$sql = "SELECT * FROM `{$name_table}` WHERE `id_user`='{$id_user}' and `status`={$state}";
	}
	 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			$this->info_total = $query->fetchAll(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 46547654'.$e->getMessage()); return false; }
}

public function getDataDoctoralTraining() {
	return $this->info_total;
}

public function getTotalInfoSubmit($test=null) {
	$total = 0; 
	if(is_array($this->info_total)) {
		foreach($r = $this->info_total as $k => $v) {
			$total += ($test != null ? $this->getDateResult(strtotime($r[$k]['date_from']), strtotime($r[$k]['date_to'])) : $r[$k]['num_credits2']);  	
		}
		$this->info_total = array();
		return $total;
	}
}

public function getDateResult($form, $to){
    $res = abs($form - $to); 
    $arr = array();
    $tmp = $res;
    $arr['second'] = $tmp % 60;
    $tmp = floor( ($tmp - $arr['second']) / 60 );
    $arr['minute'] = $tmp % 60;
    $tmp = floor( ($tmp - $arr['minute']) / 60 );
    $arr['hour'] = $tmp % 24;
    $tmp = floor( ($tmp - $arr['hour']) / 24 );
    $arr['day'] = $tmp;
    return (($arr['day'] != 0) ? $arr['day']+1 : 1 );
}
 
public function isFillingTable($name_table, $count=0) {
	if(sizeof($name_table) != 0) {
		if(!self::isSession()) { return false; }
			try {
				$dbh = ConnectDB::DB();
				$query = $dbh->prepare("SELECT * FROM `{$name_table[$count]}`  WHERE `id_user`='".self::isSession()."'");
				$query->execute();
				if($query->rowCount() > 0 ) { 
					$this->array_mult[$name_table[$count]] = $query->fetchAll(PDO::FETCH_ASSOC);
					$this->setFillingData($this->array_mult); 
					array_shift($name_table); 	
					$this->isFillingTable($name_table, $count++);

				} else {
					array_push($this->filling_table, $name_table[$count]);
					array_shift($name_table);	
					$this->isFillingTable($name_table, $count++);
				}
			} catch(Exception $e) { print ('ERROR DB SELECT # 466789686'.$e->getMessage()); return false; } 
	}
	return $this->filling_table;
}

public function deleteAllRows($tab=null, $id=null, $name_field=null) {
	if(!self::isSession()) {  self::destroy(); return false; }
	try {
		$dbh = ConnectDB::DB();
		if( $this->isID($id) ) {
			$s = "`id_user`='".self::isSession()."' and `{$name_field}` = '{$id}'";
		} else {
			$s = "`id_user`='".self::isSession()."'";
		}
		$query = $dbh->prepare("DELETE FROM `{$tab}` WHERE {$s}");
		$query->execute(); 
		return true;
	} catch(Exception $e) { print ('ERROR DB DELETE # 47657765'.$e->getMessage()); return false; }
}

public function testIfRowExists($tab, $test=null) {
	if(self::isSession()) {  
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SHOW columns FROM `{$tab}` WHERE field='id_user'");
		$query->execute();    
		if($query->rowCount() > 0 ) {  
			if($test == 'DELETE') { $this->deleteAllReg($tab); }
		} else {
			return false;
		}
	}	
}

public function showRowExists($tab, $test=null) {
	$dbh = ConnectDB::DB();
	$query = $dbh->prepare("SHOW columns  FROM `{$tab}`");
	$query->execute();    
	if($query->rowCount() > 0 ) {  
		return $query->fetchAll(PDO::FETCH_ASSOC); 
	} else {
		return false;
	}
}


public function deleteAllReg($tab) {
	if(self::isSession()) {  
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("DELETE  FROM `{$tab}` WHERE `id_user`='".self::isSession()."'");
			$query->execute(); 
		} catch(Exception $e) { print ('ERROR DB DELETE # 47657765 '.$e->getMessage()); }
	}	
}




public function docTrainingUpdateValidated($tab, $id_tab, $id, $validated) { 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `{$tab}` SET 
									`value` = '2',
									`num_credits2` = '".$validated."'
								WHERE `{$tab}`.`{$id_tab}` = '{$id}' AND `{$tab}`.`id_user`='".self::isSession()."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 456865'.$e->getMessage()); return false; }
 }
 /*
 public function iconStatusSubmit($id_user=null, $key_param1=null, $key_param2=null ) {
	$main = new Main();
	$img = null; 
	if(!$this->isID($id_user)) return null;
	if(is_array($r = $this->admSubmitSelect($id_user))) {
		if($r['id_admin'] == 0 && $r['state'] == 1 ) { $img = $main->getSrcImg($GLOBALS['sst']['icon']['square']); }
	} 
	return $img;
}
*/

function showIcones($id_user, $arr_img=array(), $val='icon', $test=null) { 
	
	$r['submitted'] = '';	
	for( $i = 1; $i <= 9; $i++) 
	if(is_array($submitted_img = $this->iconStatusSubmitted($i, $id_user)) ) {  
		$r['submitted'] = $submitted_img['icon'];
		break; 
	} 
		$new_deadline = $this->iconStatusSubmitted(21, $id_user);	
		$new_deadline = (isset($new_deadline['icon']) ? $new_deadline['icon'] :  '' );
		$r['deadline'] = $new_deadline;
		
	for( $i = 1; $i <= 9; $i++) {  
		if($i == 2 ) {
			$ico = $this->iconStatusSubmitted(2, $id_user); 
			$r['phd'][] = (isset($ico['icon']) ? $ico['icon'] : ''). (is_array($locked_img = $this->pHdLocked($i, $id_user, $arr_img[2])) ? $locked_img[$val] : ''); 
		} else if($i == 3) {
			$ico = $this->iconStatusSubmitted(3, $id_user);
			$r['phd'][] = (isset($ico['icon']) ? $ico['icon'] : ''). (is_array($locked_img = $this->pHdLocked($i, $id_user, $arr_img[3])) ? $locked_img[$val] : ''); 
		} else if($i == 4 )  {
			$ico = $this->iconStatusSubmitted(4, $id_user);
			$r['phd'][] = (isset($ico['icon']) ? $ico['icon'] : ''). (is_array($locked_img = $this->pHdLocked($i, $id_user, $arr_img[4])) ? $locked_img[$val] : ''); 
		} else {
			$r['phd'][] = (is_array($locked_img = $this->pHdLocked($i, $id_user)) ? $locked_img[$val] : ''); 
		}
	}	 
	 
	return $r;
}

public function deepCotutelle($id_user, $test, $ren='STR') {
	$main = new Main();
	$cotu = (is_array($this->myCotutelleSelect($id_user)) ? $this->myCotutelleSelect($id_user) : array());
	$f = $this->checkFolderInBD($id_user);
	
	$path = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE); 
	
	$count_dir = $main->countOpenDirectory($path.$f['dir']);
	
	switch($test) {
		case 0: // nothing
			return false;
		return;
		case 1: // (NO) no pdf no text
			if(is_numeric($count_dir) && ($count_dir > 0) ) { return false; }
			
			if((isset($cotu['description'])) && ((empty($cotu['description']))  )) {
				return ($ren == 'STR' ? $GLOBALS['sst']['select_cotutelle'][1] : true)  ;	 
			} 
		return false;
		case 2: // (IN PROGRESS) text , no pdf 
			if(isset($cotu['description']) ) {
				if((!empty($cotu['description'])) && (strlen($cotu['description']) > 3) ) {
					return ($ren == 'STR' ? $GLOBALS['sst']['select_cotutelle'][2] : true)  ;
				}
			}
			
		return false;
		case 3: // (SIGNED) just pdf
			if(is_numeric($count_dir) && ($count_dir > 0) ) {
				return ($ren == 'STR' ? 'SIGNED' : true) ; 
			} else if( (isset($cotu['description']))  && (!empty($cotu['description']) ) && (is_numeric($count_dir) && ($count_dir > 0))  ) {
				return ($ren == 'STR' ? $GLOBALS['sst']['select_cotutelle'][3] : true)  ;
			}	
		return false;
	}
	return false;
}

public function whatIsAvailableCotutelle($id_user) {
	$main = new Main();
	$cotu = (is_array($this->myCotutelleSelect($id_user)) ? $this->myCotutelleSelect($id_user) : array());
	$f = $this->checkFolderInBD($id_user);
	
	$path = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE); 
	
	$count_dir = $main->countOpenDirectory($path.$f['dir']);
	 
	if(isset($cotu['description'])) {
		if( (!empty($cotu['description'])) && ( is_numeric($count_dir) && ($count_dir > 0)) ) { 
			return  $GLOBALS['sst']['select_cotutelle'][3];
		} else if((empty($cotu['description'])) && ( is_numeric($count_dir) && ($count_dir > 0)) ) {
			return  $GLOBALS['sst']['select_cotutelle'][3];
		} else if((!empty($cotu['description'])) && ( is_numeric($count_dir) && ($count_dir <= 0)) ) {
			return  $GLOBALS['sst']['select_cotutelle'][2];
		} else {
			return  $GLOBALS['sst']['select_cotutelle'][1];
		}
	} else {
		return  $GLOBALS['sst']['select_cotutelle'][1];
	}
	
	 
	
}

public function getEachStatus($id_user, $phd=null, $ren='STR') { 
 
	$main = new Main();
	$page = new PageSST();
	switch($phd) {
		case 'ADMISSION':
				//select_status' => array(0 => '', 1 => 'In progress',2 => 'Submitted', 3 => 'Accepted',),
				// adm_home status 0 = submitted or re-open 
				// adm_home status 1 = in progress 
				// adm_home status 4 = accept
				// adm_home status 5 = blocked
			$admi_submit = $this->admSubmitSelect($id_user);
			$admissin_home = $this->admissionHomeCheck($id_user);
			
			if(!isset($admissin_home['state'])) {
				 return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][0] : 0);
			}
			
			if(isset($admi_submit['state'])) { 
				if(is_array($r = $this->status($id_user))) { 
					if($r['user_request'] == 1 && $r['position_phd'] == 1 ) { 
						return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][2] : 2);
					}
				}

				if($admissin_home['state'] == 0 && $admissin_home['date'] != 0 ) {
					return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][1] : 1);
				} else if($admissin_home['state'] == 0 && $admissin_home['date'] == 0 )  {
					 return ($ren == 'STR' ? 'RE-OPEN' : 1);
				} else if($admissin_home['state'] == 1) {
					return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][1] : 1);
				} else if($admissin_home['state'] == 4) {
					return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][3] : 3);
				} else if($admissin_home['state'] == 5) { 
					return ($ren == 'STR' ? 'BLOCKED' : 1);
				} else {
					return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][1] : 1);
				}
				
			} else {
				return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][1] : 1);
			}
		case'PRE-ADMISSION':
				//select_status' => array(0 => '', 1 => 'In progress',2 => 'Submitted', 3 => 'Accepted',),
				// adm_home status 1 = send 
				// adm_home status 2 = accept
				// adm_home status 3 = reopen  
			if(is_array($admissin_home = $this->admissionHomeCheck($id_user))) {
				  
				if( $admissin_home['employment'] == 'Preadmission') {
					if((int)$admissin_home['state'] == 1 ) {
						return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][2] : 2);
					} else if((int)$admissin_home['state'] == 2 ) {
						return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][3] : 3);
					} else if((int)$admissin_home['state'] == 3 ) {
						return ($ren == 'STR' ? 'RE-OPEN' : 0);
					} else if((int)$admissin_home['state'] == 5 ) {
						return ($ren == 'STR' ? 'BLOCKED' : 5);
					}
				}
			}	
		return ($ren == 'STR' ? $GLOBALS['sst']['select_status'][0] : 0);
		case 'CONFIRMATION':
			 
			$conf_submit = $this->confResultSelect($id_user);
			
			if(isset($conf_submit['select_confirm_state'])) {
				foreach($r = $GLOBALS['sst']['select_confirm_state'] as $k => $v) {
					if($conf_submit['select_confirm_state'] == $k) {
						  
						return ($ren == 'STR' ? $GLOBALS['sst']['select_confirm_state'][$k] : $k);
					}
				}
			} 	
		return ($ren == 'STR' ? $GLOBALS['sst']['select_confirm_state'][1] : 1);
		case 'PRIVATE DEFENCE':
			$priv_submit = $this->privateDefenceStatusSelect($id_user);
			if(isset($priv_submit['state'])) {
				foreach($r = $GLOBALS['sst']['select_private_defence_satate'] as $k => $v) {
					if($priv_submit['state'] == $k) {
						return ($ren == 'STR' ? $GLOBALS['sst']['select_private_defence_satate'][$k] : $k);
					}
				}
			} 
		return ($ren == 'STR' ? $GLOBALS['sst']['select_private_defence_satate'][1] : 1);
		case 'PUBLIC DEFENCE':
			$pabl_submit = $this->publicDefenceStatusSelect($id_user);
			if(isset($pabl_submit['state'])) {
				for($i = 0; $i <= 9; $i++){
					if($pabl_submit['state'] == $i) {
						return ($ren == 'STR' ? $GLOBALS['sst']['select_public_defence_status'][$pabl_submit['state']] : $i);
					}
				}
			}  
		return ($ren == 'STR' ? $GLOBALS['sst']['select_public_defence_status'][0] : 0);
		case 'MY COTUTELLE':
			$f = $this->checkFolderInBD($id_user);
			$path = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE);
			
			$count_dir = $main->countOpenDirectory($path.$f['dir']);
			if(is_numeric($count_dir) && ($count_dir > 0)  ) {
				return $path;
			}		 
		return 0; 
		case 'DOCTORAL TRAINING': 
			$result = '';
			$arrayobj = new ArrayObject();
			$val_doc_training = $page->doc_training->docTrainingMenu();

				$arrayobj->offsetSet('doc_training_conferences' ,           $val_doc_training['conferences']);
				$arrayobj->offsetSet('doc_training_conferences_list',       'Communications');
				$arrayobj->offsetSet('doc_training_seminars',                $val_doc_training['seminars']);
				$arrayobj->offsetSet('doc_training_teaching_and_supervision',$val_doc_training['teaching_and_supervisory']);
				$arrayobj->offsetSet('doc_training_courses',                 $val_doc_training['courses']);
				$arrayobj->offsetSet('doc_training_journal_papers',          $val_doc_training['journal_papers']);
				$iterator = $arrayobj->getIterator();
				while ( $iterator->valid() ) {
					foreach($GLOBALS['sst']['status_name'] as $k => $v ) {
						$this->info_total = null;
						$this->setTotalInfoSubmit($iterator->key(), null, $k, $id_user);
						if(is_array($this->info_total)) { 
							if($k == 1 || $k == 4) continue;
								if(!empty($k))
							$result .= '<p style="margin-left:10px; padding:1px;">' .
												$iterator->current(). 
												' : <span style="color:green;">' . $v . ' </span></p>'."\n";
						}
					}
					$iterator->next();	
				}
		return $result;
	}
}

/* (VAR post it's string) and (VAR test it's number page for example MY ACADEMIC CV IS NUMBER 1) */
public function checkingPermission($pos=null, $test=null) {

	$main = new Main();					
	$reg = '/(SUBMITTED|ACCEPTED|REJECT)/i';
	
	if( $main->authenticity() ) {
	
		return null;
		
	} else {
		
		switch($pos) {
			
			case'ADMISSION': // block all upload
				 
				if(Supervisor::isSessionSupervisor()) { return 2; }
				if( !is_null( $main->specialAccounts($test))) { return  2; }
				
				$match = $this->iconStatusSubmitted(1, ConnectDB::isSession(), 'Preadmission');
				if (preg_match($reg, $match['action'])) { return  2;  }
					
				$match =  $this->iconStatusSubmitted(1, ConnectDB::isSession(), 'Admission');
				if (preg_match($reg, $match['action'])) { return  2; }
										
			break; 
			case'ACADEMIC': // block all fields
				
				if(Supervisor::isSessionSupervisor()) { return true; }
				
				if( !is_null( $main->specialAccounts($test))) { return  true; }
				
				$match = $this->iconStatusSubmitted(1, ConnectDB::isSession(), 'Preadmission');
				if (preg_match($reg, $match['action'])) { return  true; }
					
				$match =  $this->iconStatusSubmitted(1, ConnectDB::isSession(), 'Admission');
				if (preg_match($reg, $match['action'])) { return  true;  }
					
			break;
				
		}					 
				
	}
	return null;						
}
					 
public function htmlStatusSubmitted($page, $main, $json) {

	if(!is_object($json) ) return false;
	
	$d = (
		preg_match('/[a-zA-Z]/', $json->date) ? 
		$main->getDateDigital($json->date) : 
		$main->settingDate($json->date)
	);
									
	$html = ' <div id="'.$json->id.'" style="display:none;">
			<div style="margin:10px;">
				<b>Type: </b> <span style="color:red;">'.$json->type.'</span> <br>
				<b>Last action: </b> <b style="color:#3A93C6;"> '.$json->action.' </b> <br>
				<b>Date: </b>' . $d .'<br> 
				'.(
					isset($json->new_deadline) ?
						"<b>". $page->showText('my_phd_confirmation_planning_newdeadline'). "</b> {$json->new_deadline} <br>"  : 
						''  
					) .'
				'.(
					isset($json->date_board_validated) ?
						"<b>". $page->showText('private_defance_submit_date_validated'). "</b> {$json->date_board_validated} <br>" :
						''
				) .'
 
			</div>
	</div> ';
		
	return $html;

}

public function iconStatusSubmitted($pos, $id_user=null, $test=null) {

	if(Supervisor::isSessionSupervisor()) { return null;}
	
	$main = new Main();
	$page = new PageSST();
	 
	$id_user = ($id_user == null ? self::isSession() : $id_user); 
	if(!$this->isID($id_user)) return null; 
	
	 
	
	switch($pos) {
		case 1:
			$rand = $this->guid(); 
			$sub_status = $this->admSubmitSelect($id_user);  
			
			if(is_array($admissin_home = $this->admissionHomeCheck($id_user))) {
			
				$dlg = '{"id" : "'.$rand.'", "type" : "'.$admissin_home['employment'].'", "action" : "", "date" : ""}';
				$node = $main->jsonValidate($dlg);
					
				if( ($admissin_home['employment'] == 'Preadmission' && is_null($test)) || 
									( $admissin_home['employment'] == 'Preadmission' && strtolower($test) == 'preadmission' ) ) {
									
					$r['page'] = ' ';		
						
					if($admissin_home['state'] >= 1 ) {
						
						if($admissin_home['state'] == 1) {
							
							$r['action'] = 'SUBMITTED'; 
								
							$node->action = $r['action'];
							$node->date = $sub_status['date'];
									
							$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
							$r['msg']  = $page->showText('pre-addmission_title_sended') ;
							$r['date'] = $main->datewithoutSpace($sub_status['date']);
							$r['icon'] = $main->getSrcImg(
												$GLOBALS['sst']['icon']['square_pre'], 
												null, 
												null,
												'onclick="return getHelp(\''.$rand.'\', event, \'PRE-ADMISSION APPLICATION\');"'
										) . $r['html'] ;
													
						} else if($admissin_home['state'] == 2) {
							
							$r['action'] = 'ACCEPTED'; 
										
							$node->action = $r['action'];
							$node->date = $admissin_home['date_preadmission'];
								
							$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
							$r['msg']  = $page->showText('pre-addmission_title_accepted') ;
							$r['date'] = $main->datewithoutSpace($admissin_home['date_preadmission']); 
							$r['icon'] = $main->getSrcImg(
												$GLOBALS['sst']['icon']['square_accept'],
												null,
												null,
												'onclick="return getHelp(\''.$rand.'\', event, \'PRE-ADMISSION APPLICATION\');"' 
										) . $r['html'] ;
							
						} else if($admissin_home['state'] == 3) {
								 
							$r['action'] = 'RE-OPENED'; 
								
							$node->action = $r['action'];
							$node->date = $admissin_home['date'];
								
							$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
							$r['msg']  = $page->showText('pre-addmission_title_cancelled') ;
							$r['date'] = $main->datewithoutSpace($sub_status['date']);
							$r['icon'] = $main->getSrcImg(
												$GLOBALS['sst']['icon']['square_cancel'],
												null,
												null,
												'onclick="return getHelp(\''.$rand.'\', event, \'PRE-ADMISSION APPLICATION\');"'
										) . $r['html'] ;
								
						} else if($admissin_home['state'] == 5) {
							
							$r['action'] = 'REJECT'; 
								
							$node->action = $r['action'];
							$node->date = $sub_status['date'];
								
							$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
							$r['msg']  = $page->showText('my_phd_admission_warning_reject') ;
							$r['date'] = $main->datewithoutSpace($sub_status['date']);
							$r['icon'] = $main->getSrcImg(
												$GLOBALS['sst']['icon']['locked32'],
												null,
												null,
												'onclick="return getHelp(\''.$rand.'\', event, \'PRE-ADMISSION REJECT\');"'
										). $r['html'] ;
											
						} 
						return $r; 
					}
						
				}  else if( ($admissin_home['employment'] == 'Admission' && is_null($test)) || 
										( $admissin_home['employment'] == 'Admission' && strtolower($test) == 'admission' ))  {
						
					$r['page'] = ' ';

					if($admissin_home['state'] == 5) {
						
						$r['action'] = 'REJECT';  
							
						$node->action = $r['action'];
						$node->date = $sub_status['date'];
									
						$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
						$r['msg'] = $page->showText('my_phd_admission_warning_reject') ;							
						$r['date'] = $main->datewithoutSpace($sub_status['date']);
						$r['icon'] = $main->getSrcImg(
											$GLOBALS['sst']['icon']['locked32'],
											null,
											null,
											'onclick="return getHelp(\''.$rand.'\', event, \'ADMISSION APPLICATION\');"'
									) .$r['html'] ;
						$r['status'] = 5;
						return $r; 
							
					} else if($admissin_home['state'] == 4) {
						
						$r['action'] = 'ACCEPTED'; 
							
						$node->action = $r['action'];
						$node->date = $sub_status['date'];
									
						$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
						$r['msg'] = $page->showText('my_phd_admission_warning_accepted_1') ;
						$r['date'] = $main->datewithoutSpace($sub_status['date']);
						$r['icon'] = $main->getSrcImg(
											$GLOBALS['sst']['icon']['square_accept'],
											null,
											null,
											'onclick="return getHelp(\''.$rand.'\', event, \'ADMISSION APPLICATION\');"'
									) .$r['html'] ;	
						$r['status'] = 4;
						return $r; 
						
					}
				}
			} 
			
			if(is_array($r = $this->status($id_user))) {
				if($r['user_request'] == 1 && $r['position_phd'] == 1 ) {
				
					$r['page'] = ' ';
					$r['action'] = (($this->isID($r['admin_confirm'])) ? 'ACCEPTED' : 'SUBMITTED') ; 
		
					$node->action = $r['action'];
					$node->date = $r['user_date_request'];
									
					$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);

					$r['msg']  = $r['action'];
					$r['date'] = $main->datewithoutSpace($r['user_date_request']);
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon']['square'],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'ADMISSION APPLICATION\');"'
								) . $r['html'] ;
					$r['status'] = 2;
					return $r; 
				}  
			} 
				
		return null;
		case 2:  
		
			$rand = $this->guid();
			if(is_array($r = $this->status($id_user))) { 
			
				if(($r['user_request'] == 1 && $r['position_phd'] == 2) || ($r['user_request'] == 0 && $r['position_phd'] == 3) ) { 
				
					$dlg = '{"id" : "'.$rand.'", "type" : "Confirmation", "action" : "", "date" : ""}';
					
					$data = $this->confResultSelect($id_user);

					if($data['select_confirm_state'] >= 1 ) { 
						$r['date'] = $data['date_of_confirm'];
					}
												
					$action = $GLOBALS['sst']['select_confirm_state'][$data['select_confirm_state']];					

					$node = $main->jsonValidate($dlg);
					$node->action = $action;
					$node->date = $data['date_submitted'];
					
					$r['page'] = ' ';
					$r['action'] = ( $data['select_confirm_state'] > 1 ? 'SUBMITTED' : '' );					
					$r['html'] = $this->htmlStatusSubmitted($page,$main, $node);
					$r['msg']  = $page->showText('my_phd_confirmation_result_date_confirm');
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon']['square'],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'SUBMITTED CONFIRMTION\');"'
								) . $r['html'] ;
					return $r;  
				}
			} 
			
		return null;
		case 3:
		
			$rand = $this->guid();
			
			if(is_array($r = $this->status($id_user))) {
				 
				if($r['user_request'] == 1 && $r['position_phd'] == 3 ) {
				
					$dlg = '{
							"id" : "'.$rand.'",
							"type" : "'.$page->showText('header_title_private_defence_status').'",
							"action" : "",
							"date" : "",
							"date_board_validated" :""
					}';
					
					$data = $this->privateDefenceStatusSelect($id_user);
					
					if($data['state'] >= 1 ) { 					
						$r['date'] = (
									preg_match('/[a-zA-Z]/', $data['date_passed']) ? 
									$main->getDateDigital($data['date_passed']) : 
									$main->settingDate($data['date_passed'])	
						);
					}	

					$action = $GLOBALS['sst']['select_private_defence_satate'][$data['state']];	
					 
					$node = $main->jsonValidate($dlg);
					$node->action = $action;
					$node->date = $data['date_submitted'];
					$node->date_board_validated = $main->settingDate($data['date_validated']);
					
					$r['page'] = ' '; 
					$r['action'] = ( $data['state'] > 1 ? 'SUBMITTED' : '' )  ; 					
					$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);
					$r['msg']  = $action;

					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon']['square'],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'SUBMITTED PRIVATE DEFENCE\');"'
								) . $r['html'] ; 
					return $r; 
				}
			} 
			
		return null;
		case 4:
			
			$rand = $this->guid();
			if(is_array($r = $this->status($id_user))) {
			
				if($r['position_phd'] == 4 ) {
				
					if(is_array($data = $this->publicDefenceSelect($id_user) )) {
						if($data['db'] == 1) { return false; }
						
						$dlg = '{
								"id" : "'.$rand.'",
								"type" : "'.$page->showText('header_title_public_defence_form').'",
								"action" : "",
								"date" : ""
						}';
		
						$r['page'] = ' ';		
						$r['action'] = 'SUBMITTED';
						 
						$node = $main->jsonValidate($dlg);
						$node->action = $r['action'];
						$node->date = $data['date'];

						$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);		
						$r['date'] = $data['date']; 
						$r['icon'] = $main->getSrcImg(
											$GLOBALS['sst']['icon']['pd'],
											null,
											null,
											'onclick="return getHelp(\''.$rand.'\', event, \'PUBLIC DEFENCE\');"'
						) . $r['html'] ; 
						return $r; 
					}
				} else return '';
			} 
			
		return ''; 
		case 21:
		
			$rand = $this->guid();
			$status = $this->confPlanningStatusSelect(null, $id_user);
			
			if(isset($status)) {
			
				if($status['status'] == 1) {
				
					$dlg = '{"id" : "'.$rand.'", "type" : "Confirmation", "action" : "", "date" : "", "new_deadline" : ""}';
					
					$data_planning = $this->confPlanningSelect($id_user);
					
					$r['page']   = ' '; 
					$r['action'] = 'SUBMITTED';
					$r['date']  = (	
								preg_match('/[a-zA-Z]/', $data_planning['date']) ? 
								$main->getDateDigital($data_planning['date']) : 
								$main->settingDate($data_planning['date'])
					);
					
					$node = $main->jsonValidate($dlg);
					$node->action = $r['action'];
					$node->date = $data_planning['date'];
					$node->new_deadline = $main->settingDate($data_planning['deadline']);
							
					$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);
					$r['msg'] ='';
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon']['deadline'],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'CONFIRMATION NEW DEADLINE\');"'
								) . $r['html'] ; 
					return $r;
				}		
			}
			
		return ;
	}
	
	return null;
	
}

public function ispHdLocked($id_user) {
	$admin = new AdminAuthority( );  
	if(AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple() ) {
		return true;
	}
	$i = 0;
	do {
		if(is_array($locked = $this->pHdLocked($i, $id_user))) {
			if(isset($locked['icon']) ) {
				 
				if($i == 4 ) {
					if(isset($locked['public_defence']) ) {
						if($locked['public_defence'] == 4 ) {
							self::clearSessionGUID();
							print ('<span style="display:none;">ERROR DB SELECT # 6019 </span>'); return false;
						} else { return true;  }
					} else { return true; }
					
				} else {
					self::clearSessionGUID();
					print ('<span style="display:none;">ERROR DB SELECT # 6017 </span>'); return false;
				} 
			}	 
		}
		$i++;
	} while($i < 10);
	return true;
} 

public function pHdLocked($pos, $id_user=null, $name_img='locked22') {

	if(class_exists('Supervisor') ){
		if(Supervisor::isSessionSupervisor()) { return null;}
	}
	
	$main = new Main();
	$page = new PageSST();
	
	$img = null;   
	$id_user = ($id_user == null ? self::isSession() : $id_user); 
	
	switch($pos) {
 		case 2:
		
			$rand = $this->guid();
			if(!$this->isID($id_user)) return null;
			
			if(is_array($data = $this->confResultSelect($id_user) ) ) {
				if($data['select_confirm_state'] == 5) {
					
					$dlg = '{
							"id" : "'.$rand.'",
							"type" : "'.$page->showText('header_title_confirmation_result').'",
							"action" : "", "date" : ""
					}';
					
					$node = $main->jsonValidate($dlg);
					$node->action = $GLOBALS['sst']['select_confirm_state'][$data['select_confirm_state']];
					$node->date = $data['date_submitted'];
					
					$r['page'] = '';
					$r['action'] = 'REJECT';  
					$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);
					$r['msg'] = $GLOBALS['sst']['select_confirm_state'][$data['select_confirm_state']];				 
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon'][$name_img],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'LOCKED CONFIRMATION\');"'
								) . $r['html'] ; 
					return $r; 
				}
			}
			
		return null;
		case 3:
		
			$rand = $this->guid();
			if(!$this->isID($id_user)) return null;
			
			if(is_array($data = $this->privateDefenceStatusSelect($id_user) ) ) {
				if($data['state'] == 7) {
					
					$dlg = '{
							"id" : "'.$rand.'",
							"type" : "'.$page->showText('header_title_private_defence_status').'",
							"action" : "",
							"date" : ""
					}';
					
					$node = $main->jsonValidate($dlg);
					$node->action = $GLOBALS['sst']['select_private_defence_satate'][$data['state']];
					$node->date = $data['date_submitted'];
					
					$r['page'] = '';
					$r['action'] = 'REJECT';  
					$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);
					$r['msg'] = $r['action']; $GLOBALS['sst']['select_private_defence_satate'][$data['state']];			 
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon'][$name_img],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'LOCKED PRIVATE DEFENCE\');"'
								) . $r['html'] ;				
					return $r; 
				}
			}
			
		return null;
		case 4:
		
			$rand = $this->guid();
			if(!$this->isID($id_user)) return null;
			
			if(is_array($data = $this->publicDefenceStatusSelect($id_user) ) ) { 
				if($data['state'] >= 1) {
					
					$dlg = '{
							"id" : "'.$rand.'",
							"type" : "'.$page->showText('header_title_public_defence_status').'",
							"action" : "",
							"date" : ""
					}';
					
					$s = substr( $name_img, 0, 1 );
					$name_img = ($s == 'f') ? $name_img : 'final';

					$node = $main->jsonValidate($dlg);
					$node->action = $GLOBALS['sst']['select_public_defence_status'][$data['state']];
					$node->date = $data['date_submitted'];
					
					$r['page'] = '';
					$r['action'] = 'SUBMITTED'; 					
					$r['html'] = $this->htmlStatusSubmitted($page, $main, $node);
					$r['msg'] = $GLOBALS['sst']['select_public_defence_status'][$data['state']];			 
					$r['public_defence'] = ($data['state'] == 4 ? 4 : 0);
					$r['icon'] = $main->getSrcImg(
										$GLOBALS['sst']['icon'][$name_img.$data['state']],
										null,
										null,
										'onclick="return getHelp(\''.$rand.'\', event, \'FINAL PUBLIC DEFENCE\');"'
								).$r['html'] ;				
					return $r; 
				}
			}
			
		return null;
	}
	return null;
}

// DATETIME
public function status($id=null) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `status` 
								WHERE `id_user` = '".($id == null ? self::isSession() : $id)."' 
								ORDER BY `date_time` DESC");
		$query->execute();
		if($query->rowCount() > 0 ) {  
			return $query->fetch(PDO::FETCH_ASSOC); 
		} else {
			return false;
		}
	} catch(Exception $e) { print ('ERROR DB SELECT # 46646'.$e->getMessage()); return false; }
}
 
public function checkMailIdDB($tab, $row, $val) {
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `{$tab}` WHERE `{$tab}`.`{$row}` = '{$val}'");
		$query->execute();
		if($query->rowCount() <= 0  ) {  
			return true;
		} else {
			return false;
		}
	}  catch(Exception $e) { print ('ERROR DB SELECT # 566556545 '.$e->getMessage()); return false; }
}

public function wpUserActivate($r) { 
	if(!self::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `wp_user` SET 
								`delete`    = '1'
								WHERE `wp_user`.`id_wp_user` = '".$r['wp_id']."';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 467677 '.$e->getMessage()); return false; } 
}	

public function wpUserDelete($id, $val=0) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `wp_user` SET 	
											`delete` = '".$val."'
								WHERE `wp_user`.`id_wp_user` = '".$id."'");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 476765 '.$e->getMessage()); return false; }
}

public function wpUserChangePWD($id, $pwd, $mail, $r=array()) {
	$main = new Main();
	$r['wp'] = 'WP'; 
	$r['mail'] = $mail;
	$r['new_pwd'] = $pwd;
	if($main->sendMailFromSST('OVERWRITE_PWD_WP', $r)) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("UPDATE `wp_user` SET 	
											`pwd` = '".$pwd."',
											`mail_sended` = '1'
								WHERE `wp_user`.`id_wp_user` = '".$id."'");
			$query->execute();
			return true;
		} catch(Exception $e) { print ('ERROR DB UPDATE # 756785 '.$e->getMessage()); return false; }
	} else {
		return false; 
	}
}

public function wpUserUpdate($r) {
	$r['wp'] = 'WP'; 
	$r['email'] = $r['wp_mail'];
	try {
		$dbh = ConnectDB::DB();
		$pwd = ($r['wp_passwd'] != -1 ? "`pwd`       = '".$r['wp_passwd']."'," : null);
		
		$box = ($r['wp_box'] != '0'  ? "`wp_box`       = '".$r['wp_box']."'," : null);
		 
		$query = $dbh->prepare("UPDATE `wp_user` SET 
											{$box}
											`lastname`  = '".$r['wp_lname']."',
											`firstname` = '".$r['wp_fname']."',
											`tel`       = '".$r['wp_mobile']."',
											`email`     = '".$r['wp_mail']."',
											{$pwd}
											`text`      = '".$r['wp_txt_area']."',
											`pw_adm`      = '".$r['wp_adm']."',
											`mail_sended` = '0'
								WHERE `wp_user`.`id_wp_user` = '".$r['wp_id']."' AND `wp_user`.`delete`='1';");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB UPDATE # 45678967896 '.$e->getMessage()); return false; }
}

//sendMailToUser CREATE_USER_WP
public function wpUserInsert($r) {
	$r['e-mail'] = $r['wp_mail'];
	$main = new Main();
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `wp_user` (
											`id_wp_user`,
											`wp_box`,
											`lastname`,
											`firstname`,
											`tel`,
											`email`,
											`pwd`,
											`text`,
											`pw_adm`,
											`mail_sended`,
											`last_visited`,
											`date_created`
											) 
								VALUES('{$this->guid()}',
											'".$r['wp_box']."',
											'".$r['wp_lname']."',
											'".$r['wp_fname']."',
											'".$r['wp_mobile']."',  
											'".$r['wp_mail']."',
											'".$r['wp_passwd']."',
											'".$r['wp_txt_area']."',
											'".$r['wp_adm']."',
											'".($main->sendMailFromSST('CREATE_USER_WP', $r) ? '1' : '0' )."',
											'".self::staticFormatDate()."',
											'".self::staticFormatDate()."');");
		$query->execute();
		return true;
	} catch(Exception $e) { print ('ERROR DB INSERT # 75675785'.$e->getMessage()); return false; }
}
 
public function wpUserSelect($id=null) { 
	$admin = new AdminAuthority( );  
	$op = "  ";  // is_null($id) ?  " WHERE `wp_user`.`delete` <> '0'" : " AND `wp_user`.`delete` <> '0'";
	$su = (AdminAuthority::isSessionAdminSudo()  ? '' : $op);
	try {
		$dbh = ConnectDB::DB();
		if(is_null($id)) {
			$query = $dbh->prepare("SELECT * FROM `wp_user` {$su} ");
		} else {
			if($this->isID($id)) {
				$query = $dbh->prepare("SELECT * FROM `wp_user` WHERE `wp_user`.`id_wp_user` = '{$id}' {$su}");
			} else {
				print ('ERROR DB SELECT # 5245454 ');
				return false;
			}
		}
		$query->execute();
		return (is_null($id) ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC));
	}  catch(Exception $e) { print ('ERROR DB SELECT # 58775 '.$e->getMessage()); return false; }
}
 
public function inserUserSearch($r) {
	try {
		$id = $this->guid();
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO `search_user` (
											`id_search_user`,
											`id_admin`,
											`val_field`,
											`data`,
											`date`) 
								VALUES('{$id}',
											'".$r['id_admin']."',
											'".$r['val_field']."',
											'".$r['data']."',
											'".self::staticFormatDate()."');");
		$query->execute();
		return $id;
	} catch(Exception $e) { print('ERROR BD INSERT # 456656'. $e->getMessage()); return false; }	
}
function objArr($iterator) {
    while ( $iterator -> valid() ) {
        if ( $iterator -> hasChildren() ) {
            objArr($iterator -> getChildren());
        }
        else {
            print ($iterator -> key() . ' : ' . $iterator -> current() .PHP_EOL);   
        }
        $iterator -> next();
    }
} 

public function searchSupervisoryPanel($tab_name, $id_user=null, $value, $get_name=null, $deep=0) { 
	if(!self::isSession()) { return false; } 
	try {
		$dbh = ConnectDB::DB(); 
		$sql = "SELECT * FROM `{$tab_name}` WHERE `id_user`= '{$id_user}' AND `{$get_name}`='{$value}' ";
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {
			if($get_name != null) {
				$r = $query->fetch(PDO::FETCH_ASSOC); 
				return $r['lastname'];
			} else {
				return $query->fetch(PDO::FETCH_ASSOC); 
			}
		} else {
			if($deep == 1) {
				return false;
			} else {
				$this->searchSupervisoryPanel('adm_supervisory_panel', $id_user, $value, $get_name, 1); 
			}
		}
	} catch(Exception $e) { print('ERROR DB SELECT # 60465464 '.$e->getMessage()); return false; }
}


public function addQueryDate($r=array(), $key, $obj, $obj_val1, $obj_val2, $pos=1, $item=null, $ref='PRE-ADMISSION') {
 

	if(isset($_GET['mng']))  { 
		if($_GET['mng'] == 'show_list' ) {  return; }
	}
	 
	//print_r($r);

	/*
	$r[$key] = $this->addQueryDate($r, $key, $obj, 'pre_admission1',   'pre_admission2',   1, 'preadmission', 'PRE-ADMISSION');
	$r[$key] = $this->addQueryDate($r, $key, $obj, 'admission1',       'admission2',       1, 'admission',     'ADMISSION');
	*/
	
	 
	 
	if((!empty($obj->{$obj_val1})) && (!empty($obj->{$obj_val2}))) {  
		 
		$date = $this->iconStatusSubmitted($pos, $r[$key]['id_user'], $item); 
		 
		if(isset($date['date']) ) {
			
			if((strtotime($date['date']) >= strtotime($obj->{$obj_val1})) && (strtotime($date['date']) <= strtotime($obj->{$obj_val2}))) {
				 
				if($pos == 4) {
					$r[$key][$obj_val1] = $obj->{$obj_val1}; 			
					$r[$key][$obj_val2] = $obj->{$obj_val2}; 
					return $r[$key];
				}	
				$v = $this->getEachStatus($r[$key]['id_user'], $ref, 'NUM');  
				if($v <= 0) {
					$r[$key][0] = FALSE;
				} else {    
					$r[$key][$obj_val1] = $obj->{$obj_val1};
					$r[$key][$obj_val2] = $obj->{$obj_val2}; 
				}
			} else {
				$r[$key][0] = FALSE;
			}
		} else { $r[$key][0] = FALSE; }
		
	} else if((!empty($obj->{$obj_val1})) && (empty($obj->{$obj_val2}))) {    // once  
	 
		$date = $this->iconStatusSubmitted($pos, $r[$key]['id_user'], $item);
		if(isset($date['date']) ) {  
			 //echo $obj->{$obj_val1} . ' +++ ' . $date['date'] . '<br/>' ;
			if(strtotime($obj->{$obj_val1}) == strtotime($date['date'])) {
			
				if($pos == 4) { 
				 
					$r[$key][$obj_val1] = $obj->{$obj_val1}; 
					return $r[$key]; 
				}
				$v = $this->getEachStatus($r[$key]['id_user'], $ref, 'NUM');  
				if($v <= 0) {
					$r[$key][0] = FALSE;
				} else {
					// this is once 
				 
					$r[$key][$obj_val1] = $obj->{$obj_val1};
				}
			} else {
				$r[$key][0] = FALSE;
			}
		} else { $r[$key][0] = FALSE; }
	} else if(!empty($obj->{$obj_val2}) && (empty($obj->{$obj_val1}))) { 
		$date = $this->iconStatusSubmitted($pos, $r[$key]['id_user'], $item); 
		if(isset($date['date']) ) {
			if(strtotime($obj->{$obj_val2}) == strtotime($date['date'])) {
				if($pos == 4) { 
					$r[$key][$obj_val2] = $obj->{$obj_val2};
					return $r[$key]; 
				}			
				$v = $this->getEachStatus($r[$key]['id_user'], $ref, 'NUM');
				if($v <= 0) {
					$r[$key][0] = FALSE;
				} else {
					$r[$key][$obj_val2] = $obj->{$obj_val2};
				}
			} else {
				$r[$key][0] = FALSE;
			}
		} else { $r[$key][0] = FALSE; }
	} 
	 
	return (!empty($r[$key]) ? $r[$key] : NULL);
}

//search user 
public function searchAllUsers($obj, $arr_memory=null ) { 
	 
	$patterns = array('/\s+/', '/"+/', '/%+/');
	$replace = array(' ');
	 
	$main = new Main();
	if(!is_object($obj)) return false;
	 
	$s = '';
	if(!empty($obj->{'keyword'})) {
		$last_name = preg_replace($patterns, $replace, urldecode($obj->{'keyword'}));
		$s .= "`last_name` LIKE '".$this->quoteIdent($this->encodeToUtf8($last_name))."%' AND";
	} if(!empty($obj->{'fname'})) {
		$first_name = preg_replace($patterns, $replace, urldecode($obj->{'fname'}));
		$s .= "`first_name` LIKE '".$this->quoteIdent($this->encodeToUtf8($first_name))."%' AND";
	} if (!empty($obj->{'finance_thesis'})) { 
		$thesis = preg_replace($patterns, $replace, urldecode($obj->{'finance_thesis'}));
		$s .= "`thesis` LIKE '%".$this->quoteIdent($this->encodeToUtf8($thesis))."%' AND";
	} if(!empty($obj->{'select_phd'})) {
		$phd = preg_replace($patterns, $replace, urldecode($obj->{'select_phd'}));
		$s .= "`phd` LIKE '".$phd."' AND";
	} if(!empty($obj->{'select_sciences'})) {
		$sciences = preg_replace($patterns, $replace, urldecode($obj->{'select_sciences'}));
		$s .= "`sciences` LIKE '".$sciences."' AND";
	} 
	
	$end = substr($s, strlen($s)-3,  3);
	if($end == 'AND') { $s = substr($s, 0, strlen($s)-3); }
	if(!empty($s)) { $s = ' WHERE '.$s; }
	 
	try {
	
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `registration` {$s}";
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0  ) {  
			$r = $query->fetchAll(PDO::FETCH_ASSOC);
			$j = 0; 
			foreach($r as $key => $val) {  
		   
				if(!empty($obj->{'inst'})) {    
					$h = $this->instituteSelectSelected($r[$key]['id_user'], null );
					$name_inst = $this->instituteSelect($h['id_institute']); 
					if(isset($name_inst['institute'])) {
						if($name_inst['institute'] == $obj->{'inst'}) {  
							$r[$key]['inst'] = $name_inst['institute'];
						} else {
							$r[$key][0] =  FALSE;
						}
					} else { 
						$r[$key][0] =  FALSE;
					}
				} else {
					$h = $this->instituteSelectSelected($r[$key]['id_user'], null);
					$name_inst = $this->instituteSelect($h['id_institute']); 
					$r[$key]['inst'] = isset($name_inst['institute']) ? $name_inst['institute'] : -1;
				}
				
				// keyword_supervisor
				$sup = trim($this->searchSupervisoryPanel('my_supervisory_panel', $r[$key]['id_user'], urldecode($obj->{'keyword_supervisor'}), 'lastname'));
				$sup = (empty($sup) ? 0 : $sup);
				if(!empty($obj->{'keyword_supervisor'})) {
					if(($sup === urldecode($obj->{'keyword_supervisor'}))) {
						$r[$key]['keyword_supervisor'] = $obj->{'keyword_supervisor'};
					} else {
						$r[$key][0] = FALSE;
					} 
				} else {
					$r[$key]['keyword_supervisor'] = -1;
				}
				
				// dates strtotime 
				 
					// this is to find simply the date not more ;
					$r[$key] = $this->addQueryDate($r, $key, $obj, 'pre_admission1',   'pre_admission2',   1, 'preadmission', 'PRE-ADMISSION');
					$r[$key] = $this->addQueryDate($r, $key, $obj, 'admission1',       'admission2',       1, 'admission',     'ADMISSION');
					$r[$key] = $this->addQueryDate($r, $key, $obj, 'confirmation1',    'confirmation2',    2,  null, 'CONFIRMATION');
					$r[$key] = $this->addQueryDate($r, $key, $obj, 'private_defence1', 'private_defence2', 3,  null, 'PRIVATE DEFENCE');
					$r[$key] = $this->addQueryDate($r, $key, $obj, 'public_defence1',  'public_defence2',  4,  null, 'PUBLIC DEFENCE');
				 
				  
				// public defence
				if(!empty($obj->{'admin_search_user_status_public_defence'} ) || ($obj->{'admin_search_user_status_public_defence'} != 0))  {
					 
					if($obj->{'admin_search_user_status_public_defence'} == 'ALL_PUBLIC') {
						$pub_def = $this->getEachStatus($r[$key]['id_user'], 'PUBLIC DEFENCE', 'NUM');
						if($pub_def == 1 || $pub_def == 0) {
							$r[$key][0] =  FALSE;
						} else {
							$r[$key]['admin_search_user_status_public_defence'] = $pub_def;
						}
					} else {
						$pub_def = $this->getEachStatus($r[$key]['id_user'], 'PUBLIC DEFENCE', 'NUM'); 
						
						if($obj->{'admin_search_user_status_public_defence'} == $pub_def) {
							$r[$key]['admin_search_user_status_public_defence'] = $pub_def;
						} else {
							$r[$key][0] =  FALSE;
						}
						$r[$key]['admin_search_user_status_public_defence'] = $obj->{'admin_search_user_status_public_defence'};
					}					
				} else {
					$r[$key]['admin_search_user_status_public_defence'] = -1;
				}
				
				/*	
				$arrayobj = new ArrayObject(); 			 
				$arrayobj->offsetSet('admin_search_user_status_pre_admission', $this->getEachStatus($r[$key]['id_user'], 'PRE-ADMISSION', 'NUM'));	
				$arrayobj->offsetSet('admin_search_user_status_admission',  1);
				$arrayobj->offsetSet('admin_search_user_status_confirmation', $this->getEachStatus($r[$key]['id_user'], 'CONFIRMATION', 'NUM'));
				$arrayobj->offsetSet('admin_search_user_private_defence',$this->getEachStatus($r[$key]['id_user'], 'PRIVATE DEFENCE', 'NUM'));
				
				$iterator = $arrayobj->getIterator();
				while ( $iterator->valid() ) { 
					if( (isset($obj->{$iterator->key()})) && ($obj->{$iterator->key()} != 0)) {
						if($iterator->current() != $obj->{$iterator->key()} ) { 
							$r[$key][0] =  FALSE;
						} else {
							$r[$key][$iterator->key()] = $obj->{$iterator->key()};
						}
					} else {
						$r[$key][$iterator->key()] = -1;
					}
					$iterator->next();	
				}
				*/
				
				// cotutelle  
				if(!empty($obj->{'admin_search_user_status_cotutelle'}) && ($obj->{'admin_search_user_status_cotutelle'} != 0) ) { 
					$dir = $this->getEachStatus($r[$key]['id_user'], 'MY COTUTELLE', 'NUM');
					 
					if(is_numeric($num_cotu = $obj->{'admin_search_user_status_cotutelle'}) ) {
						$b = $this->deepCotutelle($r[$key]['id_user'], $num_cotu, 'BOOLEAN');
						if($b) {
							$r[$key]['admin_search_user_status_cotutelle'] = $obj->{'admin_search_user_status_cotutelle'};
						} else {
							$r[$key][0] = FALSE;
						}
					} else {
						$r[$key][0] = FALSE;
					}
					
				} else {
					$r[$key]['admin_search_user_status_cotutelle'] = -1;
				}
				
				// admission additional programme 
				if(!empty($obj->{'admin_search_user_status_admission_additional_programme'}) && ($obj->{'admin_search_user_status_admission_additional_programme'} != 'false') ) { 
					if(is_array($this->admissionAdditionalProgrammeSelect($r[$key]['id_user'])) ) { 
						$r[$key]['admin_search_user_status_admission_additional_programme'] = 'true';
					} else {
						$r[$key][0] =  FALSE;
					}
				} else {
					$r[$key]['admin_search_user_status_admission_additional_programme'] = -1;
				}
				
				// doctoral training
				if(!empty( $obj->{'admin_search_user_status_doctoral_training'}) && ($obj->{'admin_search_user_status_doctoral_training'} != 0 ) ) { 
					$boolean = false;
					$arrayobj = new ArrayObject();
					$arrayobj->append('doc_training_conferences');
					$arrayobj->append('doc_training_conferences_list');
					$arrayobj->append('doc_training_seminars');
					$arrayobj->append('doc_training_teaching_and_supervision');
					$arrayobj->append('doc_training_courses');
					$arrayobj->append('doc_training_journal_papers');
					$iterator = $arrayobj->getIterator();
					
				
					while ( $iterator->valid() ) {
						$this->info_total = null;
						
						$this->setTotalInfoSubmit($iterator->current(),
											'MY_DOCTORAL_TRAINING',
											$obj->{'admin_search_user_status_doctoral_training'},
											$r[$key]['id_user']
						);
						
						if(is_array($this->info_total)) { $boolean = true; break;  }
						$iterator->next();	
					}
					
					if($boolean) {  
						$r[$key]['admin_search_user_status_doctoral_training'] = $obj->{'admin_search_user_status_doctoral_training'};
					} else { 
						$r[$key][0] =  FALSE;
					}
				} else {
					$r[$key]['admin_search_user_status_doctoral_training'] = -1;
				}			 
			}
			
			// delete if there are keys [0]
			foreach($r as $k => $v) { if(isset($r[$k][0])) { unset($r[$k]);} } 
			
			// add 
			foreach( $r as $add_k => $add_v) {
				
				$emp = $this->admissionHomeCheck($r[$add_k]['id_user']);
				$employment = NULL;
				if(isset($emp['employment'])) {
					$employment = $emp['employment'];
				}
				
				$r[$add_k]['check_employment']      = $employment; 
				$r[$add_k]['check_preadmission']    = (
														$this->getEachStatus($r[$add_k]['id_user'], 'PRE-ADMISSION', 'NUM') == 0 ?
														1 : $this->getEachStatus($r[$add_k]['id_user'], 'PRE-ADMISSION', 'NUM')
													)  ;		
				$r[$add_k]['check_admission']       = $this->getEachStatus($r[$add_k]['id_user'], 'ADMISSION', 'NUM');
				$r[$add_k]['check_confirmation']    = $this->getEachStatus($r[$add_k]['id_user'], 'CONFIRMATION', 'NUM');	
				$r[$add_k]['check_private_defence'] = $this->getEachStatus($r[$add_k]['id_user'], 'PRIVATE DEFENCE', 'NUM');	
				
			} 
				
			if(!empty( $obj->{'admin_search_user_status_pre_admission'}) && ($obj->{'admin_search_user_status_pre_admission'} != 0 ) ) {
			
				foreach($r as $clear_k => $clear_v) {
					if((is_null($r[$clear_k]['check_employment'])) || ($r[$clear_k]['check_employment'] == 'Admission')) {
						unset($r[$clear_k]); 
					}
					if($r[$clear_k]['check_preadmission'] != $obj->{'admin_search_user_status_pre_admission'}) {
						unset($r[$clear_k]);
					}
				}
				
			} else if(!empty( $obj->{'admin_search_user_status_admission'}) && ($obj->{'admin_search_user_status_admission'} != 0 ) ) {
			
				foreach($r as $clear_k => $clear_v) {
					if((is_null($r[$clear_k]['check_employment'])) || ($r[$clear_k]['check_employment'] == 'Preadmission')) {
						unset($r[$clear_k]); 
					}
					if($r[$clear_k]['check_admission'] != $obj->{'admin_search_user_status_admission'}) {
						unset($r[$clear_k]);
					}
				}
				
			} else if(!empty( $obj->{'admin_search_user_status_confirmation'}) && ($obj->{'admin_search_user_status_confirmation'} != 0 ) ) {
			
				foreach($r as $clear_k => $clear_v) { 
					if($r[$clear_k]['check_confirmation'] != $obj->{'admin_search_user_status_confirmation'}) {
						unset($r[$clear_k]);
					}
				}
				
			} else if(!empty( $obj->{'admin_search_user_private_defence'}) && ($obj->{'admin_search_user_private_defence'} != 0 ) ) {
			
				foreach($r as $clear_k => $clear_v) { 
					if($r[$clear_k]['check_private_defence'] != $obj->{'admin_search_user_private_defence'}) {
						unset($r[$clear_k]);
					}
				}
				
			}
			
			// sort
			$r = $main->arrayMultisort($r, 'last_name', SORT_ASC);
			
			$r['sizeof'] = sizeof($r); 
			if(!is_null($arr_memory)) {
				if(is_array($arr_memory)) {
					//----
					if (class_exists('ExtractResult')) {
						$extract = new ExtractResult();
						$extract->setExtractResult($r, $arr_memory);
					}
					//---- 
				}
			}
			
			if( isset($_SESSION['SST_GUID']) ) {
					if($r[$key]['id_user'] == ConnectDB::isSession()) {
						$arr = array();
						array_push($arr, $r[$key]);
						unset($r[$key]); 
					} 	 
				} 
				
			// merges
			if((isset($arr)) && (!empty($arr))) { 
				$r = array_merge($arr, $r); $_SESSION['SELECTED_USER'] = $arr; 
			}	
			
			return $r ;
			
		} else {   
			return false;
		}
	} catch(Exception $e) { print('ERROR BD SEARCH # 74564712 '. $e->getMessage()); return false; }	
}

public function selectLastSearch($fetch=null, $id=null, $test=null, $max =1 ) {
	try {
		$dbh = ConnectDB::DB();
		if( !is_null($id) ) {
			if( $this->isID($id) )  {
				$test = ($test == null ? ' LIMIT  '.$max : '');
				if(strtoupper($fetch) == strtoupper('all')) {
					$sql = "SELECT * FROM `search_user` 
							WHERE `search_user`.`val_field` <> 'NULL' 
							AND `search_user`.`id_admin` = '{$id}' 
							ORDER BY `search_user`.`id_search_user`  DESC {$test} ";
				} else {
					$sql = "SELECT * FROM `search_user` 
							WHERE `search_user`.`val_field` <> 'NULL' 
							AND `search_user`.`id_admin`='{$id}' 
							ORDER BY `search_user`.`id_search_user`  DESC  {$test}";
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		return  (strtoupper($fetch) == strtoupper('all') ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC))  ;
	} catch(Exception $e) { print('ERROR BD SELECT # 7840012 '. $e->getMessage()); return false; }	
}

public function instituteSelect($id_institute=null) {
	try {
		$dbh = ConnectDB::DB();
		if($id_institute == null ) {
			$sql = "SELECT * FROM `institute`";
		} else {
			$sql = "SELECT * FROM `institute` WHERE `institute`.`id_institute`='{$id_institute}'";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {  
			return   ($id_institute == null ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC));
		} else {
			return false;
		}	
	} catch(Exception $e) { print('ERROR BD SELECT # 7840012 '. $e->getMessage()); return false; }	
}

public function instituteSelectSelected($id_user=null, $id_institute=null) {   
	try {  
		$dbh = ConnectDB::DB();
		if($id_institute != null && $id_user != null) {
			$sql = "SELECT * FROM `institute_select` WHERE `id_institute`='{$id_institute}' and `id_user`='{$id_user}' and  `select`='1'";
		} else {
			$where = ($id_user == null ? "`id_institute`='{$id_institute}'" : "`id_user`='{$id_user}'" ); 
			$sql = "SELECT * FROM `institute_select` WHERE {$where} and  `select`='1'";
		}
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) {   
			return  ($id_user == null ? $query->fetchAll(PDO::FETCH_ASSOC) : $query->fetch(PDO::FETCH_ASSOC)) ;
		} else {
			return false;
		}
		
	} catch(Exception $e) { print('ERROR BD SELECT # 7845502 '. $e->getMessage()); return false; }	
}

public function getContentInstitute($id_user) {

	if(is_array($arr_inst = $this->instituteSelect())) { 
		$j = 0;
		while($j < count($arr_inst)) {
			if($this->instituteSelectSelected($id_user, $arr_inst[$j]['id_institute'])) {
				return $arr_inst[$j];
			}  	
			$j++;
		} 
	}
	return false;
}

public function instituteUpdateSelected($id_institute=null, $r=null) { 
	if($r == null) {
		$sql = "UPDATE  `institute_select` SET 
			`id_institute` = '{$id_institute}'
			WHERE `institute_select`.`id_user` = '".self::isSession()."'";
	} else {
		$id_user =(isset($r['user']) ? $r['user'] : (isset($r['id_user']) ? $r['id_user'] : null)  );
		if(!$this->isID($id_user) ) { return false; }
		$sql = "UPDATE  `institute_select` SET 
			`state` = '".$r['state']."',
			`sent` = '".$r['sent']."',
			`sent_date` = '".self::staticFormatDate()."'
			WHERE `institute_select`.`id_user` = '".$id_user."'";
	}
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print('ERROR BD UPDATE # 788785002'. $e->getMessage()); return false; }	
}

public function instituteInsertSelected($id_institute) { 

	$main = new Main(); 
	
	$path = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_PRESIDENT_SIMPLE); 
	
	$folder = $this->createFolderSimple($path, self::isSession());
	$sql = "INSERT INTO `institute_select` (`id_institute_select`, `id_institute`, `id_user`, `select`, `state`, `sent`, `sent_date`, `dir`, `date`)
									VALUES (
									'{$this->guid()}', 
									'{$id_institute}', 
									'".self::isSession()."', 
									'1',
									'0',
									'0',
									'".self::staticFormatDate()."',
									'".$folder."',
									'".self::staticFormatDate()."');";							
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print('ERROR BD INSERT # 77452004'. $e->getMessage()); return false; }	
}

public function instituteInsert($r) {
	$sql = "INSERT INTO `institute` (`id_institute`, `institute`, `mail`, `text`)
									VALUES ('{$this->guid()}', 
									'".$r['institute']."', 
									'".$r['mail']."', 
									'".$r['text']."');"; 
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print('ERROR BD INSERT # 775785485'. $e->getMessage()); return false; }	
}

public function instituteUpdate($r=array(), $test=null) {
	if(isset($r['name_field'])) {
		$sql = "UPDATE  `institute` SET 
			`{$r['name_field']}` = '".$r['modif_txt']."'
			WHERE `institute`.`id_institute` = '".$r['id_institute']."'";
	} else {
		return false; 
	}
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare($sql);
		$query->execute();
		return true; 
	} catch(Exception $e) { print('ERROR BD UPDATE # 78854531'. $e->getMessage()); return false; }	
}
 
public function instituteDelete($id_institute) {
	$main = new Main();
	try {
		if( is_array($inst = $this->instituteSelectSelected(null, $id_institute)) ) { 	 
			foreach($inst as $k => $v ) { 
		
				if($path = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_PRESIDENT_SIMPLE.$v['dir'])) {
					$this->unlinkDir($file);
				}
				
			}
		}
 
		$dbh = ConnectDB::DB(); 
		$query1 = $dbh->prepare("
						DELETE FROM `institute_select`
						WHERE `institute_select`.`id_institute` = '{$id_institute}'");
		$query2 = $dbh->prepare("DELETE FROM `institute`
						WHERE `institute`.`id_institute` = '{$id_institute}'");
		
		$r['id_institute'] = $id_institute;
		$main->deleteLinkSupervisor($r);	
		
		$query1->execute();
		$query2->execute();
		return true;
	}  catch(Exception $e) { print('ERROR BD DELETE # 47757575'. $e->getMessage()); return false; }	
}

public function confPlanningInsert($r) {

	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO conf_planning()
									VALUES ('{$this->guid()}', 
									'".self::isSession()."', 
									'".$r['deadline']."', 
									'".$r['text']."',
									'".self::staticFormatDate()."');"; ;
		$query = $dbh->prepare($sql);
		$query->execute();	
		return true;
	} catch(Exception $e) { print('ERROR BD INSERT # 758787856'. $e->getMessage()); return false; }	
}

public function confPlanningUpdate($r) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "UPDATE  `conf_planning` SET 
			`deadline` = '".$r['deadline']."',
			`text` = '".$r['text']."'
			WHERE `conf_planning`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();	
		return true;
	} catch(Exception $e) { print('ERROR BD UPDATE # 112245455'. $e->getMessage()); return false; }	
}

public function confPlanningSelect($id_user=null) { 
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `conf_planning` WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user)."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC) ;
	} catch(Exception $e) { print('ERROR BD SELECT # 78888777'. $e->getMessage()); return false; }
}

public function confPlanningStatusSelect($test=null, $id_user=null) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `conf_planning_status` WHERE `id_user`='".(is_null($id_user) ? self::isSession() : $id_user)  ."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		if($query->rowCount() > 0 ) { 
			return $query->fetch(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
		 
	} catch(Exception $e) { print('ERROR BD SELECT # 748578'. $e->getMessage()); return false; }	
}

public function confPlanningStatusUpdate($id_admin=null, $staus=0) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "UPDATE  `conf_planning_status` SET 
			`status` = '{$staus}',
			`id_admin` = '{$id_admin}',
			`date_accepted` = '".self::staticFormatDate()."'
			WHERE `conf_planning_status`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR BD UPDATE # 2465546'. $e->getMessage()); return false; }	
}

public function confPlanningStatusInsert($id_admin=null, $staus=0) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO `conf_planning_status` (`id_conf_planning_status`, `id_admin`, `id_user`, `status`, `date_sended`, `date_accepted`) 
				VALUES 
				(
				'{$this->guid()}',
				'{$id_admin}', 
				'".self::isSession()."',
				'{$staus}',
				'".self::staticFormatDate()."',
				'".self::staticFormatDate()."');";
		$query = $dbh->prepare($sql);
		$query->execute();
		return true;
	} catch(Exception $e) { print( 'ERROR BD INSERT # 7879797710'. $e->getMessage()); return false; }	
}

public function confResultUpdate($r) {
	try {
		$s = (isset($r['date_submitted']) ? ", `date_submitted` = '".self::staticFormatDate()."'"  : '');
		$dbh = ConnectDB::DB();
		$sql = "UPDATE  `conf_result` SET 
			`id_admin` = '".$r['id_admin']."',
			`date_of_confirm` = '".$r['date_of_confirm']."',
			`select_confirm_state` = '".$r['select_confirm_state']."'
			{$s}
			WHERE `conf_result`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();	
		return true;
	} catch(Exception $e) { print( 'ERROR BD UPDATE # 2454754'. $e->getMessage()); return false; }	
}

public function confResultInsert($id_admin=null, $date_of_confirm, $select_confirm_state) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO `conf_result` (`id_conf_result`, `id_user`, `id_admin`, `date_of_confirm`, `select_confirm_state`, `date_submitted`) 
				VALUES 
				(
				'{$this->guid()}',
				'".self::isSession()."', 
				'{$id_admin}',
				'{$date_of_confirm}',
				'{$select_confirm_state}',
				'".self::staticFormatDate()."');";
		$query = $dbh->prepare($sql);
		$query->execute();
		return true;
	} catch(Exception $e) { print( 'ERROR BD INSERT # 2454754 '. $e->getMessage()); return false; }
}

public function confResultSelect($id_user=null) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `conf_result` WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user)."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	} catch(Exception $e) { print('ERROR BD SELECT # 78899778 ' .$e->getMessage()); return false; }
}
 
public function statusUpdate($r, $test=null) {
	try {  
		$dbh = ConnectDB::DB();
		$user_request = null;
		if( $test != null) { $user_request = "`user_request` = '{$test}',"; }
		$sql = "UPDATE `status` SET 
					`position_phd` = '{$r['status']}',
					`admin_confirm` = '{$r['admin_confirm']}',
					{$user_request}
					`id_admin`='{$r['id_admin']}'
					WHERE `status`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();
	 
	} catch(Exception $e) { print('ERROR BD UPDATE # 4546545 ' .$e->getMessage()); return false; }
}

public function publicDefenceStatusSelect($id_user=null) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `public_defence_status` WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user)."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	} catch(Exception $e) { print('ERROR BD SELECT # 2489754 ' .$e->getMessage()); return false; }
}

public function publicDefenceStatusInsert($id_admin, $state=0) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO `public_defence_status` () VALUES (
													'{$this->guid()}',
													'".self::isSession()."',
													'{$id_admin}',
													'{$state}',
													'".self::staticFormatDate()."'
													);";
		$query = $dbh->prepare($sql);
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR BD INSERT # 478578 ' .$e->getMessage()); return false; }
}

public function publicDefenceStatusUpdate($id_admin, $state=0) {
	try {
		$dbh = ConnectDB::DB(); //  
		$sql = "UPDATE  `public_defence_status` SET 
			`id_admin` = '{$id_admin}',
			`state` = '{$state}',
			`date_submitted` = '".self::staticFormatDate()."'
			WHERE `public_defence_status`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();	
		return true;
	} catch(Exception $e) { print('ERROR BD UPDATE # 7754758 ' .$e->getMessage()); return false; }
}


public function privateDefenceStatusSelect($id_user=null) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "SELECT * FROM `private_status` WHERE `id_user`='".($id_user == null ? self::isSession() : $id_user)."'";
		$query = $dbh->prepare($sql);
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	} catch(Exception $e) { print('ERROR BD SELECT # 2489754 ' .$e->getMessage()); return false; }
}

public function privateDefenceStatusInsert($id_admin=null, $text, $select_status, $r) {
	try {
		$dbh = ConnectDB::DB();
		$sql = "INSERT INTO `private_status` () VALUES (
					'{$this->guid()}', 
					'{$id_admin}', 
					'".self::isSession()."',
					'{$select_status}',
					'{$text}',
					'".(isset($r['date_passed']) ? $r['date_passed'] : NULL)."',
					'".self::staticFormatDate()."', '".(isset($r['date_validated']) ? $r['date_validated'] : NULL)."'
				);";
		$query = $dbh->prepare($sql);
		$query->execute();
		return true;
	} catch(Exception $e) { print('ERROR BD INSERT # 2489754' .$e->getMessage()); return false; }
}
				 
public function privateDefenceStatusUpdata($r) {
	try {
		if(isset($r['date_passed']) ) {
			$date = ($r['date_passed'] != NULL ? "`date_passed` = '".$r['date_passed']."'," : '');
		} else {
			$date = NULL;
		}
		if(isset($r['test'])) {
			$text = '';
		} else {
			$text = "`text` = '".$r['txt_status']."',";
		}
		$dbh = ConnectDB::DB(); //  
		$pr_sql = ( isset($r['date_validated'])  ? ", `date_validated` = '{$r['date_validated']}'" : NULL  );  
		$sql = "UPDATE  `private_status` SET 
			`id_admin` = '".$r['id_admin']."',
			{$text}
			`state` = '".$r['select_status']."',
			{$date}
			`date_submitted` = '".self::staticFormatDate()."' {$pr_sql}
			WHERE `private_status`.`id_user` = '".self::isSession()."'";
		$query = $dbh->prepare($sql);
		$query->execute();	
		return true;
	} catch(Exception $e) { print('ERROR BD UPDATE # 4757575' .$e->getMessage()); return false; }
}


public function selectAllUsers($tab_name, $sql='') {
	if(ConnectDB::isSession() ) {
		try {
			$dbh = ConnectDB::DB();
			$query = $dbh->prepare("SELECT * FROM `{$tab_name}`{$sql}");
			$query->execute();
			if($query->rowCount() > 0 ) {  
				return $query->fetchAll(PDO::FETCH_ASSOC);
			} else {
				return false;
			}	
		} catch(Exception $e) { print('ERROR BD SELECT # 45454 ' .$e->getMessage()); return false; }
	}
}

public function rewritePWDAllUsers($tab_name='registration') {  
	if(is_array($users = $this->selectAllUsers($tab_name))) {   
		if(ConnectDB::isSession() ) { 
			try {
				$dbh = ConnectDB::DB();
				foreach($users as $k => $v) { 
					if(strlen($users[$k]['pwd']) != 32) {   
						$query = $dbh->prepare("UPDATE `{$tab_name}` SET 
													`pwd` = '".md5($users[$k]['pwd'])."' 
												WHERE `id_user` = '".$users[$k]['id_user']."';");
						$query->execute();
					}	
				}	
				 	
			} catch(Exception $e) { print('ERROR BD UPDATE  # 465769 ' .$e->getMessage()); return false; }
		}
	}
}

public function activitiesDoctoralTraining($id_user, $status=3)  {
	$r = array();
	$this->setTotalInfoSubmit('doc_training_courses', null, $status, $id_user) ;
	$total_courses = ($this->getTotalInfoSubmit()); 
	$this->setTotalInfoSubmit('', 'SEMINARS_PARTICIPER', $status, $id_user) ;
	$total_sem_part = ($this->getTotalInfoSubmit());
	$this->setTotalInfoSubmit('', 'CONFERENCE_DATE', $status, $id_user) ;
	$total_conf_date = ($this->getTotalInfoSubmit('DATE')); 
	$training = ($total_courses+$total_sem_part+$total_conf_date);
	$r['training'] = $training;
	//----------------------------------------------------------
			
	$this->setTotalInfoSubmit('doc_training_journal_papers', null, $status, $id_user) ;
	$total_journal_papers = ($this->getTotalInfoSubmit());
	$this->setTotalInfoSubmit('', 'SEMINARS_PRESENTER', $status, $id_user) ;
	$total_sem_pres = ($this->getTotalInfoSubmit());
	$this->setTotalInfoSubmit('', 'CONFERENCE_LIST', $status, $id_user) ;
	$total_conf_list = ($this->getTotalInfoSubmit());
	$communication = ($total_journal_papers+$total_sem_pres+$total_conf_list);
	$r['communication'] = $communication;
	//----------------------------------------------------------
				
	$this->setTotalInfoSubmit('', 'TEACHING', $status, $id_user) ;
	$total_teaching = ($this->getTotalInfoSubmit());
	$teaching = ($total_teaching+0);
	$r['teaching'] = $teaching;
	//----------------------------------------------
				
	$this->setTotalInfoSubmit('', 'OTHER', $status, $id_user) ;
	$total_other = ($this->getTotalInfoSubmit());
	$other = ($total_other+0);
	$r['other'] = $other;
	//------------------------------------------------------------
	
	$total = ($total_courses+$total_sem_part+$total_conf_date+$total_conf_list+$total_journal_papers+$total_sem_pres+$total_teaching+$total_other);
	$r['total'] = $total;				  
	return $r;
}

} // end class ConnectDB

class CreateGuid {

public function __construct(){}

public function guid() {
	$microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec * 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	$this->ensureLength($dec_hex, 5);
	$this->ensureLength($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= $this->createGuidSection(3);
	$guid .= '-';
	$guid .= $this->createGuidSection(4);
	$guid .= '-';
	$guid .= $this->createGuidSection(4);
	$guid .= '-';
	$guid .= $this->createGuidSection(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= $this->createGuidSection(6);
	return $guid;
}

private function createGuidSection($characters) {
	$return = "";
	for($i = 0; $i < $characters; $i++) {
		$return .= sprintf("%x", mt_rand(0,15));
	}
	return $return;
}

private function ensureLength(&$string, $length){
	$strlen = strlen($string);
	if($strlen < $length) {
		$string = str_pad($string,$length,"0");
	} else if($strlen > $length) {
		$string = substr($string, 0, $length);
	}
}

} // end class CreateGuid

/*
class TestClass {
private $var1=array();
private $var2=array();

private function TestClass($var1, $var2){
    $this->var1 = $var1;
    $this->var2 = $var2;
}

public static function create($var1, $var2){
      return new TestClass($var1, $var2);

}

} // end class TestClass
*/
/*
$myArray = array();
$myArray[] = TestClass::create(10, "111");
$myArray[] = TestClass::create(20, "222");

*/


?>