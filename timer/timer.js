
var curl = "timer/timer.php";
var USERS = {};
var send_connect = new FormData(); 
var res = {};

USERS.connexion = function( ) { 
 
	this.add = [];
	
	if(!( this instanceof USERS.connexion)) { 
		return new USERS.connexion( );
	};
	
	this.sleep = function(time) {
		
		return new Promise((resolve) => setTimeout(resolve, time));
	};

	this.checkConnexion = function (iduser, iddiv) { 

		this.sleep(5000).then(() => {
		 
			var sst = new USERS.connexion( );
  
			var httpRequest = createRequest();
			if(httpRequest != null) {
				
				httpRequest.open("POST", curl, true);
				httpRequest.onreadystatechange = function() { 
		 
					if (httpRequest.readyState == 4) {  
						var resRequest = httpRequest.responseText;
						if(resRequest == "" ) return ;
						var response = JSON.parse(resRequest);
						sst.abortConnected(); 
						 
						sst.showSingleConnected(iddiv, response);  
						sst.checkConnexion(iduser, iddiv); 
						 
					}
				}
				
				var mark = window.location.href.toString().split(window.location.host)[1].split("?"); 
						
				send_connect.append("asynchronous", "asynchronous");
				send_connect.append("page", mark[1]);
				send_connect.append("iduser", iduser);
				httpRequest.send(send_connect);
			}
		});	
	};
	
	this.checkConnexionAll = function (iddiv) {
	
		this.sleep(2500).then(() => {
			var sst = new USERS.connexion( );
			var httpRequest = createRequest();
			if(httpRequest != null) {
				httpRequest.open("POST", curl, true);
				httpRequest.onreadystatechange = function() { 
		 
					if (httpRequest.readyState == 4) {  
						var resRequest = httpRequest.responseText;
						if(resRequest == "" ) return ;
						var response = JSON.parse(resRequest);
						
						document.getElementById(iddiv).innerHTML = "";
					 
						for(var i in response ) {
							if( response[i].status == undefined ) continue;
							sst.showAllConnected(iddiv, response[i]); 
 	 
						}
						sst.abortConnected();  
						sst.checkConnexionAll(iddiv); 	 
					}
				}
				
				send_connect.append("asynchronous", "asynchronous");
				send_connect.append("iduser", 0);
				httpRequest.send(send_connect);
			}
		});
	};
	
	this.showAllConnected = function(iddiv, response) {
		 		
		var sst = new USERS.connexion( );  
		
		if(document.getElementById(iddiv) ) { 
		
			if(!document.getElementById("list-"+response.id_user)) {
				var g = document.createElement("div");
					g.setAttribute("id", "list-"+response.id_user);
					document.getElementById(iddiv).appendChild(g); 	
			}
			this.i = response.id_user ;  

			document.getElementById("list-"+response.id_user).innerHTML = (
								"<div style='box-shadow: 1px 1px 5px rgb(136, 136, 136); margin:5px; padding:5px;'>"+"<br>"+
								 this.imgConnected(true, 'EVENT')+ 
								 " <b style='color:green;'> CONNECTED : </b>" +response.timer_deconnected+"<br>"+
								 " <b style='color:green;'> FIRNS NAME : </b>" +response.first_name+"<br>"+
								 " <b style='color:green;'> LAST NAME : </b>" +response.last_name+"<br>"+
								 " <b style='color:green;'> IP : </b>" +response.ip +"<br>"+
								 " <b style='color:green;'> NAVIGATOR : </b>" +response.navigator+"<br>"+
								 " <b style='color:green;'> OS : </b>" +response.os+"<br>"+
								 " <b style='color:green;'> PAGE : </b>" +response.page+"<br>"+
								 "</div>"
			) ;	 
		}		
	};
	
	this.showSingleConnected = function(iddiv, response) {
		var sst = new USERS.connexion( );
		 
		if(iddiv.indexOf("timer-") != -1)  {
			 
			if(document.getElementById(iddiv)) {
				res =  response; 
				if (typeof response.timer_deconnected == "undefined") return;
				
				document.getElementById(iddiv).innerHTML = (
						sst.checkUserConnected(response) ?
						sst.imgConnected(true , '') : 
						sst.imgConnected(false, '')+" User has been disconnected :" +response.timer_deconnected
				) ;
			}
		}	
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
	};
	
	this.imgConnected = function(bool, js) {  
	
		if(bool) { 
			if(js == 'EVENT') {
			 
				var js = 'onclick="butListUser(\'SEL_USER\', \''+this.i+'\', \' \');"';
				return "<img class='icon_num' src='timer/penguinlive.png' align='middle' "+js+"/ >";
				
			} 
			
			var rand = "110111110011011110111111111011111011";
			var js = 'onclick="return getHelp(\''+rand+'\', event, \'ONLINE\');"';
			 
			return "<img class='' src='timer/penguinlive.png' align='middle' "+js+"/ >"+
				"<div id='"+rand+"' style='display:none;' >"+
					"<br> <b style='color:green;'> FIRST NAME  : </b> "+ res.first_name+ "<br>"+
					"<br> <b style='color:green;'> STATUS : </b> Connected <br>"+
				"</div>";
				
		} else {
			return " <img src='timer/penguindead.png' align='middle' / >";
		}
		
	};
	
	this.established = function (iduser, iddiv) {
		this.checkConnexion(iduser, iddiv);
	}; 
	
	this.establishedAll= function (iddiv) {
		this.checkConnexionAll(iddiv)  ;
	};
 
}
