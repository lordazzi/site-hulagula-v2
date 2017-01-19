<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();
callback($sql->Query("SELECT idcategoria, categoria FROM produtos_categorias WHERE isactive = 1"));
?>