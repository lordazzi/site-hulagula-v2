var Filter = (function(args){
	//	defaults
	if (args == null) { return; }
	if (args.list == null) { return; }
	if (args.evt == null) { args.evt = "keyup"; }
	if (args.onList == null) { args.onList = function(){}; }
	if (args.tolerance == null) { args.tolerance = 1; }
	
	//	facilitadores
	var byid = function(i){ return document.getElementById(i); };
	var addEvt = function(obj, evt, func) {
		if (obj.addEventListener) { obj.addEventListener(evt, func, false); return true; }
		else if (obj.attachEvent) { obj.attachEvent("on"+evt, func); return true; }
		else { return false; }
	};
	
	//	atributos privados
	var el = byid(args.list);
	var self = this;
	
	//	método construtor
	var __construct = (function(){
		if (args.filter != null) {
			var txt = byid(args.filter);
			addEvt(txt, args.evt, function(){
				self.filter(txt.value);
			});
		}
	});
	
	var to_accent_insensitive = (function(str) {
		return str.replace(/[áãâàä]/g, "a")
			.replace(/[éèêë]/g, "e")
			.replace(/[íîïì]/g, "i")
			.replace(/[óõôöò]/g, "o")
			.replace(/[úùûü]/g, "u")
			.replace(/ç/g, "c")
			.replace(/ñ/g, "n");
	});
	
	var to_sound = (function(str) {
		return str.replace(/n/g, "m")
			.replace(/rr/g, "r")
			.replace(/ll/g, "l")
			.replace(/nn/g, "n")
			.replace(/mm/g, "m")	// 'nn', 'mn', 'nm' por 'n', como Zamanna ou Environment
			.replace(/ss/g, "s")
			.replace(/oo/g, "o")
			.replace(/aa/g, "a")
			.replace(/cc/g, "t")	// CC em italiano tem som de T
			.replace(/ch/g, "x")
			.replace(/sh/g, "x")
			.replace(/([^aeiou]|^)si/g, "ci") // asi o S tem som de Z
			.replace(/([^aeiou]|^)se/g, "ce")
			.replace(/sc/g, "c")
			.replace(/c/g, "k")		// C's isolados
			.replace(/kt/g, "t")	//	acto (K está no lugar de C)
			.replace(/qu/g, "k")
			.replace(/q/g, "k")
			.replace(/y/g, "i")
			.replace(/h/g, "")
			.replace(/w/g, "v")
			.replace(/z/g, "s")
			.replace(/e/g, "i");
	});
	
	this.filter = (function(agulha){
		for (i = 0; i < el.children.length; i++) {
			var palheiro = el.children[i].innerText;
			
			/*
				tolerancias:
					0 - exatamente da forma como esta
					1 - case sensitive
					2 - accent sensitive
					3 - semelhança de pronuncia
			*/
			
			if (args.tolerance >= 1) {
				palheiro = palheiro.toLowerCase();
				agulha = agulha.toLowerCase();
			}
			
			if (args.tolerance >= 2) {
				palheiro = to_accent_insensitive(palheiro);
				agulha = to_accent_insensitive(agulha);
			}
			
			if (args.tolerance >= 3) {
				palheiro = to_sound(palheiro);
				agulha = to_sound(agulha);
			}

			
			if (palheiro.indexOf(agulha) != -1 || agulha == "") {
				el.children[i].style.display = null; //	anulando o display none e retornando ao display antigo
				args.onList(el.children[i], true);
			} else {
				el.children[i].style.display = "none"; 
				args.onList(el.children[i], false);
			}
		}
	});
	
	this.reload = (function(){
		el = byid(args.list);
	});
	
	__construct();
});