<?php

class CSQLFile {
	private $_filename;
	private $_instruction;
	private $_sql;
	private $_res;
	private $_con;
	private $_html;

	public function __construct($filename) {
		# Spara referensen till sql-filen
		$this->_filename = $filename;

		# Skapa en ny instans till classen CDatabase
		$this->_con = new CDatabase();

		# Läser in textfilen till 3st variabler
		$this->_readFileParts();	

		# Kör SQL-frågan
		$this->_executeStatements($this->_sql);

		# Skapa resultatsidan och skicka tillbaka den till CSQLFileMenu
		$this->_generateHTMLResult();
	}

	private function _readFileParts() {
		# Hämta innehållet i sql-filen
		$file 	= 	file_get_contents($this->_filename);
		$json 	= 	json_decode($file);

		# Läs in insormationen från sql-filen och spara den i variablerna
		$this->_instruction 	= 	$json->ins;
		$this->_sql 			=	$json->sql;
		$this->_res 			=	$json->res;
	}

	private function _executeStatements($sql) {
		# Förbereder sql-satsen
		$prepare 	=	 $this->_con->prepare($sql);

		# Kör sql-satsen
		$prepare->execute();

		# Retunera objektet
		return $prepare;
	}

	private function _generateHTMLResult() {
		$q = $this->_executeStatements($this->_res);

		# Hämta rubrikerna för tabellen
		$row = $q->fetch(PDO::FETCH_ASSOC);
		$th = "<tr>";
		$td = "<tr>";
		$count = 0;

		# Ta ut filnamnet och sätt den som rubrik
		$array = explode('/', $this->_filename);
		$header = explode('.', $array[count($array) -1])[0];
		$this->_html = "<h1 class='huvudrub'>".ucfirst($header)."</h1>";

		# Fyll på med instruktionen
		$this->_html .= "<p class='paragraf'>".$this->_instruction."</p>";

		# Lägg till rubriken exempel
		$this->_html .= "<h1 class='huvudrub'>Exempel</h1>";

		# Lägg till sql-uttrycket
		$this->_html .= "<p class='paragraf'>".$this->_sql."</p>";

		# Lägg till rubriken resultat
		$this->_html .= "<h1 class='huvudrub'>Resultat</h1>";

		# Lägg till html-tabellen
		$this->_html .= "<table border='1' cellpadding='10'><tr>";

		# Kolla om det finns ett resultat att hämta från databasen
		if($row) {
			foreach ($row as $key => $value) {
				$th .= "<th>$key</th>";
				$td .= "<td>$value</td>";
				$count++;
			}

			$this->_html .= $th.$td."</tr>";

			# Bygg upp tabellens innehåll
			while ($row = $q->fetch()) {
				$this->_html .= "<tr>";
				for ($i = 0; $i < $count; $i++) { 
					$this->_html .= "<td>".$row[$i]."</td>";
				}
				$this->_html .= "</tr>";
			}
		}

		$this->_html .= "</table>";
	}

	# Retunera HTML-tabellen till CSQLFileMenu
	public function returnResult() {
		return $this->_html;
	}
}