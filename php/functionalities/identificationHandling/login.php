<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
 
	$usernameUtente = $_POST['username'];
	$passwordUtente = $_POST['password'];
	
	$errorMessage = login($usernameUtente, $passwordUtente);
	if($errorMessage === null)
	 	header('location: ../../home.php');
	else
		header('location: ../../../index.php?errorMessage='.$errorMessage);

	//Funzione che effettua l'autenticazione di un utente; restituisce un eventuale messaggio di errore oppure null
	function login($usernameUtente, $passwordUtente){   
		if ($usernameUtente != null && $passwordUtente != null){

			$idUser = authenticateUsername($usernameUtente, $passwordUtente);
			if($idUser<0){
				$usernameUtente = getUsernameFromEmail($usernameUtente); //Controlliamo se l'utente si sta loggando dall'email
				if($username == -1)
					return "Dati non validi";
			}

			$idUser = authenticateUsername($usernameUtente, $passwordUtente);

		 	if($idUser>0){
		 		session_start();
     			setSession($usernameUtente, $idUser);
     			return null;
		 	}else return "Dati non validi";
		}else return "Inserisci qualcosa";
	}
	
	//Prova ad autenticare l'utente intendendo $usernameUtente come l'username (potrebbe anche essere l'email)
	function authenticateUsername ($usernameUtente, $passwordUtente){   
		global $eTravelDb;

		$usernameUtente = $eTravelDb->sqlInjectionFilter($usernameUtente);
		$passwordUtente = $eTravelDb->sqlInjectionFilter($passwordUtente);

		$queryText = "SELECT * FROM user WHERE username = '" . $usernameUtente . "' AND password = '" . $passwordUtente . "'";

		$result = $eTravelDb->performQuery($queryText);

		$numRow = mysqli_num_rows($result);
		if ($numRow != 1)
		 	return -1;
		
		$eTravelDb->closeConnection();
		$userRow = $result->fetch_assoc();
		return $userRow['idUser'];
	}

	//Recupera l'username di un utente a partire dalla sua mail
	function getUsernameFromEmail ($email){   
		global $eTravelDb;

		$email = $eTravelDb->sqlInjectionFilter($email);

		//La variabile $usernameUtente può rappresentare anche l'email dell'utente
		$queryText = "SELECT * FROM user WHERE email = '".$email."'";

		$result = $eTravelDb->performQuery($queryText);

		$numRow = mysqli_num_rows($result);
		if ($numRow != 1)
		 	return -1;
		
		$eTravelDb->closeConnection();
		$userRow = $result->fetch_assoc();
		return $userRow['username'];
	}

?>