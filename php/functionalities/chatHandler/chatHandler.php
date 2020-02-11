<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    //Distinguiamo quale funzione ha contattato il server

    //checkNewMessage
    if(isset($_GET['isThereNewMessage'])){
    	$idDestinatario = getIdUser($_GET['userDestinatario']);
    	$idMittente = getIdUser($_GET['userMittente']);
    	$nuovoMessaggio = getLatestMessageNotVisualizzato($idDestinatario, $idMittente);
    	echo $nuovoMessaggio;
    }

    //sendMessage
    if(isset($_POST['text'])){
    	$idDestinatario = getIdUser($_POST['userDestinatario']);
    	$idMittente = getIdUser($_POST['userMittente']);
    	$isMessageArrived = sendMessage($_POST['text'], $idDestinatario, $idMittente);
    	echo $isMessageArrived;
    }
?>