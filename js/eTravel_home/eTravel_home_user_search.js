//FUNZIONI CHE GESTISCONO LA RICERCA DI ALTRI USER

var UTENTI_PREFERITI = 0;
var UTENTI_CHASER = 1;
var UTENTI_POPOLARI = 2; //Sarebbe la funzione 'trova amici'

var URL_SEARCH_BASE = "./functionalities/searchHandling/";

//Funzione che rimuove tutti i contenuti del feed e li sostituisce con un nuovo wrapper e un nuovo titolo
function removeFeed(nuovoTitolo){
	var wrapper = document.getElementById("divFeedWrapper");

	//I pointer relativi a viaggi del feed vanno rimossi manualmente
	var limitRight = wrapper.offsetLeft;
	var arrayOldPointer = document.getElementsByClassName("imgMapPointer");
	var arrayNewPointer = new Array();
	var length = arrayOldPointer.length;
	for(var i=0; i<length; i++){
		//Salviamo i pointer che NON vanno rimossi (quelli delle proposte)
		if(arrayOldPointer[i].offsetLeft < limitRight)
			arrayNewPointer[i] = arrayOldPointer[i].offsetLeft + "&" + arrayOldPointer[i].offsetTop;
	}

	//Rimuoviamo tutti i pointer
	for (var i = 0; i < length; i++) {
		arrayOldPointer[0].remove();	
	}

	//Reinseriamo i pointer da NON rimuovere
	for(var i=0; i<arrayNewPointer.length; i++){
		var pointer = document.createElement("div");
		pointer.className = "imgMapPointer";
		var position = arrayNewPointer[i].split("&");
		pointer.style.left = position[0] + "px";
		pointer.style.top = position[1] + "px";
		document.body.appendChild(pointer);
	}

	wrapper.remove();

	//Nuovo div contenitore
	var divWrapper = document.createElement("div");
	divWrapper.id = "divFeedWrapper";
	document.getElementsByTagName("article")[0].appendChild(divWrapper);

	//Nuovo titolo
	var titoloUtentiPreferiti = document.createElement("h4");
	titoloUtentiPreferiti.textContent = nuovoTitolo;
	divWrapper.appendChild(titoloUtentiPreferiti);
}

//Funzione che inoltra una richiesta Ajax per effettuare una ricerca fra tutti gli utenti
function searchUser(pattern){
	if(pattern == null || pattern.length === 0)
		return;

	removeFeed("Corrispondenze");

	var url = URL_SEARCH_BASE + "searchUser.php";

	var dataToSend = "pattern=" + pattern;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showUser, true);
}

//Funzione che mostra a video le informazioni sintetizzate di un utente
function showUser(userInfo){
	var pathBase = "../upload/";
	//Div che comprende tutta la parte centrale della home
	var divWrapper = document.getElementById("divFeedWrapper");

	for(var i=0; i<userInfo.length; i++){
		//Div che contiene tutte le informazioni
		var divContenitore = document.createElement("div");
		divContenitore.className = "divUserInfoContenitore";

		//Link al profilo
		var linkProfilo = document.createElement("a");
		linkProfilo.setAttribute("href", "./profilo.php?username=" + userInfo[i].usernameUtente);
		divContenitore.appendChild(linkProfilo);

		//Immagine profilo
		var fotoProfilo = document.createElement("img");
		if(userInfo[i].pathFotoProfilo == "default")
			fotoProfilo.setAttribute("src", "../css/immagini/fotoProfiloIcon.jpg");
		else{
			fotoProfilo.setAttribute("src", pathBase + userInfo[i].pathFotoProfilo);
		}
		fotoProfilo.setAttribute("alt", "foto profilo");
		fotoProfilo.className = "fotoProfiloUserInfo";
		linkProfilo.appendChild(fotoProfilo);

		//Info
		var divContenitoreInfo = document.createElement("div");
		divContenitoreInfo.className = "divUserInfo";

		//Nome
		var nome = document.createElement("h5");
		nome.textContent = userInfo[i].nome;
		divContenitoreInfo.appendChild(nome);

		//Altre info
		var luogoOrigine = document.createElement("p");
		luogoOrigine.textContent = "Viene da: " + userInfo[i].luogoOrigine;
		divContenitoreInfo.appendChild(luogoOrigine);

		var dataNascita = document.createElement("p");
		dataNascita.textContent = "Nato il: " + userInfo[i].dataNascita;
		divContenitoreInfo.appendChild(dataNascita);

		linkProfilo.appendChild(divContenitoreInfo);

		divWrapper.appendChild(divContenitore);
	}

	//Nessun utente trovato
	if(userInfo.length == 0){
		var messaggioErrore = document.createElement("p");
		messaggioErrore.textContent = "Nessun risultato";
		messaggioErrore.style.textAlign = "center";
		divWrapper.appendChild(messaggioErrore);
	}
}

//Funzione che inoltra una richiesta Ajax per ottenere info su alcuni utenti; il modo in 
//cui questi utenti sono scelti dipende dal valore di 'relationship'
function showUserRelated(relationship){

	switch(relationship){
		case UTENTI_PREFERITI: titolo = "Utenti preferiti"; break;
		case UTENTI_CHASER: titolo = "Chaser"; break;
		case UTENTI_POPOLARI: titolo = "Utenti che potrebbero interessarti"; break;
	}

	removeFeed(titolo);
	
	var url = URL_SEARCH_BASE + "getRelatedUser.php";

	var dataToSend = "user=" + usernameUtente + "&relationship=" + relationship;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showUser, true);
}