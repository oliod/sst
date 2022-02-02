<?php 
class Visited {

	private $obj_dbh = null;
	private $obj_main = null;
	
public function __construct($obj_dbh, $obj_main ) {
	$this->obj_dbh = $obj_dbh;
	$this->obj_main = $obj_main;
}
	
// 0 = (did not visit), 1 = (visited)
public function setDefaultInactiveLeftMenu() {
	$page = new PageSST();
	 $main = new Main();
	$arr =	$page->getFullLeftMenu(new Main());
	foreach($arr as $k => $v)  {
		$count = 0;
		while ($keys = current($v)) {
			$arr[$k][$page->getValuesInArray($v, $count)] = array( 
																0 => 0,
																1 => date(FORMAT_DATE),
																2 => $this->obj_main->getIP(), 
																3 => $this->obj_dbh->guid(),
																4 => '',
																5 => '',
																6 => '',
																7 => '',
																8 => '',
																9 => '',
																); 
			unset($arr[$k][key($v)]);
			next($v);
			$count++;
		}
	}
		$this->insertVisited(ConnectDB::isSession());
		$this->obj_main->putContenFile(DIR_FOLDER_OBJ_MENU.ConnectDB::isSession(), json_encode($arr));
 }

// 0 = (did not visit), 1 = (visited) $json->{$k1}->{$k2}->{0}
public function doVisitedLeftMenu($k1 = null, $k2 = null, $test=null, $info=null, $uid=null) {

	if(!ConnectDB::isSession()) { return false; } 
	$admin = new AdminAuthority( );
	if($f = $this->obj_main->isDirectoryExists(DIR_FOLDER_OBJ_MENU, ConnectDB::isSession())) {
		// open for reading
		$json = $this->obj_main->jsonValidate($this->obj_main->showContentFile($f));

		if(empty($json)) { $this->setDefaultInactiveLeftMenu(); }
		
	} else {
		 
		return false;
	}
	if((is_object($json)) && ($json instanceof stdClass) ) {
	 
		if(AdminAuthority::isSessionAdminSudo()) {  
			$json->{$k1}->{$k2}[0] = 0;	
		} else {
			if($test != null) { $json->{$k1}->{$k2}[0] = 1; $this->updateVisited(ConnectDB::isSession(), null); }
		}
			$json->{$k1}->{$k2}[1] = date(FORMAT_DATE);
			$json->{$k1}->{$k2}[2] = $this->obj_main->getIP(); 
			if(!empty($info)) { $json->{$k1}->{$k2}[4] = $info;}
			$json->{$k1}->{$k2}[5] = $k2;
			
			$wp_data = $admin->getDataAdminSimpleWP();
				if( $wp_data['wp_data']['mod'] >= 2) { 
					$json->{$k1}->{$k2}[6] = $admin->getSessionAdmin();
				}
 
			(!empty($info) ? $this->obj_dbh->writeLogFile('['.$k1 .']'.'['.$k2.']'.' ['.$info.']', 'HAS BEEN MODIFIED') : '');
			$this->obj_main->putContenFile($f, json_encode($json));
	} else {   
		 
		 
	return false; }	
	
}

 public function getInfoVisitedLeftMenu($k1, $k2) {
 
	$admin = new AdminAuthority();
	$main = new Main();
	
	if((!AdminAuthority::isSessionAdminSudo())  &&  (!AdminAuthority::isSessionAdminSimple()) ) { return false; } 
	 
	$json = $this->obj_main->jsonValidate($this->obj_main->showContentFile(DIR_FOLDER_OBJ_MENU.ConnectDB::isSession()));
	   
	if((is_object($json)) && ($json instanceof stdClass) ) {
		 
		foreach ($json as $k => $v) { 
			 if(isset($json->{$k}->{'get'})) {
				if(is_object($json->{$k}->{'get'})) {
					$this->setDefaultInactiveLeftMenu(); 
				} 
			}
		}

		if( (isset($json->{$k1}->{$k2}[0])) && ($json->{$k1}->{$k2}[0] == 1 ) ) { 
		 
			return array(
					0 => $json->{$k1}->{$k2}[0],
					1 => $json->{$k1}->{$k2}[1], 
					2 => $json->{$k1}->{$k2}[2],
					'id'      => $json->{$k1}->{$k2}[3],
					'img'     => $GLOBALS['sst']['icon']['visited'], 
					'onclick' => 'onclick="return getHelp(\''.$json->{$k1}->{$k2}[3].'\', event, \'VISITED\');"',
					'html'    => '<div id="'.$json->{$k1}->{$k2}[3].'" style="display:none;">
									<div style="margin:10px;">
								    <b>Date : </b>'.$main->settingDate($json->{$k1}->{$k2}[1]).'<br> 
									<b>IP : </b>'.$json->{$k1}->{$k2}[2].'<br> 
									<b>Info : </b><b style="color:#3A93C6;" >'.$json->{$k1}->{$k2}[4].'</b><br>
									<b>Page : </b>'.$json->{$k1}->{$k2}[5].'<br>
									<b>USER SST : </b>'.(isset($json->{$k1}->{$k2}[6]) ? $json->{$k1}->{$k2}[6] : '').'<br>
									</div>
								 </div> ',
				);
		}

	} else {
		return null;
	}
}

public function getInfoVisitedHorisontMenu($key, $h_menu='get') { 
	$admin = new AdminAuthority( ); 
	if((!AdminAuthority::isSessionAdminSudo()) && (!AdminAuthority::isSessionAdminSimple()) ) { return false; } 
	$vis = array();
	if(is_array($h_menu)) {
		foreach ($h_menu as $h_key => $h_val) {
			if($vis = $this->getInfoVisitedLeftMenu($key, $h_key)) return $vis;
		}
	} else {
		return $this->getInfoVisitedLeftMenu($key, 'get');
	}
}	

function checkAllHorisontMenu($key, $page) {	
	 
	switch($key) {
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 0): //'MY PROFILE':  
			return $this->getInfoVisitedHorisontMenu($key) ; 
		break;
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 1): //'MY ACADEMIC CV':
			return $this->getInfoVisitedHorisontMenu($key) ; 
		break;
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 4): //'MY SUPERVISORY PANEL':
			return $this->getInfoVisitedHorisontMenu($key) ; 
		break; 	
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 5): //'MY DOCTORAL TRAINING':
			return $this->getInfoVisitedHorisontMenu($key, $page->h_menu->docTrainingMenu()) ; 
		break;
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 6): //'MY ADDITIONAL PROGRAMME':
			return $this->getInfoVisitedHorisontMenu($key ) ; 
		break;
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 7): //'MY COTUTELLE':
			return $this->getInfoVisitedHorisontMenu($key) ;
		break;
		case $page->getKeysInArray($GLOBALS['sst']['button_left'], 9): //'MY ANNUAL REPORTS':
			return $this->getInfoVisitedHorisontMenu($key) ;
		break;
		default:
			return false;
	}
}

function isValueExists($id_user) {  
	$json = null;
	if($f = $this->obj_main->isDirectoryExists(DIR_FOLDER_OBJ_MENU, $id_user)) {  
		$json = $this->obj_main->jsonValidate($this->obj_main->showContentFile($f));  
		  
	}
	 
	if($json == null) return false;
	foreach ($json as $k => $v  ) {
		foreach($v as $j) { 
			if(is_array($j)) {
				if($j[0] == 1) return true;
			}
		}
	}
	return false;
}

public function insertVisited($id_user, $test=null) {
	 
	if(!$this->obj_dbh->isID($id_user) || !ConnectDB::isSession()) { return false; }
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("INSERT INTO  `visited` (`id_visited`, `id_user`, `val`, `last_visited`)
					VALUES ('".$this->obj_dbh->guid()."', 
						'".$id_user."', 
						'".ConnectDB::staticFormatDate()."',
						".time().");");
		$query->execute();
		return true;
	
	} catch(Exception $e) { 
		//echo $e->getMessage();
		return false;
	}
}

public function updateVisited($id_user, $test=null) {
	if(!$this->obj_dbh->isID($id_user) || !ConnectDB::isSession()) { return false; }
	try {
		ConnectDB::staticFormatDate();
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("UPDATE `visited` SET 
									`val` = '".ConnectDB::staticFormatDate()."',
									`last_visited`= '".time()."'		
								WHERE `visited`.`id_user` = '".$id_user."';");
		$query->execute();

	} catch(Exception $e) {
		//echo $e->getMessage();
		return false;
	}
}

public function selectVisited($id_user, $test=null) {
	if(!$this->obj_dbh->isID($id_user) || !ConnectDB::isSession()) { return false; }
	$sql = ($test != null ? "WHERE `visited`.`id_user`= '{$id_user}'" : '' );   
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `visited` {$sql}");
		$query->execute();
		if($query->rowCount() > 0 ) {
			 return ($test != null ? $query->fetch(PDO::FETCH_ASSOC) : $query->fetchAll(PDO::FETCH_ASSOC));
		} else {
			 return  $this->insertVisited($id_user, null);
		}
	
	} catch(Exception $e) {
		//echo $e->getMessage();
		return false;
	}
}
public function visitedSelect($id_user) {
	try {
		$dbh = ConnectDB::DB();
		$query = $dbh->prepare("SELECT * FROM `visited` WHERE `visited`.`id_user`= '{$id_user}' ");
		$query->execute();
		if($query->rowCount() > 0 ) {
			 return $query->fetch(PDO::FETCH_ASSOC);
		} else {
			return false;
		}
	
	} catch(Exception $e) {
		//echo $e->getMessage();
		return false;
	}
}
}

?>