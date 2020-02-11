//CREAZIONE E GESTIONE DI UN OROLOGIO

//Lancia la creazione di un orologio
function addOrologio(citta, fusorario){
	var posizione = document.getElementsByClassName("divOrologio").length;

	var nuovoOrologio = new Orologio(fusorario, posizione, citta);

	hideOpzioniOrologi();
}

//FUNZIONI SULL'OGGETTO 'OROLOGIO'
var AGGIORNAMENTO_ORARIO = 10000; //10 secondi

//L'orologio viene inizializzato alle 9:45
var ORE_INIZIALI = 9;
var MINUTI_INIZIALI = 45;
var SFASAMENTO_ORE_INIZIALE = 20; //La lancetta delle ore deve partire un po' più avanti delle 9

var GRADI_PER_MINUTO = 6;
var GRADI_PER_ORA = 30;


//Funzione che crea l'oggetto orologio
function Orologio(locationOrario, ordine, locationCitta){
	this.fusorario = locationOrario;
	this.numero = ordine;
	this.citta = locationCitta

	this.show();
	this.set();

	var t=this;
	setInterval(function(){t.muoviMinuti();}, AGGIORNAMENTO_ORARIO);
}

//Funzione che mostra a video il layout di un orologio
Orologio.prototype.show = 
	function(){
		var divContenitore = document.getElementById("divContenitoreOrologi");
		var height = divContenitore.offsetHeight/16 + 10; //Conversione in em più aggiunta dell'altezza necessaria per comprendere orologio + input
		divContenitore.style.height = height + 'em';

		var arrayOrologi = divContenitore.getElementsByClassName("divOrologio");

		//Creiamo e inseriamo lo sfondo dell'orologio nella posizione a lui riservata
		var divOrologio = document.createElement("div");
		divOrologio.className = "divOrologio";

		if(this.numero >= arrayOrologi.length)
			divContenitore.appendChild(divOrologio);
		else divContenitore.insertBefore(divOrologio, divContenitore.childNodes[this.numero]);

		this.showLancette(divOrologio);

		//Creiamo l'input che conterrà il nome della città cui l'orologio fa riferimento
		var fintoTesto = document.createElement("input");
		fintoTesto.type = "text";
		fintoTesto.value = this.citta;
		fintoTesto.readOnly = true;
		divOrologio.appendChild(fintoTesto);
	}

//Funzione che inserisce le lancette
Orologio.prototype.showLancette =
	function(divOrologio){
		//Creiamo e inseriamo le lancette
		//Minuti
		var lancettaMinutiEsterna = document.createElement("div");
		lancettaMinutiEsterna.className = "divLancettaEsterna";
		divOrologio.appendChild(lancettaMinutiEsterna);

		var lancettaMinutiInterna = document.createElement("div");
		lancettaMinutiInterna.className = "divLancettaInterna";
		lancettaMinutiEsterna.appendChild(lancettaMinutiInterna);

		this.lancettaMinuti = lancettaMinutiEsterna;

		//Ore
		var lancettaOreEsterna = document.createElement("div");
		lancettaOreEsterna.className = "divLancettaEsterna";
		divOrologio.appendChild(lancettaOreEsterna);

		var lancettaOreInterna = document.createElement("div");
		lancettaOreInterna.className = "divLancettaInterna";
		lancettaOreInterna.style.width = '1.5em';
		lancettaOreInterna.style.left = '2.5em';
		lancettaOreEsterna.appendChild(lancettaOreInterna);

		this.lancettaOre = lancettaOreEsterna;
	}

//Funzione che imposta l'orario iniziale dell'orologio
Orologio.prototype.set =
	function(){
		//Qui si prende l'orario attuale; da notare che, partendo le lancette dalle 9:45, bisogna effettuare qualche conto
		var d = new Date();
		var localHour = d.getUTCHours() + parseInt(this.fusorario);
		if(localHour < 0)
			localHour += 12;

		//Minuti
		this.minuti = d.getMinutes();
		if(this.minuti >= MINUTI_INIZIALI)
			this.minuti %= MINUTI_INIZIALI;
		else this.minuti += (60 - MINUTI_INIZIALI);
		this.minuti *= GRADI_PER_MINUTO;

		//Ore
		this.ore = localHour%12;
		if(this.ore >= ORE_INIZIALI)
			this.ore %= ORE_INIZIALI;
		else this.ore += (12 - ORE_INIZIALI);
		this.ore *= GRADI_PER_ORA;
		this.ore += SFASAMENTO_ORE_INIZIALE; 

		//Spostiamo quindi le lancette nella posizione iniziale
		this.lancettaMinuti.style.transform = "rotate(" + this.minuti + "deg)";
		this.lancettaOre.style.transform = "rotate(" + this.ore + "deg)";
	}

//MOVIMENTO
//Funzioni che muovono le lancetta; la prima viene chiamata ogni 10 secondi, la seconda ogni 60
Orologio.prototype.muoviMinuti = 
	function(){
		this.minuti++;
		this.lancettaMinuti.style.transform = "rotate(" + this.minuti + "deg)";
		if(this.minuti%12 == 0)
			this.muoviOre();
		if(this.minuti == 360)
			this.minuti = 0;
	}

Orologio.prototype.muoviOre =
	function(){
		this.ore++;
		this.lancettaOre.style.transform = "rotate(" + this.ore + "deg)";
		if(this.ore == 360)
			this.ore = 0;
	}