//FUNZIONI ASSOCIATE ALLA SCELTA DELLE PREFERENZE

//Variabili per distinguere il tipo di preferenza
var COMPAGNIA = 0;
var CLIMA = 1;
var MEZZO = 2;
var VIAGGIO = 3;

//Larghezza (in em) della lista a seconda del tipo di preferenza
var WIDTH_COMPAGNIA = 2;
var WIDTH_CLIMA = 2;
var WIDTH_MEZZO = 6;
var WIDTH_VIAGGIO = 5;

//Larghezza (in em) di una delle immagini che compongono le preferenze
var WIDTH_IMG = 7;

//Funzione che associa ad ogni opzione di ogni preferenza il valore di "alt" dell'immagine associata
//'numPreference' distingue fra 'compagnia', 'mezzo' ...
//'typePreference' distingue fra i valori veri e propri di tale preferenza
function getAlt(numPreference, typePreference){
	var alt = new Array();
	switch(numPreference){
		case COMPAGNIA:
				alt[0] = "Solitario";
				alt[1] = "Compagnia";
				break;
		case CLIMA: 
				alt[0] = "Caldo";
				alt[1] = "Freddo";
				break;
		case MEZZO: 
				alt[0] = "Aereo";
				alt[1] = "Auto";
				alt[2] = "Bici";
				alt[3] = "Moto";
				alt[4] = "Piedi";
				alt[5] = "Treno";
				break;
		case VIAGGIO: 
				alt[0] = "Festaiolo";
				alt[1] = "Rilassato";
				alt[2] = "Esploratore";
				alt[3] = "Sportivo";
				alt[4] = "Acculturato";	
				break;
	}
	return alt[typePreference];
}

//Funzione che associa ad ogni opzione di ogni preferenza la locazione dell'immagine associata
function getLocation(numPreference, typePreference){
	var locBase;
	var loc = new Array();
	locBase = "../css/immagini/";
	switch(numPreference){
		case COMPAGNIA:
		 		loc[0] = locBase + "solitaryIcon.png";
				loc[1] = locBase + "groupIcon.png";
				break;
		case CLIMA: 
				loc[0] = locBase + "hotIcon.ico";
				loc[1] = locBase + "coldIcon.png";
				break;
		case MEZZO: 
				locBase += "mezzi/";
				loc[0] = locBase + "mezzoAereo.png";
				loc[1] = locBase + "mezzoAuto.png";
				loc[2] = locBase + "mezzoBici.png";
				loc[3] = locBase + "mezzoMoto.png";
				loc[4] = locBase + "mezzoPiedi.png";
				loc[5] = locBase + "mezzoTreno.png";
				break;
		case VIAGGIO:	
				locBase += "tipi/";
				loc[0] = locBase + "party.jpg";
				loc[1] = locBase + "relax.png";
				loc[2] = locBase + "explorer.png";
				loc[3] = locBase + "sport.ico";
				loc[4] = locBase + "culture.png";
				break;
	}
	return loc[typePreference];
}

//Funzione che modifica una delle preferenze dell'utente
function modifyPreference(numPreference, typePreference){
	//Eliminiamo l'immagine da sostituire (notare che un'immagine c'è anche se non è mai stata fatta una scelta, l'immagine di aggiunta)
	var divImg = document.getElementsByClassName("divImgPreferenza")[numPreference];
	var imgVecchia = divImg.getElementsByTagName("img")[0];
	imgVecchia.remove();

	var imgNuova = document.createElement("img");
	var isToBeClicked = 0;
	setImage(imgNuova, numPreference, typePreference, isToBeClicked);
	divImg.appendChild(imgNuova);

	//Aggiorniamo l'input nascosto in cui si memorizzano le informazioni sulle scelte effettuate
	var inputNascosto = document.getElementById("inputPreferenze");
	if(inputNascosto){
		var arrayValoriPreferenze = document.getElementById("inputPreferenze").value.split(',');
		arrayValoriPreferenze[numPreference] = typePreference;
		document.getElementById("inputPreferenze").value = "";
		for(var i=0; i<4; i++){
			document.getElementById("inputPreferenze").value += arrayValoriPreferenze[i];
			document.getElementById("inputPreferenze").value += ",";
		}
	}
}

//Funzione che imposta i vari attributi di un'immagine
function setImage(img, numPreference, typePreference, isToBeClicked){
	img.setAttribute("src", getLocation(numPreference, typePreference));
	img.setAttribute("alt", getAlt(numPreference, typePreference));
	img.numPref = numPreference;
	img.typePref = typePreference;
	img.addEventListener("mouseover", function(e){showHint(e, getAlt(this.numPref, this.typePref), 5);});
	img.addEventListener("mouseout", function(){hideHint();});
	if(isToBeClicked)
		img.addEventListener("click", function(){modifyPreference(this.numPref, this.typePref);});
}

//Funzione che mostra a video le opzioni possibili per selezionare le preferenze
function showPreferences(numPreference){
	
	var divInfoViaggiatore = document.getElementById("divInfoViaggiatore");
	var divListaPreferenze = document.getElementById("divListaPreferenze");

	//Controlliamo se già era stata inserita una lista di opzioni e, in caso, la cancelliamo
	var divContenitore = divListaPreferenze.getElementsByTagName("div")[0];
	if(divContenitore)
		divContenitore.remove();
	
	//Scegliamo il titolo e la larghezza del contenitore (la larghezza è il numero delle immagini per quella preferenza)
	var text, width;
	switch(numPreference){
		case COMPAGNIA: 
				text = "Sei solitario o cerchi compagnia?";
				width = WIDTH_COMPAGNIA;
				break;
		case CLIMA: 
				text = "Che tipo di clima preferisci?";
				width = WIDTH_CLIMA;
				break;
		case MEZZO: 
				text = "Mezzo preferito?";
				width = WIDTH_MEZZO;
				break;
		case VIAGGIO: 
				text = "Che tipo di viaggiatore sei?";	
				width = WIDTH_VIAGGIO;		
				break;
	}

	//Inseriamo titolo, divContenitore e immagini
	var fintoTitolo = divInfoViaggiatore.getElementsByTagName("input")[0];
	fintoTitolo.value = text;
	fintoTitolo.style.display = "block";

	var divContenitore = document.createElement("div");
	width *= WIDTH_IMG;
	divContenitore.style.width = width + 'em';
	divListaPreferenze.appendChild(divContenitore);

	var length = width/WIDTH_IMG;
	var isToBeClicked = 1;
	for(var i=0; i<length; i++){
		var img = document.createElement("img");
		setImage(img, numPreference, i, isToBeClicked);
		divContenitore.appendChild(img);
	}

	//Rendiamo visibile il pulsante che permette l'aggiornamento delle preferenze
	document.getElementById("submitPreferenze").style.display = "block";
}

//FUNZIONE PER LA VISUALIZZAZIONE DELLE PREFERENZE DI UN UTENTE
//Modifica le immagini delle preferenze in base agli argomenti passati
function showUserPreferences(compagnia, clima, mezzo, viaggio){
	if(compagnia != -1) //Se non è specificata, lasciamo il più
		modifyPreference(COMPAGNIA, compagnia);
	if(clima != -1)
		modifyPreference(CLIMA, clima);
	if(mezzo != -1)
		modifyPreference(MEZZO, mezzo);
	if(viaggio != -1) 
		modifyPreference(VIAGGIO, viaggio);
}