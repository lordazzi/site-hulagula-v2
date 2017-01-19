<div class="window" id="produtos-precos">
	<div class="window-title">Alterar preços dos produtos<div class="window-close">X</div></div>
	<div class="window-content">
		<div class="content">
			<form id="forms-produtos-precos">
				<div class="form-element">
					<label for="select-produtos-precos">Categorias: </label>
					<select id="select-produtos-precos" style="width:250px;">
						<option value="0" selected="selected" disabled="disabled"> -- Selecione uma categoria -- </option>
					</select>
				</div>
				<div class="form-element">
					<label for="txt-filtro-de-produtos">Pesquisa produto: </label>
					<input id="txt-filtro-de-produtos" type="text" style="width:246px;" />
				</div>
				<table class="grid little">
					<thead>
						<tr>
							<th class="large-medium">Produto</th>
							<th class="small">Preço</th>
						</tr>
					</thead>
					<tbody id="tbody-produtos-precos"></tbody>
				</table>
				
				<div class="form-element">
					<span>Aumentar R$</span>
					<input id="input-alterar-precos-de-todos" class="small" type="text" disabled="disabled" maxlength="5" value="1,00" />
					<span> em todos desta categoria</span>
					<button id="btn-alterar-precos-de-todos" disabled="disabled" style="margin-left:14px;" type="button" title="Essa ação não fará efeito sobre os produtos em promoção, para alterá-los remova-os da promoção.">Aumentar</button>
				</div>
				<div class="form-element">
					<button class="save" id="save-produtos-precos" disabled="disabled" type="submit"> <div></div> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>