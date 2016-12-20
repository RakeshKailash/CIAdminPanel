<?php
$info['title'] = array('Sistema', 'Seção Empresa');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

$imagem = $registro->caminho != null ? ("<img src='" . base_url($registro->caminho) . "' class='preview_img_form' />") : "<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>";

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
							<h4><?=$_SESSION['tipoUsuario'] != 1 ? 'Editar' : 'Visualizar'?> Empresa</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<form action="<?php echo base_url('sistema/empresa/update'); ?>" method="post" enctype="multipart/form-data">
									<h2>Conteúdo da Seção</h2>

									<div class="x_content">
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
										<?php if ($_SESSION['tipoUsuario'] != 1): ?>
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
										<?php endif ?>

										<div <?=$_SESSION['tipoUsuario'] != 1 ? 'id="editor"' : ''?>>
											<?php echo $registro->conteudo; ?>
										</div>
										<?php if ($_SESSION['tipoUsuario'] != 1): ?>
											<textarea name="conteudo" id="descr" style="display:none;"><?php echo $registro->conteudo; ?></textarea>
										<?php endif ?>
										<br />

									</div>

									<h2>Imagem</h2>
									<div class="x_content"> <!-- X-Content -->

										<input type="file" name="imagem" style="display: none;" id="imagem">
										<input type="hidden" name="has_img" value="<?php echo ($registro->caminho != null) ? '1' : '0';?>" id="has_img">

										<div id='img_selecionada'>
											<?php echo $imagem; ?>
										</div>
										<?php if ($_SESSION['tipoUsuario'] != 1): ?>
											<button type="button" class="btn btn-primary" id="select_img">Selecionar Imagem</button>
											<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
										<?php endif ?>

									</div> <!-- /X-Content -->
									<?php if ($_SESSION['tipoUsuario'] != 1): ?>
										<div class="x_content"> <!-- X-Content -->

											<button type="button" class="btn btn-warning" id="btn_reset_form">Limpar</button>
											<button type="submit" class="btn btn-success" id="btn_submit_form">Salvar</button>

										</div> <!-- /X-Content -->
									<?php endif ?>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php $this->load->view('footer') ?>