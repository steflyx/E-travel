<?php
	session_start(); 
    require_once __DIR__ . "/../../config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php";
    require_once DIR_UTIL . "sessionUtil.php";

    if(!isLogged()){
    	echo 'Non sei connesso';
    	exit;
	}
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "author" content = "Stefano Agresti">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_dynamic/eTravel_dynamic_didascalia.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_dynamic/eTravel_dynamic_pointer.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_ErrorMessage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_viaggio.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_viaggio_tappa.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/font/font.css" media="screen">
		<script type="text/javascript" src="../../../js/eTravel_content/eTravel_content_publishing.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_dynamic/eTravel_dynamic_pointer_handler.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_home/eTravel_home_viaggio_handler.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_index/effettiIndex.js"></script>
		<title>Viaggio</title>
	</head>
	<body onLoad="clearError()">
		<form action="../../functionalities/publishHandling/pubblicaViaggio.php" method="post" onsubmit="return validateFormViaggi()">
			<div id="divViaggio">
				<div id="divViaggioLeft">
					<!-- CONTENUTO CREATO DINAMICAMENTE -->
					<div id="divTappe">
						
					</div>
					<div id="divInsert">
						<img src="../../../css/immagini/addLocation.png" alt="Aggiungi una tappa" onmouseover="showHint(event, 'Aggiungi tappa', 7)" onmouseout="hideHint()" onclick="addTappa()">
	 				</div>
				</div>
				<div id="divViaggioRight">
					<img id="imgMap" src="../../../css/immagini/mapItaly.svg" alt="Spiacenti, non riusciamo a caricare la mappa" onmousemove="movePointer(event)" onclick="stopPointer(event)">			
				</div>
			</div>
			<div id="divViaggioBottom">
				<img src="../../../css/immagini/withFriendsIcon.png" alt="Con chi sei?" onmouseover="showHint(event, 'Con chi vai?', 6)" onmouseout="hideHint()" onclick="showWhereAndWith(0, 'divViaggioBottom')">
				<input type="submit" id="submitViaggio" value="Condividi!">
			</div>		
			<p>Cerchi compagnia?</p>
			<input type="checkbox" id="checkCompagnia" name="inputCompagnia">
			<?php
				if(isset($_GET['errorMessage']))
					echo '<div id="divError" class="divErrorViaggioEvento" style="top: 28em;">'.'<p id="pMessaggioErrore">'.$_GET['errorMessage'].'</p></div>';
			?>
			<input name="inputHiddenInfoNumTappe" id="inputHiddenInfoNumTappe" type="hidden">
			<input name="inputHiddenInfoMezzoTappa" id="inputHiddenInfoMezzoTappa" type="hidden">
			<input name="inputHiddenInfoCoordTappa" id="inputHiddenInfoCoordTappa" type="hidden">
		</form>
	</body>
</html>