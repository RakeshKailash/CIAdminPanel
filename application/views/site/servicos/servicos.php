<?php
$info['title'] = array('Lorem Ipsum', 'Serviços');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$tamanho_conteudo = 'conteudo_inteiro';
if (isset($secao_info->caminho) && $secao_info->caminho != null) {
	$tamanho_conteudo = 'conteudo_metade';
}
?>
<div class="container_secao" id="secao_servicos">
	<p class="titulo_secao"><i class="fa fa-<?php echo $secao_info->icone; ?>" aria-hidden="true"></i> Serviços</p>

	<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>" id="conteudo_servicos">
		<?php echo $secao_info->conteudo ?>
	</div>

	<?php if (isset($secao_info->caminho) && $secao_info->caminho != null) : ?>
		<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>" id="img_servicos" style="background-image: url(<?php echo base_url($secao_info->caminho); ?>);">
		</div>
	<?php endif; ?>
</div>

<?php $this->load->view('footer'); ?>