<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();
callback($sql->Query("SELECT idconfig, valor FROM promote_config"));
?>