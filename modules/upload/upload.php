<?php

if(!file_exists('inc.php')) { die("ERROR REQ ULOAD FILE # 52525"); } else { include_once('inc.php'); }

// A list of permitted file extensions
$allowed = array('pdf');
$sender ='';

if(!isset($_POST['upluri'] ))  {  print '{"status":"error", "key":324}'; exit; }

$dni = $main->delineateNewId($_POST['upluri']);

if(isset($dni['option']) && isset($dni['folder']) ) {

	$folder = $dbh->checkFolderInBD();
	
	switch($dni['option']) {
		
		case'diploma':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_DIPLOMA_SIMPLE.$folder['dir'].'/'.$dni['folder']);
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		case'academic':

			$dir = $main->isDirectoryExists(
								DIR_FOLDER_DIPLOMA_SIMPLE.$dbh->getPathUpload(
																		$dni['folder'],
																		'academic',
																		ConnectDB::isSession()
																)
							);
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		case'research_project':  
			  
			$dir = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_RESEARCH_SIMPLE.$folder['dir']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
				
		break;
		case'adm_signatures': 
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;		
		case'ucl_reg':
			 
			$dir = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_UCL_REG_SIMPLE.$folder['dir']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
	 
		break;	
		case'conf_planning':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_PLANNING_SIMPLE.$folder['dir']);  
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
	
		break;
		case'conf_results_doctoral':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_RESULTS_DOCTORAL_SIMPLE.$folder['dir']);  
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
				
		break;
		case'conf_results_supervisory':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_CONFIRMATION_RESULTS_SUPERVISORY_SIMPLE.$folder['dir']);  
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}	
			
		break;
		case'private_signatures':
			 
			$dir = $main->isDirectoryExists(DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}	
				
				
		break;
		case'private_president':
			  
			$dir = $main->isDirectoryExists(DIR_FOLDER_ADMISSION_SIGNATURES_PRESIDENT_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
	
		break;	
		case'public_defence_summery':
			
			$dir = $main->isDirectoryExists(DIR_FOLDER_PUBLIC_DEFENCE_SUMMERY_SIMPLE.$folder['dir']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			} 
	
		break;
		case'public_defence_photo':
				  
			$dir = $main->isDirectoryExists(DIR_FOLDER_PUBLIC_DEFENCE_PHOTO_SIMPLE.$folder['dir']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			} 	

		break;
		case'my_doc_training_conferences':
				 
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
				
		break;
		case'my_doc_training_list':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_LIST_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		case'my_doc_training_journal_papers':
			
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_JOURNAL_PAPERS_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}	 
				
		break;
		case'my_doc_training_courses':
			
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_DOCTORAL_TRAINING_COURSES_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
					
		break;
		case'my_additional_programme':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_ADDITIONAL_PROGRAMME_SIMPLE.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		case'cotutelle_opening_application':
	
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_OPENING_SIMPLE.$folder['dir']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		case'cotutelle_signed_agreement':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE.$folder['dir']);
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		
		case'my_annual_reports':
		
			$dir = $main->isDirectoryExists(DIR_FOLDER_MY_ANNUAL_REPORTS.$dni['folder']); 
			if(!is_dir($dir) ) {
				print '{"status":"error", "key":300, "name":"null"}';
				exit;
			}
			
		break;
		
		
		
	}
} else {
	print '{"status":"error", "key":323, "name":"null"}';
	exit;
}

$date = gmdate(DATE_RFC1123);

if(!isset($dir)) { print '{"status":"error", "key":322, "name":"null"}'; exit; }

if((isset($_FILES['upl'])) && ($_FILES['upl']['error'] == 0)) {

	$file_name = $_FILES['upl']['name'];
	$file_size = $_FILES['upl']['size'];
	$file_tmp  = $_FILES['upl']['tmp_name'];
	$file_err  = $_FILES['upl']['error'];
	$file_type = $_FILES['upl']['type'];
	
	$extension = pathinfo($file_name , PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)) {
		unlink($file_tmp);
		print '{"status":"error", "key":325, "name": "'.$file_name.'"}';
		exit;
	}
	
	if($file_size >  FILE_SIZE_LIMIT) { 
		print '{"status":"error", "key":319, "name": "'.$file_name.'"}';		 
		unlink($file_tmp);
		exit;
	}

	$file_name = $main->random().$dbh->cleanCarSpec($file_name);
	
	$dir = str_replace('//', '/', $dir); 
	
	if(strlen($dir) > 150) {  
		print '{"status":"error", "key":230, "name": "'.$file_name.'"}';		 
		unlink($file_tmp);
		exit;
	}
	
	if(strlen($dir.'/'.$file_name) > 170) { 
		$file_name = $main->random().$main->idGenerator() . '.' . strtolower($extension);  
	}
	
	if(move_uploaded_file($file_tmp,  $dir.'/'.$file_name)) {
	
		switch($dni['option']) { 
			case'diploma':
			
				$r['id_user'] = ConnectDB::isSession();
				$r['iden']    = $dni['folder']; // dir_diploma 
				$r['title']   = $file_name;
				$r['byte']    = $file_size;
				
				$dbh->insertUploadedDiploma($r);		
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 1),
						'get',
						'user',
						' DIPLOMA HAS BEEN UPLOADED '
				);
			
			break;
			case'academic':
			
				$r['id_user'] = ConnectDB::isSession();
				$r['iden']    = $dni['folder']; // id_year_academic
				$r['title']   = $file_name;
				$r['byte']    = $file_size;

				$dbh->insertUploadedYear($r);
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 1), 
						'get',
						'user',
						' YEAR ACADEMIC HAS BEEN UPLOADED '
				);
			
			break;
			case'research_project':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 0), 
						$page->getKeysInArray($page->menu_adm->addminssionMenu(), 1),
											'user',
											$page->showText('my_phd_admission_research_project_research_project').' HAS BEEN UPLOADED '   
				);

			break;
			case'adm_signatures';
				
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 0), 
						$page->getKeysInArray($page->menu_adm->addminssionMenu(), 5),
								'user',
								' SIGNATURE HAS BEEN UPLOADED '   
				);
					
				if(is_array($data = $dbh->admissionSupervisoryPanelSelectNotSession(ConnectDB::isSession(), null, $dni['folder']))) {
					$r['id_user'] = ConnectDB::isSession();
					$r['id'] = $data['id_adm_supervisory_panel'];
					$r['state'] = '3'; // folder uploaded 
					$r['sent'] = '1';
					$dbh->admissionSupervisoryPanelUpdateNotSession($r);  
				}
				
			break;
			case'ucl_reg':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 0), 
						$page->getKeysInArray($page->menu_adm->addminssionMenu(), 7),
								'user',
								$page->showText('my_phd_admission_ucl_reg').' HAS BEEN UPLOADED '   
				);
				
			break;
			case'conf_planning':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 1), 
						$page->getKeysInArray($page->menu_conf->confirmationMenu(), 1),
								'user',
								$page->showText('my_phd_confirmation_planning_upload').' HAS BEEN UPLOADED '   
				);
				
			break;
			case'conf_results_doctoral':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 1), 
						$page->getKeysInArray($page->menu_conf->confirmationMenu(), 2),
								'user', 
								$page->showText('my_phd_confirmation_result_doctoral_report').' HAS BEEN UPLOADED '   
				);
				
			break;
			case'conf_results_supervisory':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 1), 
						$page->getKeysInArray($page->menu_conf->confirmationMenu(), 2),
								'user', 
								$page->showText('my_phd_confirmation_result_supervisory_panel_report').' HAS BEEN UPLOADED '   
				);
				
			break;
			case'private_signatures':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 2), 
						$page->getKeysInArray($page->menu_private_defence->privateDefenceMenu(), 2),
								'user', 
								' PRIVATE DEFENCE SIGNATURES HAS BEEN UPLOADED '   
				);
				
				if(is_array($data = $dbh->privateSupervisoryPanelSelectNotSession(ConnectDB::isSession(), null, $dni['folder']))) {
					$r['id_user'] = ConnectDB::isSession();
					$r['id'] = $data['id_my_supervisory_panel'];
					$r['state'] = '3'; // folder uploaded 
					$r['sent'] = '1';
					$dbh->privateSupervisoryPanelUpdateNotSession($r);  
				}

			break;
			case'private_president':

				if( is_array($data = $dbh->instituteSelectSelected(ConnectDB::isSession())) ) {
		 
					$i = 0;
					foreach($r = $dbh->instituteSelect() as $k => $v) {  
						if($r[$i]['id_institute'] == $data['id_institute']) {
							$r['mail'] = $r[$i]['mail'];  
							$r['state'] = '3'; // folder uploaded 
							$r['sent'] = '1';
							$r['user'] = ConnectDB::isSession();
						
							$dbh->instituteUpdateSelected(ConnectDB::isSession(), $r);  
							$visited->doVisitedLeftMenu(
										$page->getKeysInArray($page->getArrayIndexInMyPHD(), 2), 
										$page->getKeysInArray($page->menu_private_defence->privateDefenceMenu(), 2), 
												'user', 
												'PRESIDENT OF INSTITUTE HAS BEEN UPLOADED'   
							);
							break;
						}
					$i++;	
					} 
				}

			break;
			case'public_defence_summery':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 3), 
						'get',
						'user',
						$page->showText('public_defence_sammery').' HAS BEEN UPLOADED '
				);
				
			break;
			case'public_defence_photo':
			
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($page->getArrayIndexInMyPHD(), 3), 
						'get',
						'user',
						$page->showText('public_defence_photo').' HAS BEEN UPLOADED '
				);

			break;
			case'my_doc_training_conferences':
				 
				$visited->doVisitedLeftMenu(  
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 5), 
						$page->getKeysInArray($page->doc_training->docTrainingMenu(), 1),
								'user', 
								'CONFERENCES HAS BEEN UPLOADED '   
				);
				
			break;	
			case'my_doc_training_list':
			
				$visited->doVisitedLeftMenu(  
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 5), 
						$page->getKeysInArray($page->doc_training->docTrainingMenu(), 1),
								'user', 
								'LIST HAS BEEN UPLOADED '   
				);

			break;
			case'my_doc_training_journal_papers':
			
				$visited->doVisitedLeftMenu(  
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 5), 
						$page->getKeysInArray($page->doc_training->docTrainingMenu(), 2),
								'user', 
								'JOURNAL PAPERS HAS BEEN UPLOADED '   
				);

			break;
			case'my_doc_training_courses':
			
				$visited->doVisitedLeftMenu(  
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 5), 
						$page->getKeysInArray($page->doc_training->docTrainingMenu(), 3),
								'user', 
								'COURSE HAS BEEN UPLOADED '   
				);
					
			break;
			case'my_additional_programme':
			
				$t = $page->showText('header_title_my_additional_prog');
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 6),
							'get',
							'user',
							$t.' HAS BEEN UPLOADED '
				);
				
				$r['id_user'] = ConnectDB::isSession();
				$main->sendMailFromSSTOffice('MY_ADDITIONAL_PROGRAMME_UPLOADED', $r, null);
				
			break;
			case'cotutelle_opening_application':
			
				$t = $page->showText('my_cotutelle_opening_application');
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 7),
							'get',
							'user',
							$t.' HAS BEEN UPLOADED '
				);
				
			break;
			case'cotutelle_signed_agreement':
			
				$t = $page->showText('my_cotutelle_upload');
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 7),
							'get',
							'user',
							$t.' HAS BEEN UPLOADED '
				);
				
			break;
			
			case'my_annual_reports':
			
				$t = 'Annual Reports';
				$visited->doVisitedLeftMenu(
						$page->getKeysInArray($GLOBALS['sst']['button_left'], 9),
							'get',
							'user',
							$t.' HAS BEEN UPLOADED '
				);
				
				 
				
				$r = $dbh->myAnnualReportsSelect(null, ConnectDB::isSession(), $dni['folder']);
				
				if( is_array($r) ) {

					$arr[0] = $r[0]['id_my_annual_reports'];
					$arr[1] = $r[0]['reports'];
					
					$dbh->myAnnualReportsUpdate($arr, 'DATE REPORTS');
					
				}
	
			break;
			
		}
		
		print '{"status":"success"}';
		exit;
	}
	unlink($file_tmp);
}
print '{"status":"error", "key":326, "name": ""}';
exit;

