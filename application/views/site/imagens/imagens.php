<?php
$info['title'] = array('Lorem Ipsum', 'Imagens');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$countImg = 0;

$commentInfo['comentarios'] = $comentarios;
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
					<?php
					if ($countImg == 3)
					{
						echo "</div><div class='row'>";
						$countImg = 0;
					}
					?>
					<div class="col-sm-4 col-xs-12">
						<figure class="wow fadeInLeft animated portfolio-item animated" data-wow-duration="500ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 300ms; -webkit-animation-duration: 300ms; animation-delay: 0ms; -webkit-animation-delay: 0ms; animation-name: fadeInLeft; -webkit-animation-name: fadeInLeft;">
							<div class="img-wrapper">
								<img src="<?=base_url($imagem->caminho);?>" class="img-responsive">
								<div class="overlay">
									<div class="buttons">
										<a rel="gallery" class="fancybox" href="<?=base_url($imagem->caminho);?>">Demo</a>
									</div>
								</div>
							</div>
						</figure>
					</div>
					<?php $countImg++; ?>
				<?php endforeach ?>
			</div>
		</div>
	</section>

	<?php
	if ($secao_info->comentarios) {
		$this->load->view('site/common/comentarios', $commentInfo);
	}
	?>

</div>

<?php $this->load->view('footer'); ?>