<?php
	session_start(); 
    require_once __DIR__ . "/config.php";
    require_once DIR_CONNECTIONS . "connectionConfig.php";
    require_once DIR_UTIL . "sessionUtil.php";

    if(!isLogged()){
    	header('location: ../index.php');
    	exit;
	}
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
   	 	<link rel="stylesheet" type="text/css" href="../css/eTravel_dynamic/eTravel_dynamic_orologio.css" media="screen">
   	 	<link rel="stylesheet" type="text/css" href="../css/eTravel_profilo/eTravel_profilo.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../css/font/font.css" media="screen">
		<script type="text/javascript" src="../js/ajaxHandler/ajaxHandler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_chat/chatHandler.js"></script> 
		<script type="text/javascript" src="../js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="../js/eTravel_home/eTravel_home_content_handler.js"></script>  
   	 	<script type="text/javascript" src="../js/eTravel_orologio/eTravel_orologio_handler.js"></script> 
   	 	<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_clocks_handler.js"></script>
   	 	<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_feed_handler.js"></script> 
   		<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_foto_handler.js"></script> 
   		<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_information_handler.js"></script> 
   		<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_interaction_handler.js"></script> 
   		<script type="text/javascript" src="../js/eTravel_profilo/eTravel_profilo_preferences_handler.js"></script>
		<title>Profilo</title>
	</head>
	<body>
		<header>
			<h1 onmouseover="showHint(event, 'Home', 3)" onmouseout="hideHint()"><a href="./home.php">eTravel.com</a></h1>
		</header>
		<div id="divCorpoCentrale">
			<aside id="asideLeft">
				<!-- FOTO PROFILO -->
				<div id="divFotoProfilo">
					<?php 
						//Caricamento di una nuova foto
						if($_SESSION['username']==$_GET['username'])
							echo '<form id="formFotoProfilo" action="./functionalities/photoHandling/uploadPhoto.php" method="post" enctype="multipart/form-data">';
					?>
					<div id="divImgFotoProfilo">
						<?php
							//Caricamento di una nuova foto
							if($_SESSION['username']==$_GET['username'])
								echo '<input type="file" name="inputFoto" onmouseover="showHint(event, \'Cambia foto profilo\', 9)" onmouseout="hideHint()" onclick="showCambiaFotoProfiloButton()">';
						?>
					</div>
					<?php
						//Caricamento di una nuova foto
						if($_SESSION['username']==$_GET['username']){
							echo '<input type="submit" id="submitFotoProfilo" name="submitFotoProfilo" value="Cambia">';
							echo '</form>';
						}
					?>
					<!-- RECUPERO IMMAGINE DEL PROFILO (questa parte compare in ogni caso) -->
					<?php
						include DIR_UTIL . "databaseUtil.php";
						$pathFotoProfilo = getFotoProfilo($_GET['username']);
						if($pathFotoProfilo != null)
							echo '<script>cambiaFotoProfilo("'.$pathFotoProfilo.'")</script>';
					?>
				</div>
				<!-- POPOLARITA' -->
				<div id="divChaserChasing">
					<div>
						<!-- "CHASER" -->
						<?php	
							$idUserPagina = getIdUser($_GET['username']);
							$numChaser = getNumeroChaser($idUserPagina);
							echo '<input type="text" class="fintoTesto" id="inputNumeroChaser" readOnly=true value="'.$numChaser.'">';
						?>						
						<h3>Chasers</h3>
					</div>
					<div>
						<!-- CHASING -->
						<?php
							$numChasing = getNumeroChasing($idUserPagina);
							echo '<input type="text" class="fintoTesto" id="inputNumeroChasing" readOnly=true value="'.$numChasing.'">';
						?>						
						<h3>Chasing</h3>
					</div>
				</div>
				<!-- INFORMAZIONI GENERICHE -->
				<form id="formInfoGenerali" method="post" action="./functionalities/infoHandling/cambiaInformazioni.php">
					<?php
						$nome = getNomeUtente($idUserPagina);
						$nickname = $_GET['username'];
						echo '<input type="text" class="fintoTesto" id="inputNome" name="inputNome" readOnly=true value="'.$nome.'">';
						echo '<input type="text" class="fintoTesto" id="inputNickname" name="inputNickname" readOnly=true value="@'.$nickname.'">';
					?>				
					<div class="divInfoGenerali">
						<h4>Luogo d'origine:</h4>
						<?php
							$luogoOrigine = getLuogoOrigine($idUserPagina);
							echo '<input type="text" class="fintoTesto" name="inputLuogoOrigine" readOnly=true value="'.$luogoOrigine.'">';
						?>
					</div>
					<div class="divInfoGenerali">
						<h4>Luogo preferito:</h4>
						<?php
							$luogoPreferito = getLuogoPreferito($idUserPagina);
							echo '<input type="text" class="fintoTesto" name="inputLuogoPreferito" readOnly=true value="'.$luogoPreferito.'">';
						?>					
					</div>
					<div class="divInfoGenerali">
						<h4>Data di nascita:</h4>
						<?php
							$dataNascita = getDataNascita($idUserPagina);
							echo '<input type="text" class="fintoTesto" name="inputDataNascita" readOnly=true value="'.$dataNascita.'" pattern="[0-9]{1,2}[/]{1}[0-9]{1,2}[/]{1}[0-9]{2,4}" title="DD/MM/AAAA">';
						?>
					</div>
				</form>

				<!-- DISTINZIONE FRA UTENTE LOGGATO E ALTRI -->
				<?php
					//Pulsante "impostazioni"
					if($_SESSION['username']==$_GET['username']){
						echo '<div id="divSettings" style="text-align: center">';
						echo '<img src="../css/immagini/settingsIcon.png" alt="Impostazioni account" onmouseover="showHint(event, \'Cambia informazioni\', 9)" onmouseout="hideHint()" onclick="changeInformation()" style="float: none">';
						echo '</div>';
					}
					//Pulsanti "chase", "preferiti", "messaggio"
					else{
						echo '<div id="divSettings">';
						echo '<img src="../css/immagini/chaseIcon.png" alt="Chase" onmouseover="showHint(event, \'Chase\', 3)" onmouseout="hideHint()" onclick="addChase()">';
						echo '<img src="../css/immagini/preferitiIcon.png" alt="Aggiungi ai preferiti" style="margin-left: 20%;" onmouseover="showHint(event, \'Aggiungi ai preferiti\', 9)" onmouseout="hideHint()" onclick="addFav()">';
						echo '<img src="../css/immagini/messageIcon.jpg" alt="Invia messaggio" style="float: right" onmouseover="showHint(event, \'Invia Messaggio\', 7.5)" onmouseout="hideHint()" onclick="showChat(\''.$pathFotoProfilo.'\', \''.$nome.'\')">';
						echo "</div>";
					}
				?>

				<!-- PREFERENZE DI VIAGGIO -->
				<div id="divInfoViaggiatore">
					<h2>Preferenze di viaggio</h2>
					<input class="fintoTesto" type="text">
					<div id="divListaPreferenze"></div>

					<!-- Differenze nel comportamento quando si visualizza il proprio profilo o quello di un altro utente -->
					<?php
						if($_SESSION['username']==$_GET['username'])
							echo '<div class="divImgPreferenza" onclick="showPreferences(0)" onmouseover="showHint(event, \'Aggiungi preferenza\', 9)" onmouseout="hideHint()">';
						else echo '<div class="divImgPreferenza" onmouseover="showHint(event, \'Nessuna preferenza\', 9)" onmouseout="hideHint()">';
					?>
						<img src="../css/immagini/addIcon.png" alt="Aggiungi preferenza">
					</div>
					<?php
						if($_SESSION['username']==$_GET['username'])
							echo '<div class="divImgPreferenza" onclick="showPreferences(1)" onmouseover="showHint(event, \'Aggiungi preferenza\', 9)" onmouseout="hideHint()">';
						else echo '<div class="divImgPreferenza" onmouseover="showHint(event, \'Nessuna preferenza\', 9)" onmouseout="hideHint()">';
					?>
						<img src="../css/immagini/addIcon.png" alt="Aggiungi preferenza">
					</div>
					<?php
						if($_SESSION['username']==$_GET['username'])
							echo '<div class="divImgPreferenza" onclick="showPreferences(2)" onmouseover="showHint(event, \'Aggiungi preferenza\', 9)" onmouseout="hideHint()">';
						else echo '<div class="divImgPreferenza" onmouseover="showHint(event, \'Nessuna preferenza\', 9)" onmouseout="hideHint()">';
					?>
						<img src="../css/immagini/addIcon.png" alt="Aggiungi preferenza">
					</div>
					<?php
						if($_SESSION['username']==$_GET['username'])
							echo '<div class="divImgPreferenza" onclick="showPreferences(3)" onmouseover="showHint(event, \'Aggiungi preferenza\', 9)" onmouseout="hideHint()">';
						else echo '<div class="divImgPreferenza" onmouseover="showHint(event, \'Nessuna preferenza\', 9)" onmouseout="hideHint()">';
					?>
						<img src="../css/immagini/addIcon.png" alt="Aggiungi preferenza">
					</div>
				</div>

				<!-- CODICE PER IL SETTAGGIO DELLE PREFERENZE -->
				<?php
					if($_SESSION['username']==$_GET['username']){
						echo '<form id="formPreferenze" action="./functionalities/infoHandling/cambiaPreferenze.php" method="post">';
						echo '<input type="hidden" id="inputPreferenze" name="inputPreferenze" value="-1,-1,-1,-1">';
						echo '<input type="submit" id="submitPreferenze" value="Aggiungi">';
						echo '</form>';
					}
				?>

				<!-- OTTENIMENTO DAL DB DELLE INFORMAZIONI SULLE PREFERENZE DELL'UTENTE -->
				<?php 
					$preferenzaCompagnia = getPreferenza($_GET['username'], 0);
					$preferenzaClima = getPreferenza($_GET['username'], 1);
					$preferenzaMezzo = getPreferenza($_GET['username'], 2);
					$preferenzaViaggio = getPreferenza($_GET['username'], 3);
					echo '<script>showUserPreferences('.$preferenzaCompagnia.','.$preferenzaClima.','.$preferenzaMezzo.','.$preferenzaViaggio.')</script>';
				?>
			</aside>
			<!-- FEED E SCELTA DEI CONTENUTI -->
			<div id="mainSectionProfilo">
				<ul>
					<li style="background-color: #c1d7d7" class="liContent" onclick="showFeed(0)" onmouseover="overContent(0)" onmouseout="stopOverContent(0)">Post</li>
					<li id="liViaggio" class="liContent" onclick="showFeed(1)" onmouseover="overContent(1)" onmouseout="stopOverContent(1)">Viaggio</li>
					<li class="liContent" onclick="showFeed(2)" onmouseover="overContent(2)" onmouseout="stopOverContent(2)">Evento</li>
				</ul>	
				<?php
					echo '<iframe id="newsFeedProfilo" src="./showFeedProfilo.php?content=post&username='.$_GET['username'].'"></iframe>';
				?>
			</div>
			<aside id="asideRight">
				<h4>Foto</h4>
				<div id="divListaFoto">

					<!-- PULSANTE DI AGGIUNTA FOTO (compare se stiamo guardando il nostro profilo) -->
					<?php
						$mySession = 0;
						if($_SESSION['username']==$_GET['username']){
							echo '<form id="formFotoUtente" action="./functionalities/photoHandling/uploadPhoto.php" method="post" enctype="multipart/form-data">';
							echo '<div class="divFotoUtente" id="divAggiungiFoto" onmouseover="showHint(event, \'Carica foto\', 5)" onmouseout="hideHint()" onclick="showAggiungiFotoButton()">';
							echo '<input type="file" name="inputFoto">';
							echo '</div>';
							echo '<input type="submit" id="submitFoto" name="submitFoto" value="Aggiungi">';
							echo '</form>';
							$mySession = 1;
						}
						
						//Recupero delle foto dell'utente
						showFotoFromDatabase($_GET['username']);
						//Piccolo aggiustamento grafico nel caso il profilo non sia il nostro
						if($mySession == 0)
							echo '<script>abbassaFoto()</script>';
					?>

				</div>
				<!-- GESTIONE DEGLI OROLOGI -->
				<div id="divOrologi">
					<h4>Città preferite</h4>
					<div id="divContenitoreOrologi"></div>
					<?php
						if($_SESSION['username']==$_GET['username']){
							echo '<div id="divOpzioniOrologi">';
							echo '<form id="formOrologio" action="./functionalities/infoHandling/aggiungiOrologio.php" method="post">';
							echo '<input type="text" placeholder="Inserisci città" name="inputCitta" required>';
							echo '<input type="text" placeholder="Inserisci fusorario" name="inputFusorario" required>';
							echo '<input type="submit" value="Aggiungi" onclick="addOrologioInterface()">';
							echo '</form>';
							echo '</div>';							
							echo '<div id="divAggiungiOrologio" onclick="showOpzioniOrologi()" onmouseover="showHint(event, \'Aggiungi città\', 7)" onmouseout="hideHint()">';
							echo '<img src="../css/immagini/addIcon.png" alt="Aggiungi città">';
							echo '</div>';
						}
						//Funzione in databaseUtil.php
						showOrologiFromDatabase($_GET['username']);
					?>
				</div>
			</aside>
		</div>
		<!-- INCLUSIONE DEL FILE DELLA CHAT -->
		<?php
			echo '<script>var userDestinatario = "'.$_GET['username'].'"</script>';
			INCLUDE DIR_LAYOUT . "chat.php";
		?>
	</body>
	<!-- MOSTRA EVENTUALI MESSAGGI DI ERRORE -->
	<?php
		if(isset($_GET['errorMessage']))
			echo '<script>showChaseError("'.$_GET['errorMessage'].'")</script>';
		if(isset($_GET['impostazioni']))
			echo '<script>changeInformation()</script>';
	?>
</html>