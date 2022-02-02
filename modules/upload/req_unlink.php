<?php

if(!file_exists('inc.php')) { die("ERROR DELETE FILE REQ # 52525"); } else { include_once('inc.php'); }

$allowed = array('pdf');

$path = (isset($_POST['patch']) ? $dbh->filter($_POST['patch']) : false) ; 
$path = $main->decipherStr($path); 

if(!$path) {
	print('ERROR DELETE FILE REQ # 3264 WRONG ROAD');
	exit;
} 

if(preg_match('/(deft_id_upload_academic|deft_id_upload_diploma)/', $path, $match )) {
	
	if($match[0] == 'deft_id_upload_academic') {
		$spl = explode('deft_id_upload_academic', $path);
		$dbh->deleteDiplomaOrYear($spl[0], 'upload_academic', 'id_upload_academic');
		$path = $spl[1];
		$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 1),
						'get',
						'user',
						' YEAR ACADEMIC HAS BEEN DELETED '
						); 
	} 
	if($match[0] == 'deft_id_upload_diploma') {
		$spl = explode('deft_id_upload_diploma', $path);
		$dbh->deleteDiplomaOrYear($spl[0], 'upload_diploma', 'id_upload_diploma');
		$path = $spl[1];  
		$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 1),
						'get',
						'user',
						' DIPLOMA HAS BEEN DELETED '
						); 
	}	
}

$extension = pathinfo($path , PATHINFO_EXTENSION);

if(!in_array(strtolower($extension), $allowed)) {
	print('ERROR DELETE FILE REQ # 3255 IMPOSIBLE TO DELETE');
	exit;
}

if($f = $main->isDirectoryExists('', $path)) { 
	print('ok'); 
	unlink($f);
} else {
	print('ERROR DELETE FILE REQ # 3265 IMPOSIBLE TO DELETE');
}

?>