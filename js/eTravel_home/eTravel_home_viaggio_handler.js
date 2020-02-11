var isLastPointerPositioned = 1; //Serve per controllare se l'utente ha posizionato l'ultimo pointer
var lastMovingPointer = 0; //Serve in caso si voglia spostare un pointer che era stato precedentemente bloccato
var numTappe = 0; //Numero di tappe inserite


//CREAZIONE NUOVA TAPPA
//Vedere il file tappa.html per avere un'idea di com'è il codice generato

//Funzione che aggiunge una nuova tappa al viaggio, creando dinamicamente il form per immettere i dati e il puntatore sulla mappa
function addTappa(){
	numTappe++;

	addLayoutTappa();
	showPointer();

	document.getElementById("inputHiddenInfoNumTappe").value = numTappe;
	var infoMezzoTappaValue = document.getElementById("inputHiddenInfoMezzoTappa").value;
	document.getElementById("inputHiddenInfoMezzoTappa").value = infoMezzoTappaValue + "-,";
}

//Creazione del layout di una tappa
function addLayoutTappa(){
	var divLeft = document.getElementById("divTappe");

	//Creiamo il div che contiene il form
	var divTappa = document.createElement("div");
	divTappa.className = "divTappaSingola";
	divLeft.appendChild(divTappa);

	//Titolo
	var fintoTestoTitolo = document.createElement("input");
	fintoTestoTitolo.type = "text";
	fintoTestoTitolo.value = "Tappa n°" + numTappe;
	fintoTestoTitolo.className = "fintoTestoTitolo";
	fintoTestoTitolo.readOnly = true;
	divTappa.appendChild(fintoTestoTitolo);

	//Luogo
	var inputLuogo = document.createElement("input");
	inputLuogo.type = "text";
	inputLuogo.name = "inputLuogo" + numTappe;
	inputLuogo.placeholder = "Nome della tappa";
	inputLuogo.className = "textLuogo";
	divTappa.appendChild(inputLuogo);

	//Periodo
	var inputPeriodo = document.createElement("input");
	inputPeriodo.type = "text";
	inputPeriodo.name = "inputPeriodo" + numTappe;
	inputPeriodo.placeholder = "Data";
	inputPeriodo.pattern = "[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{2,4}";
	inputPeriodo.title = "DD/MM/AAAA";
	inputPeriodo.className = "textPeriodo";
	divTappa.appendChild(inputPeriodo);

	//Layout per la scelta del mezzo
	addLayoutMezzo(divTappa);
	
	//Commento
	var textCommento = document.createElement("textarea");
	textCommento.placeholder = "Scrivi un commento!";
	textCommento.className = "textCommento";
	textCommento.name = "inputCommento" + numTappe;
	divTappa.appendChild(textCommento);
}

//Funzione che si occupa del layout che permette la scelta del mezzo
function addLayoutMezzo(divTappa){
	//div che contiene tutta questa parte
	var divMezzo = document.createElement("div");
	divMezzo.className = "divMezzo";
	divTappa.appendChild(divMezzo);

	//Testo con la scritta "Mezzo:"
	var fintoTestoMezzo = document.createElement("input");
	fintoTestoMezzo.type="text";
	fintoTestoMezzo.value = "Mezzo: ";
	fintoTestoMezzo.className = "fintoTestoMezzo";
	fintoTestoMezzo.readOnly = true;
	divMezzo.appendChild(fintoTestoMezzo);

	//div che conterrà l'immagine del mezzo scelto
	var divImgMezzoScelto = document.createElement("div");
	divImgMezzoScelto.className = "divImgMezzoScelto";
	divMezzo.appendChild(divImgMezzoScelto);

	//div che contiene l'icona con la freccia in basso
	var divImgInGiuIcon = document.createElement("div");
	divImgInGiuIcon.className = "divImgInGiuIcon";
	//Associamo ad ogni lista il numero della tappa in cui si trova
	divImgInGiuIcon.numTappa = numTappe - 1;
	divImgInGiuIcon.addEventListener("mouseover", function(){showMezzi(this.numTappa, this.getBoundingClientRect());});
	divImgInGiuIcon.addEventListener("mouseout", function(){hideMezzi(this.numTappa);});
	divMezzo.appendChild(divImgInGiuIcon);

	//Immagine della freccia verso il basso
	var imgInGiuIcon = document.createElement("img");
	imgInGiuIcon.setAttribute("src", "../../../css/immagini/inGiuIcon.png");
	imgInGiuIcon.setAttribute("alt", " ");
	divImgInGiuIcon.appendChild(imgInGiuIcon);

	//lista dei mezzi
	var ulMezzi = document.createElement("ul");
	ulMezzi.className = "ulMezzi";
	ulMezzi.numTappa = numTappe - 1;
	ulMezzi.addEventListener("mouseover", function(){showMezzi(this.numTappa, 0);});
	ulMezzi.addEventListener("mouseout", function(){hideMezzi(this.numTappa);});
	divMezzo.appendChild(ulMezzi);

	//Elementi della lista
	for(var i=0; i<6; i++){
		var liInterno = document.createElement("li");
		liInterno.className = "liInterno";
		liInterno.numMezzo = i;
		liInterno.numTappa = numTappe - 1;
		liInterno.addEventListener("click", function(){printMezzo(this.numMezzo, this.numTappa, -1);});
		ulMezzi.appendChild(liInterno);

		//Immagini
		var imgInterna = document.createElement("img");

		var loc;
		var alt;
		var locBase = "../../../css/immagini/mezzi/";
		switch(i){
			case 0: loc = locBase + "mezzoAereo.png"; 
					alt = "Aereo"; break;
			case 1: loc = locBase + "mezzoAuto.png"; break;
					alt = "Auto"; break;
			case 2: loc = locBase + "mezzoBici.png"; break;
					alt = "Bici"; break;
			case 3: loc = locBase + "mezzoMoto.png"; break;
					alt = "Moto"; break;
			case 4: loc = locBase + "mezzoPiedi.png"; break;
					alt = "Piedi"; break;
			case 5: loc = locBase + "mezzoTreno.png"; break;
					alt = "Treno"; break;
			default: return;
		}

		imgInterna.setAttribute("src", loc);
		imgInterna.setAttribute("alt", alt);
		liInterno.appendChild(imgInterna);
	}
}

/*****************************************************/

//FUNZIONI RELATIVE ALLA SCELTA DEL MEZZO
//Funzione che mostra la scelta dei mezzi
function showMezzi(numLista, rect){
	var arrayListe = document.getElementsByClassName("ulMezzi");
	if(rect!=0){
		arrayListe[numLista].style.left = rect.left + 'px';
		arrayListe[numLista].style.top = rect.top + 'px';
	}
	arrayListe[numLista].style.display = "block";
}

//Funzione che nasconde tale scelta
function hideMezzi(numLista){
	var arrayListe = document.getElementsByClassName("ulMezzi");
	arrayListe[numLista].style.display = "none";
}

//Funzione che mostra a video il mezzo scelto (numViaggio è un parametro necessario per distinguere fra i viaggi creati dinamicamente e la zona per la pubblicazione)
function printMezzo(numMezzo, numTappa, numViaggio){
	//Aggiorniamo l'input nascosto
	if(numViaggio == -1){ //Il -1 indica che la funzione è stata chiamata dalla zona pubblicazione
		var arrayMezzi = document.getElementById("inputHiddenInfoMezzoTappa").value.split(',');
		document.getElementById("inputHiddenInfoMezzoTappa").value = "";
		arrayMezzi[numTappa] = numMezzo;
		for(var i=0; i<numTappe; i++)
			document.getElementById("inputHiddenInfoMezzoTappa").value += (arrayMezzi[i] + ',');
	}

	//Selezioniamo la posizione in cui deve essere inserita l'immagine
	var divMezzoScelto;
	if(numViaggio == -1)
		divMezzoScelto = document.getElementsByClassName("divImgMezzoScelto")[numTappa];
	else divMezzoScelto = document.getElementsByClassName("divImgMezzoScelto" + numViaggio)[numTappa];

	//Individuiamo la locazione del file
	var loc;
	var alt;
	var locBase;
	if(numViaggio == -1) //Nei due casi l'immagine è inviata in due file diversi
		locBase = "../../../css/immagini/mezzi/";
	else locBase = "../css/immagini/mezzi/";
	switch(numMezzo){
		case 0: loc = locBase + "mezzoAereo.png"; 
				alt = "Aereo"; break;
		case 1: loc = locBase + "mezzoAuto.png"; break;
				alt = "Auto"; break;
		case 2: loc = locBase + "mezzoBici.png"; break;
				alt = "Bici"; break;
		case 3: loc = locBase + "mezzoMoto.png"; break;
				alt = "Moto"; break;
		case 4: loc = locBase + "mezzoPiedi.png"; break;
				alt = "Piedi"; break;
		case 5: loc = locBase + "mezzoTreno.png"; break;
				alt = "Treno"; break;
		default: return;
	}

	var imgMezzo = divMezzoScelto.getElementsByTagName("img")[0];
	//Se non avevamo ancora scelto un mezzo, dobbiamo creare l'immagine, altrimenti basta cambiare l'attributo "src"
	if(!imgMezzo){
		var imgMezzo = document.createElement("img");
		divMezzoScelto.appendChild(imgMezzo);
	}
	imgMezzo.setAttribute("src", loc);
	imgMezzo.setAttribute("alt", alt);
	if(numViaggio != -1)
		imgMezzo.style.width = "100%";
}
//***************************************************

/*FUNZIONE DI VALIDAZIONE DEL FORM*/
//In realtà si controlla semplicemente che sia stata inserita almeno una tappa
function validateFormViaggi(){
	if(numTappe == 0)
		return false;
	return true;
}
