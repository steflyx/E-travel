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

    $citta = $_POST['inputCitta'];
    $fusorario = $_POST['inputFusorario'];
    $idUser = $_SESSION['idUser'];

    $errorMessage = addOrologio($idUser, $citta, $fusorario);
    if($errorMessage != null)
    	header('location: ../../profilo.php?errorMessage='.$errorMessage.'&username='.$_SESSION['username']);
    header('location: ../../profilo.php?username='.$_SESSION['username']);
?>