<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    $usernameUtente = $_GET['user'];
    $idUser = getIdUser($usernameUtente);

    $relationship = $_GET['relationship'];

    switch ($relationship) {
    	case 0:
            getFavouriteUser($idUser); 
            break;
    	case 1: 
            getChaserUser($idUser); 
            break;
    	case 2: 
            getPopularUser($idUser); 
            break;
    }
	
?>