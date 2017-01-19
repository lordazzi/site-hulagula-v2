<?php
session_start();

function __autoload($class) {
	$class = strtolower($class);
	require_once("$_SERVER[DOCUMENT_ROOT]/resource/php/class/$class.class.php");
}

require_once("$_SERVER[DOCUMENT_ROOT]/resource/php/functions.php");
?>