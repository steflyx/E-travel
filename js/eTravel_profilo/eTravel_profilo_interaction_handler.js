//USER INTERACTION
//Funzioni legate all'interazione utente-utente

//Url dei file php
var URL_CHASING = "../php/functionalities/addInteraction/addChasing.php"
var URL_FAV = "../php/functionalities/addInteraction/addFavourite.php";

//Funzione che fa una richiesta Ajax per generare un nuovo 'chase'
function addChase(){
	var url = URL_CHASING;

	//mittente è l'user della sessione attuale, destinatario è l'user della pagina che si sta visualizzando
	var dataToSend = "chaserUser=" + userMittente + "&chasedUser=" + userDestinatario;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showChaseError);
}

//Funzione che fa una richiesta Ajax per generare un nuovo utente preferito
function addFav(){
	var url = URL_FAV;

	//mittente è l'user della sessione attuale, destinatario è l'user della pagina che si sta visualizzando
	var dataToSend = "userPreferring=" + userMittente + "&userPreferito=" + userDestinatario;

	url = url + "?" + dataToSend;

	performAjaxRequest("GET", url, true, null, showChaseError);
}

//Banale funzione che mostra a video un messaggio di errore (può anche essere un messaggio di ok)
function showChaseError(error){
	window.alert(error);
}