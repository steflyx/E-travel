//FUNZIONI GRAFICHE PER LA PUBBLICAZIONE DEI CONTENT
//Modificano il layout delle pagine per la pubblicazione dei contenuti (la parte interna all'iframe)

//Funzione che elimina l'icona del "dove ti trovi" (o quella del "con chi sei?") e la sostitutisce con un input di testo
function showWhereAndWith(numInput, divId){
	var div = document.getElementById(divId);
	var arrayIcon = div.getElementsByTagName("img");

	//Distinguiamo due casi: non avevamo inserito nessuno dei due input; ne avevamo già inserito uno;
	if(arrayIcon.length!=1)
		arrayIcon[numInput].remove();
	else arrayIcon[0].remove();

	//Creiamo l'input e inseriamolo
	var newInput = document.createElement("input");
	newInput.type = "text";

	if(numInput==1) 
		div.appendChild(newInput);
	else div.insertBefore(newInput, div.childNodes[0]);

	//Settiamo il placeholder
	var hint, nome;

	//Se è stato "post" a chiamare
	if(numInput==0){
		hint = "Dicci dove sei!";
		nome = "inputLuogo";
	}
	else{
		hint = "Tagga un amico!";
		nome = "inputTag";
	}

	//Se è stato "viaggio"
	if(divId == "divViaggioBottom"){
		hint = "Dicci con chi vai!";
		nome = "inputTag";
	}

	newInput.placeholder = hint;
	newInput.name = nome;
	newInput.maxlength = "45";

	//Bisogna nascondere la didascalia che necessariamente doveva essere presente
	hideHint();	
}

var PERMANENZA_ERRORE = 2000; //in ms

//Funzione che cancella i messaggi di errore (se ne trova uno)
function clearError(){
	var errorMessage = document.getElementById("divError");
	if(!errorMessage)
		return;

	var fadingInterval = 50;
	var opacitaFinale = 0;
	setTimeout(function(){fadeOut(errorMessage, opacitaFinale, fadingInterval);}, PERMANENZA_ERRORE);
}