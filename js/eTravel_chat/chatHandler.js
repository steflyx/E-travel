//GESTIONE DELLA CHAT

var IS_LAST_DESTINATARIO = 1;
var IS_LAST_MITTENTE = 0;
var IS_LAST_NON_SPECIFICATO = -1;
var URL_CHAT_HANDLER = "./functionalities/chatHandler/chatHandler.php";


var lastSender = IS_LAST_NON_SPECIFICATO;
var intervalloChat;

//Il nome del mittente viene impostato direttamente tramite PHP
//Quello del destinatario dipende dai casi (ad esempio in home.php si imposta tramite javascript)
var userDestinatario;


//Mostra a video il nome dell'utente che sta inviando i messaggi (quello memorizzato da 'lastSender')
function changeLastSender(){
	var nomeUtente = document.createElement("h6");
	nomeUtente.className = "nomeLastSender";
	if(lastSender == IS_LAST_DESTINATARIO)
		nomeUtente.textContent = userDestinatario;
	else nomeUtente.textContent = userMittente;
	document.getElementById("divMessage").appendChild(nomeUtente);
}

//Attiva una richiesta Ajax per controllare se è arrivato un nuovo messaggio
function checkNewMessage(){
	var url = URL_CHAT_HANDLER;

	//Mittente e destinatario sono invertiti perché qui il destinatario è chi invia la richiesta (ovvero l'user della sessione attuale)
	var dataToSend = "isThereNewMessage=1&userDestinatario=" + userMittente + "&userMittente=" + userDestinatario;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showMessageDestinatario, false);
}

//Funzione che chiude la chat
function closeChat(){
	document.getElementById("divChatBackground").style.display = "none";
	clearInterval(intervalloChat);
}

//Attiva una richiesta Ajax al server per inviare un messaggio
function sendMessage(){
	var url = URL_CHAT_HANDLER;
	var text = document.getElementById("inputUserMessage").value;
	document.getElementById("inputUserMessage").value = "";
	if(text == null)
		return;

	var dataToSend = "text=" + text + "&userDestinatario=" + userDestinatario + "&userMittente=" + userMittente;

	performAjaxRequest("POST", url, true, dataToSend, showMessageMittente, false);
}

//Funzione che fa apparire la chat e imposta la foto profilo e il nome dell'utente con cui si sta chattando
function showChat(pathFotoProfilo, nomeUtente){

	//Div che contiene la chat (inizialmente non visibile)
	document.getElementById("divChatBackground").style.display = "block";

	//Settaggio dell'immagine profilo
	if(pathFotoProfilo != "default"){ //Se l'immagine è quella di default, l'url è già nel CSS
		var pathBase = "../upload/";
		var pathFinale = pathBase + pathFotoProfilo;
		document.getElementById("divImgProfiloChat").style.backgroundImage = "url('" + pathFinale + "')";
	}

	//Settaggio del nome dell'utente con cui stiamo parlando
	var titoloNomeUtente = document.getElementById("chatNomeUtente")
	if(titoloNomeUtente == null){
		titoloNomeUtente = document.createElement("h5");
		titoloNomeUtente.id = "chatNomeUtente";
		document.getElementById("divChatUp").appendChild(titoloNomeUtente);
	}
	titoloNomeUtente.textContent = nomeUtente;
	

	//Richiamiamo periodicamente la funzione che controlla i nuovi messaggi in arrivo
	intervalloChat = setInterval(checkNewMessage, 1000);
}

//Mostra a video un messaggio arrivato tramite chat
function showMessage(text){	
	//Messaggio
	var divContenitore = document.getElementById("divMessage");
	var newMsg = document.createElement("p");
	newMsg.className = "chatMessage";

	//Timestamp
	var d = new Date();
	newMsg.textContent = "(" + d.getHours() + ":" + d.getMinutes() + ") " + text;
	divContenitore.appendChild(newMsg);
}

//Prima di mostrare a video il messaggio, controllano se bisogna cambiare il nome dell'ultimo utente che ha inviato un messaggio
//Si cambia il nome dell'ultimo utente con il nome del destinatario
function showMessageDestinatario(text){
	if(text == "")
		return;

	if(lastSender == IS_LAST_NON_SPECIFICATO || lastSender != IS_LAST_DESTINATARIO){
		lastSender = IS_LAST_DESTINATARIO;
		changeLastSender();
	}

	showMessage(text);
}

//Si cambia il nome dell'ultimo utente con il nome del mittente
function showMessageMittente(text){
	if(text == "")
		return;

	if(lastSender == IS_LAST_NON_SPECIFICATO || lastSender != IS_LAST_MITTENTE){
		lastSender = IS_LAST_MITTENTE;
		changeLastSender();
	}

	showMessage(text);
}