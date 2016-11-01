<?php
$info['title'] = array('Sistema', 'Editar Imagens');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);

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

					''
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
							<h4>Editar Imagens</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="modal" tabindex="-1" role="dialog" id="img_full_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Visualizar/Editar Imagem</h4>
								</div>
								<div class="modal-body" id="img_modal_body">
									<div class="image_modal_inside col-lg-12 col-xs-12 col-md-12">
										<img src="#" alt="Não foi possível carregar" class="thumbnail col-lg-12 col-xs-12 col-md-12" id="img_modal_full" style="height: auto;">
									</div>
									<div class="tools_modal_inside">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="x_panel">
													<div class="x_title">
														<h5>Informações do Arquivo</h5>
														<div class="clearfix"></div>
													</div>
													<div class="x_content">
														<br />
														<table class="table">
															<tr>
																<td>Nome</td>
																<td id="nome_imagem_modal">nome_imagem.jpg</td>
															</tr>
															<tr>
																<td>Caminho</td>
																<td id="caminho_imagem_modal">Caminho/imagem/vai/aqui/nome_imagem.jpg</td>
															</tr>
															<tr>
																<td>Tamanho</td>
																<td id="tamanho_imagem_modal">354Kb</td>
															</tr>
														</table>
													</div>
												</div>

												<div class="x_panel">
													<div class="x_title">
														<h5>Editar Informações na Galeria</h5>
														<div class="clearfix"></div>
													</div>
													<div class="x_content">
														<br />
														<form action="<?php echo base_url('sistema/imagens/update') ?>" method="post" accept-charset="utf-8" data-parsley-validate class="form-horizontal form-label-left">
															<div class="form-group">
																<label for="titulo"  class="control-label col-md-3 col-sm-3 col-xs-12">Título</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<input id="titulo_img_modal" class="form-control col-md-7 col-xs-12" type="text" name="titulo_img_modal" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="O nome a ser exibido junto com a imagem">
																</div>
															</div>
															<div class="form-group">
																<label for="legenda_img_modal" class="control-label col-md-3 col-sm-3 col-xs-12">Legenda</label>
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<textarea id="legenda_img_modal" style="width: 100%;" rows="3" class="form-control col-md-7 col-xs-12" type="text" name="legenda_img_modal" data-container="body" data-trigger="hover" data-toggle="popover" data-placement="right" data-content="Frase ou texto curto para servir de prévia"></textarea>
																</div>
															</div>
															<div class="form-group">
																<div class="col-md-6 col-sm-6 col-xs-12 col-lg-3">
																	<input type="hidden" name="id_img_modal" id="id_img_modal" value="0">
																	<button type="submit" class="btn btn-success">Salvar</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<form action="<?php echo base_url('sistema/imagens/add'); ?>" method="post" enctype="multipart/form-data">
									<h2>Galeria de Imagens</h2>
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

										<label id="img_selecionada" for="imagens_galeria"><h4>Nenhuma imagem selecionada</h4></label> <br>
										<button type="button" class="btn btn-primary" id="img_select_galeria">Selecionar Imagens</button>
										<button type="button" class="btn btn-warning" id="btn_reset_form">Limpar</button>
										<button type="submit" class="btn btn-success" id="form_submit_galeria">Enviar</button>

										<input type="file" name="imagens_galeria[]" id="imagens_galeria" multiple style="display: none;">
										<input type="submit" name="enviar" id="submit_galeria" style="display: none;">


									</div>
								</form>
							</div>
							<div class="x_panel" id="conteudo_galeria">
								<h2>Prévia da Galeria</h2>
								<h5>Clique nas imagens para editar suas informações.</h5>
								<h5>Utilize o "x" para excluir uma imagem, ou marque duas ou mais para excluir múltiplas.</h5>

								<div class="col-md-12 col-sm-12 col-xs-12" id="select_full_gallery_div">
									<input type="checkbox" name="select_full_gallery" id="select_full_gallery" value="1" class="flat" />
									<label for="select_full_gallery">Selecionar todas as imagens</label>
								</div>

								<div class="col-md-12 col-sm-12 col-xs-12" id="excluir_multiplas_div" style="display: none;">
									<a href="javascript:void(0)" class="excluir_multiplas_link" style="text-decoration: none; color: #fff;"><button type="button" class="btn btn-danger" id="botao_delete_multiple">Deletar Múltiplas</button></a><label class="excluir_multiplas_legenda"></label>
								</div>
								<div class="x_content">
									<div class="galeria_imagens">

										<div class="row">
											<?php foreach ($imagens_galeria as $imagem_galeria) : ?>
												<div class="col-xs-12 col-md-3">
													<a class="thumbnail miniatura_galeria_sistema" href="javascript:void(0)" data-id="<?php echo $imagem_galeria->id; ?>">
														<img src="<?php echo base_url($imagem_galeria->caminho); ?>" alt="Não foi possível carregar"><a href="<?php echo base_url('sistema/imagens/excluir/' . $imagem_galeria->id) ?>"><span class="glyphicon glyphicon-remove icon_img_gallery"></span></a><a href="javascript:void(0)" class="checks_deletar_galeria"><input type="checkbox" name="multiple_delete" value="<?=$imagem_galeria->id; ?>" class="flat imagem_galeria_check" /></a>
													</a>
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
		</div>
	</div>

	<script type="text/javascript">

		$(".flat.imagem_galeria_check").on('ifChanged', function () {
			if ( $(".flat:checked").length > 1 ) {
				var imagens = getMultipleImages();

				$(".excluir_multiplas_link").prop('href', base_url + 'sistema/imagens/excluir/' + imagens['ids']);
				$(".excluir_multiplas_legenda").html(imagens['mensagem']);
				$("#excluir_multiplas_div").css('display', 'block');
			} else {
				$(".excluir_multiplas_link").prop('href', 'javascript:void(0)');
				$("#excluir_multiplas_div").css('display', 'none');
			}
		});

		$("#select_full_gallery").on('ifChecked', function () {
			$(".flat").prop('checked', true);
			$(".icheckbox_flat-green").addClass('checked');

			var imagens = getMultipleImages();

			$(".excluir_multiplas_link").prop('href', base_url + 'sistema/imagens/excluir/' + imagens['ids']);
			$(".excluir_multiplas_legenda").html(imagens['mensagem']);
			$("#excluir_multiplas_div").css('display', 'block');
		});

		$("#select_full_gallery").on('ifUnchecked', function () {
			$(".flat").prop('checked', false);
			$(".icheckbox_flat-green").removeClass('checked');

			$(".excluir_multiplas_link").prop('href', 'javascript:void(0)');
			$("#excluir_multiplas_div").css('display', 'none');
		});

		function getMultipleImages () {
			var imagens_deletar = []
			, mensagem
			, retorno = []
			;

			$(".flat.imagem_galeria_check:checked").each(function () {
				imagens_deletar.push($(this).val());
			});

			if (imagens_deletar.length == $(".flat.imagem_galeria_check").length) {
				mensagem = "Todas as " + $(".flat.imagem_galeria_check").length + " imagens selecionadas.";
				$("#select_full_gallery").prop('checked', true);
				$("#select_full_gallery_div > .icheckbox_flat-green").addClass('checked');
			} else {
				mensagem = imagens_deletar.length + " de " + $(".flat.imagem_galeria_check").length + " imagens selecionadas.";
				$("#select_full_gallery").prop('checked', false);
				$("#select_full_gallery_div > .icheckbox_flat-green").removeClass('checked');
			}

			retorno['ids'] = imagens_deletar.join('_');
			retorno['mensagem'] = mensagem;

			return retorno;
		};

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

		$(".miniatura_galeria_sistema").click(function () {

			var id = $(this).data('id');
			var url = base_url + 'sistema/imagens/getInfo/'+id;
			$.get(url, function(retorno) {
				retorno = JSON.parse(retorno);

				$("#titulo_img_modal").val(retorno.titulo);
				$("#legenda_img_modal").html(retorno.texto);
				$("#id_img_modal").val(retorno.id);
				$("#img_modal_full").attr('src', base_url + retorno.caminho);

				var caminho_imagem = base_url + retorno.caminho;
				$("#nome_imagem_modal").html(retorno.nome);
				$("#caminho_imagem_modal").html("<a href=" + caminho_imagem + ">"+ caminho_imagem +"</a>");
				$("#tamanho_imagem_modal").html(formatSizeNumber(retorno.tamanho));

				$("#img_full_modal").modal('show');
			});

		});

		function formatSizeNumber (num) {
			var retorno;
				// (retorno.tamanho / 1024).toFixed(2) + "Mb"
				num = parseFloat(num);
				if (num > 1024) {
					retorno = (num / 1024).toFixed(2) + "Mb";
					return retorno;
				}

				retorno = (num).toFixed(0) + "Kb";
				return retorno;
			}

		</script>

		<?php $this->load->view('footer') ?>