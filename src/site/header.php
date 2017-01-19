<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<!-- Título -->
		<title>Hula Gula</title>

		<!-- Estilo -->
		<link rel="stylesheet" type="text/css" href="../../plugins/css/style.css" />
		<?
		
		$brow = explode(" v.", getbrowser());
		$brow = $brow[1];
		
		if (getbrowser(FALSE) == "Internet Explorer" AND $brow < 9) {
			echo "<link rel='stylesheet' type='text/css' href='../../plugins/css/explorer.css' />";
		}
		
		elseif (getbrowser(false) == "Opera") {
			echo "<link rel='stylesheet' type='text/css' href='../../plugins/css/opera.css' />";
		}
		
		?>

		<!-- Meta -->
		<meta name="description" content="A pizzaria com melhores preço da região do Ipiranga!"/>
		<meta name="keywords" content="Hula Gula, pizza, pizzaria, mussarela, calabresa" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<? if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "MSIE"))
		{ echo "<meta http-equip='X-UA-Compatible' content='IE=9' />"; } ?>
		
		<!-- JavaScript -->
		<script type="text/javascript" src="../../plugins/js/jquery-1.7.1.js"></script>
		<!-- Nivo Slider -->
		<link rel="stylesheet" href="../../plugins/js/nivoslider/default.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../plugins/js/nivoslider/nivo-slider.css" type="text/css" media="screen" />
		<script type="text/javascript" src="../../plugins/js/nivoslider/jquery.nivo.slider.pack.js"></script>
		<script type="text/javascript">
		$(window).load(function() {
			$('#slider').nivoSlider();
		});
		
		function ieadjust () {
			//ajustando os erros do Internet Explorer com javascript
			document.getElementById("openclose").style.position = "fixed";
		}
		</script>
	</head>
	<body onload="ieajust()">
		<div id="container">
			<div id="header">
				<span>
					<img src="../../plugins/img/logo.png" class="logo" />
				</span>
				<img src="../../plugins/img/extra.png" style="position: absolute; z-index: 99;" />
				<div class="slider-wrapper theme-default" style="width: 656px; float: right; height: 200px;">
					<div id="slider" class="nivoSlider">
						<? 
							$ponteiro  = @opendir("../../arquivo/foto_pizza");
							while ($nome_itens = readdir($ponteiro)) {
								if ($nome_itens != "." AND $nome_itens != ".." AND $nome_itens != "Thumbs.db") {
									if (@file_exists("../../arquivo/foto_pizza/".$nome_itens)) {
										echo "<IMG src='../../arquivo/foto_pizza/".$nome_itens."' />";
										echo "<!-- ../../arquivo/foto_pizza/".$nome_itens." -->";
									}
								}
							}
						?>
					</div>
				</div>
			</div>