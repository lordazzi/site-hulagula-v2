<?php
/** constantes */
define("isIE", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE"));
define("isIE6", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 6"));
define("isIE7", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 7"));
define("isIE8", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 8"));
define("isIE9", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 9"));
define("isIE10", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 10"));

define("isFirefox", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "firefox"));
define("isOpera", (stristr($_SERVER["HTTP_USER_AGENT"], "opera") or stristr($_SERVER["HTTP_USER_AGENT"], "presto")));

define("isWebKit", (bool) stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit"));
define("isSafari", (stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit") and stristr($_SERVER["HTTP_USER_AGENT"], "Gecko) Version")));
define("isChrome", (stristr($_SERVER["HTTP_USER_AGENT"], "AppleWebKit") and stristr($_SERVER["HTTP_USER_AGENT"], "Gecko) Chrome")));

/** da utf8_decode nas informações se for necessario */
function decode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	if ($enc == "UTF-8") {
		$string = utf8_decode($string);
	}
	return $string;
}

/** da utf8_encode nas informações se for necessario */
function encode($string) {
	$enc = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
	if ($enc == "ISO-8859-1") {
		$string = utf8_encode($string);
	}
	return $string;
}

/** dá utf8_encode em todo um array */
function array_encode($arr) {
	if ($arr <> FALSE and gettype($arr) == "array") {
		foreach ($arr as &$ar) {
			if (gettype($ar) == "array") {
				$ar = array_encode($ar);
			} else if (gettype($ar) == "string") {
				$ar = encode($ar);
			}
		}
		return $arr;
	} else {
		return array();
	}
}

/** Dá um callback do PHP para o Javascript em json */
function callback($array = array()) {
	echo(json_encode(array_encode($array))); exit();
}

/**
	Caso a informação não venha de um post() ou get()
	ou caso esteja dentro de um array, esta função
	faz as alterações que um post() ou get() faria
*/
function adjust($value, $tags = FALSE) {
	if (!$tags) {
		return strip_tags(trim(str_replace("'", "´", $value)));
	} else {
		return trim(str_replace("'", "´", $value));
	}
}

/** trabalhando com o post */
function post($post = FALSE, $tags = FALSE) {
	if ($post <> FALSE) {
		return adjust($_POST[$post]);
	} else {
		return $_POST;
	}
}

/** trabalhando com o get */
function get($get = FALSE, $tags = FALSE) {
	if ($get <> FALSE) {
		return adjust($_GET[$get]);
	} else {
		return $_SERVER["QUERY_STRING"];
	}
}

/** forçando redirecionamento */
function redirect($to) {
	header("location: $to");
	echo("
		<script type='text/javascript'>
			window.location.ref = '$to';
		</script>
	");
}

/** Cria uma pasta com suas subpastas no caso desta não existir */
function mksubdir($newdir, $chmod = 0777) {
	$dirs = explode("/", $newdir);
	$complete = "";
	foreach ($dirs as $dir) {
		if (!is_dir($complete.$dir) AND !($dir == ".." OR $dir == "")) {
			if (!mkdir($complete.$dir, $chmod)) {
				return FALSE; //sem permissão de usuário para criar pasta
			}
		}
		$complete .= $dir."/";
	}
	return $complete;
}

/** Pega a extenção do arquivo */
function get_file_extension($file) {
	$file = explode(".", $file);
	return $file[count($file) - 1];
}

/** Função que remove os acentos das strings */
function unaccent($str) {
	return strtr(decode($str), decode("ÁÂÀÄÃáâàäãÉÊÈËéêèëÍÎÌÏíîìïÓÔÒÖÕóôòöõÚÛÙÜúûùüÇçÑñ"), "AAAAAaaaaaEEEEeeeeIIIIiiiiOOOOOoooooUUUUuuuuCcNn");
}
?>