<?php
$info['title'] = array('Sistema', 'Editar Imagens');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$registro = $this->secoes_sistema->getInfo(4)[0];
$secoes = $this->secoes_sistema->getInfo();

$atualizacoes = $this->atualizacoes_sistema->retrieve(null, 5);

$imagens_galeria = $this->imagens_model->getGalleryContent();

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
												<strong>Ver todas as Atualizações</strong>
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
							<h4>Editar Imagens</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<form action="<?php echo base_url('sistema/imagens/editar'); ?>" method="post" enctype="multipart/form-data">
									<h2>Galeria de Imagens</h2>

									<div class="x_content">

										<label id="img_selecionada" for="imagens_galeria"><h4>Nenhuma imagem selecionada</h4></label> <br>
										<button type="button" class="btn btn-primary" id="img_select_galeria">Selecionar Imagens</button>
										<button type="button" class="btn btn-warning" id="btn_reset_form">Limpar</button>
										<button type="submit" class="btn btn-success" id="form_submit_galeria">Enviar</button>

										<input type="file" name="imagens_galeria[]" id="imagens_galeria" multiple style="display: none;">
										<input type="submit" name="enviar" id="submit_galeria" style="display: none;">


									</div>
								</form>
							</div>
							<div class="x_panel">
								<div class="galeria_imagens">

									<?php foreach ($imagens_galeria as $imagem_galeria) : ?>
										<div class="container_img_gallery">
											<img src="<?php echo base_url($imagem_galeria->caminho); ?>" class="img_gallery" data-id="<?php echo $imagem_galeria->id; ?>" />
											<a href="<?php echo base_url('sistema/imagens/excluir?id=' . $imagem_galeria->id) ?>"><i class="fa fa-close icon_img_gallery"></i></a>
										</div>
									<?php endforeach; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$("#remove_img").click(function () {
			$("#img_selecionada").html("Ainda não existe uma imagem para esta categoria");
			$("#has_img").val("false");
		});

		$("#editor").blur(function () {
			$("#descr").html($("#editor").html());
		});

		

		$("#imagens_galeria").change(function () {
			var label_text = []
			, arquivos = $("#imagens_galeria")[0].files
			, texto_imgs = "<h4>" + arquivos.length
			;

			for (var i = 0; i < arquivos.length; i++) {
				label_text.push("&bull; " + arquivos[i].name);
			}

			 if (arquivos.length > 1) {
			 	texto_imgs +=" imagens selecionadas: </h4>";
			 } else {
			 	texto_imgs +=" imagem selecionada: </h4>";
			 }
				
			$("#img_selecionada").html("<label id='img_selecionada' for='imagem'>" + texto_imgs + label_text.join("<br />") + "</label>");
			// $("#has_img").val("true");
		});

		$("#btn_reset_form").click(function () {
			location.reload();
		});

	</script>

	<?php $this->load->view('footer') ?>