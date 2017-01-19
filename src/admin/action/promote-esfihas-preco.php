<?php
#	RICARDO AZZI SILVA
#	27 de março de 2013
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$promocao = post("promocao");
if (!file_exists("$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/green/$promocao.png")) {
	$sql = new MySql();
	$sql->Query("UPDATE promote_config SET valor='".number_format((float) $promocao, 2, '.', '')."' WHERE idconfig=2");
	
	if (!preg_match("/^[0-9][,][0-9]{2}$/", $promocao) and is_numeric($promocao)) { $promocao = number_format($promocao, 2, ",", ""); }

	if (preg_match("/^[0-9][,][0-9]{2}$/", $promocao)) {
		//
		for($i = 0; $i < strlen($promocao); $i++) {
			$number["img"][] = imagecreatefrompng("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/green/".$promocao[$i].".png");
			$number["size"][] = getimagesize("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/green/".$promocao[$i].".png");
		}
	}
	
	$img = imagecreatetruecolor(205, 140);
	$red = imagecolorallocate($img, 255, 00, 00);
	
	imagefilledrectangle($img, 0, 0, 205, 140, $red);
	imagecolortransparent($img, $red);

	imagecopy($img, $number["img"][0], 0, 45, 0, 0, $number["size"][0][0], $number["size"][0][1]);
	imagecopy($img, $number["img"][1], 68, 100, 0, 0, $number["size"][1][0], $number["size"][1][1]);
	imagecopy($img, $number["img"][2], 80, 20, 0, 0, $number["size"][2][0], $number["size"][2][1]);
	imagecopy($img, $number["img"][3], 138, 0, 0, 0, $number["size"][3][0], $number["size"][3][1]);

	imagepng($img, "$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/green/$promocao.png");
	imagedestroy($img);
	foreach($number["img"] as $image) {
		imagedestroy($image);
	}
}
?>