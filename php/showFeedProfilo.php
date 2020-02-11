<?php
	session_start();
	require_once __DIR__ . "/config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    if(!isLogged()){
    	echo "Errore di connessione";
    	exit;
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8"> 
   	<meta name = "author" content = "Stefano Agresti">
   	<meta name = "keywords" content = "viaggiare, social, turismo">
    <link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_didascalia.css" media="screen">
   	<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_feed.css" media="screen">
    <link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_pointer.css" media="screen">
   	<link rel="stylesheet" type="text/css" href="../css/eTravel_home/eTravel_home.css" media="screen">
	  <link rel="stylesheet" type="text/css" href="../css/font/font.css" media="screen">
    <script type="text/javascript" src="../js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
    <script type="text/javascript" src="../js/eTravel_dynamic/eTravel_dynamic_pointer_handler.js"></script> 
    <script type="text/javascript" src="../js/eTravel_home/eTravel_home_content_handler.js"></script> 
	  <script type="text/javascript" src="../js/eTravel_home/eTravel_home_viaggio_handler.js"></script> 
  </head>

  <?php
    $idUserPagina = getIdUser($_GET['username']);
   	if(!isset($_GET['content']) || $_GET['content'] == "post")
   		showPostFromProfilo($idUserPagina);
   	elseif ($_GET['content'] == "eventi")
   		showEventsFromProfilo($idUserPagina);
   	elseif ($_GET['content'] == "viaggi")
   		showViaggiFromProfilo($idUserPagina);
  ?>

  <p style="text-align: center">Non ci sono altri contenuti da mostrare</p>

</html>