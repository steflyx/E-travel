<?php
	session_start(); 
    require_once __DIR__ . "/php/config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php";
    require_once DIR_UTIL . "sessionUtil.php";

    if(isset($_GET['logout']))
    	session_destroy();

    if(isLogged()){
    	header('location: ./php/home.php');
    	exit;
	}
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "author" content = "Stefano Agresti">
    	<meta name = "keywords" content = "viaggiare, social, turismo">
   	 	<link rel="shortcut icon" type="image/x-icon" href="./css/icon/icon.jpg"/>
		<link rel="stylesheet" type="text/css" href="./css/eTravel_dynamic/eTravel_dynamic_didascalia.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./css/eTravel_index/eTravel_index.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./css/eTravel_index/eTravel_index_contatti.css" media="screen">
		<link rel="stylesheet" type="text/css" href="./css/font/font.css" media="screen">
		<script type="text/javascript" src="./js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
		<script type="text/javascript" src="./js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="./js/eTravel_index/effettiIndex.js"></script> 
		<script type="text/javascript" src="./js/eTravel_index/eTravel_index_iscrizione.js"></script> 
		<title>eTravel</title>
	</head>
	<?php
		if(isset($_GET['errorMessage']))
			echo '<body onLoad="beginSfondo(); disappearError()">';
		else echo '<body onLoad="begin()">';
	?>
		<?php
			if(isset($_GET['errorMessage']))
				echo '<header id="headerLogin" style="top: 0;">';
			else echo '<header id="headerLogin">';
		?>
			<h1>eTravel.com</h1>
			<div id="divSottotitolo">
				<h2 id="sottotitoloAlto">Together we travel,</h2>
				<h2 id="sottotitoloBasso">together we live</h2>
			</div>
		</header>
		<section id="sectionSignIn">
			<h3>Unisciti alla community!</h3>
			<?php
				if(isset($_GET['errorMessage']) && $_GET['errorMessage']!="Dati non validi")
					require DIR_LAYOUT . "indexError.php";
				else require DIR_LAYOUT . "indexLogin.php";
			?>
			<?php
				if(isset($_GET['errorMessage']))
					echo '<div id="divLoginError">'.$_GET['errorMessage'].'</div>';
				else{ 
					$error = "Le password non coincidono";
					echo '<div id="divLoginError" style="display: none">'.$error.'</div>';
				}
			?>
		</section>
		<!-- CONTATTI -->
		<div id="divContattiBackground">
			<div id="divContatti">
				<h3>Contatti</h3>
				<div id="divTesto">
					<p>
						Questo sito è stato interamente progettato e realizzato da Stefano Agresti 
						nell'ambito	di un progetto universitario attinente all'esame di progettazione web
					</p>
					<br>
					<p>
						Se siete interessati a contattarmi, potete usare il mio indirizzo email 
						<a href="mailto:stefano.agresti19@gmail.com" style="color: blue">stefano.agresti19@gmail.com</a>
					</p>
				</div>
			</div>
			<p id="closeChatButton" onmouseover="showHint(event, 'Chiudi', 3)" onmouseout="hideHint()" onclick="hideContatti()">X</p>
		</div>
	</body>
	<footer id="footerLogin">
		<div>
			<a href="#" onclick="showContatti()">Contatti</a>
			<a href="./html/terms.html">Termini di servizio</a>
			<a href="./html/privacy.html">Privacy</a>
			<a href="./html/aiuto.html">Aiuto</a>
		</div>
	</footer> 
</html>
