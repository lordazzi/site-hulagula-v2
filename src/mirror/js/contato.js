$(function(){
	$("#btn-enviar-a-mensagem").on("click", function(){
		$.ajax({
			type: "post",
			url: "/admin/action/insert-mensagem.php",
			data: {
				nome: $("#txt-nome-do-contato").val(),
				contato: $("#txt-contato-do-contato-duuh").val(),
				mensagem: $("#txt-mensagem-do-contato").val()
			},
			success: function(){
				$("#txt-nome-do-contato").val("");
				$("#txt-contato-do-contato-duuh").val("");
				$("#txt-mensagem-do-contato").val("");
				alert("Mensagem cadastrada com sucesso!");
			}
		});
	});
});