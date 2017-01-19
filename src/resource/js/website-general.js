/** FUNÇÕES */
var userAgent = navigator.userAgent || "Mozilla/4.0 (compatible; MSIE 6.0; ?)"
/**
	Constantes de compatibilidade
*/
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

var setCookie = (function(indexagem,valor,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(valor) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=indexagem + "=" + c_value;
});

var getCookie = (function(indexagem) {
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++) 	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==indexagem) {
			return unescape(y);
		}
	}
});

var get = (function(index){
	var query_string = document.location.href.split("#")[0].split("?")[1];
	if (index == null || index == "?") {
		return query_string;
	} else {
		if (query_string != null) {
			var vars = query_string.split("&");
			var gets = new Array();
			for (i = 0; i < vars.length; i++) {
				vars[i] = vars[i].replace("=", "<-------------->");
				vars[i] = vars[i].split("<-------------->");
				if (vars[i][0] == index) {
					return vars[i][1];
					break;
				}
			}
			return;
		}
	}
});

var timestamp = (function() {
	return Math.round(new Date().getTime()/1000);
});

$(function(){
	//	seu browsers é antigo de mais
	if (isIE && !isIE10) {
		$('<p class="chromeframe">' + 
			'Você está utilizando um navegador <strong>antigo</strong>.' + 
			'Por favor <a target="_blank" href="http://browsehappy.com/">' + 
			'atualize seu navegador</a> ou ' + 
			'<a target="_blank" href="http://www.google.com/chromeframe/?redirect=true">' + 
			'ative o Google Chrome Frame</a> para melhorar sua navegação.' + 
		'</p>').prependTo("body");
	}
	
	/** ANIMAÇÕES */
	if (getCookie("animated") == null) {
		//	//	//
		var distance = Math.floor($(window).height() / 3);
		$("#menu").animate({
			top: distance + 50
		}, 750, function(){
			//	//	//
			$("#menu").animate({
				top: distance
			}, 250);
			
			//	//	//
			var $JQueryEls = new Array();
			$("#menu li").each(function(i){
				$JQueryEls[$JQueryEls.length] = this;
			});
			$JQueryEls.reverse();
			
			executeme = (function(j){
				setTimeout(function(){
					//	//	//
					$($JQueryEls[j]).animate({
						padding: "4px 10px 4px 30px"
					}, 50, function(){
						$($JQueryEls[j]).animate({
							padding: "4px 10px 4px 10px"
						}, 50);
					});
				}, j * 100);
			});
			
			//	//	//
			for (j = $JQueryEls.length - 1; j > -1; j--) {
				new executeme(j);
			}
			
			//	//	//
			$(".logo img").addClass("pulse");
		});
		setCookie("animated", true, new Date);
	} else {
		var distance = Math.floor($(window).height() / 3);
		$("#menu").css({
			top: distance
		});
	}
	
	$("#menu ul li").on("click", function(Event){
		if (Event.target.nodeName != "A") {
			window.location.href = $($(this).find("a")).attr("href");
		}
	});
});

/** SLIDER */
$(window).on("load", function() {
	$('#slider').nivoSlider();
});