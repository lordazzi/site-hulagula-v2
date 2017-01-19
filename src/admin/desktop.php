<?php
require_once("$_SERVER[DOCUMENT_ROOT]resource/config.php");
if (!$_SESSION["admin"]) { redirect("index.php"); }
if (!isChrome) { redirect("isntchrome.php"); }
# AUTHOR: RICARDO AZZI #
# CREATED: 12/04/13 #
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pizzaria Hula Gula</title>
		
		<!-- Meta Tags -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- CSS -->
        <link rel="stylesheet" href="/resource/css/normalize.css" />
        <link rel="less" href="/resource/css/admin.css" />
		
		<!-- plugins -->
        <script type="text/javascript" src="/resource/js/modernizr-2.6.2.min.js"></script><!-- ajustando HTML5 para browsers que não o suportam -->
        <script src="/resource/js/jquery-1.9.1.min.js"></script>
        <script src="/resource/js/less-1.3.3.min.js"></script>
        
		<!-- forms -->
		<link rel="stylesheet" href="/resource/js/forms/forms.1.0.3.css" />
        <script src="/resource/js/forms/forms.1.0.3.js"></script>
		
		<!-- filter -->
        <script src="/resource/js/class/filter.class.js"></script>

		<!-- highcharts -->
		<script src="/resource/js/highcharts/highcharts.js"></script>

		<!-- jquery ui -->
		<link rel="stylesheet" href="/resource/js/jqueryui/css/jquery-ui-1.9.2.custom.min.css" />
        <script src="/resource/js/jqueryui/js/jquery-ui-1.9.2.custom.min.js"></script>
		
		<!-- JS -->
        <script src="/resource/js/admin-general.js"></script>
		
		<!--[if gte IE 9]>
			<style type="text/css">
				.gradient-horizontal, .gradient-vertical {
					filter: none;
				}
			</style>
		<![endif]-->
		
		<script>
			$(function(){
				$(".icon").on("click", function(){
					var file = $(this).children(".image").data("load");
					$("#admin").load("modules/"+file+".php", function(){
						$.getScript("modules/"+file+".js");
					});
				});
			});
		</script>
	</head>
	<body>
		<div id="bandeja">
			<div class="icons-group">
				<span class="title">Sobre o Site</span>
				
				<div class="icon" id="admin-configurations">
					<div class="image inactive" title="Em desenvolvimento" title="Configurações"></div>
					<span class="subtitle">Configurações</span>
				</div>
				<div class="icon" id="admin-promocoes">
					<div class="image" title="Promoções da capa" data-load="win.promotion-config"></div>
					<span class="subtitle">Promoções<br />da capa</span>
				</div>
				<div class="icon" id="admin-theme">
					<div class="image inactive" title="Em desenvolvimento" title="Tema do site"></div>
					<span class="subtitle">Tema do site</span>
				</div>
				
				<div class="icon" id="admin-horario">
					<div class="image inactive" title="Em desenvolvimento" title="Quando é que a pizzaria esta e não está aberta?"></div>
					<span class="subtitle">Quando abrimos?</span>
				</div>
				<div class="icon" id="admin-feriados">
					<div class="image inactive" title="Em desenvolvimento" title="Configurar feriados"></div>
					<span class="subtitle">Feriados</span>
				</div>
			</div>
			<div class="icons-group">
				<span class="title">Sobre os Produtos</span>
				<div class="icon" id="admin-categorias">
					<div class="image inactive" title="Categorias dos produtos" data-load="win.categorias-config"></div>
					<span class="subtitle">Categorias<br />dos produtos</span>
				</div>
				<div class="icon" id="admin-produtos">
					<div class="image inactive" title="Em desenvolvimento" title="Informações dos produtos"></div>
					<span class="subtitle">Informações<br />dos produtos</span>
				</div>
				<div class="icon" id="admin-precos">
					<div class="image" title="Preços dos produtos" data-load="win.produtos-precos"></div>
					<span class="subtitle">Preços<br />dos produtos</span>
				</div>
			</div>
			<div class="icons-group">
				<span class="title">Sobre meus Clientes</span>
				<div class="icon" id="admin-visitantes">
					<div class="image" title="Visitantes do site" data-load="win.relatorio-de-visitas"></div>
					<span class="subtitle">Visitantes<br />do site</span>
				</div>
				<div class="icon" id="admin-mensagens">
					<div class="image inactive" title="Em desenvolvimento" title="Mensagens dos clientes"></div>
					<span class="subtitle">Mensagens<br />dos clientes</span>
				</div>
			</div>
			<div class="icons-group">
				<span class="title">Sistema</span>
				<div class="icon" id="admin-documentation">
					<div class="image inactive" title="Em desenvolvimento" title="Como usar o sistema"></div>
					<span class="subtitle">Como usar<br />o sistema</span>
				</div>
				<div class="icon" id="admin-logout">
					<div class="image" title="Sair do Sistema"></div>
					<span class="subtitle">Sair<br />do Sistema</span>
				</div>
			</div>
		</div>
		<div id="admin"></div>
	</body>
</html>