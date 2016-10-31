<?php
$info['title'] = array('Sistema', 'Editar Empresa');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);

$imagem = $registro->caminho != null ? ("<img src='" . base_url($registro->caminho) . "' class='preview_img_form' />") : "<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>";

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
													<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', $atualizacao->data);; ?></span>
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
								<h4>Editar Empresa</h4>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<form action="<?php echo base_url('sistema/empresa/update'); ?>" method="post" enctype="multipart/form-data">
										<h2>Conteúdo da Seção</h2>

										<div class="x_content">

											<div id="alerts"></div>
											<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
												<div class="btn-group">
													<a class="btn dropdown-toggle" data-toggle="dropdown" title="Fonte"><i class="fa icon-font"></i><b class="caret"></b></a>
													<ul class="dropdown-menu">
													</ul>
												</div>
												<div class="btn-group">
													<a class="btn dropdown-toggle" data-toggle="dropdown" title="Tamannho da Fonte"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
													<ul class="dropdown-menu">
														<li>
															<a data-edit="fontSize 5">
																<p style="font-size:17px">Grande</p>
															</a>
														</li>
														<li>
															<a data-edit="fontSize 3">
																<p style="font-size:14px">Normal</p>
															</a>
														</li>
														<li>
															<a data-edit="fontSize 1">
																<p style="font-size:11px">Pequeno</p>
															</a>
														</li>
													</ul>
												</div>
												<div class="btn-group">
													<a class="btn" data-edit="bold" title="Negrito (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
													<a class="btn" data-edit="italic" title="Itálico (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
													<a class="btn" data-edit="strikethrough" title="Riscado"><i class="icon-strikethrough"></i></a>
													<a class="btn" data-edit="underline" title="Sublinhado (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
												</div>
												<div class="btn-group">
													<a class="btn" data-edit="insertunorderedlist" title="Lista Não-ordenada"><i class="icon-list-ul"></i></a>
													<a class="btn" data-edit="insertorderedlist" title="Lista Ordenada"><i class="icon-list-ol"></i></a>
													<a class="btn" data-edit="outdent" title="Reduzir Indentação (Shift+Tab)"><i class="icon-indent-left"></i></a>
													<a class="btn" data-edit="indent" title="Indentar (Tab)"><i class="icon-indent-right"></i></a>
												</div>
												<div class="btn-group">
													<a class="btn" data-edit="justifyleft" title="Alinhar à Esquerda (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
													<a class="btn" data-edit="justifycenter" title="Centralizar (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
													<a class="btn" data-edit="justifyright" title="Alinhar à Direita (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
													<a class="btn" data-edit="justifyfull" title="Justificar (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
												</div>
												<div class="btn-group">
													<a class="btn dropdown-toggle" data-toggle="dropdown" title="Link"><i class="icon-link"></i></a>
													<div class="dropdown-menu input-append">
														<input class="span2" placeholder="URL" type="text" data-edit="createLink" />
														<button class="btn" type="button">Add</button>
													</div>
													<a class="btn" data-edit="unlink" title="Remover Link"><i class="icon-cut"></i></a>

												</div>

												<div class="btn-group">
													<a class="btn" title="Inserir imagem (ou arraste e solte)" id="pictureBtn"><i class="icon-picture"></i></a>
													<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
												</div>
												<div class="btn-group">
													<a class="btn" data-edit="undo" title="Desfazer (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
													<a class="btn" data-edit="redo" title="Refazer (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
												</div>
											</div>

											<div id="editor">
												<?php echo $registro->conteudo; ?>
											</div>
											<textarea name="conteudo" id="descr" style="display:none;"><?php echo $registro->conteudo; ?></textarea>
											<br />

										</div>

										<h2>Imagem</h2>
										<div class="x_content"> <!-- X-Content -->

											<input type="file" name="imagem" style="display: none;" id="imagem">
											<input type="hidden" name="has_img" value="1" id="has_img">

											<div id='img_selecionada'>
												<?php echo $imagem; ?>
											</div>
											<button type="button" class="btn btn-primary" id="select_img">Selecionar Imagem</button>
											<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>

										</div> <!-- /X-Content -->

										<div class="x_content"> <!-- X-Content -->

											<button type="button" class="btn btn-warning" id="btn_reset_form">Limpar</button>
											<button type="submit" class="btn btn-success" id="btn_submit_form">Salvar</button>

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
			$("#remove_img").click(function () {
				$("#img_selecionada").html("<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>");
				$("#has_img").val("false");
			});

			$("#editor").blur(function () {
				$("#descr").html($("#editor").html());
			});

			setTarget('#select_img', '#imagem');

			$("#imagem").change(function () {
				$("#img_selecionada").html("<label id='img_selecionada' for='imagem'>Imagem selecionada: " + $("#imagem").val() + "</label>");
				$("#has_img").val("true");
			});

			$("#btn_reset_form").click(function () {
				location.reload();
			});

			function setTarget (from, to, event) {
				if (event == null) {
					event = 'click';
				}

				$(from).click(function() {
					$(to).trigger(event);
				});
			}
		</script>

		<?php $this->load->view('footer') ?>