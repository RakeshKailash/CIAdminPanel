<?php
$info['title'] = array('Lorem Ipsum', 'Empresa');
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
						<h2>Empresa</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Empresa</li>
						</ol>
					</div>
				</div>
			</div>
		</div>   
	</section><!--/#Page header-->

	<section id="service-page" class="pages service-page">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="block">
						<?php echo $secao_info->conteudo ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="block">
						<img class="img-responsive" src="<?=base_url($secao_info->caminho);?>" alt="">
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<?php $this->load->view('footer'); ?>