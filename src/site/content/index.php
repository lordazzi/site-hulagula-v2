<?

include("../conn.php");
include("../header.php");
include("../menu.php");

$data = mysql_query("SELECT * FROM promote_config");
$whiles = 0;
while ($config = mysql_fetch_array($data)) {
	$config_array[$whiles][0] = str_replace(".", ",", $config["valor"]);
	$config_array[$whiles][1] = $config["ativo"];
	$whiles++;
}

?>

<?
//Array de configuração [0] = primeiro, [1] = ativo
if ($config_array[0][1] == 1) {
?>
<div class="pizza_promotion">
	<IMG src="../../plugins/img/top.png" class="top" />
	<span>
		<b>PROMOÇÃO</b><br />
		<i>BAURU - BERINJELA - CALABRESA I<br />
		ESCAROLA - LOMBINHO - MARGUERITA<br />
		TOSCANA - MUSSARELA - NAPOLITANA</i>
	</span>
	<IMG src="../../plugins/img/promote.png" class="promote" />
	
	<? //Array de configuração, [0] = primeira promoção; [0] = valor da promoção; [0][1][2][3][4] = Toda string no PHP é naturalmente um array ?>
	<IMG src="../../plugins/numeros/red/<? echo $config_array[0][0][0]; ?>.png" class="numeros" style="left: 95px; top: -5px;" />
	<IMG src="../../plugins/numeros/red/<? echo $config_array[0][0][1]; ?>.png" class="numeros" style="left: 80px; top: 15px;" />
	<IMG src="../../plugins/numeros/red/<? echo $config_array[0][0][2]; ?>.png" class="numeros" style="left: 45px; top: 35px;" />
	<IMG src="../../plugins/numeros/red/<? echo $config_array[0][0][3]; ?>.png" class="numeros" style="left: 30px; top: 5px; width: 60px;" />
	<IMG src="../../plugins/numeros/red/<? echo $config_array[0][0][4]; ?>.png" class="numeros" style="left: 15px; top: 20px; width: 60px;" />
	
	<IMG src="../../plugins/img/bottom.png" class="bottom" />
</div>
<br />
<?
} //Array de configurações: [1] = Segunda promoção, [1] = Verifica se está ativa (0/1)
 if ($config_array[1][1] == 1) {
?>
	<IMG style="width: 755px; margin: 15px 0pt -85px 10px;" src="../../plugins/img/esfihas.png" />
	<IMG src="../../plugins/numeros/green/<? echo $config_array[1][0][0]; ?>.png" style="position: relative; top: -250px; left: 80px; width: 65px; height: 90px;" />
	<IMG src="../../plugins/numeros/green/<? echo $config_array[1][0][1]; ?>.png" style="position: relative; top: -255px; left: 80px; width: 15px; height: 25px;" />
	<IMG src="../../plugins/numeros/green/<? echo $config_array[1][0][2]; ?>.png" style="position: relative; top: -270px; left: 65px; width: 65px; height: 90px;" />
	<IMG src="../../plugins/numeros/green/<? echo $config_array[1][0][3]; ?>.png" style="position: relative; top: -285px; left: 55px; width: 65px; height: 90px;" />
	
	<?
		if ($config_array[2][0] < 10) {
			$config_array[2][0] = "0".$config_array[2][0];
		}
	?>
	<IMG src="../../plugins/numeros/normal/<? echo $config_array[2][0][0]; ?>.png" style="position: relative; height: 30px; top: -245px; width: 15px; left: 333px;" />
	<IMG src="../../plugins/numeros/normal/<? echo $config_array[2][0][1]; ?>.png" style="position: relative; width: 15px; height: 30px; left: 330px; top: -245px;" />
<? } ?>
	<IMG src="../../plugins/img/tels.png" style="width: 750px; display: block; margin: 5px auto 15px;" />
<? include("../footer.php"); ?>