<?php
define('SECRET_KEY_LENGTH', 370);
 
include_once('config/config.php'); 
if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');

include_once('class/admin.php'); 
include_once('class/page.php');
include_once('class/main.php');
include_once('class/extract_result.php');

include_once('class/connect_db.php');
include_once('timer/timer.php');
include_once('class/visited.php');
include_once('class/supervisor.php');



include_once(DIR_FOLDER_SIGNATURE_LINK.'class_signature_link.php');
 
if(!class_exists('ConnectDB') || 
	!class_exists('Main') || 
	!class_exists('PageSST') || 
	!class_exists('Supervisor')) {
		print('Class don\'t exists. ERROR DISPLAY  # 3554854');
		exit;
}
 
$dbh = new ConnectDB();

//echo $dbh->guid();


$main = new Main(); 
$page = new PageSST();
$visited = new Visited(new ConnectDB(), new Main());
$supervisor = new Supervisor();
  
$dbh->ispHdLocked(ConnectDB::isSession());


// Visited page by user
$visited->selectVisited(ConnectDB::isSession(), 'user');  
if(!file_exists(DIR_FOLDER_OBJ_MENU.ConnectDB::isSession())) { $visited->setDefaultInactiveLeftMenu(); }

// Supervisor link
$supervisor->isValidSupervisor(Main::currentPageURL());   
$obj_supervisor = (
			is_object($obj_supervisor = $supervisor->getContentSupervisor(ConnectDB::isSession())) ?
			$obj_supervisor : 
			null
);

if(Supervisor::isSessionSupervisor()) {

	$perse = $main->parseQueryString(Main::currentPageURL());
	$perse = (isset($perse['page']) ? $perse['page'] : null);
	
	if($perse != 'my_doctoral_training' && $perse != 'disconnect') {
		$supervisor->initAuthenticationAndRedirect('?page=disconnect');
	}
	
}

// Requiring the withdrawal of all elements on the page
$page->display();

$myAppSST = <<<EOD
	<script>
		 
		closeDialog();
		openDialog();
 
		setProcessingForwarding(2000, '?page=disconnect'); 
		var icon = classDialog.dialogIconObject.ICON_PROG; 
			showDialogObject.dialogSimple(null, 
								showText('DIALOG', 'dialog', null, null),
								showText('DIALOG', 'management_admin_info_status_close', null, null), icon );	
			listener();	
			
	</script>	
EOD;

// Safe containers. If the system is shut off by the administrator
if(isset($GLOBALS['sst']['application_sst'][0])) {

	if(is_numeric($status = $GLOBALS['sst']['application_sst'][0] ) ) {
	
		if($status == 1) {
			$admin = new AdminAuthority( ); 
			
			if(!AdminAuthority::isSessionAdminSudo() &&
				(ConnectDB::isSession() || 
				AdminAuthority::isSessionAdminSimple())) { 
					echo $myAppSST; 
			}
			
		} 
	}
	
}	
?>