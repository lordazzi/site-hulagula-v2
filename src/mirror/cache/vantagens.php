<?php if(!class_exists('raintpl')){exit;}?><?php $counter1=-1; if( isset($this->var['vantagens']) && is_array($this->var['vantagens']) && sizeof($this->var['vantagens']) ) foreach( $this->var['vantagens'] as $key1 => $value1 ){ $counter1++; ?>
	<div class="vantagem">
		<img src="arquivo/foto_vantagens/<?php echo $value1["img"];?>" />
		<span>
			<strong><?php echo $value1["titulo"];?></strong><br />
			<?php echo $value1["description"];?>
		</span>
	</div>
<?php } ?>