<?php
session_start(); // inicia a sessão
header("Content-type: image/jpeg"); // define o tipo do arquivo
if (!preg_match("/^[A-Za-z][_\\-A-Za-z0-9]*$/", $_GET["id"])) {
	die();//!!!
}

$tamanho_fonte = 22;
$imagem = imagecreate(125, 45); // define a largura e a altura da imagem

$font = Array("aenigma.ttf", "airmole.ttf", "android.ttf",
	"bosox.ttf", "gringo.ttf", "lightout.ttf", "angrybirds.ttf",
	"strings_and_things.ttf", "call_me_maybe.ttf"
);
$font = "$_SERVER[DOCUMENT_ROOT]/resource/fonts/".$font[rand(0, count($font) - 1)];

$cores = rand(0, 9);
switch ($cores) {
	case 0:
		$r1 = 255; $g1 = 255; $b1 = 255; // define a cor branca
		$r2 = 0; $g2 = 0; $b2 = 0; // define a cor preta
		break;
	case 1:
		$r1 = 0; $g1 = 0; $b1 = 0; // define a cor preta
		$r2 = 255; $g2 = 255; $b2 = 255; // define a cor branca
		break;
	case 2:
		$r1 = 255; $g1 = 0; $b1 = 0; // define a cor vermelha
		$r2 = 0; $g2 = 255; $b2 = 255; // define a cor ciano
		break;
	case 3:
		$r1 = 0; $g1 = 255; $b1 = 255; // define a cor ciano
		$r2 = 255; $g2 = 0; $b2 = 0; // define a cor vermelho
		break;
	case 4:
		$r1 = 255; $g1 = 102; $b1 = 0; // define a cor laranja
		$r2 = 0; $g2 = 102; $b2 = 255; // define a cor azul
		break;
	case 5:
		$r1 = 0; $g1 = 102; $b1 = 255; // define a cor azul
		$r2 = 255; $g2 = 102; $b2 = 0; // define a cor laranja
		break;
	case 6:
		$r1 = 255; $g1 = 255; $b1 = 0; // define a cor amarelo
		$r2 = 0; $g2 = 0; $b2 = 255; // define a cor azul
		break;
	case 7:
		$r1 = 0; $g1 = 0; $b1 = 255; // define a cor azul
		$r2 = 255; $g2 = 255; $b2 = 0; // define a cor amarelo
		break;
	case 8:
		$r1 = 51; $g1 = 255; $b1 = 0; // define a cor verde
		$r2 = 204; $g2 = 0; $b2 = 255; // define a cor magenta
		break;
	case 9:
		$r1 = 204; $g1 = 0; $b1 = 255; // define a cor verde
		$r2 = 51; $g2 = 255; $b2 = 0; // define a cor magenta
		break;
}


$rgb1  = imagecolorallocate($imagem, $r1, $g1, $b1); //background
$rgb2 = imagecolorallocate($imagem, $r2, $g2, $b2);

$captcha = substr(str_shuffle("ABCDEFGHIJKLMNPQRTUVYXW1346789"), 0, rand(3, 4)); //	embaralhar letras
$_SESSION["_captcha_"][$_GET["id"]]["palavra"] = $captcha; // atribui para a sessao a palavra gerada

for($i = 0; $i < strlen($captcha); $i++){
	imagettftext($imagem, $tamanho_fonte, rand(-15, 15), (($tamanho_fonte+5)*$i)+15, ($tamanho_fonte + 10), $rgb2, $font, $captcha[$i]); // atribui as letras à imagem
}
imagejpeg($imagem); // gera a imagem
imagedestroy($imagem); // limpa a imagem da memoria
?>