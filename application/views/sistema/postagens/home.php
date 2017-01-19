<?php
$info['title'] = array('Sistema', 'Gerenciar Postagens');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

$usuarios = $this->usuario_model->getUser();

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
							<h4>Gerenciar Postagens</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12 col-xs-12">
										<h2>Criar Nova Postagem</h2>
										<div id="mensagens">
											<?php if ($error) : ?>
												<div class="alert alert-danger fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Erro!</strong> <?=$error; ?>
												</div>
											<?php endif; ?>
											<?php if ($success) : ?>
												<div class="alert alert-success fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Sucesso!</strong> <?=$success; ?>
												</div>
											<?php endif; ?>
											<?php if ($warning) : ?>
												<div class="alert alert-warning fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Atenção!</strong> <?=$warning; ?>
												</div>
											<?php endif; ?>
										</div>
										<form class="form-horizontal form-label-left" id="form_criar_postagem" action="<?=base_url('sistema/postagens/create')?>" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Título: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="titulo" class="form-control" required="required">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Capa:</label>
												<div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;">
													<div class="col-md-6 col-xs-12">
														<div id='img_selecionada'>
															<img src="javascript:void(0)" alt="Nenhuma imagem selecionada" class="preview_img_form">
														</div>
													</div>
													<div class="col-md-6 col-xs-12" style="margin-top: 20px;">
														<button type="button" class="btn btn-primary" id="select_img">Selecionar Imagem</button>
														<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
														<input type="file" name="imagem" style="display: none;" id="imagem" onchange="readURL(this)">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Conteúdo: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
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
													<div id="editor" contenteditable="true"></div>
													<textarea name="conteudo" id="descr" style="display:none;"></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="id_usuario" value="<?=$_SESSION['id']?>">
													<input type="hidden" name="has_img" value="<?=$_SESSION['imagem'] == 'user.png' ? '0' : '1'?>" id="has_img">
													<button type="reset" class="btn btn-warning">Limpar</button>
													<button type="submit" id="salvar_edicao_usuario" class="btn btn-primary">Salvar Rascunho</button>
													<button type="submit" id="salvar_edicao_usuario" class="btn btn-success">Salvar e Postar</button>
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
		</div>
	</div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
</script>

<?php $this->load->view('footer') ?>