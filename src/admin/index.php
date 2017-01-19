<?php
require_once("$_SERVER[DOCUMENT_ROOT]/resource/config.php");
# AUTHOR: RICARDO AZZI #
# CREATED: 09/04/13 #
if($_SESSION["admin"]){ redirect("desktop.php"); }
if (!isChrome) { redirect("isntchrome.php"); }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pizzaria Hula Gula</title>
		
		<!-- Meta Tags -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- CSS -->
        <link rel="stylesheet" href="../resource/css/normalize.css" />
        <link rel="less" href="../resource/css/admin.css" />
		
		<!-- JS -->
        <script type="text/javascript" src="../resource/js/modernizr-2.6.2.min.js"></script><!-- ajustando HTML5 para browsers que não o suportam -->
        <script src="../resource/js/jquery-1.9.1.min.js"></script>
        <script src="../resource/js/less-1.3.3.min.js"></script>
        <script src="../resource/js/admin-general.js?Asafd"></script>
		
		<!-- PLUGINS -->
        <link rel="stylesheet" href="../resource/js/forms/forms.1.0.3.css" />
        <script src="../resource/js/forms/forms.1.0.3.js"></script>
		<script>
			$(function(){
				$("#admin-login [type='submit']").on("click", function(){
					$.ajax({
						url: "action/do-login.php",
						type: "POST",
						data: {
							login: $("#login").val(),
							senha: $("#senha").val(),
							"admin-login-captcha": $("#admin-login-captcha").val()
						},
						success: function(json) {
							console.log(json);
							json = JSON.parse(json);
							if (json.success == true) {
								window.location.href = "desktop.php";
							} else {
								msg.alert(json.msg);
							}
							var _ = Math.round(new Date().getTime()/1000);
							$('#admin-login-captcha-letters').attr('src', '/html5/resource/img/captcha.php?id=admin-login-captcha&_='+_);
						}
					});
					return false;
				});
				

				
				$("#forgot-password").addClass("ghost");
				
				asWindow({
					id: "admin-login"
				});
				
				asWindow({
					id: "forgot-password",
					neverClose: true
				});
			});
		</script>
		
		<!--[if gte IE 9]>
			<style type="text/css">
				.gradient-horizontal, .gradient-vertical {
					filter: none;
				}
			</style>
		<![endif]-->
    </head>
	<body>
		<div id="admin-login" class="window">
			<div class="window-title">Faça seu login e senha<div class="window-close">X</div></div>
			<div class="window-content">
				<div class="content">
					<form>
						<label for="login">Login:</label><input id="login" name="login" type="text" /><br />
						<label for="senha">Senha:</label><input id="senha" name="senha" type="password" /><br />
						<a href="javascript: $('#forgot-password').removeClass('ghost');">Esqueci minha senha</a><br />
						<br />
						<?php Captcha::getCaptcha("admin-login-captcha"); ?>
						<input type="submit" value="Entrar" /><br />
					</form>
				</div>
			</div>
		</div>
		
		<div id="forgot-password" class="window">
			<div class="window-title">Esqueceu sua senha?<div class="window-close">X</div></div>
			<div class="window-content">
				<div class="content">
					<form>
						<p>
							Escreve o Captcha e clique em Enviar.<br />
							O sistema irá enviar um e-mail para você<br />
							perguntando se você realmente fez uma<br />
							solicitação de alteração de senha.
						</p>
						<?php Captcha::getCaptcha("forgot-password-captcha"); ?>
						<input type="submit" value="Entrar" /><br />
					</form>
				</div>
			</div>
		</div>
	</body>
<html>