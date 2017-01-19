<?
include("../conn.php");
include("../header.php");
include("../menu.php");

$data = mysql_query("SELECT * FROM vantagens ORDER BY pos");
$right = false;
while ($vant = mysql_fetch_array($data)) {
	
	echo "
		<div class='vant'>
			<img src='../../arquivo/foto_vantagens/".$vant["img"]."' $right /> <span><b>".$vant["titulo"]."</b><br />".$vant["description"]."</span>
		</div>
	";
	
	if ($right == "") { $right = " style='float: right;' "; }
	else { $right = ""; }
}

include("../footer.php");
?>