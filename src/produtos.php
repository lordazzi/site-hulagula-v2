<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

if (is_numeric($_GET["cat"])) {
	$sql = new MySql();

	$precos = $sql->Query("
		SELECT MIN(a.preco) as min, MAX(a.preco) as max, b.search
		FROM produtos a
		INNER JOIN produtos_categorias b ON a.idcategoria = b.idcategoria
		WHERE a.idcategoria = ".get("cat"), TRUE);
	
	$produtos = $sql->Query("
		SELECT
			numero, nome, description,
			preco, nomeat, ispromote
		FROM produtos
		WHERE idcategoria = ".get("cat"));
		
	foreach ($produtos as &$produto) {
		$produto["title"] = "$produto[numero] - $produto[nome]";
		$produto["data"] = strtolower(unaccent(" data-search='$produto[numero] $produto[nome]' data-meat='".(!$produto["nomeat"])."' data-isnpromote='".(!$produto["ispromote"])."' data-preco='$produto[preco]' "));
		$produto["preco"] = "R$ ".number_format($produto["preco"], 2, ',', '.');
		$produto["description"] = ucfirst($produto["description"]);
	}
	
	$categorias = $sql->Query("SELECT idcategoria, categoria FROM produtos_categorias");
	
	$page = new HulaGula(array(
		"html" => array(
			"minpreco" => number_format($precos["min"], 2, '.', ''),
			"maxpreco" => number_format($precos["max"], 2, '.', ''),
			"issearch" => (bool) $precos["search"],
			"produtos" => $produtos,
			"categorias" => $categorias
		),
		"less" => TRUE,
		"js" => array(
			"forms"
		)
	));
} else {
	header("location: categorias.php");
}
?>