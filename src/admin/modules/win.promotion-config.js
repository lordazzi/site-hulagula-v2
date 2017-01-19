$(function(){
	asWindow({ id: "promotion-config", scope: $("#admin") });
	
	$.ajax({
		url: "action/get-promotes-configuration.php",
		success: function(json){
			json = JSON.parse(json);
			$("#pizza-promocao-preco").val(json[0].valor);
			$("#pizza-promocao-esfiha").val(json[1].valor);
			$("#quantidade-promocao-esfiha").val(json[2].valor);
		}
	});
	
	$("#save-promocao-configs").on("click", function(){
		var success = [];
		var supreme_success = function(){
			success[success.length] = true;
			if (success.length == 3) {
				msg.alert("Alterações salvas com sucesso!");
			}
		}
		
		$.ajax({
			url: "action/promote-pizza-preco.php",
			type: "post",
			data: {
				promocao: $("#pizza-promocao-preco").val()
			},
			success: supreme_success
		});
		
		$.ajax({
			url: "action/promote-esfihas-preco.php",
			type: "post",
			data: {
				promocao: $("#pizza-promocao-esfiha").val()
			},
			success: supreme_success
		});
		
		$.ajax({
			url: "action/promote-esfihas-qtdd.php",
			type: "post",
			data: {
				promocao: $("#quantidade-promocao-esfiha").val()
			},
			success: supreme_success
		});
		
		return false;
	});
});