<?php

class TimerSSTConnected extends ConnectDB{

private $id_user;
private $name_table;
private $dbh;

public function __construct() { 
	if ( class_exists('ConnectDB')) { 
		$this->dbh = new ConnectDB();	 
	}  else {
		$this->dbh = NULL; 
	}
}

public function toString() { }

public function getTimerInDB($id_user) {
	 
	$ex = ConnectDB::DB();
	$query = $ex->prepare("SELECT * FROM `registration` WHERE id_user='{$id_user}'");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_ASSOC);
	$this->id_user = $id_user;	
	$this->ckeckTimer($result['timer_connected']);	
}

private function ckeckTimer($timer_connected) {
	if( $timer_connected < microtime() +10) { // if true user to use app
		 $this->updateTimerConnectedInBD(1);
	} else {
		$this->updateTimerConnectedInBD(0);
	}
}

private function getTimer() {
	list($usec,) = explode(" ", microtime());
    return ( (float)$usec); 
}

function getIdUser( ) {
	return $this->id_user;
}

function setIdUser($id_user) {
	$this->id_user = $id_user;
}

public function timerConnected() {
	 
	if( !$this->isID($this->id_user) )  return false ;
	if( is_array($this->dbh->checkRegistration($this->id_user) ) ) {
		$this->updateTimerConnectedInBD(1); 
	}
}

private function updateTimerConnectedInBD($val=0) {
	
		if($val == 0) {
			$timerc = 0;
			$timerd = date();
			$val = 0;
		} else {
			$timerc = $this->getTimer();
			$timerd = date();
			$val = 1;
		}
	$ex = ConnectDB::DB(); 
	$query = $ex->prepare("UPDATE `registration` SET 
									`timer_connected` = '{$timerc}', 
									`timer_deconnected`   = '{$timerd}', 
									`connected`= '{$val}'		
							WHERE `registration`.`id_user` = '{$this->id_user}';");
	$query->execute();
}

}



?>