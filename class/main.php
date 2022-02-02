<?php 

class Main {

public $b_next = 'NEXT >>';
public $b_prev = '<< PREV';
public $array_f = array();

private $page = null; 
private $dbh = null;
 
public function __construct() { 
	if(class_exists('PageSST')) {
		$this->page = new PageSST(); 
	}
	if(class_exists('ConnectDB')) {
		$this->dbh = new ConnectDB(); 
	}  
}

public function getCreateArray() {
	return $this->array_f;
}

private function setCreateArray($array_f) {
	return $this->array_f = $array_f ; 
}

public function encryptStr($str) {
	return base64_encode($str);
}
 
public function decipherStr($str) {
	return base64_decode($str);
}
// has been changed
public function formatDate() {
	return date(DATETIME);
}

public function pre($arr = array()) {
	$pre = '<pre>'.$arr.'</pre>';
	return $pre;
}
 // has been changed
public static function staticFormatDate() {
	return date(DATETIME);
}

// when date has been created  - mysql datetime
public static function orderDateInDB() {
	return date(DATETIME);
}
 
public function linkPDFDialog($link, $name, $title, $opt='D') {
	if ($opt == 'X') {
		$img = $this->getSrcImg($GLOBALS['sst']['icon']['pdf_error'], 'width=18px');
		$html = '<span onclick="pdf_d.getPDFDialog(\''.$link.'\' , \''.$name.'\',  \''.addslashes($title).'\', \''.$opt.'\' ); ">  
					' . $img . ' </span>';
		return $html;
	}
	$html .= '<div style="margin:15px;">
				<span>
					<a class="navig_link" href="'.$link.'" target="_blank" style="padding:5px;"> 
						-> ' . $name . 
					'</a>
					<span class="navig_link" 
						style="" 
						onclick="pdf_d.getPDFDialog(\''.$link.'\' , \''.$name.'\',  \''.addslashes($title).'\', \''.$opt.'\' ); "> 
						OPEN 
					</span>
				</span> 
			</div> ';
	return $html;						
}
 
 // MANAGEMENT ADMIN config history file
public function historyEnvironment($dir) {
	$count = 0; 
	$html = '';
	foreach($this->showAllFiles($dir, null) as $k => $v) {  
	
		$id_gener = $this->idGenerator();
		$style = ($count % 2 == 0 ? 'background:#A9D1B1;' : 'background:#82B58C;' );
		
		$html .= ('<div class="show_all_history" 
						id="'.$id_gener.'" 
						style="'.$style.' " 
						onclick="showHistoryContent(\''.$this->encryptStr($v).'\', '.$k.', this.id);"> ');
		$html .= (substr(str_replace($dir, '', $v), 36));
		$html .= ('</div>'); 

		$html .= ('<div id="img'.$id_gener.'">'); 
				 
		$html .= $this->getSrcImg(
									$GLOBALS['sst']['icon']['cancel'],
									null,
									null,
									'onclick="deleteHistory(\''.$id_gener.'\', \''.$this->encryptStr($v).'\');"'
				);
		$html .= ('</div>') ;
		$html .= ('<div style="clear:both"> </div>');
		$count++; 				
	}
	return $html;
}

 public function isKeyExists($array, $index1, $k, $index2 ) {
	if(isset($array[$index1][$k][$index2]) ) {
		return $array[$index1][$k][$index2];
	} else {
		return NULL;
	}
 }
 
 public function createFolder($name) {
	
	//$name = $this->isDirectoryExists($name); 
	if(is_dir($name)) {
		return true;
	} else {
		if (!mkdir($name, 0776, true)) { 
			return false;
		}
		return true;
	}
 }

public function removeValArr($str, $name_table) {
	if (in_array($str, $name_table)) {
		$pos = array_search($str, $name_table);
		unset($name_table[$pos]);
	}
	return $name_table ;
}

public function styleCreditsDocTraining($n) {
	switch($n) {
		case 0:
			
		return '';
		case 1:
		
		return 'background:#FF9C41;';
		case 2:
		
		return 'background:red;';  
		case 3:
		
		return '';
		
	}
	return;
}

public function createIndexInArray($arr) {
	$i = 0;
	$items = null; 
	foreach($arr as $k => $v ) {
		$items[] = $v;
		$i++;
	}
	return (is_array($items) ? $items : $arr); 
}

public  function showAllFiles($dir, $test=null) {
	if(is_dir($path = $dir)) {
		$arr_files = array();
		$i = 0;
		foreach (new DirectoryIterator($path) as $k) {
			if($k->isDot()) continue;
			$arr_files[$i] =  $path.'/'.$k->getFilename();
			$i++;
		}
		rsort($arr_files);
		return $arr_files;
	} else {
		return false;
	}
}

public function openFindKeyAndDelete($dir, $id_user=null, $test, $ext=null) {
 
	if($f = $this->isDirectoryExists($dir)) {
		foreach (new DirectoryIterator($f) as $k) {
			if($k->isDot() || $k->getFilename() == 'index.php') continue;
			$path = $k->getPath().'/'.$k->getFilename();
			
			switch($test) {
				case'OPEN_FILE':
					$content = $this->showContentFile($path); 
					$content = json_decode($content);
					if(is_object($content)) {
						if($content->{'id_user'} == $id_user.$ext) {
							$this->deleteFile($path, null);
						}	
					}
				break;
				case'FILE':
					if($k->getFilename() == $id_user.$ext) {
						$this->deleteFile($path, null);
					}
				break;
			}	
		}
	} else {
		return false;
	}	
}
 
public  function createHistoFile($name, $content) {
	file_put_contents($name, $content);
}

public function deleteFile($name, $test=null) {  
	$admin = new AdminAuthority( ); 
	if($this->authenticity() || $test != null) { 
		if(file_exists($name)) {
			array_map('unlink', glob($name));
		} else { return false; }
	}
}

public function writeHistoFile($name, $content) {
	if(file_exists($name) && is_file($name) ) {
		file_put_contents($name, $content, FILE_APPEND | LOCK_EX);
	} 
}

public function showHistoFile($name) {
	if(file_exists($name) && is_file($name) ) {
		return file_get_contents($name, null, null); 
	}	
}

public function  putContenFile($name, $content) {
	file_put_contents($name, $content, FILE_USE_INCLUDE_PATH | LOCK_EX);
}

public function  showContentFile($name) {
	if(file_exists($name) && is_file($name)) {
		return file_get_contents($name, null, null); 
	}
}

public static function  destroy() {
	unset($_COOKIE[session_name()]); //supprimer cookie (sid)
	session_destroy(); // session detruite 
}

public function isDirectoryExists($dir, $name=null) {  
	$way = '';  
	//$name = ($name == null ? '' : $name) ;
	for($i = 0 ; $i < 10; $i++) {
		 if(is_null($name)) {
			if(is_dir($way.$dir) ) {
				return $way.$dir;
			}
			
		} else  {
			if(is_file($way.$dir.$name)) {  
				return $way.$dir.$name;
			}
		}  
		$way .= '../';
	}
	return false;
}

public function validateDate($date, $format = FORMAT_DATE) {
	$d = new DateTime($date);
	return ($d && $d->format($format) == $date);
		
	/*
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
	*/
}

public function isForbidPosition($pos=null, $index=0) {
	
	$this->isPassed();
	
	if($this->authenticity() || AdminAuthority::isSessionAdminSimple()) {
		return true;
	}  
	
	$status = $this->dbh->selectStatus(null, null); 
	
	if($pos == 'position') {
		return (in_array($index, $this->page->arr_activation[$status['position']]) ? true : false);
	} else if($pos == 'position_phd') {
		 return (in_array($index, $this->page->arr_activation_phd[$status['position_phd']]) ? true : false);
	} else {
		return false;
	} 
}

function random() {
	$letter = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','q','p','r','s','t','u','v','w','x','y','z');
	return $letter[mt_rand(0, 25)].$letter[mt_rand(0, 25)].$letter[mt_rand(0, 25)].'-';
}


public function idGenerator() {
	$letter = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','q','p','r','s','t','u','v','w','x','y','z');
	$microTime = microtime();	 
	list($a_dec,) = explode(" ", $microTime);
	$dec_hex = sprintf("%x", $a_dec * 1000000);
	return $dec_hex.'-'.$letter[mt_rand(0, 25)].mt_rand(0, 1000);
}

public function utf8_to_ascii($text, $test=null) {
    if (is_string($text)) {
		if(!function_exists ( 'preg_replace_callback' )) { return $text ; }
		if(!is_callable('utf8_to_ascii', false, $callable) ) { return $text ; }
        $text = preg_replace_callback('/\X/u', __FUNCTION__, $text);
    } else if (is_array($text) && count($text) == 1 && is_string($text[0])) {
        $text = iconv("UTF-8", "ASCII//IGNORE//TRANSLIT", $text[0]);
        if ($text === '' || !is_string($text)) {
            $text = '?';
        } else if (preg_match('/\w/', $text)) {            
            $text = preg_replace('/\W+/', '', $text);  
        }
    } else {  
        $text = '';
    }
    return $text;
}

public function cupText($str, $len=20) { 
	if(strlen($str) > $len) {
		$first_txt = substr($this->utf8_to_ascii($str), 0,  8);
		$second_txt = substr($this->utf8_to_ascii($str), -8,  20);
		return $first_txt .'...'.$second_txt;
	} else {
		return $this->utf8_to_ascii($str); 
	}
}
// si input text est disactive
public function txtEmptyInInput($str) {
	return '<span style="color:'.$GLOBALS['sst']['status_color']['value'].'"> '.$str.'</span>';
}

public function getExtensionFile($file_name) {
	$info = new SplFileInfo($file_name);
	return $info->getExtension();
}

public function statusColor($index, $test=null) {
	return $GLOBALS['sst']['status_color'][$index];
}

public function statusValue($index, $test=null) {
	 return $GLOBALS['sst']['status_value'][$index];
}

public function objectTypeActivation($step=0) {
	if( class_exists('SignatureLink') ) {
		if(is_object(SignatureLink::getSessionSignature() ) ) { return false; } 
	}	
	 
	$admin = new AdminAuthority( ); 
	if(AdminAuthority::isSessionAdminSudo()) { return true; }
	
	if(AdminAuthority::isSessionAdminSimple()) {
		$wp_data = $admin->getDataAdminSimpleWP();
		if( $wp_data['wp_data']['mod'] >= 1 ) { // 1 mod 1 simple 2 super
			return true; 
		}
		return false;
	} 
	 
	$position = $this->dbh->selectStatus(null, null);
	
	if($step == null) return false; 
	if($position['admin_confirm'] == $step ) {
	// admin  activated step 
		return true;
	} else { 
		if($step == 1) { return true; }
		if(($position['admin_confirm'] != $position['user_request'])) { return false; } else { return true; }
		//return true; // admin don't activated step
	}
}

public  function countOpenDirectory($path) {
	$i = 0;  
	if (is_dir($path)) {   
		if ($dh = opendir($path)) {  
			while (($file = readdir($dh)) !== false) {
			if($file == '.' || $file == '..') continue;  
			
				 
				if(is_dir($path.'/'.$file)) $i--;				
				$i++; 
			}
			closedir($dh);
		}
	} 
	 
	return $i;
}

public function delineateNewId($uri) {
	 
	preg_match_all('/[^.\&*?]+/', $uri, $matches);
	
	$new = array();
	if((is_array($matches)) && (isset($matches[0])) ) {
		$i = 0;
		do {
			if(strpos($matches[0][$i], '=') !== false) {
				$v = explode('=', $matches[0][$i]);
				$new[$v[0]] = $v[1]; 
			} else {
				break;
			}
			$i++;
		} while($i < count($matches[0]));
	} 
	
	/*
	if (!array_key_exists('id_user', $new)) {  
		return array();
	}
	if(!$this->dbh->isID($new['id_user']) ) {
		return array();
	}
	if($new['id_user'] != ConnectDB::isSession() ) {
		return array();
	}
	*/
	
	return $new;
}

//new 
public function showDirUpload($get=null, $name=null, $uri ) {

	$page = new PageSST();
	$dbh = new ConnectDB();
	$main = new Main();
	$admin = new AdminAuthority();
	
	print($page->showText('title_upload_file'));
	
	$f = $this->isDirectoryExists('modules/upload/', 'form.php');
	
	include_once($f);
	print('<div style="margin-top:10px;">');
		print($page->buttonReturn($get, $name, $uri));
	print('</div>');
	// errors 
	print('</div></div></div></div>'); 
	 
	$page->displayFooter(); 	
	exit;
}
	
//new
public function blockLinkUpload($path, $id_user, $option, $folder=null, $count=null) {   
	return  ' <span style="color:green;"> ( '. $this->countOpenDirectory($path) . ' ) </span>' .
			$this->getLinkUpload($option, $folder, null,  $count, $path);
}

//new
public function getLinkUpload($option, $folder=null, $deft=null, $count=null, $p=null) {

	$url = $_SERVER['REQUEST_URI'].
			'&upload='.$this->dbh->idGenerator().
			'&option='.$option.
			(!is_null($deft) ? '&deft='.$deft : '').
			'&folder='.(!is_null($folder) ? $folder : 'skip');

	$html = '<a id="upload_'.(is_null($count) ? $this->dbh->idGenerator() : $count ) .'" href = "'.$url.'">';
	
	$html .= $this->getSrcImg(
							$GLOBALS['sst']['icon']['upload48'],
							null,
							null,
							null,
							'cursor:pointer;',
							'img_upload_'.(is_null($count) ? $this->dbh->idGenerator() : $count )
			);
 					
	$html .='</a>';
	
	$dir = $this->isDirectoryExists($p);
	$f_array = scandir($dir);
    for ($i = 0; $i < sizeof($f_array); $i++) {
		$pi = pathinfo($f_array[$i]);
		if ($pi['extension'] != 'pdf') continue;
		$link = $dir . '/' . $f_array[$i];
		if (strpos($f_array[$i],'[SEPARATOR]') !== FALSE) {
			$fn = explode('[SEPARATOR]',$f_array[$i]);
			$fn = $fn[1];
		}
		else $fn = $f_array[$i];
		$html .= $this->linkPDFDialog($link,  $fn, '', 'X');
	}	

	return $html;
}

public function blockImgUploadSimple($path, $id=null, $test=null ) {
	return  ' <span style="color:green;"> ( '. $this->countOpenDirectory($path) . ' ) </span>';
}

public function paginationPrintLinks($inactive, $text, $offset='', $link,  $select_user=null) {

	if($inactive) {
		print '<span class="p_link_inactive"> '.$text.' </span>';
	} else {
		print ' <a href="'.htmlentities($_SERVER['PHP_SELF']).$link.'&offset='.$offset.$select_user.'"> 
					<button class="p_link_active">'.$text.'</button> 
				</a> ';
	}
	
}

public function paginationIndexedLinks($total, $offset, $show_pages, $link=null, $select_user=null) {
	//$separator = ' | ';
	$this->paginationPrintLinks($offset == 1, $this->b_prev, $offset- $show_pages, $link, $select_user);
	echo ' <select id="pagination" onchange="pagination()"; style="width:95px;">';
	for($start = 1, $end = $show_pages; $end < $total; $start += $show_pages, $end += $show_pages) {
	
		if($offset == $start) {
			$this->paginationPrintLinks($offset == $start, "$start-$end", $start, $link, $select_user);
			echo '<option value= "'.$start.'" selected> '."$start-$end".'</option> ';
		}  else {
			echo '<option value= "'.$start.'"> '."$start-$end".'</option> ';
		}	
		//echo ' offset  > '.$offset.' <  end  > '.$end.' < '  .$start.' ('.($offset == $start).') ';
		 //$this->paginationPrintLinks($offset == $start, "$start-$end", $start, $link, $select_user);
	}
	
	echo ' </select>';
	
	$end =(($total > $start) ? -$total : '' );
	//print $separator;
	//$this->paginationPrintLinks($offset == $start, "$start$end", $start, $link, $select_user);
	//print $separator;
	 $this->paginationPrintLinks($offset == $start, $this->b_next, $offset+$show_pages, $link, $select_user);
}

public function curPageName() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

public static function  addDate($d=null) {

	$m = new DateTime();
	 
	if(preg_match('/\s/',$d)) {
	
		if(is_callable(array($m, 'createFromFormat'))) {
			$exp = explode(' ', $d); 
			//$new = DateTime::createFromFormat(FORMAT_DATE, $exp[0]);
			$date = new DateTime($exp[0]);
			
			if(!($date && $date->format(FORMAT_DATE) === $exp[0])) {
				return $d;
			} else {
				$d = $exp[0];
			}
		} else {
			return date(FORMAT_DATE, strtotime('+2 years'));
		}	
	} 
 
	if(is_callable(array($m, 'createFromFormat'))) {
	
		$date = new DateTime($d);
		$date->add(new DateInterval('P2Y'));
		return $date->format(FORMAT_DATE);
	
		/*
		$date = DateTime::createFromFormat(FORMAT_DATE, $d);
		$date->add(new DateInterval('P2Y'));
		return $date->format(FORMAT_DATE);
		*/
		 
	} else {
		if(strpos($d, ' ') !== false) {
			$exp = explode(' ', $d);
			$exp = explode(' ', $exp[0]);
			return $exp[0].'-'.$exp[1].'-'.($exp[2]+2);
		} else {
			$exp = explode('-', $d);
			return $exp[0].'-'.$exp[1].'-'.($exp[2]+2);
		}
	}
	//if($date == null) return;
	//return date(FORMAT_DATE ,strtotime("+2 years"));
}

public static function addYears($date, $days = 365) {
	return date(FORMAT_DATE, strtotime(date(FORMAT_DATE, strtotime($date)) . " + ".$days." day"));
}

public function validMail($address) {  
   $test_mail='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';  
   if(preg_match($test_mail, $address))  
      return true;  
   else  
     return false;  
}
/*
[App-CDD] Igor Kavesin : Pré-admission
[App-CDD] Igor Kavesin : Admission
[App-CDD] Igor Kavesin : Report confirmation
[App-CDD] Igor Kavesin : Confirmation
[App-CDD] Igor Kavesin : Formation doctorale
[App-CDD] Igor Kavesin : Défense privée
[App-CDD] Igor Kavesin : Programme additionnel
[App-CDD] Igor Kavesin : Co-tutelle
*/

public function sendMailFromSSTOffice($sub, $r=null, $test=null) {
	
	if(!$this->validMail(MAIL_OFFICE) && !is_array($r)) { 
		print('ERROR MAIN # 4567854'); return false; 
	}	
		
		$headers  = "From: <".MAIL_OFFICE.">\r\n";
		$headers .= "Reply-To: ".NOT_REPLAY_SST."\r\n";
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		$subject = '';
		 
		$data = $this->dbh->showRegistration();
		if( (!isset($r['id_user']) ) && ( !$this->dbh->isID($r['id_user']) ) ) {
			print('ERROR MAIN # 4756448'); return false; 
		}
		 
		if( $r['id_user'] !== $data['id_user'] ) { 
			print('ERROR MAIN # 475863545'); return false;
		}
		
	$gen = $this->dbh->idGenerator();
	
	$user_name = ($data['last_name'] . ' ' . $data['first_name']);
	$check = true; 
	
	switch($sub) {
		case 'PREADMISSION':

			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_PREADMISSION'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your pre-admission request. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			 		
		break;
		case 'ADMISSION':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_ADMISSION'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your admission request. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
						
		break;
		case 'CONFIRMATION_PLANNING':
			
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_CONFIRMATION_PLANNING'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your confirmation planning request. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			 
		break;
		case'SIGNATURES':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_ADMISSION'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your signatures. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			
		break;
		case 'CONFIRMATION_SUBMIT':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_CONFIRMATION_SUBMIT'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your confirmation. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
						
		break;
		case 'PRIVATE_DEFENCE_SBC':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_PRIVATE_DEFENCE_SBC'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your private defense. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			 
		break;
		case'PUBLIC_DEFENCE':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_PUBLIC_DEFENCE'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your public defense. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			
		break;
		case'MY_SUPERVISORY_PANEL':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_MY_SUPERVISORY_PANEL'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated your supervisory panel. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
			
		break;
		case 'MY_ADDITIONAL_PROGRAMME_UPLOADED':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_MY_ADDITIONAL_PROGRAMME'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your additional programme. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
						
		break;
		case'MY_ADDITIONAL_PROGRAMME':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_MY_ADDITIONAL_PROGRAMME_SIMPLE'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your additional programme. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
				
		break;
		case 'MY_DOCTORAL_TRAINING':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_MY_DOCTORAL_TRAINING'));
			// this is text for the user what he will see 
			$content = 'Dear '.ucfirst($data['title']). ' ' .ucfirst($data['last_name']).' ,<br><br>';
			$content.= 'The PhD office has updated the status of your doctoral training request. ';
			$content.= '<a href="'.SERVER_NAME.'" target="_blank"> Use this link to reach your file online. </a><br><br>';
						
		break;
		case 'MY_COTUTELLE':
		
			$subject = str_replace('%username%', $user_name, $this->page->showText('MAIL_OFFICE_MY_COTUTELLE'));
			$content = '';
			$check = false; 
			
		break;
	}
	
	$content .= 'Yours sincerely, <br><br>';
	$content .= 'PS. If you have any concern with this request, you may contact the thesis supervisor ';
	$content .= 'or the <a href = "https://uclouvain.be/fr/secteurs/sst/secretariat-contact.html" target="_blank">PhD office</a>.';
					
	$subject = str_replace('%domain%', $GLOBALS['sst']['select_phd_reduce'][$data['phd']], $subject);
	
	if(SEND_MAIL_FROM_SST_OFFICE) {
	
		if($check && $test == 'TO_USER') {
			($this->validMail($data['e-mail']) ? mail($data['e-mail'], $subject, $content, $headers) : false);
		}	
		
		$office = false;
		if($test != 'TO_USER') {
			$office = (mail(MAIL_OFFICE, $subject, '', $headers) ? true : false ); 
		}
		
		return ($office ? true : false); 
		
	} else {
		if($folder_mail = $this->isDirectoryExists(DIR_MAIL_OFFICE)) {
		
			$this->putContenFile( 
					$folder_mail.(
						ConnectDB::isSession() ? ConnectDB::isSession().$sub.'888'.$gen : $this->dbh->idGenerator() 
					) , $subject
			);
			
			return true;
		} else {
			print('ERROR MAIN # 47654415');
			return false;
		}	 
	}	
}

public function sendMailFromSST($sub, $r=null, $test=null) {

	$mail = (
			isset($r['mail']) ? $r['mail'] :
			(isset($r['email']) ? $r['email'] : 
			(isset($r['e-mail']) ? $r['e-mail'] : 
			null)) 
			);
	 
	if(!$this->validMail($mail) && !is_array($r)) { return false; }	
		
		$headers  = "From: <".MAIL_FROM_SST.">\r\n";
		$headers .= "Reply-To: ".NOT_REPLAY_SST."\r\n";
		$headers .= 'MIME-Version: 1.0' . "\n";
		$headers .= "Content-Type: text/html; charset=utf-8\r\n";
		$subject = '';
		
		$get_mail = $this->dbh->showRegistration();
		$mail_user = $get_mail['e-mail'];
					
	switch($sub) {
		case 'ADMISSION':
		// mail 
		break;
		case 'SIGNATURE_LINK':
			
			$subject  = $this->page->showText('mail_object_SIGNATURE_LINK');
			
			$dir = null;	 
			$user = $this->dbh->showRegistration();
				
			// Supervisor (or co-supervisors)
			$iu = (isset($r['id_user']) ? $r['id_user'] : '' ) ;
			$it = 'Download admission request details (PDF document).';
			$pdf_user = '<br><a href='.SERVER_NAME.'modules/pdf/pages/inc_tmp_pdf.php/?test=adm_sign&pdf=get&id='.$iu.' target="_blank">'.$it.'</a><br><br>';
					
			if(isset($r['id_adm_supervisory_panel']) && ($r['employment'] == 'Preadmission') ) { /* && supervisor*/

				$dir = $r['id_adm_supervisory_panel']; // select_person
				$label = 1; 
					
				$content = ' Dear '.$GLOBALS['sst']['select_person'][$r['titel']]. ' ' .ucfirst($r['lastname']).' ,<br><br>';
				$content .= ucfirst($user['first_name']) .' '.ucfirst($user['last_name']).' has recently submitted an admission request ';
				$content .= 'to the PhD programme at the Université catholique de Louvain under your supervision (or cosupervision). <br><br>';
				$content .= 'The CDD invites you to review and sign this admission request.'; 
				$content .= 'You can review the details of the admission request and sign the application using the second link below. ';
				$content .= 'You can also download the application details as a PDF document using the first link below. <br><br>';
				$content .= 'If these links bring you to the login page of the application, we ask you to notify your consent directly ';
				$content .= 'to the PhD candidate by email (<a href=mailto:'.$mail_user .'>'.$mail_user .'</a>). <br>';
				$content .= $pdf_user;
				$name_link = 'Click here (ONLY ONCE) to review the admission details online and sign the request.';
				// Signatures of the supervisory panel 
				
			} else if(isset($r['id_adm_supervisory_panel']) && ($r['employment'] == 'Admission') ) {/* && member*/ 
			
				$dir = $r['id_adm_supervisory_panel'];
				$label = 2; 
				/*
					$supervisor = new Supervisor();
					$id_adm_supervisor = $supervisor->selectSupervisor();
					
					$supervisor_name = $this->dbh->admissionSupervisoryPanelSelect(null, $id_adm_supervisor); 
				*/
					
				$s = $this->dbh->admissionSupervisoryPanelSelect('Preadmission');
				$sup = '';
				if(is_array($s) && sizeof($s) > 0) {
					foreach($s as $k => $v) {
						if((sizeof($s)-1) == $k) {
							$sup = substr($sup, 0, strlen($sup)-1);
							$sup .= ($k < 1 ? ' ' : ' and ').
										$GLOBALS['sst']['select_person'][$s[$k]['titel']].
										' '.ucfirst($s[$k]['lastname']).' '.ucfirst($s[$k]['firstname']). '. ';	
							break;
						}
						$sup .= ' '.
									$GLOBALS['sst']['select_person'][$s[$k]['titel']].
									' '.ucfirst($s[$k]['lastname']).' '.ucfirst($s[$k]['firstname']). ',';	
					}  
				}
					 
				$content = ' Dear '.$GLOBALS['sst']['select_person'][$r['titel']]. ' '. $r['lastname'].' ,<br><br>';
				$content .= ucfirst($user['first_name']). ' '.ucfirst($user['last_name']).' has recently submitted an admission request ';
				$content .= 'to the PhD programme under the supervision of '; // important!!!!  
				$content .= $sup. ' <br><br>';
				$content .= 'You are listed in the admission request as member of the supervisory panel of the thesis. ';
				$content .= 'As part of the application procedure, you are invited to verify and sign this application. <br><br>';
				$content .= 'You can review the details of the admission request and sign the application using the second link below. ';
				$content .= 'You can also download the application details as a PDF document using the first link below. <br><br>';
				$content .= 'If these links bring you to the login page of the application, we ask you to notify your consent directly ';
				$content .= 'to the PhD candidate by email (<a href=mailto:'.$mail_user .'>'.$mail_user .'</a>). <br>';
				$content .= $pdf_user;
				$name_link = 'Click here (ONLY ONCE) to review the admission details online and sign the request.';
				
			} else if(isset($r['id_my_supervisory_panel'])) {  /* PRIVATE DEFENSE */
			
				$dir = $r['id_my_supervisory_panel'];
				$my_supervisor = $this->dbh->privateSupervisoryPanelSelectNotSession($user['id_user'], $dir);
				$label = 3; 
				$content = 'Dear ' . $GLOBALS['sst']['select_person'][$my_supervisor['titel']].' '.$my_supervisor['lastname'].',<br><br>';
				$content .= 'This email is sent to you in your quality of member of the supervisory panel ';
				$content .= 'of the PhD thesis of '.ucfirst($user['first_name']).' '.ucfirst($user['last_name']) .'. ';
				$content .= 'The PhD commission invites you to verify and sign ';
				$content .= 'the constitution of the final board that has been submitted by the PhD candidate using the following link : <br><br>';
				$name_link = 'Click here (ONLY ONCE) to reach the board validation page';
				
			} else if(isset($r['id_institute_select'])) {
			
				$label = 4; 
				$id_institute = $this->dbh->instituteSelectSelected(ConnectDB::isSession(), $r['id_institute_select']);
				$data_institute = $this->dbh->instituteSelect($id_institute['id_institute']);

				$adm_vals = $this->dbh->privateJuryMembersSelect(null, $r['id_user']);
					foreach($adm_vals as $k => $v) { 
						if(preg_match ("/^(Admission|Preadmission|Role)+$/", $adm_vals[$k]['employment']) ) {
							if($adm_vals[$k]['members'] == 3) {
								$p_ti = $GLOBALS['sst']['select_person'][$adm_vals[$k]['titel']] ;
								$p_ln = $adm_vals[$k]['lastname'] ;
								$p_fn = $adm_vals[$k]['firstname'] ;
							 break;
							}
						}	
					} 
				$inst = $this->dbh->getContentInstitute($r['id_user']);

				$dir = $r['id_institute_select'];
				
				$content = 'Dear '.(isset($inst['institute']) ? $inst['institute'] : '' ).' President, <br><br>';
				$content .= ucfirst($user['first_name']). ' '.ucfirst($user['last_name']).', PhD candidate in your institute, ';
				$content .= 'has recently submitted the constitution of the jury for ';
				$content .= 'his/her private and public defences. The proposed president of the jury is ';
				$content .= ( isset($p_ti) ? $p_ti : ''  ). ' '.( isset($p_ln) ? $p_ln : ''  ) .' '.( isset($p_fn) ? $p_fn : ''  ).'.';
				$content .= '<br><br>The PhD commission invites you to click the following link to notify your agreement ';
				$content .= 'with the president designation : <br><br>';
				
				$name_link = 'Click here (ONLY ONCE) to agree with the proposed president ';
			}  

			if($dir != null) {
				if($class_file = $this->isDirectoryExists(DIR_FOLDER_SIGNATURE_LINK, 'class_signature_link.php')) {
						
					include_once($class_file);
					$signature_link = new SignatureLink();
					$signature_link->buildAuthenticationUrl('display.php?link_signatures&', $dir);
					$link = $signature_link->getLinkSupervisory(); // link 
					$content = addslashes($content);
						  
					$json = '{ "id_user":"'.ConnectDB::isSession().'",
									"link_signatures": "'.$link.'",
									"whence": "'.$label.'",
									"content": "'.str_replace("\'" , "'" , $content).'" }';
						
					if($link_file = $this->isDirectoryExists(DIR_FOLDER_SIGNATURE_LINK_SIMPLE)) {
						$this->putContenFile($link_file.$dir, $json);
					} else {
						print('ERROR MAIN # 54745542');
						return ;
					}
					
					 	
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					$content .= "\n";
					 
					
					$content .= '<a href="'.$link.'">'.(isset($name_link) ? $name_link : 'Application SST' ).'</a><br><br>';
					$content .= 'Yours sincerely, <br><br>';
					$content .= 'The team of the CDD "'.(is_numeric($user['phd']) ? $GLOBALS['sst']['select_phd'][$user['phd']] : '' ).'" <br><br>';
					$content .= 'PS. If you have any concern with this request, you may contact the thesis supervisor ';
					$content .= 'or the <a href = "https://uclouvain.be/fr/secteurs/sst/secretariat-contact.html" target="_blank">PhD office</a>.';
				} else {
					print('ERROR MAIN # 2454584754 ');
					return ;
				}
			}	
					
		break;
		case 'OVERWRITE_PWD_WP':
			
			$subject  = $this->page->showText('mail_object_OVERWRITE_PWD_WP');
			
				if(isset($r['wp_id']) ) {
					if(is_array($wp_user = $this->dbh->wpUserSelect($r['wp_id']))) {
						$wp_ln = $wp_user['lastname'];
						$wp_fn = $wp_user['firstname'];
					} 
				}
				
			$content  = 'Dear '.(isset($wp_fn) ? ucfirst($wp_fn) : '' ).'  '.(isset($wp_ln) ? ucfirst($wp_ln) : '' ).', <br><br>';
			$content .= 'This is a confirmation of the recent password modification for your account on the PhD management system ';
			$content .= 'of the Secteur des Sciences et Technologies of UCL. Your new password is :</br><br> '; 
			$content .= (isset($r['new_pwd']) ? $r['new_pwd'] : 'PASSWORD ERROR').'<br>';
			$content .= '</br> You can now login to the PhD management system. Once logged in, you can
						modify this password in the <i>My Profile</i> area.<br><br>';
			$content .= 'Yours sincerely, <br><br>';
			$content .= 'The SST PhD office. <br>';
					
		break;
		case 'CREATE_USER_WP':
			
			$subject  = $this->page->showText('mail_object_CREATE_USER_WP');
					
			$content = 'Dear colleague, <br><br>';
			$content .= 'As a member of one of the CDDs of UCL/SST, you have been attributed a login on the ';
			$content .= 'on-line PhD management system. <br><br>Using this login, you will be able to view selected ';
			$content .= 'content of the PhD database. The PhD office will inform you soon on the features and use of ';
			$content .= 'the online application. <br><br>'; 
			$content .= 'Login: '.$mail.'<br>';
			$content .= 'Password: '.(isset($r['wp_passwd']) ? $r['wp_passwd'] : 'PASSWORD ERROR').'<br><br>';
			$content .= 'Yours sincerely, <br><br>';
			$content .= 'The SST PhD office. <br>';
				
		break;
		case 'PASSWORD_FORGOT':
			
			$subject  = $this->page->showText('mail_object_PASSWORD_FORGOT');
			
			$content = 'This message has been generated automatically by the online PhD management system ';
			$content .= 'of the Secteur des Sciences et Technologies of UCL following an online request ';
			$content .= 'to reset the password of your account. The new password is :</br> '; 
			$content .= (isset($r['pwd']) ? $r['pwd'] : 'PASSWORD ERROR').'</br>';
			$content .= '</br> You can now login to the PhD management system. Once logged in, you can
								modify this password in the <i>My Profile</i> area.<br><br>';
			$content .= 'Yours sincerely, <br><br>';
			$content .= 'The SST PhD office. <br>';
					
		break;
		case 'MY_DOCTORAL_TRAINING':
					
			$subject  = $this->page->showText('mail_object_MY_DOCTORAL_TRAINING');
			
			$supervisor = new Supervisor();
			$link = 'display.php?page=my_doctoral_training&'.
					GET_LINK_DOCTORAL_TRAINING.'='.
					$this->page->getKeysInArray($this->page->doc_training->docTrainingMenu(), 6);
			// $GLOBALS['sst']['select_phd']		
			if($supervisor->buildAuthenticationUrl($link, $r['id_user'])) { return false;}
					
			$link = $supervisor->getLinkSupervisory();		
			$link_file = $this->isDirectoryExists(DIR_FOLDER_SUPERVISOR_SIMPLE);
			//echo  DIR_FOLDER_SUPERVISOR_SIMPLE .$this->isDirectoryExists(DIR_FOLDER_SUPERVISOR_SIMPLE);
			$this->putContenFile($link_file.$r['id_user'], json_encode($r['json']));
			$data_user = $this->dbh->showRegistration() ;   
					
			$content = 'Dear colleague, <br><br>';
			$content .= ucfirst($data_user['first_name']) .'  '.ucfirst($data_user['last_name']).' has recently submitted a request ';
			$content .= 'of validation of one or more doctoral training activities. ';
			$content .= 'In your quality of PhD supervisor, the CDD invites you to give your formal approval ';
			$content .= 'on the content of this request. <br><br>'; 
			$content .= 'If you approve the request, you testify that '.ucfirst($data_user['first_name']) .'  '.ucfirst($data_user['last_name']);
			$content .= ' has achieved each of the activities mentioned in the request. ';
			$content .= 'If you disagree with the content of the request, ';
			$content .= 'we ask you to notify '.ucfirst($data_user['first_name']) .'  '.ucfirst($data_user['last_name']).' of your decision.<br><br>';
			$content .= 'You can view the request details on line and communicate your decision using the following link: <br><br>';
			$content .= '<a href="'.$link.'">Click here (ONLY ONCE) to access to the on-line application.</a><br><br>';
			$content .= 'Yours sincerely, <br><br>';
			$content .= 'The team of the CDD "'. (is_numeric($data_user['phd']) ? $GLOBALS['sst']['select_phd'][$data_user['phd']] : '' ).'" <br>';
						
		break;
		case 'REGISTRATION':
			
			$subject  = $this->page->showText('mail_object_REGISTRATION');

			$content = 'Your account has been created on the online interface for the management of your PhD academic programme. ';
			$content .= 'Please keep a copy of your account details below. </br></br>';
			$content .= 'If you are receiving this message and have not created your account personally, ';
			$content .= 'it means that the PhD office has started moving your paper file into the new online system. ';
			$content .= 'If this is the case, do not try to access the online interface before you receive further instructions from the PhD office ';
			$content .= '(during the academic year 2017-2018).  </br></br>';
			//$content .= 'Please note that the doctoral SST platform in currently under development. May we ask you to avoid connecting at this stage!</br></br>';
			$content .= '<p><b>Login: </b>'. $mail.'</p>';
			$content .= '<p><b>PhD domain: </b> '.$GLOBALS['sst']['select_phd'][$r['phd']].'</p>';
			$content .= '<p><b>Last Name:  </b> '.(isset($r['last_name']) ? $r['last_name'] :  'ERROR LAST NAME').'</p>';
			$content .= '<p><b>First Name: </b> '.(isset($r['first_name']) ? $r['first_name'] : 'ERROR FIRST NAME').'</p>';
			$content .= '<p><b>Sciences:   </b> '.(is_numeric($r['sciences']) ? $GLOBALS['sst']['select_sciences'][$r['sciences']] : $r['sciences']).'</p>';
			$content .= '<p><b>Password:   </b> '.(isset($r['pwd']) ? $r['pwd'] : 'ERROR PASSWORD').'</p>';
			$content .= '<p><b>Date:       </b> '.(isset($r['date_create']) ? $r['date_create'] :  'ERROR DATE').'</p>';	
			$content .= '</br> Yours sincerely, <br>';
			$content .= 'The team of the on line PhD management system';
			//$content = wordwrap($content, 70, "\r\n");
					
		break;	
	}
		
	if(SEND_MAIL_FROM_SST) {  
		return (mail($mail, $subject, $content, $headers) ? true : false ); 
	} else {
		if($folder_mail = $this->isDirectoryExists(DIR_MAIL_SST)) {
			$this->putContenFile( $folder_mail.(ConnectDB::isSession() ? ConnectDB::isSession().'='.$this->dbh->idGenerator() : $this->dbh->idGenerator() ) , $content);
			return true;
		} else {
			print('ERROR MAIN # 4756765');
			return false;
		}	 
	}
}

public function deleteLinkSupervisor($r=null) {

	if(is_array($r)) {
		$dir = null;
		if(isset($r['id_adm_supervisory_panel'])) {
			$dir = $r['id_adm_supervisory_panel'];
		} else if(isset($r['id_my_supervisory_panel'])) {
			$dir = $r['id_my_supervisory_panel'];
		} else if(isset($r['id_institute_select'])) {
			$dir = $r['id_institute_select'];
		}
		if($dir != null && $this->dbh->isID($dir)) {
			$link_file = $this->isDirectoryExists(DIR_FOLDER_SIGNATURE_LINK_SIMPLE); 
			$this->deleteFile($link_file.$dir, $test=null);
		}
	} return false;
}

public function authenticity() {
	$main = new Main();
	if(AdminAuthority::isSessionAdminSudo()) {
		return true;
	} else if(AdminAuthority::isSessionAdminSimple() && $this->wpIsAuthorizedPage()) {
		return true;
	}
	
	return false; 
}

public function messageWarning($str, $js=null) {
	$html = '<div style=" margin:5px;">';  
	$html .= '<div style=""> ';
		//$html .= '<img src="'.$GLOBALS['sst']['icon']['important'].'" align="middle"/> ';
		$html .= '<span style="color:red;"> ';
		$html .= ' <b> '.$str.' </b> ';
		$html .= ' '.$js.' ';	
		$html .= '</span> ';
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}

function cleanly($str) {

	$str = preg_replace('/\s/', '-', $str);
	return preg_replace('/[^a-zA-Z\-]/', '', strtolower($str));
}

function getContentsOfFile($folder, $dir,  $obj) {

	if($obj->name == 'academic') {
		if( is_array($academic  = $this->dbh->showUploadedYear($obj->id))) {
			for($i = 0 ; $i < count($academic); $i++ ) {
				$content[] = $academic[$i]['id_upload_academic'].'deft_id_upload_academic'. $dir.$folder.'/'.$academic[$i]['title']; 
			}
		}
	}
	if($obj->name == 'diploma') { 
		if( is_array($diploma  = $this->dbh->showUploadedDiploma($obj->id))) {
			for($i = 0 ; $i < count($diploma); $i++ ) {
				$content[] = $diploma[$i]['id_upload_diploma'].'deft_id_upload_diploma'. $dir.$folder.'/'.$diploma[$i]['title'];
			}
		}
	}
	
	return (isset($content) ? $content : null);
}


public function showHTMLUploadedFiles($dbh, $folder, $dir , $activation=null, $obj=null) {
	 
	$boolean = false;
	if(!is_array($show_content = $this->dbh->showAllImgPath($dir, $folder)) && (!empty($show_content)) ) {
		return false; 
	}
	
	if(is_object($obj)) { 
		$show_content = $this->getContentsOfFile($folder, $dir, $obj); 
	}
	
	$boolean = $this->statusPageUpload($this->dbh); 
	
	if(is_array($admissin_home = $this->dbh->admissionHomeCheck())) {  
		if($admissin_home['state'] == '5') { 
			$boolean = false; 
		}
	}  
	
	 
	if(!is_array($show_content))  { 
		return false; 
	}  
	
	$this->displayUploaded($show_content, $boolean, $activation);
	
}

public function displayUploaded($content, $boolean, $activation) {
	
	if( !is_array($content) ) { return false; }

	foreach($content as $key => $value ) { 
	
		if(is_dir($value)) continue;
		
		$exp = explode('/', $value);
		$gen = $this->idGenerator();
		 
		print('<li id="'.$gen.'">');  
			print('<span class="prog_t">Name: </span>');

			$name = $exp[(sizeof($exp)-1)] ; 

			print('<em>'.(strlen($name) > 55 ? substr($name, 0, 55).'...' : $name).'</em>');
			print('<div class="progressbar"> </div>');
		
			print('<p class="status" style="float:left;">status.. OK</p>'); 
			
				print('<p class="status" style="float:right;">');
					print('<a href="'.$this->dividingUp($value).'" style="color:#5AAD6D;" target="_blank">');
						print('<b>DOWNLOAD</b>'); 
					print('</a>');
				print('</p>');
			  
			$boolean = ($this->authenticity() ? true : (AdminAuthority::isSessionAdminSimple() ? false : $boolean)) ;
			$boolean = (class_exists('SignatureLink') && is_object(SignatureLink::getSessionSignature()) ? false : $boolean);
		 
			if(($boolean && $activation == null) || (is_numeric($activation) &&  $activation === 0) ) { 
				if(is_object(SignatureLink::getSessionSignature())) {
					print('');
				} else {
					print('<span class="cancel" onclick="butDeleteIMG(\''.$this->encryptStr($value).'\', \''.$gen.'\');">&nbsp;</span>');
				} 
			}
			
		print('</li>');
	}
}

public function dividingUp($value) {

	if(preg_match('/(deft_id_upload_academic|deft_id_upload_diploma)/', $value, $match )) {
	
		if($match[0] == 'deft_id_upload_academic') {
			$spl = explode('deft_id_upload_academic', $value);
		} else if($match[0] == 'deft_id_upload_diploma') {
			$spl = explode('deft_id_upload_diploma', $value);
		}
			
		return (isset($spl[1]) ? $spl[1] : $value);
	}	
	return $value;
}

public function statusPageUpload($dbh) {
	 
	$perse = $this->parseQueryString(self::currentPageURL());
	$perse = (isset($perse['page']) ? $perse : null); 
	if($perse == null) return false; 
	$boolean = true; 
	
	if(is_array($admissin_home = $this->dbh->admissionHomeCheck())) {  
		if($admissin_home['state'] == '5') {
			return false;
		}
	}
	
	switch($perse['page']) {
		case'my_phd':
			if(isset($perse[GET_LINK_IN_MY_PHD])) {
				if($perse[GET_LINK_IN_MY_PHD] == 'admission') {
					 
					if(is_array($status = $this->dbh->selectStatus()) ) {  
					
					// This is a big mistake if admin click on button Save in option ( ADMISSION TYPE )
					// then to avoid everything return true...  
					
						if(is_array($admis = $this->dbh->admissionHomeCheck())) {
							
							if($status['position'] == 1 && $status['position_phd'] == 1
								&& $admis['state'] == 1 && $admis['employment'] == 'Admission'
								) {
								return true;  
							}
							
							if($admis['state'] == 1 || $status['user_request'] >= 1) { return false ; } 
							if($status['position'] > 1 || $status['position_phd'] > 1) { return false ; } 
						}
					}
				} else if($perse[GET_LINK_IN_MY_PHD] == 'confirmation') {
					if(isset($perse[GET_LINK_CONFIRMATION])) {
						if($perse[GET_LINK_CONFIRMATION] == 'planning') {
							if(is_array($status = $this->dbh->confPlanningStatusSelect()) ) {
								if($status['status'] > 0) {
									$boolean = false ;	
								}
							}
						} else if($perse[GET_LINK_CONFIRMATION] == 'results') {
							if(is_array($status = $this->dbh->confResultSelect()) ) {
								if($status['select_confirm_state'] > 1) {
									$boolean = false ;	
								}
							}
						}
					}
				} else if($perse[GET_LINK_IN_MY_PHD] == 'private_defence') {
					if(is_array($status = $this->dbh->privateDefenceStatusSelect()) ) {
						if($status['state'] > 1) {
							$boolean = false ;
						}
					}
				} else if($perse[GET_LINK_IN_MY_PHD] == 'public_defence') { }
			}
		break;
		case'my_doctoral_training':
			if((isset($perse['upload'])) && (isset($perse['folder'])) ) {
				if($perse['upload'] == 'conference') {
					if(is_array($status = $this->dbh->docTrainingConferenceSelect())) {
						foreach($status as $k => $v) {
							if($status[$k]['dir'] == $perse['folder']) {
								if($status[$k]['status'] == 2 ||
									$status[$k]['status'] == 3 ||
									$status[$k]['status'] == 5 ||
									$status[$k]['status'] == 6 ) {
									return false ;
								}
							}
						}
					}  	 
				} else if($perse['upload'] == 'journal_papers') {
					if(is_array($status = $this->dbh->docTrainingJournalPapersSelect())) {
						foreach($status as $k => $v) {
							if($status[$k]['dir'] == $perse['folder']) { 
								if($status[$k]['status'] == 2 ||
									$status[$k]['status'] == 3 || 
									$status[$k]['status'] == 5 || 
									$status[$k]['status'] == 6) {
									return false ; 
								}
							}
						}
					}
				} else if($perse['upload'] == 'course') {
					if(is_array($status = $this->dbh->docTrainingCoursesSelectSimple())) {
						foreach($status as $k => $v) {
							if($status[$k]['dir'] == $perse['folder']) { 
								if($status[$k]['status'] == 2 ||
									$status[$k]['status'] == 3 ||
									$status[$k]['status'] == 5 ||
									$status[$k]['status'] == 6) {
									return false ; 
								}
							}
						}
					}
				
				} else if($perse['upload'] == 'list') {
					if(is_array($status = $this->dbh->docTrainingConferenceListSelectItem())) {
						foreach($status as $k => $v) {
							if($status[$k]['dir'] == $perse['folder']) {
								if($status[$k]['status'] == 2 ||
									$status[$k]['status'] == 3 ||
									$status[$k]['status'] == 5 ||
									$status[$k]['status'] == 6) {
									return false ; 
								}
							}
						}
					}	
				} 
			}
		break;
		case'my_additional_programme':
			return false ; 
		break;
		case'my_cotutelle':
		
		break;
		case'get_upload':
			/*
			if(isset($perse['file'])) {
				if($perse['file'] == 'diploma' || $perse['file'] == 'academic') { 
					if(is_array($status = $this->dbh->selectStatus()) ) {
						if($status['user_request'] > 0 || $status['position_phd'] > 1 ) {
							$boolean = false ;
						}
					}
					
				}
			}
			*/
		break;
	}
	return $boolean;
}

public function parseQueryString($url, $qmark=true) {
    if ($qmark) {
        $pos = strpos($url, "?");
        if ($pos !== false) {
            $url = substr($url, $pos + 1);
        }
    }
    if (empty($url)) return false;
	
    $tokens = explode("&", $url);
    $url_vars = array();
	
    foreach ($tokens as $token) {
        $value = $this->stringPair($token, "=", "");
        if (preg_match('/^([^\[]*)(\[.*\])$/', $token, $matches)) {
            $this->parseQueryStringArray($url_vars, $matches[1], $matches[2], $value);
        } else {
            $url_vars[urldecode($token)] = urldecode($value);
        }
    }
    return $url_vars;
}

function stringPair(&$a, $delim='.', $default=false) {
    $n = strpos($a, $delim);
    if ($n === false) return $default;
    $result = substr($a, $n+strlen($delim));
    $a = substr($a, 0, $n);
    return $result;
}

function parseQueryStringArray(&$result, $k, $array_keys, $value) {
    if (!preg_match_all('/\[([^\]]*)\]/', $array_keys, $matches))
        return $value;
    if (!isset($result[$k])) {
        $result[urldecode($k)] = array();
    }
    $temp =& $result[$k];
    $last = urldecode(array_pop($matches[1]));
    foreach ($matches[1] as $k) {
        $k = urldecode($k);
        if ($k === "") {
            $temp[] = array();
            $temp =& $temp[count($temp)-1];
        } else if (!isset($temp[$k])) {
            $temp[$k] = array();
            $temp =& $temp[$k];
        }
    }
    if ($last === "") {
        $temp[] = $value;
    } else {
        $temp[urldecode($last)] = $value;
    }
}


public function isBrowse($activation=null) {

	if( class_exists('SignatureLink') ) {
		if(is_object(SignatureLink::getSessionSignature()) ) { return false; } 
	}
	 
	if($this->authenticity()) { 
	
		return true;
		
	} else {
	
		if(is_numeric($activation) &&  $activation === 0) {
			return true;
		} else if(is_numeric($activation) &&  $activation === 2) {
			return false;
		} else if($this->statusPageUpload(new ConnectDB()) )  {	 
			return true;
		} else {
			return false;
		}
		
	}	
	
	return false;
	 
}

public function datewithoutSpace($date=null) {

	if(is_array($date) ) { $date = $date['date']; } 
	
		if(strpos($date, '\s') === false ) {
			$str = explode(' ', $date);
			return $str[0];
		} else {
			return $date;
		}
	 
}

public function arrayMultisort() {

    $args = func_get_args();
    $data = array_shift($args);
	if(!is_array($data)) return;  
	
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row) {
				$tmp[$key] = $row[$field];
			}
            $args[$n] = $tmp;
		}
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}

public function imgShowHelp($name, $header) {

	$img = $GLOBALS['sst']['icon']['help'];
	$html = '<img class="d_help"  width="18" height="18" border="0" align="absmiddle" 
						onclick="return getHelp(this.name, event, \''.$header.'\');"
						name="'.$name.'"
						style="cursor:pointer;"
						src="'.$img.'"/>';
	return $html;
	
}

public function inputTypeButton($id, $name, $value, $style=null, $onclick=null, $title=null, $link = '') {
 
	if( ( class_exists('SignatureLink') ) && is_object(SignatureLink::getSessionSignature()) && empty($link) ) {  
		return false; 
	}
	if(class_exists('SignatureLink') && (!is_object(SignatureLink::getSessionSignature())))  {
		if(!$this->wpIsAuthorizedPage($title)) { return ;}	
	}

	if( $style == null ) { 
		$style ='margin:5px; padding:5px;'; 
	}
	
	return (
			'<input type="button" 
					onclick="'.$onclick.'" 
					value="'.$value.'" 
					name="'.$name.'" 
					id="'.$id.'" 
					style="'.$style.'" 
					class="s_button"/>'
			);
			
}

public function specialAccounts($page=null, $str=null) {

	$admin = new AdminAuthority( ); 
	
	$auth = ( (AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) ? true : false);
	
	if (is_array( $wp = $admin->getDataAdminSimpleWP() ) && $auth ) {
	
		if( is_null($page) ) {
		
			return $wp;
			
		} else {
		
			if(isset($wp['wp_data']['mod'])) { 
			
				if($wp['wp_data']['mod'] == 2)  { 
				
					return  (is_null($str) ? null : 'AUTHORIZED')  ;
					
				} else if($wp['wp_data']['mod'] == -1)  {
				
					return (is_null($str) ? null : 'AUTHORIZED')  ;
					
				} else if($wp['wp_data']['mod'] == 1)  {
				
					if((is_object($wp['wp_data']['data'])) && (!empty($wp['wp_data']['data']))) { 
						
						$f = (bool) filter_var($wp['wp_data']['data']->{$page}, FILTER_VALIDATE_BOOLEAN);
						if( is_null($str) ) {
							return  ( ($f) ? null : false) ;  
							
						} else {

							return  ( ($f) ? 'AUTHORIZED' : 'NOT AUTHORIZED') ; 
							
						}	
						
					}
					
				}
				
			}
		}

	}	
	 
}


public function permission($num) {
	
	$admin = new AdminAuthority( ); 
	$act = false;
	
	if (is_array( $wp = $admin->getDataAdminSimpleWP() )) {
		
		if(isset($wp['wp_data']['mod'])) {
			if($wp['wp_data']['mod'] == 2)  {
				$act = 0;
			} else if($wp['wp_data']['mod'] == -1) { 
				$act = 0;
			} else if((is_object($wp['wp_data']['data'])) && (!empty($wp['wp_data']['data']))) {
				if(is_bool($wp['wp_data']['data']->{$num})) { 
					$act = 0;
				} else {
					$act = null;
				}
			}
		} 
	}
	return $act; 
}

public function wpIsAuthorizedPage($title_key=null) {
	if( class_exists('SignatureLink') ) {
		if(is_object(SignatureLink::getSessionSignature()) ) { return false; } 
	}
	
	$str = trim($title_key);
	if(isset($_GET['page'])) {
		if($_GET['page'] == 'my_phd') {
			if(isset($_GET[GET_LINK_IN_MY_PHD])) {
				$str = str_replace('_', ' ' , strtoupper ($_GET[GET_LINK_IN_MY_PHD]));
			}
		} else {
			if($_GET['page'] == 'get_upload' && $str == 'MY ACADEMIC CV') { 
				$str = 'MY ACADEMIC CV';
			} else {
				$str = str_replace('_', ' ' , strtoupper ($_GET['page']));
			}
		}
	}  
	 
	$admin = new AdminAuthority( );  
	
	$arrayobject = new ArrayObject($this->page->getDisplayButtonLeft());
	$iterator =  new RecursiveIteratorIterator(new RecursiveArrayIterator($this->page->getDisplayButtonLeft()));
	$i = 0;
	$wp_count = -1; 
	while( $iterator->valid() ) {
		 
		if($iterator->key() == $str) {
			$wp_count = $i; 
			break ;
		}
		$iterator->next();
		$i++;
	}
	
	if($wp_count >= 0 && ($admin->isSessionAdminSimple())  ) {
		$wp_data = $admin->getDataAdminSimpleWP();
		 
		if( $wp_data['wp_data']['mod'] !=  2) {
			if($wp_data['wp_data']['data']->{($wp_count == 0 ? 0 : $wp_count-1)} == 'false') {
				return false;
			} 
		}
	}
	return true;
}

public function inputTypeText($id, $value=null, $style='width:150px;', 
								$onkeyup=null, $test=null, $js_param=null, 
								$class=null, $activated=0, $disabled=null, 
								$title=null) {
								
	if( class_exists('SignatureLink') ) {
		if(is_object(SignatureLink::getSessionSignature() ) ) { 
			return '<span style="color:green;"><b>'.$value.'</b></span>'; 
		}
	}
	
	if(!$this->wpIsAuthorizedPage($title)) {
		return '<span style="color:green;"><b>'.$value.'</b></span>'; ;	
	}
	 
	if(((strpos($id, 'num_credits2') !== false)  || (strpos($id, 'credits2') !== false)) && !$this->authenticity()) {
		return '<input type="hidden" value="'.$value.'" id="'.$id.'" />'.
				'<span style="color:green;"><b>'.$value.'</b></span>'; 
	}
	
	$span = '';
	$js = null;
	if($onkeyup != null && $onkeyup != 'num') {
		$js = 'onkeyup ="getValueOfText(this.value, this.id);"';
		$span = '<span class="icon_field"  id="'.$id.'sp"> &nbsp; </span>';
	} 
	
	if($test != null) {
		$js = 'onkeyup ="getValue(event, this.value, this.id,\''.$js_param.'\');"';
		$span = '<span class="icon_field"  id="'.$id.'sp"> &nbsp; </span>';
	}
	
	if($onkeyup == 'num' ) { $span = '<span class="icon_field"  id="'.$id.'sp"> &nbsp; </span>'; }
	
	$html  = '<input id="'.$id.'" type="text" value="'.$value.'" style="'.$style.'" '.$js.' '.$class.' '.$disabled.' /> ';
	
	if( $activated == 1) { 

		return '<span style="color:green;"><b>'.  $this->pregMatchDate($value, null).'</b></span>'; 
	}	
	
	return $html .= $span; 
}

public function pregMatchDate($str, $test=null) {
	if(preg_match("/^[0-9]{2}(\-)[0-9]{2}(\-)[0-9]{4}+$/", trim($str))) {
		return $this->settingDate($str);
	} else {
		return $str;
	}
}

public function inputTypeTextArea($id=null, $name=null, $value=null, 
								$style='border: 1px solid #4e9760; margin: 0 0 10px;', 
								$rows='7', $cols='45', $js=null, 
								$activated=0, $title=null ) {
								
	if( class_exists('SignatureLink') ) {							
		if(is_object(SignatureLink::getSessionSignature() ) ) { 
			return '<span style="color:green;"><b>'.$value.'</b></span>';
		}
	}
	if(!$this->wpIsAuthorizedPage($title)) {
		return '<span style="color:green;"><b>'.$value.'</b></span>'; 	
	}
	if( $activated == 1)  
		return '<span style="color:green;"><b>'.$value.'</b></span>'; 
	 else 
		return '<textarea id="'.$id.'" '.$js.' rows="'.$rows.'" cols="'.$cols.'" style="'.$style.'">'.$value.'</textarea>';
}

public function forbidElement() {
	return true;
}

public function inputTypeCheckbox($id, $check=null, $name=null, $value=null, $style=null, $class=null, $opt=null, $js=null, $activated=0) {
	if( class_exists('SignatureLink') ) {
		if(is_object(SignatureLink::getSessionSignature() ) ) { return false; }
	}
	 
	if($activated == 1 && !$this->authenticity()) { 
		return ($check == 'checked' ? '<img src="'. $GLOBALS['sst']['icon']['ok'].'"/>' : '' ); 
	}
	$admin = new AdminAuthority( ); 
	return ('<input type="checkbox" id="'.$id.'" value="'.$value.'" name="'.$name.'" style="'.$style.'" class="'.$class.'" '.$opt.'  '.$check. ' '.$js.' />');
}

public function getMenuHorizontal($menu, $define_link, $pos, $name_ref=null, $title=null) {
	 
	$visited = new Visited($this->dbh, $this); 
	print('<div id="cssmenu"><ul id="adm_menu">');
	for($i = 0; $i < count($menu); $i++) {
		$id = $this->page->getKeysInArray($menu, $i);  
		$adm = '&'.$define_link.'='.$id;
			print(' <li style="display:inline;"> ');
			
			if($title != null) {
			
				$vis = $visited->getInfoVisitedLeftMenu($title, $this->page->getKeysInArray($menu, $i));  
				print( (isset($vis['img']) ? 
							$this->getSrcImg(
								$vis['img'],
								'width=22',
								null,
								$vis['onclick'],
								'vertical-align: middle;margin-right:0px; margin-left:1px;margin-top:4px; float: inline-start;'
							) : '' 
						)
				);
				print( isset($vis['html']) ? $vis['html'] : '' ); 
			}
			
			
			$ref = ($name_ref == null ? $this->page->getValuesInArray($this->page->getArrayIndexInMyPHD(), $pos) : '?page='.$name_ref);
			print('<a href="'.$ref.$adm.'" id="m_'.$id.'" style="color: #000;">'.$this->page->getValuesInArray($menu, $i));
			 
			print('</a></li>');
	}
	print('</div></ul>');
}

public function createLinkSupervisor($page=null) {
	return  $page.'&slink='.$this->encryptStr($this->dbh->guid()).'&sid='.$this->encryptStr($this->dbh->guid());
}

public static function currentPageURL() {
	$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
	$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
	$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
	$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
	return $url;
}

public function styleColor($status=1, $count=0) {
	$style = ' background:';
	switch($status) {
		case 1:
			$style .= (($count % 2 == 0) ? '#E2E2E2;' : '#DBD9D9;');
		break;
		case 2:
			$style .= $GLOBALS['sst']['status_color']['request'].';';
		break;
		case 3:
			$style .= $GLOBALS['sst']['status_color']['accept'].';';
		break;
		case 4:
			$style .= $GLOBALS['sst']['status_color']['refuse'].';';
		break;
		case 5:
			$style .= $GLOBALS['sst']['status_color']['final'].';';
		break;
		case 6:
			$style .= $GLOBALS['sst']['status_color']['supervisor'].';'; 
		break;
	} 
	return $style;
}

public function getBooleanElements($status=1) {
	$admin = new AdminAuthority( ); 
	$bool = false;
	switch($status) {
		case 1: $bool = true;  break;
		case 2: $bool = false; break;
		case 3: $bool = false; break;
		case 4: $bool = true;  break;
		case 5: $bool = false; break;
		case 6: $bool = false; break;
	} 
	return ($this->authenticity() ? true : $bool)  ;
}

public function showStatusDocTraining($status=1, $test=null) {
	$result = '';
	 
	switch($status) {
		case 1: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'DEFAULT\', event, \'DIALOG\');" />';  
		break;
		case 2: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'REQUEST\', event, \'DIALOG\');"/>'; 
		break;
		case 3: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'ACCEPT\', event, \'DIALOG\');" />';   
		break;
		case 4: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'REFUSE\', event, \'DIALOG\');" />';  
		break;
		case 5: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'FINAL\', event, \'DIALOG\');"/>';  
		break;
		case 6: $result = '<img src="'.$GLOBALS['sst']['status_icon'][$status].'" 
									align="absmiddle" style="cursor: pointer;" 
									onclick="return getHelp(\'SUPERVISOR\', event, \'DIALOG\');"/>';
		break;
	} 
	return $result  ;
}

public function jsonValidate($string) {

    $result = json_decode($string);
	return $result;
    switch (json_last_error()) {
        case JSON_ERROR_NONE:
            $error = ''; // JSON is valid // No error has occurred
            break;
        case JSON_ERROR_DEPTH:
            $error = 'The maximum stack depth has been exceeded.';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Invalid or malformed JSON.';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Control character error, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON.';
            break;
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
            break;
        case JSON_ERROR_RECURSION:
            $error = 'One or more recursive references in the value to be encoded.';
            break;
        case JSON_ERROR_INF_OR_NAN:
            $error = 'One or more NAN or INF values in the value to be encoded.';
            break;
        case JSON_ERROR_UNSUPPORTED_TYPE:
            $error = 'A value of a type that cannot be encoded was given.';
            break;
        default:
            $error = 'Unknown JSON error occured.';
            break;
    }
    if ($error !== '') { exit($error);}
    return $result;
}

public function getSrcImg($src, $w=null, $h=null, $js=null, $style=null, $id=null, $name=null) {
	 
	return '  <img border="0" 
				align="absmiddle"
				class="animsition"
				id="'.$id.'"
				src="'.$src.'" '.$w.' '.$h.' '.$js.' 
				name="'.$name.'"
				style="'.$style.'" '.$GLOBALS['animation'][rand(1,10)].'/> '; // 8
				
}						

public function createArray($index, $array=null, $count=0) {

	if(is_array($array)) {
		if(sizeof($array) > 1) {	 
			$this->array_f[$index][$count] = $this->page->getValuesInArray($array, 0);
			array_shift($array);
			$this->createArray($index, $array, ++$count);
		} else {
			$this->array_f[$index][] = $this->page->getValuesInArray($array, 0);
		}
		 $this->setCreateArray($this->array_f);
	}
}

function requestMethod($method = 'post') {
	if($method == 'post') {
		if (empty($_POST)) { return false ; }
	} else {
		if (empty($_GET)) { return false ; }
	}
	return true;
}

public static function objArraySearch($array, $index, $value) {
	$item = null;
	foreach($array as $arrayInf) {
		if($arrayInf->{$index}==$value){
			return $arrayInf;
		}
	}
	return $item;
}

public function getIP() {
	if ( function_exists( 'apache_request_headers' ) ) {
		$headers = apache_request_headers();
	} else {
		$headers = $_SERVER;
	}
	if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
			$the_ip = $headers['X-Forwarded-For'];
	} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )) {
		$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
	} else {
		$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
	}
		return $the_ip;
 }
 
 // dont't touch
public function isUploadforbidden($menu=null) { }
 
public function timeElapsed($secs){
	$nowtime = time();
	$secs = ($nowtime - $secs);
    $bit = array(
        ' year'      => $secs / 31556926 % 12,
        ' week'      => $secs / 604800 % 52,
        ' day'       => $secs / 86400 % 7,
        ' hour'      => $secs / 3600 % 24,
        ' minute'    => $secs / 60 % 60,
        ' second'    => $secs % 60
        );  
    foreach($bit as $k => $v){
        if($v > 1)$ret[] = $v . $k . 's';
        if($v == 1)$ret[] = $v . $k;
        }
    array_splice($ret, count($ret)-1, 0, 'and');
    $ret[] = 'ago.';
    return join(' ', $ret);
 }
 
 public function month($index, $str=null) {
	$index = (int)$index;
	if(!is_numeric($index)) {	
		return '00'; 
	}
		
	$month = array();
	$month[1]='January';
	$month[2]='February';
	$month[3]='March';
	$month[4]='April';
	$month[5]='May';
	$month[6]='June';
	$month[7]='July';
	$month[8]='August';
	$month[9]='September';
	$month[10]='October';
	$month[11]='November';
	$month[12]='December';
	if($str != null) {
		if(in_array($str, $month)) {
			$key = array_search($str, $month);
			if($key <= 9) {
				return '0'.$key;
			} else {
				return $key;
			}
		}
	}
	return (isset($month[$index]) ? $month[$index] : '') ;
}

public function getDateDigital($date) {
	preg_match('/[a-zA-Z]+/u', $date, $matches_month );
	preg_match_all('/[0-9\s]+/u', $date, $matches_date );
	if(isset($matches_date[0][0]) && (isset($matches_month[0]) ) ) {
		return trim($matches_date[0][0]).'-'.$this->month(0, $matches_month[0]).'-'.trim($matches_date[0][1]) ;
	} else {
		return $date;
	}
}

public function checkDate($date) {
	
	$date = trim($date);
 	$d = explode('-', $date);
	if( preg_match('/\s/',$date) ) {
		$d = substr($date, 0, strrpos($date, ' '));
	}
	 
	if(preg_match('/[a-z]/',$date) ) {
		$date = $this->getDateDigital($date) ;
		$d = explode('-', $date);
	}
		 
	if (checkdate($d[1], $d[0], $d[2])) {//checkdate(month, day, year)
		return true;
	} else {
		return false;
	}
}

public function settingDate($date_fix) {
	 
	if( empty($date_fix) ) return null; 
	if( strpos($date_fix, ' ' ) && strpos($date_fix, '-')) {
		$prefix = explode(' ', $date_fix);
		$date = explode('-', $prefix[0]);
		$d = $date[0];
		$m = $date[1];
		$y = $date[2]; 
		 
		return $d . ' ' . $this->month($m) . ', '.$y;  
	} else {
		if( strpos($date_fix, '-') ) {
			$date = explode('-', $date_fix);
			$d = $date[0];
			$m = $date[1];
			$y = $date[2];   
			return $d . ' ' . $this->month($m) . ', '.$y;
		}			
	}
	 
	return $date_fix;
}

public function searchKey($array, $key, $value) {
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, $this->searchKey($subarray, $key, $value));
        }
    }

    return $results;
}

function infoSupervisorHTML($page, $obj_supervisor) {
	if(is_object($obj_supervisor)) {
		$html = '<div style="float:left; ">';
			$html .= '<div><b> Training request sent to supervisor. :</b></div>';
			/*
			$html .= '<div><b>'.$page->showText(16, 'all').' </b> '.$obj_supervisor->firstname[0].'</div>';
			$html .= '<div><b>'.$page->showText(15, 'all').' </b> '.$obj_supervisor->lastname[0].'</div>';
			$html .= '<div><b>'.$page->showText(0,  'all').' </b> '.$obj_supervisor->email[0].'</div>';
			*/
			$html .= '<div><b>Date:</b> '.$obj_supervisor->date[0].'</div>';
		$html .= '</div>';
		return $html;
	}
}

function infoLastModificationHTML($visited, $id_user, $page=null) {

	$row = $visited->visitedSelect($id_user);
	if($visited->isValueExists($id_user)) {    
		$html = '<div style="float:left; background:#93D9F2; padding:1px;">';
			$html .= '<div>
						<b>'.
							(is_object($this->page) ? $this->page->showText('admin_search_last_modification_by_user') : '' ).
						'</b>
					</div>';  
			$html .= '<div><b>Date: </b> '.$this->settingDate($row['val']).'</div>';
			$html .= '<div>'.$this->timeElapsed($row['last_visited']).'</div>';
		$html .= '</div>';
		return $html;
	}	
}	

public function cotutelleInfo($id_user, $test=null) { 
	$fold  = $this->dbh->checkFolderInBD($id_user);		 
	$directory = $this->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE.$fold['dir']);
	
	preg_match_all('!\d+!', $this->blockImgUploadSimple($directory), $matches);
	if(is_array( $matches )) {
		if($matches[0][0] == 0 ) {
			return (is_null($test) ? 
					'<span style="color:red;"> '.$this->page->showText('admin_search_no') .' </span>' :
					$this->page->showText('admin_search_no') ); 
			} else {
			return (is_null($test) ? 
					'<span style="color:red;">'.$this->page->showText('admin_search_yes') .'</span>' : 
					$this->page->showText('admin_search_yes') ); 
		}
	}
					
}

public function stateSignatures($state, $cal) {
	if($state == 0) {
		return false;
	} else if($state == 2) {
		return true;
	} else if($state == 3) {
		return (($cal <= 0) ? false : true);
	} else if($state == 4) {
		return false;
	} else if($state == 5) {
		return true;
	} else if($state == 1) {
		return false;
	} else {
		return false;
	} 
}

public function addmissionSignatures($page, $state, $cal) {

	$gen = $this->dbh->idGenerator(); 
	switch($state) {
		case 0:
			return  '<td style="color:red;" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all'): ' ').$page->showText(21, 'all').
					'</td>';
		case 1: // Sent
			return '<td style="color:'.(($cal == 0) ? 'red;': 'green;').'" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all') :' ').$page->showText(22, 'all').
					'</td>';
		case 2: // Accepted by admin
			return  '<td style="color:'.(($cal == 0) ? 'red;': 'green;').'" id="'.$gen.'">'.
						$page->showText(23, 'all'). 
					'</td>';
		case 3: // File uploaded 
			return  '<td style="color:'.(($cal == 0) ? 'red;': 'green;').'" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all') : $page->showText(26, 'all')).
					'</td>';
		case 4: // Invitation refused 
			return  '<td style="color:'.(($cal == 0) ? 'red;': 'green;').'" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all') : $page->showText(33, 'all')).
					'</td>';			
		case 5: // Accepted by supervisor
			return  '<td style="color:'.(($cal == 0) ? 'red;': 'green;').' background:yellow;" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all'): ' ').$page->showText(30, 'all'). 
					'</td>';
		default:
			return '<td style="color:'.(($cal == 0) ? 'red;': 'green;').'" id="'.$gen.'">'.
						(($cal == 0) ? $page->showText(32, 'all') : $page->showText(22, 'all')).
					'</td>';
	}
}

public function getNameJury($key) {
	if(is_array($key)) {
		if( $key['members'] == 1 && $key['employment'] == 'Preadmission' ) {			 
			return $GLOBALS['sst']['select_jury_members'][4];
		} else if( $key['members'] == 1 && $key['employment'] == 'Admission' ) {
			return $GLOBALS['sst']['select_jury_members'][1];
		} else {
			if( $key['members'] == 2 ) {
				return $GLOBALS['sst']['select_jury_members'][2];
			} else if( $key['members'] == 3 ) {	
				return $GLOBALS['sst']['select_jury_members'][3];
			}
		}
	}	
 }		
 
public function joinDiplomaAndAcademic() {
 
	$all_diploma = $this->dbh->showDiploma();

	$merger_pdf = array(); 
	for($i = 0; $i < sizeof($all_diploma); $i++) {
 	 
		$dir = $this->dbh->checkFolderInBD(); 
	
		$direction = DIR_FOLDER_DIPLOMA_SIMPLE.$dir['dir'].'/'.$all_diploma[$i]['dir'];
		$open = $this->isDirectoryExists($direction); 

		$f = $this->showAllFiles($open);

		for($j = 0; $j < sizeof($f); $j++) {
		
			if(is_dir($f[$j]) ) 
				$merger_pdf[$i]['academic'] =  $this->showAllFiles($f[$j]); 	  
			
			if(is_file($f[$j]))
				$merger_pdf[$i]['diploma'][$j] = $f[$j];	
		}			 
	}
	
	return ((sizeof($merger_pdf) < 0 ) ? false : $merger_pdf );
	 
}

public function getRebuiltMergerDiploma() {
	$merger_pdf = $this->joinDiplomaAndAcademic();
	
	 
	$r = array();
	if((is_array($merger_pdf)) && (sizeof($merger_pdf) > 0)) {

		foreach($merger_pdf as $k => $v ) {
			$count = 0;
			foreach($merger_pdf[$k]['diploma'] as $dip) { 
				if(is_file($dip)) { $r[] = array(0 => $dip, 1 => 'all');}	 
				$count++;
			}
			foreach($merger_pdf[$k]['academic'] as $aca) { 
				if(is_file($aca)) {  $r[] = array(0 => $aca , 1 => 'all'); }
				$count++;
			}
		}
		
		return $r;
	}
	return false;
}

public function getAllMyAcademicCV($test=null) {
	$count = 0; 
	$dir = $this->dbh->checkFolderInBD(); 
	if(is_array($n = $this->dbh->showDiploma())) {
		if( sizeof($n) > 0) {
			$d = array();
			foreach ($n as $k => $array)  {
				$m = 0;
				foreach($array as $value) {
					$d[$count][$m] = $value;
					$m++;
				}
				 
				$all_diploma = $this->dbh->showUploadedDiploma($d[$count][14]);
				if(is_array($all_diploma) && sizeof($all_diploma) > 0 ) { 
					for($i = 0; $i < sizeof($all_diploma); $i++) { 
						$d[$count]['dir_diploma'][$i] = DIR_FOLDER_DIPLOMA_SIMPLE.$dir['dir'].'/'.$d[$count][14].'/'.$all_diploma[$i]['title'];	
					}
				}
				
				if($all_year = $this->dbh->showYearAcademic($d[$count][0])) {
					$y = array();
					$j = 0;
					foreach ($all_year as $myck => $array)  {
						$m = 0;
						foreach($array as $value) {
							$y[$j][$m] = $value;
							$m++;
						}
						$j++;
					}	
				}
				$d[$count]['year'] = $y;
				$count++;
			}

			if((isset($d[0]['year'])) && sizeof($d[0]['year']) > 0 ) {
				foreach($d as $y_k => $y_v) {
					foreach($d[$y_k]['year'] as $year_key => $year_value) {
					
						$all_year = $this->dbh->showUploadedYear($d[$y_k]['year'][$year_key][0]); 
						if(is_array($all_year) && sizeof($all_year) > 0 ) { 
							for($f = 0; $f < sizeof($all_year); $f++) { 
								$data = $this->dbh->getDataDiploma($all_year[$f]['id_diploma']);
								$d[$y_k]['year'][$year_key]['dir_year'][] = DIR_FOLDER_DIPLOMA_SIMPLE.$dir['dir'].'/'.$data['dir'].'/'.$data['dir_year_academic'].'/'. $all_year[$f]['title'];
							}
						}	
					}	
				}
			}	
			return $d;
		}
	}
	return false;
}

public function isPassed() {
	 
	 
	if($this->dbh->getEachStatus(ConnectDB::isSession(), 'ADMISSION', 'NUM') >= 2 ) {
		return true;
	}  
	
	$this->dbh->updateStatus($this->dbh->status_default_value);
	
	return ((AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) ? true : false) ;
		
}

// You can make it unique for any field like id_user, name or num
public function uniqueSpreadArray($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}





}
?>