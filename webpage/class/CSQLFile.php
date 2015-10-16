<?php

class CSQLFile {
	private $filename;
	private $instruction;
	private $sql;
	private $res;
	private $con;
	private $html;

	public function __construct($filename) {
		# Spara referensen till sql-filen
		$this->filename = $filename;

		# Skapa en ny instans till classen CDatabase
		$this->con = new CDatabase();	
	}

	private function readFileParts() {
		# Hämta innehållet i sql-filen
		$dir 	= 	"./SQL/";
		$file 	= 	file_get_contents($dir.$filename);
		$json 	= 	json_decode($file);

		# Läs in insormationen från sql-filen och spara den i variablerna
		$this->instruction 	= 	$json->ins;
		$this->sql 			=	$json->sql;
		$this->res 			=	$json->res;
	}

	private function executeStatements() {
		# Förbereder sql-satsen
		$prepare 	=	 $this->con->prepare($this->sql);

		# Kör sql-satsen och retunerar den
		return $prepare->execute()
	}

	private function generateHTMLtableResult() {
		# Skapa en variable * html * som håller en html tabell
		$this->html 	=	 "<table border='1'>";
		$this->html 	.=	 "</table>";
	}
}