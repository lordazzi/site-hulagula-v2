<?
include("../conn.php");
if (!$_GET["cat"]) { exit; }
if ($_POST["pesquisar"]) {
	$url = "";
	if ($_POST["nome_pizza"] != "") {
		$url .= "&nome=".$_POST["nome_pizza"];
	}
	
	if ($_POST["ingred"] != "") {
		$url .= "&ingred=".$_POST["ingred"];
	}
	
	if ($_POST["max_pizza"] != "") {
		$max_pizza = str_replace("R$", "", $_POST["max_pizza"]);
		$max_pizza = str_replace(",", ".", $max_pizza);
		$max_pizza = trim($max_pizza);
		$url .= "&max=$max_pizza";
	}
	
	if ($_POST["min_pizza"] != "") {
		$min_pizza = str_replace("R$", "", $_POST["min_pizza"]);
		$min_pizza = str_replace(",", ".", $min_pizza);
		$min_pizza = trim($min_pizza);
		$url .= "&min=$min_pizza";
	}
	
	if ($_POST["vegeta"] != "") {
		$url .= "&vegeta=1";
	}
	
	header("location: produtos.php?cat=".$_GET["cat"].$url);
}
include("../header.php");
include("../menu.php");

$data = mysql_query("SELECT * FROM produtos_categorias WHERE idcategoria=".addslashes($_GET["cat"]));
$categ = mysql_fetch_array($data);

if ($categ["search"] == 1) {//VERIFICA SE O ADMINISTRADOR PERMITE QUE EXISTA BUSCA DE PRODUTOS PARA ESSA CATEGORIA
	//Selecionando os ingredientes de cada pizza, para fazer um SEARCH baseado no ingrediente
	$data = mysql_query("SELECT * FROM produtos WHERE idcategoria=".addslashes($_GET["cat"]));
	$whiles = 0;
	while ($prod = mysql_fetch_array($data)) {
		$ingred = strtolower($prod["description"]);
		$ingred = str_replace(",", "", $ingred);
		$ingred = explode(" ", $ingred);
		for ($IntFor = 0; $IntFor < count($ingred); $IntFor++) {
			if (strlen($ingred[$IntFor]) > 3 AND $ingred[$IntFor] != "quatro" AND $ingred[$IntFor] != "ingredientes" AND $ingred[$IntFor] != "escolha" AND $ingred[$IntFor] != "fatiada" AND $ingred[$IntFor] != "fatiado" AND $ingred[$IntFor] != "fatiadas" AND $ingred[$IntFor] != "fatiados"  AND $ingred[$IntFor] != "filetes" AND $ingred[$IntFor] != "tipo") {
				$prod_array[$whiles] = $ingred[$IntFor];
				$whiles++;
			}
		}
	}

	//Organizando e retirando os repetidos
	$prod_array = @array_unique($prod_array);
	@sort($prod_array);

	
	echo "
		<!-- Uma tabelinha de vez em quando não mata ninguém, né? ;D -->
		<form method='POST' action='' class='prodt'>
			<table>
				<tr>
					<td colspan='4'><b style='padding: 0px 0px 0px 10px;'>BUSCA</b></td>
				</tr>
				
				<tr>
					<td>por nome:</td>
					<td><input type='text' name='nome_pizza' id='nome_pizza' value='".$_GET["nome"]."' /></td>
					<td style='padding-left: 60px;'>valor máximo:</td>
					<td><input name='max_pizza' type='text' style='width: 60px;' value='".$_GET["max"]."' /></td>
				</tr>
				
				<tr>
					<td>com esse ingrediente:</td>
					<td>
					<select name='ingred' id='ingred'>
							<option></option>";
							for ($IntFor = 0; $IntFor < count($prod_array); $IntFor++) {
								if ($prod_array[$IntFor] != "verde") {
									echo "<option value='".$prod_array[$IntFor]."'>".$prod_array[$IntFor]."</option>";
								}
							}	
			echo 		"</select>
					</td>
					<td style='padding-left: 60px;'>valor mínimo:</td>
					<td><input name='min_pizza' type='text' style='width: 60px;'  value='".$_GET["min"]."' /></td>
				</tr>
				
				<tr>
					<td><input type='checkbox' name='vegeta' id='vegeta' /> Sem carne? </td>
					<td></td>
					<td style='padding-left: 60px;'><input type='submit' name='pesquisar' value='Enviar' /></td>
					<td></td>
				</tr>
			</table>
		</form>
	";
	
	?>
		<script type='text/javascript'>
			document.getElementById('ingred').value = '<? echo $_GET["ingred"]; ?>';
			<? if ($_GET["vegeta"]) { echo "document.getElementById('vegeta').checked = true;"; } ?>
		</script>
	<?
}

//VERIFICA SE O ADMINISTRADOR PREFERIU ESCREVER UM TEXTO AO INVÉS DE LISTAR OS PRODUTOS
if ($categ["justtext"] == 0) {
	//Filtrando de acordo com os ingredientes selecionados
	if ($_GET["ingred"]) { $ingred = " (description LIKE '%".addslashes($_GET["ingred"])."%' OR nome LIKE '%".addslashes($_GET["ingred"])."%') AND "; }
	else { $ingred = ""; }
	
	if ($_GET["nome"]) { $nome = " (nome LIKE '%".addslashes($_GET["nome"])."%') AND "; }
	else { $nome = ""; }
	
	if ($_GET["max"]) { $max = " (preco <= ".addslashes($_GET["max"]).") AND "; }
	else { $max = ""; }
	
	if ($_GET["min"]) { $min = " (preco >= ".addslashes($_GET["min"]).") AND "; }
	else { $min = ""; }
	
	if ($_GET["vegeta"]) { $vegeta = " (nomeat = '1') AND "; }
	else { $vegeta = ""; }
	
	//Listando produtos
	$data = @mysql_query("SELECT * FROM produtos WHERE $max $min $nome $ingred $vegeta idcategoria=".addslashes($_GET["cat"]));
	while ($prod = @mysql_fetch_array($data)) {
		echo "
			<div class='prodt'>
				<b>".$prod["numero"]." - ".$prod["nome"]."</b>
				<u>".$prod["preco"]."</u><br />
				<span>".str_replace($_GET["ingred"], "<i>".$_GET["ingred"]."</i>", $prod["description"])."</span>
			</div>
		";
	}
}

else {
	echo $categ["text"];
}

$data = mysql_query("SELECT * FROM produtos_categorias");
echo "<div class='nova_categ'>";
while ($categs = mysql_fetch_array($data)) {
	echo "
	<span>
		<a href='?cat=".$categs["idcategoria"]."'>".$categs["categoria"]."</a>
	</span>";
}
echo "</div>";

include("../footer.php");
?>