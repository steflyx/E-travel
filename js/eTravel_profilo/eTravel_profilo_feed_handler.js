//FUNZIONI ASSOCIATE AL CONTENT FEED (scelta fra post/eventi/viaggi)

//Variabili per il riconoscimento del tipo di contenuto
var POST = 0;
var VIAGGI = 1;
var EVENTI = 2; 

//Funzione che apporta le necessarie modifiche al layout e alla sorgente dell'iframe
function showFeed(contentype){
	changeColorContent(contentype);

	var url = "./showFeedProfilo.php?content=";
	switch(contentype){
		case POST: 
				url += "post"; 
				break;
		case VIAGGI: 
				url += "viaggi"; 
				break;
		case EVENTI: 
				url += "eventi"; 
				break;
	}
	url = url + "&username=" + userDestinatario;
	document.getElementById("newsFeedProfilo").setAttribute('src', url);
}

//*************************************************************************//