<?php

class CSQLFileMenu {
	private $_html;
	private $_navigation;
	private $_isfile;

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
		$fullDir = "./SQL".$dir;
		$this->_navigation = $fullDir;

		# Kolla om det är en mapp man tryckt på eller ej
		if(is_dir($fullDir)) {
			$files = scandir($fullDir);

			for ($i = 0; $i < count($files); $i++) {
				if($files[$i] == '.' || $files[$i] == '..') continue;

				$info = pathinfo($files[$i]);

				if(isset($info['extension']))
					$file = basename(ucfirst(str_replace('_', ' ', $files[$i])), '.'.$info['extension']);
				else
					$file = basename(ucfirst(str_replace('_', ' ', $files[$i])));

				@$this->_html .= "<form method='POST'>";
				$this->_html .= "<input type='submit' value='".$file."'>";
				$this->_html .= "<input type='hidden' name='path' value='{$dir}/{$files[$i]}'>";
				$this->_html .= "</form>";
			}

			return false;
		}

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
		
	}

	public function getContent() {
		echo $this->_html;
	}
}