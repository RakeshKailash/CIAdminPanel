<?php
$info['title'] = array('Lorem Ipsum', 'Imagens');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$this->load->view('header', $info);
$secao_info = $this->secoes_site->getSections(4)[0];
$tamanho_conteudo = 'conteudo_inteiro';
if (isset($secao_info->caminho) && $secao_info->caminho != null) {
	$tamanho_conteudo = 'conteudo_metade';
}
?>
<div class="container_secao" id="secao_servicos">
	<p class="titulo_secao"><i class="fa fa-<?php echo $secao_info->icone; ?>" aria-hidden="true"></i> Imagens</p>

	<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>">
		<?php echo $secao_info->conteudo ?>
	</div>
</div>

<?php $this->load->view('footer'); ?>