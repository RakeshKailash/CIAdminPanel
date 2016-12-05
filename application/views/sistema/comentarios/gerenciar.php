<?php
$info['title'] = array('Sistema', 'Gerenciar Comentários');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

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
							<h4>Gerenciar Comentários</h4>
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
										<h2>Configurações de Comentários</h2>
										<form class="form-horizontal form-label-left" action="<?=base_url('sistema/comentarios/setSectionStatus')?>" method="post">
											<div class="container">
												<div class="row">
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-md-6 col-sm-6 col-xs-12">Habilitar Comentário nas Seções</label>
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
													<div class="col-md-4">
														<div class="form-group">
															<label class="control-label col-md-4 col-sm-4 col-xs-12">Aprovação de Comentários</label>
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
													<div class="col-md-4">
														<div class="form-group col-md-12">
															<button type="submit" class="btn btn-default btn_atualizar_comentario_secao">Salvar</button>
															<button type="button" class="btn btn-warning btn_limpar_comentario_secao">Limpar</button>
														</div>
													</div>
												</div>
											</form>
											<div class="ln_solid"></div>
										</div>
										<div class="col-md-12 col-xs-12">
											<h2>Comentários</h2>
										</div>
										<div class="col-md-12 col-xs-12 container_comentarios_sistema">
											<?php foreach ($comentarios as $comentario) : ?>
												<div class="comentario comentario_sistema">
													<div class="container">
														<span class="square-badge-comentarios approved-<?=!!$comentario->aprovado ? 'true' : 'false';?>">ID: <?=$comentario->idComentario;?></span>
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
															<?php if (!$comentario->aprovado): ?>
																<button type="button" class="btn btn-default btn_aprovar_comentario"  data-id="<?=$comentario->idComentario;?>">Aprovar para Exibição</button>
															<?php endif ?>
															<?php if ($comentario->aprovado): ?>
																<button type="button" class="btn btn-warning btn_desativar_comentario" data-id="<?=$comentario->idComentario;?>">Desativar Temporariamente</button>
															<?php endif ?>
															<button type="button" class="btn btn-danger btn_deletar_comentario" data-id="<?=$comentario->idComentario;?>">Excluir</button>
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
			$(".btn_deletar_comentario").click(function () {
				window.location = base_url + 'sistema/Comentarios/deletar/' + $(this).data('id');
			});

			$(".btn_aprovar_comentario").click(function () {
				window.location = base_url + 'sistema/Comentarios/aprovar/' + $(this).data('id');
			});

			$(".btn_desativar_comentario").click(function () {
				window.location = base_url + 'sistema/Comentarios/desativar/' + $(this).data('id');
			});
		</script>

		<?php $this->load->view('footer') ?>