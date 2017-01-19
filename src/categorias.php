<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();

$page = new HulaGula(array(
	"html" => array(
		"categorias" => $sql->Query("SELECT idcategoria, img, categoria FROM produtos_categorias")
	),
	"less" => TRUE
));
?>