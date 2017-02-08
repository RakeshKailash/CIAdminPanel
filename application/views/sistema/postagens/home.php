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

					<!-- <div class="modal" tabindex="-1" role="dialog" id="post_full_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="title_user_modal">Visualizar/Editar Postagem</h4>
								</div>
								<div class="modal-body" id="img_modal_body" style="overflow: hidden;">
									<div class="col-lg-12 col-xs-12 col-md-12">
										<div class="col-md-12 col-lg-12 div_img_preview_modal">
											<img class="img_preview_modal" src="<?=base_url('images/uploads/sections/mountain.jpg');?>">
											<div class="buttons_container">
												<i class="fa fa-times icon_buttons_post" aria-hidden="true" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Remover Capa"></i>
												<i class="fa fa-file-image-o icon_buttons_post" aria-hidden="true" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="top" data-content="Carregar nova Capa"></i>
											</div>
										</div>
									</div>
									<div class="tools_modal_inside col-md-12" style="margin-top: 30px;">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<form action="<?=base_url('sistema/postagens/update')?>" method="post" accept-charset="utf-8" data-parsley-validate class="form-horizontal form-label-left">
													<div class="form-group">
														<label for="titulo_post_modal" class="control-label col-md-12 col-sm-12 col-xs-12" style="text-align: left; padding-left: 10px;">Título</label>
														<div class="col-md-12 col-sm-12 col-xs-12">
															<input id="titulo_post_modal" type="text" name="titulo_post_modal" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-12 col-sm-12 col-xs-12" for="conteudo_post_modal" style="text-align: left; padding-left: 10px;">Conteúdo: <span class="required">*</span></label>
														<div class="col-md-12 col-sm-12 col-xs-12">
															<div id="alerts"></div>
															<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor[data-use='modal']">
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
															<div id="editor" contenteditable="true" data-use="modal"></div>
															<textarea name="conteudo_post_modal" id="descr" data-use="modal" style="display:none;"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
														<div class="col-md-9 col-sm-9 col-xs-12">
															<div>
																<label>
																	<input type="checkbox" class="js-switch" id="status_post_modal" name="status_post_modal" value="1"> Publicar
																</label>
															</div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12 col-lg-3">
															<input type="hidden" name="id_post" id="id_post_hidden" value="0">
															<?php if ($_SESSION['tipoUsuario'] != 1): ?>
																<button type="submit" class="btn btn-success">Salvar</button>
															<?php endif; ?>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
								</div>
							</div>
						</div>
					</div> -->

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12 col-xs-12">
										<h2>Criar ou Editar Postagem</h2>
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
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Título: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="titulo" id="titulo" class="form-control" required="required">
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
														<input type="file" name="imagem" style="display: none;" id="imagem">
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
												<label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<div>
														<label>
															<input type="checkbox" class="js-switch" id="status_post_modal" name="status_post" value="1"> Publicar
														</label>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<!-- Herdado da edição de Usuários -->
													<input type="hidden" name="id_usuario" value="<?=$_SESSION['id']?>">
													<input type="hidden" name="has_img" value="<?=$_SESSION['imagem'] == 'user.png' ? '0' : '1'?>" id="has_img">
													<!-- /Herdado da edição de Usuários -->

													<input type="hidden" name="save_type" id="save_type" value="0">
													<input type="hidden" id="id_postagem" name="id_postagem" value="<?=isset($_SESSION['edit_post_id']) ? $_SESSION['edit_post_id'] : '0' ?>">
													<button type="reset" class="btn btn-warning">Limpar</button>
													<button type="button" id="salvar_rascunho_post" class="btn btn-primary">Salvar Rascunho</button>
													<button type="button" id="salvar_postar_post" class="btn btn-success">Salvar e Postar</button>
												</div>
											</div>
										</form> <!-- /Criar Editar Postagens -->
										<div class="ln_solid"></div>
										<h2>Galeria de Postagens</h2>
										<div class="posts_gallery_filters col-md-12" style="margin-bottom: 30px; text-align: center;">
											<div class="col-md-3 col-xs-12 gallery_filters">
												<select class="form-control" name="order_by_posts" id="order_by_posts">
													<option value="default" selected>-- Ordenar Por --</option>
													<option value="newest">Mais Recentes</option>
													<option value="oldest">Mais Antigos</option>
													<option value="views">Visualizações</option>
													<option value="updated">Recentemente Alterados</option>
													<option value="author">Autor</option>
													<option value="status">Status</option>
												</select>
											</div>
											<div class="col-md-2 col-xs-12 gallery_filters">
												<button type="button" class="btn btn-success">Refinar Seleção</button>
											</div>
										</div>
										<div class="gallery_posts">
											<?php foreach ($postagens as $postagem): ?>
												<div class="container_gallery_display">
													<div class="container_content_gallery_item_display">
														<div class="gallery_item_display" data-postid="<?=$postagem->id?>">
															<div class="img_gallery_item_display" style="background-image: url('<?=base_url($postagem->capa)?>');"></div>
															<div class="author_gallery_item_display">
																<span>Por: <?=$postagem->autor?></span>
															</div>
															<div class="info_gallery_item_display">
																<p class="title_gallery_item_display"><?=$postagem->titulo;?></p>
																<p class="description_gallery_item_display"><?=strip_tags(mb_substr($postagem->conteudo, 0, 97)) . '...'?></p>
															</div>
														</div>
														<?php if ($_SESSION['tipoUsuario'] != 1): ?>
															<div class="container_menu_gallery_item_display">
																<i class="fa fa-ellipsis-v more_gallery_item_display inactive" aria-hidden="true"></i>
																<ul class="menu_gallery_item_display inactive">
																	<li class="item_menu_gallery_item_display">
																		<i class="fa fa-info-circle icon_menu_gallery_item" aria-hidden="true"></i>
																		<span class="text_menu_gallery_item">Detalhes</span>
																	</li>
																	<li class="item_menu_gallery_item_display">
																		<i class="fa fa-external-link icon_menu_gallery_item" aria-hidden="true"></i>
																		<span class="text_menu_gallery_item">Visitar</span>
																	</li>
																	<li class="item_menu_gallery_item_display">
																		<i class="fa fa-pencil-square-o icon_menu_gallery_item" aria-hidden="true"></i>
																		<span class="text_menu_gallery_item">Editar</span>
																	</li>
																</ul>
															</div>
														<?php endif ?>
													</div>
												</div>
											<?php endforeach ?>
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
</div>

<script type="text/javascript" charset="utf-8" async defer>

	$("#salvar_rascunho_post").click(function () {
		$("#save_type").val(0);
		$("#form_criar_postagem").submit();
	});

	$("#salvar_postar_post").click(function () {
		$("#save_type").val(1);
		$("#form_criar_postagem").submit();
	});

	$(".gallery_posts").on('click', ".more_gallery_item_display", function () {
		if ($(this).hasClass('inactive')) {
			$(".more_gallery_item_display").removeClass('active');
			$(".more_gallery_item_display").next().removeClass('active');
			$(".more_gallery_item_display").addClass('inactive');
			$(".more_gallery_item_display").next().addClass('inactive');

			$(this).addClass('active');
			$(this).removeClass('inactive');
			$(this).next().addClass('active');
			$(this).next().removeClass('inactive');
			return true;
		}

		$(this).addClass('inactive');
		$(this).removeClass('active');
		$(this).next().addClass('inactive');
		$(this).next().removeClass('active');
	});

	$(".gallery_posts").on('click', '.gallery_item_display', function () {
		var idPostagem = $(this).data('postid');

		window.location = base_url + 'sistema/postagens/editar/' + idPostagem;
	});

	$("#status_post_modal").click(function () {
		$("#status_post_modal").val($("#status_post_modal").val() == 1 ? 0 : 1);
	});

	$("#order_by_posts").change(function () {
		var orderBy = $(this).val();

		// if (orderBy == '0') {
		// 	return false;
		// }

		$.get(base_url + 'sistema/postagens/filterPosts/' + orderBy, function (result) {
			result = JSON.parse(result);

			fillPostsGallery(result);
		});

	});

	function fillPostsGallery (elements) {
		var posts = [];
		for (var i = 0; i < elements.length; i++) {
			posts.push(
				"<div class='container_gallery_display'>",
				"<div class='container_content_gallery_item_display'>",
				"<div class='gallery_item_display' data-postid='"+elements[i].id+"'>",
				"<div class='img_gallery_item_display' style='background-image: url("+base_url+elements[i].capa+");'></div>",
				"<div class='author_gallery_item_display'>",
				"<span>Por: "+elements[i].autor+"</span>",
				"</div>",
				"<div class='info_gallery_item_display'>",
				"<p class='title_gallery_item_display'>"+elements[i].titulo+"</p>",
				"<p class='description_gallery_item_display'>"+elements[i].conteudo.substring(0, 97)+"...</p>",
				"</div>",
				"</div>",
				<?php if ($_SESSION['tipoUsuario'] != 1): ?>
				"<div class='container_menu_gallery_item_display'>",
				"<i class='fa fa-ellipsis-v more_gallery_item_display inactive' aria-hidden='true'></i>",
				"<ul class='menu_gallery_item_display inactive'>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-info-circle icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Detalhes</span>",
				"</li>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-external-link icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Visitar</span>",
				"</li>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-pencil-square-o icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Editar</span>",
				"</li>",
				"</ul>",
				"</div>",
			<?php endif ?>
			"</div>",
			"</div>");
		}

		$(".gallery_posts").html(posts.join(""));
	}

</script>

<?php $this->load->view('footer') ?>