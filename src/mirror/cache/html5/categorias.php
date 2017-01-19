<?php if(!class_exists('raintpl')){exit;}?><nav>
	<?php $counter1=-1; if( isset($this->var['categorias']) && is_array($this->var['categorias']) && sizeof($this->var['categorias']) ) foreach( $this->var['categorias'] as $key1 => $value1 ){ $counter1++; ?>
		<a class="categoria" href="produtos.php?cat=<?php echo $value1["idcategoria"];?>" />
			<img src="arquivo/foto_categorias/<?php echo $value1["img"];?>" />
			<span><?php echo $value1["categoria"];?></span>
		</a>
	<?php } ?>
</nav>