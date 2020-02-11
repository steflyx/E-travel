<!-- CHAT (non viene mostrato a video fino al click dell'apposito pulsante) -->
<div id="divChatBackground">
	<div id="divChat">
		<div id="divChatUp">
			<div id="divImgProfiloChat"></div>
		</div>
		<div id="divMessage"></div>
		<input type="text" id="inputUserMessage" placeholder="Scrivi un messaggio">
		<input type="button" value="Invia" id="inputSendMessage" onclick="sendMessage()">
	</div>
	<p id="closeChatButton" onmouseover="showHint(event, 'Chiudi chat', 5)" onmouseout="hideHint()" onclick="closeChat()">X</p>
</div>
<!-- Salviamo il nome del mittente (ovvero l'utente loggato) in javascript per poter gestire la chat 
	IMPORTANTE: il destinatario deve essere settato dalla pagina che chiama la chat-->
<?php
	echo '<script>var userMittente = "'.$_SESSION['username'].'"</script>';
?>