<!-- The main CSS file -->
<?php
/*
if(!AdminAuthority::isSessionAdminSudo()) {
	echo ' Please try later ...';
	exit ;
}

 
 $auth_upload = $dbh->getEachStatus(ConnectDB::isSession(), 'ADMISSION','NUM' ); 
 
 $match =  $dbh->iconStatusSubmitted(1, ConnectDB::isSession(), 'Preadmission');
 if (preg_match("/(SUBMITTED|ACCEPTED|REJECT)/i", $match['action'])) {
	echo 'PRE-ADMISSION NOT SHOW BROWSE';
 }
 
 
 $match =  $dbh->iconStatusSubmitted(2, ConnectDB::isSession(), 'Confirmation');
 
  
 if (preg_match("/(SUBMITTED|ACCEPTED|REJECT)/i", $match['action'])) {
	echo 'ADMISSION NOT SHOW BROWSE';
 }
 
 
 
 echo'<pre>';
	print_r($match);
	print_r($auth_upload);
 echo'</pre>';
 */
 
$obj = null;
 
if(!class_exists('Main') ) { print('ERROR FORM UPLOAD # 645611'); exit; }
 
$prs = parse_url(Main::currentPageURL());
 
if(isset($prs['query'])) {
  
	$dni = $main->delineateNewId($prs['query']);
 
	if(isset($dni['option'])) {
		 
		$query = $prs['query'];
		$folder = $dbh->checkFolderInBD();	
		
		switch($dni['option']) {
			case 'diploma':
			
				$test = '{"name":"diploma", "id":"'.$dni['folder'].'"}';
				$obj = json_decode($test);
				
				$title = ' Diploma ';
				
				$dir = $dni['folder'];
				$path = DIR_FOLDER_DIPLOMA_SIMPLE.$folder['dir'].'/';

				$hjs = $main->imgShowHelp('upload_my_aacademic_cv_academic', 'DIALOG');
				
				$act = $dbh->checkingPermission('ADMISSION', 1);	
				
			break;
			case'academic':
				 
				$test = '{"name":"academic", "id":"'.$dni['folder'].'"}';
				$obj = json_decode($test);
				
				$data_year = $dbh->getDataYear($dni['folder']);
				 
				$title =  $data_year['title_and_year'];
				 
				$data = $dbh->getDataDiploma($data_year['id_diploma']);
				$dir =  $data['dir_year_academic'];
				$path = DIR_FOLDER_DIPLOMA_SIMPLE.$folder['dir'].'/'.$data['dir'].'/';
					  
				$hjs = $main->imgShowHelp('upload_my_aacademic_cv_academic', 'DIALOG');
				
				$act = $dbh->checkingPermission('ADMISSION', 1);	

			break;
			case'research_project':  
			
				$title = $page->showText('my_phd_admission_research_project_research_project');
				
				$dir = $folder['dir'];
				$path = DIR_FOLDER_ADMISSION_RESEARCH_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_adm_research_project', 'DIALOG');
				$act = $dbh->checkingPermission('ADMISSION', 3);
				
			break;
			case'adm_signatures';
			
				$title = 'Signatures';
				
				$dir = $dni['folder'];
				$path = DIR_FOLDER_ADMISSION_SIGNATURES_SIMPLE; 
				
				$hjs = $main->imgShowHelp('upload_my_phd_adm_signatures', 'DIALOG');
				
				$act = $dbh->checkingPermission('ADMISSION', 3);
				  
			break;
			case'ucl_reg':
			
				$title = $page->showText('header_title_admission_registration');
				
				$dir = $folder['dir'];
				$path = DIR_FOLDER_ADMISSION_UCL_REG_SIMPLE; 
				
				$hjs = $main->imgShowHelp('upload_my_phd_adm_ucl_reg', 'DIALOG');
				
				$act = $dbh->checkingPermission('ADMISSION', 3);
				
			break;
			case'conf_planning':
				 
				$title = $page->showText('my_phd_confirmation_planning_upload');
				
				$dir = $folder['dir'];
				$path = DIR_FOLDER_CONFIRMATION_PLANNING_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_conf_planning', 'DIALOG');
				$act = ($main->permission(4)) ; 
				
			break;
			case'conf_results_doctoral':
			
				$title = $page->showText('my_phd_confirmation_result_doctoral_report');
				
				$dir = $folder['dir'];
				$path = DIR_FOLDER_CONFIRMATION_RESULTS_DOCTORAL_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_conf_results_doctoral', 'DIALOG');
				$act = ($main->permission(4)) ; 
			
			break;
			case'conf_results_supervisory':
			
				$title = $page->showText('my_phd_confirmation_result_supervisory_panel_report');
				
				$dir = $folder['dir'];
				$path = DIR_FOLDER_CONFIRMATION_RESULTS_SUPERVISORY_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_conf_results_supervisory', 'DIALOG');
				$act = ($main->permission(4)) ; 
			
			break;
			case'private_signatures':
			
				$title = 'Signatures';  
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_PRIVATE_SIGNATURES_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_private_signatures', 'DIALOG');
				$act = ($main->permission(5)) ;  
				
			break;
			case'private_president':
			
				$title = 'President of your Institute';
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_ADMISSION_SIGNATURES_PRESIDENT_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_private_president', 'DIALOG');
				$act = ($main->permission(5)) ;
				
			break;
			case'public_defence_summery':
			
				$title = $page->showText('public_defence_sammery');
				
				$dir = $folder['dir'];
				$path =  DIR_FOLDER_PUBLIC_DEFENCE_SUMMERY_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_public_defence_summeries', 'DIALOG');
				$act = ($main->permission(6)) ;
				
			break;
			case'public_defence_photo':
			
				$title = $page->showText('public_defence_photo');
				
				$dir = $folder['dir'];
				$path =  DIR_FOLDER_PUBLIC_DEFENCE_PHOTO_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_phd_public_defence_photo', 'DIALOG');
				$act = ($main->permission(6)) ;
				
			break;
			case'my_doc_training_conferences':
			
				$title = 'Conferences';
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_doc_training_conferences', 'DIALOG');
				$act = ($main->permission(8)) ;
				
			break;
			case'my_doc_training_list':
			
				$title = 'Communications';
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_MY_DOCTORAL_TRAINING_CONF_LIST_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_doc_training_conferences_list', 'DIALOG');
				$act = ($main->permission(8)) ;
				
			break;
			case'my_doc_training_journal_papers':
			
				$title = 'Journal papers';
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_MY_DOCTORAL_TRAINING_JOURNAL_PAPERS_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_doc_training_journal_papers', 'DIALOG');
				$act = ($main->permission(8)) ;
				
			break;
			case'my_doc_training_courses':
			
				$title = 'Course';
				
				$dir = $dni['folder'];
				$path =  DIR_FOLDER_MY_DOCTORAL_TRAINING_COURSES_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_doc_training_courses', 'DIALOG');
				$act = ($main->permission(8)) ;
					
			break;
			case'my_additional_programme':
				
				$title = $page->showText('header_title_my_additional_prog');
				
				$dir = $dni['folder'];
				$path = DIR_FOLDER_MY_ADDITIONAL_PROGRAMME_SIMPLE;  
				
				$hjs = $main->imgShowHelp('upload_my_additional_programme', 'DIALOG');
				$act = ($main->permission(8)) ;
				
			break;
			case'cotutelle_opening_application':
				 
				$title = $page->showText('my_cotutelle_opening_application');

				$dir = $folder['dir'];
				$path = DIR_FOLDER_MY_COTUTELLE_OPENING_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_cotutelle_opening_application', 'DIALOG');
				$act =  $main->permission(10);
				 
			break;
			case'cotutelle_signed_agreement':
			
				$title = $page->showText('my_cotutelle_upload');

				$dir = $folder['dir'];
				$path = DIR_FOLDER_MY_COTUTELLE_SIGNED_SIMPLE;
				
				$hjs = $main->imgShowHelp('upload_my_cotutelle_signed_agreement_pdf', 'DIALOG');
				$act = $main->permission(10);
				
			break;
			
			
			case'my_annual_reports':
				
				$title = $page->showText('header_title_annual_raports');
				
				$dir = $dni['folder'];
				$path = DIR_FOLDER_MY_ANNUAL_REPORTS;  
				
				$hjs = $main->imgShowHelp('upload_my_annual_reports', 'DIALOG');
				$act = ($main->permission(12)) ;
				
			break;
			
				
		}
		
	} else {
	
		print('ERROR FORM UPLOAD # 645686'); exit; 
		 
	}
		
} else {
	
	print('ERROR FORM UPLOAD # 64476576'); exit; 
	
}

if((!isset($query)) || (!isset($path)) || (!isset($dir)) ) { print('ERROR FORM UPLOAD # 786574'); exit; }

if(!$main->isDirectoryExists($path.$dir)) { print('ERROR FORM UPLOAD # 78656544'); exit; } 

?>

<link rel="stylesheet" type="text/css" href="css/uploaded.css" /> 	
<form id="upload" method="post" action="modules/upload/upload.php" enctype="multipart/form-data">
	<div class="uphdr"> 
		<span> 
			<?php print(isset($hjs) ? $hjs : '' ); ?> 
			<?php print($page->showText('header_title_upload') ); ?> 
			<?php print(isset($title) ? $title : '' ); ?>
			 
		</span> 
	</div>
	
	<?php if( showBrowse($main, $act )) { ?>		
	
		<div id="drop">
			<div> <?php print($page->showText('drop_upload') ); ?> </div>
			<a>Browse...</a>
			<input type="hidden" id="upluri" value="<?php print($query); ?>" name="upluri" multiple />		 
			<input type="file" name="upl" multiple />
		</div>
		
	<?php }  ?>
	
	<ul> 
		<!-- do not delete this tag ul -->
	</ul>
	
	<table align="center" style="margin-top:-15px;" cellpadding="5">
	<tr>
		<td>
			<div style="position:relative; margin:0 auto;">
				<div style="float:left;">
					<ol id="log"> 
						<?php $main->showHTMLUploadedFiles($dbh, $dir, $path, $act, $obj); ?>  
					</ol>
				</div>
			</div>
		</td>
	</tr>
	</table> 

</form>
	 
<?php

function showBrowse($main, $act) {
		 
	if( $main->authenticity() ) { 
		return true;			
	}
	if( $main->isBrowse($act) ) {
		return true;
	}
	
	return false;
}

?>

	<!-- JavaScript Includes show dialog upload files -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"> </script>
	<script src="modules/upload/assets/js/jquery.knob.js"> </script>

	<!-- jQuery File Upload Dependencies -->
	<script src="modules/upload/assets/js/jquery.ui.widget.js"> </script>
	<script src="modules/upload/assets/js/jquery.iframe-transport.js"> </script>
	<script src="modules/upload/assets/js/jquery.fileupload.js"> </script>
		
	<!-- This main JS file -->
	<script src="modules/upload/assets/js/script.js"> </script>

 
