//VISUALIZZAZIONE DEI MESSAGI

var URL_GET_MESSAGE_NOT_READ = "./functionalities/chatHandler/getMessageNotRead.php";

//Funzione che permette di utilizzare la chat anche nella home settando la variabile globale 'userDestinatario'
function showChatHome(pathFotoProfilo, usernameUtente){
	userDestinatario = usernameUtente;
	showChat(pathFotoProfilo, usernameUtente);
}

//Mostra sull'homepage i messaggi non letti
function showMessageNotRead(messageObjectArray){
	var pathBase = "../upload/";
	var divWrapper = document.getElementById("divFeedWrapper");
	for(var i=0; i<messageObjectArray.length; i++){
		
		//Recupero del path dell'immagine profilo
		var pathFotoProfilo;
		if(messageObjectArray[i].pathFotoProfilo == "default")
			pathFotoProfilo = "../css/immagini/fotoProfiloIcon.jpg";
		else{
			pathFotoProfilo = pathBase + messageObjectArray[i].pathFotoProfilo;
		}

		//Contenitore del messaggio
		var divContenitore = document.createElement("div");
		divContenitore.className = "divMessageContenitore";
		//Associamo al contenitore l'username dell'utente in modo da poter aprire la chat anche nella home
		divContenitore.usernameAssociato = messageObjectArray[i].usernameUtente;
		divContenitore.fotoProfiloAssociata = pathFotoProfilo;
		divContenitore.addEventListener("click", function(){showChatHome(pathFotoProfilo, this.usernameAssociato);});

		//Immagine profilo
		var fotoProfilo = document.createElement("img");
		fotoProfilo.setAttribute("src", pathFotoProfilo);
		fotoProfilo.setAttribute("alt", "foto profilo");
		fotoProfilo.className = "fotoProfiloUserInfo";
		divContenitore.appendChild(fotoProfilo);

		//Nome
		var nome = document.createElement("h5");
		nome.textContent = messageObjectArray[i].mittente;
		divContenitore.appendChild(nome);

		//Messaggio
		var messaggio = document.createElement("p");
		messaggio.textContent = messageObjectArray[i].testo;
		divContenitore.appendChild(messaggio);

		divWrapper.appendChild(divContenitore);
	}	
	
	//Nessun messaggio
	if(messageObjectArray.length == 0){
		var messaggioErrore = document.createElement("p");
		messaggioErrore.textContent = "Nessun nuovo messaggio";
		messaggioErrore.style.textAlign = "center";
		divWrapper.appendChild(messaggioErrore);
	}
}

//Inoltra una richiesta Ajax per ottenere i messaggi non letti di un utente
function showMessageToBeRead(){
	removeFeed("Messaggi non letti");

	var url = URL_GET_MESSAGE_NOT_READ;

	var dataToSend = "user=" + usernameUtente;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showMessageNotRead, true);
}

