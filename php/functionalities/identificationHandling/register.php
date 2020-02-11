<?php
	require_once __DIR__ . "/../../config.php";
	require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";

    $usernameUtente = $_POST['username'];
	$nomeUtente = $_POST['nome'];
	$emailUtente = $_POST['email'];
	$passwordUtente = $_POST['password'];
	$confermaPasswordUtente = $_POST['confermaPassword'];

	//Controllo lato server
	$errorMessage = isAlreadyTaken($usernameUtente, $emailUtente);
	checkErrors($errorMessage);

	//Tutto ok, possiamo passare alla registrazione
	register($usernameUtente, $nomeUtente, $emailUtente, $passwordUtente);

	//********************************************************************************
	//FUNZIONI CONTROLLO

	//Controlla se l'username o l'email sono già stati utilizzati
	function isAlreadyTaken($usernameUtente, $emailUtente){
		global $eTravelDb;

		$usernameUtente = $eTravelDb->sqlInjectionFilter($usernameUtente);
		$emailUtente = $eTravelDb->sqlInjectionFilter($emailUtente);

		$queryText = "SELECT * FROM user WHERE username = '" . $usernameUtente . "' OR email = '".$emailUtente."'";

		$result = $eTravelDb->performQuery($queryText);
		$userRow = $result->fetch_assoc();

		//Controlliamo se la query ha dato risultato
		if(mysqli_num_rows($result) == 0){
			$eTravelDb->closeConnection();
			return null;
		}

		//Controlliamo se il problema è il nome utente o  la mail
		if(strcmp($userRow['username'], $usernameUtente)==0)
			return "Username già utilizzato";

		if(strcmp($userRow['email'], $emailUtente)==0)
			return "Email già utilizzata";
	}

	//Controlla se si sono verificati errori e, in caso, li segnala
	function checkErrors($errorMessage){
		if($errorMessage!=null){
			header('location: ../../../index.php?errorMessage='.$errorMessage);
			exit;
		}
	}
	//****************************************************************************************

	//Funzione di registrazione: registra un utente e inizializza una sessione per tale utente
	function register($usernameUtente, $nomeUtente, $emailUtente, $passwordUtente){
		global $eTravelDb;

		$usernameUtente = $eTravelDb->sqlInjectionFilter($usernameUtente);
		$nomeUtente = $eTravelDb->sqlInjectionFilter($nomeUtente);
		$emailUtente = $eTravelDb->sqlInjectionFilter($emailUtente);
		$passwordUtente = $eTravelDb->sqlInjectionFilter($passwordUtente);

		$queryText = "INSERT INTO user  (`username`, `name`, `email`, `password`) VALUES ('" . $usernameUtente . "', '". $nomeUtente . "', '" . $emailUtente . "', '". $passwordUtente . "')";
		$result = $eTravelDb->performQuery($queryText);

		//Verifichiamo se l'insert ha avuto successo e apriamo una sessione
		$queryText = "SELECT * FROM user WHERE username = '" . $usernameUtente . "'";
		$result = $eTravelDb->performQuery($queryText);
		$eTravelDb->closeConnection();

		if(mysqli_num_rows($result) != 1)
			checkErrors("Errore, riprovare più tardi");

		$userRow = $result->fetch_assoc();
		$idUser = $userRow['idUser'];		

		session_start();
     	setSession($usernameUtente, $idUser);

		header('location: ../../home.php');
	}
?>