<?php
	require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once DIR_UTIL . "databaseUtil.php";

    $usernameUtente = $_GET['user'];
    $idUser = getIdUser($usernameUtente);

    getMessageNotRead($idUser);
?>