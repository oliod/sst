<?php
if((file_exists($f = '../../class/main.php')) || (file_exists($f = '../class/main.php'))) {
	include_once($f);
	if(class_exists('Main')) { 
		$main = new Main();	
		include_once($main->isDirectoryExists('config/config.php'));
		include_once($main->isDirectoryExists('class/connect_db.php'));
		include_once($main->isDirectoryExists('class/page.php'));
		PageSST::exitPage();
	} else {
		if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');	
	}
} else {
	if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');
}

?>