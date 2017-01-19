<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

if ($_POST) {
	$sql = new MySql();
	
	$per = post("per");
	$de = post("de");
	$ate = post("ate");
	
	if ($per == 1) { // day
		$results = $sql->Query("
			SELECT `data` as rotulo, count(`data`) as visitas
			FROM visitas
			WHERE `data` BETWEEN '".date("Y-m-d", $de)."' AND '".date("Y-m-d", $ate)."'
			GROUP BY `data`
		");
		
		foreach ($results as &$result) {
			$result["rotulo"] = explode("-", $result["rotulo"]);
			$result["rotulo"] = $result["rotulo"][2]."/".$result["rotulo"][1]."/".$result["rotulo"][0];
		}
	} else if ($per == 2) { // month
		$results = $sql->Query("
			SELECT subtable.visitantes as rotulo, COUNT(subtable.visitantes) as visitas
			FROM (
				SELECT CAST(`data` AS CHAR(7)) AS visitantes
				FROM visitas
				WHERE `data` BETWEEN '".date("Y-m-d", $de)."' AND '".date("Y-m-d", $ate)."'
			) AS subtable
			GROUP BY subtable.visitantes;
		");
		
		foreach ($results as &$result) {
			$result["rotulo"] = explode("-", $result["rotulo"]);
			$result["rotulo"] = $result["rotulo"][1]."/".$result["rotulo"][0];
		}
	}
	
	callback($results);
}
?>