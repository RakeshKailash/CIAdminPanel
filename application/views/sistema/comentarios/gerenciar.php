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
							<h4>Gerenciar Comentários</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="modal" tabindex="-1" role="dialog" id="comment_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Visualizar Comentário</h4>
								</div>
								<div class="modal-body" id="comment_modal_body">
									<div class="tools_modal_inside">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="col-md-3 col-sm-12 col-xs-12">
													<p><b>Por: </b></p>
													<p class="nome_autor">Anônimo</p>
												</div>
												<div class="col-md-3 col-sm-12 col-xs-12">
													<p><b>Em: </b></p>
													<p class="data_comentario">28/04/2017, às 11:34h</p>
												</div>
												<div class="col-md-3 col-sm-12 col-xs-12">
													<p><b>Na seção: </b></p>
													<p class="secao_comentario">Imagens</p>
												</div>
												<div class="col-md-3 col-sm-12 col-xs-12">
													<p><b>E-mail do autor: </b></p>
													<p class="email_autor">fulano@gmail.com</p>
												</div>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<span class="texto_comentario">Apenas um exemplo tosco de comentário comprido para encher o td</span>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top: 20px;">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<form action="javascript:void(0)" method="post" accept-charset="utf-8" data-parsley-validate class="form-horizontal form-label-left">
													<div class="form-group">
														<div class="col-md-12 col-sm-12 col-xs-12">
															<input type="hidden" name="id_comment_modal" id="id_comment_modal" value="0">
															<button type="button" class="btn btn-default btn_aprovar_comentario btn_modal"  data-id="<?=$comentario->idComentario;?>">Aprovar</button>
															<button type="button" class="btn btn-warning btn_desativar_comentario btn_modal" data-id="<?=$comentario->idComentario;?>">Desativar</button>
															<button type="button" class="btn btn-danger btn_deletar_comentario btn_modal" data-id="<?=$comentario->idComentario;?>">Excluir</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

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
									<?php if ($_SESSION['tipoUsuario'] == 1): ?>
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
														<div class="col-md-4">
															<div class="form-group col-md-12">
																<button type="submit" class="btn btn-default btn_atualizar_comentario_secao">Salvar</button>
																<button type="button" class="btn btn-warning btn_limpar_comentario_secao">Limpar</button>
															</div>
														</div>
													</div>
												</div>
											</form>
											<div class="ln_solid"></div>
										</div>
									<?php endif ?>
									<div class="col-md-12 col-xs-12">
										<h2>
											Administrar Comentários
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
												<?php if ($totalComments > 0): ?>
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
									<div class="col-md-12 col-xs-12">
										<table class="table">
											<thead>
												<tr>
													<th class="hidden-xs"></th>
													<th class="hidden-xs">ID</th>
													<th class="hidden-xs">Comentário</th>
													<th class="hidden-xs">Data</th>
													<th class="hidden-xs">Seção</th>
													<th class="hidden-xs">Autor</th>
													<th class="hidden-xs">E-mail do Autor</th>
													<th class="hidden-xs">Situação</th>
													<th class="hidden-xs"></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($comentarios as $comentario): ?>
													<tr class="linha_comentarios linha_tabela" data-id="<?=$comentario->idComentario;?>">
														<td>
															<div class="checkbox check_comentarios">
																<input type="checkbox" name="select_all_comments" value="0" class="flat" data-id="<?=$comentario->idComentario;?>" />
															</div>
														</td>
														<td class="hidden-xs"><?=$comentario->idComentario;?></td>
														<td><?=$comentario->textoComentario;?></td>
														<td class="hidden-xs"><?=date('d/m/Y\ \à\s H:i\h', strtotime($comentario->dataComentario));?></td>
														<td class="hidden-xs"><?=$comentario->nomeSecao;?></td>
														<td class="hidden-xs"><?=$comentario->nomeAutor;?></td>
														<td class="hidden-xs"><?=empty($comentario->emailAutor) ? "<i>Não informado<i>" : $comentario->emailAutor;?></td>
														<td>
															<i class="fa fa-<?=!!$comentario->aprovado ? 'check' : 'times'?>"></i> <?=!!$comentario->aprovado ? "Aprovado para Exibição" : "Aguardando Aprovação";?>
														</td>
														<td>
															<?php if (!$comentario->aprovado): ?>
																<button type="button" class="btn btn-default btn_aprovar_comentario"  data-id="<?=$comentario->idComentario;?>">Aprovar</button>
															<?php endif ?>
															<?php if ($comentario->aprovado): ?>
																<button type="button" class="btn btn-warning btn_desativar_comentario" data-id="<?=$comentario->idComentario;?>">Desativar</button>
															<?php endif ?>
															<button type="button" class="btn btn-danger btn_deletar_comentario" data-id="<?=$comentario->idComentario;?>">Excluir</button>
														</td>
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
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
		$(".linha_comentarios").click(function (e) {
			var target = e.target || e.srcElement;
			if (isNotAButton(target.className)) {

				var id = $(this).data('id');
				var url = base_url + 'sistema/comentarios/getInfo/'+id;
				$.get(url, function(retorno) {
					retorno = JSON.parse(retorno);

					var situacao = "<span class='badge bg-orange'><i class='fa fa-times-circle'></i> Aguardando Aprovação</span>";

					$(".nome_autor").html(retorno.nomeAutor);
					$(".data_comentario").html(retorno.dataComentario);
					$(".secao_comentario").html(retorno.nomeSecao);
					$(".email_autor").html(retorno.emailAutor);
					$(".texto_comentario").html("<i>"+retorno.textoComentario+"</i>");

					$(".btn_modal").attr('data-id', retorno.idComentario);

					if (retorno.aprovado == 1) {
						$(".btn_aprovar_comentario.btn_modal").css('display', 'none');
						$(".btn_desativar_comentario.btn_modal").css('display', 'inline-block');
						situacao = "<span class='badge bg-green'><i class='fa fa-check-circle'></i> Aprovado para Exibição</span>";
					}

					if (retorno.aprovado == 0) {
						$(".btn_aprovar_comentario.btn_modal").css('display', 'inline-block');
						$(".btn_desativar_comentario.btn_modal").css('display', 'none');
					}

					$(".modal-title").html("Visualizar comentário "+situacao);
					$("#comment_modal").modal('show');
				});
			}
		});

		function isNotAButton ($className)
		{
			if ($className == "btn btn-default btn_aprovar_comentario") {
				return false;
			}

			if ($className == "btn btn-danger btn_deletar_comentario") {
				return false;
			}

			if ($className == "btn btn-warning btn_desativar_comentario") {
				return false;
			}

			return true;
		}

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

			$(".checkbox.check_comentarios").parents("tr").css("background", "#eee");

			if ($(".checkbox.check_comentarios .flat:checked").length > 1) {
				$(".buttons_comments").css('display', 'inline-block');
			}

		});

		$("#select_all_comments .flat").on('ifUnchecked', function () {
			checkboxControl.uncheck(".checkbox.check_comentarios");
			$(".checkbox.check_comentarios").parents("tr").css("background", "#fff");
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

		$(".checkbox.check_comentarios .flat").on('ifChecked', function () {
			$(this).parents("tr").css("background", "#eee");
		});

		$(".checkbox.check_comentarios .flat").on('ifUnchecked', function () {
			$(this).parents("tr").css("background", "#fff");
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