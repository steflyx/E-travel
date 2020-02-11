//GESTIONE DELLE FOTO

//FOTO PROFILO
//Funzione che, dato l'indirizzo, setta l'immagine profilo di un utente
function cambiaFotoProfilo(pathFotoProfilo){
	//Nel database il valore default per la fotoProfilo è la stringa "default" (in questo caso si usano le impostazioni iniziali del css)
	if(pathFotoProfilo != "default"){
		var pathBase = "../upload/";
		var pathFinale = pathBase + pathFotoProfilo;
		document.getElementById("divImgFotoProfilo").style.backgroundImage = "url('" + pathFinale + "')";
	}
}

//Funzione che fa apparire il pulsante per il submit della fotoProfilo
function showCambiaFotoProfiloButton(){
	document.getElementById("submitFotoProfilo").style.display = "block";
	document.getElementById("divFotoProfilo").style.height = "5em";
}
/********************************************************************************/

//FOTO GALLERIA
//Elimina l'attributo position: relative dalle foto (necessario per una corretta visualizzazione in alcuni casi)
function abbassaFoto(){
	var foto = document.getElementsByClassName("divFotoUtenteFromDatabase");
	var count = 0;
	while(foto[count]){
		foto[count].style.position = "static";
		count++;
	}
}

//Mostra a video (nella galleria) una foto di cui abbiamo l'URL 
function addFoto(pathFoto){
	var pathBase = "../upload/";
	var pathFinale = pathBase + pathFoto;

	var divRiquadro = document.getElementById("divListaFoto");
	var divFoto = document.createElement("div");
	divFoto.className = "divFotoUtenteFromDatabase";
	var img = document.createElement("img");
	img.setAttribute("src", pathFinale);
	img.setAttribute("alt", " ");
	divFoto.appendChild(img);
	divRiquadro.appendChild(divFoto);
}

//Funzione che fa apparire il pulsante per il submit di una foto
function showAggiungiFotoButton(){
	document.getElementById("submitFoto").style.display = "block";
	document.getElementById("divListaFoto").style.height = "8em";

	//Quando compare il pulsante dobbiamo abbassare le eventuali foto che lo coprirebbero
	var immaginiSotto = document.getElementsByClassName("divFotoUtenteFromDatabase");
	var count = 2;
	while(immaginiSotto[count]){
		immaginiSotto[count].style.marginTop = "2.5em";
		count++;
	}
}