// test ok ...

 this.DATE_FORMA_SIMPLE = "mm-yy";
this.DATE_FORMA_NORMAL = "d MM, yy";

this.JSON_FORMAT_TEST_DATE = 1 ; // 0 = data normal 1 = date comple
this.JSON_FORMAT_DATE_NORMAL = { dateFormat:  "d MM, yy" };
this.JSON_FORMAT_DATE_COMPLET = { changeMonth: true,  changeYear: true, dateFormat:  "d MM, yy", yearRange: "1950:2020"};
// JSON_FORMAT_TEST_DATE == 0 ? JSON_FORMAT_DATE_NORMAL : JSON_FORMAT_DATE_COMPLET 

this.FILE_SIZE_LIMIT = "31457280";   
this.FILE_TYPE = "*.pdf;";
this.FILE_UPLOAD_LIMIT = 10; 


this.txt = {
    'DIALOG' : {
        0 : "O'Key", //
        1 : "Hi, ADMIN",
		2 : "Good Luck",
		3 : "Connexion error: ",
		4 : "Do you really want to disconnect ?",
		5 : "Disconnect",
		6 : "Your data has been sent ",
		7 : "ERROR ",
		8 : "Do you really want to save this text? ",
		9 : "CONFIRM",
		
		"confirm" : "CONFIRM",
		"error"   : "ERROR",
		"dialog"  : "DIALOG",  
		"waiting" : "WAITING",   		
		"my_doctoral_training_home_update_5002"   : "Update has been executed....", // 
		"my_doctoral_training_home_error_5001"   : "Error please try again.",
		"my_doctoral_training_home_radio_5003"   : "Please select radio.",
    },
	'DIALOG_HELP' : {
		"mail" : "If you would like to reuse any content from New Scientist, either in print or online, please contact the syndication department first for permission.",
		"FirstName": "New Scientist does not own rights to photos, but there are a variety of licensing options available for use of articles and graphics we own the copyright to.",
		"100"   : "Diploma level: You must select this field ",
		"101"   : "Diploma official title...",
		"102"   : "Institution  ",
		"103"   : "Please select you country..",
		"104"   : "Awarding date: format date is  "+DATE_FORMA_NORMAL+" or "+DATE_FORMA_SIMPLE,
		"105"   : "Diploma date: format date is  "+DATE_FORMA_NORMAL+" or "+DATE_FORMA_SIMPLE,
		"106"   : "Obtained for diploma: ",
		"107"   : "PlEASE DOWNLOAD COPY OF DIPLOMA",
		"108"   : "Date of the thesis: Format <span style='color:red;'>"+DATE_FORMA_NORMAL+"</span>",
		"109"   : "Copie du rapport et  Rapport du doctorant", 
		"default"  : "Message Default",
		
		"my_doctoral_training_courses_type"          : "HELLO THIS IS MY my_doctoral_training_courses_type ",  
		"my_doctoral_training_courses_institution"   : "HELLO THIS IS MY my_doctoral_training_courses_institution ", 
		"my_doctoral_training_courses_title"         : "HELLO THIS IS MY my_doctoral_training_courses_title", 
		"my_doctoral_training_courses_date"          : "HELLO THIS IS MY my_doctoral_training_courses_date",    
		"my_doctoral_training_courses_participation" : "HELLO THIS IS MY my_doctoral_training_courses_participation",  
		"my_doctoral_training_courses_certificate"   : "HELLO THIS IS MY my_doctoral_training_courses_certificate", 
		"my_doctoral_training_courses_credits"       : "HELLO THIS IS MY my_doctoral_training_courses_credits",  
		"my_doctoral_training_courses_text"          : "HELLO THIS IS MY my_doctoral_training_courses_text", 
		
		"my_doctoral_training_conferences_name"          : "HELLO THIS IS MY my_doctoral_training_conference_name", //  
		"my_doctoral_training_conferences_type"          : "HELLO THIS IS MY my_doctoral_training_conference_type", // 
		"my_doctoral_training_conferences_place"         : "HELLO THIS IS MY my_doctoral_training_conference_place",  //  
		"my_doctoral_training_conferences_date"          : "HELLO THIS IS MY my_doctoral_training_conference_date", //  
		"my_doctoral_training_conferences_participation" : "HELLO THIS IS MY my_doctoral_training_conference_participation", //  
		"my_doctoral_training_conferences_certificate"   : "HELLO THIS IS MY my_doctoral_training_conference_certificate", //  
		"my_doctoral_training_conferences_list_documents": "HELLO THIS IS MY my_doctoral_training_conference_list_documents", //  
		"my_doctoral_training_conferences_type_title": "HELLO THIS IS MY my_doctoral_training_conference_type_title",
		"my_doctoral_training_conferences_type_select_add" : "HELLO THIS IS MY my_doctoral_training_conference_type_select_add", 
		"my_doctoral_training_conferences_dial_notice"     : "HELLO THIS IS MY my_doctoral_training_conference_dial_notice ",
		"my_doctoral_training_conferences_comment"         : "HELLO THIS IS MY my_doctoral_training_conference_comment ",
		"my_doctoral_training_conferences_number_credit"   : "HELLO THIS IS MY my_doctoral_training_conference_number_credit ",
		"my_doctoral_training_conferences_complete_ref"    : "HELLO THIS IS MY my_doctoral_training_conference_complete_ref ", //  
		"my_doctoral_training_conferences_title"           : "HELLO THIS IS MY my_doctoral_training_conference_title ",
		
		"my_doctoral_training_courses_title"           : "HELLO THIS IS MY my_doctoral_training_courses_title ", // 
		"my_doctoral_training_courses_institution"     : "HELLO THIS IS MY my_document_training_courses_institution ",  // 
		"my_doctoral_training_courses_type"     : "HELLO THIS IS MY my_document_training_courses_type ", // 
		"my_doctoral_training_courses_date"     : "HELLO THIS IS MY my_document_training_courses_date ", //   
		"my_doctoral_training_courses_participation"     : "HELLO THIS IS MY my_document_training_courses_participation ", 
		"my_doctoral_training_courses_certificate"     : "HELLO THIS IS MY my_document_training_courses_certificate ", 
		"my_doctoral_training_courses_credits"     : "HELLO THIS IS MY my_document_training_courses_credits ",
		"my_doctoral_training_courses_text"     : "HELLO THIS IS MY my_document_training_courses_text ", // 
		
		"my_doctoral_training_journal_papers_title"      : "HELLO THIS IS MY my_doctoral_training_journal_papers_title ", //   
		"my_doctoral_training_journal_papers_date"      : "HELLO THIS IS MY my_doctoral_training_journal_papers_date ", //     
		"my_doctoral_training_journal_papers_notice"   : "HELLO THIS IS MY my_doctoral_training_journal_papers_notice ", 
		"my_doctoral_training_journal_papers_file"                      : "HELLO THIS IS MY my_document_training_file ", //  
		"my_doctoral_training_journal_papers_credits"    : "HELLO THIS IS MY my_doctoral_training_journal_papers_credits ",
		
		"my_doctoral_training_seminars_function"    : "HELLO THIS IS MY my_doctoral_training_seminars_function ",
		"my_doctoral_training_seminars_title"    : "HELLO THIS IS MY my_doctoral_training_seminars_title ", // 
		"my_doctoral_training_seminars_type"    : "HELLO THIS IS MY my_document_training_seminars_type ",
		"my_doctoral_training_seminars_institution"    : "HELLO THIS IS MY my_document_training_institution ",
		"my_doctoral_training_seminars_date"    : "HELLO THIS IS MY my_document_training_seminars_date ",
		"my_doctoral_training_seminars_credits"    : "HELLO THIS IS MY my_doctoral_training_seminars_credits ", //    
		"my_doctoral_training_seminars_text"    : "HELLO THIS IS MY my_doctoral_training_seminars_text ",
		
		
		"my_doctoral_training_teaching_and_supervision_title"    : "HELLO THIS IS MY my_doctoral_training_teaching_and_supervision_title ",
		"my_doctoral_training_teaching_and_supervision_type"    : "HELLO THIS IS MY my_document_training_teaching_and_supervision_type ",
		"my_doctoral_training_teaching_and_supervision_institution"    : "HELLO THIS IS MY my_document_training_teaching_and_supervision_institution ",
		"my_doctoral_training_teaching_and_supervision_credits"    : "HELLO THIS IS MY my_doctoral_training_teaching_and_supervision_credits ", //
		"my_doctoral_training_teaching_and_supervision_text"    : "HELLO THIS IS MY my_doctoral_training_teaching_and_supervision_text ", 
		
		"my_doctoral_training_intermediate" : "HELLO THIS IS MY my_doctoral_training_intermediate", 
		"my_doctoral_training_submission"   : "HELLO THIS IS MY my_doctoral_training_submission", 
		"my_doctoral_training_final"        : "HELLO THIS IS MY my_doctoral_training_final",
		 
		// public defence  
		"public_defence_date"           : "<span style=\"color:red;\">DD-MM-YYYY 00:00</span>",  
		"public_defence_sammery"        : "HELLO THIS IS MY public_defence_sammery", //  
		"public_defence_photo"          : "HELLO THIS IS MY public_defence_photo",  
		"public_defence_thesis_time"    : "HELLO THIS IS MY public_defence_thesis_time", //  
		"public_defence_thesis_place"   : "HELLO THIS IS MY public_defence_thesis_place", // 
		"public_defence_jury_date_time" : "HELLO THIS IS MY public_defence_jury_date_time", // 
		"public_defence_jury_date_place": "HELLO THIS IS MY public_defence_jury_date_place", //  
		"public_defence_admin_place"    : "HELLO THIS IS MY public_defence_admin_place",  //  
		"public_defence_admin_thesis_num": "HELLO THIS IS MY public_defence_admin_thesis_num",   
		"public_defence_admin_money"    : "HELLO THIS IS MY public_defence_admin_money",   
		"public_defence_admin_auto_diff": "HELLO THIS IS MY public_defence_admin_auto_diff",  // 
		"public_defence_admin_generate" : "HELLO THIS IS MY public_defence_admin_generate",
		"public_defence_jury_members_title" : "HELLO THIS IS MY public_defence_jury_members_title",
		
		"private_defence_home_title" : "private_defence_home_place ",
		"private_defence_home_place"  : "private_defence_home_Place",  //////////////////////////////////////
		"private_defence_home_date" : "<span style=\"color:red;\"> HELLO THIS IS MY my "+this.DATE_FORMA_NORMAL+"</span>", 
		
		"private_defence_submit_board_title_admin" : "HELLO THIS IS MY private_defence_submit_board_title_admin",
		"private_defence_submit_board_title_user" : "HELLO THIS IS MY private_defence_submit_board_title_user",
		"private_defance_result_select_admin" : "HELLO THIS IS MY private_defance_result_select_admin",
		"private_defance_result_select_user" : "HELLO THIS IS MY private_defance_result_select_user", // private_defance_status_textarea
		"private_defance_status_textarea" : "HELLO THIS IS MY private_defance_status_textarea",
		
		
		"admission_signature_upload" : "HELLO THIS IS MY admission_signature_upload",
		
		"my_supervisory_panel_title_supervisory" : "HELLO THIS IS MY my_supervisory_panel_title_supervisory",
		
		"my_supervisory_panel_header_supervisory_panel": "HELLO THIS IS MY my_supervisory_panel_header_supervisory_panel", 
		"my_supervisory_panel_header_supervisory_panel_member": "HELLO THIS IS MY my_supervisory_panel_header_supervisory_panel_member", 
		
		"my_profile_reference_title": "HELLO THIS IS MY my_profile_reference_title",  //    my_profile_pwd     
		"my_profile_mail": "HELLO THIS IS MY my_profile_mail", 
		"my_profile_mobile": "HELLO THIS IS MY my_profile_mobile", 
		"my_profile_birthplace": "HELLO THIS IS MY my_profile_birthplace", 
		"my_profile_birth_date": "HELLO THIS IS MY my_profile_birth_date", 
		"my_profile_PhD_domain": "HELLO THIS IS MY my_profile_PhD_domain",
		"my_profile_sciences": "HELLO THIS IS MY my_profile_sciences", 
		"my_profile_last_name": "HELLO THIS IS MY my_profile_last_name",
		"my_profile_first_name": "HELLO THIS IS MY my_profile_first_name", 
		"my_profile_pwd": "HELLO THIS IS MY my_profile_pwd", 		//  
		"my_profile_institution": "HELLO THIS IS MY my_profile_institution", 		//  
		"my_profile_contact_tel": "HELLO THIS IS MY my_profile_contact_tel", 		// 
		 
		
		
		
		
		
		
		"my_academic_cv_diploma_level": "HELLO THIS IS MY my_academic_cv_diploma_level",
		"my_academic_cv_diploma_official_title": "HELLO THIS IS MY my_academic_cv_diploma_official_title",
		"my_academic_cv_institution": "HELLO THIS IS MY my_academic_cv_institution",
		"my_academic_cv_country": "HELLO THIS IS MY my_academic_cv_country",
		"my_academic_cv_awarding_date": "HELLO THIS IS MY my_academic_cv_awarding_date",
		"my_academic_cv_diploma_date": "HELLO THIS IS MY my_academic_cv_diploma_date",
		"my_academic_cv_obtained_for_diploma": "HELLO THIS IS MY my_academic_cv_obtained_for_diploma",
		"my_academic_cv_num_of_cr_years_for_diploma": "HELLO THIS IS MY my_academic_cv_num_of_cr_years_for_diploma",
		"my_academic_cv_ects": "HELLO THIS IS MY my_academic_cv_ects",
		"#my_academic_cv_ects_year": "HELLO THIS IS MY my_academic_cv_ects_year",
		"my_academic_cv_ects_non": "HELLO THIS IS MY my_academic_cv_ects_non",
		"my_academic_cv_ects_years": "HELLO THIS IS MY my_academic_cv_ects_years", // my_academic_cv_aca_title_year
		"my_academic_cv_please_download_diploma": "HELLO THIS IS MY my_academic_cv_please_download_diploma", 
		
		"my_academic_cv_aca_institution": "HELLO THIS IS MY my_academic_cv_aca_institution", 
		"my_academic_cv_aca_awarding_date": "HELLO THIS IS MY my_academic_cv_aca_awarding_date", 
		"my_academic_cv_aca_diploma_date": "HELLO THIS IS MY my_academic_cv_aca_diploma_date", 
		"my_academic_cv_aca_degree_level": "HELLO THIS IS MY my_academic_cv_aca_degree_level", 
		"my_academic_cv_aca_score": "HELLO THIS IS MY my_academic_cv_aca_score", 
		"my_academic_cv_aca_title_year": "HELLO THIS IS MY my_academic_cv_aca_title_year",  //  
		"my_academic_cv_aca_please_download_year": "HELLO THIS IS MY my_academic_cv_aca_download_year", 
		"my_academic_cv_aca_copy_year": "HELLO THIS IS MY my_academic_cv_aca_copy_year", //  
		"my_academic_cv_aca_squale_between": "HELLO THIS IS MY my_academic_cv_aca_squale_between",
		
		
		"my_phd_admission_home_preadmission": "HELLO THIS IS MY my_phd_admission_home_preadmission", 
		"my_phd_admission_home_admission": "HELLO THIS IS MY my_phd_admission_home_admission", 
		
		"my_phd_admission_research_project_title": "HELLO THIS IS MY my_phd_admission_research_project_title", //  
		"my_phd_admission_research_project_research_project": "HELLO THIS IS MY my_phd_admission_research_project_research_project", // 
 		
		"my_phd_admission_supervisory_panel_title": "HELLO THIS IS MY my_phd_admission_supervisory_panel_title", 
		"my_phd_admission_supervisory_panel_supervisory_panel": "HELLO THIS IS MY my_phd_admission_supervisory_panel_supervisory_panel", 
		
		"my_phd_admission_doctoral_training_act":"HELLO THIS IS MY my_phd_admission_doctoral_training_act",
		"my_phd_admission_doctoral_training_desc":"HELLO THIS IS MY my_phd_admission_doctoral_training_desc",
		"my_phd_admission_doctoral_training_place":"HELLO THIS IS MY my_phd_admission_doctoral_training_place",
		"my_phd_admission_doctoral_training_acronym":"HELLO THIS IS MY my_phd_admission_doctoral_training_acronym",
		"my_phd_admission_doctoral_training_ects":"HELLO THIS IS MY my_phd_admission_doctoral_training_ects",
		"my_phd_admission_doctoral_training_comment":"HELLO THIS IS MY my_phd_admission_doctoral_training_comment",  // 
		
		"my_phd_admission_ucl_reg":"HELLO THIS IS MY my_phd_admission_ucl_reg",
		
		
		
		"my_cotutelle_desc":"HELLO THIS IS MY my_cotutelle_description", 
		"my_cotutelle_upload":"HELLO THIS IS MY my_cotutelle_upload",

		"management_admin_config_dialog":"HELLO THIS IS MY menegement_admin_config_dialog", // 
		"management_admin_config_state":"HELLO THIS IS MY menegement_admin_config_state",
		
		"my_phd_confirmation_planning_deadline_for_conf":"HELLO THIS IS MY my_phd_confirmation_planning_deadline_for_conf", 
		"my_phd_confirmation_planning_request":"HELLO THIS IS MY my_phd_confirmation_planning_request", 
		"my_phd_confirmation_planning_newdeadline":"HELLO THIS IS MY my_phd_confirmation_planning_newdeadline", 
		"my_phd_confirmation_planning_justification":"HELLO THIS IS MY my_phd_confirmation_planning_justification", 
		
		"my_phd_confirmation_home_status":"HELLO THIS IS MY my_phd_confirmation_home_status", 
		 
		"my_phd_confirmation_result_date_confirm":"HELLO THIS IS MY my_phd_confirmation_result_date_confirm", 
		
		// 
	} 
};

function showText(module, position, revise, check) {
	if(revise != null) return revise;
	if(typeof this.txt[module] == 'undefined') {
		return ;
	} else {
		return this.txt[module][position];
	}	
}