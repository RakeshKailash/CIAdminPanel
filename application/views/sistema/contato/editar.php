<?php
$info['title'] = array('Sistema', 'Editar Contato');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);

$imagem = $registro->caminho != null ? ("<img src='" . base_url($registro->caminho) . "' class='preview_img_form' />") : "<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>";

$checkStatus = $contato->has_form ? 'checked' : '';

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
							<img src="<?=base_url('images/uploads/profile/image.jpg'); ?>" alt="..." class="img-circle profile_img">
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
									<img src="<?php echo base_url('images/uploads/profile/image.jpg'); ?>" alt=""><?php echo $_SESSION['nome'] ?>
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

								</a>
								<ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
									<?php foreach ($atualizacoes as $atualizacao) : ?>
										<li>
											<a>
												<span class="image">
													<img src="<?php echo base_url("images/uploads/profile/$atualizacao->imagem"); ?>" alt="Imagem de Perfil" />
												</span>
												<span>
													<span><?php echo $atualizacao->nome; ?></span>
													<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', $atualizacao->data); ?></span>
												</span>
												<span class="message">
													<?php echo $atualizacao->titulo; ?>
												</span>
											</a>
										</li>
									<?php endforeach; ?>
									<li>
										<div class="text-center">
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
											<label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-mail</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input id="email" class="form-control col-md-7 col-xs-12" type="text" name="email" value="<?php echo $contato->email ?>">
											</div>
										</div>
										<div class="form-group">
											<input type="checkbox" name="form_email" id="form_email" value="1" class="flat" <?php echo $checkStatus; ?> />
											<label class="control-label col-md-3 col-sm-3 col-xs-12" style="padding: 3px 10px;">Formulário de Contato</label>
										</div>
									</div>

									<div class="x_content"> <!-- X-Content -->

										<button type="button" class="btn btn-warning" id="btn_reset_contato">Limpar</button>
										<button type="submit" class="btn btn-success" id="btn_submit_contato">Salvar</button>

									</div> <!-- /X-Content -->
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$("#remove_img_contato").click(function () {
			$("#img_selecionada_contato").html("<label id='img_selecionada_contato' for='imagem'>Ainda não existe uma imagem para esta categoria</label>");
			$("#has_img_contato").val("false");
		});

		$("#editor").blur(function () {
			$("#descr").html($("#editor").html());
		});

		$("#imagem_contato").change(function () {
			$("#img_selecionada_contato").html("<label id='img_selecionada_contato' for='imagem'>Imagem selecionada: " + $("#imagem_contato").val() + "</label>");
			$("#has_img_contato").val("true");
		});

		$("#btn_reset_contato").click(function () {
			location.reload();
		});

	</script>

	<?php $this->load->view('footer') ?>