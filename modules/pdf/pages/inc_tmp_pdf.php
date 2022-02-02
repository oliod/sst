<?php
 
 
include_once('../class_default.php');
 

if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');
include_once('../../../class/page.php');
include_once('../../../class/admin.php');
include_once('../../../class/main.php');
include_once('../../../class/connect_db.php');
include_once('../../../class/supervisor.php');
include_once('../../../class/extract_result.php');

$page = new PageSST();
$dbh = new ConnectDB();
$main = new Main();
$admin = new AdminAuthority( ); 
$supervisor = new Supervisor(); 
 
$txt = '';
  
if( isset($_GET['id']) ) {
	if( isset($_GET['test']) ) {
		if($dbh->isID($_GET['id'])) {
			switch($_GET['test']) {
				case'adm_sign':

					$id_user = ($dbh->isID($_GET['id']) ? $_GET['id'] : null );  
					if(is_null($id_user) ) { $txt .= ' ERROR PDF # 3254'; exit ; }
					
					$_SESSION['SST_GUID'] = $id_user;
					if(!$dbh->isIDUserExists()) {   $page->disconnectPage(); exit(); }
					
					$r[0]['id_user'] = $id_user;	
					 
					$extract = new ExtractResult();
					$data = $extract->setExtractResult($r, array(), 'SHOW LIST'); 
				
					if(is_array($data)) {
						$txt = dispalyData($data, $page, $main, $dbh, $r);
					}
				
				break;
				case'show_list':
					if(!isset($_SESSION['SST_CONNEXION'])) {  $page->disconnectPage(); exit(); }

					$id_user = ($dbh->isID($_GET['id']) ? $_GET['id'] : null );  
					if(is_null($id_user) ) { $txt .= ' ERROR PDF # 3254'; exit ; }

					$r[0]['id_user'] = $id_user;	
				
					$extract = new ExtractResult();
					$data = $extract->setExtractResult($r, array(), 'SHOW LIST'); 
					if(is_array($data)) {
						$txt = dispalyData($data, $page, $main, $dbh, $r);
					}
				
				break;
			
				case'adm_submit':
					if(!isset($_SESSION['SST_CONNEXION'])) {  $page->disconnectPage(); exit(); }
					$id_user = ($dbh->isID($_GET['id']) ? $_GET['id'] : null );  
					if(is_null($id_user) ) { $txt .= ' ERROR PDF # 3254'; exit ; }

					$r[0]['id_user'] = $id_user;		  
					$extract = new ExtractResult();
					$data = $extract->setExtractResult($r, array(), 'SHOW LIST'); 
			
					if(is_array($data)) {
						unset($data['SHOW_LIST']['confirmation_submit']);
						unset($data['SHOW_LIST']['confirmation_planning']);
						unset($data['SHOW_LIST']['private_defence_home']);
						unset($data['SHOW_LIST']['private_defence_jury']);
						unset($data['SHOW_LIST']['private_defence_status']);
						unset($data['SHOW_LIST']['public_defence_home']);
						unset($data['SHOW_LIST']['my_supervosory_panel']);
						unset($data['SHOW_LIST']['my_doctoral_training']);
						unset($data['SHOW_LIST']['my_additional_programme']);
						unset($data['SHOW_LIST']['my_cotutelle']);
						$txt = dispalyData($data, $page, $main, $dbh, $r);
					}	
				break; 
				case'private_defence_submit':
					$id_user = ($dbh->isID($_GET['id']) ? $_GET['id'] : null );  
					if(is_null($id_user) ) { $txt .= ' ERROR PDF # 3254'; exit ; }

					$r[0]['id_user'] = $id_user;		  
					$extract = new ExtractResult();
					$data = $extract->setExtractResult($r, array(), 'SHOW LIST');
				
					if(is_array($data)) {
						unset($data['SHOW_LIST']['public_defence_home']);
						unset($data['SHOW_LIST']['my_supervosory_panel']);
						unset($data['SHOW_LIST']['my_doctoral_training']);
						unset($data['SHOW_LIST']['my_additional_programme']);
						unset($data['SHOW_LIST']['my_cotutelle']);
						$txt = dispalyData($data, $page, $main, $dbh, $r);
					}
				break; 
			}
		} else {
			echo 'oups!!! ;) ';
			exit;
		}
		 
	} else { exit; }
} else { exit; }
/*
echo '<pre>';
print_r($txt);
echo '</pre>';
 */
$bookmark = '<bookmark content="Start of the Document" />';
$html = $bookmark.$txt; 

include('../mpdf/mpdf.php');

$mpdf=new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output();


 function dispalyData($data, $page, $main, $dbh, $r) {
	
	if( is_array($data) ) {
	$txt = "";
		if(isset($data['SHOW_LIST']) ) {
							 
			if(array_key_exists('registration', $data['SHOW_LIST'])) { //  
			 
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
							$page->showText('header_title_my_profile').'</h3>';
						 
				$phd = $GLOBALS['sst']['select_phd'][(int)$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'phd')];						
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_PhD_domain') . '</b></span> ' .
						$phd .'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_last_name')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'last_name' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_first_name')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'first_name' ).'<br>';	
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_mail')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'e-mail' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_institute')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'institution' ).'<br>';	
								
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_sciences')  . '</b></span> ';
						
				if(is_numeric( $main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'sciences' ) ) ) { 
					$txt .= $GLOBALS['sst']['select_sciences'][$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'sciences' )].'<br>';
				} else {
					$txt .= ' <br>';
				}		
						
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_reference_title')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'title' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_mobile')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'mobile' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_birthplace')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'birth_place' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_birth_date')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'birth_date' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_thesis_funding')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'registration', 0, 'thesis' ).'<br>';
						
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_institute') .' Name: </b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'institution', 'inst_name', 0 ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_institute') .' E-mail: </b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'institution', 'inst_mail', 0 ).'<br>';			
			} 
				
			if(array_key_exists('contact_address', $data['SHOW_LIST'])) {	// 
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
							$page->showText('header_title_my_profile_contact_address').'</h3>';
							
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_university')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'univ' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_street')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'street' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_box') . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'box_num' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_postcode')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'postal_code' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_city')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'city' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_country')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'country' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_contact_tel')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'contact_address', 0, 'tel' ).'<br>';									 
			}	
			
			if(array_key_exists('address_residence', $data['SHOW_LIST'])) {	 // 			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
							$page->showText('header_title_my_profile_residence_address').'</h3>';
				
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_street')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'street' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_box_number')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'box_num' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_postal_code')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'postal_code' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_city')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'city' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_country')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'country' ).'<br>';
				$txt .= '<span style="color:green"><b>'.$page->showText('my_profile_tel')  . '</b></span> ' .
						$main->isKeyExists($data['SHOW_LIST'], 'address_residence', 0, 'tel' ).'<br>';
			}				
			
			if(array_key_exists('diploma', $data['SHOW_LIST'])) {	
				if(is_array($diploma = $data['SHOW_LIST']['diploma'][0]))  { //    
					foreach($diploma as $diploma_k => $diploma_v ) {
					
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Admission - '.
									$GLOBALS['sst']['title']['t_diploma'].'</h3>';
						
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_diploma_level'). '</b></span> ' .
								$diploma[$diploma_k]['level_diploma'].'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_diploma_official_title'). '</b></span> ' .
								$diploma[$diploma_k]['official_title_diploma'].'<br>';	
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_institution'). '</b></span> ' .
								$diploma[$diploma_k]['institution'].'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_country'). '</b></span> ' .
								$diploma[$diploma_k]['country'].'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_awarding_date'). '</b></span> ' .
								$diploma[$diploma_k]['awarding_date'].'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_diploma_date'). '</b></span> ' .
								$diploma[$diploma_k]['diploma_date'].'<br>';		
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_obtained_for_diploma'). '</b></span> ' .
								$diploma[$diploma_k]['obtained_diploma'].'<br>';	
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_num_of_cr_years_for_diploma'). '</b></span> ' .
								$diploma[$diploma_k]['credits1'].'<br>';		
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_country'). '</b></span> ' .
								$diploma[$diploma_k]['credits2'].'<br>';		
						$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_ects_credits_years'). '</b></span> ' .  
								$diploma[$diploma_k]['credits3'].'<br>';		
									
						if(is_array($academic = $dbh->showYearAcademic($diploma[$diploma_k]['id_diploma'], $r[0]['id_user']))) {
						
							$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> '.
										$GLOBALS['sst']['title']['t_year'].'</h3>';
							
							foreach($academic as $academic_k => $academic_v ) { 
								$txt .= '<div style="margin:10px;">';
								
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_title_year'). '</b></span> ' . 
										$academic[$academic_k]['title_and_year'].'<br>';
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_awarding_date'). '</b></span> ' .
										$academic[$academic_k]['awarding_date'].'<br>';
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_diploma_date'). '</b></span> ' .
										$academic[$academic_k]['diploma_date'].'<br>'; 
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_degree_level'). '</b></span> ' .
										$academic[$academic_k]['degree_level'].'<br>';
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_squale_between'). '</b></span> ' .
										$academic[$academic_k]['score_min'].'<br>';
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_squale_between_and'). '</b></span> ' .
										$academic[$academic_k]['score_max'].'<br>';  
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_score'). '</b></span> ' .
										$academic[$academic_k]['obtained_year'].'<br>';
								$txt .= '<span style="color:green"><b>'.$page->showText('my_academic_cv_aca_institution'). '</b></span> ' .
										$academic[$academic_k]['institution'].'<br>';
								$txt .= '<span style="color:green"><b>'.'Date: '. '</b></span> ' .
										$main->settingDate($academic[$academic_k]['date_fixed']).'<br>';
								
								$txt .= '</div>';			 
							}			
						}		
					}
				}
			}	

			if(array_key_exists('admission', $data['SHOW_LIST'])) {  
			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Admission - '.
							$page->showText('header_title_admission_home').'</h3>';
			
				$type = (($main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'employment' ) == 'Admission') ? 'ADMISSION' : 'PRE-ADMISSION' ); 
			 
				$status = $dbh->getEachStatus($main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'id_user' ), $type, 'STR');
				
				$txt .= '<span style="color:green"><b>Type: ' . '</b></span> ' .
					$main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'employment' ).'<br>';
				$txt .= '<span style="color:green"><b>Text: ' . '</b></span> ' .
					$main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'text' ).'<br>';
				$txt .= '<span style="color:green"><b>State: ' . '</b></span> ' .
					$status.'<br>';
				$txt .= '<span style="color:green"><b>Date: ' . '</b></span> ' .
					$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'date' )).'<br>';	
				$txt .= '<span style="color:green"><b>Date pre-admission: ' . '</b></span> ' .
					$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'admission', 0, 'date_preadmission' )).'<br>';		
			}
			
			if(array_key_exists('admission_research_project', $data['SHOW_LIST'])) { 
			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Admission - '.
							$page->showText('header_title_admission_reseach_project').'</h3>'; //  
				
				$txt .= '<span style="color:green"><b>'.$page->showText('my_phd_admission_research_project_title') . '</b></span> ' .
					$main->isKeyExists($data['SHOW_LIST'], 'admission_research_project', 0, 'text' ).'<br>';
				$txt .= '<span style="color:green"><b>Date: ' . '</b></span> ' .
					$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'admission_research_project', 0, 'date' )).'<br>';	
			}
			
			if(array_key_exists('admission_additional_programme', $data['SHOW_LIST'])) { 
			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Admission - '.
							$page->showText('header_title_admission_additional_prog').'</h3>'; //
				
				if(is_array($admission_ap = $data['SHOW_LIST']['admission_additional_programme'][0]))  { //  
					$txt .= '<table border=0>';
					$txt .= '<tr>';
					$txt .= '<th>'.$page->showText('my_addition_programme_course_code').'</th>';  
					$txt .= '<th>'.$page->showText('my_addition_programme_name_course').'</th>';
					$txt .= '<th>'.$page->showText('my_addition_programme_number_ects').'</th>';
					$txt .= '</tr>';
					foreach($admission_ap as $admission_ap_k => $admission_ap_v ) {
						$style = (($admission_ap_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
						$txt .= '<tr '.$style.'>'; 
						$txt .= '<td>'.$admission_ap[$admission_ap_k]['course_code'].'</td>';
						$txt .= '<td>'.$admission_ap[$admission_ap_k]['name_course'].'</td>';
						$txt .= '<td>'.$admission_ap[$admission_ap_k]['ects'].'</td>';
						$txt .= '</tr>';
					}
					$txt .= '</table>';
				}
			}
			
			
			if(array_key_exists('admission_doctoral_training', $data['SHOW_LIST'])) { 
			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> 
							Admission - Doctoral training</h3>'; //
				
				if(is_array($admission_dt = $data['SHOW_LIST']['admission_doctoral_training'][0])) {  
					$txt .= '<table border=0>';
					$txt .= '<tr>';
					$txt .= '<th>Activities</th>';
					$txt .= '<th>Description</th>';  
					$txt .= '<th>Place</th>';
					$txt .= '<th>Acronym</th>';
					$txt .= '<th>Ects</th>';
					$txt .= '<th>Comment</th>'; 
					$txt .= '</tr>';
					foreach($admission_dt as $admission_dt_k => $admission_dt_v ) { 
						$style = (($admission_dt_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
						$txt .= '<tr '.$style.'>'; 
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['activities'].'</td>';
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['description'].'</td>';
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['place'].'</td>';
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['acronym'].'</td>';
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['ects'].'</td>';
						$txt .= '<td>'.$admission_dt[$admission_dt_k]['comment'].'</td>';
						$txt .= '</tr>';	
					}	
					$txt .= '</table>';
				}
			}
			
			
			if(array_key_exists('admission_supervisory_panel', $data['SHOW_LIST'])) {
			
				$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> 
								Admission - Supervisory panel </h3>'; //
			
				if(is_array($admission_sp = $data['SHOW_LIST']['admission_supervisory_panel'][0]))  {   
					$asp = $main->arrayMultisort($admission_sp, 'employment', SORT_ASC);
					
					$txt .= '<table border=0>';
					$txt .= '<tr>';
					$txt .= '<th>Type</th>';
					$txt .= '<th>Title</th>';  
					$txt .= '<th>Last Name</th>';
					$txt .= '<th>First Name</th>';
					$txt .= '<th>Institution</th>';
					$txt .= '<th>E-mail</th>';
					$txt .= '<th>State</th>';
					$txt .= '<th>Date</th>';  
					$txt .= '</tr>';
					foreach($asp as $asp_k => $asp_v ) { 
						$style = (($asp_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
						$txt .= '<tr '.$style.'>'; 
						$txt .= '<td>'.(
										$asp[$asp_k]['employment'] == 'Preadmission' ?
										$page->showText('header_title_admission_supervisory_panel_supervisor') : 
										$page->showText('header_title_admission_other_members_') 
										).
								'</td>';
									
						$txt .= '<td>'.  $GLOBALS['sst']['select_person'][$asp[$asp_k]['titel']].'</td>';
						$txt .= '<td>'.$asp[$asp_k]['lastname'].'</td>';
						$txt .= '<td>'.$asp[$asp_k]['firstname'].'</td>';
						$txt .= '<td>'.$asp[$asp_k]['institution'].'</td>';
						$txt .= '<td>'.$asp[$asp_k]['email'].'</td>';
						$txt .= '<td>'.$asp[$asp_k]['state'].'</td>';
						$txt .= '<td>'.$main->settingDate($asp[$asp_k]['sent_date']).'</td>';
						$txt .= '</tr>';
					}
					$txt .= '</table>';
				}   
				
				if(array_key_exists('admission_ucl', $data['SHOW_LIST'])) {
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Admission - '.
								$page->showText('header_title_admission_registration').'</h3>'; 
					
					$txt .= '<span style="color:green"><b>File: ' . ' </b></span>' .
						$main->isKeyExists($data['SHOW_LIST'], 'admission_ucl', 'content', 0 ).'<br>';
				}  
				
				if(array_key_exists('confirmation_submit', $data['SHOW_LIST'])) {  
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Confirmation - '.
								$page->showText('header_title_confirmation_result').'</h3>'; //
					
					$txt .= '<span style="color:green"><b>'.$page->showText('my_phd_confirmation_result_date_confirm'). ' </b></span>' .   
						$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'confirmation_submit', 0, 'date_of_confirm' )).'<br>';
						 
					$state = $main->isKeyExists($data['SHOW_LIST'], 'confirmation_submit', 0, 'select_confirm_state' );
					$txt .= '<span style="color:green"><b>'.$page->showText('my_phd_confirmation_status') . ' </b></span>';
					$txt .= ((!is_null($state) && $state > 0  ) ? $GLOBALS['sst']['select_confirm_state'][$state] : '').'<br>';
						
						
					$txt .= '<span style="color:green"><b> Date submitted: ' . ' </b></span>' .
						$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'confirmation_submit', 0, 'date_submitted' )).'<br>';	
				}
				
				if(array_key_exists('confirmation_planning', $data['SHOW_LIST'])) {  
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">  '.
								$page->showText('header_title_confirmation_status').'</h3>'; 
					
					if(array_key_exists('deadline', $data['SHOW_LIST']['confirmation_planning'])) { 
						$txt .= '<span style="color:green"><b> Deadline: ' . ' </b></span>' .
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['confirmation_planning'], 'deadline', 0, 'deadline' )).'<br>';
						$txt .= '<span style="color:green"><b> Text: ' . ' </b></span>' .
							$main->isKeyExists($data['SHOW_LIST']['confirmation_planning'], 'deadline', 0, 'text' ).'<br>';
					}
					if(array_key_exists('state', $data['SHOW_LIST']['confirmation_planning'])) {
					
						$txt .= '<span style="color:green"><b> State: </b></span>';
						$state = $main->isKeyExists($data['SHOW_LIST']['confirmation_planning'], 'state', 0, 'status' ); 
						$res = ((!is_null($state) ) ? $state : '') ;
						if($res == 0 ) {
							$txt .= ' Cancelled <br>';
						} else if($res == 1) {
							$txt .= ' Submitted  <br>';
						} else if($res == 2) {
							$txt .= ' Accepted <br>';
						} else {
							$txt .= '<br>';
						}
						
						$txt .= '<span style="color:green"><b> Date submitted: ' . ' </b></span>' .
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['confirmation_planning'], 'state', 0, 'date_sended' )).'<br>';	
						$txt .= '<span style="color:green"><b> Date accepted: ' . ' </b></span>' .
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['confirmation_planning'], 'state', 0, 'date_accepted' )).'<br>';	
					
					}
				}
				
				if(array_key_exists('private_defence_home', $data['SHOW_LIST'])) {    
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Private defence -  '.
								$page->showText('header_title_private_defence_home').'</h3>'; 
					
					$txt .= '<span style="color:green"><b>'.$page->showText('private_defence_home_title'). ' </b></span>' .
						$main->isKeyExists($data['SHOW_LIST'], 'private_defence_home', 0, 'thesis1' ).'<br>';
					$txt .= '<span style="color:green"><b>'.$page->showText('private_defence_home_place'). ' </b></span>' .
						$main->isKeyExists($data['SHOW_LIST'], 'private_defence_home', 0, 'thesis2' ).'<br>';
					$txt .= '<span style="color:green"><b>'.$page->showText('private_defence_home_date') . ' </b></span>' .
						$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'private_defence_home', 0, 'date' )).'<br>';	
				}
				
				if(array_key_exists('private_defence_jury', $data['SHOW_LIST'])) { 
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;"> Private defence -  '.
								$page->showText('header_title_public_defence_jury_members').'</h3>'; 
					
					if(is_array($private_defence_jury = $data['SHOW_LIST']['private_defence_jury'][0])) {  
						$txt .= '<table border=0>';
						$txt .= '<tr>';
						$txt .= '<th>Title</th>';
						$txt .= '<th>Last Name</th>';  
						$txt .= '<th>First Name</th>';
						$txt .= '<th>Institution</th>';
						$txt .= '<th>E-mail</th>';
						$txt .= '<th>Role</th>';
						$txt .= '<th>Date</th>';  
						$txt .= '</tr>';
						foreach($private_defence_jury as $private_defence_jury_k => $private_defence_jury_v ) { 
							$style = (($private_defence_jury_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
							$txt .= '<tr '.$style.'>'; 
							$txt .= '<td>'.$GLOBALS['sst']['select_person'][$private_defence_jury[$private_defence_jury_k]['titel']].'</td>';
							$txt .= '<td>'.$private_defence_jury[$private_defence_jury_k]['lastname'].'</td>';
							$txt .= '<td>'.$private_defence_jury[$private_defence_jury_k]['firstname'].'</td>';
							$txt .= '<td>'.$private_defence_jury[$private_defence_jury_k]['institution'].'</td>';
							$txt .= '<td>'.$private_defence_jury[$private_defence_jury_k]['email'].'</td>';
							$txt .= '<td>'.$main->getNameJury($private_defence_jury[$private_defence_jury_k]) .'</td>';
							$txt .= '<td>'.$main->settingDate($private_defence_jury[$private_defence_jury_k]['date']).'</td>';
							$txt .= '</tr>';
						}
					$txt .= '</table>';
					}
				}
				
				if(array_key_exists('private_defence_status', $data['SHOW_LIST'])) { 
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
								$page->showText('header_title_private_defence_status').'</h3>'; 
					$txt .= '<span style="color:green"><b>'.$page->showText('private_defance_submit_select_user').' </b></span>';
					
					$state = $main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'private_defence_status', 0, 'state' ));
					$txt .= (!is_null($state) ? $GLOBALS['sst']['select_private_defence_satate'][$state] : '' ).'<br>';
					$txt .= '<span style="color:green"><b> Date:  </b></span>' . 
						$main->settingDate($main->isKeyExists($data['SHOW_LIST'], 'private_defence_status', 0, 'date_passed' )).'<br>';	
				}
				
				if(array_key_exists('public_defence_home', $data['SHOW_LIST'])) {
					if(array_key_exists('public_practical', $data['SHOW_LIST']['public_defence_home'])) {
						 
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
									$page->showText('header_title_public_defence_form').'</h3>';

						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_these') .' </b></span>'. 
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'title_of_thesis' )).'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_date') .' </b></span>'. 
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'date' )).'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_local_upstaires') .' </b></span>'.
							$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'local' ).'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_thesis_time') .' </b></span>'.  
							$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'thesis_time' ).'<br>';
						$txt .= '<span style="color: navy;font-weight: bold;">'.$page->showText('public_defence_title').'</span><br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_thesis_place') .' </b></span>'.
							$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'thesis_place' ).'<br>';
						$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_jury_date_time') .' </b></span>'.
							$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_practical', 0, 'j_date_time' ).'<br>';	
						
					}
					if(array_key_exists('public_details', $data['SHOW_LIST']['public_defence_home'])) {
						if(AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) {
						
							$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
										$page->showText('header_title_public_defence_thesis').'</h3>';
							$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_admin_thesis_num') .' </b></span>'. 
								$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_details', 0, 'thesis_num' ).'<br>';
							$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_admin_money') .' </b></span>'.
								$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_details', 0, 'money' ).'<br>';
							$txt .= '<span style="color:green"><b>'.$page->showText('public_defence_admin_auto_diff') .' </b></span>'. 
								$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_details', 0, 'check' ).'<br>';	
							$txt .= '<span style="color:green"><b> Link: </b></span>' . 
								$main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_details', 0, 'hypertext' ).'<br>';
						}
					}
					if(array_key_exists('public_state', $data['SHOW_LIST']['public_defence_home'])) {
						 
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
									$page->showText('header_title_public_defence_status').'</h3>'; 
						
						$txt .= '<span style="color:green"><b> State: </b></span>';
						$state = $main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_state', 0, 'state' );
						$txt .= ((!is_null($state)) ? $GLOBALS['sst']['select_public_defence_status'][$state] : '') .'<br>';
								
						$txt .= '<span style="color:green"><b> Date: </b></span>' . 
							$main->settingDate($main->isKeyExists($data['SHOW_LIST']['public_defence_home'], 'public_state', 0, 'date_submitted' )).'<br>';		
					}
				}
				
				if(array_key_exists('my_supervosory_panel', $data['SHOW_LIST'])) { 
					if(is_array($my_sp = $data['SHOW_LIST']['my_supervosory_panel'][0]) ) {
					
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">
									My Supervisory panel</h3>'; 
						
						$asp = $main->arrayMultisort($my_sp, 'employment', SORT_ASC);
					
						$txt .= '<table border=0>';
						$txt .= '<tr>';
						$txt .= '<th>Type</th>';
						$txt .= '<th>Title</th>';
						$txt .= '<th>Last Name</th>';  
						$txt .= '<th>First Name</th>';
						$txt .= '<th>Institution</th>';
						$txt .= '<th>E-mail</th>';
						$txt .= '<th>Date</th>';  
						$txt .= '</tr>';
						
						foreach($my_sp as $my_sp_k => $my_sp_v) {
							
							$style = (($my_sp_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
							$txt .= '<tr '.$style.'>'; 
							$txt .= '<td>'.(
										$my_sp[$my_sp_k]['employment'] == 'Preadmission' ?
										$page->showText('header_title_my_supervisory_panel_supervisor') : 
										$page->showText('header_title_my_supervisory_panel_member') 
										).
								'</td>';
									
							$txt .= '<td>'.  $GLOBALS['sst']['select_person'][$my_sp[$my_sp_k]['titel']].'</td>';
							$txt .= '<td>'.$my_sp[$my_sp_k]['lastname'].'</td>';
							$txt .= '<td>'.$my_sp[$my_sp_k]['firstname'].'</td>';
							$txt .= '<td>'.$my_sp[$my_sp_k]['institution'].'</td>';
							$txt .= '<td>'.$my_sp[$my_sp_k]['email'].'</td>';

							$txt .= '<td>'.$main->settingDate($my_sp[$my_sp_k]['sent_date']).'</td>';
							$txt .= '</tr>';
						}
					$txt .= '</table>';
					}
				}
				
				if(array_key_exists('my_doctoral_training', $data['SHOW_LIST'])) {  
				
					$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
								$page->showText('header_title_my_doctoral_training_status').'</h3>';
					
					$txt .= $dbh->getEachStatus($r[0]['id_user'], 'DOCTORAL TRAINING');
				 
					$activities = $dbh->activitiesDoctoralTraining($r[0]['id_user'], 3) ; 
					
					$txt .= '<span style="color:green"><b>'.$page->showText('my_doctoral_training_status_formation').'</b></span>';
					$txt .= $activities['training'].'<br>';

					$txt .= '<span style="color:green"><b>'.$page->showText('my_doctoral_training_status_communication').'</b></span>';
					$txt .= $activities['communication'].'<br>';

					$txt .= '<span style="color:green"><b>'.$page->showText('my_doctoral_training_status_encad').'</b></span>';
					$txt .= $activities['teaching'].'<br>';
					
					$txt .= '<span style="color:green"><b>'.$page->showText('my_doctoral_training_status_other').'</b></span>';
					$txt .= $activities['other'].'<br>';
					
					$txt .= '<span style="color:green"><b>'.$page->showText('my_doctoral_training_status_total').'</b></span>';
					$txt .= $activities['total'].'<br>';
				}
				
				if(array_key_exists('my_additional_programme', $data['SHOW_LIST'])) { 
					if(is_array($my_ap = $data['SHOW_LIST']['my_additional_programme'][0]) ) {
					
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
									$page->showText('header_title_my_additional_prog').'</h3>';
					
						$txt .= '<table border=0>';
						$txt .= '<tr>';
						$txt .= '<th>'.$page->showText('my_addition_programme_course_code').'</th>';  
						$txt .= '<th>'.$page->showText('my_addition_programme_name_course').'</th>';
						$txt .= '<th>'.$page->showText('my_addition_programme_number_ects').'</th>';
						$txt .= '</tr>';
						
						foreach($my_ap as $my_ap_k => $my_ap_v) {
							
							$style = (($my_ap_k % 2 == 0) ? ' style="background:#DFDDDD;" ' : ' style="background:#D2CFCF;" ' );
							$txt .= '<tr '.$style.'>'; 
							$txt .= '<td>'.$my_ap[$my_ap_k]['course_code'].'</td>';
							$txt .= '<td>'.$my_ap[$my_ap_k]['name_course'].'</td>';
							$txt .= '<td>'.$my_ap[$my_ap_k]['ects'].'</td>';
							$txt .= '</tr>';
						}
						$txt .= '</table>';
					}
				}
				
				if(array_key_exists('my_cotutelle', $data['SHOW_LIST'])) { 
					if(is_array($data['SHOW_LIST']['my_cotutelle']['file']) ) {
						$txt .= '<h3 style="background-color: #05435c; color:#fff; font-size: 14px; height: 20px; margin: 5px 0 0; padding: 7px;">'.
									$page->showText('header_title_my_cotutelle').'</h3>';
						$txt .= '<span style="color:green"><b> File: </b></span>' .$data['SHOW_LIST']['my_cotutelle']['file'][0].'<br>';						
					}
				}
			}
		}
		
		 
		return '<div style="margin:10px;"><div><img src="../../../img/bandeau.jpg" border="0"> </div>'.$txt.'</div>';
	}
 }

?>