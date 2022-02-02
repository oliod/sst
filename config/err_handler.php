<?php
 
class ErrorHendler {
	 
	
	public static function setHandler($err_types = ERROR_TYPES ){
		return set_error_handler(array('ErrorHendler', 'handler'), $err_types);
	}
	public static function handler($err_no, $err_str, $err_file, $err_line) {
		$backtrace = ErrorHendler::getBacktrace(2);
		$error_message = 'ERRNO: ' . $err_no . chr(10) ."\n".
 	                 'TEXT: ' . $err_str . chr(10) ."\n".
	                 'LOCATION: ' . $err_file ."\n".
	                 'LINE: ' . $err_line ."\n".
					 'DATE: '.date('Y-m-d H:i:s')."\n";
					 
		if(SEND_ERROR_MAIL == true) {
			error_log($error_message, 1, ADMIN_ERROR_MAIL, 'From: '. SENDMAIL_FROM. "\t\nTo:".ADMIN_ERROR_MAIL);
		}
		if(LOG_ERRORS == true){
			error_log($error_message, 3, LOG_ERRORS_FILE);
		}
		if(($err_no == E_WARNING && IS_WARNING_FATAL == false) || ($err_no == E_NOTICE || $err_no == E_USER_NOTICE)) {
			if(DEBUGGING == true) 
				print('<div class="error_box"><pre>'. $error_message .'</pre></div>');
		} else {
			if(DEBUGGING == true) 
				print('<div class="error_box"><pre>'. $error_message .'</pre></div>');
			else
				print(SITE_GENERIC_ERROR_MESSAGE);
				exit();
			}
		}
	public static function 	getBacktrace($irrelevant_first_entries){
		
		$s = '';
		$MAXSTRLEN = 64;
		$trace_array = debug_backtrace();
		for($i = 0; $i < $irrelevant_first_entries;$i++) 
			array_shift($trace_array);
		$tabs = sizeof($trace_array)-1;	
		foreach($trace_array as $arr) {
		
			$tabs -=1;
			if(isset($arr['class']))
				$s .= $arr['class'].'.';
			$args = array();
			if(!empty($arr['args']))
				foreach($arr['args'] as $v){
				
					if(is_null($v))
						$args[] = 'null';
					elseif(is_array($v))
						$args[] = 'Array['.sizeof($v).']';
					elseif(is_object($v))
						$args[] = 'Object: '.get_class($v);
					elseif(is_bool($v))
						$args[] = $v ? 'true' : 'false';
					else {
						$v = (string)@$v;
						$str = htmlspecialchars(substr($v, 0, $MAXSTRLEN));
						if(strlen($v) > $MAXSTRLEN)
							$str .= '...';
					 	$args[] = '"'.$str.'"';	
					}	
				}
			$s .= $arr['function'].'('.implode(', ', $args) . ')';
			$line = (isset($arr['line']) ? $arr['line'] : 'unknown');
			$file = (isset($arr['file']) ? $arr['file'] : 'unknown');
			$s .= sprintf('# line %4d, file: %s', $line, $file);
		}
		return $s;
	}
} 
?>
