<?php
    session_start();
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    if(!isLogged()){
        echo "Errore di connessione";
        exit;
    }

    $nuovePreferenze = $_POST['inputPreferenze'];
    $idUser = $_SESSION['idUser'];

    //Il ciclo for modifica le varie preferenze (se specificate)
    $infoPreferenze = explode(",", $nuovePreferenze);
    for($i=0; $i<4; $i++){
    	if($infoPreferenze[$i] != -1){
	    	$errorMessage = modifyPreferences($idUser, $infoPreferenze[$i], $i);
	    	if($errorMessage != null)
	    		header('location: ../../profilo.php?errorMessage='.$errorMessage.'&username='.$_SESSION['username']);
	    }
	}

    header('location: ../../profilo.php?username='.$_SESSION['username'].'&errorMessage=Preferenze aggiornate')
?>