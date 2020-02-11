<?php
  	require_once __DIR__ . "/../config.php";
  	require_once DIR_CONNECTIONS . "connectionConfig.php"; 
    require_once DIR_UTIL . "sessionUtil.php";
    require_once __DIR__ . "/userInfoObject.php";
    require_once __DIR__ . "/messageInfoObject.php";

    $MAX_NUMBER_OF_CONTENTS = 100;

    //Permette di aggiungere un 'chase'
    function addChase($chaser, $chased){
      global $eTravelDb;

      $idChaser = getIdUser($chaser);
      $idChased = getIdUser($chased);

      $queryText = "INSERT INTO chasing (`userChaser`, `userChased`) VALUES ('".$idChaser."', '".$idChased."')";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Permette di aggiungere un utente preferito
    function addFav($userPreferring, $userPreferito){
      global $eTravelDb;

      $userPreferring = getIdUser($userPreferring);
      $userPreferito = getIdUser($userPreferito);

      $queryText = "INSERT INTO preferiti (`userPreferring`, `userPreferito`) VALUES ('".$userPreferring."', '".$userPreferito."')";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Aggiunge un orologio
    function addOrologio($idUser, $luogo, $fusorario){
      global $eTravelDb;

      $luogo =  $eTravelDb->sqlInjectionFilter($luogo);
      $luogo = getIdLuogo($luogo);

      $queryText = "INSERT INTO orologio (`autore`, `luogo`, `fusorario`) VALUES ('".$idUser."', '".$luogo."', '".$fusorario."')";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Aggiunge una partecipazione ad un evento
    function addPartecipazione($idUser, $idEvento){
      global $eTravelDb;

      $queryText = "INSERT INTO partecipazione (`user`, `evento`) VALUES ('".$idUser."', '".$idEvento."')";
      
      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Prende una data del tipo AAAA-MM-DD e la trasforma in una del tipo DD/MM/AAAA
    function changeDataFormat($data){
      $dataList = explode("-", $data);

      return $dataList[2]."/".$dataList[1]."/".$dataList[0];
    }

    //Permette di cambiare le info generali di un utente
    function changeInfoGenerali($nome, $luogoOrigine, $luogoPreferito, $dataNascita, $usernameUtente){
      global $eTravelDb;

      $idUser = getIdUser($usernameUtente);

      $queryText = "UPDATE user SET ";

      if($nome != null){
         $nome =  $eTravelDb->sqlInjectionFilter($nome);
         $queryText = $queryText."`name`='".$nome."'";
      } 
      if($luogoOrigine != null){
        $idLuogoOrigine = getIdLuogo($luogoOrigine);
        if($idLuogoOrigine == "Errore di connessione")
          return $idLuogoOrigine;
        $queryText = $queryText.", `luogoOrigine`='".$idLuogoOrigine."'";
      }
      if($luogoPreferito != null){
        $idLuogoPreferito = getIdLuogo($luogoPreferito);
        if($idLuogoPreferito == "Errore di connessione")
          return $idLuogoPreferito;
        $queryText = $queryText.", `luogoPreferito`='".$idLuogoPreferito."'";
      }
      if($dataNascita != null){
        $dataNascita = getCorrectDate($dataNascita);
        if($dataNascita == "Inserire una data valida")
          return $dataNascita;
        $queryText = $queryText.", `dataNascita`='".$dataNascita."'";
      }

      $queryText = $queryText." WHERE `idUser`='".$idUser."'";

      $result = $eTravelDb->performQuery($queryText);    

      if(!$result)
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Restituisce un messaggio di errore se esiste già un 'chase' fra questi due utenti
    function checkIfAlreadyChased($chaser, $chased){
      global $eTravelDb;

      $idChaser = getIdUser($chaser);
      $idChased = getIdUser($chased);

      $queryText = "SELECT * FROM chasing WHERE userChaser='".$idChaser."' AND userChased='".$idChased."'";

      $result = $eTravelDb->performQuery($queryText);    

      if(!$result)
        return "Errore di connessione";

      if(mysqli_num_rows($result) != 0)
        $errorMessage = "Hai già aggiunto questo utente";
      else $errorMessage = null;

      $eTravelDb->closeConnection();

      return $errorMessage;
    }

    //Restituisce un messaggio di errore se l'utente partecipa già a questo evento
    function checkIfAlreadyPartecipate($idUser, $idEvento){
      global $eTravelDb;

      $queryText = "SELECT * FROM partecipazione WHERE user='".$idUser."' AND evento='".$idEvento."'";

      $result = $eTravelDb->performQuery($queryText);    

      if(!$result)
        return "Errore di connessione";

      if(mysqli_num_rows($result) != 0)
        $errorMessage = "Partecipi già a questo evento";
      else $errorMessage = null;

      $eTravelDb->closeConnection();

      return $errorMessage;
    }

    //Restituisce un messaggio di errore se l'utentePreferring ha già l'altro utente fra i preferiti
    function checkIfAlreadyPreferred($userPreferring, $userPreferito){
      global $eTravelDb;

      $userPreferring = getIdUser($userPreferring);
      $userPreferito = getIdUser($userPreferito);

      $queryText = "SELECT * FROM preferiti WHERE userPreferring='".$userPreferring."' AND userPreferito='".$userPreferito."'";

      $result = $eTravelDb->performQuery($queryText);    

      if(!$result)
        return "Errore di connessione";

      if(mysqli_num_rows($result) != 0)
        $errorMessage = "Hai già aggiunto questo utente";
      else $errorMessage = null;

      $eTravelDb->closeConnection();

      return $errorMessage;
    }

    //Restituisce un array codificato con metodo JSON contenente le informazioni sui chaser di un user
    function getChaserUser($idUser){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT * FROM chasing C INNER JOIN user U ON (C.userChaser = U.idUser) WHERE C.userChased='".$idUser."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        echo "Errore di connessione";

      $eTravelDb->closeConnection();

      showUserInfo($result);
    }

    //Prende una data del tip DD/MM/AAAA e ne restituisce una del tipo AAAA-MM-DD (quella richiesta da MySql)
    //Restituisce un messaggio di errore se il formato iniziale presentava errori
    function getCorrectDate($data){
		  $dataList = explode("/", $data);

      if(!checkdate($dataList[1], $dataList[0], $dataList[2]))
       	return "Inserire una data valida";

      return $dataList[2]."-".$dataList[1]."-".$dataList[0];
    }

    //Restituisce la data di nascita dell'utente associato a 'idUser'
    function getDataNascita($idUser){
      global $eTravelDb;

      $queryText = "SELECT dataNascita FROM user WHERE idUser='".$idUser."'";

      $result = $eTravelDb->performQuery($queryText); 
      if(!$result)
        return "Errore di connessione";

      $userRow = $result->fetch_assoc();

      $eTravelDb->closeConnection();

      if(isset($userRow['dataNascita']))
        return changeDataFormat($userRow['dataNascita']);
      else return "Non specificata";
    }

    //Recupera gli utenti preferiti di un user e li invia tramite JSON
    function getFavouriteUser($idUser){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT * FROM preferiti P INNER JOIN user U ON (P.userPreferito = U.idUser) WHERE P.userPreferring='".$idUser."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result)
        echo "Errore di connessione";

      $eTravelDb->closeConnection();

      showUserInfo($result);
    }

    //Restituisce l'indirizzo della fotoProfilo di un utente
    function getFotoProfilo($usernameUtente){
      global $eTravelDb;

      $queryText = "SELECT fotoProfilo FROM user WHERE username='".$usernameUtente."'";

      $result = $eTravelDb->performQuery($queryText); 
      if(!$result) //Se la query non va a buon fine semplicemente la foto profilo non viene mostrata
        return null;

      $userRow = $result->fetch_assoc();

      $eTravelDb->closeConnection();

      return $userRow['fotoProfilo'];
    }

    //Restituisce l'id dell'ultimo viaggio pubblicato dall'utente
    function getIdLastViaggio($idUser){
      global $eTravelDb;

      $queryText = "SELECT V1.idviaggio
                    FROM viaggio V1 LEFT OUTER JOIN viaggio V2 ON (V1.timestamp < V2.timestamp AND V1.autore=V2.autore)
                    WHERE V1.autore = '".$idUser."' AND V2.timestamp IS NULL";

      $result = $eTravelDb->performQuery($queryText);      
      if(!$result)
        return "Errore di connessione";
      $userRow = $result->fetch_assoc();

      $eTravelDb->closeConnection();

      return $userRow['idviaggio'];
    }

    //Restituisce l'id relativo al nome del luogo passato; se non esiste un'occorrenza di tale luogo, ne crea una nuova
    function getIdLuogo($luogo){
    	global $eTravelDb;

    	$luogo = $eTravelDb->sqlInjectionFilter($luogo);

    	$queryText = "SELECT idLuogo FROM luogo WHERE nome='".$luogo."'";
    	$result = $eTravelDb->performQuery($queryText);
    	if(!$result)
    		return "Errore di connessione";
		  $userRow = $result->fetch_assoc();

  		if(mysqli_num_rows($result) == 0){
  			$queryText = "INSERT INTO luogo (`nome`) VALUES ('".$luogo."')";
  			if(!$eTravelDb->performQuery($queryText))
  				return "Errore di connessione";

  			return getIdLuogo($luogo);	
  		}


  		$eTravelDb->closeConnection();

  		return $userRow['idLuogo'];
    }

    //Restituisce l'id dell'utente indicato (username); restituisce -1 se non esiste
    function getIdUser($user){
   		global $eTravelDb;

   		$user = $eTravelDb->sqlInjectionFilter($user);

   		$queryText = "SELECT idUser FROM user WHERE username='".$user."'";

    	$result = $eTravelDb->performQuery($queryText);
    	if(!$result)
    		return "Errore di connessione";

		$userRow = $result->fetch_assoc();

		if(mysqli_num_rows($result) == 0)
			return "Hai taggato un utente non esistente";	

		$eTravelDb->closeConnection();

		return $userRow['idUser'];
  }

  //Invia, codificato tramite JSON, un array contenenti i messaggi non letti da un utente
  function getMessageNotRead($idUser){
    global $eTravelDb;
    global $MAX_NUMBER_OF_CONTENTS;

    $queryText = "SELECT U.name AS nome, U.fotoProfilo AS fotoProfilo, M.testo AS testo, M.timestamp AS timestamp, U.username AS username 
                  FROM messaggio M INNER JOIN user U ON (M.mittente = U.idUser) WHERE M.visualizzato='0' AND M.destinatario='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result){
      echo 'Errore di connessione';
      return;
    }

    $arrayMessage = array();
    $count = 0;

    while($userRow = $result->fetch_assoc()){

      $arrayMessage[$count] = new messageInfo();
      $arrayMessage[$count]->mittente = $userRow['nome'];
      $arrayMessage[$count]->usernameUtente = $userRow['username'];
      $arrayMessage[$count]->pathFotoProfilo = $userRow['fotoProfilo'];
      $arrayMessage[$count]->testo = $userRow['testo'];
      $arrayMessage[$count]->timestamp = $userRow['timestamp'];

      $count++;
      if($count >= $MAX_NUMBER_OF_CONTENTS)
        break;
    }
    $arrayEncoded = json_encode($arrayMessage);

    echo $arrayEncoded;
      
  }

  //Restituisce gli utenti più popolari
  function getPopularUser($idUser){
    global $eTravelDb;    
    global $MAX_NUMBER_OF_CONTENTS;

    $queryText = "SELECT U1.name AS name, U1.fotoProfilo AS fotoProfilo, U1.luogoOrigine AS luogoOrigine, 
                  U1.dataNascita AS dataNascita, U1.username AS username   
                  FROM user U1 INNER JOIN chasing C ON (U1.idUser = C.userChased) 
                  WHERE U1.idUser <> '" . $idUser . "'
                  GROUP BY C.userChased 
                  ORDER BY count(*) DESC";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      echo "Errore di connessione";

    $eTravelDb->closeConnection();

    showUserInfo($result);
  }

  //Restituisce l'ultimo messaggio non visualizzato che i due utenti si sono scambiati
  //In più, modifica l'attributo 'visualizzato' di quel messaggio; se non esiste, restituisce una stringa vuota
  function getLatestMessageNotVisualizzato($idDestinatario, $idMittente){
    global $eTravelDb;

    $queryText = "SELECT testo, idMessaggio FROM messaggio 
                  WHERE destinatario='".$idDestinatario."' AND mittente='".$idMittente."' AND visualizzato='0' 
                  ORDER BY timestamp ASC"; //Così abbiamo in cima il messaggio più vecchio 

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    if(mysqli_num_rows($result) == 0)
      return ""; 

    $userRow = $result->fetch_assoc();

    $queryText = "UPDATE messaggio SET visualizzato='1' WHERE idMessaggio='".$userRow['idMessaggio']."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    return $userRow['testo'];
  }

  //Restituisce il luogo d'origine dell'utente associato a 'idUser'
  function getLuogoOrigine($idUser){
    global $eTravelDb;

    $queryText = "SELECT luogoOrigine FROM user WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();
    if(isset($userRow['luogoOrigine']))
      return getNomeLuogo($userRow['luogoOrigine']);
    else return "Non specificato";
  }

  //Restituisce il luogo preferito dell'utente
  function getLuogoPreferito($idUser){
    global $eTravelDb;

    $queryText = "SELECT luogoPreferito FROM user WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    if(isset($userRow['luogoPreferito']))
      return getNomeLuogo($userRow['luogoPreferito']);
    else return "Non specificato";
  }

  //Prende in ingresso 3 timestamp e restituisce l'indice del più recente
  function getMostRecentContent($timestampUno, $timestampDue, $timestampTre){
    if(!isset($timestampUno)){
      if(!isset($timestampDue)){
        if(!isset($timestampTre))
          return -1;
      } else{
        if(!isset($timestampTre))
          return 1;
        else return ($timestampDue > $timestampTre) ? 1 : 2;
      }
    }
    else{
      if(!isset($timestampDue)){
        if(!isset($timestampTre))
          return 0;
        else return ($timestampUno > $timestampTre) ? 0 : 2;
      }else{
        if(!isset($timestampTre))
          return ($timestampUno > $timestampDue) ? 0 : 1;
        else {
          if($timestampUno > $timestampDue)
            return ($timestampUno > $timestampTre) ? 0 : 2;
          else return ($timestampDue > $timestampTre) ? 1 : 2;
        }
      }
    }
  }

  //Restituisce il nome del luogo associato a questo id
  function getNomeLuogo($idLuogo){
    global $eTravelDb;

    $queryText = "SELECT nome FROM luogo WHERE idLuogo='".$idLuogo."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['nome'];
  }

  //Restituisce il nome dell'utente associato a 'idUser'
  function getNomeUtente($idUser){
    global $eTravelDb;

    $queryText = "SELECT name FROM user WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['name'];
  }

  //Restituisce il numero di 'chaser' di un utente
  function getNumeroChaser($idUser){
    global $eTravelDb;

    $queryText = "SELECT count(*) AS numChaser FROM chasing WHERE userChased='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['numChaser'];
  }

  //Restituisce il numero di 'chasing' di un utente
  function getNumeroChasing($idUser){
    global $eTravelDb;

    $queryText = "SELECT count(*) AS numChasing FROM chasing WHERE userChaser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['numChasing'];
  }

  //Restituisce il numero di foto di un utente
  function getNumeroFoto($idUser){
    global $eTravelDb;

    $queryText = "SELECT count(*) AS numFoto FROM foto WHERE user = '".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['numFoto'];
  }

  //Restituisce il numero di orologi di un utente
  function getNumeroOrologi($idUser){
    global $eTravelDb;

    $queryText = "SELECT count(*) AS numOrologi FROM orologio WHERE autore = '".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['numOrologi'];
  }

  //Restituisce il numero di partecipanti ad un evento
  function getNumPartecipanti($idEvento){
    global $eTravelDb;

    $queryText = "SELECT count(*) AS numPartecipanti FROM partecipazione WHERE evento = '".$idEvento."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
     return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['numPartecipanti'];
  }

  //Restituisce le preferenze di viaggio di un utente
  function getPreferenza($usernameUtente, $numPreference){
    global $eTravelDb;

    $idUser = getIdUser($usernameUtente);

    $queryText = "SELECT * FROM user WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    if($numPreference == 0)
      return $userRow['preferenzaCompagnia'];
    if($numPreference == 1)
      return $userRow['preferenzaClima'];
    if($numPreference == 2)
      return $userRow['preferenzaMezzo'];
    if($numPreference == 3)
      return $userRow['preferenzaViaggio'];
  }

  //Funzione che ricerca gli utenti a partire da un pattern
  function getUserByPattern($pattern){
    global $eTravelDb;

    $pattern = $eTravelDb->sqlInjectionFilter($pattern);

    $queryText = "SELECT * FROM user WHERE name LIKE '%" . $pattern ."%'"; 
  
    $result = $eTravelDb->performQuery($queryText);
    $eTravelDb->closeConnection();

    $eTravelDb->closeConnection();

    showUserInfo($result);
  }

  //Restituisce l'username di un utente
  function getUsernameUtente($idUser){
    global $eTravelDb;

    $queryText = "SELECT username FROM user WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      return "Errore di connessione";

    $userRow = $result->fetch_assoc();

    $eTravelDb->closeConnection();

    return $userRow['username'];
  }

  //Memorizza l'URL di una foto caricata da un'utente
  function memorizzaFoto($idUser, $URL){
    global $eTravelDb;

    $URL = $eTravelDb->sqlInjectionFilter($URL);

    $queryText = "INSERT INTO foto (`user`, `URL`) VALUES ('".$idUser."', '".$URL."')";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      return "Errore di connessione";

    $eTravelDb->closeConnection();

    return null;
  }

  //Memorizza l'URL della foto profilo di un utente
  function memorizzaFotoProfilo($idUser, $URL){
    global $eTravelDb;

    $URL = $eTravelDb->sqlInjectionFilter($URL);

    $queryText = "UPDATE user SET fotoProfilo = '".$URL."' WHERE idUser = '".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      return "Errore di connessione";

    $eTravelDb->closeConnection();

    return null;
  }

  //Modifica le preferenze di un utente
  function modifyPreferences($idUser, $valorePreferenza, $numPreferenza){
    global $eTravelDb;

    $queryText = "UPDATE user SET preferenza";

    if($numPreferenza == 0)
      $queryText .= "Compagnia";
    if($numPreferenza == 1)
      $queryText .= "Clima";
    if($numPreferenza == 2)
      $queryText .= "Mezzo";
    if($numPreferenza == 3)
      $queryText .= "Viaggio";

    $queryText .= "='".$valorePreferenza."' WHERE idUser='".$idUser."'";

    $result = $eTravelDb->performQuery($queryText);
    if(!$result)
      return "Errore di connessione";

    $eTravelDb->closeConnection();

    return null;
  }

  //Pubblica un evento; se c'è un errore restituisce il relativo messaggio
  function publishEvent($titolo, $descrizione, $luogo, $dataInizio, $dataFine, $idUser, $URL){
 		global $eTravelDb;

 		$titolo = $eTravelDb->sqlInjectionFilter($titolo);
    $descrizione = $eTravelDb->sqlInjectionFilter($descrizione);

 		$queryTextPartOne = "INSERT INTO evento (`autore`, `titolo`, `descrizione`";
 		$queryTextPartTwo = " VALUES ('".$idUser."', '".$titolo."', '".$descrizione."'";

 		//Costruiamo la query in base alle informazioni che l'utente ha immesso
 		if($luogo != null){
		  	$idLuogo = getIdLuogo($luogo);   			
		  	if($idLuogo == "Errore di connessione")
		  		return $idLuogo;

 			$queryTextPartOne = $queryTextPartOne.", `luogo`";
 			$queryTextPartTwo = $queryTextPartTwo.", '".$idLuogo."'";
 		}
 		if($dataInizio != null){
 			$correctData = getCorrectDate($dataInizio);
 			if($correctData == "Inserire una data valida")
 				return $correctData;

 			$queryTextPartOne = $queryTextPartOne.", `inizio`";
	  		$queryTextPartTwo = $queryTextPartTwo.", '".$correctData."'";
		}
   	if($dataFine != null){
 			$correctData = getCorrectDate($dataFine);
 			if($correctData == "Inserire una data valida")
 				return $correctData;

 		   	$queryTextPartOne = $queryTextPartOne.", `fine`";
	  		$queryTextPartTwo = $queryTextPartTwo.", '".$correctData."'";
    }
    if($URL != null){
      $URL = $eTravelDb->sqlInjectionFilter($URL);
      $queryTextPartOne = $queryTextPartOne.", `fotoEvento`";
      $queryTextPartTwo = $queryTextPartTwo.", '".$URL."'";
    }
		$queryTextPartOne = $queryTextPartOne.")";
		$queryTextPartTwo = $queryTextPartTwo.")";	

		$queryText = $queryTextPartOne.$queryTextPartTwo;	

		if(!$eTravelDb->performQuery($queryText))
			return "Errore di connessione";

		$eTravelDb->closeConnection();

		return null;
  	}

  //Pubblica un post; se c'è un errore, restituisce il relativo messaggio
  function publishPost($text, $luogo, $tag, $idUser){
   	  global $eTravelDb;

   		$text = $eTravelDb->sqlInjectionFilter($text);

   		$queryTextPartOne = "INSERT INTO post (`autore`, `testo`";
   		$queryTextPartTwo = " VALUES ('".$idUser."', '".$text."'";

   		//Costruiamo la query in base alle informazioni che l'utente ha immesso
   		if($luogo != null){
  			$idLuogo = getIdLuogo($luogo); 	
		  	if($idLuogo == "Errore di connessione")
		  		return $idLuogo;

   			$queryTextPartOne = $queryTextPartOne.", `luogo`";
   			$queryTextPartTwo = $queryTextPartTwo.", '".$idLuogo."'";
   		}
   		if($tag != null){
   			$idTag = getIdUser($tag);
   			if($idTag == "Errore di connessione" || $idTag == "Hai taggato un utente non esistente")
   				return $idTag;

   			$queryTextPartOne = $queryTextPartOne.", `tag`";
	   		$queryTextPartTwo = $queryTextPartTwo.", '".$idTag."'";
		  }
		 	$queryTextPartOne = $queryTextPartOne.")";
	   	$queryTextPartTwo = $queryTextPartTwo.")";	

    	$queryText = $queryTextPartOne.$queryTextPartTwo;

  		if(!$eTravelDb->performQuery($queryText))
  			return "Errore di connessione";

  		$eTravelDb->closeConnection();

  		return null;
    }

    //Funzione che pubblica una singola tappa
    function publishTappa($idViaggio, $luogoTappa, $commentoTappa, $mezzo, $coordX, $coordY, $dataTappa){
      global $eTravelDb;

      $queryTextPartOne = "INSERT INTO tappa (`viaggio`";
      $queryTextPartTwo = " VALUES ('".$idViaggio."'";

      if($luogoTappa != null){
        $idLuogo = getIdLuogo($luogoTappa);  
        if($idLuogo == "Errore di connessione")
          return $idLuogo;

        $queryTextPartOne = $queryTextPartOne.", `luogo`";
        $queryTextPartTwo = $queryTextPartTwo.", '".$idLuogo."'";
      }
      if($commentoTappa != null){
        $commentoTappa = $eTravelDb->sqlInjectionFilter($commentoTappa);
        $queryTextPartOne = $queryTextPartOne.", `commento`";
        $queryTextPartTwo = $queryTextPartTwo.", '".$commentoTappa."'";
      }
      if($mezzo != "-"){
        $queryTextPartOne = $queryTextPartOne.", `mezzo`";
        $queryTextPartTwo = $queryTextPartTwo.", '".$mezzo."'";
      }
      if($dataTappa != null){
        $correctData = getCorrectDate($dataTappa);
        if($correctData == "Inserire una data valida")
          return $correctData;
        $queryTextPartOne = $queryTextPartOne.", `data`";
        $queryTextPartTwo = $queryTextPartTwo.", '".$correctData."'";
      }
      $queryTextPartOne = $queryTextPartOne.", `positionX`, `positionY`)";
      $queryTextPartTwo = $queryTextPartTwo.", '".$coordX."', '".$coordY."')";

      $queryText = $queryTextPartOne.$queryTextPartTwo;

      if(!$eTravelDb->performQuery($queryText))
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Funzione che pubblica un viaggio (nei suoi aspetti generali)
    function publishViaggio($idUser, $userTagged, $wantsCompany){
      global $eTravelDb;

      $queryTextPartOne = "INSERT INTO viaggio (`autore`, `compagnia`";
      $queryTextPartTwo = " VALUES ('".$idUser."', '".$wantsCompany."'";

      //Finiamo di costruire la query
      if($userTagged != null){
        $idUserTagged = getIdUser($userTagged);
        if($idUserTagged == "Errore di connessione" || $idUserTagged == "Hai taggato un utente non esistente")
          return $idUserTagged;

        $queryTextPartOne = $queryTextPartOne.", `tag`";
        $queryTextPartTwo = $queryTextPartTwo.", '".$idUserTagged."'";
      }
      $queryTextPartOne = $queryTextPartOne.")";
      $queryTextPartTwo = $queryTextPartTwo.")";

      $queryText = $queryTextPartOne.$queryTextPartTwo;

      if(!$eTravelDb->performQuery($queryText))
        return "Errore di connessione";

      $eTravelDb->closeConnection();

      return null;
    }

    //Funzione che invia un messaggio, restituisce il messaggio stesso o un messaggio di errore
    function sendMessage($text, $idDestinatario, $idMittente){
      global $eTravelDb;

      $queryText = "INSERT INTO messaggio (`destinatario`, `mittente`, `testo`, `visualizzato`) 
                           VALUES ('".$idDestinatario."', '".$idMittente."', '".$text."', '0')";

      if(!$eTravelDb->performQuery($queryText))
        return "Errore di connessione, il tuo messaggio non è stato inviato";

      $eTravelDb->closeConnection();

      return $text;
    }

    //Funzione che mostra a video gli eventi più popolari dell'ultimo mese (al più 5)
    function showEventiPopolari(){
      global $eTravelDb;

      $queryText = "SELECT E.titolo AS nomeEvento FROM partecipazione P INNER JOIN evento E ON (P.evento = E.idEvento)
                    WHERE (month(inizio) = month(current_date()) and year(inizio) = year(current_date()))
                    GROUP BY P.evento ORDER BY count(*) desc";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      for($i=0; $i<5; $i++){
        if(!$userRow = $result->fetch_assoc())
          return;
        echo '<li>'.$userRow['nomeEvento'].'</li>';
      }
    }

    //Funzione che mostra a video un evento
    function showEvento($idEvento){
      global $eTravelDb;

      $queryText = "SELECT * FROM evento WHERE idEvento='".$idEvento."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      $userRow = $result->fetch_assoc();

      $usernameUtente = getUsernameUtente($userRow['autore']);
      $nomeUtente = getNomeUtente($userRow['autore']);
      $usernameUtente = getUsernameUtente($userRow['autore']);

      $pathImgProfilo = getFotoProfilo($usernameUtente);
      if($pathImgProfilo == null || $pathImgProfilo == "default")
        $pathImgProfilo = "../css/immagini/fotoProfiloIcon.jpg"; //Foto di default
      else $pathImgProfilo = "../upload/".$pathImgProfilo;

      $pathFotoEvento = $userRow['fotoEvento'];
      if($pathFotoEvento == null || $pathFotoEvento == "default")
        $pathFotoEvento = "../css/immagini/fotoProfiloIcon.jpg"; //Foto di default
      else $pathFotoEvento = "../upload/".$pathFotoEvento;

      echo '<div class="divEvento">';
      echo '<h5 class="titoloEvento">'.$userRow['titolo'].'</h5>';
      echo '<div class="divImmagineEvento">';
      echo '<img class="imgProfiloNotifiche" src="'.$pathFotoEvento.'" alt="Foto evento" onmouseover="showHint(event, \'Foto evento\', 6)" onmouseout="hideHint()">';
      echo '</div>';
      echo '<h5 class="sottoTitoloEvento">Creato da:</h5>';
      echo '<p><a href="./profilo.php?username='.$usernameUtente.'">'.$nomeUtente.'</a></p>';
      echo '<h5 class="sottoTitoloEvento">Descrizione:</h5>';
      echo '<p>'.$userRow['descrizione'].'</p>';
      echo '<h5 class="sottoTitoloEvento">Date:</h5>';
      echo '<p>';
      if($userRow['inizio'] != null){
        echo 'Dal '.changeDataFormat($userRow['inizio']);
        if($userRow['fine'] != null) //Non avrebbe senso mostrare la data finale se non è stata impostata una data iniziale
          echo ' al '.changeDataFormat($userRow['fine']);
      } else echo 'Non specificate';
      echo '</p>';
      echo '<h5 class="sottoTitoloEvento">Luogo:</h5>';
      if($userRow['luogo'] != null)
        echo '<p>'.getNomeLuogo($userRow['luogo']).'</p>';
      else echo '<p>Non specificato</p>';
      $numPartecipanti = getNumPartecipanti($userRow['idevento']);
      if($numPartecipanti != 0 && $numPartecipanti == 1)
        echo '<h5 class="sottoTitoloEvento" style="text-align: center; width: 50%; margin: auto">Partecipa già '.$numPartecipanti.' persona!</h5>';
      else echo '<h5 class="sottoTitoloEvento" style="text-align: center; width: 50%; margin: auto">Partecipano già '.$numPartecipanti.' persone!</h5>';
      echo '<form action="./functionalities/addInteraction/addPartecipazione.php" method="post">';
      echo '<input type="submit" name="submitPartecipazione" value="Partecipa">';
      echo '<input type="hidden" name="inputIdEvento" value="'.$userRow['idevento'].'">';
      echo '</form>';
      echo '</div>';
    }

    //Mostra a video gli eventi più recenti creati da un dato profilo (al più 100)
    function showEventsFromProfilo($idUser){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT idevento FROM evento WHERE autore='".$idUser."' ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      $count = 0;

      while($userRow = $result->fetch_assoc()){
        if($count < $MAX_NUMBER_OF_CONTENTS)
          showEvento($userRow['idevento']);
        else return;
        $count++;
      }
    }

    //Funzione che mostra a video le foto di un utente (le prime 10)
    function showFotoFromDatabase($usernameUtente){
      global $eTravelDb;
      
      $idUser = getIdUser($usernameUtente);

      $numFoto = getNumeroFoto($idUser);
      if($numFoto == "Errore di connessione")
        header('location: ./profilo.php?errorMessage=Errore di connessione&username='.$usernameUtente);

      $numFoto = ($numFoto < 10) ? $numFoto : 10;


      $queryText = "SELECT URL FROM foto WHERE user='".$idUser."' ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result) //Poiché questa funzione è chiamata direttamente da 'profilo.php' non ci sono passaggi intermedi
        header('location: ./profilo.php?errorMessage=Errore di connessione&username='.$usernameUtente);

      for($i=0; $i<$numFoto; $i++){
        $userRow = $result->fetch_assoc();
        echo '<script>addFoto("'.$userRow['URL'].'");</script>';
      }
    }

    //Mostra a video le mete più popolari dell'ultimo mese (al più 5)
    function showMetePopolari(){
      global $eTravelDb;

      $queryText = "SELECT luogo FROM tappa WHERE (month(data) = month(current_date()) and year(data) = year(current_date()))
                    GROUP BY luogo ORDER BY count(*) desc";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      for($i=0; $i<5; $i++){
        if(!$userRow = $result->fetch_assoc())
          return;
        $luogo = getNomeLuogo($userRow['luogo']);
        echo '<li>'.$luogo.'</li>';
      }
    }

    //Mostra a video tutti gli orologi associati ad un dato utente
    function showOrologiFromDatabase($usernameUtente){
      global $eTravelDb;

      $idUser = getIdUser($usernameUtente);

      $numOrologi = getNumeroOrologi($idUser);
      if($numOrologi == "Errore di connessione")
        header('location: ./profilo.php?errorMessage=Errore di connessione&username='.$usernameUtente);

      $queryText = "SELECT * FROM orologio WHERE autore='".$idUser."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result) //Poiché questa funzione è chiamata direttamente da 'profilo.php' non ci sono passaggi intermedi
        header('location: ./profilo.php?errorMessage=Errore di connessione&username='.$usernameUtente);

      for($i=0; $i<$numOrologi; $i++){
        $userRow = $result->fetch_assoc();
        $luogo = getNomeLuogo($userRow['luogo']);
        echo '<script>addOrologio("'.$luogo.'", '.$userRow['fusorario'].');</script>';
      }
    }

    //Funzione che mostra a video un post
    function showPost($idPost){
      global $eTravelDb;

      $queryText = "SELECT * FROM post WHERE idPost='".$idPost."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      $userRow = $result->fetch_assoc();

      $usernameUtente = getUsernameUtente($userRow['autore']);
      $nomeUtente = getNomeUtente($userRow['autore']);

      $pathImgProfilo = getFotoProfilo($usernameUtente);
      if($pathImgProfilo == null || $pathImgProfilo == "default")
        $pathImgProfilo = "../css/immagini/fotoProfiloIcon.jpg"; //Foto di default
      else $pathImgProfilo = "../upload/".$pathImgProfilo;


      echo '<div class="divPost">';
      echo '<div class="divPostUp">';
      echo '<div class="divImmagineProfiloContent">';
      echo '<img class="imgProfiloNotifiche" src="'.$pathImgProfilo.'" alt="Foto profilo" onmouseover="showHint(event, \'Foto profilo\', 6)" onmouseout="hideHint()">';
      echo '</div>';
      echo '<h5><a href="./profilo.php?username='.$usernameUtente.'">'.$nomeUtente.'</a></h5>';
      if($userRow['luogo'] != null || $userRow['tag'] != null){
        echo '<h6>';
        if($userRow['luogo'] != null)
          echo ' - presso: '.getNomeLuogo($userRow['luogo']).';';
        if($userRow['tag'] != null)
          echo ' - con: '.getNomeUtente($userRow['tag']).';';
        echo '</h6>';
      }
      echo '</div>';
      echo '<div class="testoPost">';
      echo $userRow['testo'];
      echo '</div>';
      echo '</div>';

    }

    //Mostra a video i post più recenti di un dato profilo (al più 100)
    function showPostFromProfilo($idUser){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT idPost FROM post WHERE autore='".$idUser."' ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      $count = 0;

      while($userRow = $result->fetch_assoc()){
        if($count < $MAX_NUMBER_OF_CONTENTS)
          showPost($userRow['idPost']);
        else return;
        $count++;
      }
    }

    //Mostra a video i viaggi di utenti in cerca di compagnia (al più 10)
    function showProposte(){
      global $eTravelDb;

      $queryText = "SELECT idViaggio FROM viaggio WHERE compagnia = '1' ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      $count = 0;
      while($userRow = $result->fetch_assoc()){
        showViaggioRidotto($userRow['idViaggio']);
        $count++;
        if($count == 10)
          return;
      }
    }

    //Carica e mostra a video i contenuti più recenti legati ad un utente
    //Il valore $main vale 0 se dobbiamo mostrare i contenuti più recenti;
    //vale 1 se dobbiamo mostrare i contenuti postati dagli utenti preferiti dell'user
    function showRecentFeed($idUser, $main){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      //Recuperiamo prima i post
      if($main == 0)
        $queryText = "SELECT idPost, timestamp FROM post WHERE autore='".$idUser."' OR autore IN (
                      SELECT userChased FROM chasing WHERE userChaser='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;
      else
        $queryText = "SELECT idPost, timestamp FROM post WHERE autore='".$idUser."' OR autore IN (
                      SELECT userPreferito FROM preferiti WHERE userPreferring='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;

      $resultPost = $eTravelDb->performQuery($queryText);
      if(!$resultPost){
        echo 'Errore di connessione';
        return;
      }

      //Recuperiamo poi gli eventi
      if($main == 0)
        $queryText = "SELECT idEvento, timestamp FROM evento WHERE autore='".$idUser."' OR autore IN (
                      SELECT userChased FROM chasing WHERE userChaser='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;
      else
        $queryText = "SELECT idEvento, timestamp FROM evento WHERE autore='".$idUser."' OR autore IN (
                      SELECT userPreferito FROM preferiti WHERE userPreferring='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;

      $resultEventi = $eTravelDb->performQuery($queryText);
      if(!$resultEventi){
        echo 'Errore di connessione';
        return;
      }

      //Infine recuperiamo i viaggi
      if($main == 0)
        $queryText = "SELECT idViaggio, timestamp FROM viaggio WHERE autore='".$idUser."' OR autore IN (
                      SELECT userChased FROM chasing WHERE userChaser='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;
      else
        $queryText = "SELECT idViaggio, timestamp FROM viaggio WHERE autore='".$idUser."' OR autore IN (
                      SELECT userPreferito FROM preferiti WHERE userPreferring='".$idUser."')
                      ORDER BY timestamp DESC LIMIT ".$MAX_NUMBER_OF_CONTENTS;

      $resultViaggi = $eTravelDb->performQuery($queryText);
      if(!$resultViaggi){
        echo 'Errore di connessione';
        return;
      }

      //Il successivo contenuto da caricare viene scelto in base a qual è il più recente
      $userRowPost = $resultPost->fetch_assoc();
      $userRowEventi = $resultEventi->fetch_assoc();
      $userRowViaggi = $resultViaggi->fetch_assoc();

      for($i=0; $i<$MAX_NUMBER_OF_CONTENTS; $i++){ 
        $contentType = getMostRecentContent($userRowPost['timestamp'], $userRowEventi['timestamp'], $userRowViaggi['timestamp']);
        if($contentType == 0){
          showPost($userRowPost['idPost']);
          $userRowPost = $resultPost->fetch_assoc();
        }
        if($contentType == 1){
          showEvento($userRowEventi['idEvento']);
          $userRowEventi = $resultEventi->fetch_assoc();
        }
        if($contentType == 2){
          showViaggio($userRowViaggi['idViaggio']);
          $userRowViaggi = $resultViaggi->fetch_assoc();
        }
        if($contentType == -1){
          echo '<p style="text-align: center">Non ci sono altri post da mostrare</p>';
          return;
        }
      }
    }

    //Funzione che mostra a video i viaggi più recenti creati dagli utenti (al più 100)
    function showRecentViaggi(){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT idViaggio FROM viaggio ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      $count = 0;
      while($userRow = $result->fetch_assoc()){
        $count++;
        showViaggio($userRow['idViaggio']);
        if($count >= $MAX_NUMBER_OF_CONTENTS)
          break;
      }
    }

    //Funzione che carica le tappe di un viaggio (a partire dalla meno recente)
    function showTappe($idViaggio){
      global $eTravelDb;

      $queryText = "SELECT * FROM tappa WHERE viaggio='".$idViaggio."' ORDER BY timestamp ASC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      $count = 0;

      while($userRow = $result->fetch_assoc()){
        echo '<div class="divTappaSingola">';
        echo '<h5 class="sottoTitoloEvento">Tappa n°'.($count+1).'</h5>';
        if($userRow['luogo'] != null)
          echo '<p>'.getNomeLuogo($userRow['luogo']).'</p>';
        echo '<h5 class="sottoTitoloEvento">Data</h5>';
        if($userRow['data'] != null)
          echo '<p>'.changeDataFormat($userRow['data']).'</p>';
        else echo '<p>Non specificata</p>';
        echo '<h5 class="sottoTitoloEvento">Mezzo</h5>';
        echo '<div class="divImgMezzoScelto'.$idViaggio.'" style="width: 5em"></div>';
        if($userRow['mezzo'] != null)
          echo '<script>printMezzo('.$userRow['mezzo'].', '.$count.', '.$idViaggio.')</script>';
        else echo '<p>Non specificato</p>';
        echo '<h5 class="sottoTitoloEvento">Commento</h5>';
        if($userRow['commento'] != null)
          echo '<p>'.$userRow['commento'].'</p>';
        else echo '<p>Non specificato</p>';
        echo '</div>';

        echo '<script>placePointerWrapper('.$idViaggio.', '.$userRow['positionX'].', '.$userRow['positionY'].', 1)</script>';

        $count++;
      }
    }

    //Funzione che carica le tappe di un viaggio (a partire dalla meno recente) ma in versione ridotta
    function showTappeRidotte($idViaggio){
      global $eTravelDb;

      $queryText = "SELECT * FROM tappa WHERE viaggio='".$idViaggio."' ORDER BY timestamp ASC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      while($userRow = $result->fetch_assoc())
        echo '<script>placePointerWrapper("Ridotta'.$idViaggio.'", '.$userRow['positionX'].', '.$userRow['positionY'].', 0)</script>';
    }

    //Invia, codificato tramite JSON, un array contenente le informazioni sugli utenti contenute in 'result'
    function showUserInfo($result){
      global $MAX_NUMBER_OF_CONTENTS;

      $arrayUser = array();
      $count = 0;

      while($userRow = $result->fetch_assoc()){

        $arrayUser[$count] = new userInfo();
        $arrayUser[$count]->nome = $userRow['name'];
        $arrayUser[$count]->usernameUtente = $userRow['username'];
        $arrayUser[$count]->pathFotoProfilo = $userRow['fotoProfilo'];
        if($userRow['luogoOrigine'] != null)
          $arrayUser[$count]->luogoOrigine = getNomeLuogo($userRow['luogoOrigine']);
        else $arrayUser[$count]->luogoOrigine = " ";
        if($userRow['dataNascita'] != null)
          $arrayUser[$count]->dataNascita = changeDataFormat($userRow['dataNascita']);
        else $arrayUser[$count]->dataNascita = " ";

        $count++;
        if($count >= $MAX_NUMBER_OF_CONTENTS)
          break;
      }
      $arrayEncoded = json_encode($arrayUser);

      echo $arrayEncoded;
    }

    //Mostra a video i viaggi più recenti creati da un dato profilo (al più 100)
    function showViaggiFromProfilo($idUser){
      global $eTravelDb;
      global $MAX_NUMBER_OF_CONTENTS;

      $queryText = "SELECT idViaggio FROM viaggio WHERE autore='".$idUser."' ORDER BY timestamp DESC";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo 'Errore di connessione';
        return;
      }

      $count = 0;

      while($userRow = $result->fetch_assoc()){
        if($count < $MAX_NUMBER_OF_CONTENTS)
          showViaggio($userRow['idViaggio']);
        else return;
        $count++;
      }
    }

    //Funzione che mostra a video un viaggio
    function showViaggio($idViaggio){
      global $eTravelDb;

      $queryText = "SELECT * FROM viaggio WHERE idViaggio='".$idViaggio."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      $userRow = $result->fetch_assoc();
      $nomeUtente = getNomeUtente($userRow['autore']);
      $usernameUtente = getUsernameUtente($userRow['autore']);
      if($userRow['tag'] != null)
        $usernameTag = getUsernameUtente($userRow['tag']);

      echo '<div class="divEvento" style="padding-bottom: 1em">';
      echo '<h5 class="titoloEvento"><a href="./profilo.php?username='.$usernameUtente.'" style="color: #4286f4">'.$nomeUtente.'</a> parteciperà ad un viaggio';
      if($userRow['tag'] != null)
        echo ' con <a href="./profilo.php?username='.$usernameTag.'" style="color: #4286f4">'.getNomeUtente($userRow['tag']).'</a>';
      echo '</h5>';
      echo '<div class="divContentViaggioRight">';
      echo '<img class="imgMap" id="contentMap'.$idViaggio.'" src="../css/immagini/mapItaly.svg" alt="Spiacenti, non riusciamo a caricare la mappa">';
      if($userRow['compagnia'] == 1)
        echo '<h5 class="sottoTitoloEvento" style="width: 100%">Cerco compagni di viaggio!</h5>';
      echo '</div>';

      //Sono invertiti i div perché la funzione 'showTappe' deve essere chiamata solo dopo che la mappa si è caricata
      echo '<div class="divContentViaggioLeft">';
      showTappe($userRow['idviaggio']);
      echo '</div>';
      echo '</div>';      
    }

    //Funzione che mostra a video una versione semplificata di un viaggio
    function showViaggioRidotto($idViaggio){
      global $eTravelDb;

      $queryText = "SELECT * FROM viaggio WHERE idViaggio='".$idViaggio."'";

      $result = $eTravelDb->performQuery($queryText);
      if(!$result){
        echo '<div class="divContent>Errore di connessione</div>';
        return;
      }

      $userRow = $result->fetch_assoc();
      $nomeUtente = getNomeUtente($userRow['autore']);
      $usernameUtente = getUsernameUtente($userRow['autore']);

      echo '<div class="divViaggioRidotto">';
      echo '<h5 class="sottoTitoloEvento" style="width: 100%; text-align: center; margin: 0">Creato da ';
      echo '<a href="./profilo.php?username='.$usernameUtente.'">'.$nomeUtente.'</a></h5>';
      echo '<img class="imgMap" id="contentMapRidotta'.$idViaggio.'" src="../css/immagini/mapItaly.svg" alt="Spiacenti, non riusciamo a caricare la mappa">';
      showTappeRidotte($idViaggio);
      echo '</div>';
    }
?>