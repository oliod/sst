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
 
 function abortAJAX(httpRequest) {
	if(httpRequest.readyState != 4 && httpRequest.readyState != 0) {
		httpRequest.onreadystatechange = function() { };
		httpRequest.abort(); 
		window.location.reload();
		return;
	}
}