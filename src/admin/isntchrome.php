<?php
require_once("$_SERVER[DOCUMENT_ROOT]resource/config.php");
if (!$_SESSION["admin"]) { redirect("index.php"); }
if (isChrome) { redirect("index.php"); }
# AUTHOR: RICARDO AZZI #
# CREATED: 23/07/13 #
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pizzaria Hula Gula</title>
		
		<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
		<!-- CSS -->
        <link rel="stylesheet" href="/resource/css/normalize.css" />
        <link rel="less" href="/resource/css/admin.css" />
		
		<!-- JS -->
		<script src="/resource/js/jquery-1.9.1.min.js"></script>
        <script src="/resource/js/less-1.3.3.min.js"></script>
		<script src="/resource/js/admin-general.js"></script>
		<script>
			$(function(){
				asWindow({ id: "is-not-chrome" });
			});
		</script>
	</head>
	<body style="background-image: url('/resource/img/no-signal.gif');background-repeat: repeat;">
		<div class="window" id="is-not-chrome">
			<div class="window-title">Erro<div class="window-close">X</div></div>
			<div class="window-content">
				<div class="content">
					A área administrativa do site foi desenvolvida para<br />
					rodar no Google Chrome, você está utilizando um browser<br />
					diferente, baixe o Google Chrome
					<a href="https://www.google.com/intl/en/chrome/browser/" target="_blank">clicando aqui</a>
				</div>
			</div>
		</div>
	</body>
</html>