<?php

class CDatabase {
	private $con;							# uppkopplingsvaiabel
	private $username 	= 	"root";			# Användarnamn
	private $password	= 	"";				# Lösenord
	private $host		=	"127.0.0.1";	# Host (oftast localhost eller 127.0.0.1)
	private $db			= 	"test";			# Databas att koppla upp mot

	public function __construct() {

		# Försök att skapa en upploppling mot databasen med PDO (PHP DATA OBJECTS). Fånga ett meddelande om ett fel uppstår
		try {
			$this->con = new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->username, $this->password);
			$this->con->exec("set names utf8");
		}
		catch(PDOExeption $e) {
			die($e->getMessage());
		}

		# Retunera uppkopplingsvariabeln om lyckad uppkoppling
		return $this->con;
	}

	# Förbered en SQL fråga innan den körs
	public function prepare($sql) {
		return $this->con->prepare($sql);
	}
}