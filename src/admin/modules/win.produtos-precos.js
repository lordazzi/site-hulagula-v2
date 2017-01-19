$(function(){
	asWindow({ id: "produtos-precos", scope: $("#admin") });
	
	var lista = new Filter({
		list: "tbody-produtos-precos",
		filter: "txt-filtro-de-produtos",
		tolerance: 2
	});
	
	$("#input-alterar-precos-de-todos").on("keyup", function(Event){
		return forms.UFloat(Event);
	});
	
	$.ajax({
		url: "action/get-categorias.php",
		success: function(json){
			json = JSON.parse(json);
			$select = $("#select-produtos-precos");
			for (var i = 0; i < json.length; i++) {
				var $option = $("<option>");
				$option.val(json[i].idcategoria);
				$option.text(json[i].categoria);
				$option.appendTo($select);
			}
			
			$select.on("change", function(){
				$("#btn-alterar-precos-de-todos, #input-alterar-precos-de-todos").removeAttr("disabled");
				
				idcategoria = $(this).val();
				$.ajax({
					url: "action/get-produtos-from-categoria.php",
					type: "post",
					data: {
						idcategoria: idcategoria
					},
					success: function(json){
						json = JSON.parse(json);
						$tbody = $("#tbody-produtos-precos");
						$tbody.children().remove();
						
						for (var i = 0; i < json.length; i++) {
							var $tr = $("<tr>");
							$tr.attr("data-id", json[i].idproduto);
							
							var $td = $("<td>", { "class": "large-medium" });
							$td.text(json[i].numero+") "+json[i].nome);
							$td.appendTo($tr);
							
							var $td = $("<td>", { "class": "small" });
							var $span = $("<span>");
							var $input = $("<input>", {
								"type": "text",
								"value": json[i].preco,
								"class": "small",
								"maxlength": 5
							});
							
							$span.text("R$ ");
							$input.on("keydown", function(Event){
								$("#save-produtos-precos").removeAttr("disabled");
								return forms.UFloat(Event);
							});
							
							if (json[i].ispromote == 1) {
								$input.attr("disabled", "disabled");
								$input.attr("title", "Você não pode alterar o valord e uma pizza da promoção através desta janela");
							}
							
							$span.appendTo($td);
							$input.appendTo($td);
							$td.appendTo($tr);
							$tr.appendTo($tbody);
						}
					}
				});
			});
		}
	});
	
	$("#btn-alterar-precos-de-todos").on("click", function(){
		if ($(this).attr("disabled") == null) {
			var valor = parseFloat($("#input-alterar-precos-de-todos").val().replace(",", "."));
			var tudo = $("#tbody-produtos-precos").children();
			
			for (var i = 0; i < tudo.length; i++) {
				$input = $(tudo[i]).find("input[type='text']");
				if ($input.attr("disabled") == null) {
					var resultado = (Math.round((parseFloat($input.val().replace(",", ".")) + valor) * 100)/100).toString().replace(".", ",");
					console.log(i, resultado);
					resultado = (resultado.length == 2) ? (resultado + ",00") : (resultado);
					
					if (resultado.split(",")[1].length == 1) {
						$input.val(resultado+"0");
					} else {
						$input.val(resultado);
					}
				}
			}
			
			$("#save-produtos-precos").removeAttr("disabled");
		}
		
		return false;
	});
	
	$("#save-produtos-precos").on("click", function(){
		if ($(this).attr("disabled") == null) {
			var ids = [], values = [];
			$("#tbody-produtos-precos tr:not([disabled])").each(function(){
				ids[ids.length] = $(this).data("id");
				values[values.length] = $(this).find("input[type='text'].small").val().replace(",", ".");
			});
			
			$.ajax({
				url: "action/update-produtos-precos.php",
				type: "post",
				data: {
					ids: ids,
					values: values
				},
				success: function(json){
					json = JSON.parse(json);
				}
			});
		}
		
		return false;
	});
});