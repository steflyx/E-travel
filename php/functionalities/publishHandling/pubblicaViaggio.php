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

    //Recuperiamo le informazioni legate al viaggio in generale e inseriamolo nel database
    $numTappe = $_POST['inputHiddenInfoNumTappe'];
    $idUser = $_SESSION['idUser'];
    $userTagged = $_POST['inputTag'];
    $wantsCompany = (isset($_POST['inputCompagnia'])) ? 1 : 0;
    $errorMessage = publishViaggio($idUser, $userTagged, $wantsCompany);
    if($errorMessage != null){
        header('location: ../../layout/content/viaggio.php?errorMessage='.$errorMessage);
        exit;
    }

    //Recuperiamo le informazioni sulle singole tappe e inseriamole singolarmente nel database
    //Da notare che i mezzi e le coordinate sono memorizzati all'interno di input nascosti nel seguente modo:
    //Mezzi: Mezzo1,Mezzo2,Mezzo3....
    //Coordinate: Coord1X,Coord1Y;Coord2X,Coord2Y;...
    $idViaggio = getIdLastViaggio($idUser);
    $infoMezzi = explode(",", $_POST['inputHiddenInfoMezzoTappa']);
    $infoCoord = explode(";", $_POST['inputHiddenInfoCoordTappa']);
    for($i = 0; $i < $numTappe; ++$i){
        $numInput = $i + 1; //I nomi degli input cominciano da 1
        $luogoTappa = $_POST['inputLuogo'.$numInput];
        $commentoTappa = $_POST['inputCommento'.$numInput];
        $coordX = explode(",", $infoCoord[$i])[0];
        $coordY = explode(",", $infoCoord[$i])[1];
        $dataTappa = $_POST['inputPeriodo'.$numInput];
        $errorMessage = publishTappa($idViaggio, $luogoTappa, $commentoTappa, $infoMezzi[$i], $coordX, $coordY, $dataTappa);
        if($errorMessage != null){
            header('location: ../../layout/content/viaggio.php?errorMessage='.$errorMessage);
            exit;
        }
    }
    header('location: ../../layout/content/viaggio.php?errorMessage=Viaggio pubblicato!');
?>