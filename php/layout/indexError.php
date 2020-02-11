<form id="formLogin" action="./php/functionalities/identificationHandling/register.php" method="post">
	<div id="divInputText">
		<input id="inputUsername" class="inputDaInserire" type="text" placeholder="Username" name="username" required autofocus maxlength="45">
		<input type="text" id="inputNome" name="nome" placeholder="Nome" class="inputDaInserire" style="opacity: 1;">
		<input type="text" id="inputEmail" name="email" placeholder="Email" class="inputDaInserire" required="" style="opacity: 1;">
		<input id="inputPassword" class="inputDaInserire" type="password" placeholder="Password" name="password" required="" style="margin-bottom: 0.9em;">
		<input type="password" id="inputConfermaPassword" name="confermaPassword" placeholder="Conferma password" class="inputDaInserire" required="" style="opacity: 1; margin-bottom: 1em;">
	</div>
	<input id="inputIscrizione" class="inputDaPremere" type="submit" value="Iscriviti ora!" onclick="richiestaRegistrazione()">
</form>