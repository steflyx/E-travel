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
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_ErrorMessage.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/eTravel_publishing/eTravel_publishing_post.css" media="screen">
		<link rel="stylesheet" type="text/css" href="../../../css/font/font.css" media="screen">
		<script type="text/javascript" src="../../../js/eTravel_content/eTravel_content_publishing.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_dynamic/eTravel_dynamic_didascalia.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_home/effettiHome.js"></script> 
		<script type="text/javascript" src="../../../js/eTravel_index/effettiIndex.js"></script> 
		<title>Post</title>
	</head>
	<body onLoad="clearError()">
		<form action="../../functionalities/publishHandling/pubblicaPost.php" method="post">
			<textarea name="inputPostText" placeholder="Scrivi qualcosa!" required></textarea>
			<div id="divImgContent">
				<img src="../../../css/immagini/whereIcon.png" alt="Dove sei?" onmouseover="showHint(event, 'Dove ti trovi?', 6)" onmouseout="hideHint()" onclick="showWhereAndWith(0, 'divImgContent')">
				<img src="../../../css/immagini/accountIcon.png" alt="Con chi sei?" onmouseover="showHint(event, 'Con chi sei?', 6)" onmouseout="hideHint()" onclick="showWhereAndWith(1, 'divImgContent')">
			</div>
			<input name="buttonPubblica" type="submit" value="Pubblica">
		</form>
		<?php
			if(isset($_GET['errorMessage']))
				echo '<div id="divError">'.'<p id="pMessaggioErrore">'.$_GET['errorMessage'].'</p></div>';
		?>
	</body>
</html>