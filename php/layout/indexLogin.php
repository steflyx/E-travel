<form id="formLogin" action="./php/functionalities/identificationHandling/login.php" method="post" onsubmit="return validateForm()">
	<div id="divInputText">
		<input id="inputUsername" class="inputDaInserire" type="text" placeholder="Username/e-mail" name="username" required autofocus maxlength="45">
		<input id="inputPassword" class="inputDaInserire" type="password" placeholder="Password" name="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="La password deve contenere un numero, una lettera minuscola e una maiuscola">
	</div>
	<input id="inputLogin" class="inputDaPremere" type="submit" value="Login">
	<p id="pMessaggioPromozionale">Non hai un account?</p>
	<input id="inputIscrizione" class="inputDaPremere" type="button" value="Iscriviti ora!" onClick="richiestaRegistrazione()">
</form>