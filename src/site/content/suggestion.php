<?
require_once("../conn.php");
define("FRASE_DE_INTRUCAO", "Envie suas ideias, criticas e sugestões para nós!");

if ($_POST["send_suggestion"]) {
	if ($_POST["suggestion_content"] != "" AND $_POST["suggestion_content"] != FRASE_DE_INTRUCAO) {
		//Localizando o país pelo IP
		$ip = getip();
		$browser = getbrowser();
		$so = getos();
		$suggestion = addslashes($_POST["suggestion_content"]);
		mysql_query("INSERT INTO suggestion (ip, browser, so, suggestion, datetime) VALUES ('$ip', '$browser', '$so', '$suggestion', '".date("Y-m-d H:i:s")."')");
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<!-- Título -->
		<title>Alfacey: converse com estranhos!</title>

		<!-- Estilo -->
		<link rel="stylesheet" type="text/css" href="../../plugins/css/style.css" />
		<? if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE") !== false)
		{ echo "<link rel='stylesheet' type='text/css' href='../../plugins/css/explorer.css' />"; } ?>

		<!-- Meta -->
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<!-- JavaScript -->
		<script language="javascript" type="text/javascript">
			function myRealStyle(myId) {
				document.getElementById(myId).style.color = "#000000";
				document.getElementById(myId).style.fontStyle = "normal";
				if (document.getElementById(myId).value == "<? echo FRASE_DE_INTRUCAO; ?>") {
					document.getElementById(myId).value = "";
				}
			}

			function myEffectStyle(myId) {
				if (document.getElementById(myId).value == "") {
					document.getElementById(myId).style.color = "#999999";
					document.getElementById(myId).style.fontStyle = "italic";
					document.getElementById(myId).value = "<? echo FRASE_DE_INTRUCAO; ?>";
				}
			}
		</script>
	</head>
	<body style="overflow: hidden; background-image: none; background-color: red;">
		<?
			if ($_POST["send_suggestion"]) {
				echo "<span class='suggestion'>Obrigado pelo sua cooperação! Sua sugestão foi arquivada!</span>
				
					<script type='text/javascript'>
						setTimeout('refreshme()', 4000);
						function refreshme() {
							window.location.href = 'suggestion.php';
						}
					</script>
				";
				exit;
			}
		?>
		<div id="suggestion">
			<form method="POST" action="">
				<textarea name="suggestion_content" id="suggestion_content" maxlength="255" onblur="myEffectStyle('suggestion_content');" onfocus="myRealStyle('suggestion_content');"><? echo FRASE_DE_INTRUCAO; ?></textarea><br />
				<input type="submit" value="Enviar sugestão" name="send_suggestion" />
			</form>
		</div>
	</body>
</html>