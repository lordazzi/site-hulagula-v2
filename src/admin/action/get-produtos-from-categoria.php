<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$sql = new MySql();
$pizzas = $sql->Query("
	SELECT
		idproduto, numero, nome,
		preco, ispromote
	FROM produtos
	WHERE idcategoria = ".post("idcategoria")." AND isactive = 1
	ORDER BY numero
");foreach ($pizzas as &$pizza) {	$pizza["preco"] = number_format($pizza["preco"], 2, ',', '');}callback($pizzas);
?>