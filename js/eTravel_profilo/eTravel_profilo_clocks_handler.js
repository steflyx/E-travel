//GESTIONE DEL LAYOUT DEGLI OROLOGI

//Funzione che recupera il valore dei due input di testo e fa il submit del form
function addOrologioInterface(){
	var arrayInput = document.getElementById("divOpzioniOrologi").getElementsByTagName("input");
	var citta = arrayInput[0].value;
	if(citta == ""){
		window.alert("Devi inserire una città");
		return;
	}

	var fusorario = arrayInput[1].value;
	var regExpFusorario = new RegExp("^[-+]{0,1}[0-9]+$");
	var isCorrect = regExpFusorario.test(fusorario);
	if(fusorario == "" || isCorrect == false || fusorario<-12 || fusorario>12){
		window.alert("Inserisci un fusorario valido");
		return;
	}

	document.getElementById("formOrologio").submit();
}

//Funzione che mostra a video gli input per inserire città e fusorario
function showOpzioniOrologi(){
	document.getElementById("divOpzioniOrologi").style.display = 'block';
}

//Annulla gli effetti della precendente
function hideOpzioniOrologi(){
	if(document.getElementById("divOpzioniOrologi")==null)
		return;
	document.getElementById("divOpzioniOrologi").style.display = 'none';
	var arrayInput = document.getElementById("divOpzioniOrologi").getElementsByTagName("input");
	arrayInput[0].value = "";
	arrayInput[1].value = "";
}