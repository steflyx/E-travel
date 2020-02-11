<?php
	
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbName = "etravel";

	$eTravelDb = new MySqlConnection();

	class MySqlConnection{

		private $mysqli_conn = null;

		function MySqlConnection(){
			$this->openConnection();
		}

		//Apre la connessione 
		function openConnection(){
    		if (!$this->isOpened()){

    			global $hostname;
    			global $username;
    			global $password;
    			global $dbName;
    			
    			$this->mysqli_conn = new mysqli($hostname, $username, $password);
				if ($this->mysqli_conn->connect_error) 
					die('Connect Error (' . $this->mysqli_conn->connect_errno . ') ' . $this->mysqli_conn->connect_error);

				$this->mysqli_conn->select_db($dbName) or
					die ('Can\'t use pweb: ' . mysqli_error($this->mysqli_conn));

			}
    	}

    	//Controlla se la connessione è aperta
    	function isOpened(){
    		return ($this->mysqli_conn != null);
    	}

    	//Chiude la connessione
    	function closeConnection(){
 	       	if($this->mysqli_conn !== null)
				$this->mysqli_conn->close();
			
			$this->mysqli_conn = null;
		}

		//Esegue una query
		function performQuery($queryText) {
			if (!$this->isOpened())
				$this->openConnection();
			
			return $this->mysqli_conn->query($queryText);
		}
		
		//Esegue una real_escape_string su stringa
		function sqlInjectionFilter($stringa){
			if(!$this->isOpened())
				$this->openConnection();
				
			return $this->mysqli_conn->real_escape_string($stringa);
		}
	}

?>