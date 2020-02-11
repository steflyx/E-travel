<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    $chaser = $_GET['chaserUser'];
    $chased = $_GET['chasedUser'];

    $errorMessage = checkIfAlreadyChased($chaser, $chased);
    if($errorMessage != null){
        echo $errorMessage;
        return;
    }

    $errorMessage = addChase($chaser, $chased);
    if($errorMessage != null){
        echo $errorMessage;
        return;
    }

    //Il messaggio di ok viene gestito dalla stessa funzione che gestisce i messaggi di errore
    echo 'Utente aggiunto ai tuoi chasing';
?>