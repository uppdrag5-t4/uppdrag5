<?php

class CSQLFileMenu {
	private $file;
	private $html;

	public function __construct() {

		# Om man ska visa den lägsta menyn
		if(isset($_POST['low'])) {

		}
		# Om amn ska visa den mellersta menyn
		else if(isset($_POST['sub'])) {

		}
		# Om man ska visa den översta menyn
		else {
			$this->html = "<form>";
			$this->html .= "<input type='button' name='' value='0 Skapa tabell'>";
			$this->html .= "<input type='button' name='' value='1 Fyll tabeller'>";
			$this->html .= "<input type='button' name='' value='2 Radera'>";
			$this->html .= "<input type='button' name='' value='3 Hämta data'>";
			$this->html .= "</form>";
		}

	}

	public function getNavigation() {
		
	}

	public function getContent() {
		echo $this->html;
	}
}