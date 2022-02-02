<?php

if(!file_exists('../../config/config.php')) { die("ERROR REQ ULOAD FILE # 52525"); } else { include_once('../../config/config.php'); }

mb_internal_encoding('utf-8');

include_once('../../class/page.php'); 
include_once('../../class/connect_db.php'); 
include_once('../../class/main.php'); 
include_once('../../class/admin.php'); 
include_once('../../class/supervisor.php');
include_once('../../class/visited.php'); 
include_once('../../modules/link_signatures/class_signature_link.php');  

$dbh = new ConnectDB();
$main = new Main();
$page = new PageSST();
$admin = new AdminAuthority();
$supervisor = new Supervisor();
$signature_link = new SignatureLink( ); 
$visited = new Visited(new ConnectDB(), new Main());
if(Supervisor::isSessionSupervisor()) { print('ERROR REQ ULOAD # 25478'); exit; }
($main->objectTypeActivation(1) ? '' : die('ERROR # CONNEXION 555'));

if(!isset($_SESSION['SST_GUID'])) {  print('ERROR REQ ULOAD # 2545244'); exit(); }

?>