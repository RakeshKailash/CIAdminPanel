<?php
$info['title'] = array('Lorem Ipsum', 'Contato');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$tamanho_conteudo = 'conteudo_inteiro';
if (isset($secao_info->caminho) && $secao_info->caminho != null) {
	$tamanho_conteudo = 'conteudo_metade';
}

$classes = array('0' => 6, '1' => 6, '2' => 12);
$colunas = array('0' => 4, '1' => 12, '2' => 3);
$countColumns = 0;

$commentInfo['comentarios'] = $comentarios;
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
					<div class="col-md-<?=$classes[$countColumns];?>">
						<?php
						$countColumns++;
						$info_contact = null;
						if (isset($contato->contact_message)) {
							$info_contact['message'] = $contato->contact_message;
						}
						$this->load->view('site/contato/form_email', $info_contact);
						?>
					</div>
				<?php endif ?>
				<?php if ($contato->has_map) : ?>
					<div class="col-md-<?=$classes[$countColumns];?>">
						<?php
						$countColumns++;
						$info_map['address'] = str_replace(' ', "+", $contato->address);
						if (isset($contato->map_message))
						{
							$info_map['map_message'] = $contato->map_message;
						}
						$this->load->view('site/contato/map', $info_map);
						?>

					</div>
				<?php endif ?>
				<?php if ($countColumns == 2): ?>
				</div>
				<div class="row address-details">
				<?php endif ?>
				<div class="col-md-<?=($countColumns > 0) ? $classes[$countColumns] : 12;?>" style="text-align: center;">
					<div class="col-md-<?=$colunas[$countColumns]?>">
						<div class="phone wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".3s">
							<i class="ion-ios-telephone-outline"></i>
							<p><?=$contato->telefone;?></p>
							<?php if(isset($contato->celular)) : ?>
								<p><?=$contato->celular;?></p>
							<?php endif ?>
						</div>
					</div>
					<div class="col-md-<?=$colunas[$countColumns]?>">
						<div class="email wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".5s">
							<i class="ion-ios-email-outline"></i>
							<p><?=$contato->email;?></p>
						</div>
					</div>
					<?php if (isset($contato->address)) : ?>
						<div class="col-md-<?=$colunas[$countColumns]?>">
							<div class="address wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".7s">
								<i class="ion-ios-location-outline"></i>
								<h5><?=$contato->address;?></h5>
							</div>
						</div>
					<?php endif ?>
					<?php if (isset($contato->whatsapp)) : ?>
						<div class="col-md-<?=$colunas[$countColumns]?>">
							<div class="phone wow fadeInLeft" data-wow-duration="500ms" data-wow-delay=".9s">
								<i class="ion-social-whatsapp-outline"></i>
								<p><?=$contato->whatsapp;?></p>
							</div>
						</div>
					<?php endif ?>
				</div>
				<?php if ($countColumns == 2): ?>
				</div>
			<?php endif ?>
		</div>
	</section>

	<?php
	if ($secao_info->comentarios) {
		$this->load->view('site/common/comentarios', $commentInfo);
	}
	?>

</div>

<?php $this->load->view('footer'); ?>