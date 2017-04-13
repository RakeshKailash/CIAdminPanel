<?php
$info['title'] = array('Sistema', 'Comentários');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

$totalComments = count($comentarios);
$disabledComments = 0;
$enabledComments = 0;

foreach ($comentarios as $comentario) {
	if ($comentario->aprovado)
	{
		$enabledComments++;
	} else {
		$disabledComments++;
	}
}

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
							<h4><?=$_SESSION['tipoUsuario'] == 1 ? 'Gerenciar' : 'Visualizar'?> Comentários</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
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
									<div class="col-md-12">
										<h2>Configurar Comentários</h2>
										<form class="form-horizontal form-label-left" action="<?=base_url('sistema/comentarios/setSectionStatus')?>" method="post">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-md-6 col-sm-6 col-xs-12">Habilitar Comentário nas Seções</label>
															<div class="container">
																<div class="col-md-6 col-sm-6 col-xs-12">
																	<div class="checkbox">
																		<label><input type="checkbox" name="secoes_valores[]" value="2" class="flat" <?=$statusSections[1]->comentarios?> /> Serviços</label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" name="secoes_valores[]" value="3" class="flat" <?=$statusSections[2]->comentarios?> /> Empresa</label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" name="secoes_valores[]" value="4" class="flat" <?=$statusSections[3]->comentarios?> /> Imagens</label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" name="secoes_valores[]" value="5" class="flat" <?=$statusSections[4]->comentarios?> /> Contato</label>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-md-4 col-sm-4 col-xs-12">Aprovação de Comentários</label>
															<div class="container">
																<div class="col-md-8 col-sm-8 col-xs-12">
																	<div class="radio">
																		<input type="radio" class="flat" name="aprovacao_comentarios" id="aprovY" value="1" required <?=!!$auto_approve->valor ? 'checked' : '' ?> /> Auto-aprovar
																	</div>
																	<div class="radio">
																		<input type="radio" class="flat" name="aprovacao_comentarios" id="aprovN" value="0" <?=!!$auto_approve->valor ? '' : 'checked' ?> /> Aguardar Aprovação Manual
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php if ($_SESSION['tipoUsuario'] == 1): ?>
														<div class="col-md-4">
															<div class="form-group col-md-12">
																<button type="submit" class="btn btn-default btn_atualizar_comentario_secao">Salvar</button>
																<button type="button" class="btn btn-warning btn_limpar_comentario_secao">Limpar</button>
															</div>
														</div>
													<?php endif ?>
												</div>
											</div>
										</form>
										<div class="ln_solid"></div>
									</div>
									<div class="col-md-12 col-xs-12">
										<h2>
											Administrar Comentários
											<?php if ($totalComments > 0): ?>
												<label class="lbl_exibir_comentario green"><span class="glyphicon glyphicon-eye-open icon_inline"></span> Exibir</label>
											<?php endif ?>
										</h2>
										<h5 class="bg-blue badge"><?=$totalComments?> comentários registrados</h5>
										<?php if ($enabledComments > 0): ?>
											<h5 class="bg-green badge"><?=$enabledComments?> aprovados</h5>
										<?php endif ?>
										<?php if ($disabledComments > 0): ?>
											<h5 class="bg-orange badge"><?=$disabledComments?> aguardando aprovação</h5>
										<?php endif ?>
										<div class="container">
											<div class="col-md-12">
												<?php if ($totalComments > 0 && $_SESSION['tipoUsuario'] == 1): ?>
													<div class="checkbox" id="select_all_comments">
														<label style="padding-left: 0;" for="select_all_comments"><input type="checkbox" name="select_all_comments" value="0" class="flat" /> Selecionar todos</label>
													</div>
													<div class="buttons_comments" style="display: none;">
														<button type="button" class="btn btn-default" id="btn_aprovar_multiple"><span class="glyphicon glyphicon-ok icon_inline icone_save"></span> Aprovar Múltiplos</button>
														<button type="button" class="btn btn-default" id="btn_desativar_multiple"><span class="glyphicon glyphicon-ban-circle icon_inline icone_alert"></span> Desativar Múltiplos</button>
														<button type="button" class="btn btn-default" id="btn_delete_multiple"><span class="glyphicon glyphicon-remove icon_inline icone_delete"></span> Excluir Múltiplos</button>
													</div>
												<?php endif ?>
											</div>
										</div>
									</div>
									<div class="col-md-12 col-xs-12 container_comentarios_sistema" style="display: none;">
										<?php foreach ($comentarios as $comentario) : ?>
											<div class="comentario comentario_sistema">
												<div class="container">
													<span class="square-badge-comentarios">ID: <?=$comentario->idComentario;?></span>
													<?php if ($_SESSION['tipoUsuario'] == 1): ?>
														<div class="checkbox check_comentarios">
															<input type="checkbox" name="select_all_comments" value="0" class="flat" data-id="<?=$comentario->idComentario;?>" />
														</div>
													<?php endif ?>
													<div class="col-md-4 col-xs-12">
														<span class='autor_comentario'><?=$comentario->nomeAutor;?></span>
														<span class='data_comentario'><?=", em ".date('d/m/Y\ \à\s H:i\h', strtotime($comentario->dataComentario));?></span>
														<p class='texto_comentario'><?=$comentario->textoComentario;?></p>
													</div>
													<div class="col-md-4 col-xs-12 detalhes_comentario_sistema">
														<p>
															<span class="label_comentarios_sistema title_label">E-mail:</span>
															<span class="label_comentarios_sistema"><?=empty($comentario->emailAutor) ? "Não informado" : $comentario->emailAutor;?></span>
														</p>
														<p>
															<span class="label_comentarios_sistema title_label">Seção:</span>
															<span class="label_comentarios_sistema"><?=$comentario->nomeSecao;?></span>
														</p>
													</div>
													<div class="col-md-4 col-xs-12 detalhes_comentario_sistema">
														<p>
															<span class="label_comentarios_sistema title_label">Status:</span>
															<span class="label_comentarios_sistema"><i class="fa fa-<?=!!$comentario->aprovado ? 'check' : 'times'?>"></i> <?=!!$comentario->aprovado ? "Aprovado para Exibição" : "Aguardando Aprovação";?></span>
														</p>
														<?php if ($_SESSION['tipoUsuario'] == 1): ?>
															<?php if (!$comentario->aprovado): ?>
																<button type="button" class="btn btn-default btn_aprovar_comentario"  data-id="<?=$comentario->idComentario;?>">Aprovar</button>
															<?php endif ?>
															<?php if ($comentario->aprovado): ?>
																<button type="button" class="btn btn-warning btn_desativar_comentario" data-id="<?=$comentario->idComentario;?>">Desativar</button>
															<?php endif ?>
															<button type="button" class="btn btn-danger btn_deletar_comentario" data-id="<?=$comentario->idComentario;?>">Excluir</button>
														<?php endif ?>
													</div>
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

	<script type="text/javascript">
		$(".lbl_exibir_comentario").click(function () {
			if ($(".container_comentarios_sistema").css('display') == 'none') {
				$(".container_comentarios_sistema").css('display', 'block');
				$(".lbl_exibir_comentario").html("<span class='glyphicon glyphicon-eye-close icon_inline'></span> Esconder");
				$(".lbl_exibir_comentario").addClass('red');
				$(".lbl_exibir_comentario").removeClass('green');
			} else {
				$(".container_comentarios_sistema").css('display', 'none');
				$(".lbl_exibir_comentario").html("<span class='glyphicon glyphicon-eye-open icon_inline'></span> Exibir");
				$(".lbl_exibir_comentario").addClass('green');
				$(".lbl_exibir_comentario").removeClass('red');
			}
		});

		$(".btn_deletar_comentario").click(function () {
			window.location = base_url + 'sistema/Comentarios/deletar/' + $(this).data('id');
		});

		$(".btn_aprovar_comentario").click(function () {
			window.location = base_url + 'sistema/Comentarios/aprovar/' + $(this).data('id');
		});

		$(".btn_desativar_comentario").click(function () {
			window.location = base_url + 'sistema/Comentarios/desativar/' + $(this).data('id');
		});

		$("#select_all_comments .flat").on('ifChecked', function () {
			checkboxControl.check(".checkbox.check_comentarios");

			if ($(".container_comentarios_sistema").css('display') == 'none') {
				$(".lbl_exibir_comentario").trigger('click');
			}

			if ($(".checkbox.check_comentarios .flat:checked").length > 1) {
				$(".buttons_comments").css('display', 'inline-block');
			}
		});

		$("#select_all_comments .flat").on('ifUnchecked', function () {
			checkboxControl.uncheck(".checkbox.check_comentarios");
			$(".buttons_comments").css('display', 'none');
		});

		$(".checkbox.check_comentarios .flat").on('ifChanged', function () {
			if ($(".checkbox.check_comentarios .flat:checked").length != $(".checkbox.check_comentarios .flat").length) {
				checkboxControl.uncheck("#select_all_comments");
			} else {
				checkboxControl.check("#select_all_comments");
			}

			if ($(".checkbox.check_comentarios .flat:checked").length > 1) {
				$(".buttons_comments").css('display', 'inline-block');
			} else {
				$(".buttons_comments").css('display', 'none');
			}
		});

		$("#btn_delete_multiple").click(function () {
			var idsDeletar = [];
			$(".checkbox.check_comentarios .flat:checked").each(function () {
				idsDeletar.push($(this).data('id'));
			});

			idsDeletar = idsDeletar.join("_");

			window.location = base_url + 'sistema/Comentarios/deletar/' + idsDeletar;
		});

		$("#btn_desativar_multiple").click(function () {
			var idsDesativar = [];
			$(".checkbox.check_comentarios .flat:checked").each(function () {
				idsDesativar.push($(this).data('id'));
			});

			idsDesativar = idsDesativar.join("_");

			window.location = base_url + 'sistema/Comentarios/desativar/' + idsDesativar;
		});

		$("#btn_aprovar_multiple").click(function () {
			var idsAprovar = [];
			$(".checkbox.check_comentarios .flat:checked").each(function () {
				idsAprovar.push($(this).data('id'));
			});

			idsAprovar = idsAprovar.join("_");

			window.location = base_url + 'sistema/Comentarios/aprovar/' + idsAprovar;
		});

		var checkboxControl = {};
		checkboxControl.check = function (nomeDiv) {
			if (nomeDiv == null) {
				nomeDiv = ".checkbox";
			}

			$(nomeDiv + " .flat").prop('checked', true);
			$(nomeDiv + " .icheckbox_flat-green").addClass('checked');

		};

		checkboxControl.uncheck = function (nomeDiv) {
			if (nomeDiv == null) {
				nomeDiv = ".checkbox";
			}

			$(nomeDiv + " .flat").prop('checked', false);
			$(nomeDiv + " .icheckbox_flat-green").removeClass('checked');
		}
	</script>

	<?php $this->load->view('footer') ?>