var draggable;
var centralize;
var generateid;
var msg;
var asWindow;
var forms;

$(function(){
	var id = 99;
	generateid = (function(){
		id++; return "element-"+id;
	});
	
	/** feitos mais especificamente para mover janelas, mas pode ser utilizado para outros fins */
	draggable = (function(args){
		if (args.scope == null) { args.scope = document; }
		$(args.ondrag).on("dragenter dragover dragleave drop", function(){ return false; });
		$(args.ondrag).on("mousedown", function(DownEvent){
			$(document).on("mousemove", function(MoveEvent){
				$(args.domove).css({
					"left": MoveEvent.clientX - DownEvent.offsetX - args.scope.offset().left,
					"top": MoveEvent.clientY - DownEvent.offsetY - args.scope.offset().top
				});
			});
			
			$(document).on("mouseup", function(){
				$(document).off("mousemove mouseup");
			});
		});
	});
	
	/** função que centraliza uma div na tela */
	centralize = (function(seletor, scope){
		if (scope == null) { scope = Window; }

		var top = Math.floor(($(scope).height() / 2) - ($(seletor).height() / 2)) - 50;
		var left = Math.floor(($(scope).width() / 2) - ($(seletor).width() / 2));
		if (top < 10) { top = 10; }
		$(seletor).css({
			"top": top,
			"left": left
		});
	});
	
	/** Substituindo o alert e confirm padrões do javascript */
	msg = {
		"alert": function(msg, title){
			if (title == null) { title = "Atenção!"; }
			var id = generateid();
			var mybutton = generateid();
			
			$("<div class='background-blocker'></div>").appendTo("body");
			
			$('<div id="'+id+'" class="window unblocked">' + 
				'<div class="window-title">'+title+'</div>' + 
				'<div class="window-close">X</div>' + 
				'<div class="window-content">' + 
					'<div class="content">' + 
						'<p>'+msg+'</p>' + 
						'<input id='+mybutton+' type="button" value="Ok" />' + 
					'</div>' + 
				'</div>' + 
			'</div>').appendTo("body");
			
			$("#"+id+" .window-close, #"+mybutton).on("click", function(){
				$(".background-blocker, #"+id).remove();
			});
			centralize("#"+id);
			
			new draggable({
				ondrag: "#"+id+" .window-title",
				domove: "#"+id
			});
		}
	}
	
	asWindow = (function(args) {
		if (args == null) { return; }
		if (args.id == null) { return; }
		if (args.neverClose == null) { args.neverClose = false; }
		if (args.scope == null) { args.scope = document; }
		
		new draggable({
			ondrag: "#"+args.id+" .window-title",
			domove: "#"+args.id,
			scope: args.scope
		});
		
		centralize("#"+args.id, args.scope);
		
		$("#"+args.id+" .window-close").on("click", function(){
			if (args.neverClose) {
				$(this).parents(".window").addClass("ghost");
			} else {
				$(this).parents(".window").remove();
			}
		});
		
		var $self = $("#"+args.id);
		$self.css({
			"width": $self.width(),
			"min-width": $self.width(),
			"max-width": $self.width()
		});
		
		$self.find("[data-type]").each(function(){
			switch ($(this).data("type")) {
				case "uint":
					$(this).on("keydown", forms.UInt);
					break;
					
				case "int":
					$(this).on("keydown", forms.Int);
					break;
					
				case "float":
					$(this).on("keydown", forms.Float);
					break;
					
				case "ufloat":
					$(this).on("keydown", forms.UFloat);
					break;
			}
		});
	});
	
	forms = {
		keyIsNumber: (function(Event){
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
		}),
		Int: (function(Event){
			if (forms.keyIsNumber(Event)) { //teclas auxiliares
				return true;
			} else if ((Event.keyCode == 189 && Event.shiftKey == false) || Event.keyCode == 109) {
				return true;
			} else {
				return false;
			}
		}),
		UInt: (function(Event){
			if (forms.keyIsNumber(Event)) { //teclas auxiliares
				return true;
			} else {
				return false;
			}
		}),
		Float: (function(Event){
			if (forms.keyIsNumber(Event)) { //teclas auxiliares
				return true;
			} else if ((Event.keyCode == 188 || Event.keyCode == 190 || Event.keyCode == 110 || Event.keyCode == 194) && Event.shiftKey == false) {
				return true;
			} else if ((Event.keyCode == 189 && Event.shiftKey == false) || Event.keyCode == 109) {
				return true;
			} else {
				return false;
			}
		}),
		UFloat: (function(Event){
			if (forms.keyIsNumber(Event)) { //teclas auxiliares
				return true;
			} else if ((Event.keyCode == 188 || Event.keyCode == 190 || Event.keyCode == 110 || Event.keyCode == 194) && Event.shiftKey == false) {
				return true;
			} else {
				return false;
			}
		})
	};
	
	$("#admin-logout .image").off("click");
	$("#admin-logout .image").on("click", function(){
		$.ajax({
			url: "action/sair.php",
			success: function(){
				window.location.href = "http://www.hulagula.com.br/admin";
			}
		});
	});
});