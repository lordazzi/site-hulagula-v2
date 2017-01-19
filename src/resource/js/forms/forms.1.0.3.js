/*
	Color picker map from:
		http://www.w3schools.com/tags/ref_colorpicker.asp
*/

var RESOURCE_PATH = "/resource/js/forms/";

var ptbr = {
	00: "O campo está válido",
	01: "O campo não pode ser nulo",
	02: "Digite pelo menos {$minlength} caracteres",
	03: "Os dois campos não combinam",
	04: "Isso não é um telefone",
	05: "O campo de prefixo está incompleto",
	06: "Isso não é um CEP",
	07: "Isso não é um e-mail",
	08: "O valor digitado não é válido",
	09: "Isso não é um número válido",
	101: "Ok",
	102: "Cancelar",
	103: "Mais",
	104: "Básico"
}

var enus = {
	00: "The field is valid",
	01: "The field can't be null",
	02: "Enter at least {$minlength} characters",
	03: "Both fields don't match",
	04: "This is not a phone",
	05: "The prefix field is incomplete",
	06: "This is not a zip code",
	07: "This is not an e-mail",
	08: "The value you entered is not valid",
	09: "This is not a valid number",
	101: "Ok",
	102: "Cancel",
	103: "More",
	104: "Basic"
}

var eses = {
	00: "El campo es válida",
	01: "El campo no puede ser nulo",
	02: "Ingrese al menos {$minlength} caracteres",
	03: "Los dos campos no coinciden",
	04: "Esto no es un teléfono",
	05: "El campo de prefijo es incompleto",
	06: "Esto no es un código postal",
	07: "Esto no es un correo electrónico",
	08: "El valor que introdujo no es válido",
	09: "Esto no es un número válido",
	101: "Ok",
	102: "Cancelar",
	103: "Más",
	104: "Básico"
}

/*
	- adicionar eskema de validações externas: como e-mail ou login já existes (são coisas que a classe não pode fazer)
	- verficar se é a primeira vez que os campos estão sendo validados (validação onload)
	- verificar se é o ultimo campo do formulario
*/

var Forms = (function(args){
	//	obrigatórios
	if (args == undefined) { return; }
	if (args.id == undefined) { return; }
	if (args.lang == undefined) { // language library
		var lang = navigator.language || navigator.browserLanguage || "";
		lang = lang.toLowerCase();
		switch(lang) {
			case "en":
			case "en-us":
				args.lang = enus;
				break;
			case "es-es":
				args.lang = eses;
				break;
			case "pt-br":
			default:
				args.lang = ptbr;
				break;
		}
	}
	
	//	elemento jQuery do formulário
	var $JQueryEl = $("#"+args.id);
	
	//	defaults
	args.url = args.url || $JQueryEl.attr("action");
	args.method = args.method || $JQueryEl.attr("method") || "get";
	args.add = args.add || {};
	args.autostart = args.autostart || true; //	exerce uma verificação inicial quando o formulário é carregado
	args.action = args.action || (function(){ return; });
	args.success = args.success || (function(){ return; });
	
	if (!args.evt || args.evt == "blur" || args.evt == "focus") {
		args.evt = "blur focus";
	} else {
		args.evt = "keydown change"; // I put change because there is no sense keydown for a select box ;P
	}
	/*
		No caso de browsers antigos, os elementos em html5 não funcionam,
		a classe forms irá altera-los automaticamente para manter a compatibilidade
		do formulário, porém isso vai fazer com que a aparencia dos antigos fiquem
		diferente das dos atuais e os atuais vão ficar diferente entre si, uma vez
		que cada um criou seus campos da forma como desejou.
		
		A configuração 'ignoreBrowser' vem por padrão como 'true' e vai substituir
		alguns elementos do html5 por elementos que fazem a mesma função (em todos
		os browsers), garantindo um formulário igual em todos os browsers.
	*/
	args.ignoreBrowser = (args.ignoreBrowser == undefined) ? (true) : (args.ignoreBrowser);
	
	//	atributos privados
	var self = this;
	var submits = $JQueryEl.find("[data-type='submit'], [type='submit']").add("[data-type='submit'][form='"+args.id+"'], [type='submit'][form='"+args.id+"']");
	var basicColors = ["#003366", "#336699", "#3366CC", "#003399", "#000099", "#0000CC", "#000066", "#006666", "#006699", "#0099CC", "#0066CC", "#0033CC", "#0000FF", "#3333FF", "#333399", "#669999", "#009999", "#33CCCC", "#00CCFF", "#0099FF", "#0066FF", "#3366FF", "#3333CC", "#666699", "#339966", "#00CC99", "#00FFCC", "#00FFFF", "#33CCFF", "#3399FF", "#6699FF", "#6666FF", "#6600FF", "#6600CC", "#339933", "#00CC66", "#00FF99", "#66FFCC", "#66FFFF", "#66CCFF", "#99CCFF", "#9999FF", "#9966FF", "#9933FF", "#9900FF", "#006600", "#00CC00", "#00FF00", "#66FF99", "#99FFCC", "#CCFFFF", "#CCCCFF", "#CC99FF", "#CC66FF", "#CC33FF", "#CC00FF", "#9900CC", "#003300", "#009933", "#33CC33", "#66FF66", "#99FF99", "#CCFFCC", "#FFFFFF", "#FFCCFF", "#FF99FF", "#FF66FF", "#FF00FF", "#CC00CC", "#660066", "#336600", "#009900", "#66FF33", "#99FF66", "#CCFF99", "#FFFFCC", "#FFCCCC", "#FF99CC", "#FF66CC", "#FF33CC", "#CC0099", "#993399", "#333300", "#669900", "#99FF33", "#CCFF66", "#FFFF99", "#FFCC99", "#FF9999", "#FF6699", "#FF3399", "#CC3399", "#990099", "#666633", "#99CC00", "#CCFF33", "#FFFF66", "#FFCC66", "#FF9966", "#FF6666", "#FF0066", "#CC6699", "#993366", "#999966", "#CCCC00", "#FFFF00", "#FFCC00", "#FF9933", "#FF6600", "#FF5050", "#CC0066", "#660033", "#996633", "#CC9900", "#FF9900", "#CC6600", "#FF3300", "#FF0000", "#CC0000", "#990033", "#663300", "#996600", "#CC3300", "#993300", "#990000", "#800000", "#993333"];
	/*
		Constantes de compatibilidade
	*/
	var userAgent = navigator.userAgent || "Mozilla/4.0 (compatible; MSIE 6.0; ?)";
	var isIE = (userAgent.indexOf("MSIE") != -1);
	var isIE6 = (userAgent.indexOf("MSIE 6") != -1);
	var isIE7 = (userAgent.indexOf("MSIE 7") != -1);
	var isIE8 = (userAgent.indexOf("MSIE 8") != -1);
	var isIE9 = (userAgent.indexOf("MSIE 9") != -1);
	var isIE10 = (userAgent.indexOf("MSIE 10") != -1);
	var isFirefox = (userAgent.indexOf("Firefox") != -1);
	var isWebKit = (userAgent.indexOf("AppleWebKit") != -1);
	var isChrome = (userAgent.indexOf("Gecko) Chrome/") != -1 && userAgent.indexOf("AppleWebKit") != -1);
	var isSafari = (userAgent.indexOf("Gecko) Version/") != -1 && userAgent.indexOf("AppleWebKit") != -1);
	var isOpera = (userAgent.indexOf("Opera") != -1 && userAgent.indexOf("Presto") != -1);
	
	//	atributos públicos
	self.els = [];
	
	/*	método que representa o construtor
	
		O método construtor no javascript é tudo o que é executado diretamente
		dentro da classe, uma coisa bem fora do comum comparado com outras linguagens.
		Se eu executar as ações do construtor no inicio da classe javascript, o
		construtor não irá enxergar os métodos da classe, por que eles só serão criados
		depois que o construtor for executado, por isso eu criei uma função __construct()
		que é executada no final da classe, quando todas os métodos já foram criados
	*/
	var __construct = (function(){
		var els = $JQueryEl.find("[type]:not([type='submit']), [data-type]:not([data-type='submit'])");
		els.each(function(i){
			self.els[self.els.length] = new HtmlElement($(this), {
				/*
					evento que será executado no elemento, o último elemento
					deve ter o evento keydown/change, para que o botão submit
					seja habilitado antes que o usuário retire o foco de dentro
					dele
				*/
				evt: (els.length == i+1) ? ("keydown change") : (args.evt),
				autostart: args.autostart, //	exercer uma validação assim que o formulário terminar de carregar
				action: args.action, //	ação de validação
				each: each
			});
		});
	});
	
	submits.click("click", function(){
		if ($(this).attr("disabled") != "disabled") {
			var json = {};
			//	formaction é um atributo HTML5 para o botão submit, ele altera o arquivo para onde o formulário deve enviar as informações
			var url = $(this).attr("formaction") || args.url;
			//	formmethod é um atributo HTML5 para o botão submit, ele altera a forma como as informações são enviadas para o servidor
			var method = $(this).attr("formmethod") || args.method;
			
			$JQueryEl.find("[name]:not([data-type='submit'],[type='submit'])").each(function(){
				json[$(this).attr("name")] = $(this).val();
			});
			
			//	itens adicionais
			for (i in args.add) { json[i] = args.add[i]; }
			
			$.ajax({
				type: method,
				url: url,
				data: json,
				success: args.success
			});
		}
		
		return false;
	});
	
	var each = (function(){
		var isvalid = true;		for (i = 0; i < self.els.length; i++) {
			if (self.els[i].status == false) { isvalid = false; }
		}
		
		if (!isvalid) {
			submits.attr("disabled", "disabled");
		} else {
			submits.removeAttr("disabled");
		}
	});
	
	self.getConfiguration = (function(){
		var elements = $JQueryEl.find("[name]");
		var json = {};
		elements.each(function(){
			var nome = $(this).attr("name");
			json[nome] = {};
			if ($(this)[0].nodeName == "INPUT" || $(this)[0].nodeName == "TEXTAREA" || $(this)[0].nodeName == "DATALIST") {
				if ($(this).attr("required") == "required") { json[nome].required = true; }
				
				if ($(this).data("equal")) { json[nome].equal = $(this).data("equal"); }
				
				if ($(this).attr("pattern")) { json[nome].pattern = $(this).attr("pattern"); }
				
				if ($(this).attr("maxlength")) { json[nome].maxlength = $(this).attr("maxlength"); }
				
				if ($(this).data("minlength")) { json[nome].minlength = $(this).data("minlength"); }
				
				var type = $(this).data("type") || $(this).attr("type") || "";
				var ignore = ["text", "button", "reset", "hidden", "search", "password", "checkbox", "radio", ""];
				var minmax = ["range", "date", "datetime", "datetime-local", "timestamp"];
				var accept = ["checkbox", "radio"];
				
				if (ignore.indexOf(type) == -1) {
					json[nome].type = type;
				}
				
				if (minmax.indexOf(type) == -1) {
					if ($(this).attr("min")) { json[nome].min = $(this).attr("min"); }
					if ($(this).attr("max")) { json[nome].max = $(this).attr("max"); }
				}
				
				if (accept.indexOf(type) == -1) {
					json[nome].accept = new Array();
					$("[name='"+$(this).attr("name")+"']").each(function(){

						if (!$(this).attr("disabled")) {
							json[nome].accept[json[nome].accept.length] = $(this).attr("value");
						}
					});
				}
				
				if (type == "radio") { json[nome].required = true; }
			} else if ($(this)[0].nodeName == "SELECT") {
				json[nome].accept = new Array();
				$(this).find("option").each(function(){
					if (!$(this).attr("disabled")) {
						json[nome].accept[json[nome].accept.length] = $(this).attr("value");
					}
				});
			}
		});
		
		console.log(JSON.stringify(json));
	});
	
	//	default das funções que utilizam verificação de número (int, uint, float, ufloat)
	var keyIsNumber = (function(Event){
		if ((Event.keyCode == 8 || Event.keyCode == 46 || //backspace e delete
		Event.keyCode >= 96 && Event.keyCode <= 105 || //teclas do numlock
		Event.keyCode >= 48 && Event.keyCode <= 57 || //números ali em cima
		Event.keyCode >= 33 && Event.keyCode <= 40 || //outras teclas e setas
		Event.keyCode == 47) && //outras teclas
		Event.shiftKey == false || Event.ctrlKey == true || //teclas auxiliares
		Event.keyCode >= 37 && Event.keyCode <= 40 && Event.shiftKey == true ||
		Event.keyCode == 9) {
			return true;
		} else {
			return false;
		}
	});
	
	self.Int = (function(Event){
		if (keyIsNumber(Event)) { //teclas auxiliares
			return true;
		} else if ((Event.keyCode == 189 && Event.shiftKey == false) || Event.keyCode == 109) {
			return true;
		} else {
			return false;
		}
	});
	
	self.UInt = (function(Event){
		if (keyIsNumber(Event)) { //teclas auxiliares
		   return true;
		} else {
		   return false;
		}
	});
	
	self.Float = (function(Event){
		if (keyIsNumber(Event)) { //teclas auxiliares
		   return true;
		} else if ((Event.keyCode == 188 || Event.keyCode == 190 || Event.keyCode == 110 || Event.keyCode == 194) && Event.shiftKey == false) {
			return true;
		} else if ((Event.keyCode == 189 && Event.shiftKey == false) || Event.keyCode == 109) {
			return true;
		} else {
			return false;
		}
	});
	
	self.UFloat = (function(Event){
		if (keyIsNumber(Event)) { //teclas auxiliares
			return true;
		} else if ((Event.keyCode == 188 || Event.keyCode == 190 || Event.keyCode == 110 || Event.keyCode == 194) && Event.shiftKey == false) {
			return true;
		} else {
			return false;
		}
	});
	
	self.Equal = (function(Event){
		if (Event.ctrlKey == true && Event.keyCode == 86) { return false; }
	});
	
	//	impede que o usuário digite valores inválidos, a medida do possível
	var soul = (function(el){
		//	se este campo deve ser igual a outro: como em confirmação de e-mail ou senha
		if (el.data("equal")) {
			el.attr("autocomplete", "off"); //	isso vai impedir que o chrome complete automaticamente o e-mail
			el.on("keydown", self.Equal);
			el.on("contextmenu", function(){ return false; });
		}
		
		var type = el.attr("data-type") || el.attr("type");
		
		switch(type) {
			case "":
			case "text":
			case "range":
			case "button":
			case "radio":
			case "checkbox":
			case "reset":
			case "hidden":
			case "search":
			case "password":
				break;
			case "telprefix":
				el.attr("maxlength", 2);
				el.on("keydown", self.UInt);
				el.attr("type", "tel");
				break;
			case "smalltel":
				el.attr("maxlength", 9);
				el.on("keydown", self.UInt);
				el.attr("type", "tel");
				break;
			case "mediumtel":
				el.attr("maxlength", 11);
				el.on("keydown", self.UInt);
				el.attr("type", "tel");
				break;
			case "tel":
				el.attr("maxlength", 13);
				el.on("keydown", self.UInt);
				el.attr("type", "tel");
				break;
			case "timestamp":
				el.attr("type", "datetime-local");
				var date = new Date(0);
				el.attr("min", date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate());
			case "cep":
				el.attr("type", "text");
				el.attr("data-type", "cep");
				el.attr("maxlength", 8);
				el.on("keydown", self.UInt)
			case "int":
				el.on("keydown", self.Int);
				el.attr("data-type", "int");
				break;
			case "uint":
			case "number":
				el.on("keydown", self.UInt);
				el.attr("data-type", "uint");
				break;
			case "float":
				el.on("keydown", self.Float);
				el.attr("data-type", "float");
				break;
			case "ufloat":
				el.on("keydown", self.UFloat);
				el.attr("data-type", "ufloat");
				break;
			case "day":
				el.on("keydown", self.Uint);
				el.attr("type", "number");
				el.attr("data-type", "day");
				el.attr("min", 0);	
				el.attr("min", 31);	
			case "cpf":
				el.attr("type", "text");
				el.attr("data-type", "cpf");
				el.attr("maxlength", 11);
				el.on("keydown", self.UInt);
				break;
			case "cnpj":
				el.attr("type", "text");
				el.attr("data-type", "cnpj");
				el.attr("maxlength", 14);
				el.on("keydown", self.UInt);
				break;			case "color":
				if (!isChrome && !isOpera || args.ignoreBrowser) {
					var attrs = {};
					attrs["value"] = "#FFFFFF";
					for (i = 0; i < el[0].attributes.length; i++) {
						attrs[el[0].attributes[i]["name"]] = el[0].attributes[i]["value"];
					}
					attrs["type"] = "color";
					
					var $button = $("<button>", attrs);
					$button.addClass("forms-button-type-color");
					var $div = $("<div>");
					$div.appendTo($button);
					el.replaceWith($button);
					$button.update();
					el = $button;
					
					$button.on("click", function(){
						var cp = new self.ColorPicker({
							lang: args.lang,
							color: $button.val(),
							callback: function(color) {
								$button.val(color);
								$button.update();
							}
						});
						return false;
					});
					
					$button.on("change", function(){
						$div.css({
							"background-color": $(this).val()
						});
					});
				}
				break;
		}
	});
	
	var validate = (function(el, me){
		var type = el.attr("data-type") || el.attr("type");	//	pegando o tipo de validação, data-type é a prioridade, depois é type
		var required = (el.attr("required") != undefined) ? (true) : (false);	//	not null
		var minlength = parseFloat(el.data("minlength"));	// minlength
		var equal = el.data("equal");	//	verificando se há a necessidade de que este campo seja igual a outro
		var $equal = $("#"+equal);
		var pattern = el.attr("pattern");
		
		if (required == true && el.val() == "") {
			me.status = false;
			return {
				status: me.status,
				msg: args.lang[1], //	O campo não pode ser nulo
				code: 1
			};
		}
		
		if (minlength != 0 && el.val().length <= minlength) {
			me.status = false;
			return {
				status: me.status,
				msg: args.lang[2].replace("{$minlength}", minlength),
				code: 2 //	Digite pelo menos {$minlength} caracteres
			}
		}
		
		if (equal != undefined && $equal.length != 0 && el.val() != $equal.val()) {
			me.status = false;
			return {
				status: me.status,
				msg: args.lang[3],
				code: 3 //	Os dois campos não combinam
			}
		}
		
		if (pattern != undefined && !el.val().match(pattern) || el.val() == "") {	//	validação de nulo é feita em 'required'
			me.status = false;
			return {
				status: me.status,
				msg: args.lang[8],
				code: 8 //	O valor digitado não é válido
			}
		}
		
		switch(type) {
			case "":	// no caso de select e textarea
			case "radio":
			case "checkbox":
			case "text":
			case "range":
			case "button":
			case "reset":
			case "hidden":
			case "search":
			case "password":
				me.status = true;
				return {
					status: me.status,
					msg: args.lang[0],	//	Tudo ok
					code: 0
				};
				break;
			case "tel":
			case "mediumtel":
			case "smalltel":
				if (el.val().length < 8 && el.val() != "") {	// aqui ele pode ser nulo, se ele não pudesse, não teria passado na validação de require
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[4],//	"Isso não é um telefone",
						code: 4
					};
				} else {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "telprefix":
				if (el.val().length == 1) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[5],//	O campo de prefixo está incompleto
						code: 5
					}
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "cep":
				if (!el.val().match(/^[0-9]{8}$/)) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[6], //	Isso não é um CEP
						code: 6
					}
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					}
				}
			case "email":
				if (!el.val().match(/^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*[.]{1}[a-zA-Z]{2,4})+$/) || el.val() == "") {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[7], //	Isso não é um e-mail
						code: 7
					};
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "int":
				if (el.val().match(/^(-|)[0-9]*$/)) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[9], //	Isso não é um número válido
						code: 9
					};
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "uint":
				if (el.val().match(/^[0-9]*$/)) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[9], //	Isso não é um número válido
						code: 9
					};
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "float":
				if (el.val().match(/^(-|)([0-9][0-9]*)(|.[0-9])([0-9]*)$/)) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[9], //	Isso não é um número válido
						code: 9
					};
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
			case "ufloat":
				if (el.val().match(/^([0-9][0-9]*)(|.[0-9])([0-9]*)$/)) {
					me.status = false;
					return {
						status: me.status,
						msg: args.lang[9], //	Isso não é um número válido
						code: 9
					};
				} else {
					me.status = true;
					return {
						status: me.status,
						msg: args.lang[0],	//	Tudo ok
						code: 0
					};
				}
				break;
		}
	});
	
	//	criar compatibilidade para o datalist
	// date
	// timestamp
	// datetime
	// datetime-local
	// email
	// month
	// number
	// time
	// url
	// week

	//	cada elemento que será enviado no AJAX é um objeto HtmlElement
	var HtmlElement = (function(el, defaults){
		var parent = self;
		var self = this;
		
		this.status = false;
		
		var __construct = (function(){
			el.on(defaults.evt, function(){
				var info = validate(el, self);
				defaults.each();
				defaults.action(el, info.status, info.msg, info.code, false);
			});
			soul(el);
			
			//	fazendo uma validação inicial quando o formulário é carregado
			if (defaults.autostart == true) { 
				var info = validate(el, self);
				defaults.action(el, info.status, info.msg, info.code, true);
			}
		});
		
		__construct();
	});

	this.ColorPicker = (function(args){
		if (args == null) { return; }
		if (args.lang == null) { return; }
		args.colorpicker = args.colorpicker || "basic";
		args.color = args.color || "#000000";
		args.callback = args.callback || (function(){ return; });
		
		//	o atributo color é a div que contém tanto o seletor de cores básico, como o avançado
		var $color;
		var self = this;
		
		var __construct = (function(){
			//	criando background que bloqueia a tela antes que a cor seja selecionada
			var $block = $("<div>", {
				id: "forms-block-background"
			});
			
			//	carregando janela de sistema onde o usuário poderá fazer a seleção de uma cor
			$color = $("<div>", {
				"class": "forms-color-picker"
			});
			
			//	inserindo os elementos no DOM
			$color.appendTo($block);
			$block.appendTo("body");
			
			if (basicColors.indexOf(args.color.toUpperCase()) == -1) {
				loadPallete("advanced", configureAdvanced, args.color);
			} else {
				loadPallete("basic", configureBasic, args.color);
			}
		});
		
		var loadPallete = (function(type, onload, params) {
			onload = onload || (function(){});
			
			$color.load(RESOURCE_PATH+type+"-color-pallete.html", function(){
				//	configurando
				$color.find("[data-src]").each(function(){
					$(this).attr({
						"src": RESOURCE_PATH+$(this).data("src")
					});
				});
				
				$color.find("[data-language]").each(function(){
					$(this).text(args.lang[$(this).data("language")]);
				});
				
				$color.find("[data-href]").each(function(){
					$(this).attr({
						"href": RESOURCE_PATH+$(this).data("href")
					});
				});
				
				//	centralize
				$color.css({
					"top": Math.floor(($(window).height() / 2) - ($color.height() / 2)),
					"left": Math.floor(($(window).width() / 2) - ($color.width() / 2))
				});
				
				$(".forms-do-ok").on("click", function(){
					doOk($(this).data("color"));
				});
				$(".forms-do-cancel").on("click", doCancel);
				
				onload(params);
			});
		});
		
		//	o objetivo deste método é ir aos poucos convertendo uma cor em branco, para criar a barra a direita do seletor avançado de cor
		var getWhite = (function(myByte, em, total) {
			total = total || 15;
			myByte = parseFloat(myByte);
			return Math.floor(myByte + (255 - myByte) / total * em);
		});
		
		var getBlack = (function(myByte, em, total) {
			total = total || 15;
			myByte = parseFloat(myByte);
			return Math.round(myByte / total * em);
		});
		
		//	cria o seletor avançado de cores
		var configureAdvanced = (function(color){
			
			var __construct = (function() {
				selectColor(color);
			});
			
			$("#forms-selected-color").css({
				left: -3,
				top: -3
			});
			
			$("#forms-advanced-color-pallete tr td").on("click", function(){
				var $tableOffset = $("#forms-advanced-color-pallete").offset();
				var $offset = $(this).offset();
				
				$("#forms-selected-color").css({
					left: $offset.left - $tableOffset.left - 4,
					top: $offset.top - $tableOffset.top - 4
				});
				
				$colorBar = $("#forms-color-bar");
				$colorBar.children().remove();
				var color = $(this).attr("alt");
				var $div = $("<div>").addClass("forms-color-block").css({
					"background-color": color
				}).attr("alt", color).appendTo($colorBar);
				
				//	criando o menu que te permite escolher o quão escuro/claro você deseja que a cor seja
				var rgb = $(this).css("background-color").replace("rgb(", "").replace(")", "").replace(/[ ]/g, "").split(",");
				for (i = 1; i < 16; i++) {
					color = self.rgbToHex(getWhite(rgb[0], i), getWhite(rgb[1], i), getWhite(rgb[2], i));
					var $div = $("<div>").addClass("forms-color-block").css({
						"background-color": color
					}).attr("alt", color).prependTo($colorBar);
					$(".forms-do-ok").attr("data-color", color);
				}
				
				for (i = 14; i >= 0; i--) {
					color = self.rgbToHex(getBlack(rgb[0], i), getBlack(rgb[1], i), getBlack(rgb[2], i));
					var $div = $("<div>").addClass("forms-color-block").css({
						"background-color": color
					}).attr("alt", color).appendTo($colorBar);
				}
				
				setDarkness($(".forms-color-darkness-selector").css("top").replace("px", ""));
				selectColor($(this).attr("alt"));
			});
			
			//	movimentando a seta que indica quão escuro/claro a cor será
			$(".forms-color-darkness-selector").on("mousedown", function(EventDown){
				$selector = $(this);
				$("body").on("mousemove", function(Event){
					if (Event.which == 1) {
						var top = Event.clientY - $color.offset().top + (EventDown.offsetY || EventDown.originalEvent.layerY) - 20;
						if (top >= -2 && top <= 182) {
							setDarkness(top);
							$selector.css({
								"top": top
							});
						}
					} else {
						$("body").off("mousemove mouseup");
					}
				});
				
				$("body").on("mouseup", function(){
					$("body").off("mousemove mouseup");
				});
			});
			
			$("#forms-hexcolor").on("keyup", function(){
				if ($(this).val().length >= 5 && $(this).val().match(/^#[0-9A-Fa-f]{6}$/)) {
					selectColor($(this).val());
				}
			});
			
			$("#forms-go-to-basic").on("click", function(){
				doClear();
				loadPallete("basic", configureBasic, color);
			});
			
			var setDarkness = (function(top){
				return selectColor($($("#forms-color-bar").children()[floor(top + 2, 6) / 6]).attr("alt"));
			});
			
			var selectColor = (function(color){
				try {
					color = color.toUpperCase();
					$("#forms-hexcolor").val(color);
					$("#forms-selected-color-square").css({
						"background-color": color
					});
					$(".forms-do-ok").attr("data-color", color);
					return true;
				} catch (e) {
					return false;
				}
			});
			
			__construct();
		});
		
		//	cria o seletor básico de cores
		var configureBasic = (function(color){
			$("#forms-colormap area[shape='poly']").on("click", function(){
				$("#forms-selected-color").css({
					"display": "block"
				});
				
				var offset = {
					x: 19,
					y: 19
				};
				
				var coords = $(this).attr("coords");
				coords = coords.split(",");

				$("#forms-selected-color").css({
					position: "absolute",
					top: parseFloat(offset.y) + parseFloat(coords[1]),
					left: parseFloat(offset.x) + parseFloat(coords[10])
				});
				
				$(".forms-selected-color").css({
					"background-color": $(this).attr("alt")
				});
				
				$(".forms-do-ok").attr("data-color", $(this).attr("alt"));
			});
			
			$("#forms-colormap area[shape='poly'][alt='"+color.toUpperCase()+"']").trigger("click");
			
			$("#forms-go-to-advanced").on("click", function(){
				doClear();
				loadPallete("advanced", configureAdvanced, color);
			});
		});
		
		self.hexToRgb = (function(hex) {
			return {
				r: parseInt(hex.substr(1, 2), 16),
				g: parseInt(hex.substr(3, 2), 16),
				b: parseInt(hex.substr(5, 2), 16)
			};
		});
		
		self.rgbToHex = (function(r, g, b){
			if (g == undefined && b == undefined && typeof r == "string") {
				r = r.replace("rgb(", "").replace(")", "").replace(/[ ]/g, "").split(",");
				g = parseFloat(r[1]);
				b = parseFloat(r[2]);
				r = parseFloat(r[0]);
			}
			r = r.toString(16);
			g = g.toString(16);
			b = b.toString(16);
			
			r = (r.length == 2) ? (r) : ("0"+r);
			g = (g.length == 2) ? (g) : ("0"+g);
			b = (b.length == 2) ? (b) : ("0"+b);
			
			return "#"+r+g+b;
		});
		
		//	arredondamento diferente: floor(13, 5) = 10
		var floor = (function(number, base){
			base = base || 1;
			if (base == 0) {
				return number;
			} else {
				return number - (number % base);
			}
		});
		
		var doClear = (function(){
			$color.children().remove();
		});
		
		var doOk = (function(color){
			args.callback(color);
			doCancel();
		});
		
		var doCancel = (function(){
			$("#forms-block-background").remove();
		});
		
		__construct();
	});
	__construct();
});

/* Complementando o jQuery */
$.fn.update = (function(){
	var type = $(this).attr("type");
	switch(type) {
		case "color":
			$(this).find("div")[0].style.backgroundColor = $(this).val();
			break;
	}
});

/* Compatibilidade com IEs antigos */
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(obj, start) {
		 for (var i = (start || 0), j = this.length; i < j; i++) {
			 if (this[i] === obj) { return i; }
		 }
		 return -1;
	}
}