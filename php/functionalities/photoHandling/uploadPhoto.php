<?php
    session_start();
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    $DIRECTORY_FOTO_UPLOAD = "../../../upload/";

    if(!isLogged()){
        echo "Errore di connessione";
        exit;
    }

    //Recuperiamo le informazioni
    $usernameUtente = $_SESSION['username'];
    $idUser = $_SESSION['idUser'];
    $fotoProfilo = (isset($_POST['submitFotoProfilo'])) ? 1 : 0; //Controlliamo se è la foto profilo oppure un'altra
    $directoryFile = $DIRECTORY_FOTO_UPLOAD . basename($_FILES["inputFoto"]["name"]);
	$imageFileType = pathinfo($directoryFile,PATHINFO_EXTENSION);

	//Controllo per verificare se l'immagine è una vera immagine
   	$check = getimagesize($_FILES["inputFoto"]["tmp_name"]);
    if($check != true)
        header('location: ../../profilo.php?username='.$usernameUtente.'&errorMessage=Il file non è un\'immagine');

	//Controllo sul formato
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
        header('location: ../../profilo.php?username='.$usernameUtente.'&errorMessage=Estensione non supportata');

    //Upload e eventuale memorizzazione nel database dell'URL
    if (move_uploaded_file($_FILES["inputFoto"]["tmp_name"], $directoryFile)) {
    	if($fotoProfilo == 0)
    		$errorMessage = memorizzaFoto($idUser, basename($_FILES["inputFoto"]["name"]));
    	else $errorMessage = memorizzaFotoProfilo($idUser, basename($_FILES["inputFoto"]["name"]));
    	if($errorMessage != null)
    		header('location: ../../profilo.php?username='.$usernameUtente.'&errorMessage='.$errorMessage);
    	header('location: ../../profilo.php?username='.$usernameUtente.'&errorMessage=File caricato');
    }
    else header('location: ../../profilo.php?username='.$usernameUtente.'&errorMessage=Errore nel caricamento');
?>