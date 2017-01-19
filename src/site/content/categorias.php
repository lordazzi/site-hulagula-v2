<?
include("../conn.php");
include("../header.php");
include("../menu.php");
$data = mysql_query("SELECT * FROM produtos_categorias");
while ($categ = mysql_fetch_array($data)) {
	echo "
	<div class='categoria' onClick=\" window.location.href = 'produtos.php?cat=".$categ["idcategoria"]."'; \">
		<IMG src='../../arquivo/foto_categorias/".$categ["img"]."' />
		<span>".$categ["categoria"]."</span>
	</div>";
}
include("../footer.php");
?>