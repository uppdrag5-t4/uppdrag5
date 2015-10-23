<?php

class CSQLFileMenu {
	private $_html;
	private $_navigation;
	private $_isfile;
	private $_fullDir;

	public function __construct() {
		# Om man har tryckt på en av sökvägarna
		if(!isset($_POST['path']))
			$dir = "";
		# Annars sätt dir till tomma strängen
		else
			$dir = $_POST['path'];

		# Läs i mapparna och kolla om man tryckt på en fil eller mapp
		$this->_isfile = $this->_readTree($dir);

		# Kolla om det är en fil man tryckt på
		$this->_checkIfFile($this->_isfile);
	}

	# Läs genom mappstrukturen
	private function _readTree($dir) {
		$this->_fullDir = "./SQL".$dir;
		$this->_navigation = $this->_fullDir;

		# Kolla om det är en mapp man tryckt på eller ej
		if(is_dir($this->_fullDir)) {
			$files = scandir($this->_fullDir);

			for ($i = 0; $i < count($files); $i++) {
				if($files[$i] == '.' || $files[$i] == '..') continue;

				# Hämta informationen om filen
				$info = pathinfo($files[$i]);

				# Om filen har en '.php, .html, .css' etc så ta bort den
				if(isset($info['extension']))
					$file = basename(ucfirst(str_replace('_', ' ', $files[$i])), '.'.$info['extension']);
				else
					$file = basename(ucfirst(str_replace('_', ' ', $files[$i])));

				# Bygg knapparna för att navigera på sidan
				@$this->_html 	.= 	"<form method='POST'>";
				$this->_html 	.= 	"<input type='submit' value='".$file."'>";
				$this->_html 	.= 	"<input type='hidden' name='path' value='{$dir}/{$files[$i]}'>";
				$this->_html 	.= 	"</form>";
			}

			# Om det är en mapp man klickat på
			return false;
		}

		# Om det är en fil man klickat på
		return true;
	}

	# Om det är en fil, läs in filen
	private function _checkIfFile($bool) {
		if($bool) {
			$csqlFile = new CSQLFile($this->_navigation);
			$this->_html = $csqlFile->returnResult();
		}
	}

	public function getNavigation() {
		# Variabel som håller HTML-koden
		$html = "";

		# Dela upp strängen i olika delar
		$path = explode('/', $this->_fullDir);
		array_slice($path, 0, 2);

		# Räkna ut längden på den nya listan
		$length = count($path);

		# Skapa root knappen
		$html = "<form method='POST'>
					<input type='submit' value='ROOT'>
					<input type='hidden' name='path' value=''>
				</form>";

		# Fyll på med fler knappar om så finns
		for ($i = 2; $i < $length; $i++) { 
			@$fullPath 	.= '/'.$path[$i];

			$html 		.= "<span> > </span>";

			$html 		.= "<form method='POST'>
								<input type='submit' value=\"$path[$i]\">
								<input type='hidden' name='path' value=\"$fullPath\">
							</form>";
		}

		# Skriv ut sökvägarna
		echo $html;
	}

	# Retunera innehållet till sidan
	public function getContent() {
		echo $this->_html;
	}
}