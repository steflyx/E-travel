<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    $nome = $_POST['inputNome'];
    $luogoOrigine = $_POST['inputLuogoOrigine'];
    if($luogoOrigine == "Non specificato")
        $luogoOrigine = null;
    
    $luogoPreferito = $_POST['inputLuogoPreferito'];
    if($luogoPreferito == "Non specificato")
        $luogoPreferito = null;

    $dataNascita = $_POST['inputDataNascita'];
    if($dataNascita == "Non specificata")
        $dataNascita = null;

    $usernameUtente = $_POST['inputNickname'];
    $usernameUtente = explode("@", $usernameUtente)[1];

    $errorMessage = changeInfoGenerali($nome, $luogoOrigine, $luogoPreferito, $dataNascita, $usernameUtente);
    if($errorMessage != null)
    	header('location: ../../profilo.php?errorMessage='.$errorMessage);
    else header('location: ../../profilo.php?username='.$usernameUtente);
?>