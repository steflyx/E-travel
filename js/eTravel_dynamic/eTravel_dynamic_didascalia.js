//GESTIONE DELLE DIDASCALIE

//Distanziamento della didascalia dalla posizione del mouse (altrimenti diventa fastidiosa)
var DISTANZIAMENTO = 5; 


//Funzione che fa comparire una didascalia dove si trova il mouse
//'larghezza' è inteso in em
function showHint(e, hint, larghezza){
	var positionX = e.clientX + DISTANZIAMENTO;
	var positionY = e.clientY + DISTANZIAMENTO;

	//Per sicurezza, si controlla che non ne esista già una
	var didascalia = document.getElementById("inputDidascalia");

	if(!didascalia){
		didascalia = document.createElement("input");
		didascalia.id = "inputDidascalia";
		didascalia.type = "text";
		didascalia.value = hint;
		didascalia.style.width = larghezza + 'em';
		didascalia.readOnly = true;
		document.body.appendChild(didascalia);  
	}

	didascalia.style.left = positionX + 'px';
	didascalia.style.top = positionY + 'px';
}

//Funzione che annulla la precedente, rimuovendo la didascalia
function hideHint(){
	if(document.getElementById("inputDidascalia"))
		document.getElementById("inputDidascalia").remove();
}
/****************************************************/