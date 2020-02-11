<?php
	
	//Inizializza la sessione
	function setSession($usernameUtente, $idUser){
		$_SESSION['idUser'] = $idUser;
		$_SESSION['username'] = $usernameUtente;
	}

	//Controlla se l'utente ha già effettuato il login
	function isLogged(){		
		if(isset($_SESSION['idUser']))
			return $_SESSION['idUser'];
		else
			return false;
	}

?>