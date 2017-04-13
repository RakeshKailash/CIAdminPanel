<?php
$info['title'] = array('Sistema', 'Editar Postagem');
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
							<h4>Editar Postagem</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12 col-xs-12">
										<h3>
											<i class="fa fa-newspaper-o" aria-hidden="true"></i> <?=$edit_post->titulo;?>
										</h3>
										<h5>
											<i>
												Por: <b><?=$edit_post->autor;?></b> <br>
												Em: <b><?=date('d/m/Y\,\ \à\s\ H:i:s\h', strtotime($edit_post->dataCriacao));?></b> <br>
												Última versão: <b><?=$edit_post->ultimaVersao == $edit_post->dataCriacao ? 'Original' : date('d/m/Y\,\ \à\s\ H:i:s\h', strtotime($edit_post->ultimaVersao));?></b> <br>
												Status: <b><?=!!$edit_post->listar ? 'Publicada' : 'Arquivada'; ?></b>
											</i>
										</h5>
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
										<form class="form-horizontal form-label-left" id="form_criar_postagem" action="<?=base_url('sistema/postagens/save');?>" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label col-md-2 col-sm-2 col-xs-12">Título: <span class="required">*</span></label>
												<div class="col-md-10 col-sm-10 col-xs-12">
													<input type="text" name="titulo" id="titulo" class="form-control" required="required" value="<?=$edit_post->titulo;?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2 col-sm-2 col-xs-12">Capa:</label>
												<div class="col-md-10 col-sm-10 col-xs-12" style="text-align: center;">
													<div class="col-md-4 col-xs-12">
														<div id='img_selecionada'>
														<?php if (sizeof($edit_post->capa) > 0) : ?>
															<img src="<?=base_url($edit_post->capa);?>" alt="Nenhuma imagem selecionada" class="preview_img_form">
														<?php endif ?>
														<?php if (sizeof($edit_post->capa) <= 0) : ?>
															<label id='img_selecionada' for='imagem'>Ainda não existe uma imagem para esta categoria</label>
														<?php endif ?>
														</div>
													</div>
													<div class="col-md-2 col-xs-12" style="margin-top: 20px;">
														<button type="button" class="btn btn-primary" id="select_img">Selecionar Imagem</button>
														<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
														<input type="file" name="imagem" style="display: none;" id="imagem">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2 col-sm-2 col-xs-12">Conteúdo: <span class="required">*</span></label>
												<div class="col-md-10 col-sm-10 col-xs-12">
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
															<!-- <a class="btn" title="Inserir imagem (ou arraste e solte)" id="pictureBtn"><i class="icon-picture"></i></a> -->
															<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
														</div>
														<div class="btn-group">
															<a class="btn" data-edit="undo" title="Desfazer (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
															<a class="btn" data-edit="redo" title="Refazer (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
														</div>
													</div>
													<div id="editor" contenteditable="true"><?=$edit_post->conteudo;?></div>
													<textarea name="conteudo" id="descr" style="display:none;"><?=$edit_post->conteudo;?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<div>
														<label>
															<input type="checkbox" class="js-switch" id="status_post_modal" name="status_post" value="1" <?=!!$edit_post->listar ? 'checked' : ''?>> Publicar
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-2">
													<!-- Herdado da edição de Usuários -->
													<!-- <input type="hidden" name="id_usuario" value="<?=$_SESSION['id']?>"> -->
													<input type="hidden" name="has_img" value="<?=sizeof($edit_post->capa) > 0 ? '1' : '0'?>" id="has_img">
													<!-- /Herdado da edição de Usuários -->

													<input type="hidden" name="save_type" id="save_type" value="0">
													<input type="hidden" id="id_postagem" name="id_postagem" value="<?=$edit_post->id;?>">
													<button type="button" class="btn btn-warning"><a href="<?=base_url('sistema/postagens')?>">Cancelar</a></button>
													<button type="submit" class="btn btn-success">Salvar Edições</button>
												</div>
											</div>
										</form> <!-- /Criar Editar Postagens -->
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

<?php $this->load->view('footer') ?>