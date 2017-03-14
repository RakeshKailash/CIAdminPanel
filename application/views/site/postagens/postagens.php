<?php
$info['title'] = array('Lorem Ipsum', 'Postagens');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$countPost = 0;

$commentInfo['comentarios'] = $comentarios;
?>

<div class="container_secao" id="secao_servicos">
	<section class="global-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<h2>Postagens</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Postagens</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#Page header-->

	<section id="gallery" class="gallery">
		<div class="container" style="text-align: center;">
			<div class="row">
			<? if (sizeof($postagens) > 0) :?>
				<?php foreach ($postagens as $postagem): ?>
					<?php
					if ($countPost == 3)
					{
						echo "</div><div class='row'>";
						$countPost = 0;
					}
					?>

					<div class="container_post">
						<div class="img_post" style="background-image: <?=(sizeof($postagem->imagem) > 0) ? "url(".base_url($postagem->imagem).")" : "javascript:void(0)"?>"></div>
						<div class="text_post">
						    <span class="title_post"><?=$postagem->titulo?></span>
						    <p class="info_post">
						    	<span class="line_info_post">Por <b><?=$postagem->autor?></b></span>
						    	<span class="line_info_post">Em: <?=date('d\/m\/Y\, \à\s H\:i\h', strtotime($postagem->dataCriacao))?></span>
							</p>
						</div>
					</div>
					<?php $countPost++; ?>
				<?php endforeach ?>
			<?php else: ?>
				<p>Não há postagens a serem exibidas</p>
			<?php endif ?>
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