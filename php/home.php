<?php
	session_start(); 
    require_once __DIR__ . "/config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php";
    require_once DIR_UTIL . "sessionUtil.php";

    if(!isLogged()){
    	header('location: ../index.php');
    	exit;
	}

	if(isset($_GET['notizie']))
		$_SESSION['notizie'] = $_GET['notizie'];
?>

<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="utf-8"> 
    	<meta name = "author" content = "Stefano Agresti">
    	<meta name = "keywords" content = "viaggiare, social, turismo">
   	 	<link rel="shortcut icon" type="image/x-icon" href="../css/icon/icon.jpg"/>
		<link rel="stylesheet" type="text/css" href="../css/eTravel_altro/eTravel_header_generico.css" media="screen">
   	 	<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_chat.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_didascalia.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_feed.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_message.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_pointer.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_user_info.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/eTravel_home/eTravel_home.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/font/font.css" media="screen">
		<script type="text/javascript" src="../js/ajaxHandler/ajaxHandler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
		<script type="text/javascript" src="../js/eTravel_dynamic/eTravel_dynamic_pointer_handler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_chat/chatHandler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/eTravel_home_content_handler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/eTravel_home_messaggi.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/eTravel_home_user_search.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/eTravel_home_viaggio_handler.js"></script> 
		<title>Home</title>
	</head>
	<body onLoad="showContent(0)">
	<body>
		<header>
			<h1>eTravel.com</h1>
			<form id="formCerca">
				<input id="inputCerca" type="text" placeholder="Cerca un utente" name="cerca" onkeyup="searchUser(this.value)">
			</form>
		</header>
		<div id="divCorpoCentrale">
			<aside id="asideLeft">
				<ul class="ulLaterali">
					<li>
						<!-- CARICAMENTO DELLA FOTO PROFILO -->
						<div class="divImmagineProfilo">
							<?php echo '<a href="./profilo.php?username='.$_SESSION['username'].'">'; ?>
								<?php
									include DIR_UTIL . "databaseUtil.php";
									$pathFotoProfilo = getFotoProfilo($_SESSION['username']);
									if($pathFotoProfilo == "default") 
										$pathFotoProfilo = "../css/immagini/fotoProfiloIcon.jpg"; //Foto di default
									else $pathFotoProfilo = "../upload/".$pathFotoProfilo;
									echo '<img class="imgProfiloNotifiche" src="'.$pathFotoProfilo.'" alt="Foto profilo" onmouseover="showHint(event, \'Foto profilo\', 6)" onmouseout="hideHint()">';
								?>
							</a>
						</div>
						<!-- PULSANTI "CHASE", "MESSAGGI", "PROFILO" -->
						<div style="float: left">
							<?php
								echo '<div class="divImmaginiNotifiche" onclick="showUserRelated(1)">';
							?>
								<img class="imgProfiloNotifiche" src="../css/immagini/chaseIcon.png" alt="Chasers" onmouseover="showHint(event, 'Chase', 4.2)" onmouseout="hideHint()">
							</div>
							<?php
								echo '<div class="divImmaginiNotifiche" onclick="showMessageToBeRead()">';
							?>
								<img class="imgProfiloNotifiche" src="../css/immagini/messageIcon.jpg" alt="Messaggi" onmouseover="showHint(event, 'Messaggi', 4.4)" onmouseout="hideHint()">
							</div>
							<div class="divImmaginiNotifiche">
								<?php echo '<a href="./profilo.php?username='.$_SESSION['username'].'">'; ?>
								<img class="imgProfiloNotifiche" src="../css/immagini/accountIcon.png" alt="Profilo" onmouseover="showHint(event, 'Profilo', 4.2)" onmouseout="hideHint()"></a>
						</div>
					</div>
					</li>
					<!-- PULSANTE "NOTIZIE", CON SOTTOPULSANTI "PRINCIPALI" E "RECENTI"-->
					<li class="liUtil" id="liNotizie" style="padding-top: 0.5em">
						<div class="divUtilLeft">
							<img id="imgNewsIcon" class="imgIcon" alt=" " src="../css/immagini/newsIcon.png">
							<a href="./home.php?notizie=0" style="float: left">Notizie</a>
							<div id="divImgInGiuIcon" onmouseover="showNewsType()" onmouseout="hideNewsType()">
								<img src="../css/immagini/inGiuIcon.png" alt=" ">
							</div>
							<ul id="ulNotizie" onmouseover="showNewsType()" onmouseout="hideNewsType()">
								<li class="liInterno"><a href="./home.php?notizie=1">Principali</a></li>
								<li class="liInterno"><a href="./home.php?notizie=0">Recenti</a></li>
							</ul>
						</div>
					</li>
					<!-- PULSANTE "PREFERITI" -->
					<li class="liUtil">
						<?php
							echo '<div class="divUtilLeft" onclick="showUserRelated(0)">';
						?>
							<img class="imgIcon" alt=" " src="../css/immagini/preferitiIcon.png">
							<h3 class="opzioniMenu">Preferiti</h3>
						</div>
					</li>
					<!-- PULSANTE "VIAGGI" -->
					<li class="liUtil">
						<div class="divUtilLeft">
							<div class="divImgIcon">
								<img class="imgIcon" alt=" " src="../css/immagini/viaggiIcon.png">
							</div>
							<a href="./home.php?notizie=2">Viaggi</a>
						</div>
					</li>
				</ul>
				<!-- PROPOSTE -->
				<div class="divLista">
					<p class="pLista" style="text-align: center">Proposte</p>
					<?php
						showProposte();
					?>
				</div>
			</aside>
			<!-- CONTENT-PUBLISHING E FEED -->
			<article>
				<div id="divFeedWrapper">
					<div class="divContent">
						<ul id="ulContent">
							<li class="liContent" onClick="showContent(0)" onmouseover="overContent(0)" onmouseout="stopOverContent(0)">Post</li>
							<li class="liContent" id="liViaggio" onClick="showContent(1)" onmouseover="overContent(1)" onmouseout="stopOverContent(1)">Viaggio</li>
							<li class="liContent" onClick="showContent(2)" onmouseover="overContent(2)" onmouseout="stopOverContent(2)">Evento</li>
						</ul>
						<iframe id="windowContent"></iframe>
					</div>
					<!-- CARICAMENTO DEL FEED -->
					<?php
						if(!isset($_SESSION['notizie']) || $_SESSION['notizie'] == 0) //Di default carichiamo le notizie più recenti
							showRecentFeed($_SESSION['idUser'], 0);
						elseif ($_SESSION['notizie'] == 1)
						 	showRecentFeed($_SESSION['idUser'], 1);
						elseif ($_SESSION['notizie'] == 2)
						 	showRecentViaggi();
					?>
				</div>
			</article>
			<aside id="asideRight">
				<ul class="ulLaterali">
					<!-- PULSANTE "IMPOSTAZIONI" -->
					<li class="liUtil">
						<div class="divUtilRight">
							<div class="divImgIcon">
								<img class="imgIcon" alt=" " src="../css/immagini/settingsIcon.png">
							</div>
								<?php echo '<a href="./profilo.php?username='.$_SESSION['username'].'&impostazioni=Change">'; ?>
								Impostazioni</a>
						</div>
					</li>
					<!-- PULSANTE "TROVA AMICI"-->
					<li class="liUtil">
						<div class="divUtilRight" onclick="showUserRelated(2)">
							<div class="divImgIcon">
								<img class="imgIcon" alt=" " src="../css/immagini/findFriendsIcon.png">
							</div>
							<a href="#">Trova amici</a>
						</div>
					</li>
					<!-- PULSANTE "LOGOUT" -->
					<li class="liUtil">
						<div class="divUtilRight">
							<div class="divImgIcon">
								<img class="imgIcon" alt=" " src="../css/immagini/logoutIcon.png">
							</div>
							<a href="../index.php?logout=1">Logout</a>
						</div>
					</li>
				</ul>
				<!-- METE POPOLARI -->
				<div class="divLista" id="divListaMete">
					<p class="pLista">Mete popolari</p>
					<ol>
						<?php
							showMetePopolari();
						?>
					</ol>
				</div>
				<!-- EVENTI POPOLARI -->
				<div class="divLista">
					<p class="pLista">Eventi popolari</p>
					<ol>
						<?php
							showEventiPopolari();
						?>
					</ol>
				</div>
			</aside>
		</div>
		<!-- MOSTRA UN EVENTUALE MESSAGGIO DI ERRORE -->
		<?php
			echo '<script>var usernameUtente = "'.$_SESSION['username'].'"</script>';
			if(isset($_GET['errorMessage']))
				echo '<script>showError("'.$_GET['errorMessage'].'")</script>';
		?>
		<!-- CHAT -->
		<?php
			INCLUDE DIR_LAYOUT . "chat.php";
		?>
	</body>
</html>