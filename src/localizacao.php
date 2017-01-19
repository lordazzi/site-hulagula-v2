<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();

$page = new HulaGula(array(
	"html" => TRUE,
	"less" => TRUE,
	"cache" => FALSE
));
?>