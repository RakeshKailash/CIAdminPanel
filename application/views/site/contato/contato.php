<?php
$info['title'] = array('Lorem Ipsum', 'Contato');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$tamanho_conteudo = 'conteudo_inteiro';
if (isset($secao_info->caminho) && $secao_info->caminho != null) {
	$tamanho_conteudo = 'conteudo_metade';
}
?>
<div class="container_secao" id="secao_servicos">
	<p class="titulo_secao"><i class="fa fa-<?php echo $secao_info->icone; ?>" aria-hidden="true"></i> Imagens</p>

	<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>">
		<?php
		echo $secao_info->conteudo;
		if ($contato->has_form)
		{
			$this->load->view('site/contato/form_email');
		}
		?>

	</div>

	<?php if (isset($secao_info->caminho) && $secao_info->caminho != null) : ?>
		<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>" style="background-image: url(<?php echo base_url($secao_info->caminho); ?>);">
		</div>
	<?php endif; ?>
</div>

<?php $this->load->view('footer'); ?>