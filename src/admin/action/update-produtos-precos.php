<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

if (count($_POST["ids"]) == count($_POST["values"])) {
	$sql = new MySql();
	for ($i = 0; $i < count($_POST["ids"]); $i++) {
		$sql->Query("UPDATE produtos SET preco = '".adjust($_POST["values"][$i])."' WHERE idproduto = ".$_POST["ids"][$i]);
	}
} else {
	callback(array(
		"success" => FALSE,
		"msg" => "Quantidade de valores enviada foi diferente da quantidade de números de identificação!"
	));
}

callback(array(
	"success" => TRUE
));
?>