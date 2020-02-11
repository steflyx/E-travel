var NUM_SFONDI = 4;

//Funzione che attiva i vari effetti della pagina di login e imposta uno sfondo casuale fra quelli disponibili
function begin(){
	beginSfondo(); //Inizializzazione dello sfondo

	var header = document.getElementById("headerLogin");
	var section = document.getElementById("sectionSignIn");
	var footer = document.getElementById("footerLogin");
	
	//Si fanno apparire l'header, la sezione per il login e il footer
	var fadingInterval = 50;
	var opacitaFinale = 1;
	fadeIn(header, opacitaFinale, fadingInterval);
	fadeIn(section, opacitaFinale, fadingInterval);
	fadeIn(footer, opacitaFinale, fadingInterval);
	fadeIn(document.body, opacitaFinale, fadingInterval);

	//Sliding di header, footer e section
	//Header
	var startPositionUpHeader = -10;
	var endPositionUpHeader = 0;
	var horizontalPositionHeader = 0; //L'header non si muove in orizzontale
	var slidingIntervalHeader = 10;
	slide(header, startPositionUpHeader, endPositionUpHeader, horizontalPositionHeader, horizontalPositionHeader, slidingIntervalHeader);

	//Footer
	var startPositionUpFooter = 103;
	var endPositionUpFooter = 93;
	var horizontalPositionFooter = 0; //Il footer non si muove in orizzontale
	var slidingIntervalFooter = 10;
	slide(footer, startPositionUpFooter, endPositionUpFooter, horizontalPositionFooter, horizontalPositionFooter, slidingIntervalFooter);

	//Section
	var verticalPositionSection = 18; //La section non si muove in verticale
	var startPositionLeftSection = 100;
	var endPositionLeftSection = 80;
	var slidingIntervalSection = 5; //La section si muove più velocemente perché deve percorrere più spazio
	slide(section, verticalPositionSection, verticalPositionSection, startPositionLeftSection, endPositionLeftSection, slidingIntervalSection);
}

//Funzione che inizializza lo sfondo con un'immagine casuale; è separata rispetto al resto di begin in modo da poterla
//richiamare singolarmente quando l'utente immette dati sbagliati (non si ripete invece lo slide)
function beginSfondo(){
	var randomSfondo = Math.floor(Math.random()*NUM_SFONDI);
	document.body.style.backgroundImage = "url(./css/immagini/SfondiLogin/sfondo" + randomSfondo + ".jpg)";
}

//Funzione che fa lentamente apparire un elemento aumentandone l'opacità a cicli di durata variabiale
function fadeIn(elemento, opacitaFinale, intervallo){
	var opacitaIniziale = 0.1;

	//Se l'opacità passata è minore di 0.1, la funzione non si attiva
	if (opacitaIniziale >= opacitaFinale)
    	return;
    
    //Timer che aumenta periodicamente l'opacità
    var timer = setInterval(
    	function () {
    		//Condizione di stop
	        if (opacitaIniziale >= opacitaFinale){
	            clearInterval(timer);
	            opacitaIniziale = opacitaFinale;
	        }

	   		elemento.style.opacity = opacitaIniziale;

	   		opacitaIniziale += 0.1;
	   	}, intervallo);
}

//Funzione che fa lentamente scomparire un elemento diminuendone l'opacità a cicli di durata variabiale
function fadeOut(elemento, opacitaFinale, intervallo){
	var opacitaIniziale = 1.0;

	//Se l'opacità passata è maggiore di 1, la funzione non si attiva
	if (opacitaIniziale <= opacitaFinale)
    	return;
    
    //Timer che diminuisce periodicamente l'opacità
    var timer = setInterval(
    	function () {
    		//Condizione di stop
	        if (opacitaIniziale <= opacitaFinale){
	            clearInterval(timer);
	            opacitaIniziale = opacitaFinale;
	        }

	   		elemento.style.opacity = opacitaIniziale;

	   		opacitaIniziale -= 0.1;
	   	}, intervallo);
}

//Funzione che sposta un oggetto in verticale (startPositionUp --> endPositionUp) e in orizzontale (startPositionLeft --> endPositionLeft)
//Il movimento può essere in tutte le direzioni e la sua velocità è inversamente proporzionale all'intervallo scelto
//Le posizioni sono calcolate rispetto al lato in alto e rispetto a quello a sinistra
var MOVIMENTO_PER_CHIAMATA = 0.1;

function slide(elemento, startPositionUp, endPositionUp, startPositionLeft, endPositionLeft, intervallo){

	var timer = setInterval(
		function () {
			//A differenza della funzione 'fade', qui non possiamo usare semplicemente startPosition >= endPosition,
			//perché la funzione può essere sia da una posizione maggiore verso una minore
			//che il viceversa. Usare solo l'uguaglianza non funzionerebbe nei casi in cui uno dei due parametri
			//è più preciso dell'altro (es. startPosition = 20.4 endPosition = 30.15)
			var differenzaUp, isMovingUp;
			var differenzaLeft, isMovingLeft;

			//Controlliamo se il movimento è verso l'alto o verso il basso
			//e recuperiamo la differenza fra la posizione in cui ci troviamo e quella finale
			if(startPositionUp<=endPositionUp){
				differenzaUp = endPositionUp - startPositionUp;
				isMovingUp=false;
			}
			else {
				differenzaUp = startPositionUp - endPositionUp;
				isMovingUp=true;
			}

			//Controlliamo se il movimento è verso sinistra o verso destra
			if(startPositionLeft<=endPositionLeft){
				differenzaLeft = endPositionLeft - startPositionLeft;
				isMovingLeft=false;
			}
			else {
				differenzaLeft = startPositionLeft - endPositionLeft;
				isMovingLeft=true;
			}

			//Se entrambe le differenze sono minori del movimento che facciamo fare all'elemento ad ogni chiamata, fermiamo il timer
	        if (differenzaUp<MOVIMENTO_PER_CHIAMATA && differenzaLeft<MOVIMENTO_PER_CHIAMATA)	
	            clearInterval(timer);

	        //Cambiamo gli attributi top e left dell'elemento
	   		elemento.style.top = startPositionUp + '%';
	   		elemento.style.left = startPositionLeft + '%';
	   		
	   		//Se l'elemento deve ancora essere mosso in verticale effettuiamo tale movimento
	   		if(differenzaUp>=MOVIMENTO_PER_CHIAMATA){
	   			if(isMovingUp)
	        		startPositionUp -= MOVIMENTO_PER_CHIAMATA;
	        	else startPositionUp += MOVIMENTO_PER_CHIAMATA;
	    	}

	    	//Se l'elemento deve ancora essere mosso in orizzontale effettuiamo tale movimento
	    	if(differenzaLeft>=MOVIMENTO_PER_CHIAMATA){
		        if(isMovingLeft)
		        	startPositionLeft -= MOVIMENTO_PER_CHIAMATA;
		        else startPositionLeft += MOVIMENTO_PER_CHIAMATA;
		    }

	   	}, intervallo);
}

//VISUALIZZAZIONE CONTATTI

//Mostra a video le informazioni sui contatti
function showContatti(){
	document.getElementById("divContattiBackground").style.display = "block";
}

//Nasconde le informazioni sui contatti
function hideContatti(){
	document.getElementById("divContattiBackground").style.display = "none";
}