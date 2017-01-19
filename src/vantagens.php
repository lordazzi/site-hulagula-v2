<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();

$page = new HulaGula(array(
	"html" => array(
		"vantagens" => $sql->Query("SELECT titulo, img, description FROM vantagens ORDER BY pos")
	),
	"less" => TRUE
));
?>