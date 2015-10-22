<?php

class CDatabase {
	private $_con;							# uppkopplingsvaiabel
	private $_username 	= 	"root";			# Användarnamn
	private $_password	= 	"";				# Lösenord
	private $_host		=	"127.0.0.1";	# Host (oftast localhost eller 127.0.0.1)
	private $_db		= 	"skolan";		# Databas att koppla upp mot

	public function __construct() {

		# Försök att skapa en upploppling mot databasen med PDO (PHP DATA OBJECTS). Fånga ett meddelande om ett fel uppstår
		try {
			$this->_con = new PDO("mysql:host=".$this->_host.";dbname=".$this->_db, $this->_username, $this->_password);
			$this->_con->exec("set names utf8");
		}
		catch(PDOExeption $e) {
			die("Connection error: " . $e->getMessage());
		}

		# Retunera uppkopplingsvariabeln om lyckad uppkoppling
		return $this->_con;
	}

	# Förbered en SQL fråga innan den körs
	public function prepare($sql) {
		return $this->_con->prepare($sql);
	}
}