<?php
#	RICARDO AZZI SILVA
#	27 de março de 2013
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");

$promocao = post("promocao");
if (!file_exists("$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/normal/$promocao.png")) {
	$sql = new MySql();
	$sql->Query("UPDATE promote_config SET valor='$promocao' WHERE idconfig=3");
	
	if (preg_match("/^[0-9]{2}$/", $promocao)) {
		//
		for($i = 0; $i < strlen($promocao); $i++) {
			$number["img"][] = imagecreatefrompng("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/normal/".$promocao[$i].".png");
			$number["size"][] = getimagesize("$_SERVER[DOCUMENT_ROOT]/resource/img/numeros/normal/".$promocao[$i].".png");
		}
	}
	
	$img = imagecreatetruecolor(43, 36);
	$golden = imagecolorallocate($img, 254, 197, 00);
	
	imagefilledrectangle($img, 0, 0, 43, 36, $golden);
	imagecolortransparent($img, $golden);

	imagecopy($img, $number["img"][0], 0, 0, 0, 0, $number["size"][0][0], $number["size"][0][1]);
	imagecopy($img, $number["img"][1], 20, 0, 0, 0, $number["size"][1][0], $number["size"][1][1]);

	imagepng($img, "$_SERVER[DOCUMENT_ROOT]/arquivo/arquivo_numeros/normal/$promocao.png");
	imagedestroy($img);
	foreach($number["img"] as $image) {
		imagedestroy($image);
	}
}
?>