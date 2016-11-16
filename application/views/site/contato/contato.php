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
	<section class="global-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<h2>Contato</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Contato</li>
						</ol>
					</div>
				</div>
			</div>
		</div>   
	</section><!--/#Page header-->

	<section id="contact-section">
		<div class="container">
			<div class="row">
				<?php if ($contato->has_form) : ?>
					<div class="col-md-6">
						<?php 
						$info_contact = null;
						if (isset($contato->contact_message)) {
							$info_contact['message'] = $contato->contact_message;
						}
						$this->load->view('site/contato/form_email', $info_contact);
						?>
					</div>
				<?php endif ?>
				<?php if ($contato->has_map) : ?>
					<div class="col-md-6">
						<?php
						$info_map['address'] = str_replace(' ', "+", $contato->address);
						$this->load->view('site/contato/map', $info_map);
						?>

					</div>
				<?php endif ?>
			<div class="col-md-6">
				<div class="col-md-6">
					<div class="address wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".3s">
						<i class="ion-ios-telephone-outline"></i>
						<p><?=$contato->telefone;?></p>
						<?php if(isset($contato->celular)) : ?>
							<p><?=$contato->celular;?></p>
						<?php endif ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="email wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".5s">
						<i class="ion-ios-email-outline"></i>
						<p><?=$contato->email;?></p>
					</div>
				</div>
				<?php if (isset($contato->address)) : ?>
					<div class="col-md-6">
						<div class="address wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".7s">
							<i class="ion-ios-location-outline"></i>
							<h5><?=$contato->address;?></h5>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</section>

</div>

<?php $this->load->view('footer'); ?>