<?php 
$itens = $this->secoes_site->getSections();
?>

<ul class="menu_cabecalho hide-sm">
	<?php foreach ($itens as $item): ?>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('site/' . $item->link); ?>">
				<?php if ($item->icone != null) : ?>
					<i class="fa fa-<?php echo $item->icone; ?>" aria-hidden="true"></i>
				<?php endif;
				echo $item->nome; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

<span class="botao_menu_mobile hide-l"><i class="fa fa-bars" aria-hidden="true"></i></span>

<ul class="menu_mobile hide-l menu_hidden">
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site'); ?>" title="">
			Home<i class="fa fa-home" aria-hidden="true"></i>
		</a>
	</li>
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site/servicos'); ?>" title="">
			Serviços<i class="fa fa-desktop" aria-hidden="true"></i>
		</a>
	</li>
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site/empresa'); ?>" title="">
			Empresa<i class="fa fa-building" aria-hidden="true"></i>
		</a>
	</li>
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site/imagens'); ?>" title="">
			Imagens<i class="fa fa-picture-o" aria-hidden="true"></i>
		</a>
	</li>
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site/contato'); ?>" title="">
			Contato<i class="fa fa-envelope" aria-hidden="true"></i>
		</a>
	</li>
</ul>