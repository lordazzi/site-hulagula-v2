<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 06/06/13 #

class HulaGula extends Page {
	
	public function __construct($args = array()) {
		parent::__construct(array(
			"header" => "/resource/html/head.html",
			"body" => "/resource/html/body.php",
			"footer" => "/resource/html/footer.html"
		), $args);
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}

?>