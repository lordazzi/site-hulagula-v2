<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 03/11/12 #

class Captcha {
		/**
			O id da captcha, é obrigatório. Como captcha usa
			$_SESSION, o não uso deste campo irá sobreescrever outros
			captchas. Através do ID que o captcha irá conseguir conversar
			com outra captcha que esteja num arquivo que recebe AJAX
			para que a classe saiba de qual captcha esta sendo tratada
		*/
	
	public static function getCaptcha($id) {
		if (!preg_match("/^[A-Za-z][_\\-A-Za-z0-9]*$/", $id)) { return FALSE; }
		/**
			O parametro $pos é referente a posição da imagem captcha
			(captcha.php), dentro do sistema.
		*/
		//	CSS
		$cssid = $id."-captcha";
		echo("
		<style type='text/css'>
			#$cssid {
				margin: 10px auto;
				display: block;
				height: 76px;
				width: 127px;
			}
			
			#$cssid img {
				display: block;
				margin: 0px;
				height: 50px;
				width: 125px;
				border-radius: 7px 7px 0px 0px;
				-moz-border-radius: 7px 7px 0px 0px;
				-webkit-border-radius: 7px 7px 0px 0px;
				border: 1px solid #000;
			}
				
			#$cssid input[type='text'] {
				margin: -1px 0 0 0;
				padding: 0 5px;
				
				height: 24px;
				width: 92px;
				
				display: block;
				float: left;
				
				border-top: 0px;
				border: 1px solid #000;
				border-radius: 0px 0px 0px 7px;
				-moz-border-radius: 0px 0px 0px 7px;
				-webkit-border-radius: 0px 0px 0px 7px;
			}
				
			#$cssid div {
				width: 10px;
				background-color: #FFF;
				float: left;
				padding: 3px 2px;
				border: 1px solid #000;
				margin-left: -1px;
				margin-top: -1px;
				width: 18px;
				border-radius: 0 0 7px 0;
				cursor: pointer;
			}		
			
			#$cssid div img {
				width: 18px;
				height: 18px;
				border-radius: 0px;
				border: none;
			}
		</style>
		");
		
		$refresh = "id='$id-refresh'";
		$text = " name='$id' id='$id' ";
		$idcaptcha = " id='$id-captcha' ";
		$letters = " id='$id-letters' ";
		
		//	DOM
		echo("
			<span $idcaptcha>
				<img id='$id-letters' src='/resource/img/captcha.php?id=$id' />
				<input $text type='text' />
				<div>
					<img $refresh src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC2klEQVR42oWTS0hUYRiGn3OZOWcuZ2YaHbUIMulmZRcloptIRpQLyaIL0W0TFLgoxGWrFhVR4KpFiy4QRlFEF4poISVSLQLJArtYQXSBysRpZnTmnL/vKKRDQT8c/sN//u897/t+76c57W/U8MlZGpNWyanvR72C26CFgqvLK2wGR8C1At31c/Sua0u0I5PvahzoU1Yuy8j5ZWMggQMvVEvrfHIeJHQIW/KYMN+G5ji0voYrizVtAmB/r0purGH46hOMZJyFu6sJuRCRorIwWLKXBiAnlxdHoSkGB1+BMNHGAfY+UWZTLdGARiqsYyopjGnE5W9xAwoFyI5CXRkIIUaEWWtqAkRjV4+iaRm26zI1YWDqirnTAjy69I6CE8RJhSmMemQ8g1N7EwxmYGYQGh1Y/shnsP2BYuMKDMPAEbFm3sWQwm83+nDP1hSZGz49qHyQoLBYKN5s6/YBttxVrK+TtxA76qOsTYpWMezEF7h/7gPpY5V/QCrODKmsaIjPTaBEatxSaKVtfcqJCCc5edfTD9EERvUMLBSZ45VFDP61/nvBX8G2t2o07+FUJXE9nQ3LY7iuwgrpArDplmLpArFbemfo2P1fyXWu/ANstw+o5p0zaZkOVaJ7QEL1Mi0ZEZkXnrkCsLZTsbORsSYFTOzbz8ldXVPErP7ykNq6KsbD7xCTTKRCsovqzqcjAtBwUdHSIPXiihKQKXHsm72MCkU7lcDzPLFHY0/7It7/lJhbvnnSEQG69/TXuAehHY9Vdl0lDGdFhkQv7hAYlE/KI591qV5VQkAUlksyfb9LI1IjIbvbk55k4uY7kodayWx+PH6az7UcW/dIhjQs3aAsZTD0Mcur+wMsaKoi/Tlb3AV7X6/K1UoQTDl2/YGQ8JtRnJhJOKIzdP0letAg0zFPCx/qV8nZJX+30Wl7fTT/I9OQG/60Gn9exINgdFp3MGF3pTvmFY1y5HC/+g2AMu993dD1HgAAAABJRU5ErkJggg==' />
				</div>
			</span>
		");
		
		//	JAVASCRIPT
		echo("
			<script type='text/javascript'>
				if (document.addEventListener) {
					document.getElementById('$id-refresh').addEventListener('click', function(){
						var _ = Math.round(new Date().getTime()/1000);
						document.getElementById('$id-letters').setAttribute('src', '/resource/img/captcha.php?id=$id&_='+_);
					}, false);
				} else if (document.attachEvent) { //ie
					document.getElementById('$id-refresh').attachEvent('onclick', function(){
						var _ = Math.round(new Date().getTime()/1000);
						document.getElementById('$id-letters').setAttribute('src', '/resource/img/captcha.php?id=$id&_='+_);
					});
				}
			</script>
		");
	}
	
	//	é importante passar o id da captcha e o que o usuário escreveu
	//	verifica se a tentativa é igual as letras da captcha, se não for
	//	adiciona uma tentativa
	public static function Match($id) {
		if (!preg_match("/^[A-Za-z][_\\-A-Za-z0-9]*$/", $id)) { return FALSE; }
		$palavra = $_SESSION["_captcha_"][$id]["palavra"];

		if (strtoupper($_POST[$id]) == strtoupper($palavra)) {
			unset($_SESSION["_captcha_"][$id]);
			return TRUE;
		} else {
			$_SESSION["_captcha_"][$id]["tries"] = Captcha::getTries($id) + 1;
			return FALSE;
		}
	}
	
	//	pega a quantidade de tentativas
	public static function getTries($id) {
		if (!preg_match("/^[A-Za-z][_\\-A-Za-z0-9]*$/", $id)) { return FALSE; }
		if (isSet($_SESSION["_captcha_"]) and isSet($_SESSION["_captcha_"][$id]) and isSet($_SESSION["_captcha_"][$id]["tries"])) {
			return $_SESSION["_captcha_"][$id]["tries"];
		} else {
			return 0;
		}
	}
	
	//	adiciona uma tentativa
	public static function addTry($id) {
		if (!preg_match("/^[A-Za-z][_\\-A-Za-z0-9]*$/", $id)) { return FALSE; }
		$_SESSION["_captcha_"][$id]["tries"] = addTry::getTries($id) + 1;
		return $_SESSION["_captcha_"][$id]["tries"];
	}
}
?>