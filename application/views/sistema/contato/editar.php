<?php
$info['title'] = array('Sistema', 'Editar Contato');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

$imagem = $registro->caminho != null ? ("<img src='" . base_url($registro->caminho) . "' class='preview_img_form' />") : "<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>";

$checkForm = $contato->has_form ? 'checked' : '';
$checkMap = $contato->has_map ? 'checked' : '';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

?>

<body class="nav-md">

	<div class="container body">


		<div class="main_container">

			<?php $this->load->view('sistema/common/sidebar');?>

			<!-- top navigation -->
			<?php $this->load->view('sistema/common/navbar');?>
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">

					<div class="page-title">
						<div class="title_left">
							<h3>Painel de Administração</h3>
						</div>
						<div class="title_right">
							<h4>Editar Contato</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<form data-parsley-validate class="form-horizontal form-label-left" action="<?php echo base_url('sistema/contato/update'); ?>" method="post" enctype="multipart/form-data">
									<h2>Informações de Contato</h2>
									<h5>Informações de contato que serão exibidas para os usuários do site.</h5>
									<div class="x_content">
										<br>

										<?php if ($error) : ?>
											<div class="alert alert-danger fade in">
												<a href="#" class="close" data-dismiss="alert">×</a>
												<strong>Erro!</strong> <?php echo $error; ?>
											</div>
										<?php endif; ?>
										<?php if ($success) : ?>
											<div class="alert alert-success fade in">
												<a href="#" class="close" data-dismiss="alert">×</a>
												<strong>Sucesso!</strong> <?php echo $success; ?>
											</div>
										<?php endif; ?>
										<?php if ($warning) : ?>
											<div class="alert alert-warning fade in">
												<a href="#" class="close" data-dismiss="alert">×</a>
												<strong>Atenção!</strong> <?php echo $warning; ?>
											</div>
										<?php endif; ?>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefone">Telefone <span class="required">*</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input class="form-control" id="telefone" name="telefone" data-inputmask="'mask': '(99) 9999-99999'" type="text" value="<?php echo $contato->telefone ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="celular">Celular
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input class="form-control" id="celular" name="celular" data-inputmask="'mask': '(99) 9999-99999'" type="text" value="<?php echo $contato->celular ?>">
											</div>
										</div>
										<div class="form-group">
											<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-mail <span class="required">*</span></label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="email" class="form-control col-md-7 col-xs-12" name="email" required="required" value="<?php echo $contato->email ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="whatsapp">Whatsapp</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input class="form-control" id="whatsapp" name="whatsapp" data-inputmask="'mask': '+9999 99999-9999'" type="text" value="<?php echo $contato->whatsapp ?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="endereco">Endereço</span>
											</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input class="form-control" id="endereco" name="endereco" type="text" value="<?php echo $contato->address;?>">
											</div>
										</div>
										<div class="ln_solid"></div>
										<h2>Formulário de Contato</h2>
										<h5>Inclua um campo para que o usuário possa lhe enviar um e-mail através do site.</h5>
										<h5>O e-mail usado para receber as mensagens é o que foi cadastrado no campo E-mail, acima.</h5>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding: 3px 10px;">Incluir</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="checkbox" name="form_email" id="form_email" value="1" class="flat" <?php echo $checkForm; ?> />
											</div>
										</div>
										<div id="contact-group" class="<?=($checkForm == 'checked') ? 'element-visible' : 'element-hidden';?>">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Legenda</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea class="form-control" id="contact_message" name="contact_message"><?php echo $contato->contact_message;?></textarea>
												</div>
											</div>
										</div>
										<div class="ln_solid"></div>
										<h2>Mapa do Google</h2>
										<h5>Ative para incluir no site um mapa do Google, centralizado em seu endereço.</h5>
										<h5>O mapa usará como base o Endereço fornecido nas Informações de Contato, acima.</h5>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">Incluir</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="checkbox" name="map_google" id="map_google" value="1" class="flat" <?php echo $checkMap; ?> />
											</div>
										</div>
										<div id="map-group" class="<?=($checkMap == 'checked') ? 'element-visible' : 'element-hidden';?>">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Legenda</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea class="form-control" id="map_message" name="map_message"><?php echo $contato->map_message;?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Prévia do Mapa</label>
												<div class="map col-md-6 col-sm-6 col-xs-12">
													<iframe width="100%" height="400" id="mapa_preview" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCGFrB3MI-kCSz76Op_xBGnmB4qO3MguUI&q=<?=str_replace(' ', '+', $contato->address);?>" allowfullscreen></iframe>
												</div>
											</div>
										</div>

										<div class="ln_solid"></div>

										<div class="form-group">
											<button type="button" class="btn btn-warning" id="btn_reset_contato">Limpar</button>
											<button type="submit" class="btn btn-success" id="btn_submit_contato">Salvar</button>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('footer') ?>