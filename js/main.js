var linking ="";
var items = "undefined";
var server = "https://sites.uclouvain.be/doctorat-sst/sst/display.php";

function isLeapYear(y) {
	return (y % 4 == 0 && (y % 100 != 0 || y % 400 != 0));
}

function isset(str) { 
    try { 
        eval(str);
    } catch(err) { 
        if ( err instanceof ReferenceError ) 
           return false;
    }
    return true;
} 

function isNumeric(input) {
    return (input - 0) == input && (''+input).replace(/^\s+|\s+$/g, "").length > 0;
}

var img = new Image();
	img['ICON_CLOSE']       = "img/close.png";
	img['INACTIVE_UPLOAD']  = "img/folder32.png";
	img['ACTIVE_UPLOAD']    = "img/folder32.png";

var IMG = {
	ICON_CLOSE       : img['ICON_CLOSE'],
	INACTIVE_UPLOAD  : img['INACTIVE_UPLOAD'],
	ACTIVE_UPLOAD    : img['ACTIVE_UPLOAD'],
};

this.sst_page = "";
var httpReqMenu = createRequest();

function ClassMenuLeft() {
	this.getMenuLeft = function() {}
	this.setMenuLeft = function() {}
	this.sendRequest = function() {
		if(httpReqMenu != null) {  
			var url = "modules/menu_left/pages/menu_left.php?get="+Math.random();       
			httpReqMenu.open("GET", url, true);
			httpReqMenu.onreadystatechange = function() {
				if (httpReqMenu.readyState == 4)  {
					var resRequest = httpReqMenu.responseText;
					document.getElementById("menu_left").innerHTML = resRequest;
					if(document.getElementById("connexion_form")) {
						var f_connexion = document.getElementById("connexion_form");
						f_connexion.parentNode.removeChild(f_connexion);
					}	
				} else {
						return false;
				}			
			}; 
			httpReqMenu.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpReqMenu.send();
		}
	}
}

function disconnect() {
	closeDialog();
	openDialog();
	classDialog.whence = "DESCONNECT_SESSION";
	var icon = classDialog.dialogIconObject.ICON_WARNING; 
		showDialogObject.dialogConfirm(null, 
								showText('DIALOG', 'dialog', null, null), 
								showText('DIALOG', 4, null, null), icon, 'OK', 'CANCEL');	
	listener(); 
}

function connexionHandleKey(e, sub) {
	e = (!e) ? window.event : e;
	target = (!e.target) ? e.srcElement : e.target;
	if (target.nodeType == 3) 
		target = target.parentNode;
 
	code = (e.charCode) ? e.charCode :
       ((e.keyCode) ? e.keyCode :
       ((e.which) ? e.which : 0)); 
	if(code == 13) {
		switch(sub) {
			case'CONNEXION':
				var login = document.getElementById("con_login").blur();
				var pwd   = document.getElementById("con_pwd").blur();
				connexion();
			break;
		}	
	}
}	

function connexion() {   
	var login = document.getElementById("con_login");
	var pwd   = document.getElementById("con_pwd");
	if(login.id == classForm.JSON_FORM_CONNEXION.Login && !classForm.REG_FORM_MAIL.test(login.value)) {
		getValueOfText( login.value, login.id) ;
		login.focus();
	} else if(pwd.id == classForm.JSON_FORM_CONNEXION.Passwd && !classForm.REG_FORM_PWD.test(pwd.value)){
		getValueOfText( pwd.value, pwd.id);
		pwd.focus();
	}
	
	if(classForm.REG_FORM_MAIL.test(login.value) && classForm.REG_FORM_PWD.test(pwd.value)) {	
		var httpReqConnex = createRequest();
		if(httpReqConnex != null) {
		 
		var url = "modules/form_connexion/pages/request.php";       
		httpReqConnex.open("POST", url, true);
			httpReqConnex.onreadystatechange = function(login, pwd) {
				if(httpReqConnex.readyState == 1 || httpReqConnex.readyState == 2 || httpReqConnex.readyState == 3) {
					closeDialog();
					openDialog();
					var icon = classDialog.dialogIconObject.ICON_PROG; 
						showDialogObject.dialogSimple(null, 
											showText('DIALOG', 'dialog', null, null),
											showText('DIALOG', 'waiting', null, null), icon );	
					listener();	
				} 
				if (httpReqConnex.readyState == 4)  {  
					closeDialog();
					var resRequest = httpReqConnex.responseText; 
					goMainUser(resRequest);	 
				}
			}
			httpReqConnex.setRequestHeader("Content-type","application/x-www-form-urlencoded");
			httpReqConnex.send("&mail="+escape(login.value)+"&pwd="+escape(pwd.value));
		}
	}
}

function goMainUser(resRequest) {
	openDialog();
	
	if(!navigator.cookieEnabled) {
			setProcessingForwarding(2000, server); 
			var icon = classDialog.dialogIconObject.ICON_ERROR; 
				showDialogObject.dialogSimple(null, 
											showText('DIALOG', 'dialog', null, null),
											'Cookie Enabled!', icon );	
				listener();			
			return;
	}
		
		
	
	if(resRequest.indexOf("#") != -1) {  
		var spl = resRequest.split("#");
		var spl = spl[1];
		var spl = spl.split(" ");
		 
		var sub = spl[1].replace(/^\s+|\s+$/gm,'');
		switch(sub) {
			
			case'6011':  
				var icon = classDialog.dialogIconObject.ICON_ERROR;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6011', null, null), icon, 'OK');	
				listener();
			return;
			case'6017':
				var icon = classDialog.dialogIconObject.ICON_ERROR;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6017', null, null), icon, 'OK');	
				listener();
			return; 
			case'6018':
				var icon = classDialog.dialogIconObject.ICON_ERROR;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6018', null, null), icon, 'OK');	
				listener();
			return; 
			case'6019':
				var icon = classDialog.dialogIconObject.ICON_OK;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6019', null, null), icon, 'OK');	
				listener();
			return; 
			case'6020':  
				var icon = classDialog.dialogIconObject.ICON_OK;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6020', null, null), icon, 'OK');	
				listener();
			return; 
			case'6021':  
				var icon = classDialog.dialogIconObject.ICON_ERROR;
					showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 'connexion_6021', null, null), icon, 'OK');	
				listener();
			return; 
		}
	}
	
	
	if(resRequest.indexOf("SST") != -1) { 
	
		 
			
		var classMenuLeft = new ClassMenuLeft();
			classMenuLeft.sendRequest();
			classDialog.whence = 'SEND_DATA_MY_SST'; 
		var icon = classDialog.dialogIconObject.ICON_OK;
			showDialogObject.dialogStandard(null, 
												showText('DIALOG', 'dialog', null, null), 
												showText('DIALOG', 1, null, null), icon, 'OK');	
			listener();
			return; 
	}
	var r  = new RegExp("(OK|ok)");
	if(r.test(resRequest)) { 
		var classMenuLeft = new ClassMenuLeft();
			classMenuLeft.sendRequest();
			classDialog.whence = 'SEND_DATA_MY_SPACE_CONNECT'; 
		var icon = classDialog.dialogIconObject.ICON_OK;
			showDialogObject.dialogStandard(null, 
											showText('DIALOG', 'dialog', null, null), 
											showText('DIALOG', 2, null, null), icon, 'OK');	
			listener();
	} else { 
		var icon = classDialog.dialogIconObject.ICON_ERROR;
			showDialogError(showText('DIALOG', 3, null, null), icon)
	}
}

var classForm = new mainClassForm();
var httpReq = createRequest();

function mainClassForm() { 
	this.ID  = "";
	this.VAL = "";
	
	var imgForm = new Image();
	
	imgForm['ICON_OK']  = "img/ok.png";
	imgForm['ICON_ERR'] = "img/error.png";
	this.iconObject = {
		ICON_OK  : imgForm['ICON_OK'],
		ICON_ERR : imgForm['ICON_ERR']
	};
	// If you decide to add a key here, then you should check (my profile js  and my space connect js ) 
	this.JSON_FORM_RESIDENCE = {
						"LastName"    : "lname",
						 "FirstName"  : "fname",
						 "E_MAil"     : "mail",
						 "RE_TYPE_E_MAil" : "retypemail",
						 "PASSWORD"   : "pwd",
						 "CONFPWD"    : "confpwd",
						 "SCIENCE"    : "ssciences",
						 "DOMAIN"     : "sdomain",
						 "REFEREED"   : "refereed",
						 "MOBILE"     : "mobile",
						 "INSTITUTION": "institution",
						 "BirthPlace" : "birthplace",
						 "birthDate"  : "birthdate",
						 "INSTITUTE"  : "institute",
						 "THESIS"     : "thesis",
	}; 	
	
	this.JSON_FORM_ADDRESS = {
						"F1STREET"    : "f1_street",
						"F1BoxNum"    : "f1_box_num",
						"F1PostalCode": "f1_postal_code",
						"F1CITY"      : "f1_city",
						"F1TEL"       : "f1_tel",
						"F1COUNTRY"   : "f1_country",
						"F2UNIV"      : "f2_univ",
						"F2STREET"    : "f2_street",
						"F2BoxNum"    : "f2_box_num",
						"F2PostalCode": "f2_postal_code",
						"F2CITY"      : "f2_city",
						"F2TEL"       : "f2_tel",
						"F2COUNTRY"   : "f2_country",
	};	
	
	this.JSON_FORM_CONNEXION = { 
						"Login" : "con_login",
						"Passwd": "con_pwd"
	};	
	
	this.JSON_FORM_ACADEMIC_CV = {
					"GetNumberDip"   : "getdip",
					"HowLongStudied" : "how_long_studied" 
	};
	
	this.JSON_FORM_DATE = {
					"UNIV_DATE"  : "univ_date",
					"DATEHOUR"   : "date_hour",
					"PublicDate" : "date",
					"PublicTime" : "thesis_time",
					"PablicJuryDateTime"  : "j_date_time",
					"PablicJuryDatePlace" : "j_date_place",
	};
	
	this.REG_FORM_SIMPLE = /^[a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_\s\'][^0-9\<\>\\\/\"\(\)\{\}\;]{1,200}$/i;	
	this.REG_FORM_MAIL   = /^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
	this.REG_FORM_PWD    = /^[a-zA-Z0-9_.\-\=\+\!]{1,25}$/i;
	this.REG_FORM_NUM    = /^[0-9a-zA-Z-\,\.]+$/;
	this.REG_FORM_T      = /^[0-9\(\)\s\+\-\.\/]{4,25}$/;
	this.REG_FORM_FLEX   = /^[0-9a-zA-ZÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ_\s\'\+\-][^\<\>\\\?\/\"\(\)\{\}\;]{0,100}$/i;
	this.REG_FORM_DATE_HEUR  = /^[a-z0-9_.\-\=\+\s\:\,]{1,50}$/i;
	this.REG_FORM_UNIQUE_NUM  = /^[0-9]+$/;
	this.REG_FORM_UNIQUE_NUM_CREDITS  = /^[0-9\-]+$/;
	
	this.REG_URL = /^[0-9a-z-\+\=\_\.\&\/\:\?]+$/;
	this.REG_FORM_MINIMUM = /^[a-zA-Z0-9_.\-\=\+\!\/\s\(\)]{1,100}$/i;
	
	this.CHECK_FORM = 4;
	this.CHECK_FORM_ADDRESS = 11;
	this.valid = function() { }

	this.sendFormResidence = function (ssciences, sdomain, lname, fname, mail, pwd, institution, refereed, mobile, birthplace, birthdate, institute, thesis) {
	 
		if(httpReq != null) { 
			 
			var send_vals = new FormData();
			if(refereed != null && mobile != null && birthplace != null && birthdate != null){
				var json = '{';
				for(var m in classForm.JSON_FORM_ADDRESS) 
					json += '"'+classForm.JSON_FORM_ADDRESS[m]+'" : "'+document.getElementById(classForm.JSON_FORM_ADDRESS[m]).value+'",';
					
				json = json.substring(0, json.length-1);
				json += '}'; 
				var json_as_string = JSON.stringify(json);
				 
				var url = "modules/my_profile/pages/request.php"; 
				send_vals.append('resid',       json_as_string); 
				send_vals.append('ssciences',   escape(illegalChars(ssciences))); 
				send_vals.append('sdomain',     escape(illegalChars(sdomain.value))); 
				send_vals.append('lname',       escape(illegalChars(lname.value))); 
				send_vals.append('fname',       escape(illegalChars(fname.value))); 
				send_vals.append('mail',        escape(illegalChars(mail.value))); 
				send_vals.append('pwd',        (pwd == -1 ? pwd : escape(illegalChars(pwd.value))) ); 
				send_vals.append('institution', escape(illegalChars(institution.value))); 
				send_vals.append('refereed',    escape(illegalChars(refereed.value))); 
				send_vals.append('mobile',      escape(mobile.value)); 
				send_vals.append('birthplace',  escape(illegalChars(birthplace.value))); 
				send_vals.append('birthdate',   escape(illegalChars(birthdate.value))); 
				send_vals.append('institute',   escape(illegalChars(institute.value))); 
				send_vals.append('thesis',      escape(thesis.value));   			
			} else {
				var url = "modules/my_space_connect/pages/request.php"; 		
				send_vals.append('ssciences', escape(illegalChars(ssciences))); 	
				send_vals.append('sdomain',   escape(illegalChars(sdomain.value))); 
				send_vals.append('lname',     illegalChars(lname.value)); 
				send_vals.append('fname',     illegalChars(fname.value)); 
				send_vals.append('mail',      illegalChars(mail.value)); 
				send_vals.append('pwd',       escape(illegalChars(pwd.value))); 			
			}
			 
			httpReq.open("POST", url, true);
			httpReq.onreadystatechange = function() {
				if(httpReq.readyState == 1 || httpReq.readyState == 2 || httpReq.readyState == 3) {
					var icon = classDialog.dialogIconObject.ICON_DB; 
						showDialogObject.dialogSimple(null, 
											showText('DIALOG', 'dialog', null, null),
											showText('DIALOG', 'waiting', null, null), icon );	
					listener();		
					 
				} 
				if (httpReq.readyState == 4)  { //return;   
					var resRequest = httpReq.responseText;  
					var s = new String(resRequest);
					if(s.indexOf("OK") !== -1 || s.indexOf("ok") !== -1) {   
						document.getElementById("form_request").value = true;
						if(document.getElementById("bsend")) { document.getElementById("bsend").disabled=true; }
						
						if (typeof destroyCookieTrack == 'function') { destroyCookieTrack(true); }
						
						for(var k in classForm.JSON_FORM_RESIDENCE) { 
							if(document.getElementById(classForm.JSON_FORM_RESIDENCE[k])) {
								document.getElementById(classForm.JSON_FORM_RESIDENCE[k]).disabled = true;
							}
						}
						var classMenuLeft = new ClassMenuLeft();
							
							classMenuLeft.sendRequest();
							classDialog.whence = 'SEND_DATA_MY_SPACE_CONNECT'; 
						/*
						setProcessingForwarding(2000, '?page=my_profile'); 
						var icon = classDialog.dialogIconObject.ICON_PROG; 
							showDialogObject.dialogSimple(null, 
											showText('DIALOG', 'dialog', null, null),
											showText('DIALOG', 'waiting', null, null), icon );	
							listener();
						 */
						 var icon = classDialog.dialogIconObject.ICON_OK;
							showDialogObject.dialogStandard(null, 
														showText('DIALOG', 'dialog', null, null), 
														showText('DIALOG', 'my_profile_saved', null, null), icon, 'OK');
														
														
						 listener();
						 return;
					} else {
						var icon = classDialog.dialogIconObject.ICON_ERROR;
							showDialogObject.dialogStandard(null, 
														showText('DIALOG', 'dialog', null, null), resRequest  , icon, 'OK');	
						listener();
						return false;
					}
				}	
			};
			httpReq.send(send_vals);		
		} else {
			return false;
		}	
	}
}

function checkDate(day_d, month_d, year_d) {
	var day   = parseInt(day_d);
	var month = parseInt(month_d);
	var year  =  parseInt(year_d);
	var maxDay;
	
	if(month < 1 || month > 12) { return false; }

	switch(month) {
		case 1: case 3: case 5: case 7: case 8: case 10: case 12:
			maxDay = 31; break;
		case 4: case 6: case 9: case 11:
			maxDay = 30; break;
		case 2: maxDay = (isLeapYear(year) ? 29 : 28); break;
	}
	
	if( day > maxDay ) { return false; }
	return true;
}

function showDialogError(msg, icon) { 
	closeDialog();
	openDialog();
	classDialog.whence = "DIALOG_ERR";
	showDialogObject.dialogStandard(null, 
									showText('DIALOG', 'dialog', null, null) , msg  , icon, 'OK');	
	listener();
}

function cuttingMSGDialogContent(str) {
	if(str.length > 75) {
		return str.substring(0, 75)+"... "; 
	} else {
		return str; 
	}
}

function cuttingMSGDialogHeader(str) {
	if(str.length > 25) {
		return str.substring(0, 25)+"... "; 
	} else {
		return str; 
	}
}

function illegalChars(str) {
	if(str == undefined) return ;
	var arr_result = [];
	var arr_filter = ["/","\\","<", ">","%",";","*"];
	for(var i = 0; i < str.length; i++) {
		for(var index in arr_filter) {
			if( str.charAt(i).indexOf(arr_filter[index]) != -1) {
				arr_result[i] = " ";
				break;				
			} else {
				arr_result[i] = str.charAt(i);
			}
		}	 	
	}
	var t = "";
	for(var j =0; j < arr_result.length; j++) {
		t += arr_result[j];
	}
	return t;
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function getRandom() {
	var alf = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	var rand ="";
	for(var i = 1; i <= 1; i++) {
		rand += Math.floor((Math.random() * 100000) + 100)+'-';
		for(var j = 1; j <=3; j++) {
			rand += alf[ Math.floor((Math.random() * 25) + 1)];
		}
	}
	return rand;
}

// event key up participation#
function getValueOfText( val, id) {
	 
	  
	var spl = id.split("_"); 
	if(id == classForm.JSON_FORM_RESIDENCE.E_MAil || 
		id == classForm.JSON_FORM_CONNEXION.Login || 
		id == classForm.JSON_FORM_RESIDENCE.RE_TYPE_E_MAil) {
		var reg = classForm.REG_FORM_MAIL;
	} else if(id == classForm.JSON_FORM_RESIDENCE.PASSWORD || id == classForm.JSON_FORM_CONNEXION.Passwd) {  
		 var reg = classForm.REG_FORM_PWD; 
	} else if(id == classForm.JSON_FORM_ACADEMIC_CV.GetNumberDip || id == classForm.JSON_FORM_ACADEMIC_CV.HowLongStudied) {
		var reg = classForm.REG_FORM_NUM;
	} else if(id == classForm.JSON_FORM_RESIDENCE.MOBILE) {	
		var reg = classForm.REG_FORM_T;
	} else if(id == classForm.JSON_FORM_RESIDENCE.THESIS) {
		var reg = classForm.REG_FORM_SIMPLE;
	}else if(spl[0] == "min" || spl[0] == "max" || spl[0] == "obt") {  
		var reg = classForm.REG_FORM_NUM; 
		var elems = document.getElementById(id);
		  
			//elems.value = (isNumber(elems.value) ? elems.value : elems.value.substring(0,0)); 
			elems.value = (reg.test(elems.value) ? elems.value : elems.value.substring(0,0)); 
			elems.value = (elems.value.length >= 10 ?  elems.value.substring(0,0) : elems.value); 
			
	} else if(id ==  classForm.JSON_FORM_ADDRESS.F1STREET || 
			  id ==  classForm.JSON_FORM_ADDRESS.F1BoxNum || 
			  id ==  classForm.JSON_FORM_ADDRESS.F1PostalCode ||
			  id ==  classForm.JSON_FORM_ADDRESS.F1CITY ||
			  id ==  classForm.JSON_FORM_ADDRESS.F2UNIV ||
			  id ==  classForm.JSON_FORM_ADDRESS.F2STREET ||
			  id ==  classForm.JSON_FORM_ADDRESS.F2BoxNum ||
			  id ==  classForm.JSON_FORM_ADDRESS.F2PostalCode ||
			  id ==  classForm.JSON_FORM_ADDRESS.F2CITY) { 
		 var reg = classForm.REG_FORM_FLEX;
	} else if(id ==  classForm.JSON_FORM_ADDRESS.F1TEL || id ==  classForm.JSON_FORM_ADDRESS.F2TEL) {
		var reg = classForm.REG_FORM_T;
	} else if(id ==  classForm.JSON_FORM_DATE.DATEHOUR || 
			  id ==  classForm.JSON_FORM_DATE.PublicDate ||
			  id ==  classForm.JSON_FORM_DATE.PublicTime ||
			  id ==  classForm.JSON_FORM_DATE.PablicJuryDateTime ||
			  id ==  classForm.JSON_FORM_DATE.PablicJuryDatePlace) {  
		  var reg = classForm.REG_FORM_DATE_HEUR;
	} else if(id.indexOf("#") !== -1 && id.indexOf("univ_date") == -1)  {
		if(isset(document.getElementById(id))) {
			var part = document.getElementById(id);
			var spl = id.split("#");
			if(spl[0] == "participation") {
				var reg = classForm.REG_FORM_NUM; 
			} else {  
				if(id.indexOf("num_credits1") !== -1 || id.indexOf("num_credits2") !== -1) {    
					var reg = classForm.REG_FORM_UNIQUE_NUM_CREDITS; 
					var elems = document.getElementById(id);
					if(elems.value.length >= 2)
						elems.value = (isNumber(elems.value) ? elems.value : elems.value.substring(0,0)); 
				} else {
					var reg = classForm.REG_FORM_FLEX;
					}
			}
		}
	} else if(id.indexOf("univ_date") !== -1 ) {   
		var reg = classForm.REG_FORM_DATE_HEUR;
	} else if(id.indexOf("dipobtained") !== -1 ) {  
		 var reg = classForm.REG_FORM_MINIMUM;
	} else {
		var reg = classForm.REG_FORM_FLEX;
	} 
	  
	var elems = document.getElementById(id+"sp");
	if(reg.test(val))  {
		elems.style.backgroundImage = "url("+classForm.iconObject.ICON_OK+")";
		document.getElementById(id).style.border ="1px solid #4E9760";
		return true;
	} else {  
		if(val == "") { 
			elems.style.backgroundImage = "url('')";
			document.getElementById(id).style.border ="1px solid #4E9760";
			return false;
		}
		elems.style.backgroundImage = "url("+classForm.iconObject.ICON_ERR+")";
		document.getElementById(id).style.border ="1px solid red";
		return false;
	}  
}
						 
function posHelp(event) {
	var x = 0; var y = 0;
	if (document.attachEvent != null) { 
		x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
		y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
		   
	} else if (!document.attachEvent && document.addEventListener) { 
		if(navigator.userAgent.match(/Trident.*rv\:11\./) ) {
			x = window.event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft);
			y = window.event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop);
		} else {
			x = event.clientX + window.scrollX;
			y = event.clientY + window.scrollY;
		}
	} else { return false; }
	return {x:x, y:y}; 
}

function getHelp(type, evt, head) {  
    evt = evt || window.event;
    evt.cancelBubble = true;
	   
    var getHelp = document.getElementById("dialog_help");  
    var html = "", msg = "", dbl = false;
	
	var dynamic_txt = type.substr(0, 5);
		  
	if( dynamic_txt.indexOf("mo.07") !== -1 ) {
	
		msg = type.substr(5, type.length);
		dbl = true;
		
	} else if(type.length != 36) {    
		for(index in this.txt['DIALOG_HELP'] ){
			if(type == index) { 
			
				msg = this.txt['DIALOG_HELP'][index];
				break;
				
			}
		}  
	} else {   
		if(document.getElementById(type)) {
			msg = document.getElementById(type).innerHTML;
		} else { return ;}
	}	
		  
	if(msg == "") { msg = this.txt['DIALOG_HELP'].default; }
	
		if(!dbl) {
			html  = "<div class='content_help'>";
			html += "<div style='float:left;'>&nbsp;"+head+"</div>";
			html += "<div style='margin-left: 10px; cursor: pointer; float:right;'><img align='absmiddle' src='"+IMG.ICON_CLOSE+"'/></div>";
			html += "</div>";
		}
		
		html += "<div style='font-size:12px; line-height:4mm;'>";
		html += msg;
		html += "</div>";
    
    if (html != "" && getHelp != null ) {
		 
			getHelp.innerHTML = html;
			getHelp.style.top = posHelp(evt).y + ((dynamic_txt.indexOf("mo.07") !== -1) ? 10 : 0) + "px";
			getHelp.style.left = posHelp(evt).x + ((dynamic_txt.indexOf("mo.07") !== -1) ? 10 : 0) +  "px";
			getHelp.style.display = "";
		  
    }
    return false;
}

function closeHelp(object, event, handler, useCapture) {
    if (object.addEventListener) {
        object.addEventListener(event, handler, useCapture ? useCapture : false);
    } else if (object.attachEvent) {
        object.attachEvent('on' + event, handler);
    }  
	return false; 
}

closeHelp(document, "click", function() {
var tit_h = document.getElementById("dialog_help");
	if(tit_h) { 
		tit_h.style.display="none"; 
	} 
});

function deleteTheDownloadedFile() {

	var send_vals = new FormData();
	var url = this.address; 
	var httpRequest = createRequest();
	
	if(httpRequest != null) {
		httpRequest.open("POST", url, true);
		httpRequest.onreadystatechange = function() {
		
		if(httpRequest.readyState == 1 || httpRequest.readyState == 2 ||httpRequest.readyState == 3) {} 
			else if (httpRequest.readyState == 4) {   
			var resRequest = httpRequest.responseText;	
				if(resRequest.indexOf("ok") !== -1 ) {
					 
					closeDialog();
					openDialog();
					setTimeProcessingDialog(1500); 
					var icon = classDialog.dialogIconObject.ICON_TRASH;   
					showDialogObject.dialogSimple(null, 
											showText('DIALOG', 'dialog', null, null),
											showText('DIALOG', 'delete_downloaded_pdf_remove', null, null)   , icon );	
					listener();
					var del = document.getElementById(id_gen);
					del.parentNode.removeChild(del);
					return ;
				} else {
					var icon = classDialog.dialogIconObject.ICON_ERROR;
					showDialogError(resRequest, icon); 
					return ;
				}
			}
		}
	if(typeof this.id_cv !== "undefined") {
		send_vals.append('id_cv', this.id_cv);
		send_vals.append('elem_cv', this.elem_cv);
	}
	send_vals.append('patch', this.patch); 		
	httpRequest.send(send_vals);
	
	}	
}

function eventButtonOK() { 	  
	switch (classDialog.whence) {     
		case "DIALOG_SIGNATURE":  
			closeDialog();
			location.reload();  
		break;
		case "DIALOG_NAME_SUPERVISION": 
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[0]);
			}   
		break;
		case "DIALOG_DELETE_SUPERVISION": 
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
		break;
		case "DIALOG_NAME_SEMINARS":  
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[0]);
			}   
		break;
		case "DIALOG_DELETE_SEMINARS":  
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
			closeDialog();
		break;
		case "DIALOG_NAME_JOURNAL_PAPERS": 
			closeDialog(); 
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[0]);
			}  
		break;
		case "DIALOG_DELETE_JOURNAL_PAPERS": 
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
		break;
		case "DIALOG_NAME_COURSE":
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[0]);
			}   
		break;
		case "DIALOG_DELETE_COURSE":  
			closeDialog();
			 if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
		break;
		case "DIALOG_NAME_CONFERENCE":  
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[7]);
			}   
		break;
		case "DIALOG_DELETE_CONFERENCE":  
			closeDialog();   
			 if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
		break;
		case "ADD_DOC_TRAINING":  
			closeDialog();   
			window.location.reload();
		break;
		case "ADM_SUBMIT_OK":
			closeDialog(); 
			window.location.reload();  
		break;
		case "ADM_SUBMIT":  
			closeDialog();   
			ajaxAdmSubmitSave();
		break;
		case "OPTION_ACCEPTING":  
			closeDialog();   
			requestOptionAjax();
		break;
		case "OPTION_TRYING":  
			closeDialog();   
			requestOptionAjax();
		break;
		case "FIELD_TEXTAREA_SAVE":
			closeDialog();   
			if (typeof saveFieldTextarea == "function") { 
				saveFieldTextarea();
			}
		break;
		case "TEXTAREA_SAVE":
			closeDialog();   
			if (typeof saveTextarea == "function") { 
				saveTextarea(); 
			}
		break;
		case "ADMISSION_ADDITIONAL_PROGRAMME_SAVE":
			closeDialog(); 
			location.reload();
			//((SMAIL == 'null' || typeof SMAIL == undefined) ? location.reload() : '') ;
		break;
		
		case "MY_ANNUAL_REPORTS_SAVE":
			closeDialog(); 
			location.reload();

		break;
		
		
		case "SAVE_DIPLOMA":
			closeDialog();  
		break;
		case "DIALOG_ERR":
			 
			closeDialog();  
		break;
		case "DESCONNECT_SESSION":
			closeDialog();  
			window.location.href="?page=disconnect";
		break;
		case "SEND_DATA_MY_SPACE_CONNECT":
			closeDialog();		
			window.location.href ="?page=my_profile";
		break;
		
		case "DELETE_THE_DOWNLOADED_PDF":
			closeDialog();	 	
			deleteTheDownloadedFile();
		break;
		
		
		case "SEND_DATA_MY_SST":
			 
			closeDialog();
			openDialog();

			var icon = classDialog.dialogIconObject.ICON_PROG; 
			showDialogObject.dialogSimple(null, 
						showText('DIALOG', 'dialog', null, null),
						showText('DIALOG', 'waiting', null, null), icon );	
			listener();
			
			window.location.href ="?page=management_user&mng=welcome";
		break;
		case "DELETE_YEAR":
			closeDialog();  
			deleteBlockYearFinally();
		break;
		case "DELETE_DIPLOMA":
			closeDialog();
			if(isset(document.getElementById(classForm.ID))) {
				var del =  document.getElementById(classForm.ID);
				deleteDiplomaIn();
				del.parentNode.removeChild(del);	
			}
		break;
		case "DELETE_DIPLOMA_EMPTY":  
			closeDialog();
			if(isset(document.getElementById(classForm.ID))) {
				var del = document.getElementById(classForm.ID);
				del.parentNode.removeChild(del);
				setCookie('diploma', '', '/', new Date(new Date().getTime()-3600000));			
			}
		break;
		case "MANAGEMENT_SAVE_CONTENT":
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}
		break;
		case "MANAGEMENT_DELETE_CONTENT":
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[3]);
			}
			closeDialog(); //  
		break;
		case "DIALOG_PW_ACTIVATE_USER":
			closeDialog();
			if(typeof sendAjax == "function") {
				sendAjax(option_arr_vals[2]);  
			}   
		break;
		case "DIALOG_PW_LIST_DELETE_USER":
			closeDialog();  
			if(typeof sendAjax == "function") {
				sendAjax(option_arr_vals[0]);  
			} 
		break;
		case "DIALOG_PW_LIST_SEND_MAIL_USER":  
			closeDialog(); 
			if(typeof sendAjax == "function") {
				sendAjax(option_arr_vals[1]);  
			}  
		break;
		case "CONF_SUBMIT_OK":
			closeDialog();
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[0]);
			}		 
		break;
		case "CONF_SUBMIT_VALIDATE":
			closeDialog();  
			if(typeof ajaxRequestData == "function") {
				ajaxRequestData(option_arr_vals[1]);
			}		 
		break;
		case "CONF_SUBMIT_CANCEL": 
			closeDialog(); 
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[2]);
			}		 
		break;
		case "CONF_RESULT_SUBMIT": 
			closeDialog(); 
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[0]);
			}			 
		break;
		case "CONF_RESULT_VALIDATE":
			closeDialog(); 
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[1]);
			}		 
		break;
		case "CONF_RESULT_CANCEL":
			closeDialog(); 
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[2]);
			}		 
		break; PRIVATE_STATUS_SUBMIT
		case "PRIVATE_STATUS_SUBMIT": 
		
			closeDialog(); 
			if(typeof ajaxRequestData == "function") {  
				ajaxRequestData(option_arr_vals[0]);
			}		 
		break;
		case "PRIVATE_STATUS_VALIDATE":
			closeDialog(); 
			if(typeof ajaxRequestData == "function") {  
				ajaxRequestData(option_arr_vals[1]);
			}			 
		break;
		case "PRIVATE_STATUS_CANCEL":  
			closeDialog();  
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[2]);
			}		 
		break;
		case "PUBLIC_DEFENCE_END_OF_PHD":   
			closeDialog();  
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[1]);
			}		 
		break;
		case "DIALOG_MANAGEMENT_DELETE_USER":
			closeDialog();  
			if(typeof ajaxSearchRequestData == "function") { 
				ajaxSearchRequestData(test);
			}	
			 		 
		break;
		case "DIALOG_MANAGEMENT_BLOCK_USER":
			closeDialog();  
			if(typeof ajaxSearchRequestData == "function") {   
				 ajaxSearchRequestData(test);
			}	 
		break;
		case "DIALOG_VALID_SIGNATURES_LINK": // 
			closeDialog();  
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[1]);
			}	
		break;
		case "DIALOG_CANCEL_SIGNATURES_LINK": // 
			closeDialog();  
			if(typeof ajaxRequestData == "function") { 
				ajaxRequestData(option_arr_vals[0]);
			}	
		break;
		 case "DIALOG_FIELD_SEARCH":
			closeDialog();  
			if(typeof saveResearch == "function") { 
				 
				saveResearch();
			}	
		break;
		case "DIALOG_FIELD_SEARCH_SAVE":
			closeDialog();  
			if(typeof searchData == "function") { 
				searchData();
			}	
		break;
		case "DIALOG_DELETE_LOAD_SEVED_QUERY":
			closeDialog();  
			if(typeof deleteLoadedQuery == "function") { 
				deleteLoadedQuery();
			}	
		break;
		default:
			closeDialog();
	} 
}

function eventButtonCancel() {  
	switch (classDialog.whence) {
		case "TEXTAREA_SAVE":
			closeDialog();   
			if (typeof saveTextarea == 'function') { cancelTextarea(); } 
		break;
		case "DIALOG_FIELD_SEARCH":  
			closeDialog();   
			if (typeof searchData == 'function') { 
		alert('df');	
	//		searchData();
	
			} 
		break;
		
		default:
			closeDialog(); return ; 
	}
}

function intervalTime() {
	closeDialog(); return;
}

function eventField(e) { }

var ID_TIME;
function setTimeProcessingDialog(times) {  
    ID_TIME = setTimeout("stopProcessingDialog()", times);
}

function intervalTimeProgress() {

	var mark = window.location.href.toString().split(window.location.host)[1].split("?");
		closeDialog(); 
		openDialog();
				
		setProcessingForwarding(1000, '?'+mark[1]);   
		var icon = classDialog.dialogIconObject.ICON_PROG; 
			showDialogObject.dialogSimple(null, 
									showText("DIALOG", "dialog", null, null), 
									showText("DIALOG", "reload", null, null), icon );	
			listener();
				
	  return;
}



function stopProcessingDialog() { 
	closeDialog();  
    clearTimeout(ID_TIME);
}

var LINK_FORWARDING = null;

function setProcessingForwarding(times, link) {  
	ID_TIME = setTimeout("stopProcessingForwarding()", times);
	LINK_FORWARDING = link;
}
 
function stopProcessingForwarding() {  
	if(LINK_FORWARDING == null) {
		window.location.reload();
	}  else {
		window.location.href = LINK_FORWARDING;
	}
	closeDialog();  
    clearTimeout(ID_TIME); 
}

function closeJSD() {
	if(document.getElementById("draggableSearch") && document.getElementById("dsj")) {
		var dr = document.getElementById("draggableSearch");
			dr.parentNode.removeChild(dr);
		var dsj = document.getElementById("dsj");
			dsj.parentNode.removeChild(dsj); 
	}
}

function base64_encode(data) {
	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
	ac = 0,
	enc = '',
	tmp_arr = [];

	if (!data) { return data; }

	do {  
		o1 = data.charCodeAt(i++);
		o2 = data.charCodeAt(i++);
		o3 = data.charCodeAt(i++);

		bits = o1 << 16 | o2 << 8 | o3;

		h1 = bits >> 18 & 0x3f;
		h2 = bits >> 12 & 0x3f;
		h3 = bits >> 6 & 0x3f;
		h4 = bits & 0x3f;
		
		tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
	} while (i < data.length);
	enc = tmp_arr.join('');
	var r = data.length % 3;
		return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
}	
 
function base64_decode (data){
    var e = {}, i, k, v = [], r = '', w = String.fromCharCode;
    var n = [[65, 91], [97, 123], [48, 58], [43, 44], [47, 48]];

    for (z in n) {
        for (i = n[z][0]; i < n[z][1]; i++) {
            v.push(w(i));
        }
    }
    for (i = 0; i < 64; i++) {
        e[v[i]] = i;
    }

    for (i = 0; i < data.length; i+=72) {
        var b = 0, c, x, l = 0, o = data.substring(i, i+72);
        for (x = 0; x < o.length; x++) {
            c = e[o.charAt(x)];
            b = (b << 6) + c;
            l += 6;
            while (l >= 8) {
                r += w((b >>> (l -= 8)) % 256);
            }
         }
    }
    return r;
}

function delCookies() {
	var pairs = document.cookie.split(";");
	var cookies = {};
		for (var i = 0; i < pairs.length; i++){		 
			var pair = pairs[i].split("=");  
			var g = pair[0].substring(0, 4);
			var reg = new RegExp("(NEW|OLD)");
			if(reg.test(g)){
				document.cookie = pair[0] + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			} 
		}
}

function isValidURL(url){
    var RegExp = classForm.REG_URL;
    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }
} 

function createPDF(id, where) {
	if(id.indexOf("pdf") !== -1 ) {
		var spl = id.split("pdf");
		var mark = window.location.href.toString().split(window.location.host)[1].split("?");
		var url = false;
		switch(where) {  
			case 'show_list':
				url = "modules/pdf/pages/inc_tmp_pdf.php/?test=show_list"+"&pdf=get"+"&id="+spl[1];
			break;
			case 'adm_submit': //  
				url = "modules/pdf/pages/inc_tmp_pdf.php/?test=adm_submit"+"&pdf=get"+"&id="+spl[1];
			break;
			case 'private_defence_submit':
				url = "modules/pdf/pages/inc_tmp_pdf.php/?test=private_defence_submit"+"&pdf=get"+"&id="+spl[1];
			break;
		}
		if(url) {
			window.open(url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=20, left=20, width=900, height=700");
		} else {
		var icon = classDialog.dialogIconObject.ICON_ERROR;
			showDialogError('ERROR MAIN JS : IMPOSSIBLE TO CREATE PDF  ', icon); 
			return false;
		} 
	}
}

function setCookie(name, value, path, expires, domain, secure) {

	if(listCookies() > 20  ) { return; }
	 if(value.length > 4000 ) {
		var icon = classDialog.dialogIconObject.ICON_ERROR;
			showDialogError('ERROR MAIN JS : IMPOSSIBLE TO CREATE COOKIE  ', icon); 
		 return ;
	}
	document.cookie = name + "=" + escape (value) +
	((expires) ? "; expires=" + expires.toGMTString() : "") +
	((path) ? "; path=" + path : "") +
	((domain) ? "; domain=" + domain : "") +
	((secure) ? "; secure" : "");             
}

function listCookies() {
    var theCookies = document.cookie.split(';');
    return theCookies.length;
}


 
function getCookie(name) {	 
	var prefix = name + "=";
	var cookieStartIndex = document.cookie.indexOf(prefix);
	if(cookieStartIndex == -1) 
		return null;
	var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
	if(cookieEndIndex == -1) 
		cookieEndIndex = document.cookie.length;
	return unescape(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
}

function reloadPage() {
	if (typeof destroyCookieTrack == 'function') { destroyCookieTrack(false); return; }
	location.reload();
}

function destroyCookieTrack(revise) { 
	 
	  
	if(typeof items != undefined) {
		if(getCookie(items[0])) {
			setCookie(items[0],     " ", '/', new Date(new Date().getTime()-timeCookie));  
		} if(getCookie(items[1])) { 
			setCookie(items[1],     " ", '/', new Date(new Date().getTime()-timeCookie)); 
		}
	}	
	
	if(!revise) {  
		location.reload();
		return;
	} else {
		 
		if(items[0] ==  undefined ) {
			addrTrack();  
			var cOld = prefixOldCookie+this.paramAddr;
			var cNew = prefixNewCookie+this.paramAddr;
			
			if(getCookie(cOld)) {
				setCookie(cOld,     " ", '/', new Date(new Date().getTime()-timeCookie));  
			} if(getCookie(cNew)) {
				setCookie(cNew,     " ", '/', new Date(new Date().getTime()-timeCookie)); 
			}
		}
		if (typeof initTrack == "function") { 
			initTrack(); displayMessageTrack(false, ''); 
		}  
	}
}

function pagination(){
	var m = document.getElementById("pagination");
	var num = m.options[ m.selectedIndex ].value;
	var uri = window.location.href.toString().split(window.location.host)[1];
	
	closeDialog();
	openDialog();

	var icon = classDialog.dialogIconObject.ICON_PROG; 
			showDialogObject.dialogSimple(null, 
						showText('DIALOG', 'dialog', null, null),
						showText('DIALOG', 'waiting', null, null), icon );	
	listener();

	if(uri.indexOf("offset") !== -1 ) {
		var spl = uri.split("offset");
			window.location.href = spl[0]+"offset="+num;
	} else { 
 
		 window.location.href = uri+"&offset="+num;
	}
}

function butDeleteIMG(patch, id_gen) {
	
	this.patch = patch; 
	this.id_gen = id_gen;
	//this.address = "modules/my_phd/pages/admission/req/req_research_delete_file.php";
	//req_unlink.php

	this.address = "modules/upload/req_unlink.php";
	closeDialog();
	openDialog();
	
	classDialog.whence = "DELETE_THE_DOWNLOADED_PDF";
	var icon = classDialog.dialogIconObject.ICON_WARNING;  
				showDialogObject.dialogConfirm(null, 
									showText('DIALOG', 'dialog', null, null), 
									showText('DIALOG', 'delete_downloaded_pdf_confirm', null, null) , icon, 'OK', 'CANCEL');	
	listener();  
}

function getBrowserInfo() {
    var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
    if(/trident/i.test(M[1])){
        tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
        return {name:'IE ',version:(tem[1]||'')};
        }   
    if(M[1]==='Chrome'){
        tem=ua.match(/\bOPR\/(\d+)/)
        if(tem!=null)   {return {name:'Opera', version:tem[1]};}
        }   
    M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
    return {
		name: M[0],
		version: M[1]
    };
}
 
$(function() { 
	 
	var browser = getBrowserInfo();
	var tem=browser.name.match(/(Firefox|IE)/);
	
    if(tem == null)   { return; }

	var adm_menu = false;
    // Stick the to the top of the window  
    var nav = $('#menu_left');
	var navHomeY = nav.offset().top;
	
	if (($("#cssmenu").length > 0)){
		var nav_center = $('#cssmenu');
		var navRightY = nav_center.offset().top;
		var adm_menu = true;
	}
	
	var nav_ic_right = $("#ic_nav_right");
	var navIcRightY = nav_ic_right.offset().top;
	
    var isFixed = false;
    var $w = $(window);
    $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
				 
			nav.css("cssText", nav.css("cssText")+
			"position: fixed; top:0px;");
			
			if(adm_menu) {
				nav_center.css("cssText", nav_center.css("cssText")+
				"position: fixed!important;top:0px!important;margin: auto opacity: 0.9; background:#F0F0F0; border: 1px solid #D6D6D6; max-width:630px; padding:5px; box-shadow: 5px 5px 5px rgb(136, 136, 136);");
			}
			
			nav_ic_right.css('cssText', nav_ic_right.css("cssText")+
			"position: fixed!important; transition: 0.5s !important; top: 65px!important;   right:0px;   z-index:0; ");
			
            isFixed = true;
        }
        else if (!shouldBeFixed && isFixed) {
			// remove id wrap responsive 
			
			nav.css("cssText", nav.css("cssText")+
				"position: relative;  float:left;");
			
		if(adm_menu) {			
			nav_center.css("cssText", nav_center.css("cssText")+
				" width:633px;");
		}
		
			nav_ic_right.css("cssText", nav_ic_right.css("cssText")+
				"position:absolute;   right:0;   z-index:0;  ");	
				isFixed = false;
        }
    });
});



