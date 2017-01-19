<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/resource/config.php");
header("Content-type: text/css");

if ($_GET["f"] <> "") { 
	$file = $_SERVER["DOCUMENT_ROOT"].base64_decode($_GET["f"]);
	
	if (file_exists($file)) {
	$ext = explode(".", $file);
		if ($ext[count($ext) - 1] == "css") {
			if (file_exists($file)) {
				$less = new lessc;
				echo $less->compile(file_get_contents($file));
			} else {
				exit();
			}
		} else {
			exit();
		}
	} else {
		exit();
	}
} else {
	exit();
}
?>