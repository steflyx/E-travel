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

  //Recuperiamo i valori degli input
  $titolo = $_POST['inputTitolo'];
  $descrizione = $_POST['inputDescrizione'];
  $luogo = $_POST['inputLuogo'];
  $dataInizio = $_POST['inputDataInizio'];
  $dataFine = $_POST['inputDataFine'];
  $URL = null;

  //Recuperiamo l'id dell'utente
  $idUser = $_SESSION['idUser'];

  //Prima di pubblicare l'evento, salviamo l'eventuale foto associata e aggiorniamo il database
  if(isset($_FILES['inputFoto'])){
    $directoryUpload = $DIRECTORY_FOTO_UPLOAD;
    $directoryFile = $directoryUpload . basename($_FILES['inputFoto']['name']);
    $imageFileType = pathinfo($directoryFile, PATHINFO_EXTENSION);

    //Controllo per verificare se l'immagine è una vera immagine
    $check = getimagesize($_FILES['inputFoto']['tmp_name']);
    if($check != true)
        header('location: ../../layout/content/evento.php?errorMessage=Il file non è un\'immagine');

    //Controllo sul formato
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
        header('location: ../../layout/content/evento.php?errorMessage=Estensione non supportata');

    //Upload del file
    if (move_uploaded_file($_FILES['inputFoto']['tmp_name'], $directoryFile)) {
      $URL = basename($_FILES['inputFoto']['name']);
    } else header('location: ../../layout/content/evento.php?errorMessage=Errore nel caricamento');
  }

  //Salvataggio dell'evento all'interno del database
  $errorMessage = publishEvent($titolo, $descrizione, $luogo, $dataInizio, $dataFine, $idUser, $URL);
  if($errorMessage === null)
   	header('location: ../../layout/content/evento.php?errorMessage=Evento pubblicato!');
  else header('location: ../../layout/content/evento.php?errorMessage='.$errorMessage);
?>