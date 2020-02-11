//GESTIONE DELLE RICHIESTE AJAX

function performAjaxRequest(method, url, isAsync, dataToSend, responseFunction, isEncoded){
	var xmlHttp = new XMLHttpRequest();
	if(xmlHttp == null)
		return "Errore, il tuo browser non supporta AJAX";
 	xmlHttp.onreadystatechange = function() {
   		if (this.readyState == 4 && this.status == 200) {
   			if(isEncoded == true){
   				//window.alert(this.responseText);
	   			var myObj = JSON.parse(this.responseText);
	   			responseFunction(myObj);
	   		}
   			else responseFunction(this.responseText);
    	}
 	};
  	xmlHttp.open(method, url, isAsync);
  	if(method == "POST"){
  		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	  	xmlHttp.send(dataToSend);
	}
	else xmlHttp.send();
}