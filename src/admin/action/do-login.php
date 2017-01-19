<?php
require_once($_SERVER["DOCUMENT_ROOT"]."resource/config.php");
# AUTHOR: RICARDO AZZI #
# CREATED: 12/04/13 #

$sql = new MySql();
if (Captcha::Match("admin-login-captcha")) {
	if ($_POST["login"] AND $_POST["senha"]) {
		$infos = $sql->Query("SELECT 1 AS callback FROM admin WHERE login='".post("login")."' AND senha='".MD5(post("senha"))."'", TRUE);

		if ($infos["callback"] == TRUE) {
			$_SESSION["admin"] = TRUE;
			callback(array(
				"success" => TRUE
			));
		} else {
			$sql->Query("INSERT INTO admin_tries (useragent, ip, date) VALUES ('$_SERVER[HTTP_USER_AGENT]', '".System::getIp()."', '".date("Y-m-d")."')");
			callback(array(
				"success" => FALSE,
				"msg" => "Login ou senha incorreto."
			));
		}
	} else {
		$sql->Query("INSERT INTO admin_tries (useragent, ip, date) VALUES ('$_SERVER[HTTP_USER_AGENT]', '".System::getIp()."', '".date("Y-m-d")."')");
		callback(array(
			"success" => FALSE,
			"msg" => "Você deve preencher o campo de login e senha!"
		));
	}
} else {
	$sql->Query("INSERT INTO admin_tries (useragent, ip, date) VALUES ('$_SERVER[HTTP_USER_AGENT]', '".System::getIp()."', '".date("Y-m-d")."')");
	callback(array(
		"success" => FALSE,
		"msg" => "Captcha Incorreto! Favor digite as letras corretamente."
	));
}
?>