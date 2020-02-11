//FUNZIONI CHE GESTISCONO I CAMBI NELLE IMPOSTAZIONI DI UN UTENTE

//Funzione che permette all'utente di cambiare le proprie informazioni generali
function changeInformation(){
	var arrayInput = document.getElementById("formInfoGenerali").getElementsByClassName("fintoTesto");

	//Cambiamo le proprietà dei vari input
	for(var i=0; i<5; i++){
		if(i!=1){ //Non si può cambiare il nickname
			arrayInput[i].style.backgroundColor = "white";
			arrayInput[i].readOnly = false;
		}
	}

	//Eliminiamo l'immagine per il cambio delle impostazioni e sostituiamola con quella per il submit del form
	document.getElementById("divSettings").getElementsByTagName("img")[0].remove();

	var img = document.createElement("img");
	img.setAttribute("src", "../css/immagini/submit.png");
	img.setAttribute("alt", "Submit");
	img.style.float = "none";
	img.addEventListener("click", function(){submitForm("formInfoGenerali");});
	img.addEventListener("mouseover", function(e){showHint(e, "Submit", 3.5);});
	img.addEventListener("mouseout", function(){hideHint();});
	document.getElementById("divSettings").appendChild(img);
}

//Funzione che permette di fare il submit di un form
function submitForm(formId){
	document.getElementById(formId).submit();
}
