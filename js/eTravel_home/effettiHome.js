//EFFETTI GRAFICI DELLA HOME

//FUNZIONI PER IL LAYOUT DELLE NEWS
//Funzione che mostra la scelta fra notizie recenti e principali
function showNewsType(){
	document.getElementById("ulNotizie").style.display = "block";
}

//Funzione che nasconde la scelta fra notizie recenti e principali
function hideNewsType(){
	document.getElementById("ulNotizie").style.display = "none";
}

//ALTRO
//Funzione che mostra un messaggio d'errore
function showError(errorMessage){
	window.alert(errorMessage);
}
/******************************************************/

