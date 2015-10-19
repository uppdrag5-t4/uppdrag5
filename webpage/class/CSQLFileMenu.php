<?php

class CSQLFileMenu {
	private $_html;
	private $_navigation;

	public function __construct() {
		if(!isset($_POST['path']))
			$dir = "";
		else
			$dir = $_POST['path'];

		var_dump($this->_readTree($dir));
	}

	private function _readTree($dir) {
		$fullDir = "./SQL".$dir;
		$this->_navigation = $fullDir;

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

	public function getNavigation() {
		
	}

	public function getContent() {
		echo $this->_html;
	}
}