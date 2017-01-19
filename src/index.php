<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();
$configs = $sql->Query("SELECT valor FROM promote_config");

$page = new HulaGula(array(
	"html" => array(
		"pizzapreco" => number_format($configs[0]["valor"], 2, ',', ''),
		"esfihapreco" =>  number_format($configs[1]["valor"], 2, ',', ''),
		"esfihaquantidade" =>  number_format($configs[2]["valor"], 0)
	),
	"less" => TRUE
));
?>