<?php
 
class PageSST {

const HEADER_DIR = 'hf/header.php';
const FOOTER_DIR = 'hf/footer.php';

// class PageSST's attributes
//<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 private $page_default  = 'default';
 private $page_real     = '';
 private $doctype  	    = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n";
 private $html    	    = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n<head>\n";
 private $title    	    = 'S.S.T. Secteur des Sciences et Technologies';
 private $key_words     = "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">\n";
 private $css_default   = "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/default.css\" />\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/dialog.css\" />\n";
 private $css_jquery_ui = "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/jquery-ui.css\" />\n";


 private $css_ie = " <!--[if IE]><style type='text/css'>#layout{ filter: alpha(opacity=50); }</style><![endif]-->\n";
 private $head 	 = "</head>\n";
 private $js_ajax             = "<script type=\"text/javascript\" src=\"js/ajax.js\"> </script>\n";
 private $js_text             = "<script type=\"text/javascript\" src=\"js/text.js\"> </script>\n";
 private $js_main             = "<script type=\"text/javascript\" src=\"js/main.js\"> </script>\n";
 private $js_responsive       = "<script type=\"text/javascript\" src=\"js/responsive.js\"> </script>\n";
 private $js_track            = "<script type=\"text/javascript\" src=\"js/track.js\"> </script>\n";
 
 private $js_my_space_connect = "<script type=\"text/javascript\" src=\"modules/my_space_connect/js/my_space_connect.js\"> </script>\n"; 
 private $js_my_profile       = "<script type=\"text/javascript\" src=\"modules/my_profile/js/my_profile.js\"> </script>\n"; 
 private $js_jquery           = "<script type=\"text/javascript\" src=\"js/jquery/jquery-2.1.0.js\"> </script>\n";
 private $js_my_academic_y	  = "<script type=\"text/javascript\" src=\"modules/my_academic_cv/js/my_academic_cv.js\"> </script>\n";
 
 private $js_my_phd_admission    = "<script type=\"text/javascript\" src=\"modules/my_phd/js/admission.js\"> </script>\n";
 private $js_my_phd_confirmation = "<script type=\"text/javascript\" src=\"modules/my_phd/js/confirmation.js\"> </script>\n";

 private $js_my_phd_private_defence  = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_defence.js\"> </script>\n";


 private $js_my_phd                  = '';
 private $js_my_supervisory_panel    = "<script type=\"text/javascript\" src=\"modules/my_supervisory_panel/js/my_supervisory_panel.js\"> </script>\n";
 private $js_my_doctoral_training    = '';
 private $js_my_additional_programme = "<script type=\"text/javascript\" src=\"modules/my_additional_programme/js/my_additional_programme.js\"> </script>\n";
 private $js_dialog 					= "<script type=\"text/javascript\" src=\"js/dialog.js\"> </script>".
											"<script src=\"http://code.jquery.com/jquery-latest.min.js\" type=\"text/javascript\"></script>". "\n";
 private $js_pwd_forgot 				= "<script type=\"text/javascript\" src=\"modules/pwd_forgot/js/pwd_forgot.js\"> </script>\n";


 private $js_adm_home                 = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_home.js\"> </script>\n";
 private $js_adm_research_project     = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_research_project.js\"> </script>\n";
 private $js_adm_additional_programme = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_additional_programme.js\"> </script>\n";
 private $js_adm_doc_training         = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_doc_training.js\"> </script>\n";
 private $js_adm_supervisory_panel	 = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_supervisory_panel.js\"> </script>\n"; 
 private $js_adm_signatures           = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_signatures.js\"> </script>\n";
 private $js_adm_submit               = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_submit.js\"> </script>\n";
 private $js_adm_ucl                  = "<script type=\"text/javascript\" src=\"modules/my_phd/js/adm_ucl.js\"> </script>\n";
 private $js_adm_result_and_log       = "";

 private $js_conf_planning	 = "<script type=\"text/javascript\" src=\"modules/my_phd/js/conf_planning.js\"> </script>\n"; 
 private $js_conf_result	     = "<script type=\"text/javascript\" src=\"modules/my_phd/js/conf_results.js\"> </script>\n"; 

 private $js_private_home	     = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_home.js\"> </script>\n"; 
 private $js_private_jury_members = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_jury_members.js\"> </script>\n"; 
 private $js_private_signatures	 = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_signatures.js\"> </script>\n"; 
 private $js_private_submit	     = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_submit.js\"> </script>\n"; 
 private $js_private_status	     = "<script type=\"text/javascript\" src=\"modules/my_phd/js/private_status.js\"> </script>\n"; 
 
 //js_my_phd $js_public_defence js_my_phd_public_defence_home
 private $js_my_phd_public_defence      = "<script type=\"text/javascript\" src=\"modules/my_phd/js/public_defence.js\"> </script>\n";
 private $js_my_phd_public_defence_home  = "<script type=\"text/javascript\" src=\"modules/my_phd/js/public_defence_home.js\"> </script>\n";
	
 private $js_admin_management     = "<script type=\"text/javascript\" src=\"modules/admin/js/management_admin.js\"> </script>\n";
 private $js_admin_mail           = "<script type=\"text/javascript\" src=\"modules/admin/js/mail.js\"> </script>\n";
 private $js_user_management      = "<script type=\"text/javascript\" src=\"modules/admin/js/management_user.js\"> </script>\n";

 private $js_user_mng           = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_user.js\"> </script>\n";
 private $js_admin_mng          = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_admin.js\"> </script>\n";

 private $js_user_wp_form       = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_wp_form.js\"> </script>\n";
 private $js_user_wp_list       = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_wp_list.js\"> </script>\n";
  
 public  $js_search_user       = "<script type=\"text/javascript\" id=\"dsj\"  src=\"modules/admin/js/mng_search_user.js\"> </script>\n";
 private $js_show_list        = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_show_list.js\"> </script>\n";
 private $js_institute        = "<script type=\"text/javascript\" src=\"modules/admin/js/mng_institute.js\"> </script>\n";

 private $js_admin_authority	   = "<script type=\"text/javascript\" src=\"modules/admin/js/authority.js\"> </script>\n";
 
//jquery-ui.js
 private $js_doc_training_status        = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_status.js\"> </script>\n";
 private $js_doc_training_conferences = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_conferences.js\"> </script>\n";
 private $js_doc_training             = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training.js\"> </script>\n";
 private $js_doc_training_journal_papers = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_journal_papers.js\"> </script>\n"; //
 private $js_doc_training_courses        = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_courses.js\"> </script>\n";
 private $js_doc_training_seminars = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_seminars.js\"> </script>\n"; //
 private $js_doc_training_teaching_and_supervisory = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_teaching_and_supervisory.js\"> </script>\n"; //
 private $js_doc_training_submit = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_submit.js\"> </script>\n"; //
 private $js_doc_training_detail = "<script type=\"text/javascript\" src=\"modules/my_doctoral_training/js/doc_training_detail.js\"> </script>\n"; //

 private $js_jquery_ui = "<script type=\"text/javascript\" src=\"js/jquery/jquery-ui.js\"> </script>\n";
 private $js_jquery_countdown = "<script type=\"text/javascript\" src=\"js/jquery/jquery.countdown.js\"> </script>\n"; //  
 private $js_jquery_plugin = "<script type=\"text/javascript\" src=\"js/jquery/jquery.plugin.js\"> </script>\n";

 private $js_my_cotutelle = "<script type=\"text/javascript\" src=\"modules/my_cotutelle/js/my_cotutelle.js\"> </script>\n";
 private $js_my_annual_reports = "<script type=\"text/javascript\" src=\"modules/my_annual_reports/js/my_annual_reports.js\"> </script>\n";


 private $link_signatures = "<script type=\"text/javascript\" src=\"modules/link_signatures/js/link_signatures.js\"> </script>\n";

 private $jq_min = "<script type=\"text/javascript\" src=\"js/jquery-3.2.1.min.js\"> </script>\n";
 
 private $js_timer = "<script type=\"text/javascript\" src=\"timer/timer.js\"> </script>\n";

 public $menu_adm             = array();
 public $menu_private_defence = array();	
 public $menu_public_defence  = array();				
 public $menu_conf            = array();	  							  
 public $doc_training         = array(); 			
 public $cotutelle            = array();
 public $annual_reports       = array();
 public $menu_manage_admin    = array();		
 public $my_additional_programm = array();	
 public $menu_manage_user     = array();

 public $h_menu     = array();		
	
 public $arr_activation = array(
								0=>array(0), 
								1=>array(1,2,3,8), 
								2=>array(1,2,3,4,5,6,7,8,9,10)
							);
								
 public $arr_activation_phd = array(
								0=>array(0),
								1=>array(1),								
								2=>array(1,2), 
								3=>array(1,2,3),
								4=>array(1,2,3,4),
							);									
 public $num_active_buts = 3;
				
 public function __construct() { 
	 
		$this->menu_adm             = new HorisontMenu(); 
		$this->menu_private_defence = new HorisontMenu(); 
		$this->menu_public_defence  = new HorisontMenu(); 
		$this->menu_conf            = new HorisontMenu();
		$this->doc_training         = new HorisontMenu(); 
		$this->cotutelle            = new HorisontMenu(); 
		$this->annual_reports       = new HorisontMenu(); 
		$this->menu_manage_admin    = new HorisontMenu();  
		$this->my_additional_programm = new HorisontMenu();  
		$this->menu_manage_user     = new HorisontMenu();
		$this->h_menu     = new HorisontMenu();
 }

 public function activationPosition ($pos=0) {
	return (isset($this->arr_activation[$pos]) ? $this->arr_activation[$pos] : 0);
 }
 public function activationPositionPhD ($pos=0) {
	return (isset($this->arr_activation_phd[$pos]) ? $this->arr_activation_phd[$pos] : 0 );
 }
 
 public function display() {
	  
	 if(!is_array($this->displayButtonLeft())) return false;  
		$this->getButtonsLeft();
		print ( $this->displayDoctype() );
		print ( $this->displayHTML() );
		print ( $this->displayTitle() );
		print ( $this->displayKeywords() );
		print ( $this->displayStyles() );
		
		//if (!preg_match("/aa/i", $this->getBrowserName($_SERVER['HTTP_USER_AGENT']))) {}
		include_once('animation.php'); 
		print($animCSS."\n");
		
		print ( $this->displayJavaScript($this->page_real) );
		if(AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) {
			print ( $this->js_admin_authority);
		}
		 
		print( $this->js_timer ) ;
		print('<script> var sst = new USERS.connexion( ); </script>');
		print ( $this->displayJSInMyPHD() ); 
		
		print ( $this->admissionJS() );
		print ( $this->confirmationJS() );
		print ( $this->privateDefenceJS() );
		print ( $this->publicDefenceJS() );  
		
		print ( $this->myDoctoralTrainingJS() );
		print ( $this->_adminManagementJS() );
		print ( $this->css_ie );
		
		print ( $this->head );
		$this->displayHeader();
		print('<script src="modules/pdf_dialog/js/pdf_dialog.js"> </script>');
		print($animJS."\n".$animJQuery);
		
		print ( $this->displayPage($this->page_real) );	
		$this->displayFooter();
 }
 
 public function displayDoctype() {
    return  $this->doctype ;
 }
 
 function getBrowserName($user_agent) {
    if (stripos($user_agent, 'Opera') || stripos($user_agent, 'OPR/')) return 'Opera';
    elseif (stripos($user_agent, 'Edge')) return 'Edge';
    elseif (stripos($user_agent, 'Chrome')) return 'Chrome';
    elseif (stripos($user_agent, 'Safari')) return 'Safari';
    elseif (stripos($user_agent, 'Firefox')) return 'Firefox';
    elseif (stripos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'IE';
    return 'Other';
 }
 
 public function buttonReturn($get, $key, $uri) {
	 
	$uri = ( (is_null($get) || is_null($key)) ? $uri : $uri.'&'.$get.'='.  $key ) ;
	print('<div style="margin-top:20px; padding:10px;"><a class="s_button_return" href="'.$uri.'">'); 
	print('RETURN');
	print('</a></div>');
 
 }
 
 public function displayHTML() {
    return  $this->html ;
 }
 
 public function displayTitle() {
    return  "<title>".$this->title."</title>\n" ;
 }
 
 public function displayKeywords() {
    return  $this->key_words ;
 }
 
 public function displayStyles() { 
	return  $this->css_default.$this->css_jquery_ui;
 }

 public function admissionJS() {
	$result =  ''; 
	$admission = (isset($_GET[GET_LINK_ADMISSION]) ? $_GET[GET_LINK_ADMISSION] : '');
	
	switch($admission) {
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 0): 
			$result = $this->js_adm_home."\n" ; 
		break;
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 1): 
			$result = $this->js_adm_research_project."\n"; 
		break;
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 2): 
			$result = $this->js_adm_additional_programme."\n"; 
		break;	
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 3): 
			$result = $this->js_adm_doc_training."\n"; 
		break;	
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 4): 
			$result = $this->js_adm_supervisory_panel."\n"; 
		break;		
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 5): 
			$result = (
						( class_exists('SignatureLink') ) && 
							is_object(SignatureLink::getSessionSignature()) ? 
							'' : 
							$this->js_adm_signatures."\n" 
			);
		break;			
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 6): 
			$result = $this->js_adm_submit."\n"; 
		break;	
		case $this->getKeysInArray($this->menu_adm->addminssionMenu(), 7): 
			$result = $this->js_adm_ucl."\n"; 
		break;	
	}
	return $result;	
 }
 
 public function myDoctoralTrainingJS() {
	$result =  '';  
	$doc_training = (isset($_GET[GET_LINK_DOCTORAL_TRAINING]) ? $_GET[GET_LINK_DOCTORAL_TRAINING] : '');
	switch($doc_training) {
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 0): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training."\n".
						$this->js_doc_training_status."\n".
						$this->js_jquery_ui."\n";
		break;	
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 1): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training."\n".
						$this->js_doc_training_conferences."\n".
						$this->js_jquery_ui."\n"; 
		break;	
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 2): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training_journal_papers."\n".
						$this->js_doc_training."\n".
						$this->js_jquery_ui."\n"; 
		break;	
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 3): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training_courses."\n".
						$this->js_doc_training."\n".
						$this->js_jquery_ui."\n"; 					  
		break;																  
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 4): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training_seminars."\n".
						$this->js_doc_training."\n".
						$this->js_jquery_ui."\n"; 					  
		break; 															  
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 5): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training_teaching_and_supervisory."\n".
						$this->js_doc_training."\n".
						$this->js_jquery_ui."\n"; 
		break;														  
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 6):
			$result = $this->js_jquery."\n".
						$this->js_doc_training."\n".
						$this->js_doc_training_submit."\n".
						$this->js_jquery_ui."\n"; 
		break;	
		case $this->getKeysInArray($this->doc_training->docTrainingMenu(), 7): 
			$result = $this->js_jquery."\n".
						$this->js_doc_training."\n".
						$this->js_doc_training_detail."\n".
						$this->js_jquery_ui."\n"; 
		break;		
	}
	return $result;	
 }
 
 public function confirmationJS() {
	$result =  '';
	$private = (isset($_GET[GET_LINK_CONFIRMATION]) ? $_GET[GET_LINK_CONFIRMATION] : '');
	switch($private) {
		case $this->getKeysInArray($this->menu_conf->confirmationMenu(), 0): 
			$result = $this->js_jquery.
						$this->js_jquery_ui."\n".
						$this->js_jquery_plugin."\n".
						$this->js_jquery_countdown."\n" ;
		break;
		case $this->getKeysInArray($this->menu_conf->confirmationMenu(), 1): 
			$result = $this->js_jquery."\n".
						$this->js_jquery_ui."\n".
						$this->js_conf_planning."\n";
		break;
		case $this->getKeysInArray($this->menu_conf->confirmationMenu(), 2): 
			$result = $this->js_jquery."\n".
						$this->js_jquery_ui."\n".
						$this->js_conf_result. "\n".
						$this->js_jquery_ui."\n";
		break;	
		
	}
	return $result;	
 }
 
 public function privateDefenceJS() {
	$result =  '';
	$private = (isset($_GET[GET_LINK_PRIVATE_DEFENCE]) ? $_GET[GET_LINK_PRIVATE_DEFENCE] : '');
	switch($private) {
		case $this->getKeysInArray($this->menu_private_defence->privateDefenceMenu(), 0): 
			$result = $this->js_jquery."\n".
						$this->js_private_home."\n". 
						$this->js_jquery_ui."\n" ; 
		break;
		case $this->getKeysInArray($this->menu_private_defence->privateDefenceMenu(), 1): 
			$result = $this->js_jquery."\n".
						$this->js_private_jury_members."\n".
						$this->js_jquery_ui."\n"; 
		break;
		case $this->getKeysInArray($this->menu_private_defence->privateDefenceMenu(), 2): 
			$result = $this->js_jquery."\n".
						$this->js_jquery_ui."\n".
						$this->js_private_signatures."\n"; 
		break;	
		case $this->getKeysInArray($this->menu_private_defence->privateDefenceMenu(), 3): 
			$result = $this->js_jquery."\n".
						$this->js_private_submit."\n".
						$this->js_jquery_ui."\n" ; 
		break;		
		case $this->getKeysInArray($this->menu_private_defence->privateDefenceMenu(), 4): 
			$result = $this->js_jquery."\n".
						$this->js_private_status."\n".
						$this->js_jquery_ui."\n" ; 
		break;			
	}
	return $result;	
 }
 
 public function publicDefenceJS() { 
	$result =  '';
	$public = (isset($_GET[GET_LINK_PUBLIC_DEFENCE]) ? $_GET[GET_LINK_PUBLIC_DEFENCE] : '');
	switch($public) {
		case $this->getKeysInArray($this->menu_public_defence->publicDefenceMenu(), 0): 
			$result = $this->js_jquery."\n". 
						$this->js_my_phd_public_defence_home."\n".
						$this->js_jquery_ui."\n"; 
		break;
	}
	return $result;
 } 
	
 private function _adminManagementJS() {  
	$result = '';
	$mng = (isset($_GET[GET_LINK_MANAGEMENT]) ? $_GET[GET_LINK_MANAGEMENT] : null);
	if(is_null($mng)) { return ;}
		  
	switch($mng) {
	
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 0): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";						
																						   
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 1): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";						
																						   
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 2): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";	
																						   
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 3): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";	
																						   
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 4): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_admin_mail."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";						
																						   
		case $this->getKeysInArray($this->menu_manage_admin->manageAdminMenu(), 5): 
			return $this->js_admin_mng."\n".
					$this->js_admin_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";	
																						   
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 0): 
			return $this->js_user_mng."\n".
					$this->js_search_user."\n".
					$this->js_user_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n".
					$this->js_show_list."\n";  
		
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 1): 
			return $this->js_user_mng."\n".
					$this->js_user_wp_form."\n". 
					$this->js_user_management."\n". 
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";					
																						 
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 2): 
			return $this->js_user_mng."\n".
					$this->js_user_wp_list."\n".
					$this->js_user_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";
																						 
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 3): 
			return $this->js_user_mng."\n".
					$this->js_search_user."\n".
					$this->js_user_management."\n". 
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n"; 
																						 																			
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 4): 
			return $this->js_user_mng."\n".
					$this->js_institute."\n".
					$this->js_user_management."\n".
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";					
		
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 5): 
			return $this->js_user_mng."\n".
					$this->js_search_user."\n".
					$this->js_user_management."\n". 
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";  
																						 
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 6): 
			return $this->js_user_mng."\n". 
					$this->js_user_management."\n". 
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";
																						 
		case $this->getKeysInArray($this->menu_manage_user->manageUserMenu(), 7): 
			return $this->js_user_mng."\n". 
					$this->js_user_management."\n". 
					$this->js_jquery."\n".
					$this->js_jquery_ui."\n";																																							 
	}	 
 }

 private function setButtonLeft($page) {  
	$s_page = str_replace('_', ' ', $page);
	if(in_array(strtoupper($s_page), $this->convertArrayOupper())) {
		$this->page_real = $page;
	} else {
		$this->linkDefault($page);
	 }
 }
 
 private function linkDefault($p)  {
 
	$a = array('my_space_connect','disconnect', 'pwd_forgot', 'get_upload', 'management_user', 'management_admin', 'link_signatures');
	if(in_array($p, $a)) {
		$this->page_real = $p;
	} else {
		return ;
	}
 }
 
 private function convertArrayOupper() {
	$a = array();
	$arr = array_keys($this->displayButtonLeft());
	foreach($arr as $k) {
		array_push($a, strtoupper($k));
	}
	return $a;
 }
 
 public function getLinkSignatures() {
	if(is_array( $p = parse_url(Main::currentPageURL()) )) { 
		if(isset($p['query']) ) {
			if ( preg_match("/link_signatures/", $p['query']) ) { 
				$exp = explode ( '&', $p['query']);
				if('link_signatures' == $exp[0]) {
					return ($this->page_real = $exp[0]);
				} 
			}
		}	
	}
 }
 
 private function getButtonsLeft() { 
	$this->getLinkSignatures();
	if(isset($_GET['page'])) {
		return $this->setButtonLeft($_GET['page']); 
	} else {
		 
		return $this->setButtonLeft($this->page_default); 
	}	
 }  
 
 private  function displayButtonLeft() {
	return $GLOBALS['sst']['button_left'];
}

 public function getDisplayButtonLeft() {
	return $GLOBALS['sst']['button_left'];
 }
 
 public function showText($position, $module=null) {
	$s = $GLOBALS['sst']['lang'][$this->getLang()][$position];
	return utf8_encode($s);
 }

 public function getStateSelect() {
	return $GLOBALS['sst']['state'];  
}

 public function displayButtonLeftAdmin() {
	if (class_exists('AdminAuthority')) {
		if(AdminAuthority::isSessionAdminSudo()) {   
			return  $GLOBALS['sst']['button_left_admin'];
		} else if(AdminAuthority::isSessionAdminSimple()) { 
			$admin = new AdminAuthority( ); 
			$data = $admin->getDataWP();
			if($data['pw_adm'] == 0) {
				array_pop($GLOBALS['sst']['button_left_admin']);
				return $GLOBALS['sst']['button_left_admin'];
			} else {
				return $GLOBALS['sst']['button_left_admin'];
			}
		} else {
			return false;
		}
	}	
}

 public function setLeftMenu() {
	$_SESSION['POST_BUTTON_LEFT'] = 3;
	$this->getLeftMenu();
 }
 
 private function getLeftMenu() {
	if(is_array($this->displayButtonLeft())) { 
	
		print('<div style=" 
						 
						background:#ebebeb; ">');
		print('<div style=" 
						padding: 7px;margin:5px;
						font-weight: bold;   background-color: #145A66; color:white;"> NAVIGATION  </div>');
		
		print('</div>');


		print ('<div id="cssmenuleft">    <ul class="button_left">');
		print($this->displayMenuAdmin());
		if((isset($_SESSION['SST_GUID']))  && ( $_SESSION['SST_GUID'] == 'empty')) { 
		 // show menu admin
		  
		} else {   
			$dbh = new ConnectDB();
			$r = $dbh->selectStatus(null, null); // $r['position'], $r['position_phd']
			$this->getLeftMenuPrincipal($r['position'], $r['position_phd']); 
		}
		print('</ul></div> ');
	} else {
		return;
	}
 }

 public function createIndexInArray($array) {
	$arr = array();
	$i = 0;
	while(count($array) > $i) { 
		$arr['key'][$i] = $this->getKeysInArray($array, $i);
		$arr['val'][$i] = $this->getValuesInArray($array, $i);
		$i++;
	}
	return $arr;
 }
 
 private function getLeftMenuPrincipal($step_1=0, $step_2=0) {  
	$supervisory = new Supervisor();
	$dbh = new ConnectDB();
	$main = new Main();
	$visited = new Visited($dbh, $main);
	$admin = new AdminAuthority( ); 
	
	$status = $dbh->selectStatus(null, null); //$status['position']

	$counter  = 1; $j = 0; 
	$position_1 = (Supervisor::isSessionSupervisor() ? 2 : ((AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) ? 2 : $step_1));
	$position_2 = (Supervisor::isSessionSupervisor() ? 0 : ((AdminAuthority::isSessionAdminSudo() || AdminAuthority::isSessionAdminSimple()) ? 4 : $step_2) );
	$pos = 0; 
	$h = 7; 
	 
	foreach($arr = $this->displayButtonLeft() as $k => $v) { 				
		if(!ConnectDB::isSession() ) {
			print($counter == 4 ? '' : '<li class="btn_left_inact"> <span data-bubble="'.$this->showText('link_not_active').'">'.$k.'</span> </li>'."\n") ;
		} else {
			if($counter == 4 && $position_1 != 0 )  {
				//  menu my phd
				print  $this->menuLeftHTMLMyPhD($arr['IN_MY_PHD'], $position_2);
			} else {
				if(!is_array($this->activationPosition($position_1))) $this->disconnectPage(); 
				if(in_array($counter, $this->activationPosition($position_1))) { // 
 
					if(Supervisor::isSessionSupervisor()) {
					 
						if($this->getKeysInArray($this->displayButtonLeft(), 5) == $k) {  
							print(' <li class="btn_left_act" ><a  href="'.$v.'" '.$this->getStylePosition($counter).'>'.$k.'</a></li>'."\n");
						} else {   
							print(' <li class="btn_left_inact"><span data-bubble="'.$this->showText('link_not_active').'">'.$k.'</span> </li>'."\n");
						}
					} else {
						/* this is visited menu... */
						$vis = $visited->checkAllHorisontMenu($k, $this);
						  
						print( '<li class="btn_left_act" >' ); 
						print( '<a  href="'.$v.'" '.$this->getStylePosition($counter).'>'.$k); 
						
						$wp_data = $admin->getDataAdminSimpleWP();
						if( $wp_data['wp_data']['mod'] != 2) {
							print( $admin->getIMGWP(($pos > 3 ? $h++ : $pos), 'IMG')); 
						}  
						print( '</a>');
						print( (isset($vis['img']) ?  $main->getSrcImg($vis['img'], 'width="30"', null, $vis['onclick']) : '' ));
						print( (isset($vis['html']) ? $vis['html'] : '' ));
						print( '</li>'."\n");
						}
				} else {
					if($counter == 8) {
						print('<li class="btn_left_act"><a  href="'.$v.'" '.$this->getStylePosition($counter).'>'.$k.'</a></li>'."\n");
					}else if($counter == 9) {
						if( $main->authenticity()) {
							//print('<li class="btn_left_act">...<a style="color:red" href="'.$v.'" '.$this->getStylePosition($counter).'>'.$k.'</a></li>'."\n");
						}
					} else {
						print('<li class="btn_left_inact"> <span data-bubble="'.$this->showText('link_not_active').'">'.$k.'</span> </li>'."\n");
					}
					 
				}
			}
		}	
		$counter+=1; $j++;	$pos++;
	}
 }

 private function displayMenuAdmin() {
	$html = '';
	if(is_array($r_admin_menu = $this->displayButtonLeftAdmin())) { 
		foreach($r_admin_menu as $admin_k => $admin_v) {
			$html .= '<li class="btn_left_act"  ><a href="'.$admin_v.'" style="color:red!important;">'.$admin_k.'</a></li>';
		}	
	}
	return $html;
 }

 public function getStylePosition($counter) {
	$dbh = new ConnectDB();
	$status = $dbh->selectStatus(null, null);
	
	if(!isset($this->arr_activation[$status['position']])) { $this->disconnectPage(); }
	return ((((AdminAuthority::isSessionAdminSudo()) || (AdminAuthority::isSessionAdminSimple()))) ?
		(in_array($counter, $this->arr_activation[$status['position']]) ? 'style="color:#05435C;"' : 'style="color:#878787;"' ) : ''); 
 }

 public function getStylePositionPhD($counter) {
	$dbh = new ConnectDB();
	$status = $dbh->selectStatus(null, null);
	return ((((AdminAuthority::isSessionAdminSudo()) || (AdminAuthority::isSessionAdminSimple()))) ?
			(in_array($counter, $this->arr_activation_phd[$status['position_phd']]) ? 'style="color:#5AAD6D;"' : 'style="color:#878787;"' ) :
			'style=" "');	
 }

 public function menuLeftHTMLMyPhD($arr, $step=0) {
	$dbh = new ConnectDB();

	$status = $dbh->selectStatus(null, null);
	$html = '<ul class="button_left deep"   style="margin: 10px 10px 10px 20px;  ">';
	$counter = 1;
	// admin always = 4 user 1, or 2, or 3, or 4 
	foreach($arr as $key => $val) {
		$link = '';
		 switch ($key) { // this is mod !!!
			case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 0):    //'ADMISSION'
				$h_menu = $this->menu_adm->addminssionMenu();
				$link = '&'.GET_LINK_ADMISSION.'='.$this->getKeysInArray($h_menu, 0); 
				$html .= $this->getPhDlink($link, 
											$val, 
											$key, 
											$counter, 
											$step, 
											(is_array($submitted_img = $dbh->iconStatusSubmitted(1)) ? 
											isset($submitted_img['icon']) ? $submitted_img['icon'] : '<span style="color:red;"> ERROR ICON </span>' :
											''), 
											$h_menu, 
											3) ;
											
            break;
			case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 1): //'CONFIRMATION':
				$h_menu = $this->menu_conf->confirmationMenu();
				$link = '&'.GET_LINK_CONFIRMATION.'='.$this->getKeysInArray($h_menu, 0); 
				$html .= $this->getPhDlink($link,
											$val,
											$key,
											$counter,
											$step,
											(is_array($submitted_img = $dbh->iconStatusSubmitted(2)) ? $submitted_img['icon']: ''),
											$h_menu,
											4, (is_array($submitted_img = $dbh->iconStatusSubmitted(21)) ? $submitted_img['icon']: '')) ;
			break;
			case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 2): //'PRIVATE DEFENCE':
				$h_menu = $this->menu_private_defence->privateDefenceMenu();
				$link = '&'.GET_LINK_PRIVATE_DEFENCE.'='.$this->getKeysInArray($h_menu, 0); 
				$html .= $this->getPhDlink($link,
											$val,
											$key,
											$counter,
											$step,
											(is_array($submitted_img = $dbh->iconStatusSubmitted(3)) ? $submitted_img['icon']: ''),
											$h_menu,
											5) ;
			break;
			case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 3): //'PUBLIC DEFENCE':
				$h_menu = $this->menu_public_defence->publicDefenceMenu();
				$link = '&'.GET_LINK_PUBLIC_DEFENCE.'='.$this->getKeysInArray($h_menu, 0); 
				$html .= $this->getPhDlink($link,
											$val,
											$key,
											$counter,
											$step, 
											(is_array($submitted_img = $dbh->iconStatusSubmitted(4)) ? $submitted_img['icon']: ''), 
											'get',
											6) ;
			break;
		}	
		$counter++;
	} 
	$html .= '</ul>';
	return $html;
 }
 
 public function getPhDlink($link, $val, $key, $counter, $step, $img=null, $h_menu='get', $pos=0, $new=null) {
	$main = new Main();  
	$admin = new AdminAuthority( ); 
	$dbh = new ConnectDB();
	$visited = new Visited(new ConnectDB(), new Main());
	$vis = $visited->getInfoVisitedHorisontMenu($key, $h_menu);
	$m = (in_array($counter, $this->activationPositionPhD($step)) ? 
			'<a href="'.$val.$link.'" '.$this->getStylePositionPhD($counter).'  >'.$key.'</a>' : 
			'<span style="color:#878787" data-bubble="'.$this->showText('link_not_active').'">'.$key.' </span>');
			$wp_data = $admin->getDataAdminSimpleWP();
			$wp_img = '';
			if( $wp_data['wp_data']['mod'] != 2) {
			$wp_img = $admin->getIMGWP($pos, 'IMG');		
			}
	return '<li style="margin-top:7px" >'.
			$m.$wp_img.$img.$new.(isset($vis['img']) ? $main->getSrcImg($vis['img'], null, null, $vis['onclick']) : '' ).
			( is_array($locked = $dbh->pHdLocked($pos-2, null, 'locked32')) ? $locked['icon'] : '' ).
			(isset($vis['html']) ? $vis['html'] : '' ) .'</li>';
 }
 
 public function getNameLinkInMyPHD() {
	$a = array();
	if(is_array($arr = $this->displayButtonLeft())) {
		
		foreach($arr['IN_MY_PHD'] as $k => $v) {
			$exp = explode(strtolower(GET_LINK_IN_MY_PHD)."=", $arr['IN_MY_PHD'][$k]);
			$a[] = $exp[1]; 
		}
		 
	}
	return $a;
 }
 
 // get the right menu example => ([0] =  (MY PROFILE) [1]= (?page=my_profile))
 function menuLeftWhereIam($index=0, $all=false) {
 
	$arr = $this->getDisplayButtonLeft();

	$count = 0;
	foreach($arr as $k => $v) {
		
		if(!is_array($v) ) $add[$count] = array(0 => $k, 1=> $v ); 
		 
		if($k == 'IN_MY_PHD') {
			 
			foreach($arr['IN_MY_PHD'] as $key => $val ) { 
				$add[$count] = array(0 => $key, 1=> $val ); 
				$count++;	
			}
			
		}
		 
		if( is_array($v) ) continue;  
			$count++;
	}
	
	if($all == true) { return $add; }
	
	return (isset($add[$index]) ? $add[$index] : null);
	
 }
 
 public function getArrayIndexInMyPHD() {
	if(is_array($arr = $this->displayButtonLeft())) {
		  return $arr['IN_MY_PHD'];
	}
 }
 
 public function goToPageInMyPHD($name_page, $module) {
	foreach($my = $this->getNameLinkInMyPHD() as $k => $v ) { 
		if($name_page == $my[$k]) {
		$path = 'modules/'.$module.'/pages/'.$my[$k].'.php';
			if(file_exists($path)) {
				include_once($path);
				break;
			} 
		}
	}	
 }
 // Home - Research project - Additional programme - Signatures - Submit - Result and log
 public function goToPageSimple($name_page, $module, $folder=null) {
 
	if($folder == null ) { 
		$folder = ''; 
	} else { 
		$folder = $folder.'/';
	}
		
	$path = 'modules/'.$module.'/pages/'.$folder.$name_page.'.php';
	if(file_exists($path)) {
		include_once($path);
	}
 }
 
public function getValuesInArray($array, $index) {
	if(is_array($array)) {
		$smp = array_values(array_slice($array, $index, 1, true));
		return array_pop($smp);
	}	
}

public function getKeysInArray($array, $index) {
	if(is_array($array)) {
		$smp = array_keys(array_slice($array, $index, 1, true));
		return array_pop($smp);
	}	
}

// menu ADMISSION = 0, CONFIRMATION = 1,  PRIVATE DEFENCE = 2, PUBLIC DEFENCE = 3
 private function displayJSInMyPHD() {
  
	$link = (isset($_GET[strtolower(GET_LINK_IN_MY_PHD)]) ? $_GET[strtolower(GET_LINK_IN_MY_PHD)] : null );
	$index = $this->getNameLinkInMyPHD();
	$result = '';
	switch($link) {
		case $index[0]: 
			$result = (
						(class_exists('SignatureLink')) && is_object(SignatureLink::getSessionSignature()) ? 
							$this->link_signatures."\n".
							$this->js_jquery."\n".
							$this->js_jquery_ui."\n": 
							$this->js_my_phd_admission."\n".
							$this->js_jquery."\n".
							$this->js_jquery_ui."\n"
			);
		break;
		case $index[1]: 
			$result = $this->js_my_phd_confirmation."\n" ; 
		break;
		case $index[2]: 
			$result = $this->js_my_phd_private_defence."\n" ; 
		break;
		case $index[3]: 
			$result = $this->js_my_phd_public_defence."\n" ; 
		break;
	}
	return $result;
 }
 
 public function displayJavaScript($page_script) {  
	$result = "";
	switch($page_script) {
		case "my_space_connect":        
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_my_space_connect."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;										  
		case "my_profile":              
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_track."\n".
						$this->js_my_profile."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;	
		/*
		case "get_upload":				
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_jquery."\n";		
		break;		
		*/
		case "my_academic_cv":          
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n".
						$this->js_my_academic_y."\n";
		break;										  
		case "my_phd":                  
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n". //  
						 
						$this->js_track."\n".
						$this->js_my_phd."\n";
		break;										  
		case "my_supervisory_panel":    
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_my_supervisory_panel."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;									  
		case "my_doctoral_training":    
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						 
						$this->js_my_doctoral_training."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";    
		break;										  
		case "my_additional_programme": 
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_my_additional_programme."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;										  
		case "my_cotutelle":            
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_track."\n".
						$this->js_my_cotutelle."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;
		case "my_annual_reports":            
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_my_annual_reports."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;
		
		 
		case "my_log":            		
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";          
		break;										  
		case "pwd_forgot":				
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_pwd_forgot."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;									  
		case "link_signatures";			
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->link_signatures."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break;			
		case "default":                 
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
		break; 										  
		default:                        
			$result = $this->js_ajax."\n".
						$this->js_text."\n".
						$this->js_dialog."\n".
						$this->js_main."\n".
						 
						$this->js_jquery."\n".
						$this->js_jquery_ui."\n";
						$this->js_jquery_ui."\n";
		break;
    }
	 $result = $this->jq_min.$result.$this->js_responsive."\n";
    return $result;
 }
 private function displayPage($name_page) { 
	  
	 if($name_page == 'link_signatures') {
		//echo 'please try again later '. $name_page;
		//exit ; 
	 }
	 if($name_page == 'my_doctoral_training') {
		 //echo 'please try again later '. $name_page;
		 //exit ; 
	 }
	  
	switch($name_page) {		
		case "my_space_connect":        
			include_once'modules/my_space_connect/pages/my_space_connect.php';               
		break;
		case "my_profile":              
			include_once'modules/my_profile/pages/my_profile.php';                           
		break;
		case "my_academic_cv":          
			include_once'modules/my_academic_cv/pages/my_academic_cv.php';                   
		break;
		case "get_upload":          	
			include_once'modules/my_academic_cv/pages/get_upload.php';                       
		break;
		case "my_phd":                  
			include_once'modules/my_phd/pages/my_phd.php';                                   
		break;
		case "my_supervisory_panel":    
			include_once'modules/my_supervisory_panel/pages/my_supervisory_panel.php';       
		break;
		case "my_doctoral_training":    
			include_once'modules/my_doctoral_training/pages/my_doctoral_training.php';      
		break;
		case "my_additional_programme": 
			include_once'modules/my_additional_programme/pages/my_additional_programme.php'; 
		break;
		case "my_cotutelle":            
			include_once'modules/my_cotutelle/pages/my_cotutelle.php';                       
		break;
		case "my_annual_reports":            
			include_once'modules/my_annual_reports/pages/my_annual_reports.php';                       
		break;
		case "my_log":                  
			include_once'modules/my_log/pages/my_log.php';                       
		break;
		case "pwd_forgot":              
			include_once'modules/pwd_forgot/pages/pwd_forgot.php';                           
		break;
		case "management_user":         
			include_once'modules/admin/pages/management_user.php';                   
		break;
		case "management_admin":		
			include_once'modules/admin/pages/management_admin.php';                  
		break;
		case "disconnect":   
			self::disconnectPage();
		case "link_signatures":			
			include_once'modules/link_signatures/display.php';                  
		break;                  													
		default:                        
			include_once('modules/default/pages/'.$this->page_default.'.php');       
		break;
    }
 }
 
 public function displayHeader() { 
	include_once(self::HEADER_DIR);
 }
 
  public function displayFooter() { 
	include_once(self::FOOTER_DIR);
 }
 // default language   
 public function getLang() {
	return 'en';
 }
 
 public static function disconnectPage() {
	if (class_exists('ConnectDB')) {
		$dbh = new ConnectDB();
		$dbh->writeLogFile(' [ PAGE IS: disconnect ] ', $GLOBALS['sst']['log'][17]); 
	}  
	self::disconn();
 }

public function getFullLeftMenu($main) {

	/*
	$class = new ReflectionClass('Main');
	$methods = $class->getMethods();
	var_dump($methods);
	*/
	
	$main = new Main();
	$main->array_f=null;
	$count = 0; 
	foreach($t = $this->getDisplayButtonLeft() as $k => $v) {  
		if( $this->getKeysInArray($t, $count) != 'IN_MY_PHD') { 
			switch($this->getKeysInArray($t, $count)) {
				case $this->getKeysInArray($GLOBALS['sst']['button_left'], 5): //'MY DOCTORAL TRAINING':
					$main->createArray($this->getKeysInArray($t, $count), array('get'));	
					foreach($this->doc_training->docTrainingMenu() as $kee => $va) {
						$main->createArray($this->getKeysInArray($t, $count), array($kee));	 
					}
				break;
				default:
					$main->createArray($this->getKeysInArray($t, $count), array('get'));	
			}
		} else {
			foreach($t[$k] as $ke => $va) { 
				switch($ke) {
					case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 0): //'ADMISSION':
						$main->createArray($ke, array('get'));
						foreach($this->menu_adm->addminssionMenu() as $key => $val) { 
							$main->createArray($ke, array($key));
							}	
					break;
					case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 1): //'CONFIRMATION':
						$main->createArray($ke, array('get'));	
						foreach($this->menu_adm->confirmationMenu() as $key => $val) {
							$main->createArray($ke, array($key)); 
						}
					break;
					case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 2): //'PRIVATE DEFENCE':
						$main->createArray($ke, array('get'));
						foreach($this->menu_adm->privateDefenceMenu() as $key => $val) { 
							$main->createArray($ke, array($key)); 
						}	
					break;
					case $this->getKeysInArray($GLOBALS['sst']['button_left']['IN_MY_PHD'], 3): //'PUBLIC DEFENCE':
							$main->createArray($ke, array('get'));	
							 
					break;
				}
			}		
		}
	$count++;
	}
	 return $main->getCreateArray();	
}

public static function exitPage($link=null) {
	if (!headers_sent()) {
		if($link == null) {
			$_SESSION = array(); 
			unset($_COOKIE[session_name()]); 
			session_destroy();
		}
		$link = ($link == null ? SERVER_NAME : $link);
		header('Location: '.$link);
		exit;
	}
}

public static function disconn() { 
	$_SESSION = array(); 
	unset($_COOKIE[session_name()]);  
	
	if(is_array($_COOKIE) ) {
		foreach ( $_COOKIE as $key => $value ) { 
			setcookie($key, NULL, 1, "/", DOMAIN_COOKIE);
		}
	}
	 
	if (!headers_sent()) {
		header('Location: '.DISCONNECT);
		session_destroy(); 

		exit;
	} else {
		print '<script> window.location.href="'.DISCONNECT.'"; </script>';
	}
 }
}
?>