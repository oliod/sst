 
var request = null;
function createRequest() 
 {
 
     try {
       request = new XMLHttpRequest();
     } catch (exception1) {
       try {
         request = new ActiveXObject("Msxml2.XMLHTTP");
       } catch (exception2) {
         try {
           request = new ActiveXObject("Microsoft.XMLHTTP");
         } catch (exception3) {
           request = null;
         }
       }
     }
      return request;
 }

 
var curl = "asy.php";
var USERS = {};
var send_connect = new FormData(); 
var sst_timer = 5000;

USERS.connexion = function( ) { 
 
	this.add = [];
	if(!( this instanceof USERS.connexion)) { 
		return new USERS.connexion( );
	};
	this.sleep = function(time) {
		
		return new Promise((resolve) => setTimeout(resolve, time));
	};
 
	this.checkConnexion = function (iduser, iddiv) { 

		this.sleep(sst_timer).then(() => {
	
			var sst = new USERS.connexion( );
  
			var httpRequest = createRequest();
			if(httpRequest != null) {
				
				httpRequest.open("POST", curl, true);
				httpRequest.onreadystatechange = function() { 
		 
					if (httpRequest.readyState == 4) {  
						var resRequest = httpRequest.responseText;	
						var response = JSON.parse(resRequest);
				 
						sst.abortConnected(); 
							
							document.getElementById(iddiv).innerHTML = (
								sst.checkUserConnected(response) ?
								sst.imgConnected(true) : 
								sst.imgConnected(false)
							) ;
						 
						sst.checkConnexion(iduser, iddiv); 
					}
				}
				
				send_connect.append("asynchronous", "sendconnect");
				send_connect.append("iduser", iduser);
				httpRequest.send(send_connect);
			}
		});	
	};
	
	this.abortConnected = function() {
		const controller = new AbortController();
		controller.abort();
		return;
	};
	
	this.checkUserConnected = function (connected) {
	 
		if(typeof connected == "object") {
			if(connected.status == 777) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}
	
	this.imgConnected = function(bool) {  
		if(bool) {
			return "<img src='penguinlive.png' / >";
		} else {
			return "<img src='penguindead.png' / >";
		}
		
	};
	
	//settle
	this.established = function (iduser, iddiv) {

		var sst = new USERS.connexion( );
		sst.checkConnexion(iduser, iddiv);
	}; 
	 
}
	
 














