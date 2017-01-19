var f;
$(function(){
	f = new Forms({
		id: "formulario-de-pesquisa"
	});
	
	$("#nome-pizza, #min-preco, #max-preco").on("keyup", function(){
		filter();
	});
	
	$("#sem-carne, #da-promocao").on("click", function(){
		filter();
	});
	
	var filter = (function(){
		var valor = $("#nome-pizza").val().toLowerCase();
		var semcarne = ($("#sem-carne").filter(":checked").length == 1);
		var dapromocao = ($("#da-promocao").filter(":checked").length == 1);
		var minpreco = parseFloat($("#min-preco").val().replace(",", "."));
		var maxpreco = parseFloat($("#max-preco").val().replace(",", "."));
		
		minpreco = (!isNaN(minpreco)) ? (minpreco) : (0);
		maxpreco = (!isNaN(maxpreco)) ? (maxpreco) : (0);
		
		$("#produtos div").each(function(){
			$this = $(this);
			var preco = parseFloat($(this).data("preco"));
			
			if ($this.data("search").indexOf(valor) != -1 || valor == "") {
				if ($this.data("meat") == 1 && semcarne) {
					$this.css("display", "none");
				} else {
					if ($this.data("isnpromote") == 1 && dapromocao) {
						$this.css("display", "none");
					} else {
						if (minpreco <= preco || minpreco == 0) {
							if (maxpreco >= preco || maxpreco == 0) {
								$this.removeAttr("style");
							} else {
								$this.css("display", "none");
							}
						} else {
							$this.css("display", "none");
						}
					}
				}
			} else {
				$this.css("display", "none");
			}
		});
	});
});