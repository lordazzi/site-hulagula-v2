<?php if(!class_exists('raintpl')){exit;}?><?php if( $this->var['issearch'] ){ ?>
	<form id="formulario-de-pesquisa">
		<label for="nome-pizza">Pesquisar Pizza:</label> <input name="nome-pizza" id="nome-pizza" type="search" /><br />
		<label for="min-preco">Entre R$ </label><input name="min-preco" id="min-preco" type="search" data-type="ufloat" value="<?php echo $this->var['minpreco'];?>" />
		<label for="max-preco"> e R$ </label><input name="max-preco" id="max-preco" type="search" data-type="ufloat" value="<?php echo $this->var['maxpreco'];?>" />
		<label for="sem-carne">Sem Carne?</label><input name="sem-carne" id="sem-carne" type="checkbox" />
		<label for="da-promocao">Da Promoção?</label><input name="da-promocao" id="da-promocao" type="checkbox" />
	</form>
<?php }else{ ?>
	<div id="alterar-categoria">
		<?php $counter1=-1; if( isset($this->var['categorias']) && is_array($this->var['categorias']) && sizeof($this->var['categorias']) ) foreach( $this->var['categorias'] as $key1 => $value1 ){ $counter1++; ?>
			<span>
				<a href="?cat=<?php echo $value1["idcategoria"];?>"><?php echo $value1["categoria"];?></a>
			</span>
		<?php } ?>
	</div>
<?php } ?>

<div id="produtos">
	<?php $counter1=-1; if( isset($this->var['produtos']) && is_array($this->var['produtos']) && sizeof($this->var['produtos']) ) foreach( $this->var['produtos'] as $key1 => $value1 ){ $counter1++; ?>
		<div <?php echo $value1["data"];?>>
			<span class="title"><?php echo $value1["title"];?></span>
			<span class="price"><?php echo $value1["preco"];?></span><br />
			<span class="description"><?php echo $value1["description"];?></span>
		</div>
	<?php } ?>
</div>

<div id="alterar-categoria">
	<?php $counter1=-1; if( isset($this->var['categorias']) && is_array($this->var['categorias']) && sizeof($this->var['categorias']) ) foreach( $this->var['categorias'] as $key1 => $value1 ){ $counter1++; ?>
		<span>
			<a href="?cat=<?php echo $value1["idcategoria"];?>"><?php echo $value1["categoria"];?></a>
		</span>
	<?php } ?>
</div>