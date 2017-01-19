<div class="window" id="promotion-config">
	<div class="window-title">Configuração das promoções<div class="window-close">X</div></div>
	<div class="window-content">
		<div class="content">
			<form id="forms-promotion-config">
				<fieldset>
					<legend>Promoção das pizzas</legend>

					<div class="form-element">
						<label>Pizzas da promoção:</label>
						<input type="text" id="pizza-promocao-preco" data-type="ufloat" class="small" />
					</div>
				</fieldset>
					
				<fieldset>
					<legend>Promoção das Esfihas</legend>
					<div class="form-element">
						<label>Preço das Esfihas:</label>
						<input type="text" id="pizza-promocao-esfiha" data-type="ufloat" class="small" />
					</div>
					
					<div class="form-element">
						<label>Quantidade de Esfihas:</label>
						<input type="text" id="quantidade-promocao-esfiha" data-type="uint" class="small" />
					</div>
				</fieldset>
				
				<div class="form-element">
					<button class="save" id="save-promocao-configs" type="submit"> <div></div> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>