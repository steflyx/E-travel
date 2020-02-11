//FUNZIONI CHE GESTISCONO IL LAYOUT DEI CONTENUTI (nella parte esterna all'iframe)

//Variabile che memorizza l'ultimo content selezionato
var contentTypeSelected = 0;

var CONTENT_SELECTED_POST = 0;
var CONTENT_SELECTED_VIAGGIO = 1;
var CONTENT_SELECTED_EVENTO = 2;

//ALTEZZE DELL'IFRAME A SECONDA DEL CONTENUTO (in em)
var HEIGHT_POST = 7.5;
var HEIGHT_VIAGGIO = 32;
var HEIGHT_EVENTO = 24;

var RAPPORTO_EM_TO_PX = 16; //Bisogna moltiplicare per 16 per effettuare la conversione 

//URL DEI FILE IN CUI SI TROVANO I CONTENT
var URL_POST = "./layout/content/post.php";
var URL_VIAGGIO = "./layout/content/viaggio.php";
var URL_EVENTO = "./layout/content/evento.php";

//Funzione che dà la possibilità all'utente di creare un nuovo post, un nuovo viaggio o un nuovo evento facendo le opportune modifiche al layout 
//Nello specifico cambia:
//	- Il colore delle scelte in alto
//	- L'altezza dell'iframe, che si deve adattare ai diversi contenuti
//	- Risistema i vari pointer presenti nella home, che, essendo posizionati in maniera assoluta,
//	  si ritroverebbero in posizioni casuali dopo un cambiamento nell'altezza dell'iframe
function showContent(contentType){

	//La vecchia altezza ci serve per aggiustare i pointer successivamente
	var oldHeight = 0;
	switch(contentTypeSelected){
		case CONTENT_SELECTED_POST: oldHeight = HEIGHT_POST * RAPPORTO_EM_TO_PX; break;
		case CONTENT_SELECTED_VIAGGIO: oldHeight = HEIGHT_VIAGGIO * RAPPORTO_EM_TO_PX; break;
		case CONTENT_SELECTED_EVENTO: oldHeight = HEIGHT_EVENTO * RAPPORTO_EM_TO_PX; break;
	}

	changeColorContent(contentType);

	//Modifica dell'altezza dell'iframe e modifica dell'url
	var loc, newHeight;
	if(contentType == CONTENT_SELECTED_POST){
		loc = URL_POST;
		height = HEIGHT_POST + "em";
		newHeight = HEIGHT_POST * RAPPORTO_EM_TO_PX;
	}
	if(contentType == CONTENT_SELECTED_VIAGGIO){
		loc = URL_VIAGGIO;
		height = HEIGHT_VIAGGIO + "em";
		newHeight = HEIGHT_VIAGGIO * RAPPORTO_EM_TO_PX;
	}
	if(contentType == CONTENT_SELECTED_EVENTO){
		loc	= URL_EVENTO;
		height = HEIGHT_EVENTO + "em";
		newHeight = HEIGHT_EVENTO * RAPPORTO_EM_TO_PX;
	}
	var iframe = document.getElementById("windowContent");
	iframe.setAttribute('src', loc);
	iframe.style.height = height;

	//Riadattamento delle posizioni dei pointer
	var arrayPointer = document.getElementsByClassName("imgMapPointer");
	for(var i=0; i<arrayPointer.length; i++){
		finalHeight = arrayPointer[i].offsetTop - oldHeight + newHeight;
		if(arrayPointer[i].needAdjustment == 1) //Solo alcuni dei pointer devono essere aggiustati
			arrayPointer[i].style.top = finalHeight + 'px';
	}
}

//Funzione che imposta il backgroundColor quando si clicca su una delle opzioni
function changeColorContent(contentType){
	var contentList = document.getElementsByClassName("liContent");
	for(var i=0; i<3; ++i)
		contentList[i].style.backgroundColor = "white";

	contentList[contentType].style.backgroundColor = "#c1d7d7";
	contentTypeSelected = contentType;
}

//Funzioni che impostano il backgroundColor delle opzioni per la scelta del content 
//da pubblicare quando ci si passa sopra col mouse
//Il motivo per cui non si può usare direttamente il CSS è che non sempre questa modifica va fatta

var DEFAULT_COLOR = "white";
var HOVER_COLOR = "#e0ebeb";

//Modifica il backgroundColor simulando l'istruzione CSS :hover
function overContent(contentType){
	var contentList = document.getElementsByClassName("liContent");

	//Il content selezionato non deve cambiare colore
	if(contentType!=contentTypeSelected)
		contentList[contentType].style.backgroundColor = HOVER_COLOR;
}

//Funzione che riporta il backgroundColor al colore iniziale
function stopOverContent(contentType){
	var contentList = document.getElementsByClassName("liContent");

	//Il content selezionato non deve cambiare colore
	if(contentType!=contentTypeSelected)
		contentList[contentType].style.backgroundColor = DEFAULT_COLOR;
}
/****************************************************************************/
