<?php 
//Only the session id is transmitted as a cookie; not the session data itself
ini_set('session.use_only_cookies', true);
session_start();
//Update the current session id with a newly generated one 
session_regenerate_id();
//Used by all date/time functions in a script 
date_default_timezone_set('Europe/Paris');
 
include_once('define.php');
include_once('err_handler.php'); 
include_once('state.php');   
ErrorHendler::setHandler();
 
?>