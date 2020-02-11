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
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_ErrorMessage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_evento.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/font/font.css" media="screen">
		<script type="text/javascript" src="../../../js/eTravel_content/eTravel_content_publishing.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_index/effettiIndex.js"></script>
		<title>Evento</title>
	</head>
	<body onLoad="clearError()">
		<form action="../../functionalities/publishHandling/pubblicaEvento.php" method="post" enctype="multipart/form-data">
			<div id="divEvento">
				<div id="divEventoUp">
					<div id="divTitolo">
						<h2>Titolo</h2>
						<input type="text" name="inputTitolo" id="inputTitolo" placeholder="Inserisci il titolo" required maxlength="45">
					</div>
					<div id="divFoto">
						<h2>Foto</h2>
						<input type="file" id="inputFoto" name="inputFoto" style="width: 11em">
					</div>
				</div>
				<div id="divEventoCenter">
					<div id="divDescrizione">
						<h2>Descrizione</h2>
						<textarea name="inputDescrizione" placeholder="Inserisci descrizione" required></textarea>
					</div>
					<div id="divLuogo">
						<h2>Luogo</h2>
						<input type="text" name="inputLuogo" placeholder="Inserisci luogo" maxlength="45">
					</div>
				</div>
				<div id="divEventoDown">
					<h2>Periodo</h2>
					<input type="text" name="inputDataInizio" placeholder="Data iniziale (DD/MM/AAAA)" pattern="[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{2,4}" title="DD/MM/AAAA">
					<input type="text" name="inputDataFine" placeholder="Data finale (DD/MM/AAAA)" pattern="[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{2,4}" title="DD/MM/AAAA">
				</div>
			</div>
			<input type="submit" class="pressEvento" value="Crea">
			<?php
				if(isset($_GET['errorMessage']))
					echo '<div id="divError" class="divErrorViaggioEvento" style="top: 19em">'.'<p id="pMessaggioErrore">'.$_GET['errorMessage'].'</p></div>';
			?>
		</form>
	</body>
</html>