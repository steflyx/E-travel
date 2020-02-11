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

    $idUser = $_SESSION['idUser'];
    $idEvento = $_POST['inputIdEvento'];

    $errorMessage = checkIfAlreadyPartecipate($idUser, $idEvento);
    if($errorMessage != null){
    	header('location: ../../home.php?errorMessage='.$errorMessage);
        exit;
    }

    $errorMessage = addPartecipazione($idUser, $idEvento);
    if($errorMessage != null){
    	header('location: ../../home.php?errorMessage='.$errorMessage);
        exit;
    }

    header('location: ../../home.php'); 
?>