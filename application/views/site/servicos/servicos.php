<?php
$info['title'] = array('Lorem Ipsum', 'Serviços');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$classe = $secao_info->caminho ? 'col-md-6' : 'col-md-12';
$commentInfo['comentarios'] = $comentarios;
?>
<div class="container_secao" id="secao_servicos">
	<section class="global-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<h2>Serviços</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Serviços</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#Page header-->

	<section id="service-page" class="pages service-page">
		<div class="container">
			<div class="row">
				<div class="<?=$classe;?>">
					<div class="block">
						<?php echo $secao_info->conteudo ?>
					</div>
				</div>
				<?php if ($classe == 'col-md-6') : ?>
					<div class="col-md-6">
						<div class="block">
							<img class="img-responsive" src="<?=base_url($secao_info->caminho);?>" alt="">
						</div>
					</div>
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