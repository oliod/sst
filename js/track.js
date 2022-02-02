
var jsonArrInputOld = [];
var jsonArrInputNew = [];
var items = [];
 
//window.onload = initTrack;

var elemRegex = new RegExp('(select-one|text|textarea)');
var colorOld = "#FFFFFF";
var colorNew = "#D9D9DB";
var timeCookie = 3600000;

var paramAddr = "";
var prefixOldCookie = "OLD";
var prefixNewCookie = "NEW"; 
var markUri = "page"; // this uri mark ;
var obj = new Object();
var divDisplay = "track_div";

function initTrack() {
	 
	if(!addrTrack() || !navigator.cookieEnabled || !document.getElementById(divDisplay)) return; 
	    
	var selects = document.getElementsByTagName("select");
	for (var index = 0; index < selects.length; ++index) {
		 
		
		if(selects[index].id != "" ) { 
			var inSelected = document.getElementById(selects[index].id);
			jsonArrInputOld.push({ 
							id: selects[index].id, 
							value: inSelected.options[inSelected.selectedIndex].value,
							txt: inSelected.options[inSelected.selectedIndex].text,
							type: selects[index].type // select-one
			});
			document.getElementById(selects[index].id).addEventListener("change",  eventKeyTrack );
		}	
	}
	
	var txtarea = document.getElementsByTagName("textarea");
	for (var index = 0; index < txtarea.length; ++index) {
		if(txtarea[index].id != "") {
			jsonArrInputOld.push({ 
							id: txtarea[index].id, 
							value: txtarea[index].value,
							type: txtarea[index].type.toLowerCase()
			});
			document.getElementById(txtarea[index].id).addEventListener("keyup",  eventKeyTrack );
		}
	}
	var inputs = document.getElementsByTagName("input");
	for (var index = 0; index < inputs.length; ++index) {
		if(inputs[index].type == "text" && (inputs[index].id != "")) {
			jsonArrInputOld.push({ 
							id: inputs[index].id, 
							value: inputs[index].value,
							type: inputs[index].type.toLowerCase()
			});
			document.getElementById(inputs[index].id).addEventListener("keyup",  eventKeyTrack );
		} else if(inputs[index].type == "checkbox" && (inputs[index].id != "") ) {  
			jsonArrInputOld.push({ 
							id: inputs[index].id, 
							value: inputs[index].checked,
							type: inputs[index].type.toLowerCase()						
			});
			document.getElementById(inputs[index].id).addEventListener("click",  eventKeyTrack);
		} else if(inputs[index].type == "radio"  && (inputs[index].id != "")) {
			jsonArrInputOld.push({
							id: inputs[index].id, 
							value: inputs[index].checked,
							name: inputs[index].name,
							type: inputs[index].type.toLowerCase()							
			});
			document.getElementById(inputs[index].id).addEventListener("click",  eventKeyTrack);
		}
	}
	// this name cookie 
	items = [prefixOldCookie+paramAddr, prefixNewCookie+paramAddr, (jsonArrInputOld.length > 0 ? jsonArrInputOld : 0)];

	if(items[2] != 0) { 
		if(getCookie(items[0])) { 
			inputDataTrack(items[0], false, false, items[1]);  
			 
		} else { 	
			var jsonInputData = JSON.stringify(items[2]);
			setCookie(items[0], jsonInputData, '/', new Date(new Date().getTime()+timeCookie));	
		}
	}	
	jsonArrInputOld = [];
} 

function inputDataTrack(nameCookieOld, revise, inputEvent, nameCookieNew ) {
	   
	var found = revise.toString(); 
  
	if(!getCookie(nameCookieOld) && !getCookie(nameCookieNew)) { return; }
	var jsonOldData = JSON.parse(getCookie(nameCookieOld));
	var jsonNewData = JSON.parse(getCookie(nameCookieNew));
	 
	// if the user clicked
	if(typeof inputEvent == "object") {
		return ((!check(jsonOldData, jsonNewData, inputEvent)) ? displayMessageTrack(true, '') : displayMessageTrack(false, '')) 			
	}	
	    
	look1: 
	for(var dOld in jsonOldData) {  // old data 
	 
		var attr = (jsonOldData[dOld].type != "select-one" ? jsonOldData[dOld].value : jsonOldData[dOld].txt);
			if(!document.getElementById(jsonOldData[dOld].id)) continue;
			document.getElementById(jsonOldData[dOld].id).setAttribute("title",  attr);
		 
		look2: 
		for(var dNew in jsonNewData) { // new data 
		 
			if(jsonOldData[dOld].id == jsonNewData[dNew].id) {
				if(jsonOldData[dOld].value != jsonNewData[dNew].value) { 
					if(jsonNewData[dNew].type == "checkbox") {  //checked 
						document.getElementById(jsonNewData[dNew].id).setAttribute("checked", jsonNewData[dNew].value);
						found += "true"; 
					} else if(jsonNewData[dNew].type == "radio") { //checked 
						document.getElementById(jsonNewData[dNew].id).setAttribute("checked", jsonNewData[dNew].value);
						found += "true";
					} else if(jsonNewData[dNew].type == "select-one") { // selected
							var select = document.getElementById(jsonNewData[dNew].id);
							for (var i = 0; i < select.length; i++) { 
								if(select.options[i].value == jsonNewData[dNew].value) {
									select.options[i].selected = true ;
								} else {
									select.options[i].selected = false;
								}
							}
						document.getElementById(jsonNewData[dNew].id).style.background = colorNew;
						found += "true";
					} else {
						document.getElementById(jsonNewData[dNew].id).value = jsonNewData[dNew].value;
						document.getElementById(jsonNewData[dNew].id).style.background = colorNew;
						found += "true";
					}
				}  			
			}				
		}					
	}		
	 
	if(found.indexOf("true") !== -1) {  
		displayMessageTrack(true, '');  
	} else { 
	 
		destroyCookieTrack(true); 
		displayMessageTrack(false, ''); 
	} 
}

function check(jsonOldData, jsonNewEventData, inputEvent) {
	 
	var revise = true;
	for(var i in jsonOldData) {
		if(jsonOldData[i].id  == inputEvent.id) {
			if(inputEvent.type == "checkbox" || inputEvent.type == "radio") {
				if(jsonOldData[i].value == inputEvent.checked) {
					break;
				} else {
					return false;
				}
			} else if(jsonOldData[i].value == inputEvent.value) {
				document.getElementById(inputEvent.id).style.background = colorOld;
				break;
			} else {
				document.getElementById(inputEvent.id).style.background = colorNew;
				return false;
			}
		}
	}
	 
	for(var i in jsonOldData) {
		for(var j in jsonNewEventData) {
			if(jsonOldData[i].id == jsonNewEventData[j].id) {
				if(jsonOldData[i].value == jsonNewEventData[j].value) {
					document.getElementById(jsonOldData[i].id).style.background = colorOld;
				} else {
					if(document.getElementById(jsonOldData[i].id)) {
						document.getElementById(jsonOldData[i].id).style.background = colorNew;
						revise = false;
					}
				}
			}
		}
	}
	return ((revise) ? true : false);
}

function displayMessageTrack(revise, n) { 
	if(document.getElementById(divDisplay)) {
		var d = document.getElementById(divDisplay); 
		if(revise) {
			d.className = "track_show";
			d.innerHTML = " Data has been modified but not yet saved ";
		} else { 
			colorFieldsTrack();
			d.className = "track_hide";
			d.innerHTML = " "; 
		}
	}	
}

function colorFieldsTrack() {
/*
	var fields = document.getElementsByTagName("input");
	for(var i=0; i < fields.length; i++){
		if(fields[i].type == "text" || fields[i].type == "password" ) {
            //fields[i].style.backgroundColor = colorOld;
        }
    }
	
	var textarea = document.getElementsByTagName("textarea");
	for(var i=0; i < textarea.length; i++) {
        textarea[i].style.backgroundColor = colorOld;
    }
	
	var select = document.getElementsByTagName("select");
	for(var i=0; i < select.length; i++){
        select[i].style.backgroundColor = colorOld;
    }	
	*/
}

function eventKeyTrack(e) { 
	addNewDataTrack(items[1] , this);
	inputDataTrack(items[0], false, this, items[1]);
}

// add new data in cookie and give the name for cookie
function addNewDataTrack(nameCookieNew, inputEvent) {

	if(inputEvent.type == "select-one") { 
		var inSelected = document.getElementById(inputEvent.id);
		var selectedIndex = inSelected.options[inSelected.selectedIndex].text;
	}
	
	if(!getCookie(nameCookieNew) ) {
		jsonArrInputNew.push({ 
					id: inputEvent.id, 
					value: (elemRegex.test(inputEvent.type) ? inputEvent.value : inputEvent.checked),
					type: inputEvent.type	 						
		});
		
		if(inputEvent.type == "select-one") { 
			jsonArrInputNew[0].txt = selectedIndex;
		} else if(inputEvent.type == "radio") {
			jsonArrInputNew[0].name = inputEvent.name;
		}

		var jsonInputNew = JSON.stringify(jsonArrInputNew);  
			setCookie(nameCookieNew, jsonInputNew, '/', new Date(new Date().getTime()+timeCookie)); 
			return;
	} else { 		 

		var jsonNewEventData  = JSON.parse(getCookie(nameCookieNew));
		var found = false; 
		var k = 0;
		for(k in jsonNewEventData) {  
			if(jsonNewEventData[k].id == inputEvent.id) {
				found = true;
				if(inputEvent.type == "select-one") {
					jsonNewEventData[k].txt = selectedIndex;
				} else if(inputEvent.type == "radio") {
					if(jsonNewEventData[k].name == inputEvent.name) { 
						jsonNewEventData[k].id = inputEvent.id;
						break;
					} else {
						jsonNewEventData[k].name = inputEvent.name;
					}	
				}
				
				jsonNewEventData[k].value = (elemRegex.test(inputEvent.type) ? inputEvent.value : inputEvent.checked);
				break;
				
			} else {
				if(inputEvent.type == "radio") { 
					if(jsonNewEventData[k].name == inputEvent.name) {
						jsonNewEventData[k].id = inputEvent.id;
						jsonNewEventData[k].value = inputEvent.checked;
						found = true;
						break;
					}
				}
			}  
		}
		
		if(!found) {
			jsonNewEventData.push({ 
						id: inputEvent.id, 
						value: (elemRegex.test(inputEvent.type) ? inputEvent.value : inputEvent.checked),
						type: inputEvent.type							
			});
			
			if(inputEvent.type == "select-one") { 
				jsonNewEventData[(++k)].txt = selectedIndex;
			} else if(inputEvent.type == "radio") {
				jsonNewEventData[(++k)].name = inputEvent.name;
			}
			
		}
		var jsonInputNew = JSON.stringify(jsonNewEventData);
			setCookie(nameCookieNew, jsonInputNew, '/', new Date(new Date().getTime()+timeCookie)); 
	}	 	
}

 
/*	
function setCookie(name, value, path, expires, domain, secure) {
 
	document.cookie = name + "=" + escape (value) +
	((expires) ? "; expires=" + expires.toGMTString() : "") +
	((path) ? "; path=" + path : "") +
	((domain) ? "; domain=" + domain : "") +
	((secure) ? "; secure" : "");             
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
*/
function queryParamsTrack(qs) {
    qs = qs.split('+').join(' ');
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;
    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
    }
	 
    return params;
}

function addrTrack( ) {
	 
	var query = queryParamsTrack(document.location.search);
	if((typeof query != "object") || (!(markUri in query)) ) return false;
	 
	paramAddr = (paramAddr.length > 0 ? "" : paramAddr);
	for(var h in query) { 
		paramAddr += query[h]; 
	}
	if(paramAddr == "") { 
		return false; 
	}
	 
	return paramAddr;
}
