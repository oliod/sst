<?php

class ExtractResult  {

 private $dbh = null;
 private $main = null;
 private $admin = null;
 
 private $registration      = array();
 private $address_residence = array();
 private $contact_address   = array();
 private $institution = array();
 
 private $diploma           = array();
 private $admission         = array();
 private $admission_research_project    = array();
 private $admission_additional_programme = array();
 private $admission_doctoral_training   = array();
 private $admission_ucl                 = array();
 private $admission_supervisory_panel   = array();

 private $confirmation_submit   = array();
 private $confirmation_planning = array();
 
 private $private_defence_home   = array();
 private $private_defence_jury   = array();
 private $private_defence_status = array();
 
 private $public_defence_home    = array();  
 
 private $my_supervosory_panel = array();
 private $my_doctoral_training = array();
 private $my_additional_programme = array();
 private $my_cotutelle = array(); 
 
 private $all_records = array();
 private $total = array();
 private $memory = null;
 
 private $arr_sup = array();
 private $args = null;
 private $pdo = null;
 
 private $dpl_more = null;
 
 public function __construct() {
	
	if (class_exists('ConnectDB') && class_exists('Main') && class_exists('AdminAuthority')) {
		$this->dbh   = new ConnectDB();
		$this->main  = new Main();
		$this->admin = new AdminAuthority();	
		$this->pdo = ConnectDB::DB();
	} else {
		print(' >>> ERROR NOT CLASS EXISTS <<< ');
		return ;
	} 
 }
 
  public static function getNameTables() {
	return array(
				0 => 'extract_my_profile',  
				1 => 'extract_my_academic_cv',
				2 => 'extract_my_phd_admission',
				3 => 'extract_my_phd_admission_research_project',
				4 => 'extract_my_phd_admission_additional_programme',
				5 => 'extract_my_phd_admission_doctoral_training',
				6 => 'extract_my_phd_admission_supervisory_panel',
				7 => 'extract_my_phd_admission_ucl',
				8 => 'extract_my_phd_confirmation_submit',
				9 => 'extract_my_phd_confirmation_planning', 
				10 => 'extract_my_phd_private_defence_home',
				11 => 'extract_my_phd_private_defence_jury',
				12 => 'extract_my_phd_private_defence_status',
				13 => 'extract_my_phd_public_defence_home',
				14 => 'extract_my_supervisory_panel',
				15 => 'extract_my_doctoral_training',
				16 => 'extract_my_additional_programme',
				17 => 'extract_my_cotutelle',
				18 => 'extract',
			);
 }
 
 public function extractDelete($id, $row = 'id_user') {
	$name_table = ExtractResult::getNameTables();
	$r = array();
	
	if(!$this->dbh->isID($id)) { return false; }
	foreach($name_table as $k => $v) { 
		$r['table'] = $v;
		$r['col'] = $row;
		$r['del'] = $id;
		$this->dbh->deleteAllCol($r);
	}
 }

 public function setExtractResult($r, $arr_memory, $args=null ) {
 
	
	echo '<pre>';
		print_r($arr_memory);
	echo '</pre>';
	
	if(!is_null($this->dbh) ) {   
 
		if(((is_null($args)) ? (is_array($r) && is_array($arr_memory) && $this->deleteTableExtract()) : true )) {
			 
			$this->memory = $arr_memory;
			$this->args =  $args;
			foreach($r as $k => $v) {  
				if(isset($r[$k]['id_user']) && ($this->dbh->isID($r[$k]['id_user']) ) ) {
					$this->registration[]      = $this->dbh->checkRegistration($r[$k]['id_user']);
					$this->contact_address[]   = $this->dbh->showAddressContact($r[$k]['id_user']);
					$this->address_residence[] = $this->dbh->showAddressResidence($r[$k]['id_user']);
					
					$h = $this->dbh->instituteSelectSelected($r[$k]['id_user'], null );
					$name_inst = $this->dbh->instituteSelect($h['id_institute']); 
					
					$this->institution['id_user'][]   = $r[$k]['id_user'] ;
					$this->institution['inst_name'][] = (isset($name_inst['institute']) ? $name_inst['institute'] : '') ;
					$this->institution['inst_mail'][] = (isset($name_inst['mail']) ? $name_inst['mail'] : '') ;
					
					$this->diploma[]   = $this->dbh->showDiploma($r[$k]['id_user']); 
					$this->admission[] = $this->dbh->admissionHomeCheck($r[$k]['id_user']);
					
					$this->admission_research_project[]     = $this->dbh->admissionResearchProjectCheck($r[$k]['id_user']);
					$this->admission_additional_programme[] = $this->dbh->admissionAdditionalProgrammeSelect($r[$k]['id_user']);
					$this->admission_doctoral_training[]    = $this->dbh->admDocTrainingSelect($r[$k]['id_user']);
					$this->admission_supervisory_panel[]    = $this->dbh->admissionSupervisoryPanelSelectAll($r[$k]['id_user']); 
					
					$folder = $this->dbh->checkFolderInBD($r[$k]['id_user']);
					$directory = $this->main->isDirectoryExists(DIR_FOLDER_ADMISSION_UCL_REG_SIMPLE, $folder['dir']);
					$count = $this->main->countOpenDirectory($directory) ; 
					$this->admission_ucl['id_user'][] =  $r[$k]['id_user'];
					$this->admission_ucl['dir'][]     = $directory;
					$this->admission_ucl['content'][] = ($count > 0 ? 'YES' : 'NO'); 
					
					$this->confirmation_submit[] = $this->dbh->confResultSelect($r[$k]['id_user']);
					
					$this->confirmation_planning['deadline'][] = $this->dbh->confPlanningSelect($r[$k]['id_user']);
					$this->confirmation_planning['state'][]    = $this->dbh->confPlanningStatusSelect(null, $r[$k]['id_user']);	
				
					$this->private_defence_home[]   = $this->dbh->showPrivateHome($r[$k]['id_user']);
					$this->private_defence_jury[]   = $this->dbh->privateJuryMembersSelect(null, $r[$k]['id_user']);
					$this->private_defence_status[] = $this->dbh->privateDefenceStatusSelect($r[$k]['id_user']);
					
					$this->public_defence_home['public_practical'][] = $this->dbh->publicDefenceSelect($r[$k]['id_user']);
					$this->public_defence_home['public_details'][]   = $this->admin->publicDefenceAdminSelect($r[$k]['id_user']);
					$this->public_defence_home['public_state'][]     = $this->dbh->publicDefenceStatusSelect($r[$k]['id_user']);
					
					$this->my_supervosory_panel[] = $this->dbh->mySupervisoryPanelSelect(null , $r[$k]['id_user'], 'SIGNATURES');
					$this->my_doctoral_training[] = $r[$k]['id_user'];
					
					$this->my_additional_programme[] = $this->dbh->myAdditionalProgrammeSelect(null, $r[$k]['id_user']);
					
					$this->my_cotutelle['id_user'][] = $r[$k]['id_user']; 
					$this->my_cotutelle['file'][]    = $this->dbh->whatIsAvailableCotutelle($r[$k]['id_user']); //$this->main->cotutelleInfo($r[$k]['id_user'], 'STR');
				}
			}
		} 
	}
	
	if(is_array($this->registration) && is_array($this->memory)) {
		if(count($this->registration) > 0) {
		
			if(!is_null($this->args)) {
 
				return array('SHOW_LIST' => array(
											'registration'      => $this->registration, 
											'contact_address'   => $this->contact_address,
											'address_residence' => $this->address_residence,
											'institution'       => $this->institution,
											'diploma'           => $this->diploma,
											'admission'         => $this->admission,
											'admission_research_project'     => $this->admission_research_project,
											'admission_additional_programme' => $this->admission_additional_programme,
											'admission_doctoral_training'    => $this->admission_doctoral_training,
											'admission_supervisory_panel'    => $this->admission_supervisory_panel,
											'admission_ucl'           => $this->admission_ucl,
											'confirmation_submit'     => $this->confirmation_submit,
											'confirmation_planning'   => $this->confirmation_planning,
											'private_defence_home'    => $this->private_defence_home,
											'private_defence_jury'    => $this->private_defence_jury,
											'private_defence_status'  => $this->private_defence_status,
											'public_defence_home'     => $this->public_defence_home,
											'my_supervosory_panel'    => $this->my_supervosory_panel,
											'my_doctoral_training'    => $this->my_doctoral_training,
											'my_additional_programme' => $this->my_additional_programme,
											'my_cotutelle'            => $this->my_cotutelle,
											) 	  
							) ;
 
			}

			$this->insertData('my_profile');
			
			if(count($this->diploma) > 0 ) { $this->insertData('my_academic_cv'); }
			if(count($this->admission) > 0 ) { $this->insertData('my_phd_admission'); }
			if(count($this->admission_research_project) > 0 ) { $this->insertData('my_phd_admission_research_project'); }
			if(count($this->admission_additional_programme) > 0 ) { $this->insertData('my_phd_admission_additional_programme'); }
			if(count($this->admission_doctoral_training) > 0 ) { $this->insertData('my_phd_admission_doctoral_training'); }
			if(count($this->admission_supervisory_panel) > 0 ) { $this->insertData('my_phd_admission_supervisory_panel'); }
			if(count($this->admission_ucl) > 0 ) { $this->insertData('my_phd_admission_ucl'); }
			
			if(count($this->confirmation_submit) > 0 ) { $this->insertData('my_phd_confirmation_submit'); }  
			if(count($this->confirmation_planning) > 0 ) { $this->insertData('my_phd_confirmation_planning'); } 
			
			if(count($this->private_defence_home) > 0 ) { $this->insertData('my_phd_private_defence_home'); }
			if(count($this->private_defence_jury) > 0 ) { $this->insertData('my_phd_private_defence_jury'); }
			if(count($this->private_defence_status) > 0 ) { $this->insertData('my_phd_private_defence_status'); }
			
			if(count($this->public_defence_home) > 0 ) { $this->insertData('my_phd_public_defence_home'); }
			
			if(count($this->my_supervosory_panel) > 0 ) { $this->insertData('my_supervosory_panel'); }  
			if(count($this->my_doctoral_training) > 0 ) { $this->insertData('my_doctoral_training'); }
			if(count($this->my_additional_programme) > 0 ) { $this->insertData('my_additional_programme'); }
			if(count($this->my_cotutelle) > 0 ) { $this->insertData('my_cotutelle'); }
			
			//print_r($this->getRecords());
			
			//print_r(self::getNameFieldsExtract());
			 $this->container(); // => table extract
		}  
	} 
 }
 
 private function setRecords($name, $r) {
	$this->all_records[$name][] = $r; 
 }
 
 public function getRecords() {
	return $this->all_records;
 }
 
 public function quoteIdent($str) {
	return trim($this->pdo->quote($str), "\'");
 }
 
 private function insertData($name) {
	switch($name) {
		case'my_profile':
			foreach($this->registration as $k => $v) {  
				if(is_numeric($this->registration[$k]['sciences']) ) {
					$sc = $GLOBALS['sst']['select_sciences'][$this->registration[$k]['sciences']];
				} else {
					$sc = ' ';
				}

				$sql = "INSERT INTO extract_my_profile() VALUES ('{$this->dbh->guid()}',  
												'".$this->memory['id_admin']."',
												'".$this->registration[$k]['id_user'] ."',
												'".$this->memory['id_name'] ."', 
												'".$this->quoteIdent ( $this->memory['val_field'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['title'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['last_name'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['first_name'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['birth_place'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['birth_date'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['mobile'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['phd'] )."', 
												'".$this->quoteIdent ( $sc )."', 
												'".$this->quoteIdent ( $this->registration[$k]['institution'] )."',  
												'".$this->quoteIdent ( $this->registration[$k]['thesis'] )."',
												'".$this->quoteIdent ( $this->registration[$k]['e-mail'] )."', 
												'".$this->quoteIdent ( $this->institution['inst_name'][$k] )."',
												'".$this->quoteIdent ( $this->institution['inst_mail'][$k] )."',
												'".$this->quoteIdent ( $this->address_residence[$k]['street'] )."',  
												'".$this->quoteIdent ( $this->address_residence[$k]['box_num'] )."',
												'".$this->quoteIdent ( $this->address_residence[$k]['postal_code'] )."',
												'".$this->quoteIdent ( $this->address_residence[$k]['city'] )."',
												'".$this->quoteIdent ( $this->address_residence[$k]['country'] )."',
												'".$this->quoteIdent ( $this->address_residence[$k]['tel'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['univ'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['street'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['box_num'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['postal_code'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['city'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['country'] )."',
												'".$this->quoteIdent ( $this->contact_address[$k]['tel'] )."', 
												'".date(DATETIME)."');";
				$this->requestSQL($sql,' >>>>> ERROR EXTRACT 568578 <<<<< '); 
				
				
				$r = array(); 
				array_push($r, $this->registration[$k]);
				array_push($r, $this->address_residence[$k]); 
				array_push($r, $this->contact_address[$k]);
				 
				
				$this->setRecords('extract_my_profile', $r);				
			}
		break;
		case'my_academic_cv':
			
			foreach($this->diploma as $k => $v) {
					if(is_array($v)) {  
						foreach($v as $j) {
							if(empty($j['id_user'])) continue; 
							$sql = 	"INSERT INTO extract_my_academic_cv() VALUES ('{$this->dbh->guid()}', 
											'".$this->memory['id_admin']."',
											'".$j['id_user']."',
											'".$this->memory['id_name']."', 
											'".$this->quoteIdent ( $this->memory['val_field'])."',
											'".$j['id_diploma']."',
											'".$GLOBALS['sst']['select_diploma'][$j['level_diploma']]."',
											'".$this->quoteIdent( $j['official_title_diploma'])."',
											'".$this->quoteIdent( $j['institution'])."',
											'".$this->quoteIdent( $j['country'])."',
											'".$this->quoteIdent( $j['awarding_date'])."',
											'".$this->quoteIdent( $j['diploma_date'])."', 
											'".$this->quoteIdent( $j['obtained_diploma'])."', 
											'".$this->quoteIdent( $j['credits1'])."',
											'".$this->quoteIdent( $j['credits2'])."',
											'".$this->quoteIdent( $j['credits3'])."',
											'".$this->quoteIdent( $j['dir'])."',
											'".$j['dir_year_academic']."');";
							$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 47657 <<<<< '); 						
						}
						$this->setRecords('extract_my_academic_cv', $this->diploma[$k]);
					}
				}
		break;
		case'my_phd_admission':
			 
			foreach($this->admission as $k => $v) { //  
				$diploma_selected = 0;
				$id_diploma = NULL;
			
				 
				if(empty($this->admission[$k]['id_user']))  continue; 
					if(is_array($this->diploma) && (sizeof($this->diploma) > 0) ) {
						foreach($this->diploma as $d_k => $d_v ) {
							if(is_array($this->diploma[$d_k]))  {
								foreach( $this->diploma[$d_k] as $d_value) {
									if(isset($d_value['id_user'])) {
										if($d_value['diploma_selected'] == 1 && $d_value['id_user'] == $this->admission[$k]['id_user']) {
											$diploma_selected = $d_value['diploma_selected'];
											$id_diploma = $d_value['id_diploma'];
											break;
										}
									}
								}
							} else { continue; }	
						}
					} 
				
				if(is_array($arr_diploma = $this->dbh->showDiploma($this->admission[$k]['id_user']))) {
					foreach($arr_diploma as $key => $val) {
						if($arr_diploma[$key]['id_diploma'] == $id_diploma) {
							$name_diploma    = $arr_diploma[$key]['official_title_diploma'];
							$inst_diploma    = $arr_diploma[$key]['institution'];
							$issued_diploma  = $arr_diploma[$key]['diploma_date'];
							$awarded_diploma = $arr_diploma[$key]['awarding_date'];
							break;
						}
					}	
				}

				$type = ( ($this->admission[$k]['employment'] == 'Admission') ? 'ADMISSION' : 'PRE-ADMISSION' );
				$status = $this->dbh->getEachStatus($this->admission[$k]['id_user'], $type, 'STR');
				
				$this->admission[$k]['date_admission'] = (($this->admission[$k]['state'] == 4) ? $this->admission[$k]['date'] : NULL);  
				
				if($this->admission[$k]['date'] != 0 ) {
					$this->admission[$k]['date_admission'] = $this->admission[$k]['date']; 
				}

				$sql = "INSERT INTO extract_my_phd_admission() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->admission[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->admission[$k]['employment']."',
								'".$this->quoteIdent( $this->admission[$k]['text'])."',
								'".$status."', 
								'".$this->main->settingDate($this->admission[$k]['date_preadmission'])."', 
								'".$this->main->settingDate($this->admission[$k]['date_admission'])."',
								'".$id_diploma."',
								'".$diploma_selected."',
								'".(isset($name_diploma)    ? $this->quoteIdent($name_diploma)    : NULL )."',
								'".(isset($inst_diploma)    ? $this->quoteIdent($inst_diploma)    : NULL )."',
								'".(isset($issued_diploma)  ? $this->quoteIdent($issued_diploma)  : NULL )."',
								'".(isset($awarded_diploma) ? $this->quoteIdent($awarded_diploma) : NULL )."',
								'".$this->main->settingDate($this->admission[$k]['date'])."');";
				$this->requestSQL($sql, ' >>>>>  ERROR EXTRACT 654644678 <<<<< '); 
				
				$this->admission[$k]['name_diploma']    =  (isset($name_diploma)    ? $name_diploma    : NULL );
				$this->admission[$k]['inst_diploma']    =  (isset($inst_diploma)    ? $inst_diploma    : NULL );
				$this->admission[$k]['issued_diploma']  =  (isset($issued_diploma)  ? $issued_diploma  : NULL );
				$this->admission[$k]['awarded_diploma'] =  (isset($awarded_diploma) ? $awarded_diploma : NULL );
				
				$this->setRecords('extract_my_phd_admission', $this->admission[$k]);
			}
		break;
		
		 
		case'my_phd_admission_research_project': // dir
			foreach($this->admission_research_project as $k => $v) {
				if(empty($this->admission_research_project[$k]['id_user']))  continue; 
				$sql = "INSERT INTO extract_my_phd_admission_research_project() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->admission_research_project[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->admission_research_project[$k]['folder']."',
								'".addslashes(trim($this->dbh->encodeToUtf8($this->dbh->filter($this->admission_research_project[$k]['text']))))."');";
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 65465465 <<<<< '); 
				$this->setRecords('extract_my_phd_admission_research_project', $this->admission_research_project[$k]);
			}
		break;  
		case'my_phd_admission_additional_programme':
			foreach($this->admission_additional_programme as $k => $v) {
				if(is_array($v)) {  
					$num = null;
					$id_user = null;
					$r = array();
					foreach($v as $j) {
						if(empty($j['id_user'])) continue; 
							$num += (is_numeric($j['ects']) ? ($j['ects']) : 0);
							$id_user = $j['id_user'];
							$r['name_course'][] = $j['name_course'];  
					}
					if(!is_null($num) && !is_null($id_user)) {
						$sql = "INSERT INTO extract_my_phd_admission_additional_programme() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$j['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$num."');";
						$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 75686 <<<<< '); 
						$r['total'][] = $num;
						$r['id_user'][] = $id_user;
						$this->setRecords('extract_my_phd_admission_additional_programme', $r);
					}
				}
			}	
					
		break;
		case'my_phd_admission_doctoral_training';
 
			 foreach($this->admission_doctoral_training as $k => $v) {
			 	if(empty($v) ) continue;
 	 	 
				$activities = $this->getActivities($v);
				$total = $activities['total'];
				unset($activities['total']);
				foreach($activities as $act) {   
					$sql = "INSERT INTO extract_my_phd_admission_doctoral_training() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$act['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_admission_doctoral_training_act'][$act['activities']]['name'] ."',
								'".$act['ects']."',
								'".$total."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 78686 <<<<< '); 
				} 
			 }
		break;
		case'my_phd_admission_supervisory_panel':
				$new = array();
				$index = 0; 
				foreach($this->admission_supervisory_panel as $k => $v) {
					$i_pre = 0; $i_adm = 0;  
					if(empty($v) ) { continue; }
					foreach($v as $key) {
						if($key['employment'] == 'Admission') { 
							if(++$i_adm >= 6 ) continue;  
						} else if($key['employment'] == 'Preadmission') { 
							if(++$i_pre >= 4 ) continue;   
						} 
							
						$new[$index]['type'] = $key['employment'];
						$new[$index]['id_user'] = $key['id_user'];
						$new[$index]['title']   = $key['titel'];
						$new[$index]['l_name']  = $key['lastname']; 
						$new[$index]['f_name']  = $key['firstname']; 
						$new[$index]['institution'] = $key['institution']; 
						$new[$index]['email']       = $key['email']; 
						$new[$index]['state']       = $key['state']; 
						$new[$index]['dir']         = $key['dir'];  
						$index++; 
						if($i_adm  >= 5 && $i_pre >= 3) break;  
					} 
				}
				
				if(sizeof($new) > 0 ) {
					foreach($new as $k => $v) {
					$sql = "INSERT INTO extract_my_phd_admission_supervisory_panel() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$new[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_person'][$new[$k]['title']]."',
								'".$new[$k]['type']."',
								'".$this->quoteIdent( $new[$k]['l_name'])."',
								'".$this->quoteIdent( $new[$k]['f_name'])."',
								'".$this->quoteIdent($new[$k]['institution'])."',
								'".$this->quoteIdent($new[$k]['email'])."',
								'".$new[$k]['state']."',
								'".$new[$k]['dir']."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 475767896 <<<<< '); 
					$this->setRecords('extract_my_phd_admission_supervisory_panel', $new[$k]);
					}
				}
		break;
		case'my_phd_admission_ucl':
			for($i = 0; $i < count($this->admission_ucl['id_user']); $i++) {
				if(empty($this->admission_ucl['id_user'][$i]) ) continue; 
				$sql = "INSERT INTO extract_my_phd_admission_ucl() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->admission_ucl['id_user'][$i]."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->admission_ucl['content'][$i]."',
								'".$this->admission_ucl['dir'][$i]."');";
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 47557 <<<<< '); 
			}	 
		break;	
		case'my_phd_confirmation_submit':
			foreach($this->confirmation_submit as $k => $v) { //  
				if(empty($v) ) continue; 
				$sql = "INSERT INTO extract_my_phd_confirmation_submit() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->confirmation_submit[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_confirm_state'][$this->confirmation_submit[$k]['select_confirm_state']]."',
								'".$this->main->settingDate($this->confirmation_submit[$k]['date_of_confirm'])."');";
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 77876785 <<<<< '); 
				$this->setRecords('extract_my_phd_confirmation_submit', $this->confirmation_submit[$k]);
			 
			} 
		break;  
		case'my_phd_confirmation_planning':
			 
			for($i = 0; $i < count($this->confirmation_planning['deadline']); $i++) {
				if(empty($this->confirmation_planning['deadline'][$i])) continue; 
				if($this->confirmation_planning['deadline'][$i]['id_user'] == $this->confirmation_planning['state'][$i]['id_user'] ) {
					$sql = "INSERT INTO extract_my_phd_confirmation_planning() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->confirmation_planning['deadline'][$i]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->confirmation_planning['state'][$i]['status']."',
								'".$this->main->settingDate($this->confirmation_planning['deadline'][$i]['deadline'])."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 868686 <<<<< '); 
					$this->setRecords('extract_my_phd_confirmation_planning', $this->confirmation_planning);
				}
			}
		break; //  
		case'my_phd_private_defence_home':
			foreach($this->private_defence_home as $k => $v) {
				if( empty($v) ) { continue; }
				$sql = "INSERT INTO extract_my_phd_private_defence_home() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->private_defence_home[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->quoteIdent( $this->private_defence_home[$k]['thesis1'])."',
								'".$this->quoteIdent( $this->private_defence_home[$k]['thesis2'])."',
								'".$this->main->settingDate($this->private_defence_home[$k]['date'])."');";
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 47575785 <<<<< '); 
				$this->setRecords('extract_my_phd_private_defence_home', $this->private_defence_home[$k]);
			}
		break;
		case'my_phd_private_defence_jury':
			$new = array();
				$index = 0; 
				foreach($this->private_defence_jury as $k => $v) {
					$i_president = 0; $i_secretary = 0; $i_member = 0; $i_supervisor = 0; 
					if( empty($v) ) { continue; }
					foreach($v as $key) {
						if($key['employment'] == 'Admission' || $key['employment'] == 'Preadmission') {

							if( $key['members'] == 1 && $key['employment'] == 'Preadmission' ) {
								if( ++$i_supervisor >= 4 ) continue; 
									$new[$index]['role'] = $GLOBALS['sst']['select_jury_members'][4];
							} else if( $key['members'] == 1 && $key['employment'] == 'Admission' ) {
								if( ++$i_member >=7 ) continue; 
									$new[$index]['role'] = $GLOBALS['sst']['select_jury_members'][1];
							} else {
								if( $key['members'] == 2 ) {
									if( ++$i_secretary >= 2 ) continue; 
										$new[$index]['role'] = $GLOBALS['sst']['select_jury_members'][2];
								} else if( $key['members'] == 3 ) {
									if( ++$i_president >= 2 ) continue; 
										$new[$index]['role'] = $GLOBALS['sst']['select_jury_members'][3];
								}
							}

							$new[$index]['type'] = $key['employment'];
							$new[$index]['id_user'] = $key['id_user'];
							$new[$index]['title']   = $GLOBALS['sst']['select_person'][$key['titel']];
							$new[$index]['l_name']  = $key['lastname']; 
							$new[$index]['f_name']  = $key['firstname']; 
							$new[$index]['institution'] = $key['institution']; 
							$new[$index]['email']       = $key['email']; 
							$new[$index]['dir']         = $key['dir']; 	 
						} 
						$index++; 
						if($i_president >= 1 && $i_secretary >= 1 && $i_member >= 6 && $i_supervisor >= 3) break;
					} 
				} 
			if(sizeof($new) > 0 ) {
				foreach($new as $k => $v) {
					$sql = "INSERT INTO extract_my_phd_private_defence_jury() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$new[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$new[$k]['role']."',
								'".$new[$k]['type']."',
								'".$new[$k]['title']."',
								'".$this->quoteIdent( $new[$k]['l_name'])."',
								'".$this->quoteIdent( $new[$k]['f_name'])."',
								'".$new[$k]['institution']."',
								'".$new[$k]['email']."',
								'".$new[$k]['dir']."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 74568686 <<<<<');
					$this->setRecords('extract_my_phd_private_defence_jury', $new[$k]);					
				}
			}
		break;
		case'my_phd_private_defence_status':
		
			 
			
			
			foreach($this->private_defence_status as $k => $v) {
				if( empty($v) ) { continue; }
				$sql = "INSERT INTO extract_my_phd_private_defence_status() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$this->private_defence_status[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_private_defence_satate'][$this->private_defence_status[$k]['state']]."',
								'".$this->private_defence_status[$k]['date_passed']."',
								'".$this->private_defence_status[$k]['date_submitted']."',
								'".$this->private_defence_status[$k]['date_validated']."');";
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 7576765756 <<<<< ');
				$this->setRecords('extract_my_phd_private_defence_status', $this->private_defence_status[$k]);	
			}
		break;
		case'my_phd_public_defence_home':
		
			 
			$new = array();
			for($k = 0; $k < count($this->public_defence_home['public_practical']); $k++) {
			
				$new[$k]['id_user'] = (
							(
								!is_null($id_user = $this->testKeyPublicDefence( 'public_practical', $k, 'id_user' )) ||
								!is_null($id_user = $this->testKeyPublicDefence( 'public_details', $k, 'id_user' )) || 
								!is_null($id_user = $this->testKeyPublicDefence( 'public_state', $k, 'id_user' ))
							) ? $id_user : NULL
				);
				
				if(is_null($new[$k]['id_user']) ) { continue; }
				
				
				$new[$k]['title_of_thesis'] = $this->testKeyPublicDefence( 'public_practical', $k, 'title_of_thesis' );
				
				$new[$k]['date']         =  (
											is_null($date = $this->testKeyPublicDefence( 'public_practical', $k, 'date' )) ?
											NULL : 
											$this->main->settingDate($date)
											);
				
				$this->testKeyPublicDefence( 'public_practical', $k, 'date' );
				$new[$k]['local']        =  $this->testKeyPublicDefence( 'public_practical', $k, 'local' );
				$new[$k]['hour']  =  $this->testKeyPublicDefence( 'public_practical', $k, 'thesis_time' );
				$new[$k]['thesis_place'] =  $this->testKeyPublicDefence( 'public_practical', $k, 'thesis_place' );
				$new[$k]['time']  =  $this->testKeyPublicDefence( 'public_practical', $k, 'j_date_time' );
				
				$new[$k]['details_place']        =  $this->testKeyPublicDefence( 'public_details', $k, 'place' );
				$new[$k]['details_thesis_num']   =  $this->testKeyPublicDefence( 'public_details', $k, 'thesis_num' );
				$new[$k]['details_money']        =  $this->testKeyPublicDefence( 'public_details', $k, 'money' );
				$new[$k]['details_check']        =  $this->testKeyPublicDefence( 'public_details', $k, 'check' );	
				$new[$k]['details_hypertext']    =  $this->testKeyPublicDefence( 'public_details', $k, 'hypertext' );						

				$new[$k]['state'] =  (
									is_null($state = $this->testKeyPublicDefence( 'public_state', $k, 'state' )) ? 
									'NOT YET' : 
									$GLOBALS['sst']['select_public_defence_status'][$state] 
									);
				$new[$k]['state_date']  =  (
											is_null($state_date = $this->testKeyPublicDefence( 'public_state', $k, 'date_submitted' )) ?
											NULL : 
											$this->main->settingDate($state_date)
											);
				$this->testKeyPublicDefence( 'public_state', $k, 'date_submitted' );		
			}
			
			
			 
			
			if(sizeof($new) > 0 ) {
			
			 
				foreach($new as $k => $v) {
					$sql = "INSERT INTO extract_my_phd_public_defence_home() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$new[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$new[$k]['title_of_thesis']."',
								'".$new[$k]['date']."',
								'".$this->quoteIdent( $new[$k]['local'])."',
								'".$this->quoteIdent( $new[$k]['hour'])."',
								'".$this->quoteIdent( $new[$k]['thesis_place'])."',
								'".$this->quoteIdent( $new[$k]['time'])."',
								'".$this->quoteIdent( $new[$k]['details_place'])."',
								'".$this->quoteIdent( $new[$k]['details_thesis_num'])."',
								'".$new[$k]['details_money']."',
								'".$new[$k]['details_check']."',
								'".$new[$k]['details_hypertext']."',
								'".$new[$k]['state']."',
								'".$new[$k]['state_date']."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 75785 <<<<< ');
					$this->setRecords('extract_my_phd_public_defence_home', $new[$k]);
				}
			}
		break;
		case'my_supervosory_panel':
			$new = array();
				$index = 0; 
				foreach($this->my_supervosory_panel as $k => $v) {
					$i_pre = 0; $i_adm = 0;  
					if(empty($v) ) { continue; }
					foreach($v as $key) {
					
						if($key['employment'] == 'Admission') { // members 5
							if(++$i_adm >= 6 )  continue;  
						} else if($key['employment'] == 'Preadmission') { // supervisor 3
							if(++$i_pre >= 4 )  continue;   
						} 
							
						$new[$index]['type'] = $key['employment'];
						$new[$index]['id_user'] = $key['id_user'];
						$new[$index]['title']   = $key['titel'];
						$new[$index]['l_name']  = $key['lastname']; 
						$new[$index]['f_name']  = $key['firstname']; 
						$new[$index]['institution'] = $key['institution']; 
						$new[$index]['email']       = $key['email']; 
						$new[$index]['state']       = $key['state']; 
						$new[$index]['dir']         = $key['dir'];  
						$index++; 
						if($i_adm  >= 5 && $i_pre >= 3) break;  
					} 
				}
				if(sizeof($new) > 0 ) { 
					foreach($new as $k => $v) {
					$sql = "INSERT INTO extract_my_supervisory_panel() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$new[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_person'][$new[$k]['title']]."',
								'".$new[$k]['type']."',
								'".$this->quoteIdent( $new[$k]['l_name'])."',
								'".$this->quoteIdent( $new[$k]['f_name'])."',
								'".$new[$k]['institution']."',
								'".$new[$k]['email']."',
								'".$new[$k]['state']."',
								'".$new[$k]['dir']."');";
					$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 46546456 <<<<< '); 
					}
				}
				
				
		break;
		case'my_doctoral_training': 
			$new = array(); 
			foreach($this->my_doctoral_training as $k => $v) {
					
				if(is_array($doc = $this->dbh->docTrainingHomeSelect($this->my_doctoral_training[$k])) ) {
					$this->total = array();
					$new[$k]['id_user']     = $doc['id_user'];
					$new[$k]['submission']  = $doc['radio'];
					$new[$k]['date']        = $doc['date_created'];
					$this->statusTraining($this->dbh->docTrainingConferenceSelect($this->my_doctoral_training[$k])); 
					$this->statusTraining($this->dbh->docTrainingConferenceListSelectItem(null, $this->my_doctoral_training[$k]));
					$this->statusTraining($this->dbh->docTrainingJournalPapersSelect($this->my_doctoral_training[$k]));
					$this->statusTraining($this->dbh->docTrainingCoursesSelect($this->my_doctoral_training[$k])); 
					$this->statusTraining($this->dbh->docTrainingSeminarsSelect($this->my_doctoral_training[$k])); 
					$this->statusTraining($this->dbh->docTrainingTeachingAndSupervisionSelect($this->my_doctoral_training[$k])); 
					$new[$k]['status'] = $this->total;
					$new[$k]['activities'] = $this->dbh->activitiesDoctoralTraining($this->my_doctoral_training[$k]); 
				}
			}
			
			if(sizeof($new) > 0 ) { 
					foreach($new as $k => $v) {
						$sql = "INSERT INTO extract_my_doctoral_training() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$new[$k]['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$GLOBALS['sst']['select_my_doctoral_training_submission'][$new[$k]['submission']]."',
								'".(isset($new[$k]['status']['validated']) ? $new[$k]['status']['validated'] : 0 )."',
								'".(isset($new[$k]['status']['submitted']) ? $new[$k]['status']['submitted'] : 0 )."',
								'".(isset($new[$k]['activities']['training'])      ? $new[$k]['activities']['training'] : 0 )."',
								'".(isset($new[$k]['activities']['communication']) ? $new[$k]['activities']['communication'] : 0 )."',
								'".(isset($new[$k]['activities']['teaching'])      ? $new[$k]['activities']['teaching'] : 0 )."',
								'".(isset($new[$k]['activities']['other'])         ? $new[$k]['activities']['other'] : 0 )."',
								'".(isset($new[$k]['activities']['total'])         ? $new[$k]['activities']['total'] : 0 )."',
								'".$this->main->settingDate($new[$k]['date'])."');";
						$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 46465 <<<<< '); 
						$this->setRecords('extract_my_doctoral_training', $new[$k]);
					}
				}
		break;
		case'my_additional_programme':
			
			foreach($this->my_additional_programme as $k => $v) {
				if(is_array($v)) {  
					$num = null;
					$num_validated = null; 
					$id_user = null;
					foreach($v as $j) {
						if(empty($j['id_user'])) continue; 
							 
						$id_user = $j['id_user'];
						$dir = $this->main->isDirectoryExists(DIR_FOLDER_MY_ADDITIONAL_PROGRAMME_SIMPLE.$j['dir']); 
						if($dir) {
							if($this->main->countOpenDirectory($dir) > 0)	{
								$num_validated += (is_numeric($j['ects']) ? ($j['ects']) : 0);
							} else {
								$num += (is_numeric($j['ects']) ? ($j['ects']) : 0);
							}
						}	
					}
					if(!is_null($id_user)) {
						// total 
						$nb_credits = (is_null($num) ? 0 : $num); 
						// total of those with file attachment
						$nb_credits_validated = (is_null($num_validated) ? 0 : $num_validated); 
						
						$sql = "INSERT INTO extract_my_additional_programme() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."', 
								'".$j['id_user']."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$nb_credits."',
								'".$nb_credits_validated."');";
						$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 12585232 <<<<< '); 
					 	
					}
				}
			}	
			
		break;
		case'my_cotutelle':
			
			foreach($this->my_cotutelle['id_user'] as $k => $v) {
			
				$sql = "INSERT INTO extract_my_cotutelle() VALUES ('{$this->dbh->guid()}',
								'".$this->memory['id_admin']."',
								'".$this->my_cotutelle['id_user'][$k]."', 
								'".$this->memory['id_name']."', 
								'".$this->memory['val_field']."',
								'".$this->my_cotutelle['file'][$k]."');"; // $this->my_cotutelle['file'][$k]
				$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 47575676 <<<<< ');
						
			}
			$this->setRecords('extract_my_cotutelle', $this->my_cotutelle);		
		break;
	}
 }
 
 public function statusTraining($arr) {
	if(is_array($arr) ) {  
		foreach( $arr as $k => $v ) {
			if($arr[$k]['status'] == 2) { 
				if(!array_key_exists('submitted', $this->total)) { 
					$this->total['submitted'] = 1; 
				} else { 
					$this->total['submitted']++; 
				}
			} else if($arr[$k]['status'] == 3) { 
				if(!array_key_exists('validated', $this->total)) {
					$this->total['validated'] = 1; 
				} else { 
					$this->total['validated']++; 
				}
			}
		} 
	}
	return $this->total;	
 }
 
 public function testKeyPublicDefence( $index1, $k, $index2 ) {
	if(isset($this->public_defence_home[$index1][$k][$index2]) ) {
		return $this->public_defence_home[$index1][$k][$index2];
	} else {
		return NULL;
	}
 }
 
 public function getActivities($arr) {
	$new = array();
	if(is_array($r = $arr) && (sizeof($r) > 0) ) {
		$i = 0;
		$new['total'] = 0;
		do {
			for($j = 0; $j < 9; $j++) {
				if($arr[$i]['activities'] == $j) {
				
					$new[$j]['activities'] = (int)$arr[$i]['activities'];
					$new[$j]['id_user']    = $arr[$i]['id_user'];
					$new[$j]['ects']       = (int)(
											  isset($new[$j]['ects']) ? 
											  ($new[$j]['ects']+$arr[$i]['ects']) :
											  $arr[$i]['ects']
											);
					break;					
				}
			}
			$new['total'] += $arr[$i]['ects'];
			$i++;
		} while($i < sizeof($r));
	}
	return $new;
 }

  public function joinMyProfile($id_name) {  
	$sql = "SELECT * FROM `extract_my_profile` WHERE `id_name`='".$id_name."'";
	return $this->fetch($sql);
 }
 
 public function deleteTableExtract() {
	$name_table = ExtractResult::getNameTables();
	$r = array();
	$id = ($this->dbh->isID($this->admin->getSessionAdmin()) ? $this->admin->getSessionAdmin() : NULL );
	if(is_null($id)) { return false;}
	for($i = 0; $i < count($name_table); $i++ ) {
		if(isset($name_table[$i])) {
			$r['table'] = $name_table[$i];
			$r['col'] = 'id_admin';
			$r['del'] = $id;
			$this->dbh->deleteAllCol($r);
		}	
	}
		return true;
 }
 
  public function offset() {
	$fill = array();
	if(is_array($records = $this->getRecords()) && (sizeof($records) > 0) ) {
		$arrayobj = new ArrayObject(self::getNameFieldsExtract());		
		$iterator = $arrayobj->getIterator();
		while ( $iterator->valid() ) {
			if (array_key_exists($iterator->key(), $records)) { 
				$fill[$iterator->key()]['fields'] = $iterator->current();
				$fill[$iterator->key()]['values'] = $records[$iterator->key()];
			} else {
				$fill[$iterator->key()]['fields'] = $iterator->current();
				$fill[$iterator->key()]['values'] = null;
			}
			$iterator->next();	
		}
	}
	return $fill;
 }

 // update delete insert
 public function requestSQL($sql=null, $test=null) {
	 
	if(is_null($sql)) return false;
		try {
			$dbh = $this->dbh->DB();
			$dbh->beginTransaction(); 
			$sth = $dbh->prepare($sql);
			$sth->execute(); 
			$dbh->commit(); 
			if( $test == 'COUNT' ) return $sth->rowCount();
			return true;
		} catch (Exception $e) {
			$dbh->rollback(); 
			print('ERROR Extract # 524545184 ' . $test . ' ' . $e->getMessage() . ' LINE = > ' . $e->getLine() . ' ' );
		}
 }
 
 // select 
 public function fetch($sql, $test='ALL') {
	if(is_null($sql)) return false;
		try {
			$dbh = $this->dbh->DB();
			$sth = $dbh->prepare($sql);
			$sth->execute(); 
			if($sth->rowCount() > 0 ) { 
				return ($test == 'ALL' ?  $sth->fetchAll(PDO::FETCH_ASSOC) : $sth->fetch(PDO::FETCH_ASSOC)); 
			} else {
				return false;
			}		
			 
		} catch (Exception $e) { 
			print('ERROR Extract # 5655286 '.$test .' ' .$e->getMessage());
		}
 }

 private function disconnectDB() { 
	try {
		return $this->dbh = null;
	} catch (Exception $e) {
		print('ERROR Extract # 5045758 ');
	}
 }

 public function __destruct() {
    $this->disconnectDB();
 }
 
 private static function close() { } 
 
 public static function getNameFieldsExtract() {
	$name_table = self::getNameTables();
	return array(
			// extract_my_profile
			$name_table[0] => array('id_extract', 'id_admin', 'id_user', 'id_name', 'value', 'title', 'l_name', 'f_name',  'b_place', 'b_date', 
									'mobile','phd_domain', 'sciences', 'institute','founding', 'e_mail','inst_name', 'inst_mail', 'o_street',
									'o_box_number', 'o_postcode', 'o_city', 'o_country', 'o_tel', 'c_university', 
									'c_street', 'c_box_number', 'c_postcode', 'c_city', 'c_country', 'c_tel', 'date_form'),
			// extract_my_academic_cv						
			$name_table[1] => array('dpl_1', 'dpl_2', 'dpl_3', 'dpl_4', 'dpl_5'),
			/*
				'dpl_more' = YES OR NON 
				((fields = 5 * 8) + (dpl_more 1)) = 41 fields this is in db
				('dpl_id1', 'dpl_level1', 'dpl_title1', 'dpl_inst1', 'dpl_awarded1','dpl_issued1','dpl_number1', dpl_obtained1)
				('dip_id2', 'dip_level2', 'dip_title2', 'dip_inst2', 'dip_awarded2','dip_issued2','dip_number2', dpl_obtained2) 
				('dip_id3', 'dip_level3', 'dip_title3', 'dip_inst3', 'dip_awarded3','dip_issued3','dip_number3', dpl_obtained3) 
				('dip_id4', 'dip_level4', 'dip_title4', 'dip_inst4', 'dip_awarded4','dip_issued4','dip_number4', dpl_obtained4) 
				('dip_id5', 'dip_level5', 'dip_title5', 'dip_inst5', 'dip_awarded5','dip_issued5','dip_number5', dpl_obtained5) 				
			*/
									
			// extract_my_phd_admission
			/*
			
			//$r[$set[$name_table[2]]['fields'][4]] = $set[$name_table[2]]['values'][$k]['inst_diploma'];
						//$r[$set[$name_table[2]]['fields'][5]] = $set[$name_table[2]]['values'][$k]['issued_diploma'];
						//$r[$set[$name_table[2]]['fields'][6]] = $set[$name_table[2]]['values'][$k]['awarded_diploma'];
			*/
			$name_table[2] => array('admission_type',
									'admission_text',
									'admission_state',
									'date_preadmission',
									'date_admission',
									'admission_name_diploma',
									'admission_inst_diploma',
									'admission_issued_diploma',
									'admission_awarded_diploma'
									),  
			// institution and date issued 
			// extract_my_phd_admission_research_project
			$name_table[3] => array('admission_title'),
			// extract_my_phd_admission_additional_programme
			$name_table[4] => array('course1','course2','course3','course4','course5', 'credits_total'),
			// extract_my_phd_admission_supervisory_panel not in db 
			$name_table[6] => array('prefix_p1', 'prefix_p2', 'prefix_p3', 'prefix_a1', 'prefix_a2', 'prefix_a3', 'prefix_a4', 'prefix_a5'),
			/*
				('p1l_name','p1f_name', 'p1_inst')
				('p2l_name','p2f_name', 'p2_inst')
				('p3l_name','p3f_name', 'p3_inst') 
				('a1l_name','a1f_name', 'a1_inst')
				('a2l_name','a2f_name', 'a2_inst')
				('a3l_name','a3f_name', 'a3_inst') 
				('a4l_name','a4f_name', 'a4_inst')
				('a5l_name','a5f_name', 'a5_inst') 
			*/
			// extract_my_phd_confirmation_submit			
			$name_table[8] => array('confirm_date', 'confirm_state', 'confirm_submitted_date'),
			// extract_my_phd_confirmation_planning
			$name_table[9] => array('confirm_deadline', 'confirm_text', 'confirm_planning_state', 'confirm_sended_date', 'confirm_accepted_date'),
			// extract_my_phd_private_defence_home
			$name_table[10] => array('private_thesis1','private_thesis2','private_date'),
			// extract_my_phd_private_defence_jury not in db 
			$name_table[11] => array('prefix_pr1', 'prefix_se1', 'prefix_su1', 'prefix_su2', 'prefix_su3', 'prefix_me1', 'prefix_me2', 'prefix_me3', 'prefix_me4', 'prefix_me5', 'prefix_me6',),
			/*
				('pr1l_name', 'pr1f_name', 'pr1_inst') 
				('se1l_name', 'se1f_name', 'se1_inst') 
				('su1l_name', 'su1f_name', 'su1_inst') 
				('su2l_name', 'su2f_name', 'su2_inst') 
				('su3l_name', 'su3f_name', 'su3_inst')
				('me1l_name', 'me1f_name', 'me1_inst')
				('me2l_name', 'me2f_name', 'me2_inst') 
				('me3l_name', 'me3f_name', 'me3_inst') 
				('me4l_name', 'me4f_name', 'me4_inst')
				('me5l_name', 'me5f_name', 'me5_inst')
				('me6l_name', 'me6f_name', 'me6_inst')
			*/
			// extract_my_phd_private_defence_status
			$name_table[12] => array('private_state', 'private_passed_date','private_submitted_date', 'private_validated_date'),
			//extract_my_phd_public_defence_home
			$name_table[13] => array('public_title_of_thesis', 'public_date', 'public_local','public_hour','public_thesis_place','public_time','public_details_place',
									'public_details_thesis_num','public_details_money','public_details_check',
									'public_details_hypertext','public_state','public_state_date',),
			// extract_my_doctoral_training
			$name_table[15] => array('doctoral_submission', 'doctoral_date', 'doctoral_validated', 'doctoral_submitted',
											'doctoral_training', 'doctoral_communication','doctoral_teaching','doctoral_other','doctoral_total',),
			// extract_my_cotutelle
			$name_table[17] => array('cotutelle'), 
		); 
 }
 
 public function container() {
	$set = $this->offset();
	$name_table = self::getNameTables();
	$name_field = self::getNameFieldsExtract();
	$arrayobj = new ArrayObject();
	
		// $this->memory['id_admin'] $this->memory['id_name'] $this->memory['val_field']
		$r = array(); $result = array();
		foreach($set[$name_table[0]]['values'] as $k => $v) {
		
			$r[$set[$name_table[0]]['fields'][0]] = $this->dbh->guid();
			$r[$set[$name_table[0]]['fields'][1]] = $this->memory['id_admin'];
			$r[$set[$name_table[0]]['fields'][2]] = $set[$name_table[0]]['values'][$k][0]['id_user'];
			$r[$set[$name_table[0]]['fields'][3]] = $this->memory['id_name'];
			$r[$set[$name_table[0]]['fields'][4]] = $this->memory['val_field'];
			$r[$set[$name_table[0]]['fields'][5]] = $set[$name_table[0]]['values'][$k][0]['title'];
			$r[$set[$name_table[0]]['fields'][6]] = $set[$name_table[0]]['values'][$k][0]['last_name'];
			$r[$set[$name_table[0]]['fields'][7]] = $set[$name_table[0]]['values'][$k][0]['first_name'];
			$r[$set[$name_table[0]]['fields'][8]] = $set[$name_table[0]]['values'][$k][0]['birth_place'];
			$r[$set[$name_table[0]]['fields'][9]] = $set[$name_table[0]]['values'][$k][0]['birth_date'];
			$r[$set[$name_table[0]]['fields'][10]] = $set[$name_table[0]]['values'][$k][0]['mobile']; //   
			$r[$set[$name_table[0]]['fields'][11]] = (
													 is_numeric($set[$name_table[0]]['values'][$k][0]['phd']) ?
													 $GLOBALS['sst']['select_phd'][$set[$name_table[0]]['values'][$k][0]['phd']] :
													 ''  
													 ) ;
													 
			$r[$set[$name_table[0]]['fields'][12]] = (
													is_numeric($set[$name_table[0]]['values'][$k][0]['sciences']) ?
													$GLOBALS['sst']['select_sciences'][$set[$name_table[0]]['values'][$k][0]['sciences']]:
													''
													);
			
			$r[$set[$name_table[0]]['fields'][13]] = $set[$name_table[0]]['values'][$k][0]['institution'];
			$r[$set[$name_table[0]]['fields'][14]] = $set[$name_table[0]]['values'][$k][0]['thesis'];
			
			$r[$set[$name_table[0]]['fields'][15]] = $set[$name_table[0]]['values'][$k][0]['e-mail'];
			
			$r[$set[$name_table[0]]['fields'][16]] = $this->institution['inst_name'][$k];
			$r[$set[$name_table[0]]['fields'][17]] = $this->institution['inst_mail'][$k];
			
			$r[$set[$name_table[0]]['fields'][18]] = $set[$name_table[0]]['values'][$k][1]['street'];
			$r[$set[$name_table[0]]['fields'][19]] = $set[$name_table[0]]['values'][$k][1]['box_num'];
			$r[$set[$name_table[0]]['fields'][20]] = $set[$name_table[0]]['values'][$k][1]['postal_code'];
			$r[$set[$name_table[0]]['fields'][21]] = $set[$name_table[0]]['values'][$k][1]['city'];
			$r[$set[$name_table[0]]['fields'][22]] = $set[$name_table[0]]['values'][$k][1]['country'];
			$r[$set[$name_table[0]]['fields'][23]] = $set[$name_table[0]]['values'][$k][1]['tel'];
			$r[$set[$name_table[0]]['fields'][24]] = $set[$name_table[0]]['values'][$k][2]['univ'];
			$r[$set[$name_table[0]]['fields'][25]] = $set[$name_table[0]]['values'][$k][2]['street'];
			$r[$set[$name_table[0]]['fields'][26]] = $set[$name_table[0]]['values'][$k][2]['box_num'];
			$r[$set[$name_table[0]]['fields'][27]] = $set[$name_table[0]]['values'][$k][2]['postal_code'];
			$r[$set[$name_table[0]]['fields'][28]] = $set[$name_table[0]]['values'][$k][2]['city'];
			$r[$set[$name_table[0]]['fields'][29]] = $set[$name_table[0]]['values'][$k][2]['country'];
			$r[$set[$name_table[0]]['fields'][30]] = $set[$name_table[0]]['values'][$k][2]['tel'];
			$r[$set[$name_table[0]]['fields'][31]] = $this->main->settingDate($set[$name_table[0]]['values'][$k][2]['date']);
			$result[$k] = $r;	
		} 
		$arrayobj->offsetSet($name_table[0],  $result); 
		
		// extract_my_phd_admission
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {

			$r = $this->fillTheVoid($set,  $name_table[2], sizeof($name_field[$name_table[2]]));
			 
			if(is_array($set[$name_table[2]]['values'])) {
				/*
				echo '<pre>';
					//print_r($set[$name_table[2]]['values']);
				echo '</pre>';
				*/
				
				foreach($set[$name_table[2]]['values'] as $k => $v) {
					 
					if($set[$name_table[2]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) {
					
						$type = (($set[$name_table[2]]['values'][$k]['employment'] == 'Admission') ? 'ADMISSION' : 'PRE-ADMISSION'); 
						$status = $this->dbh->getEachStatus($set[$name_table[0]]['values'][$i][0]['id_user'], $type, 'STR');
						$s = (empty($status) ? $GLOBALS['sst']['select_status'][1] : $status);
					
						$r[$set[$name_table[2]]['fields'][0]] = $set[$name_table[2]]['values'][$k]['employment'];
						$r[$set[$name_table[2]]['fields'][1]] = $set[$name_table[2]]['values'][$k]['text'];
						$r[$set[$name_table[2]]['fields'][2]] = $s;
						
						$r[$set[$name_table[2]]['fields'][3]] = $this->main->settingDate($set[$name_table[2]]['values'][$k]['date_preadmission']);
						$r[$set[$name_table[2]]['fields'][4]] = $this->main->settingDate($set[$name_table[2]]['values'][$k]['date_admission']);
						
						$r[$set[$name_table[2]]['fields'][5]] = $set[$name_table[2]]['values'][$k]['name_diploma'];
						$r[$set[$name_table[2]]['fields'][6]] = $set[$name_table[2]]['values'][$k]['inst_diploma'];
						$r[$set[$name_table[2]]['fields'][7]] = $set[$name_table[2]]['values'][$k]['issued_diploma'];
						$r[$set[$name_table[2]]['fields'][8]] = $set[$name_table[2]]['values'][$k]['awarded_diploma'];
						 
					} 
				} 
			}	
			$result[$i] = $r; 
		}
		$arrayobj->offsetSet($name_table[2],  $result); 
		
		// extract_my_phd_admission_research_project
		$r = array(); $result = array();
		 
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {

			$r = $this->fillTheVoid($set,  $name_table[3], sizeof($name_field[$name_table[3]]));
			 
			  
			 
			if(is_array($set[$name_table[3]]['values'])) {
			
				foreach($set[$name_table[3]]['values'] as $k => $v) {
					if($set[$name_table[3]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) { 
						$r[$set[$name_table[3]]['fields'][0]] = $set[$name_table[3]]['values'][$k]['text'];										 
					}
				}
			}	
			$result[$i] = $r; 
		}
		$arrayobj->offsetSet($name_table[3],  $result); 
		
		// extract_my_phd_admission_additional_programme
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[4], sizeof($name_field[$name_table[4]]));
			 
			if(is_array($set[$name_table[4]]['values'])) {
			
				foreach($set[$name_table[4]]['values'] as $k => $v) {
					if($set[$name_table[4]]['values'][$k]['id_user'][0] == $set[$name_table[0]]['values'][$i][0]['id_user']) {
					$r[$set[$name_table[4]]['fields'][0]] = (
															isset($set[$name_table[4]]['values'][$k]['name_course'][0]) ?
															$set[$name_table[4]]['values'][$k]['name_course'][0] : 
															NULL
															);
					$r[$set[$name_table[4]]['fields'][1]] = (
															isset($set[$name_table[4]]['values'][$k]['name_course'][1]) ?
															$set[$name_table[4]]['values'][$k]['name_course'][1] : 
															NULL
															);
					$r[$set[$name_table[4]]['fields'][2]] = (
															isset($set[$name_table[4]]['values'][$k]['name_course'][2]) ?
															$set[$name_table[4]]['values'][$k]['name_course'][2] : 
															NULL
															); 			
					$r[$set[$name_table[4]]['fields'][3]] = (
															isset($set[$name_table[4]]['values'][$k]['name_course'][3]) ? 
															$set[$name_table[4]]['values'][$k]['name_course'][3] : 
															NULL
															);
					$r[$set[$name_table[4]]['fields'][4]] = (
															isset($set[$name_table[4]]['values'][$k]['name_course'][4]) ?
															$set[$name_table[4]]['values'][$k]['name_course'][4] : 
															NULL
															);
					$r[$set[$name_table[4]]['fields'][5]] = (
															isset($set[$name_table[4]]['values'][$k]['total'][0]) ?
															$set[$name_table[4]]['values'][$k]['total'][0] : 
															NULL
															);		
					}
				}  
			}
			$result[$i] = $r; 			
		}
		$arrayobj->offsetSet($name_table[4],  $result); 
		
		// extract_my_phd_admission_supervisory_panel
		$r = array(); $result = array();
		$this->arr_sup = $this->main->arrayMultisort($set[$name_table[6]]['values'], 'type', SORT_ASC);	
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
			
			$id_user = $set[$name_table[0]]['values'][$i][0]['id_user'];
			
			$r[$set[$name_table[6]]['fields'][0]] = $this->getContentType('Preadmission', $id_user,  'p1');
			$r[$set[$name_table[6]]['fields'][1]] = $this->getContentType('Preadmission', $id_user,  'p2');
			$r[$set[$name_table[6]]['fields'][2]] = $this->getContentType('Preadmission', $id_user,  'p3');
			$r[$set[$name_table[6]]['fields'][3]] = $this->getContentType('Admission', $id_user,  'a1');
			$r[$set[$name_table[6]]['fields'][4]] = $this->getContentType('Admission', $id_user,  'a2');
			$r[$set[$name_table[6]]['fields'][5]] = $this->getContentType('Admission', $id_user,  'a3');
			$r[$set[$name_table[6]]['fields'][6]] = $this->getContentType('Admission', $id_user,  'a4');
			$r[$set[$name_table[6]]['fields'][7]] = $this->getContentType('Admission', $id_user,  'a5');

			$result[$i] = $r; 	
		}		
		$this->arr_sup = array();
		$arrayobj->offsetSet($name_table[6],  $result);
		
		// extract_my_phd_confirmation_submit			
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) { 
			
			$r = $this->fillTheVoid($set,  $name_table[8], sizeof($name_field[$name_table[8]]));
			if(is_array($set[$name_table[8]]['values'])) {
				foreach($set[$name_table[8]]['values'] as $k => $v) {
					if($set[$name_table[8]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) { 
						$r[$set[$name_table[8]]['fields'][0]] = $this->main->settingDate($set[$name_table[8]]['values'][$k]['date_of_confirm']);	
						$r[$set[$name_table[8]]['fields'][1]] = $GLOBALS['sst']['select_confirm_state'][$set[$name_table[8]]['values'][$k]['select_confirm_state']];	
						$r[$set[$name_table[8]]['fields'][2]] = $this->main->settingDate($set[$name_table[8]]['values'][$k]['date_submitted']);	
					}
				}
			}	
			$result[$i] = $r;	
		}
		$arrayobj->offsetSet($name_table[8],  $result); 
		 
		// extract_my_phd_confirmation_planning
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) { 
			
			$r = $this->fillTheVoid($set,  $name_table[9], sizeof($name_field[$name_table[9]]));
			if(is_array($set[$name_table[9]]['values'][0]) ) {
			foreach($set[$name_table[9]]['values'][0]['deadline'] as $k => $v) {
				 
				if( isset($set[$name_table[9]]['values'][0]['deadline'][$k]['id_user']) ) {
					if($set[$name_table[9]]['values'][0]['deadline'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user'] ) {
						$r[$set[$name_table[9]]['fields'][0]] = $this->main->settingDate($set[$name_table[9]]['values'][0]['deadline'][$k]['deadline']); 
						$r[$set[$name_table[9]]['fields'][1]] = $set[$name_table[9]]['values'][0]['deadline'][$k]['text']; 
					}
				}
				if( isset($set[$name_table[9]]['values'][0]['state'][$k]['id_user'] ) ) {  
					if($set[$name_table[9]]['values'][0]['state'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user'] ) {
						$r[$set[$name_table[9]]['fields'][2]] = (
																$set[$name_table[9]]['values'][0]['state'][$k]['status'] == 0 ?
																'' :
																$set[$name_table[9]]['values'][0]['state'][$k]['status']
																);
						
						 
						$r[$set[$name_table[9]]['fields'][3]] = $this->main->settingDate($set[$name_table[9]]['values'][0]['state'][$k]['date_sended']);
						$r[$set[$name_table[9]]['fields'][4]] = $this->main->settingDate($set[$name_table[9]]['values'][0]['state'][$k]['date_accepted']);  						
					}
				}
			}
			}
			$result[$i] = $r;
		}
		$arrayobj->offsetSet($name_table[9],  $result); 
		
		// extract_my_phd_private_defence_home
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[10], sizeof($name_field[$name_table[10]]));
			
			if(is_array($set[$name_table[10]]['values']) ) {
				foreach($set[$name_table[10]]['values'] as $k => $v) {
					if($set[$name_table[10]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) { 
						$r[$set[$name_table[10]]['fields'][0]] = $set[$name_table[10]]['values'][$k]['thesis1'];
						$r[$set[$name_table[10]]['fields'][1]] = $set[$name_table[10]]['values'][$k]['thesis2'];
						$r[$set[$name_table[10]]['fields'][2]] = $this->main->settingDate($set[$name_table[10]]['values'][$k]['date']);
					}
				}
			}	
			$result[$i] = $r;
		}
		$arrayobj->offsetSet($name_table[10],  $result); 
		
		// // extract_my_phd_private_defence_jury not in db  
		$r = array(); $result = array();
		$this->arr_sup = $this->main->arrayMultisort($set[$name_table[11]]['values'], 'role', SORT_ASC);		
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
			// Supervisor , Member, Secretary , President
			$id_user = $set[$name_table[0]]['values'][$i][0]['id_user'];
			
			$r[$set[$name_table[11]]['fields'][0]] = $this->getContentType('President', $id_user,  'p1', 'role');
			
			$r[$set[$name_table[11]]['fields'][1]] = $this->getContentType('Secretary', $id_user,  'se1', 'role');
			
			$r[$set[$name_table[11]]['fields'][2]] = $this->getContentType('Supervisor', $id_user,  'su1', 'role');
			$r[$set[$name_table[11]]['fields'][3]] = $this->getContentType('Supervisor', $id_user,  'su2', 'role');
			$r[$set[$name_table[11]]['fields'][4]] = $this->getContentType('Supervisor', $id_user,  'su3', 'role');
			
			$r[$set[$name_table[11]]['fields'][5]] = $this->getContentType('Member', $id_user,  'me1', 'role');
			$r[$set[$name_table[11]]['fields'][6]] = $this->getContentType('Member', $id_user,  'me2', 'role');
			$r[$set[$name_table[11]]['fields'][7]] = $this->getContentType('Member', $id_user,  'me3', 'role');
			$r[$set[$name_table[11]]['fields'][8]] = $this->getContentType('Member', $id_user,  'me4', 'role');
			$r[$set[$name_table[11]]['fields'][9]] = $this->getContentType('Member', $id_user,  'me5', 'role');
			$r[$set[$name_table[11]]['fields'][10]] = $this->getContentType('Member', $id_user,  'me6', 'role');

			$result[$i] = $r; 	
		}		 
		$this->arr_sup = array();
		$arrayobj->offsetSet($name_table[11],  $result);

		// extract_my_phd_private_defence_status
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[12], sizeof($name_field[$name_table[12]]));
			
			
			if(is_array($set[$name_table[12]]['values']) ) {
				foreach($set[$name_table[12]]['values'] as $k => $v) {
					if($set[$name_table[12]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) { 
						$r[$set[$name_table[12]]['fields'][0]] = $GLOBALS['sst']['select_private_defence_satate'][$set[$name_table[12]]['values'][$k]['state']];
						$r[$set[$name_table[12]]['fields'][1]] = $this->main->settingDate($this->main->settingDate($set[$name_table[12]]['values'][$k]['date_passed']));
						$r[$set[$name_table[12]]['fields'][2]] = $this->main->settingDate($this->main->settingDate($set[$name_table[12]]['values'][$k]['date_submitted']));
						
						$r[$set[$name_table[12]]['fields'][3]] = $this->main->settingDate($this->main->settingDate($set[$name_table[12]]['values'][$k]['date_validated']));
					}
				}
			}	
			$result[$i] = $r;
		}
		$arrayobj->offsetSet($name_table[12],  $result); 		  
		
		//extract_my_phd_public_defence_home				
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[13], sizeof($name_field[$name_table[13]]));
			
			if(is_array($set[$name_table[13]]['values']) ) { 
				foreach($set[$name_table[13]]['values'] as $k => $v) {
					if($set[$name_table[13]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) {
					
						$r[$set[$name_table[13]]['fields'][0]] = $set[$name_table[13]]['values'][$k]['title_of_thesis'];
						$r[$set[$name_table[13]]['fields'][1]] = $this->main->settingDate($set[$name_table[13]]['values'][$k]['date']);
						$r[$set[$name_table[13]]['fields'][2]] = $set[$name_table[13]]['values'][$k]['local'];
						$r[$set[$name_table[13]]['fields'][3]] = $set[$name_table[13]]['values'][$k]['hour'];
						$r[$set[$name_table[13]]['fields'][4]] = $set[$name_table[13]]['values'][$k]['thesis_place'];
						$r[$set[$name_table[13]]['fields'][5]] = $set[$name_table[13]]['values'][$k]['time'];
						$r[$set[$name_table[13]]['fields'][6]] = $set[$name_table[13]]['values'][$k]['details_place'];
						$r[$set[$name_table[13]]['fields'][7]] = $set[$name_table[13]]['values'][$k]['details_thesis_num'];
						$r[$set[$name_table[13]]['fields'][8]] = $set[$name_table[13]]['values'][$k]['details_money'];
						$r[$set[$name_table[13]]['fields'][9]] = $set[$name_table[13]]['values'][$k]['details_check'];
						$r[$set[$name_table[13]]['fields'][10]] = $set[$name_table[13]]['values'][$k]['details_hypertext'];
						$r[$set[$name_table[13]]['fields'][11]] = $set[$name_table[13]]['values'][$k]['state'];
						$r[$set[$name_table[13]]['fields'][12]] = $this->main->settingDate($set[$name_table[13]]['values'][$k]['state_date']);
					}
				}
			}	
			$result[$i] = $r;
		}
		$arrayobj->offsetSet($name_table[13],  $result); 	
		
		// extract_my_doctoral_training
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[15], sizeof($name_field[$name_table[15]]));

			if(is_array($set[$name_table[15]]['values'])) {
				foreach($set[$name_table[15]]['values'] as $k => $v) { 
					if($set[$name_table[15]]['values'][$k]['id_user'] == $set[$name_table[0]]['values'][$i][0]['id_user']) {  
						$state = $GLOBALS['sst']['select_my_doctoral_training_submission'][$set[$name_table[15]]['values'][$k]['submission']];
						
						$r[$set[$name_table[15]]['fields'][0]] = $state;
						$r[$set[$name_table[15]]['fields'][1]] = $this->main->settingDate($set[$name_table[15]]['values'][$k]['date']);
					
						$r[$set[$name_table[15]]['fields'][2]] = (
															isset($set[$name_table[15]]['values'][$k]['status']['validated']) ? 
															$set[$name_table[15]]['values'][$k]['status']['validated'] :
															0
															);
						$r[$set[$name_table[15]]['fields'][3]] = (
															isset($set[$name_table[15]]['values'][$k]['status']['submitted']) ? 
															$set[$name_table[15]]['values'][$k]['status']['submitted'] :
															0
															);
						$r[$set[$name_table[15]]['fields'][4]] = $set[$name_table[15]]['values'][$k]['activities']['training']; 												
						$r[$set[$name_table[15]]['fields'][5]] = $set[$name_table[15]]['values'][$k]['activities']['communication']; 										
						$r[$set[$name_table[15]]['fields'][6]] = $set[$name_table[15]]['values'][$k]['activities']['teaching']; 
						$r[$set[$name_table[15]]['fields'][7]] = $set[$name_table[15]]['values'][$k]['activities']['other']; 	
						$r[$set[$name_table[15]]['fields'][8]] = $set[$name_table[15]]['values'][$k]['activities']['total']; 					
					}
				}	
			}
			$result[$i] = $r;
		}
		$arrayobj->offsetSet($name_table[15],  $result); 
		
		// extract_my_cotutelle
		$r = array(); $result = array();
		for($i = 0; $i < sizeof($set[$name_table[0]]['values']); $i++) {
		
			$r = $this->fillTheVoid($set,  $name_table[17], sizeof($name_field[$name_table[17]]));
			
			if(is_array($set[$name_table[17]]['values'])) {
				foreach($set[$name_table[17]]['values'][0]['id_user'] as $k => $v) {
					if($set[$name_table[17]]['values'][0]['id_user'][$k] == $set[$name_table[0]]['values'][$i][0]['id_user']) { 
						$r[$set[$name_table[17]]['fields'][0]] = $set[$name_table[17]]['values'][0]['file'][$k];
					}
				}
			}	
			$result[$i] = $r;
		}	
		$arrayobj->offsetSet($name_table[17],  $result); 
		
		// extract_my_academic_cv
		$r = array(); $result = array();
		
			//print_r($set);
		// for($i = 0; $i < sizeof($set[$name_table[1]]['values']); $i++) {
		for($i = 0; $i < sizeof($set[$name_table[1]]['values']); $i++) {
			
			$r = $this->fillTheVoid($set,  $name_table[1], sizeof($name_field[$name_table[1]]));
			 
			$r[$set[$name_table[1]]['fields'][0]] = (is_array($set[$name_table[1]]['values'][$i][0]) ? 
															$set[$name_table[1]]['values'][$i][0] : null) ;
			$r[$set[$name_table[1]]['fields'][1]] = (is_array($set[$name_table[1]]['values'][$i][1]) ? 
															$set[$name_table[1]]['values'][$i][1] : null) ;
			$r[$set[$name_table[1]]['fields'][2]] = (is_array($set[$name_table[1]]['values'][$i][2]) ? 
															$set[$name_table[1]]['values'][$i][2] : null) ;
			$r[$set[$name_table[1]]['fields'][3]] = (is_array($set[$name_table[1]]['values'][$i][3]) ? 
															$set[$name_table[1]]['values'][$i][3] : null) ;
			$r[$set[$name_table[1]]['fields'][4]] = (is_array($set[$name_table[1]]['values'][$i][4]) ? 
															$set[$name_table[1]]['values'][$i][4] : null) ;
			$r[$set[$name_table[1]]['fields'][5]] = (is_array($set[$name_table[1]]['values'][$i][5]) ? 
															$set[$name_table[1]]['values'][$i][5] : null) ;												

															
			$this->dpl_more[$i] = (sizeof($set[$name_table[1]]['values'][$i]) > sizeof($name_field[$name_table[1]]) ?
									'  YES ' : ' NON ');
			
			$result[$i] = $r; 	
		}		

		$arrayobj->offsetSet($name_table[1],  $result); 
		
		$iterator = $arrayobj->getIterator();
		
		$this->insertContainer(sizeof($name_table[0]), $iterator);
 }
 
 public function insertContainer($size, $iterator, $index=0) {
	// add Grade awarded for the final diploma (if available): IMPORTANT 
	$name_table = self::getNameTables();
	$name_field = self::getNameFieldsExtract();
	
	$new = array();
	while ( $iterator->valid() ) {	
		$count = $index;	
		 
			foreach($iterator[$iterator->key()] as $k => $v ) {
			
				if(is_array($iterator[$iterator->key()][$count]) ) {
					if($index == $index) {
						foreach($iterator[$iterator->key()][$count] as $k_res => $v_res ) {
							 
							if(stripos($k_res, 'prefix_') !== false) {
								$exp = explode("prefix_", $k_res);
								$new[$count][$exp[1].'l_name'] = (is_array($v_res) ? $this->quoteIdent ( $v_res['l_name'] )      : '');
								$new[$count][$exp[1].'f_name'] = (is_array($v_res) ? $v_res['f_name']      : '');
								$new[$count][$exp[1].'_inst']  = (is_array($v_res) ? $v_res['institution'] : '');
							} else if(stripos($k_res, 'dpl_') !== false) {
								$exp = explode("dpl_", $k_res);
								$new[$count]['dpl_id'.$exp[1]] = 	(is_array($v_res) ? 
																		$this->quoteIdent ( $v_res['id_diploma'] )  : '');
								$new[$count]['dpl_level'.$exp[1]] = (is_array($v_res) ?
																		$GLOBALS['sst']['select_diploma'][$v_res['level_diploma']]  : '');
								// test here was  removed  an option   
								$new[$count]['dpl_title'.$exp[1]] = (is_array($v_res) ? 
																		$this->quoteIdent ($v_res['official_title_diploma'])   : '');
								$new[$count]['dpl_inst'.$exp[1]] =  (is_array($v_res) ? 
																		$this->quoteIdent ( $v_res['institution'] ) : '');
								$new[$count]['dpl_awarding'.$exp[1]] = (is_array($v_res) ? 
																		$v_res['awarding_date'] : '');
								$new[$count]['dpl_issued'.$exp[1]] = (is_array($v_res) ? 
																		$v_res['diploma_date'] : '');
								$new[$count]['dpl_number'.$exp[1]] = (is_array($v_res) ? 
																		$v_res['credits1'] : '');
																		
								$new[$count]['dpl_obtained'.$exp[1]] = (is_array($v_res) ? 
																		$v_res['obtained_diploma'] : '');

																		
								if( $exp[1] == sizeof($name_field[$name_table[1]]) ) {
									$new[$count]['dpl_more'] = $this->dpl_more[$k]; 
								}
								
							} else {
								 $new[$count][$k_res] = $v_res;
							}
						}
					}
				}	
			$count++;
					
			if($count < $size) { $this->insertContainer($size, $iterator, $count); } 
			 
		}
			$iterator->next();	
	}
	
	$new = $this->isMissingKeysDiploma($new , 0, $key = 'dpl_'); 
	
	foreach($new as $k => $v ) {
		
		foreach($new[$k] as $key => $val) { 
			if(empty($key)) {
				unset($new[$k][$key]);continue;
			}
		}
	
		$columns = implode(", ",array_keys($new[$k]));
		$escaped_values = array_map(null, array_values($this->dbh->filter($new[$k])));
		foreach ($escaped_values as $k_id => $v_val) { 
			$escaped_values[$k_id] = "'".addslashes(trim($this->dbh->encodeToUtf8($this->dbh->filter($v_val))))."'";  
		}
		$values  = implode(", ", $escaped_values);
		$sql = "INSERT INTO extract () VALUES ($values)";
		$this->requestSQL($sql, ' >>>>> ERROR EXTRACT 365547 <<<<< ');
	}	
 }
 
 // if there isn't  an elements in array then it add the keys ...  
 public function isMissingKeysDiploma($arr, $i=0, $key='dpl_') {
	
	$name_table = self::getNameTables();
	$name_field = self::getNameFieldsExtract();
	
	$count = 1;
	$test = false;
	foreach($arr[$i] as $k => $v) {

		 if(substr($k, 0, 4) == $key) {
			$test = true;
		}
		if($count == count($arr[$i])) {
			if(!$test) {
				for( $j = 1; $j <= sizeof($name_field[$name_table[1]]); $j++ ) {
					$arr[$i]['dpl_id'.$j] = NULL; 
					$arr[$i]['dpl_level'.$j] = NULL;  
					$arr[$i]['dpl_title'.$j] = NULL; 
					$arr[$i]['dpl_inst'.$j] =  NULL; 
					$arr[$i]['dpl_awarding'.$j] = NULL; 
					$arr[$i]['dpl_issued'.$j] = NULL; 
					$arr[$i]['dpl_number'.$j] = NULL;
					$arr[$i]['dpl_obtained'.$j] = NULL; // add obtained 1 2 3 ... n
				}
				$arr[$i]['dpl_more'] = ' NON '; 
			}
			if(isset($arr[++$i]) ) {
				return $this->isMissingKeysDiploma($arr, $i, $key);
			}	
		}
		$count++;
	}
	return $arr;
	
 }
 
 public function fillTheVoid($set, $name_table, $n) {
 
	$r = array();
	$i = 0;
	do {
		$r[$set[$name_table]['fields'][$i]] = NULL;
		$i++;
	} while($i < $n) ;
		return $r;
 }
 
 public function getContentType($type, $id_user, $row, $index = 'type') {
	if(is_array( $this->arr_sup ) && sizeof($this->arr_sup) > 0) {
		foreach($this->arr_sup as $k => $v) {
			if($type == $this->arr_sup[$k][$index]) {
				if($id_user == $this->arr_sup[$k]['id_user'] ) {
					$r = $this->arr_sup[$k];
					unset($this->arr_sup[$k]);
					return $r;
				}
			} 
		}
		return null;
	} else {
		return null;
	}
 }

}

 



?>