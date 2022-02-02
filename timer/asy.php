<?php
 sleep(1); 
 
( isset($_POST['asynchronous']) ? '' : exit ); 

if($_POST['iduser'] == '5451211456545') {
	print '{"status":777, "class":"connected", "id":"5451211456545"}';
} else  if($_POST['iduser'] == '545185858') {
	print '{"status":777, "class":"connected", "id":"5451858585"}';
} else {
	print '{"status":333, "class":"connected", "id":"5451858585"}';
 }
//send_vals.append("asynchronous", "connexion");
//		send_vals.append("iduser", this.iduser);

exit;

?>