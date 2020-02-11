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

    //Recuperiamo i valori degli input
    $text = $_POST['inputPostText'];
    $luogo = $_POST['inputLuogo'];
    $tag = $_POST['inputTag'];

    //Recuperiamo l'id dell'utente
    $idUser = $_SESSION['idUser'];

    $errorMessage = publishPost($text, $luogo, $tag, $idUser);
    if($errorMessage === null)
    	header('location: ../../layout/content/post.php?errorMessage=Post pubblicato!');
    else header('location: ../../layout/content/post.php?errorMessage='.$errorMessage);
?>