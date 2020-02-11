//FUNZIONI CHE GENERANO E GESTISCONO I POINTER

//Coordinate (in px) del punto centrale della mappa per la pubblicazione dei viaggi
var HORIZONTAL_MAP_CENTER = 132;
var VERTICAL_MAP_CENTER = 128;

//Dimensioni della mappa
var MAP_LENGTH_PX = 304;
var MAP_HEIGHT_PX = 368;
var MAP_LENGTH_EM = 19;

//Aggiustamento della posizione del pointer affinché segua il mouse in maniera adeguata
var SFASAMENTO_ORIZZONTALE_POINTER = 20; //in px
var SFASAMENTO_VERTICALE_POINTER = 56;

var RITARDO = 200; //in ms

//Funzione che fa apparire il puntatore sulla mappa
function showPointer(){
	var positionLeft = document.getElementById("imgMap").offsetLeft + HORIZONTAL_MAP_CENTER; 
	var positionTop = document.getElementById("imgMap").offsetTop + VERTICAL_MAP_CENTER;

	var pointer = document.createElement("div");
	pointer.className = "imgMapPointer";
	pointer.style.left = positionLeft + 'px';
	pointer.style.top = positionTop + 'px';
	pointer.onmousemove = movePointer; //Altrimenti se il mouse tocca il pointer si ha un fastidioso effetto di lag nel movimento
	pointer.onclick = stopOrStartMovingPointer;
	document.body.appendChild(pointer); 

	isLastPointerPositioned = 0;
	lastMovingPointer = numTappe - 1;

	//Aggiorniamo il valore contenuto nell'input nascosto con un valore di default (il centro della mappa)
	var posIniziale = "";
	if(lastMovingPointer == 0)
		document.getElementById("inputHiddenInfoCoordTappa").value = "";
	posIniziale = posIniziale + HORIZONTAL_MAP_CENTER + "," + VERTICAL_MAP_CENTER + ";";	
	document.getElementById("inputHiddenInfoCoordTappa").value += posIniziale;
}

//FUNZIONI RELATIVE AL MOVIMENTO DEI PUNTATORI
//Funzione che muove l'ultimo puntatore non posizionato
function movePointer(e){
	if(isLastPointerPositioned == 0){
		document.getElementById("imgMap").style.cursor = "pointer";

		var positionX = e.clientX;
		var positionY = e.clientY;

		//Serve per controllare se il mouse si trova all'interno della mappa
		var imgMap = document.getElementById("imgMap");
		var limitLeft = imgMap.offsetLeft;
		var limitRight = imgMap.offsetLeft + MAP_LENGTH_PX;
		var limitTop = imgMap.offsetTop;
		var limitBottom = imgMap.offsetTop + MAP_HEIGHT_PX;

		if(positionX<limitRight && positionX>limitLeft && positionY<limitBottom && positionY>limitTop){
			var lastMovingPointerCopia = lastMovingPointer;
			
			//Individuiamo il pointer da spostare
			var arrayPointer = document.getElementsByClassName("imgMapPointer");
			var movingPointer = arrayPointer[lastMovingPointerCopia];

			//Aggiorniamo la posizione del pointer
			positionX -= SFASAMENTO_ORIZZONTALE_POINTER;
			positionY -= SFASAMENTO_VERTICALE_POINTER;

			movingPointer.style.left = positionX + 'px';
			movingPointer.style.top = positionY + 'px';
		}
	}
}

//Funzione che, resettando isLastPointerPositioned, blocca ulteriori spostamenti del pointer
function stopPointer(e){
	document.getElementById("imgMap").style.cursor = "default";
	isLastPointerPositioned = 1;

	var positionX = e.clientX;
	var positionY = e.clientY;

	//Aggiorniamo il contenuto dell'hidden input
	var imgMap = document.getElementById("imgMap");
	positionX -= imgMap.offsetLeft;
	positionY -=imgMap.offsetTop;

	var arrayCoord = document.getElementById("inputHiddenInfoCoordTappa").value.split(';');
	arrayCoord[lastMovingPointer] = positionX + ',' + positionY;
	document.getElementById("inputHiddenInfoCoordTappa").value = "";
	for(var i=0; i<arrayCoord.length-1; i++)
		document.getElementById("inputHiddenInfoCoordTappa").value += (arrayCoord[i] + ';')
	document.getElementById("inputHiddenInfoCoordTappa").value += arrayCoord[arrayCoord.length - 1];
}

//Funzione che blocca l'ultimo puntatore che stavamo muovendo se ne stavamo muovendo uno; 
//altrimenti permette di spostare il puntatore su cui si è cliccato
function stopOrStartMovingPointer(e){
	var positionX = e.clientX;
	var positionY = e.clientY;

	if(isLastPointerPositioned == 0)
		stopPointer(positionX, positionY);
	else{

		lastMovingPointer = findClickedPointer(positionX, positionY);

		if(lastMovingPointer == -1)
			return;

		isLastPointerPositioned = 0;
	}
}

//Funzione che individua il pointer cliccato; partendo dalla fine dell'array, se due pointer sono sovrapposti, prende l'ultimo inserito
function findClickedPointer(positionX, positionY){
	var arrayPointer = document.getElementsByClassName("imgMapPointer");
	var length = arrayPointer.length;

	for(var i=length-1; i>=0; i--){
		var limitLeft = parseInt(arrayPointer[i].style.left);
		var limitTop = parseInt(arrayPointer[i].style.top);

		if(positionX>=limitLeft && positionX<=(limitLeft + 40) && positionY>=limitTop && positionY<=(limitTop + 56))
			return i;
	}

	return -1;
}


//POSIZIONAMENTO DEI POINTER ALL'INTERNO DEL FEED

//E' necessario inserire questa funzione contenitore perché altrimenti il caricamento della pagina influisce sulla posizione dei pointer
function placePointerWrapper(idViaggio, positionX, positionY, needResize){
	setTimeout(function(){placePointer(idViaggio, positionX, positionY, needResize);}, RITARDO);
}

//Funzione che mostra a video un pointer su una delle mappe degli elementi creati in php (i viaggi presi dal database)
function placePointer(idViaggio, positionX, positionY, needResize){
	var idMappa = "contentMap" + idViaggio; //Questo è il metodo usato per distinguere univocamente le mappe
	var imgMap = document.getElementById(idMappa);
	var widthMap = imgMap.offsetWidth / RAPPORTO_EM_TO_PX; //Otteniamo la grandezza in em della mappa

	var rapportoDiScala = widthMap / MAP_LENGTH_EM;

	//Effettuiamo la proporzione per mantenere i rapporti iniziali
	var adaptedPositionX = positionX * rapportoDiScala; 
	var finalPositionX = imgMap.offsetLeft + adaptedPositionX - SFASAMENTO_ORIZZONTALE_POINTER;

	var adaptedPositionY = positionY * rapportoDiScala; //Il rapporto sulle altezze è uguale a quello delle larghezze
	var finalPositionY = imgMap.offsetTop + adaptedPositionY - SFASAMENTO_VERTICALE_POINTER; 

	//Mostriamo a video il pointer
	var pointer = document.createElement("div");
	pointer.className = "imgMapPointer";
	pointer.style.left = finalPositionX + 'px';
	pointer.style.top = finalPositionY + 'px';
	//Serve per sapere dopo se è necessario aggiustarne la posizione quando cambiamo content in cima alla pagina
	pointer.needAdjustment = needResize; 
	document.body.appendChild(pointer); 
}