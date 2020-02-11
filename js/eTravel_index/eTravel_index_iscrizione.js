//FUNZIONI LEGATE ALLA RICHIESTA DI REGISTRAZIONE

//Funzione che si attiva dopo aver cliccato il pulsante "iscriviti ora";
//Tale funzione si occupa di riordinare gli input e di modificarne alcune proprietà 
function richiestaRegistrazione(){
	comparsaInput(); //riordino degli input

	//Trasformiamo il pulsante di iscrizione da 'button' a 'submit'
	var inputIscrizione = document.getElementById("inputIscrizione");
	inputIscrizione.setAttribute("type", "submit");

	//Cambiamo il file php a cui è associato il form
	var form = document.getElementById("formLogin");
	form.setAttribute("action", "./php/functionalities/identificationHandling/register.php")
}

//Funzione che modifica la grafica del login per permettere l'iscrizione
function comparsaInput(){

	var div = document.getElementById("divInputText");

	//Rimuoviamo il pulsante di login, non più utilizzato, e il testo sopra il pulsante di registrazione
	document.getElementsByTagName("p")[0].remove();
	document.getElementById("inputLogin").remove();

	//Aspettiamo  un certo intervallo di tempo per assicurarci che il pulsante di login sia stato rimosso prima di inserire i nuovi input
	var ritardo = 1000;
	setTimeout(comparsaInputRitardata(div), ritardo);
}

//Termina il lavoro della precedente
function comparsaInputRitardata(div){
	
	//Cambiamo il placeholder di 'inputUsername' e cancelliamo il contenuto presente
	var inputUsername = document.getElementById("inputUsername");
	inputUsername.value = "";
	inputUsername.placeholder = "Username";

	//Cancelliamo il contenuto di 'inputPassword' e modifichiamone il layout
	var inputPassword = document.getElementById("inputPassword");
	inputPassword.value="";
	inputPassword.style.marginBottom = "0.9em";

	//Inseriamo i campi "nome", "email" e "conferma password"
	var opacitaFinale = 1;
	var fadingInterval = 50;

	//Nome
	var inputNome = document.createElement("input");
	inputNome.type = "text";
	inputNome.id = "inputNome";
	inputNome.name = "nome";
	inputNome.placeholder = "Nome";
	inputNome.className = "inputDaInserire";
	inputNome.style.opacity = "0";
	div.insertBefore(inputNome, div.childNodes[2]);
	fadeIn(document.getElementById("inputNome"), opacitaFinale, fadingInterval);

	//Email
	var inputEmail = document.createElement("input");
	inputEmail.type = "text";
	inputEmail.id = "inputEmail";
	inputEmail.name = "email";
	inputEmail.placeholder = "Email";
	inputEmail.className = "inputDaInserire";
	inputEmail.style.opacity = "0";
	inputEmail.required = true;
	inputEmail.pattern = "^[_\\.a-z0-9-]+[@][a-z0-9]+([.][0-9a-z-]+)*[\\.][a-z]{2,4}$";
	inputEmail.title = "Inserire una mail valida";
	div.insertBefore(inputEmail, div.childNodes[3]);
	fadeIn(document.getElementById("inputEmail"), opacitaFinale, fadingInterval);

	//Conferma password
	var inputConfermaPassword = document.createElement("input");
	inputConfermaPassword.type = "password";
	inputConfermaPassword.id = "inputConfermaPassword";
	inputConfermaPassword.name = "confermaPassword";
	inputConfermaPassword.placeholder = "Conferma password";
	inputConfermaPassword.className = "inputDaInserire";
	inputConfermaPassword.style.opacity = "0";
	inputConfermaPassword.style.marginBottom = "1em";
	inputConfermaPassword.required = true;
	div.appendChild(inputConfermaPassword);
	fadeIn(document.getElementById("inputConfermaPassword"), opacitaFinale, fadingInterval);
}

//Mostra a video un messaggio di errore
function showError(){
	document.getElementById("divLoginError").style.display = "block";
	disappearError();
}

//Funzione che fa sparire un messaggio d'errore
function disappearError(){
	var opacitaFinale = 0;
	var fadingInterval = 50;
	setTimeout(function(){fadeOut(document.getElementById('divLoginError'), opacitaFinale, fadingInterval);}, 2000);
}

//Controlla che i valori di "password" e "conferma password" siano uguali
function validateForm(){
	var password = document.getElementById("inputPassword").value;
	var conferma = document.getElementById("inputConfermaPassword");
	if(!conferma) //Questa funzione viene chiamata anche nella schermata di login, in cui non è presente questo input
		return true;
	if(password == conferma.value)
		return true;
	showError();
	return false;
}