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

			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">

					<div class="navbar nav_title" style="border: 0;">
						<a href="javascript:void(0)" class="site_title"><i class="fa fa-dashboard"></i> <span><?php echo "Projeto CI" ?></span></a>
					</div>
					<div class="clearfix"></div>


					<!-- menu prile quick info -->
					<div class="profile">
						<div class="profile_pic">
							<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem']); ?>" alt="..." class="img-circle profile_img">
						</div>
						<div class="profile_info">
							<span>Bem-vindo,</span>
							<h2><?php echo $_SESSION['nome']; ?></h2>
						</div>
					</div>
					<!-- /menu prile quick info -->

					<br />

					<!-- sidebar menu -->
					<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

						<div class="menu_section">
							<h3>Sistema</h3>
							<ul class="nav side-menu">
								<li><a href="<?=base_url('sistema'); ?>"><i class="fa fa-home"> </i> Home </a></li>
							</ul>
						</div>

						<div class="menu_section">
							<h3>Editar Seções</h3>
							<ul class="nav side-menu">
								<?php
								foreach ($secoes as $secao_info):
									if ($secao_info->nome != 'Home') :
										?>

									<li><a href="<?=base_url('sistema/' . $secao_info->link . '/editar'); ?>"><i class="fa fa-<?php echo $secao_info->icone; ?>"> </i> <?php echo $secao_info->nome ?> </a></li>

								<?php endif;
								endforeach; ?>
							</ul>
						</div>

					</div>

					<!-- /sidebar menu -->


				</div>
			</div>

			<!-- top navigation -->
			<div class="top_nav">

				<div class="nav_menu">
					<nav class="" role="navigation">
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="<?php echo base_url('images/uploads/profile/' . $_SESSION['imagem']); ?>" alt=""><?php echo $_SESSION['nome'] ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
									<li><a href="<?="Editar_usuario" ?>"><i class="fa fa-user pull-right"></i> Conta de Usuário</a>
									</li>
									<li>
										<a href="<?="Ajuda" ?>"><i class="fa fa-question-circle pull-right"></i> Ajuda</a>
									</li>
									<li>
										<a href="<?=base_url('sistema/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Sair</a>
									</li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-wrench"></i>
									<span class="count-update-badge badge bg-green"><?=(count($atualizacoes['naoVisualizadas']) > 0 ? count($atualizacoes['naoVisualizadas']) : null)?></span>
								</a>
								<ul class="dropdown-menu list-unstyled msg_list animated fadeInDown atualizacoes_site_lista" role="menu">
									<?php if ($atualizacoes['limitadas']) : foreach ($atualizacoes['limitadas'] as $atualizacao) : ?>
										<li class="atualizacao-visualizada-<?=$atualizacao->status;?>" data-id="<?=$atualizacao->id;?>">
											<a>
												<span class="image">
													<img src="<?php echo base_url("images/uploads/profile/$atualizacao->imagem"); ?>" alt="Imagem de Perfil" />
												</span>
												<span>
													<span><?php echo $atualizacao->nome; ?></span>
													<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', strtotime($atualizacao->data)); ?></span>
												</span>
												<span class="message">
													<?php echo $atualizacao->titulo; ?>
												</span>
											</a>
										</li>
									<?php endforeach; endif; ?>
									<li>
										<div class="text-center open_att_modal">
											<a>
												<strong>Ver todas as Modificações</strong>
												<i class="fa fa-angle-right"></i>
											</a>
										</div>
									</li>
								</ul>
							</li>

						</ul>
					</nav>
				</div>

			</div>
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

	<script type="text/javascript">

		$("#map_google").on('ifChecked', function () {
			$("#mapa_preview").attr('src', "https://www.google.com/maps/embed/v1/place?key=AIzaSyCGFrB3MI-kCSz76Op_xBGnmB4qO3MguUI&q=" + ($("#endereco").val()).replace(' ', '+'));
			$("#map-group").addClass('element-visible');
			$("#map-group").removeClass('element-hidden');
		});

		$("#map_google").on('ifUnchecked', function () {
			$("#map-group").addClass('element-hidden');
			$("#map-group").removeClass('element-visible');
		});

		$("#form_email").on('ifUnchecked', function () {
			$("#contact-group").addClass('element-hidden');
			$("#contact-group").removeClass('element-visible');
		});

		$("#form_email").on('ifChecked', function () {
			$("#contact-group").addClass('element-visible');
			$("#contact-group").removeClass('element-hidden');
		});

		$("#btn_reset_contato").click(function () {
			location.reload();
		});

		$("#endereco").keypress(function () {
			if ($("#map_google").prop('checked')) {
				$("#mapa_preview").attr('src', "https://www.google.com/maps/embed/v1/place?key=AIzaSyCGFrB3MI-kCSz76Op_xBGnmB4qO3MguUI&q=" + ($("#endereco").val()).replace(' ', '+'));
			}
		});

	</script>

	<?php $this->load->view('footer') ?>