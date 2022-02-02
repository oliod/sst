this.DATE_FORMA_SIMPLE = "mm-yy";
this.DATE_FORMA_NORMAL = "d MM, yy";
this.DATE_FORMA_NUMBER = "d MM, yy";

// { dateFormat: DATE_FORMA_SIMPLE }
this.JSON_FORMAT_TEST_DATE = 1 ; // 0 = data normal 1 = date comple
this.JSON_FORMAT_DATE_NORMAL = { constrainInput: true, dateFormat: "d MM, yy" };
this.JSON_FORMAT_DATE_COMPLET = { constrainInput: true, changeMonth: true,  changeYear: true, dateFormat:  "d MM, yy", yearRange: "1950:2030"};

// format: if date has been submitted 
this.JSON_FORMAT_DATE_SUBMIT = { constrainInput: true, dateFormat: "dd-mm-yy" };
this.JSON_FORMAT_DATE_NUMBER = { constrainInput: true, changeMonth: true,  changeYear: true, dateFormat:  "d-m-yy", yearRange: "1950:2020"};

// File configuration
this.FILE_SIZE_LIMIT = "31457280";   
this.FILE_TYPE = "*.pdf;";
this.FILE_UPLOAD_LIMIT = 10; 

this.txt = {
    'DIALOG' : {
        0 : "O'Key", //
        1 : "Welcome (Administrator Account)",
		2 : "Welcome !",
		3 : "Connection error ",
		4 : "Do you really want to disconnect ?",
		5 : "Disconnect",
		6 : "Your data has been sent",
		7 : "ERROR ",
		9 : "CONFIRM",
		
		"delete_downloaded_pdf_confirm" : "Do you really want to delete this file , if yes, it will be finally destroyed, continue?  ",
		"delete_downloaded_pdf_remove"  : "The file has been deleted. ",
		
		"downloaded_pdf_only"  : "Only PDF files can be uploaded here.",
		
		
		
		
		"link_signatures_cancel_1" : "If you do not want to sign this admission request, please contact the PhD candidate or supervisor.",
		"link_signatures_cancel_2" : "If you do not agree with the composition of the thesis board, please contact the PhD candidate, the supervisor or the CDD office.",
		"link_signatures_cancel_3" : "If you do not agree with the composition of the thesis board, please contact the PhD candidate, the supervisor or the CDD office.",
		"link_signatures_cancel_4" : "If you do not agree with the role of president of this thesis board, please contact the PhD candidate or the CDD office.",
		"link_signatures_cancel_update" : "Your choice has been notified to the PhD candidate. The application is closing.",
		"link_signatures_accept_update" : "Your choice has been notified to the PhD candidate. The application is closing.",
		
		"link_signatures_redirected" : "Please wait is redirected to the page...",
		"link_signatures_validate_1" : "You are about to sign the admission request.",
		"link_signatures_validate_2" : "You are about to sign the composition of the board. 2",
		"link_signatures_validate_3" : "You are about to sign the composition of the board. 3",
		"link_signatures_validate_4" : "Your agreement will confirm the role of the President of this thesis board.",
		
		"delete_file" : "File has been deleted.",
		
		"any_element_selected" : "Select the item that you want to remove",
		
		"impossible_remove"    : "It is impossible to remove elements",
		
		"connexion_6017" : " Your account has been blocked. Please contact the PhD secretariat. ",
		"connexion_6011" : " The PhD management system is currently unavailable. Please try later.",
		"connexion_6018" : " The user name or password you have typed is invalid. ",
		"connexion_6019" : " Your account has been locked. Please contact the PhD office. ",
		"connexion_6020" : " Application  has been locked. Please wait or go to another time. ",  
		"connexion_6021" : " There was a failure in the system. Please try again later. We regret the inconvenience ;(", 
		
		"confirm" : "CONFIRM",
		"error"   : "ERROR",
		"dialog"  : "DIALOG",  
		"waiting" : "WAITING",   	
		
		 
		"my_doctoral_training_status_update_5002"  : "Update has been executed....", // 
		"my_doctoral_training_status_error_5001"   : "Error please try again.",
		"my_doctoral_training_status_radio_5003"   : "Please select radio.",

		"my_doctoral_training_conferences_err_5001"   : " Error please try again ",
		"my_doctoral_training_conferences_update_5002"   : " The activity has been updated.",
		"my_doctoral_training_conferences_name_5003"   : " Please, give the name of the conference ",
		"my_doctoral_training_conferences_delete_5004"   : " You are about to permanently delete this activity. Please confirm. ",

		"my_doctoral_training_journal_papers_err_5001" : "Error please try again",
		"my_doctoral_training_journal_papers_update_5002"   : " The activity has been updated. ",
		"my_doctoral_training_journal_papers_delete_5003"   : " You are about to permanently delete this activity. Please confirm. ",
		"my_doctoral_training_journal_papers_name_5004"   : " Please, give the name of the journal papers",

		"my_doctoral_training_courses_err_5001"      : " Error please try again",
		"my_doctoral_training_courses_update_5002"   : " The activity has been updated.",
		"my_doctoral_training_courses_delete_5003"   : " You are about to permanently delete this activity. Please confirm.",
		"my_doctoral_training_courses_name_5004"     : " Please, give the name of the course.",

		"my_doctoral_training_seminars_err_5001"      : " Error please try again",
		"my_doctoral_training_seminars_update_5002"   : " The activity has been updated.",
		"my_doctoral_training_seminars_delete_5003"   : " You are about to permanently delete this activity. Please confirm.",
		"my_doctoral_training_seminars_name_5004"     : " Please, give the name of the seminars",

		"my_doctoral_training_teaching_and_supervision_err_5001"      : " Error please try again",
		"my_doctoral_training_teaching_and_supervision_update_5002"   : " The activity has been updated.",
		"my_doctoral_training_teaching_and_supervision_delete_5003"   : " You are about to permanently delete this activity. Please confirm.",
		"my_doctoral_training_teaching_and_supervision_name_5004"     : " Please, give the name of the activity ",

		"my_doctoral_training_detail_numeric_err_5001"      : " Only numbers are allowed in this field ",
		"my_doctoral_training_detail_select_err_5002"       : " Please select the activities you want to delete. ",
		"my_doctoral_training_detail_select_acc_err_5003"   : " Please select the activities you want to validate. ",
		"my_doctoral_training_submit_numeric_err_5001"      : " Only numbers are allowed in this field.", 
		"my_doctoral_training_submit_disc_5002"             : " Your decision has been communicated to the CDD office. You will now be disconnected from the management system.",
		"my_doctoral_training_submit_select_err_5003"       : " Please select the activities you want to reject. ", 
		"my_doctoral_training_submit_select_acc_err_5004"   : " Please select the activities you want to reject. ", 

		"adm_submit_but_submit"                        : "Data has been submitted",
		"adm_submit_response_server_create_link_error" : "An error has occurred while trying to connect to the server. Please try again.",
		"adm_submit_response_server_page_error"        : "Your admission file is incomplete or contains errors and cannot be submitted. You will now be directed to the next error in your admission file.",
		"adm_submit_confirm"                           : "You are about to submit your admission file. Please note that your admission file will be blocked until the decision of the PhD commission.",

		"adm_submit_response_empty_pdf"                : "Your academic CV is incomplete. Please check you have uploaded diploma certificates and transcript records as requested.",
		
		
		"adm_home_save_option"           : " Admission type has been saved. ",
		"adm_home_response_server_error" : " Error, please try again.",

		"adm_research_project_save_thesis"           : "Research project has been saved.",
		"adm_research_project_response_server_error" : "Some fields were not filled.",

		"adm_additional_programme_fields_error"             : "Error : Please check all fields. All fields must be filled...",
		"adm_additional_programme_saved"                    : "The additional programme has been saved. ",
		"adm_additional_programme_any_elems_selected_error" : "Please select one or more items to delete.",
		"adm_additional_programme_delete"                   : "Data has been deleted",
		
		"adm_doctoral_training_checkbox_error" : "Please select check-box, if you want to delete elements...",
		"adm_doctoral_training_save"           : "The doctoral training project has been saved.",
		
		"adm_supervisory_panel_delete_error"               : " Please select one or more members to delete.",
		"adm_supervisory_panel_save"                       : " Data has been saved",
		"adm_supervisory_panel_response_server_mail_error" : " Error please check mail",
		"adm_supervisory_panel_checkbox_error"             : " Please check the member(s) to whom an invitation to sign should be mailed.",

		"my_phd_confirmation_planning_submit"            : " You are about to submit the extension request for your confirmation. The confirmation data will be locked until approval by the CDD. Do you want to proceed ? ",
		"my_phd_confirmation_planning_validate"          : " Do you really want to validate this data? Continue? ",
		"my_phd_confirmation_planning_cancel"            : " Do you really want to cancel ? Continue? ",
		"my_phd_confirmation_planning_submit_err_5001"   : " Error please try again ",

		"my_phd_confirmation_result_submit_err_5001" : "Error please try again ",
		"my_phd_confirmation_result_submit_err_5002" : "Please upload your research report.",
		"my_phd_confirmation_result_submit_err_5003" : "Please upload the report of the supervisory panel.",
		
		"my_phd_confirmation_result_submit"   : "You are about to submit the results of your confirmation. The confirmation data will be locked until validation by the CDD.",
		"my_phd_confirmation_result_validate" : "You are about to validate the new confirmation status.",
		"my_phd_confirmation_result_cancel"   : "Do you want to re-open the confirmation? ",

		"my_phd_private_submit_err_5001" : "Error please try again ",
		"my_phd_private_submit_submit"   : "Do you really want to submit this data? Warning, data will be inaccessible. Continue? ",
		"my_phd_private_submit_validate" : "Do you really want to validate this data? Warning, data will be inaccessible. Continue? ",
		"my_phd_private_submit_cancel"   : "Do you really want to cancel this data? Continue?",

		"my_phd_private_defence_board_submit"                   : "You are about to submit the board composition for your private defence. The private defence data will be locked until approval by the UCL authorities.",
		"my_phd_private_defence_board_validate"                 : "You are about to validate the board composition. Please update the status of the private defence.",
		"my_phd_private_defence_board_cancel"                   : "You are about to re-open the private defense. Please update the status of the private defence.",
		"my_phd_private_defence_board_server_create_link_error" : "An error has occurred while trying to connect to the server. Please try again.",
		"my_phd_private_defence_board_server_page_error"        : "Your board composition is incomplete (e.g. missing signatures) and cannot be submitted. You will now be directed to the next error location.",
		
		"my_phd_private_defence_signatures_box_err" : "Please check the box in front of the members who should be contacted by the system.",
		"my_phd_private_defence_signatures_send"    : "An invitation to sign has been sent by email to the selected members.",
		
		
		
		"amd_signatures_sent" : "An email has been sent to this member. The status of the signature will change when the member has e-signed the admission request. ", 
		
		"my_profile_saved"       : "Your changes have been saved. We ask you to keep the address areas up to date during your whole PhD. ",
		"my_profile_sent"       : "Your data has been sent.",
		"my_profile_pwd_error"  : "Password Error",
		"my_profile_char_error" : "Error in field check character",

		"my_academic_cv_check_all_elems_error" : "Please make sure you have saved your changes.",
		"my_academic_cv_dip_save"              : "The data for this diploma has been updated. If you have not already done so, please upload the PDF copy of the diploma.", // 
		"my_academic_cv_diploma_saved"         : "The diploma has been saved", // 
		"my_academic_cv_year_save"	           : "The data for this year/semester has been updated. If you have not already done so, please upload the PDF copy of your transcripts records for this year.", // 	
		"my_academic_cv_year_saved"	           : "The year/semester has been saved", // 
		"my_academic_cv_dip_msg_error"         : "Some mandatory fields has not been filled.",
		"my_academic_cv_before_save_error"     : "Please save this diploma and try again.",
		"my_academic_cv_want_to_delete_empty"  : " You are about to delete this empty diploma. ",
		"my_academic_cv_want_to_delete"        : " You are about to delete this entire diploma (including year/semester data).  ? ",
		"my_academic_cv_want_to_delete_year"   : " You are about to delete this year/semester. ", 
		"my_academic_cv_msg_ok"                : " Message: OK",
		
		"my_academic_cv_create_diploma_error"  : " Some mandatory fields has not been filled or has not saved. Please check all fields and save.",
		"my_academic_cv_create_diploma" : "Please wait it is preparing new diploma.",
		
		"my_academic_cv_not_saved_diploma"  : "<span style='color:red;'> <b>Diploma was not saved, please check all Diplomas.</b></span>",
		"my_academic_cv_not_saved_academic" : "<span style='color:red;'> <b>Academic year was not saved, please check all Academic year.</b></span>",
		

		"file_deleted" : "This file has been deleted...",   

		"admin_pw_create_user_ok"                 : " Changes have been saved ",
		"admin_pw_create_user_error_pwd"          : " Error in field password , check this field",
		"admin_pw_create_user_error_pwd_char"     : " Error in field password , you can use chars:  a-z A-Z 0-9 . - = + ! ",
		"admin_pw_create_user_error_mail"         : " Error in field mail , check this field",
		"admin_pw_create_user_error_tel"          : " Error in field tel , check this field", 
		"admin_pw_create_user_confirm_activation" : " Do you really want to activate user? ",
		"admin_pw_create_user_been_activated"     : " User has been activated ",

		"admin_pw_list_delete_user"    : "Do you really want to lock this user access ? ",
		"admin_pw_list_been_deleted"   : "User has been deleted ",
		"admin_pw_list_send_mail_user" : "A new password will be generated and emailed to the user.",
		"admin_pw_list_been_sended"    : "An email has been sent to the user",

		"admin_show_list_unlock"    : "  Do you want to lock / unlock this user ? ",
		"admin_show_list_delete_user"    : " You are about to delete this user. This will erase ALL information related to the user. Please confirm.",
		
		"admin_authority_option_accepting"       : "Do you want really to accept ? ",
		"admin_authority_option_trying"          : " You are about to delete the signature. The user will have the possibility to re-invite the member. ",
		"admin_authority_option_exchangeing_txt" : "Do you really want to save this text?  ",

		"waiting"     : "Wait....",

		"responce_ok" : " The modification has been saved.",
		
		"management_open_folder"             : "Finder not showing user library folder you must go to the (MANAGEMENT USER)",
		"management_admin_info_status_user0" : "",
		"management_admin_info_status_user1" : "Please wait the application not available at this moment", 
		"management_admin_info_status_close" : "Please wait the application will be close ",
		
		"management_admin_config_err"            : "Error please try again ",  
		"management_admin_config_update"         : " Update was performed! ", 
		"management_admin_config_delete_content" : "Do you want really to delete? Warning file will be deleted. Continue?",
		"management_admin_config_save_content"   : " Do you want really to save this modification? Warning file will be created. Continue?",
		"management_admin_config_close_history"  : " Please close the dialog history ",
		
		"management_search_user_delete_user"      : " Do you really want to delete this user ? ", 
		"management_search_user_block_user"       : " Do you really want to block this user ?  ", 	
		"management_search_user_save_user"        : " Do you want to save research ? ",
		"management_search_user_provide_name"     : " Please provide a name for this search ? ", 
		"management_search_user_delete_query"     : " Do you want to delete query ?  ", 
		"management_search_user_nothing_selected" : " Nothing will be selected ", 
		"reload" : " Please wait, while the page is reloaded. ", 

		"my_supervisory_panel_save"       : "Your changes have been saved",
		"my_supervisory_panel_delete_err" : "Error impossible to delete",  
		"my_supervisory_panel_add_err"    : "Error impossible to add",
		
		"my_space_connect_error_1000" : "Please check all fields.",
		"my_space_connect_error_1001" : "Please check your E-mail.",
		"my_space_connect_error_1002" : "Your password should contain at least 6 characters ( a-z A-Z 0-9 _ . - = + ! ). ",
		
		"pwd_forgot": "Please check your mailbox. If you do not receive a new password. Try again", 
		"pwd_forgot_response_server" : "A new password has been sent to your mailbox.", 
		"pwd_forgot_format_mail_err" : "The value you typed is not an email address.", 
		
		"my_cotutelle_saved":"  Data has been saved. ",  
		"my_cotutelle_error":"  Please try again.  ",

		"auth_data_not_complete" : "Data can not be blocked. The data is not complete.",
		"auth_date_error"        : "Error, date is empty. ",
		
		"public_defence_server_try_again" : "Error please try again ",  
		"public_defence_saved" : " Has been saved !",
		"public_defence_default_status" : " Do you really want to change status and do it  by - Default state ?  ", 
		"public_defence_status_1" : " Do you really want to change status and do it by - ", 
		"public_defence_status_2" : " Do you really want to change status and do it by - ", 
		"public_defence_status_3" : " Do you really want to change status and do it by - ", 
		"public_defence_status_4" : " Do you really want to change status and do it by - Diploma has been delivered ? ", 
		
		
		"my_additional_save_err" : "Error : Please check all fields. All fields must be filled.",
		"my_additional_save" : "Changes has been saved.",
		"my_additional_element_err" : "Error Any element selected.",
		"my_additional_delete" : "Element has been deleted.",
		
		"my_annual_reports_save_err" : " Impossible to save because there are empty items.  ",  
		"my_annual_reports_save" : " Changes has been saved. ",  
		"my_annual_reports_element_err" : " Error Any element selected. ",  
		"my_annual_reports_delete" : " Element has been deleted. ",
		"my_annual_reports_last_elem" : " Impossible to delete. ",
		
    },
	'DIALOG_HELP' : {
		"mail" : "Please use a long-lasting email as it will be used to log in the application.",
		"re_type_mail" : "Please use a long-lasting email as it will be used to log in the application.",
		"mail_forgot" : " Please enter here the email address which is associated to your account.",
		"FirstName": "First name",
		"100"   : "Diploma level: You must select this field ",
		"101"   : "Diploma official title. ",
		"102"   : "Institution  ",
		"103"   : "Please select your country..",
		"104"   : "Awarding date: format date is  "+DATE_FORMA_NORMAL+" or "+DATE_FORMA_SIMPLE,
		"105"   : "Diploma date: format date is  "+DATE_FORMA_NORMAL+" or "+DATE_FORMA_SIMPLE,
		"106"   : "Obtained for diploma: ",
		"107"   : "Upload a copy of your diploma",
		"108"   : "Date of the thesis: Format <span style='color:red;'>"+DATE_FORMA_NORMAL+"</span>",
		"109"   : "Copie du rapport et  Rapport du doctorant", 
		"default"  : "Message Default",
		
		"dblclick_me_active" : "DBLCLICK ME",
		"dblclick_me_inactive" : "DIALOG",
		
		"my_doctoral_training_1" : "Intermediate submission",
		"my_doctoral_training_2" : "Submission before confirmation",
		"my_doctoral_training_3" : "Final submission",
		"my_doctoral_training_4" : " ",
		"my_doctoral_training_5" : " ",
		
		
		"my_doctoral_training_courses_type"          : " my_doctoral_training_courses_type ",  
		"my_doctoral_training_courses_institution"   : " my_doctoral_training_courses_institution ", 
		"my_doctoral_training_courses_title"         : " my_doctoral_training_courses_title", 
		"my_doctoral_training_courses_date"          : " my_doctoral_training_courses_date",    
		"my_doctoral_training_courses_participation" : " my_doctoral_training_courses_participation",  
		"my_doctoral_training_courses_certificate"   : " my_doctoral_training_courses_certificate", 
		"my_doctoral_training_courses_credits1"       : " my_doctoral_training_courses_credits1",  
		"my_doctoral_training_courses_text"          : " my_doctoral_training_courses_text", 
		
		"my_doctoral_training_conferences_name"          : " my_doctoral_training_conference_name",  
		"my_doctoral_training_conferences_type"          : " my_doctoral_training_conference_type",
		"my_doctoral_training_conferences_place"         : " my_doctoral_training_conference_place", 
		"my_doctoral_training_conferences_date"          : " my_doctoral_training_conference_date", 
		"my_doctoral_training_conferences_participation" : " my_doctoral_training_conference_participation",  
		"my_doctoral_training_conferences_certificate"   : " my_doctoral_training_conference_certificate",  
		"my_doctoral_training_conferences_list_documents": " my_doctoral_training_conference_list_documents",  
		"my_doctoral_training_conferences_type_title": " my_doctoral_training_conference_type_title",
		"my_doctoral_training_conferences_type_select_add" : " my_doctoral_training_conference_type_select_add", 
		"my_doctoral_training_conferences_dial_notice"     : " my_doctoral_training_conference_dial_notice ",
		"my_doctoral_training_conferences_comment"         : " my_doctoral_training_conference_comment ",
		"my_doctoral_training_conferences_number_credit"   : " my_doctoral_training_conference_number_credit ",
		"my_doctoral_training_conferences_complete_ref"    : " my_doctoral_training_conference_complete_ref ",  
		"my_doctoral_training_conferences_title"           : " my_doctoral_training_conference_title ",
		
		
		"my_doctoral_training_journal_papers_title"    : " my_doctoral_training_journal_papers_title ",    
		"my_doctoral_training_journal_papers_role"     : " my_doctoral_training_journal_papers_role ",  
		"my_doctoral_training_journal_papers_date"     : " my_doctoral_training_journal_papers_date ",      
		"my_doctoral_training_journal_papers_notice"   : " my_doctoral_training_journal_papers_notice ", 
		"my_doctoral_training_journal_papers_file"     : " my_document_training_file ",
		"my_doctoral_training_journal_papers_credits"  : " my_doctoral_training_journal_papers_credits ",
		
		"my_doctoral_training_seminars_function"    : " my_doctoral_training_seminars_function ",
		"my_doctoral_training_seminars_title"       : " my_doctoral_training_seminars_title ",  
		"my_doctoral_training_seminars_type"        : " my_document_training_seminars_type ",
		"my_doctoral_training_seminars_institution" : " my_document_training_institution ",
		"my_doctoral_training_seminars_date"        : " my_document_training_seminars_date ",
		"my_doctoral_training_seminars_credits"     : " my_doctoral_training_seminars_credits ",    
		"my_doctoral_training_seminars_text"        : " my_doctoral_training_seminars_text ",
		
		"my_doctoral_training_teaching_and_supervision_title"       : " my_doctoral_training_teaching_and_supervision_title ",
		"my_doctoral_training_teaching_and_supervision_type"        : " my_document_training_teaching_and_supervision_type ",
		"my_doctoral_training_teaching_and_supervision_institution" : " my_document_training_teaching_and_supervision_institution ",
		"my_doctoral_training_teaching_and_supervision_credits"     : " my_doctoral_training_teaching_and_supervision_credits ", //
		"my_doctoral_training_teaching_and_supervision_text"        : " my_doctoral_training_teaching_and_supervision_text ", 
		
		"my_doctoral_training_intermediate" : " my_doctoral_training_intermediate", 
		"my_doctoral_training_submission"   : " my_doctoral_training_submission", 
		"my_doctoral_training_final"        : " my_doctoral_training_final",
		
		"my_doctoral_training_position1"   : " my_doctoral_training_position1", 
		"my_doctoral_training_position2"   : " my_doctoral_training_position2", 
		"my_doctoral_training_position3"   : " my_doctoral_training_position3", 
		"my_doctoral_training_position4"   : " my_doctoral_training_position4", 
		"my_doctoral_training_position5"   : " my_doctoral_training_position5", 
		
		 
		// public defence  
		
		"public_defence_date"               : "<span style=\"color:red;\">DD-MM-YYYY 00:00</span>",
		"public_defence_these"              : "public_defence_these",
		"public_defence_local_upstaires"    : " public_defence_local_upstaires",
		"public_defence_sammery"            : " public_defence_sammery",    
		"public_defence_photo"              : " public_defence_photo",  
		"public_defence_thesis_time"        : " public_defence_thesis_time",   
		"public_defence_thesis_place"       : " public_defence_thesis_place",   
		"public_defence_jury_date_time"     : " public_defence_jury_date_time",  
		"public_defence_jury_date_place"    : " public_defence_jury_date_place",  
		"public_defence_admin_place"        : " public_defence_admin_place",  
		"public_defence_admin_thesis_num"   : " public_defence_admin_thesis_num",   
		"public_defence_admin_money"        : " public_defence_admin_money",   
		"public_defence_admin_auto_diff"    : " public_defence_admin_auto_diff",  
		"public_defence_admin_generate"     : " public_defence_admin_generate",
		"public_defence_jury_members_title" : " public_defence_jury_members_title",
		
		"private_defence_home_title"  : "private_defence_home_place ",
		"private_defence_home_place"  : "private_defence_home_Place",  
		"private_defence_home_date"   : "<span style=\"color:red;\">  my "+this.DATE_FORMA_NORMAL+"</span>", 
		
		"private_defence_submit_board_title_admin" : " private_defence_submit_board_title_admin",
		"private_defence_submit_board_title_user"  : " private_defence_submit_board_title_user",
		"private_defance_submit_select_admin"      : " private_defance_result_select_admin",
		"private_defance_submit_select_user"       : " private_defance_result_select_user",  
		"private_defance_submit_textarea"          : " private_defance_status_textarea",
		"private_defance_submit_date"              : "private_defance_submit_date",
		"private_defance_submit_date_validated"    : "private_defance_submit_date_validated",
		"private_defence_signaturs_president"      : "private_defence_signaturs_president",
		"private_defence_signaturs_president_empty": "private_defence_signaturs_president_empty",
		
		"admission_signature_upload" : " admission_signature_upload",
		"private_signature_upload" : " private_signature_upload",
		
		"my_supervisory_panel_title_supervisory"              : " my_supervisory_panel_title_supervisory",
		"my_supervisory_panel_header_supervisory_panel"       : " my_supervisory_panel_header_supervisory_panel", 
		"my_supervisory_panel_header_supervisory_panel_member": " my_supervisory_panel_header_supervisory_panel_member", 
		
		"#my_profile_reference_title": " my_profile_reference_title",      
		"#my_profile_mail"           : " my_profile_mail", 
		"#my_profile_mobile"         : " my_profile_mobile", 
		"#my_profile_birthplace"     : " my_profile_birthplace", 
		"#my_profile_birth_date"     : " my_profile_birth_date", 
		"my_profile_PhD_domain"     : " Please ask your supervisor to confirm the domain of your PhD. ",
		"my_profile_sciences"       : " Please ask your supervisor to confirm the sub-domain of your PhD.", 
		"#my_profile_last_name"      : " my_profile_last_name",
		"#my_profile_first_name"     : " my_profile_first_name", 
		"#my_profile_pwd"            : " my_profile_pwd", 		//  
		"#my_profile_institution"    : " my_profile_institution", 		 
		"my_profile_institute"      : " Select here the research institute of your (main) supervisor. ", 		 	
		"my_profile_thesis_funding" : " e.g. FRIA, FNRS, EU project,...", 		 
		"#my_profile_contact_tel"    : " my_profile_contact_tel", 		  
		
		"#my_academic_cv_diploma_level"          : " my_academic_cv_diploma_level",
		"#my_academic_cv_diploma_official_title" : " my_academic_cv_diploma_official_title",
		"#my_academic_cv_institution"            : " my_academic_cv_institution",
		"#my_academic_cv_country"                : " my_academic_cv_country",
		"my_academic_cv_awarding_date"           : " Date of final deliberation as it appears on your record.",
		"my_academic_cv_diploma_date"            : " Date of delivery of the diploma.",
		"#my_academic_cv_obtained_for_diploma"    : " my_academic_cv_obtained_for_diploma",
		"my_academic_cv_num_of_cr_years_for_diploma": " Type here the total number of credits required to obtain this diploma. ",
		"my_academic_cv_ects"                    : " Use this option if your institution uses the european ECTS system. ",
		"my_academic_cv_ects_year"               : " Select the country and type here the number of credits for a semester in the credit system used by your institution. ",
		"my_academic_cv_ects_non"                : " Use this option if your institution uses a credit system which is different from the EU system and enter the total number of credits for the diploma. ",
		"my_academic_cv_ects_years"              : " Use this option if your institution does not use any credit system.",  
		"#my_academic_cv_please_download_diploma" : " my_academic_cv_please_download_diploma", 
		"#my_academic_cv_aca_institution"         : " my_academic_cv_aca_institution", 
		"my_academic_cv_aca_awarding_date"       : " Date of final deliberation as it appears on your record.", 
		"my_academic_cv_aca_diploma_date"        : " Date of delivery of the diploma.", 
		"#my_academic_cv_aca_degree_level"        : " my_academic_cv_aca_degree_level", 
		"#my_academic_cv_aca_score"               : " my_academic_cv_aca_score", 
		"#my_academic_cv_aca_title_year"          : " my_academic_cv_aca_title_year",     
		"my_academic_cv_aca_please_download_year": " Please upload the transcript record for that year / semester. ", 
		"#my_academic_cv_aca_copy_year"           : " my_academic_cv_aca_copy_year",   
		"#my_academic_cv_aca_squale_between"      : " my_academic_cv_aca_squale_between",
		
		"my_phd_admission_home_preadmission"                  : " Read carefully the comments in the frame above. The provisory admission (preadmission) is reserved to duly justified situations.", 
		"#my_phd_admission_home_admission"                     : " my_phd_admission_home_admission", 
		"my_phd_admission_justification"                      : " Detail here the reasons which justify the recourse to a provisory admission. ",
		"#my_phd_admission_research_project_title"             : " my_phd_admission_research_project_title",    
		"my_phd_admission_research_project_research_project"  : " Upload here a PDF version of the research project (typically in three pages) you have designed with your supervisor. ",   
		"my_phd_admission_supervisory_panel_title"            : " my_phd_admission_supervisory_panel_title", 
		"my_phd_admission_supervisory_panel_supervisory_panel": " my_phd_admission_supervisory_panel_supervisory_panel", 
		"#my_phd_admission_doctoral_training_act"              :" my_phd_admission_doctoral_training_act",
		"my_phd_admission_doctoral_training_desc"             :" Give here the name or a short description of the activity.",
		"#my_phd_admission_doctoral_training_place"            :" my_phd_admission_doctoral_training_place",
		"my_phd_admission_doctoral_training_acronym"          :" Course code or acronym (if available).",
		"my_phd_admission_doctoral_training_ects"             :" Anticipated number of credits (see comments in the frame above).",
		"#my_phd_admission_doctoral_training_comment"          :" my_phd_admission_doctoral_training_comment",  
		
		"my_phd_admission_ucl_reg" : " Upload here the confirmation file of your enrollment request at the UCL registration office (SIC). ",
		
		"my_phd_admission_submit_select_academic_cv" : "my_phd_admission_submit_select_academic_cv",
		
		"my_cotutelle_desc"   : " my_cotutelle_description", 
		"my_cotutelle_upload" : " my_cotutelle_upload",
		
		"my_cotutelle_opening_application" : "my_cotutelle_opening_application",  
		
		"upload_my_cotutelle_opening_application"  : "upload_my_cotutelle_opening_application",
		"upload_my_cotutelle_signed_agreement_pdf" : "upload_my_cotutelle_signed_agreement_pdf",
		
		"upload_my_additional_programme"           : "upload_my_additional_programme",
		
		"upload_my_aacademic_cv_diploma"           : "upload_my_aacademic_cv_diploma",
		"upload_my_aacademic_cv_academic"          : "upload_my_aacademic_cv_academic",
		
		"upload_my_phd_adm_research_project"       : "upload_my_phd_adm_research_project",
		"upload_my_phd_adm_signatures"             : "upload_my_phd_adm_signatures", 
		"upload_my_phd_adm_ucl_reg"                : "upload_my_phd_adm_ucl_reg",
		
		"upload_my_phd_conf_planning"              : "upload_my_phd_conf_planning",  
		"upload_my_phd_conf_results_doctoral"      : "upload_my_phd_conf_results_doctoral",
		"upload_my_phd_conf_results_supervisory"   : "upload_my_phd_conf_results_supervisory", 
		
		"upload_my_phd_private_signatures"         : "upload_my_phd_private_signatures",
		"upload_my_phd_private_president"          : "upload_my_phd_private_president",
		
		"upload_my_phd_public_defence_summeries"     : "upload_my_phd_public_defence_summeries",
		"upload_my_phd_public_defence_photo"         : "upload_my_phd_public_defence_photo",
		
		"upload_my_doc_training_conferences"      : "upload_my_doc_training_conferences",
		"upload_my_doc_training_conferences_list" : "upload_my_doc_training_conferences_list",
		"upload_my_doc_training_journal_papers"   : "upload_my_doc_training_journal_papers",
		
		"upload_my_doc_training_courses"          :"upload_my_doc_training_courses",
		
		
		
		"upload_my_annual_reports" : "upload_my_annual_reports",
		
		
		"management_admin_config_dialog" : " menegement_admin_config_dialog", 
		"management_admin_config_state" : " menegement_admin_config_state",
		
		"my_phd_confirmation_planning_deadline_for_conf"   : " my_phd_confirmation_planning_deadline_for_conf", 
		"#my_phd_confirmation_planning_request"            : " my_phd_confirmation_planning_request", 
		"my_phd_confirmation_planning_newdeadline"         : " my_phd_confirmation_planning_newdeadline", 
		"my_phd_confirmation_planning_justification"       : " my_phd_confirmation_planning_justification", 
		"my_phd_confirmation_planning_admission_two_years" : " my_phd_confirmation_planning_admission_two_years ",
		"my_phd_confirmation_planning_upload"              : " my_phd_confirmation_planning_upload",
		
		"my_phd_confirmation_home_status":" my_phd_confirmation_home_status", 
		 
		"my_phd_confirmation_result_date_confirm"             : " my_phd_confirmation_result_date_confirm", 
		"my_phd_confirmation_result_doctoral_report"          : " my_phd_confirmation_result_doctoral_report", 
		"my_phd_confirmation_result_supervisory_panel_report" : " my_phd_confirmation_result_supervisory_panel_report", 
		
		"my_phd_confirmation_status"                 : "my_phd_confirmation_status",
		"my_phd_confirmation_planning_submit_sanded" : "Data has been sanded",
		
		"admin_search_load_saved_query"              : " admin_search_load_saved_query ", 
		"admin_search_user_lname"                    : "Last name", 
		"admin_search_user_fname"                    : " admin_search_user_fname",
		"admin_search_user_phd"                      : " admin_search_user_phd",
		"admin_search_user_subdomain"                : " admin_search_user_subdomain",
		"admin_search_user_inst"                     : " admin_search_user_inst",
		"admin_search_user_supervisor"               : "admin_search_user_supervisor ",
		"admin_search_user_finance_thesis"           : " admin_search_user_finance_thesis",
		"admin_search_user_admission"                : "admin_search_user_admission ",
		"admin_search_user_pre_admission"            : "admin_search_user_pre_admission ",
		"admin_search_user_confirmation"             : " admin_search_user_confirmation",
		"admin_search_user_private_defence"          : " admin_search_user_private_defence",
		"admin_search_user_public_defence"           : " admin_search_user_public_defence",
		"admin_search_user_status_admission"         : "admin_search_user_status_admission ",
		"admin_search_user_status_pre_admission"     : " admin_search_user_status_pre_admission",
		"admin_search_user_status_confirmation"      : " admin_search_user_status_confirmation",
		"admin_search_user_status_doctoral_training" : " admin_search_user_status_doctoral_training",
		"admin_search_user_status_private_defence"   : "admin_search_user_status_private_defence ",
		"admin_search_user_status_public_defence"    : "admin_search_user_status_public_defence ",
		"admin_search_user_status_cotutelle"         : "admin_search_user_status_cotutelle ",
		"admin_search_user_status_thesis_completed"  : "admin_search_user_status_thesis_completed ",
		
		"admin_search_user_status_admission_additional_programme" : "admin_search_user_status_admission_additional_programme",
		
		"DEFAULT"    : " Not yet submitted", 
		"REQUEST"    : " Waiting for supervisor approval.",
		"ACCEPT"     : " Accepted",
		"REFUSE"     : " Rejected",
		"FINAL"      : " FINAL",
		"SUPERVISOR" : " Submitted to the CDD",
		 	
			"admin_wp_last_name"  : "Last name: ",
			"admin_wp_first_name" : "First name: ",
			"admin_wp_tel"        : "Tel: ",
			"admin_wp_email"      : "E-mail: ",
			"admin_wp_pwd"        : "Password: ",
			"admin_wp_confpwd"    : "Confirm Password: ",
			"admin_wp_txt"        : "Text",
			
			"admin_wp_form_pwd"        : "Your password must be at least 8-character long and consist of the following characters: a-z A-Z 0-9 . - = + ! ",
			"admin_wp_form_server_res" : "Error: The server can not process the data.",

		"admission_submit_admitted" : " Admitted en : ",
		
		"admin_institute_title" : "Institution: ",
		"admin_institute_mail"  : "Mail",
		"admin_institute_text"  : "Text",
		
		"#header_title_application_sst"             : "About Application SST ",
		"#header_title_get_new_password"           : "header_title_get_new_password",
		"header_title_link_signatures_info_user"   : "header_title_link_signatures_info_user",
		"header_title_my_log"                      : "header_title_my_log ",
		"header_title_my_cotutelle"                : "header_title_my_cotutelle ",
		"header_title_my_additional_prog"          : "header_title_my_additional_prog ",
		"header_title_my_doctoral_training_block"  : "header_title_my_doctoral_training_block ",  
		"header_title_my_doctoral_training_submit" : "header_title_my_doctoral_training_submit ",  
		"header_title_my_doctoral_training_detail" : "header_title_my_doctoral_training_detail ",  
		"header_title_my_doctoral_training_status" : "header_title_my_doctoral_training_status ",  
		"header_title_my_supervisory_panel_tentative"  : "header_title_my_supervisory_panel_tentative ",
		"header_title_my_supervisory_panel_supervisor" : "header_title_my_supervisory_panel_supervisor ",  
		"header_title_my_supervisory_panel_member" : "header_title_my_supervisory_panel_member ",  
		"header_title_public_defence_thesis"       : "header_title_public_defence_thesis ",  
		"header_title_public_defence_form"         : "header_title_public_defence_form ",  
		"header_title_private_defence_home"        : "header_title_private_defence_home ",  
		"header_title_public_defence_jury_members" : "header_title_public_defence_jury_members ",  
		"header_title_public_defence_status"       : "header_title_public_defence_status", 
		
		"header_title_private_defence_signatures"    : "header_title_private_defence_signatures ",  
		"header_title_private_defence_submit_board"  : "header_title_private_defence_submit_board ", 
		"header_title_private_defence_status"        : "header_title_private_defence_status ", 
		"header_title_confirmation_status"           : "header_title_confirmation_status ",  
		"header_title_confirmation_planning"         : "header_title_confirmation_planning ",  
		"header_title_confirmation_result"           : "header_title_confirmation_result ", 
		"#header_title_admission_home"                : "header_title_admission_home",		
		"#header_title_admission_reseach_project"     : "header_title_admission_reseach_project ",  
		"#header_title_admission_additional_prog"     : "header_title_admission_additional_prog ",  
		"header_title_admission_supervisory_panel_tentative_promotor" : "header_title_admission_supervisory_panel_tentative_promotor ",  
		"header_title_admission_supervisory_panel_supervisor"         : "header_title_admission_supervisory_panel_supervisor ",  
		"header_title_admission_supervisor"          : "Your supervisor must be an academic member of the Sciences and Technology Sector. In the case of a co-supervision, at least one your co-supervisors must be an academic member of the Sector. ",  
		"header_title_admission_other_members_"      : "The members of your supervisory panel must owe a PhD degree. You must provide a minimum of two members in addition to your supervisor(s). ",    
		"header_title_admission_supervisory_panel_other_member" : "header_title_admission_supervisory_panel_other_member ",   
		"#header_title_admission_registration"        : "header_title_admission_registration ",  
		"header_title_management_user_form_wp_"      : "header_title_management_user_form_wp_... ",  
		"header_title_management_user_search"        : "header_title_management_user_search ",  
		"header_title_management_user_institute"     : "header_title_management_user_institute ",  
		"#header_title_my_profile"                   : "header_title_my_profile ",  
		"#header_title_my_profile_residence_address" : "header_title_my_profile_residence_address ",  
		"#header_title_my_profile_contact_address"   : "header_title_my_profile_contact_address ",
		
		"header_title_annual_raports"               : "header_title_annual_raports ",
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