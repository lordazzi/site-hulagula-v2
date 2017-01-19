<?php
#	RICARDO AZZI SILVA
#	27 de março de 2013
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$promocao = post("promocao");
if (!file_exists("$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/red/$promocao.png")) {
	$sql = new MySql();
	$preco = number_format((float) $promocao, 2, '.', '');
	$sql->Query("UPDATE promote_config SET valor='$preco' WHERE idconfig=1");
	$sql->Query("UPDATE produtos SET preco = '$preco' WHERE idcategoria = 1 and ispromote = 1");
	
	if (!preg_match("/^[0-9][,][0-9]{2}$/", $promocao) and is_numeric($promocao)) { $promocao = number_format($promocao, 2, ",", ""); }
	
	if (preg_match("/^[0-9]{2}[,][0-9]{2}$/", $promocao)) {
		//
		for($i = 0; $i < strlen($promocao); $i++) {
			$number["img"][] = imagecreatefrompng("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/red/".$promocao[$i].".png");
			$number["size"][] = getimagesize("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/red/".$promocao[$i].".png");
		}
	}

	$img = imagecreatetruecolor(295, 175);
	$yellow = imagecolorallocate($img, 255, 255, 00);
	
	imagefilledrectangle($img, 0, 0, 295, 175, $yellow);
	imagecolortransparent($img, $yellow);

	imagecopy($img, $number["img"][0], 0, 0, 0, 0, $number["size"][0][0], $number["size"][0][1]);
	imagecopy($img, $number["img"][1], 80, 20, 0, 0, $number["size"][1][0], $number["size"][1][1]);
	imagecopy($img, $number["img"][2], 150, 125, 0, 0, $number["size"][2][0], $number["size"][2][1]);
	imagecopyresampled($img, $number["img"][3], 185, 50, 0, 0, $number["size"][3][0]/1.7, $number["size"][3][1]/1.7, $number["size"][3][0], $number["size"][3][1]);
	imagecopyresampled($img, $number["img"][4], 235, 67, 0, 0, $number["size"][4][0]/1.7, $number["size"][4][1]/1.7, $number["size"][4][0], $number["size"][4][1]);

	imagepng($img, "$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/red/$promocao.png");
	imagedestroy($img);
	foreach($number["img"] as $image) {
		imagedestroy($image);
	}
}
?>