<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

if ($_POST) {
	$nome = post("nome");
	$contato = post("contato");
	$mensagem = post("mensagem");
	
	$sql = new MySql();
	$sql->Query("
		INSERT INTO mensagens (
			txtnome, txtcontato, txtmensagem
		) VALUES (
			'$nome', '$contato', '$mensagem'
		);
	");
}
?>