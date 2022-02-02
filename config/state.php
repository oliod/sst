<?php
//https://uclouvain.be/fr/secteurs/sst/secretariat-contact.html 
// chrome://settings/content/flash?search=flash
if(!defined('SST') || !constant(SST)) die('Not A Valid Entry Point');
define('DATE_FORMA_NORMAL', 'DD-MM-YYYY');
$GLOBALS['sst'] = array (  
'icon'  => array (
		'close_connect'  => 'img/exit32.png',
		'help'           => 'img/help.png',
		'top'	         => 'img/top.png',
		'important' 	 => 'img/important.png',
		'upload48' 	 => 'img/folder32.png',
		'in_upload48' 	 => 'img/in_upload48.png',
		'upload128' 	 => 'img/upload128.png',
		'delete' 	 => 'img/del.png',
		'minus' 	 => 'img/mmm.png',
		'plus' 	 	 => 'img/ppp.png',
		'close'          => 'img/close.png',
		'ok'             => 'img/ok.png',
		'cancel'         => 'img/cancel.png',
		'usersst'        => 'img/usersst.png',
		'trash32'        => 'img/trash-full32.png',
		'mail_on'        => 'img/mail_1.png',
		'mail_off'       => 'img/mail_2.png',
		'simp_adm'       => 'img/simpl_adm.png',  
		'simp_modif'     => 'img/modify32.png',
		'pdf24'       => 'img/pdf24.png',
		'locked22'      => 'img/lock22.png',
		'locked32'      => 'img/lock32.png',
		'deadline'       => 'img/clock.png',
		'trash22'       => 'img/trash22.png',
		'folder32' => 'img/folder32.png',
		'search' => 'img/search.png', // 32x32 /
		'pdf_error' => 'img/pdf32.png', // 32x32 /  pdf32.png  img/pdf_barre.png // pdf24
		'comment_edit' => 'img/comment_edit.png',
		
		'buffering' => 'img/buffering.png', // 32x32 /
		
		'sst' => 'img/sst.png', 
		'eli' => 'img/eli.png', 
		
		'interface' => 'img/interface.png',
		'passwd'    => 'img/passwd.png',
		'member' => 'img/member.png',
		'beta' => 'img/beta.png',
		
		'search_list' => 'img/search_list.png', // 32x32 /
		'search_detail' => 'img/search_detail.png', // 32x32 /
		'search_result' => 'img/search_result.png', // 32x32 /
		'search_table' => 'img/search_table.png', // 32x32 /
		
		'user_act'       => 'img/us.png',
		'user_ina'       => 'img/us_hide.png',
		
		'1'       => 'img/1.png',
		'2'       => 'img/2.png',
		'3'       => 'img/3.png',
		'4'       => 'img/4.png',
		'5'       => 'img/5.png',
		
		/*
		'square'       	 => 'img/square_sub.png',
		'square_pre'     => 'img/square_pre.png',  
		'square_cancel'  => 'img/adm_pre_cancel.png',   
		'square_accept'  => 'img/adm_pre_accept.png',
		'square_reject'  => 'img/adm_pre_reject.png',
		'pd' => 'img/pd.png',
		*/
		
		'square'       	 => 'img/square_pre.png',
		'square_pre'     => 'img/square_pre.png',  
		'square_cancel'  => 'img/square_pre.png',   
		'square_accept'  => 'img/square_pre.png',
		'square_reject'  => 'img/square_pre.png',
		'pd' => 'img/square_pre.png',
		
		
		'visited'      => 'img/visited.png',
		'reload'       => 'img/reload.png', 
		'final'  => 'img/final.png',
		'final1' => 'img/final1.png',
		'final2' => 'img/final2.png',
		'final3' => 'img/final3.png',
		'final4' => 'img/final4.png',
 
),
// 'anim_front_page' if option equals true then will be execute the next options,
// if option equals false cannot be done nothing 
// ( default = ' simple animation ' , rand = 'random animation', num = 'configurable animation' )
// for example ('default' => null), ('rand' => null), ('num' => 1)
'anim_front_page'  => array ( 'true' => array('num' => 10)),

//define('SEND_MAIL_FROM_SST', true);
'application_sst' => array(0), //  0 application available 1 application unavailable for user
'application_sst_not_use' => array(0), //  0 application available 1 application unavailable for user and show not_use_msg
'application_sst_not_use_msg'=> 'Please do not use this application at the moment.',
'pagination' => array(10),
'session_time' => array(12600),// 1 hour = 1800
'button_style' => array(1 => 'background:#6499B7;margin:5px;   border: 1px solid #7293c0;  ',
						2 => 'background:#AC3420;margin:5px;   border: 1px solid #7293c0;  ',
						3 => 'background:#AF0303;margin:5px;   border: 1px solid #7293c0;  ',
						4 => 'background:#388985;margin:5px;   border: 1px solid #7293c0;  '),
'button_left' => array (
		'MY PROFILE'              => '?page=my_profile',
		'MY ACADEMIC CV'          => '?page=my_academic_cv',
		'MY PhD'                  => '?page=my_phd&'.GET_LINK_IN_MY_PHD.'=admission&'.GET_LINK_ADMISSION.'=home',
		'IN_MY_PHD' => array (
			'ADMISSION'                  => '?page=my_phd&'.GET_LINK_IN_MY_PHD.'=admission',
			'CONFIRMATION'               => '?page=my_phd&'.GET_LINK_IN_MY_PHD.'=confirmation',
			'PRIVATE DEFENCE'            => '?page=my_phd&'.GET_LINK_IN_MY_PHD.'=private_defence',
			'PUBLIC DEFENCE'             => '?page=my_phd&'.GET_LINK_IN_MY_PHD.'=public_defence',
			),
		'MY SUPERVISORY PANEL'    => '?page=my_supervisory_panel',
		'MY DOCTORAL TRAINING'    => '?page=my_doctoral_training&'.GET_LINK_DOCTORAL_TRAINING.'=status',
		'MY ADDITIONAL PROGRAMME' => '?page=my_additional_programme',
		'MY COTUTELLE'            => '?page=my_cotutelle',
		'MY LOG'                  => '?page=my_log',
		'MY ANNUAL REPORTS'       => '?page=my_annual_reports',
),

'button_left_admin' => array (
					'MANAGEMENT USER' => '?page=management_user&'.GET_LINK_MANAGEMENT.'=search_user',
					'MANAGEMENT ADMIN' => '?page=management_admin&'.GET_LINK_MANAGEMENT.'=config_state'
),

// TEST My Profile PhD domain + Institute ....

// default values  0 => 'adm_home' , 1 => 'adm_research', 2 => 'adm_additional', 3 => 'adm_doc_training', 4 => 'adm_supervisory_panel', 5 => 'adm_signature'
'adm_submit'=> array(0 => 'adm_home' , 1 => 'adm_research', 2 => 'adm_doc_training', 3 => 'adm_supervisory_panel'),

 
/* 
operator = (true is <)  (false is >)  

global training:
if check = true: checking is enabled
if check = false: all checks (global and within) are disabled
if all_block = true: test on sum of all activities

within each category:
if check = true and block-check = true: test is made on the block total only
if check = true and block-check = false: test is made on lines only
otherwise: no test
 
*/

'admission_doctoral_training_testing' => array('check' => true, 'all_block' => true, 'operator' => false,  'num' => 40), // operator max true, min false;
'select_admission_doctoral_training_act' => array(
			1 => array('name' => 'Discipline-specific training', 
						'check'=> true,  // check == true then check each line, but if the option is set in block false
						'operator' => false,  // max = true  min = false   
						'num' => 0 , // value
						'block' => array(
								'check' => true, // check == true check block else do not check block
								'operator' => false, // max = true  min = false
								'num' => 15) // value
						), 
			2 => array('name' => 'Scientific communication',
						'check'=> true, 
						'operator' => false,
						'num' => 0 ,  
						'block' => array(  
								'check' => true,
								'operator' => false,
								'num' => 15)
						), 
			3 => array('name' => 'Teaching',
						'check'=> true,
						'operator' => false,
						'num' => 0 ,
						'block' => array(
								'check' => true,
								'operator' => true,
								'num' => 6)
						), 
			4 => array('name' => 'Others', 
						'check'=> false,
						'operator' => false,   
						'num' => 75 ,   
						'block' => array(
								'check' => false,    
								'operator' => false,
								'num' => 170)
						),
						
			),  

// end config block addmission 

 'select_phd' => array( // (select_phd == select_phd_reduce) 
		1 => 'Choose your domain',
		2 => 'Art de batir et urbanisme',
		3 => 'Sciences',
		4 => 'Sciences agronomiques et ingenierie biologique',
		5 => 'Sciences de l\'ingenieur et technologie',
		6 => 'Sciences veterinaires',
		
), 'select_phd_reduce' => array( // (select_phd_reduce == select_phd) 
		1 => '',
		2 => 'ARCH',
		3 => 'SC',
		4 => 'AGRO',
		5 => 'INGE',
		6 => 'VETE' 
				
), 'select_sciences' => array(
		1 => 'Biologie',
		2 => 'Chimie',
		3 => 'Geographie',
		4 => 'Mathematiques',
		5 => 'Physique',
		6 => 'Statistiques',
		7 => 'Sciences actuarielles'	
		
), 'select_diploma' =>array(
		1 => 'Level of diploma',
		2 => 'Bachelor',
		3 => 'Master',
		4 => 'Advanced master',
		5 => 'Industrial engineering',
		6 => 'Other'

), 'select_academic' =>array(
		1 => '1st year',
		2 => '2nd year',
		3 => '3rd year',
		4 => '4th year',
		5 => '5th year',
		6 => '6th year',
		7 => '1st semester',
		8 => '2nd semester',
		9 => '3rd semester',
		10 => '4th semester',
		11 => '5th semester',
		12 => '6th semester',
		13 => '7th semester',
		14 => '8th semester',
		15 => '9th semester',
		16 => '10th semester',
		17 => '11th semester',
		18 => '12th semester'

), 

'title' =>array('t_diploma'    => 'Diploma # ',
				't_year'       => 'Academic Year/Semester # ',  
				't_conference' => 'CONFERENCE # ',
				't_courses'    => 'COURSE # ',
				't_journal_papers' => 'JOURNAL PAPER # ',
				't_seminars'       => 'SEMINAR # ', //  
				't_teaching_and_supervision' => 'OTHER ACTIVITY # ', 
				), 

'select_my_profile_institute' => array(1 => 'ELI', 2 => 'ISV',3 => 'IMMC',4 => 'IMCN',5 => 'ICTEAM',6 => 'UCL',7 => 'ULB'),

// this is select 
'state'                => array(1 => 'Waiting for private defence report',
								2 => 'Succeeded with minor modifications',
								3 => 'Succeeded with modifications',
								4 => 'New private defence planned',
								5 => 'End of PhD programme',
								), 
								
'select_confirm_state' => array(1 => 'Waiting for confirmation report', // (planning) button validate and cancel 
								2 => 'Confirmation report submitted',
								3 => 'Confirmation successful',
								4 => 'Waiting for new confirmation report',
								5 => 'Confirmation failed End of PhD',
								6 => 'Deadline extension request submitted', // (planning) button submitted 
								),
								
'select_private_defence_satate_get' => array('elem' => 3),

'select_private_defence_satate'  => array(1 => 'Waiting board composition',
										  2 => 'Board composition submitted',
										  3 => 'Board validated. Waiting for report',
										  4 => 'Succeeded without modifications',
										  5 => 'Succeeded with modifications (< 3 months)',
										  6 => 'New private defense planned',
										  7 => 'End of PhD',
										  ), 
	
'select_my_doctoral_training_submission' => array(
			1	=> 'Intermediate submission',
			2   => 'Submission before confirmation',
			3   => 'Final submission',
),
	
								
								
'select_jury_members'  => array(1 => 'Member',
								2 => 'Secretary', 
								3 => 'President',
								4 => 'Supervisor'
								),

'select_status' => array(0 => '', 
						1 => 'In progress',
						2 => 'Submitted', 
						3 => 'Accepted'
						),

'select_cotutelle' => array(0 => '', 
							1 => 'No',
							2 => 'In progress', 
							3 => 'Signed'
							),
						

'select_public_defence_status' => array(0 => '',
										1 => 'Defence is planned',
										2 => 'Waiting for rector signature or thesis report', 
										3 => 'Diploma ready', 
										4 => 'Diploma has been delivered'
										),
											   

'select_my_doctoral_training_conferences_type_list'    => array(1 => 'Poster ',
																2 => 'Talk', 
																3 => 'Conference paper'
																), 
																
'select_my_doctoral_training_conferences_type'         => array(1 => 'National', 
																2 => 'International'
																), 
																
'select_my_doctoral_training_conferences_reference'    => array(1 => 'Abstract', 
																2 => 'Extended abstract', 
																3 => 'Peer-Reviewed full paper'
																),
																
'select_my_doctoral_training_seminars'                 => array(1 => 'My pole / institute',   
																2 => 'Other (Belgian)', 
																3 => 'Other (International)'),
'select_my_doctoral_training_seminars_function'        => array(1 => 'Presenter',
																2 => 'Audience'
																),
																
																
'select_my_doctoral_training_journal'                  => array(1 => 'Accepted',
																2 => 'Published',
																3 => 'Submitted'
																),																
																
																
'select_my_doctoral_training_teaching_and_supervision' => array(1 => 'Teaching (course or practicals)',
																2 => 'Tutoring (master thesis)',
																3 => 'Other activity'
																),
'select_my_doctoral_training_courses_type'             => array(1 => 'Master',
																2 => 'Language',
																3 => 'Other'
																),
   // -----------------------------------------------------
 
'select_person'  => array(0 => 'Mr',    1 => 'Mrs',      2 => 'Dr',         3 => 'Prof'),

'log'  => array(0 => ' Account created ', 
				1 => ' Admission submitted ', //      
				2 => ' Admission accepted by administrator ',      
				3 => ' Admission re-opened by administrator ',
				
				10 => ' Pre-admission submitted by administrator ',
				11 => ' Pre-admission submitted by user ',
				12 => ' Pre-admission re-opened by administrator ',
				13 => ' Pre-admission accepted by administrator ',
				14 => ' Public defence locked by administrator (PhD completed) ',
				15 => ' Public defence unlocked by administrator ',
				
				16 => ' You have been connected ',
				17 => ' You have been disconnected ',	
				18 => ' Tried to connect to SST application ',
				19 => ' Tried to connect when SST application has been locked ',					
				),
				
// 	BEGIN VALUES MY DOCTORAL TRAINING			
 'status_color'  => array('default' => '#F9E0B8',
						'request'   => '#CAC7C7', 
						'accept'    => '#A9D3A5', 
						'refuse'    => '#BC9A9A', 
						'final'     => '#D9DEE0',      
						'supervisor' => '#82AFC9',
						'value'      => 'green',),
				  
				  
'status_value'  => array('default' => 1, 
						'request'  => 2,       
						'accept'   => 3,
						'refuse'   => 4,
						'final'    => 5, 
						'supervisor'  => 6,),
						
'status_icon' => array( 1 => 'img_conf/1.png', 
						2 => 'img_conf/2.png',       
						3 => 'img_conf/3.png',
						4 => 'img_conf/4.png',
						5 => 'img_conf/5.png', 
						6 => 'img_conf/6.png',),
						
// see in file js/text.js 						
'status_name' => array( 1 => 'Not yet submitted', 
						2 => 'Waiting for supervisor approval.',       
						3 => 'Accepted',
						4 => 'Rejected',
						5 => 'FINAL', 
						6 => 'Submitted to the CDD',),
						
// 	END VALUES MY DOCTORAL TRAINING						

'lang' =>array(
		'en' => array(
			0 => 'E-mail: ',
			1 => 'Password: ',
			2 => 'LOGIN ',
			3 => ' Create my space ',
			4 => ' Reset my password',
			5 => ' SEND REQUEST ', // button send
			6 => ' Please enter the exact email address associated with your account.<br/><br/> 
				A new password will be sent to that email address. <br/><br/>',
			7 => 'SUBMIT',
			8 => 'MY ACCOUNT ',
			9 => ' ', // Title of Welcome page
			// begin page default
			10 => ' <div>
						Welcome to the online interface for the PhD programme management. The interface is available to all PhD students of the Secteur des 
						Sciences et Technologies. 
                                                To help you with the use of the interface, a user guide is available <a style="color:navy!important;" href="https://uclouvain.be/en/sectors/sst/application-phd.html" target="_blank">'.'here'.'</a>.<br/> <br/>
					</div>
					<div>
						If you log in for the first time, click on "Create my space" in the right menu, 
						fill in the fields and save your profile. You will receive a confirmation email with your login information.
                                                Proceed by encoding your detailed profile and your academic diploma in the MY PROFILE and MY ACADEMIC CV areas.<br/> <br/>
					</div> ', // page default
			11 => ' <div>
						Before you engage in a PhD programme, you must assemble and submit an admission file using the ADMISSION area of the interface. 
                                                Your application file requires the following points:
						<ul style="list-style-type: circle!important;">
							<li style="margin-left:30px;">the required entry qualifications</li>
							<li style="margin-left:30px;">a supervisor who has agreed to oversee your work</li>
							<li style="margin-left:30px;">an original and innovative research project in which you have a keen interest</li>
							<li style="margin-left:30px;">a proposed supervisory panel willing to support you</li>
							<li style="margin-left:30px;">a proposed doctoral training programme</li>
							<li style="margin-left:30px;">a way of funding your research</li>
						</ul>
					</div></br>
					<div>
						Your submitted admission file will be forwarded to the PhD commission (CDD) responsible for your field of study.
					</div>', // page default
			12 => ' <div>
						Please visit the site <a style="color:navy!important;" href="https://uclouvain.be/en/sectors/sst/settlement.html" target="_blank">'.'Special provisions'.'</a>, where you will
						find specific information needed to assemble and submit your application for admission. 
						<br/>Applications can be
						submitted any time during the academic year and will be reviewed <a style="color:navy!important;" href="https://uclouvain.be/en/sectors/sst/deadlines.html" target="_blank">at the next CDD meeting</a>.
					<div style="color:red; margin:10px;">
								The site has been tested on five web browsers!  
								Do not to use the web browsers Internet Explorer below 11 version.
					</div>
					<img src="img/browser.png"/>
					</div> ', // page default
			
			// end page default
			13 => ' PhD domain: ',
			14 => ' Sub-domain: ',
			15 => ' Last Name: ',
			16 => ' First Name: ',
			17 => ' REGISTER ', // button 
			18 => ' Action:  ', // button 
			19 => ' State:  ', // button 
			20 => ' Mail sent: ',
			//begin state option // Dispatch Processing...OK
			21 => ' Not yet invited ',
			22 => ' Invited to sign ',
			23 => ' Signed by admin.',
			//end state option
			24 => ' Accept ',
			25 => ' Retry ',
			
			26 => ' PDF Signed ',
			27 => ' Mail format was incorrectly entered ',
			28 => ' ID was incorrectly ',
			29 => ' PDF Signed ',
			30 => ' e-Signed ',
			
			31 => ' Online PhD management interface ',
			
			32 => '  ',
			33 => ' Invitation refused ',
			34 => 'Re-type E-mail: ',
			
			'cache_results_title' => 'CACHED RESULTS OF LAST SEARCH',
			'admin_welcome' => 'Welcome to the site SST. Unfortunately the site is under construction 
								and some functions will not work correctly or slowly .<br><br>',
			'signature_link_text' => 'Welcome to the online PhD management system of the Sciences and Technology Sector of UCL.
									  You can now review the details of the PhD admission request and sign (or not) the submission file.
									  <br><br>
									  Use the left menu to display and browse the profile, academic CV and admission details of the candidate.
									  The research project, training programme and the composition of the supervisory panel are located in the 
									  MY PhD > Admission section.
									  <br><br>
									  You can sign (or not) the submission using the blue buttons which appears at the bottom of any Admission page.',
			'supervisor_link_text' => 'Welcome to the online PhD management system of the Sciences and Technology Sector of UCL.
									  You can now review the details of the training credits submission.
									  <br><br>
									  Use the menu bar above to display and browse the different training activities (by category).
									  <br><br>
									  You can sign (or not) the submission using the blue buttons which appears at the bottom of this page.',
			
			'pre-addmission_title_sended'    => ' Pre-admission application submitted. ',
			'pre-addmission_title_accepted'  => ' Pre-admission application accepted. ',
			'pre-addmission_title_rejected'  => ' Pre-admission application rejected. ',
			'pre-addmission_title_cancelled' => ' Pre-admission application re-opened. ',
			
			'title_upload_file' => ' UPLOAD FILE',
			
			'private_defance_submit_select_admin' => ' State of the PRIVATE DEFENCE: ',
			'private_defance_submit_select_user'  => ' State of the PRIVATE DEFENCE: ', // 
			'private_defance_submit_textarea'     => ' Message: ',
			'private_defance_submit_date' => 'Date: ',
			'private_defance_submit_date_validated' => ' Date board validated: ',
			
			'private_defence_home_title'    => ' Thesis title: ',
			'private_defence_home_place'    => ' Place of private defence:  ',
			'private_defence_home_date'     => ' Date of private defence ',
			
			'private_defence_submit_board_title_admin'    => ' Result administrator: ',
			'private_defence_submit_board_title_user'    => ' Result user: ',
			
			'private_defence_board_composition_submitted' => 'Board composition submitted. Submission date : ',
			'private_defence_board_composition_validated' => 'Board composition Validated. Validation date : ',
			'private_defence_board_composition_waiting'   => 'Board composition validated. Waiting for private defence report. Validation date : ',
			'private_defence_board_composition_waiting_validation' => 'Board composition submitted. Waiting validation by the CDD.  Submission date : ',
			
			'private_defence_signaturs_president'       => ' Signature of the President of your Institute ',
			'private_defence_signaturs_president_empty' => ' ',
			
			'my_addition_programme_course_code' => 'Course code ',
			'my_addition_programme_name_course' => 'Course name ',
			'my_addition_programme_number_ects' => 'Number of credits ',
			'my_addition_programme_attached'    => 'Evidence PDF ',
			
			
			'my_doctoral_training_conferences_name'          => 'Name of conference: ',
			'my_doctoral_training_conferences_type_name'     => 'Type: ',
			'my_doctoral_training_conferences_place'         => 'Place: ',
			'my_doctoral_training_conferences_participation' => 'Days of participation: ',
			'my_doctoral_training_conferences_certificate'   => 'UPLOAD CERTIFICATE OF ATTENDANCE (PDF only): ',
			'my_doctoral_training_conferences_date' 		 =>  'Dates: ',
			'my_doctoral_training_conferences_list_documents'=> 'Communications:',
			'my_doctoral_training_conferences_type_title'    => 'Sub-type: ',
			'my_doctoral_training_conferences_type_uploaded' => 'Evidence PDF:', //  
			'my_doctoral_training_conferences_type_select_add' => 'Type: ',  
			'my_doctoral_training_conferences_dial_notice'     => 'Reference of DIAL.Pr notice: ',
			'my_doctoral_training_conferences_comment'         => 'Comment: ',
			'my_doctoral_training_conferences_number_credit'   => 'ECTS: ',
			'my_doctoral_training_conferences_complete_ref'    => 'Title: ', //my_doctoral_training_courses_title
			
			'my_doctoral_training_courses_title'          => 'Course title: ', //  
			'my_doctoral_training_courses_institution'    => 'Institution: ', 
			'my_doctoral_training_courses_type'    => 'Type: ',
			'my_doctoral_training_courses_date'    => 'Dates: ',//my_document_training_courses_certificate
			'my_doctoral_training_courses_participation'    => 'Course volume (hours): ',
			'my_doctoral_training_courses_certificate'      => 'UPLOAD CERTIFICATE OF ATTENDANCE: ',//my_document_training_courses_text
			'my_doctoral_training_courses_credits1'      => 'ECTS: ',
			'my_doctoral_training_courses_proposed'     => 'Proposed: ',
			'my_doctoral_training_courses_validated'    => 'Validated: ',
			'my_doctoral_training_courses_text'         => 'Comment: ', //  
			
			'my_doctoral_training_journal_papers_title'   => 'Title: ', //  notice 
			'my_doctoral_training_journal_papers_role'    => 'Role: ', //  notice 
			'my_doctoral_training_journal_papers_date'    => 'Date: ', // 
			'my_doctoral_training_journal_papers_notice'  => 'Notice DIAL: ', // 
			
			'my_doctoral_training_journal_papers_file'      => 'UPLOAD FIRST PAGE OF PAPER (PDF Only): ',
			'my_doctoral_training_journal_papers_credits'   => 'ECTS: ', // 
			'my_doctoral_training_journal_papers_proposed'  => ' Proposed: ', // my_document_training_journal_papers_validated
			'my_doctoral_training_journal_papers_validated' => ' Validated: ',
			
			// my_document_training_seminars_proposed
			'my_doctoral_training_seminars_function'    => 'My role: ',
			'my_doctoral_training_seminars_title'       => 'Title of seminar (or series): ',
			'my_doctoral_training_seminars_type'        => 'Audience: ',
			'my_doctoral_training_seminars_institution' => 'Institution: ',
			'my_doctoral_training_seminars_date'        => 'Date: ',
			'my_doctoral_training_seminars_credits'     => 'ECTS: ',
			'my_doctoral_training_seminars_proposed'    => 'Proposed: ',
			'my_doctoral_training_seminars_validated'   => 'Validated: ', // my_doctoral_training_teaching_and_supervision_title  
			'my_doctoral_training_seminars_text'        => 'Comment: ',
			
			'my_doctoral_training_teaching_and_supervision_title'       => 'Description: ', //my_document_training_teaching_and_supervision_type
			'my_doctoral_training_teaching_and_supervision_type'        => 'Type: ', // my_document_training_teaching_and_supervision_institution
			'my_doctoral_training_teaching_and_supervision_institution' => 'Institution: ',// my_doctoral_training_teaching_and_supervision_credits
			'my_doctoral_training_teaching_and_supervision_credits'     => 'ECTS: ', //my_document_training_teaching_and_supervision_proposed
			'my_doctoral_training_teaching_and_supervision_proposed'    => 'Proposed: ', //my_document_training_teaching_and_supervision_validated
			'my_doctoral_training_teaching_and_supervision_validated'   => 'Validated: ', // _text
			'my_doctoral_training_teaching_and_supervision_text'        => 'Comment: ',

			'my_doctoral_training_submit_page'      => 'Page:',
			'my_doctoral_training_submit_title'     => 'Title:',
			'my_doctoral_training_submit_file'      => 'Files:',
			'my_doctoral_training_submit_proposed'  => ' Proposed:',
			'my_doctoral_training_submit_validated' => ' Validated:',
			'my_doctoral_training_submit_comment'   => 'Comment:',
			
			
			'my_doctoral_training_status_information'   => 'Information:',
			'my_doctoral_training_status_activities'    => 'Activities',
			'my_doctoral_training_status_ects'          => 'ECTS',
			'my_doctoral_training_status_formation'     => 'Training:',
			'my_doctoral_training_status_communication' => 'Communication:',
			'my_doctoral_training_status_encad'   => 'Teaching: ',
			'my_doctoral_training_status_other'   => 'Other: ',
			'my_doctoral_training_status_total'   => 'Total: ',
			'my_doctoral_training_status_list'    => 'List status : ',
			
			
			'public_defence_label_status'    => 'Status:',
			"public_defence_date"            => 'Date: ',
			"public_defence_these"           => 'Title of thesis:',
			"public_defence_local_upstaires" => 'Local: ',
			"public_defence_sammery"         => 'UPLOAD THESIS ABSTRACT: ',
			"public_defence_photo"           => 'UPLOAD PHOTO: ',  
			"public_defence_thesis_time"     => 'Hour: ',
			"public_defence_thesis_place"    => 'Location: ', // 
			"public_defence_jury_date_time"  => 'Time', //   
			"public_defence_jury_date_place" => 'Jury\'s date place: ',  
			"public_defence_title"           => 'Board members meeting before the defence ',
			
			"private_defence_signatures_signatures"  => 'Supervisor ',
			"private_defence_signatures_members"     => ' Member',
			
			'public_defence_admin_place'      => 'Place: ',  
			'public_defence_admin_thesis_num' => 'Thesis number: ',  
			'public_defence_admin_money'      => '250 Euro: ', //  
			'public_defence_admin_auto_diff'  => 'Library copy: ', //  
			'public_defence_admin_generate'   => 'Generate thesis flyer: ',
			'public_defence_admin_generate'   => 'Generate thesis flyer: ',
			'public_defence_jury_members_title'    => ' Jury members  ',
			'public_defence_jury_last_name'  => ' Last name: ',
			'public_defence_jury_first_name' => ' First name: ',
			'public_defence_jury_member'     => ' Role: ',
			
			
			
			
			
			'admission_signature_upload' => ' Please upload a PDF document with the formal approval or signature of this member : ', 
			'private_signature_upload'   => ' Please upload a PDF document with the formal approval or signature of this member : ',  			
			
			'my_supervisory_panel_header_tentative'  =>'Tentative promoter: ',
			'my_supervisory_panel_header_supervisor' =>'Supervisor(s): ', // 
			'my_supervisory_panel_header_supervisory_panel'        =>'Members: ',
			'my_supervisory_panel_header_supervisory_panel_member' =>'Panel member ',
			
			'my_supervisory_panel_title'       =>'Title: ',
			'my_supervisory_panel_last_name'   =>'Last Name: ',
			'my_supervisory_panel_first_name'  =>'First Name: ',
			'my_supervisory_panel_institution' =>'Institution: ',
			'my_supervisory_panel_mail'        =>'E-mail: ',
			
			'my_profile_address_residence' =>'RESIDENCE ADDRESS ',	
			'my_profile_reference_title'   =>'Title: ', // my_profile_address_residence    
			'my_profile_mail'       =>'E-mail: ',
			'my_profile_mobile'     =>'Mobile: ',
			'my_profile_birthplace' =>'Birth place: ',
			'my_profile_birth_date' =>'Birth date: ', 
			'my_profile_PhD_domain' =>'PhD domain: ',
			'my_profile_sciences'   =>'Sub-domain: ', 		
			'my_profile_last_name'  =>'Last name: ', 
			'my_profile_first_name' =>'First name: ',
			'my_profile_institution'=>'Institution: ', 
			 
			'my_profile_institute'=>'Institute: ', 
			'my_profile_thesis_funding'=>'Thesis funding: ', 
			'my_profile_select_institute'=>'Choose your institute  ', 
			'my_profile_pwd'        =>'Password: ', 
			'my_profile_confpwd'    =>'Confirm password: ', 
			"my_profile_mail_desc" => '!! This email address is your username </br>on the PhD management system.',

			'my_profile_street'      =>'Street: ', 
			'my_profile_box_number'  =>'Box number:  ', 
			'my_profile_postal_code' =>'Postcode:  ', 
			'my_profile_city'        =>'City:  ',
			'my_profile_country'     =>'Country:  ',
			'my_profile_tel'         =>'Tel:  ',
			'my_profile_contact_address' =>'CONTACT ADDRESS', // 'my_profile_university'
			'my_profile_contact_university'  =>'University / Institute: ',
			'my_profile_contact_street'      =>'Street: ',
			'my_profile_contact_box'      =>'Box number: ',//my_profile_contact_postcode
			'my_profile_contact_postcode' =>'Postcode: ',
			'my_profile_contact_city'     =>'City: ',
			'my_profile_contact_country'  =>'Country: ',
			'my_profile_contact_tel'      =>'Tel: ',
			
			
			'my_academic_cv_merge_pdf'     => 'MERGE ALL DOCUMENTS AND DOWNLOAD',
			'my_academic_cv_dip_empty_pdf_err' => 'CERTIFICATE MISSING',
			'my_academic_cv_year_empty_pdf_err' => 'TRANSCRIPT MISSING',
			
			'my_academic_cv_merge_pdf_err' => 'The following PDF annexes cannot be merged in the compilation of certificates: ',
			
			'my_academic_cv_diploma_auth_msg'       => ' Your academic CV has been verified during the admission process and is now locked. ',
			'my_academic_cv_diploma_level'          =>'Level of diploma:  ', 
			'my_academic_cv_diploma_official_title' =>'Official title of diploma: ', 
			'my_academic_cv_institution'   =>'Institution:  ', 
			'my_academic_cv_country'       =>'Country: ', 
			'my_academic_cv_awarding_date' =>'Date awarded: ', 
			'my_academic_cv_diploma_date'  =>'Date issued: ', 
			'my_academic_cv_obtained_for_diploma'        =>'Grade awarded for the final diploma (if available):  ', 
			'my_academic_cv_num_of_cr_years_for_diploma' =>'Cumulated number of credits of this diploma ', 
			'my_academic_cv_ects'        =>'EU credits (1 year = 60 ECTS) ', 
			'my_academic_cv_ects_year'   =>'  ', 
			'my_academic_cv_ects_non'    =>'Non EU credits ', 
			'my_academic_cv_ects_credits_years'      =>'Credits / semester ',
			'my_academic_cv_ects_years'              =>'Semesters', 
			'my_academic_cv_please_download_diploma' =>'Final certificate of successful completion of the programme (PDF FORMAT ONLY)', 
			'my_academic_cv_copy_diploma'            =>' ', 
			
			'my_academic_cv_aca_institution'   =>'Institution: ',
			'my_academic_cv_aca_awarding_date' =>'Date awarding: ',
			'my_academic_cv_aca_diploma_date'  =>'Date issued: ',
			'my_academic_cv_aca_degree_level'  =>'Rank within the diploma: ',
			'my_academic_cv_aca_score'         =>'Score obtained: ',
			'my_academic_cv_aca_squale_between'    => ' On a scale between: ',
			'my_academic_cv_aca_squale_between_and'=> ' and ',

			
			
			'my_academic_cv_aca_min' =>'Min: ',
			'my_academic_cv_aca_max' =>'Max: ',
			'my_academic_cv_aca_title_year'           =>'Title of year/semester: ',  
			'my_academic_cv_aca_please_download_year' =>'Transcripts for this year/semester (PDF FORMAT ONLY)', 
			'my_academic_cv_aca_copy_year'            =>' ',

			
			'my_phd_admission_home_preadmission'      =>'Pre-admission ', 
			'my_phd_admission_home_text_preadmission' =>'Text Pre-admission: ', 
			'my_phd_admission_home_text_length'       =>'Characters left: ', 
			'my_phd_admission_home_text_max_length'   =>'Max: ',
			'my_phd_admission_home_admission'         =>'Admission ',

			'my_phd_admission_justification' => 'Brief justification: ',
			
			
			'my_phd_admission_research_project_title' =>'Provisory title of the thesis:  ',
			'my_phd_admission_research_project_research_project' => ' Upload research project: ',
			
			'my_phd_admission_doctoral_training_act'     =>'Activities: ',
			'my_phd_admission_doctoral_training_desc'    =>'Activity ',
			'my_phd_admission_doctoral_training_place'   =>'Location ',
			'my_phd_admission_doctoral_training_acronym' =>'Code (if avail.) ',
			'my_phd_admission_doctoral_training_ects'    =>'Credits ',
			'my_phd_admission_doctoral_training_comment' =>'Comments ',
			'my_phd_admission_warning_accepted_1' => ' You have been admitted to the PhD program on ',
			'my_phd_admission_warning_accepted_2' => '. Your admission file is now locked (read-only). ',
			'my_phd_admission_warning_reject' => ' Your application to the PhD programme has been rejected 
													and your account has been locked. Please contact the PhD office. ',
			'my_phd_admission_warning_processed'  => ' The data being processed. It may take several days',
			
			
			
			'my_phd_admission_supervisory_panel_dialog_title'       =>'Title', 
			'my_phd_admission_supervisory_panel_dialog_last_name'   =>'Last name',
			'my_phd_admission_supervisory_panel_dialog_first_name'  =>'First name',
			'my_phd_admission_supervisory_panel_dialog_institution' =>'Institution, country',
			'my_phd_admission_supervisory_panel_dialog_mail'        =>'E-mail',
			
			'my_phd_admission_supervisory_panel_tentative_promotor' =>'Tentative promoter ', 
			'my_phd_admission_supervisory_panel_supervisor'         =>'Supervisor(s) ', 
			'my_phd_admission_supervisory_panel_supervisory_panel'  =>'Other members  of the panel  ',  
			'my_phd_admission_supervisory_panel_last_name'  =>'Last name ',  
			'my_phd_admission_supervisory_panel_first_name' =>'First name',  
			
			'my_phd_admission_supervisory_panel_date' => 'Date ',
			'my_phd_admission_supervisory_panel_folder' => 'Folder ',
			
			'my_phd_admission_supervisory_panel_status' => 'Status  ',
			
			
			'my_phd_admission_signatures_list_title' =>'Supervisory panel',
			'my_phd_admission_signatures_last_name'  =>'Last name',
			'my_phd_admission_signatures_first_name' =>'First name',
			'my_phd_admission_signatures_mail'       =>'E-mail',
			'my_phd_admission_signatures_state'      =>'State',
			'my_phd_admission_signatures_upload'     =>'Upload PDF', // title_upload_file
			
			'my_phd_admission_signatures_second_title' =>'Members', // my_phd_confirmation
			
			/*
			'my_phd_admission_submit_admin_accept'        => 'Check whether all data is been filled. After sending the ADMISSION will be blocked for user',
			'my_phd_admission_submit_admin_accept_cancel' => 'You must accept or cancel data',
			'my_phd_admission_submit_admin_cancel'        => 'Cancellation leads to the loss of some data. Be careful!',
			'my_phd_admission_submit_admin_default'       => 'USER IS NOT SEND REQUEST! ',
			*/
			
			'my_phd_admission_submit_user_sent' => 'Data has been sent. Data must be accepted by admin. Being processed ... ',
			'my_phd_admission_submit_user_send' => 'Check whether all data is been filled. After sending the ADMISSION will be blocked', 
			'my_phd_admission_submit_user_accepted' => 'Data has been accepted by admin', 
			'my_phd_admission_submit_user_default'  => 'If the data will be sent, ADMISSION will be blocked',
			
			
			'my_phd_admission_submit_user'  =>  'Check whether all data is been filled. After sending the ADMISSION will be blocked',
			'my_phd_admission_submit_admin' => 'Cancellation leads to the loss of some data. Be careful!',
			'my_phd_admission_submit_sent'  => 'Data has been sent',
			
			'my_phd_admission_submit_select_academic_cv'  => ' Select academic cv ',
			
			
			
			'my_phd_admission_ucl_reg' => 'PDF ONLY: ',
			'confirmation_planning_upload' => '<div style="margin:10px;">Upload the justification letter</div>',
			'my_phd_confirmation_planning_deadline_for_conf'   =>'Deadline for confirmation '.DATE_FORMA_NORMAL.' + 2 YEARS', 
			'my_phd_confirmation_planning_request'             =>'Request for deadline extension',  //
			'my_phd_confirmation_planning_newdeadline'         =>'Deadline (extended !) : ', //
			'my_phd_confirmation_planning_justification'       =>'Brief justification :', // my_phd_confirmation_planning_justification
			'my_phd_confirmation_planning_admission_two_years' =>'Deadline for confirmation :', // my_phd_confirmation_planning_justification
			'my_phd_confirmation_planning_upload'         => 'Upload justification letter ',
			'my_phd_confirmation_result_date_confirm'     =>'Date of confirmation : ',
			'my_phd_confirmation_result_doctoral_report'  =>'Research report : ',
			'my_phd_confirmation_result_supervisory_panel_report'     =>'Report of the supervisory panel : ',
			'my_phd_confirmation_planning_counter'                    => 'Remaining time before the deadline ',
			
			'my_phd_confirmation_planning_validated'    => 'Your confirmation results have been validated by the CDD. ',
			'my_phd_confirmation_planning_submitted'    => 'Data has been submitted  ',
			'my_phd_confirmation_planning_confirmation' => 'The results of the confirmation have been submitted and are waiting for CDD validation. Date of submission : ',
			
			'my_phd_confirmation_planning_pending'  =>'Deadline extension request pending. Waiting for CDD approval. Request sent : ', //
			'my_phd_confirmation_planning_accepted' => 'The extension of deadline has been approved. ',
			'my_phd_confirmation_status'            => 'Current status : ',
			
			'my_phd_confirmation_home_status' =>'Status of confirmation: ',
			
			'my_cotutelle_desc'   => 'Current status: ',
			'my_cotutelle_upload' => 'Signed agreement PDF: ',
			
			'my_cotutelle_opening_application' => 'Opening application: ', 
			
			'management_admin_info_detect'   => ' Detect errors in input data.  ',
			
			'management_admin_info_title'   => ' APPLICATION STATUS ',
			'management_admin_info_status0' => 'The application is currently available. Change the value of the
			                                    variable named "application_sst" (Config Environment) to 1 to make it unavailable.',
			'management_admin_info_status1' => 'The application is currently unavailable. Change the value of the
			                                    variable named "application_sst" (Config Environment) to 0 to make it available.',
			'management_admin_info_status2' => '',									
												
			'management_admin_info_status_default' => ' NOT STATUS ',
			
			'management_admin_info_status_user0' => ' ',
			'management_admin_info_status_user1' => ' The PhD management system is temporarily unavailable. Please try later. ',
			
			'management_admin_config_dialog' => 'Please be careful when modifying " Dialog "', //  
			'management_admin_config_state'  => 'Please be careful when modifying "Environment"', 
			'management_admin_config_dialog_history'  => 'DIALOG HISTORY', 
			'management_admin_config_content'         => 'Content',
			'management_admin_config_history_area'    => 'History', 

			'admin_wp_last_name'  => 'Last name: ',
			'admin_wp_first_name' => 'First name: ',
			'admin_wp_tel'        => 'Tel: ',
			'admin_wp_email'      => 'E-mail: ',
			'admin_wp_pwd'        => 'Password: ',
			'admin_wp_confpwd'    => 'Confirm Password: ',
			'admin_wp_txt'        => ' Text: ',
			'admin_wp_user_has_been_deleted' =>'The account has been deleted ',
			'admin_wp_create_user'           => 'Create special accounts',
			'admin_wp_warning_be_careful'    => 'Your account allows you to change special user settings. Proceed with care...',
			'admin_wp_warning_create_user'   => 'Care should be taken to select appropriate access rights for each special user.',
			'admin_wp_user_has_been_created' => 'You have created an account with special WRITE access.',
			'admin_wp_create_admin'      => 'This account has WRITE access to the whole database',
			'admin_wp_is_admin'          => 'You have created an account with full WRITE access.',
			'admin_wp_give_neme'         => 'Select the pages to which this user should have a WRITE access.',
			'admin_wp_change_privileges' => 'You do not have the rights to change these settings.',
			
			
			'doctoral_your_research_report_upload' => '<div style="margin:10px;">Upload your research report </div>',
			'report_supervisory_panel_upload'      => '<div style="margin:10px;">Upload the report of the supervisory panel </div>',
		
		'admin_search_user_click' => ' Please go to the Search Users tab to start working. ',
		'admin_search_load_saved_query' => 'LOAD SAVED QUERY : ',
		'admin_search_user_header'	   => 'SEARCH USER ',
		'admin_search_user_lname'      =>'Last Name', 
		'admin_search_user_fname'      => ' First Name',
		'admin_search_user_phd'        => ' PhD Domain // CDD',
		'admin_search_user_subdomain'  => ' Subdomain',
		'admin_search_user_inst'       =>' Institution',
		'admin_search_user_supervisor' => 'Supervisor ',
		'admin_search_user_finance_thesis' => ' Finance thesis',
		'admin_search_user_admission'      => 'Admission ',
		'admin_search_user_pre_admission'  => 'Pre-admission	 ',
		'admin_search_user_confirmation'   => ' Confirmation',
		'admin_search_user_private_defence'   => ' Private defence ',
		'admin_search_user_public_defence' => ' Public defence	',
		'admin_search_user_status_admission'     => 'Admission ',
		'admin_search_user_status_pre_admission' => ' Pre-admission	',
		'admin_search_user_status_confirmation'  => ' Confirmation',
		'admin_search_user_status_doctoral_training' => ' Doctoral training	',
		'admin_search_user_status_private_defence'   => 'Private defence	 ',
		'admin_search_user_status_public_defence'    => 'Public defence	 ',
		'admin_search_user_status_cotutelle'         => 'Cotutelle ',
		'admin_search_user_status_thesis_completed'  =>  'Thesis completed ',
		'admin_search_user_title_my_phd'         => ' MY PhD: ',
		'admin_search_user_title_sciences'       => ' Sub-domain: ',
		'admin_search_user_title_thesis_funding' => ' Thesis funding: ',
		
		'admin_search_user_status_admission_additional_programme' => ' Additional programme  ',
		
		'admin_search_last_modification_by_user' => 'Last modification by user :',
		'admin_search_yes' => ' YES ',
		'admin_search_no' => ' NO ',
		
		'admin_text_list' => ' Write something about this user!!! ',
		
		"req_server_page_ok1" => "ok",
		"req_server_page_ok2" => "OK",
		"req_server_page_pwd_forgot_err100"       => "There is no account associated with that email.",
		"req_server_page_my_space_connect_err100" => "An account with this email address exists already. Please try to login or to reset your password.",
		"req_server_page_my_academic_err022"      => " Some fields are missing.",
		"req_server_page_additional_programme_save_err"   => "The programme is empty and has not been saved.",
		"req_server_page_additional_programme_delete_err" => "Please select at least one item to delete.",
		
		"inc_info_show_all_tables"    => 'SHOW ALL TABLES ',
		"inc_info_msg_all_files_del"  => 'All files and all records will be deleted. be careful',
		"inc_info_information_header" => 'INFORMATION FOLDER ID: ',
		"inc_info_file_exists" => ' <span style="color:green;"><b> EXISTS </b></span>',
		"inc_info_file_null"   => ' <span style="color:blue;"><b> NULL </b></span>',
		
		// form header 
		
		'header_title_application_sst' => ' About the interface ',
		'header_title_get_new_password'          => 'Get new password',
		'header_title_link_signatures_info_user' => ' PhD candidate ',
		
		'header_title_show_list'         => 'USER LIST (whole DB) ', 
		'header_title_create_accounts'   => 'Create special accounts', 
		'header_title_list_accounts'     => 'ACCOUNTS WITH SPECIAL RIGHTS ', 
		'header_title_query_user'        => 'SEARCH USER  ', 
		'header_title_presidents'        => 'SST Institutes  ', 
		
		 
		'header_title_my_log'                          => 'Activity log of your account ',
		'header_title_my_cotutelle'                    => 'Cotutelle agreement ',
		'header_title_my_additional_prog'              => 'Composition of the additional programme ',
		'header_title_my_doctoral_training_block'      => 'Type of submission ',
		'header_title_my_doctoral_training_submit'     => 'Activities in the submission queue ',
		'header_title_my_doctoral_training_detail'     => 'List of validated activities ',
		'header_title_my_doctoral_training_status'     => 'Status of the doctoral training (validated activities) ',
		'header_title_my_supervisory_panel_tentative'  => 'Pre-admission supervisor ',
		'header_title_my_supervisory_panel_supervisor' => 'Supervisor(s) ',
		'header_title_my_supervisory_panel_member'     => 'Members ',
		'header_title_public_defence_thesis'           => 'Publication details ',
		'header_title_public_defence_form'             => 'Practical details for the public defence ',
		'header_title_private_defence_home'            => 'General information ',
		'header_title_public_defence_jury_members'     => 'Composition of the thesis board  ',
		'header_title_public_defence_status'           => 'Status of public defence',
		'header_title_private_defence_signatures'      => 'Signatures of the members of the supervisory panel ',
		'header_title_private_defence_submit_board'    => 'Submission of board composition ',
		'header_title_private_defence_status'    => 'Private defence status ',
		'header_title_confirmation_status'       => ' Current status of your confirmation ', 
		'header_title_confirmation_planning'     => 'Deadline extension form ',  
		'header_title_confirmation_result'       => 'Results of the confirmation ',
		'header_title_admission_home'       	 => ' Print or submit your admission file ',		
		'header_title_admission_reseach_project' => 'Research project ',  
		'header_title_admission_additional_prog' => 'Additional programme ',  
		'header_title_admission_supervisory_panel_tentative_promotor' => 'Tentative supervisor ',  
		'header_title_admission_supervisory_panel_supervisor'         => 'Supervisor (or co-supervisors) ',  
		'header_title_admission_supervisor'     => 'Supervisor (or co-supervisors) ', 
		'header_title_admission_other_members_' => 'Other members ',  
		'header_title_admission_supervisory_panel_other_member' => 'Signatures of the supervisory panel ',  
		'header_title_admission_registration'       => 'Your file from the UCL admission office ',   
		'header_title_management_user_form_wp_'     => 'User information ',  
		'header_title_management_user_search'       => 'Query',  
		'header_title_management_user_institute'    => 'Institutes - President contact address ',  
		'header_title_my_profile'                   => 'General data',  
		'header_title_my_profile_residence_address' => 'Official residence address ',  
		'header_title_my_profile_contact_address'   => 'Contact address (in principle, your UCL address) ', 
		'header_title_search_user'                  => 'SEARCH RESULT', 
		'header_title_search_recorded_results'      => 'RECORDED RESULTS',
		'header_title_upload'                       => 'File upload in... ',
		
		
		'header_title_upload'                       => 'File upload in... ',
		'header_title_annual_raports'               => 'Annual reports  ',
		
		'hedaer_title_welcome' => 'Meaning of icons ',
		
		'hedaer_title_timer' => ' List of users online',
		
		'description_welcome' => 'Description',
			
		'tip_close_connect'        => 'Log out in safe mode.',
		'tip_reload_page'          => 'Refresh the page and delete the cookies of this application.',
		'tip_last_search_results'  => 'Use this button to (re)load the last search results (and copy them to the cache).',
		'tip_manage_saved_queries' => 'Displays and manage saved queries.',
		'tip_database_structure'   => 'Displays information of the database structure (MySQL tables).',
		'tip_buffering'            => 'Displays the last search results from the cache (faster, but unsafe if the DB content has changed). ',
		'tip_users_screen'         => 'Go back to the Search Users screen. ',
		
		'link_not_active' => ' Link is not active... ',
		
		'my_annual_raports_title'  => 'Title Annual reports  ',
		'my_annual_raports_date'   => 'Date uploaded  ',
		'my_annual_raports_folder' => 'Evidence PDF  ',
		'my_annual_raports_file_deleted' => 'File has been deleted :  ',
		
		
		'drop_upload' => 'Please Drop PDF Here',
		
		 
		
		'mail_object_SIGNATURE_LINK'    => '[UCL/SST/CDD] Supervisory panel - Invitation to sign admission request.',
		'mail_object_OVERWRITE_PWD_WP'  => '[UCL/SST/CDD] Password confirmation',
		'mail_object_CREATE_USER_WP'    => '[UCL/SST/CDD] Your login details on the online PhD management interface',
		'mail_object_PASSWORD_FORGOT'   => '[UCL/SST/CDD] Password reset',
		'mail_object_MY_DOCTORAL_TRAINING' => '[UCL/SST/CDD] Validation of doctoral training request',
		'mail_object_REGISTRATION'  => '[UCL/SST/CDD] Message from the PhD management office',
		'mail_object_DEFAULT'       => '[UCL/SST/CDD] Message from the PhD management office', 
		
		'MAIL_OFFICE_PREADMISSION'            => '[App-CDD] %domain% - %username% : Pre-admission submitted',
		'MAIL_OFFICE_ADMISSION'               => '[App-CDD] %domain% - %username% : Admission submitted',
		'MAIL_OFFICE_CONFIRMATION_PLANNING'   => '[App-CDD] %domain% - %username% : Confirmation planning submitted',
		'MAIL_OFFICE_CONFIRMATION_SUBMIT'     => '[App-CDD] %domain% - %username% : Confirmation submitted ',
		'MAIL_OFFICE_PRIVATE_DEFENCE_SBC'     => '[App-CDD] %domain% - %username% : Board composition submitted',
		'MAIL_OFFICE_PUBLIC_DEFENCE'          => '[App-CDD] %domain% - %username% : Status of public defence',
		'MAIL_OFFICE_MY_SUPERVISORY_PANEL'    => '[App-CDD] %domain% - %username% : Supervisory panel',
		'MAIL_OFFICE_MY_ADDITIONAL_PROGRAMME' => '[App-CDD] %domain% - %username% : Additional Programme uploaded ',
		'MAIL_OFFICE_MY_ADDITIONAL_PROGRAMME_SIMPLE' => '[App-CDD] %domain% - %username% : Additional Programme ',
		'MAIL_OFFICE_MY_DOCTORAL_TRAINING'    => '[App-CDD] %domain% - %username% : Doctoral training submitted',
		'MAIL_OFFICE_MY_COTUTELLE'            => '[App-CDD] %domain% - %username% : Cotutelle saved',
		
		'header_administrator_sudo'   => ' SUPER ADMINISTRATOR ',
		'header_administrator_simple' => ' SIMPLE ADMINISTRATOR ',
		'header_link_signatures' => ' INVITATION TO REVIEW AND SIGN A PhD ADMISSION REQUEST ',
		
		'admission_submit_admitted' => ' Admission date : ',
		
		'footer_version' => ' 	
							<b> Version (v 1.2.1) Last modification 06-08-2018 (d-m-y)</b> 
							<span><b> AFD </b></span> Copyright all rights reserved  2014-2018
							',
				
		'footer_copyright' => ' ',
		
		'between' =>  'between ',
		'end'     =>  'end ',
			
			 
			
			'message_supervisor_mail' => 'Do not forget to activate the main "SUPERVISORY" click on the icon in the form of an envelope!!!',
			
			'my_phd'            => '<h1> ATTACHED FILE </h1>',
			'method_pointer'    => '<h1> METHOD: Not A Valid Entry Point </h1>',
			'title_upload_file' => '<h1> FILE UPLOAD </h1>',
			
			'e-main_content_supervisor'  => 'Please click here to go to -> <br/>',
			'e-main_content_default'     => ' Message of SST ',
			'e-mail_msg_object_from_sst' => ' Welcome SST',
			
			'admin_institute_title' => ' Institute ',
			'admin_institute_header' => ' SST Institutes ',
			'admin_institute_mail' => ' Mail ',
			'admin_institute_text' => ' Full name ',
			
			'upload_file_in' => ' Upload file in type : ' 
				
		)
)

);

class HorisontMenu {

public function addminssionMenu() {
	return  array('home'                 => 'Admission type',                
				  'research_project'     => 'Research project',
				  'additional_programme' => 'Additional programme',
				  'doctoral_training'    => 'Doctoral training',
				  'supervisory_panel'    => 'Supervisory panel',
				  'signatures'           => 'Signatures',
				  'submit'               => 'Submit admission',
                  'ucl_reg'              => 'UCL Registration',	   
	);
}

public function privateDefenceMenu() {
	return array('home'            => 'Home', 
				  'jury_members'   => 'Jury members',
				  'signatures'     => 'Signatures',
				  'submit'         => 'Submit board composition',  
				  'status'        => 'Status',	  
	);
}

public function publicDefenceMenu() {
	return array('public'   => 'Home',);
}

public function confirmationMenu() {
	return array('home'        => 'Status', 
					'planning' => 'Planning',
					'results'  => 'Submit',
					//'log'      => 'Log',
	);
}

public function docTrainingMenu() {
	return array('status' => 'Status', 
					'conferences' => 'Conferences',
					'journal_papers'  => 'Journal papers',
					'courses'  => 'Courses',
					'seminars'  => 'Seminars',
					'teaching_and_supervisory'  => 'Others',
					'submit'  => 'Submit',
					'detail'  => 'Detail',                  
					//'log'      => 'Log',
	);
}

public function cotutelleMenu() {
	return array('home' => 'Cotutelle');    
}

public function annualReports() {
	return array('home' => 'Annual Reports');    
}

public function manageAdminMenu() { 
	return array('info' => 'Info',
				'show_all_admin' => 'Show all admin',
				'config_text' => 'Config dialog',
				'config_state' => 'Config environment',		
	);
}

public function myAdditionalProgramm() {
	return array('home' => 'My additional program');
}

public function manageUserMenu() { 
	return  array('show_list' => 'Show List', 'wp_form'=> 'Create special accounts', 'wp_list'=>'List of special accounts', 
				'search_user'=> 'Search Users', 'institute' => 'Presidents of institutes', 'welcome'=>'welcome');
}

}
 
				  
				  
?>