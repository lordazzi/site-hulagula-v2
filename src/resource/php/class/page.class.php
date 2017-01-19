<?php
# AUTHOR: RICARDO AZZI #

class Page {
	protected $root;

	private $args;
	private $files;
	private $tpl;
	private $time;
	
	public function __construct($files = array(), $args = array()) {
		$this->time = time();
		$this->args = $args;
		$this->files = $files;
		
		//	iniciando informações que devem ser colocadas no cabeçalho
		if ($this->files["header"]) {
			if ($this->args["cache"] === FALSE) {
				$header = file_get_contents($_SERVER["DOCUMENT_ROOT"].$this->root.$this->files["header"]);
				$header = str_replace(".js", ".js?_=$this->time", $header);
				$header = str_replace(".css", ".css?_=$this->time", $header);
				echo($header);
			} else {
				require_once($_SERVER["DOCUMENT_ROOT"].$this->root.$this->files["header"]);
			}
		}
		
		if ($this->args["cache"] === FALSE) { $cache = "?_=$this->time"; }
		
		//	importando arquivos CSS ou LESS espelhados
		if ($this->args["css"] and !$this->args["less"]) {
			echo("\t<link rel='stylesheet' href='".$this->getMirror("css")."$cache' />\n");
		}
		
		if ($this->args["less"]) {
			if ($this->args["cache"] === FALSE) {
				echo("\t<link rel='stylesheet' href='".$this->getMirror("less")."&_=$this->time' />\n");
			} else {
				echo("\t<link rel='stylesheet' href='".$this->getMirror("less")."' />\n");
			}
		}
		
		//	importando CSS de compatibilidade para todas as páginas
		if (is_array($this->args["main"]["css"])) {
			$this->doCompatibility("css", $this->args["main"]["filebase"], $this->args["main"]["css"]);
		}
		
		//	importando LESS de compatibilidade para todas as páginas
		if (is_array($this->args["main"]["less"])) {
			$this->doCompatibility("less", $this->args["main"]["filebase"], $this->args["main"]["less"]);
		}
		
		//	importando CSS de compatibilidade
		if (is_array($this->args["css"]) and $this->args["css"] == TRUE) {
			$this->doCompatibility("css");
		}
		
		//	importando LESS de compatibilidade
		if (is_array($this->args["less"]) and $this->args["less"] == TRUE) {
			$this->doCompatibility("less");
		}
		
		//	adicionando classes em JavaScript que eu criei
		if (is_array($this->args["js"])) {
			foreach ($this->args["js"] AS $add) {
				switch($add) {
					case "jqueryui":
						echo("\t<script src='resource/js/jquery-ui-1.10.2.custom.js$cache'></script>\n");
						echo("\t<link rel='stylesheet' href='resource/css/jquery-ui-1.10.2.custom.css$cache' />\n");
						break;
					
					case "forms":
						echo("\t<script src='resource/js/forms/forms.1.0.3.js$cache'></script>\n");
						echo("\t<link rel='stylesheet' href='resource/js/forms/forms.1.0.3.css$cache' />\n");
						break;
						
					default:
						echo("\t<script src='/resource/js/classes/$add.class.js$cache'></script>\n");
						break;
				}
			}
		}
		
		//	importando o arquivo javascript espelhado
		if ($this->args["js"]) {
			$js = $this->getMirror("js");
			echo("\t<script src='".$this->getMirror("js")."$cache'></script>\n");
		}
		
		//	encerrando cabeçalho e iniciando body
		if ($this->files["body"]) {
			require_once($_SERVER["DOCUMENT_ROOT"].$this->root.$this->files["body"]);
		}
		
		if ($this->args["html"]) {
			//	raintpl
			$this->tpl = new RainTPL();
			
			//	caminhos do cache
			$html = $this->getMirror("cache");
			mksubdir($_SERVER["DOCUMENT_ROOT"].$html[0]);	//	criando subpastas
			$this->tpl->cache_dir = $_SERVER["DOCUMENT_ROOT"].$html[0];
			
			//	caminho dos htmls
			$html = $this->getMirror("html");
			$this->tpl->tpl_dir = $_SERVER["DOCUMENT_ROOT"].$html[0];
			
			//	passando todas as configurações para o template
			if (is_array($this->args["html"])) {
				foreach ($this->args["html"] as $key => $tpl) {
					$this->tpl->assign($key, $tpl);
				}
			}
			$this->tpl->draw($html[1]);
		}
	}
	
	public function doCompatibility($type, $filebase = FALSE, $configs = FALSE) {
		$haystack = $_SERVER["HTTP_USER_AGENT"];
		$configs = ($configs) ? ($configs) : ($this->args[$type]);

		$cache = "";
		if ($this->args["cache"] === FALSE) { $cache = ($type == "css") ? ("?_=$this->time") : ("&_=$this->time"); }
		
		if (in_array("ie", $configs) and stristr($haystack, "MSIE")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie")) : ($this->getMirror($type, "ie.")))."$cache' />\n");
		}
		
		if (in_array("ie6", $configs) and stristr($haystack, "MSIE 6")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie6")) : ($this->getMirror($type, "ie6.")))."$cache' />\n");
		}
		
		if (in_array("ie7", $configs) and stristr($haystack, "MSIE 7")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie7")) : ($this->getMirror($type, "ie7.")))."$cache' />\n");
		}
		
		if (in_array("ie8", $configs) and stristr($haystack, "MSIE 8")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie8")) : ($this->getMirror($type, "ie8.")))."$cache' />\n");
		}
		
		if (in_array("ie9", $configs) and stristr($haystack, "MSIE 9")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie9")) : ($this->getMirror($type, "ie9.")))."$cache' />\n");
		}
		
		if (in_array("ie10", $configs) and stristr($haystack, "MSIE 10")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "ie10")) : ($this->getMirror($type, "ie10.")))."$cache' />\n");
		}
		
		if (in_array("webkit", $configs) and stristr($haystack, "AppleWebKit")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "webkit")) : ($this->getMirror($type, "webkit.")))."$cache' />\n");
		}
		
		if (in_array("chrome", $configs) and stristr($haystack, "AppleWebKit") and stristr($haystack, "Gecko) Chrome")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "chrome")) : ($this->getMirror($type, "chrome.")))."$cache' />\n");
		}
		
		if (in_array("safari", $configs) and stristr($haystack, "AppleWebKit") and stristr($haystack, "Gecko) Version")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "safari")) : ($this->getMirror($type, "safari.")))."$cache' />\n");
		}
		
		if (in_array("opera", $configs) and stristr($haystack, "opera") !== FALSE and stristr($haystack, "presto")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "opera")) : ($this->getMirror($type, "opera.")))."$cache' />\n");
		}
		
		if (in_array("firefox", $configs) and stristr($haystack, "firefox")) {
			echo("\t<link rel='stylesheet' href='".(($filebase) ? ($this->changeExtension($filebase, "css", "firefox")) : ($this->getMirror($type, "firefox.")))."$cache' />\n");
		}
	}
	
	protected function getMirror($type, $prefix = "") {
		switch($type) {
			case "html":
			case "cache":
				$path = explode("/", $_SERVER["SCRIPT_URL"]);
				$path[count($path) - 1] = "";
				$path = implode("/", $path);
				
				$doc = explode("/", $_SERVER["SCRIPT_NAME"]);
				$doc = explode(".", $doc[count($doc) - 1]);
				unset($doc[count($doc) - 1]);
				$doc = implode(".", $doc);

				return array("$this->root/mirror/$type$path", $doc);
				break;
			case "css":
			case "js":
				return "$this->root/mirror/$type".$this->changeExtension($_SERVER["SCRIPT_NAME"], $type, $prefix);
				break;
			case "less":
				$file = $_SERVER["SCRIPT_NAME"];
				return "/resource/css/style.php?f=".base64_encode($this->changeExtension("$this->root/mirror/css/".$_SERVER["SCRIPT_NAME"], "css", $prefix));
				break;
		}
	}
	
	private function changeExtension($file, $ext, $prefix = "") {
		$prefix = ($prefix <> "") ? ($prefix.".") : ($prefix);
	
		$file = explode(".", $file);
		$file[count($file) - 1] = $prefix.$ext;
		$file = implode(".", $file);
		
		return $file;
	}
	
	public function __destruct() {
		if ($this->files["footer"]) {
			require_once($_SERVER["DOCUMENT_ROOT"].$this->root.$this->files["footer"]);
		}
	}
}

?>