<div class="window" id="produtos-configs">
	<div class="window-title">Editar produtos<div class="window-close">X</div></div>
	<div class="window-content">
		<div class="content">
			<form id="forms-produtos-configs">
				<div class="form-element">
					<label for="select-produtos-configs">Categorias: </label>
					<select id="select-produtos-configs" style="width:250px;">
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
							<th class="small">Número</th>
							<th class="large-medium">Produto</th>
						</tr>
					</thead>
					<tbody id="tbody-produtos-configs"></tbody>
				</table>
				
				<div class="form-element">
					<button id="btn-alterar-precos-de-todos" disabled="disabled" style="margin-left:14px;" type="button" title="Essa ação não fará efeito sobre os produtos em promoção, para alterá-los remova-os da promoção.">Aumentar</button>
				</div>
				<div class="form-element">
					<button class="save" id="save-produtos-precos" disabled="disabled" type="submit"> <div></div> Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>