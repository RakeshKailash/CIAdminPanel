<?php
$info['title'] = array('Lorem Ipsum', 'Imagens');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$tamanho_conteudo = 'conteudo_inteiro';
if (isset($secao_info->caminho) && $secao_info->caminho != null) {
	$tamanho_conteudo = 'conteudo_metade';
}
?>
<div class="container_secao" id="secao_servicos">
	<section class="global-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<h2>Imagens</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Imagens</li>
						</ol>
					</div>
				</div>
			</div>
		</div>   
	</section><!--/#Page header-->

	<section id="gallery" class="gallery">
		<div class="container">
			<div class="row">
				<?php foreach ($imagens as $imagem): ?>
					<div class="col-sm-4 col-xs-12">
						<figure class="wow fadeInLeft animated portfolio-item animated" data-wow-duration="500ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 300ms; -webkit-animation-duration: 300ms; animation-delay: 0ms; -webkit-animation-delay: 0ms; animation-name: fadeInLeft; -webkit-animation-name: fadeInLeft;">
							<div class="img-wrapper">
								<img src="<?=base_url($imagem->caminho);?>" class="img-responsive" alt="this is a title">
								<div class="overlay">
									<div class="buttons">
										<a rel="gallery" class="fancybox" href="<?=base_url($imagem->caminho);?>">Demo</a>
									</div>
								</div>
							</div>
						</figure>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</section>

	<div class="conteudo_secao <?php echo $tamanho_conteudo; ?>">
		<?php echo $secao_info->conteudo ?>
	</div>
</div>

<?php $this->load->view('footer'); ?>