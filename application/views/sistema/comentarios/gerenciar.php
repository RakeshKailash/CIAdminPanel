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
									<div class="col-md-12 container_comentarios_sistema">
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
										<?php foreach ($comentarios as $comentario) : ?>
											<div class="comentario comentario_sistema">
												<div class="container">
													<span class="square-badge-comentarios approved-<?=!!$comentario->aprovado ? 'true' : 'false';?>">ID: <?=$comentario->idComentario;?></span>
													<div class="col-md-4">
														<span class='autor_comentario'><?=$comentario->nomeAutor;?></span>
														<span class='data_comentario'><?=", em ".date('d/m/Y\ \à\s H:i\h', strtotime($comentario->dataComentario));?></span>
														<p class='texto_comentario'><?=$comentario->textoComentario;?></p>
													</div>
													<div class="col-md-4 detalhes_comentario_sistema">
														<p>
															<span class="label_comentarios_sistema title_label">E-mail:</span>
															<span class="label_comentarios_sistema"><?=empty($comentario->emailAutor) ? "Não informado" : $comentario->emailAutor;?></span>
														</p>
														<p>
															<span class="label_comentarios_sistema title_label">Seção:</span>
															<span class="label_comentarios_sistema"><?=$comentario->nomeSecao;?></span>
														</p>
													</div>
													<div class="col-md-4 detalhes_comentario_sistema">
														<p>
															<span class="label_comentarios_sistema title_label">Status:</span>
															<span class="label_comentarios_sistema"><i class="fa fa-<?=!!$comentario->aprovado ? 'check' : 'times'?>"></i> <?=!!$comentario->aprovado ? "Aprovado para Exibição" : "Aguardando Aprovação";?></span>
														</p>
														<?php if (!$comentario->aprovado): ?>
															<button type="button" class="btn btn-default btn_aprovar_comentario"  data-id="<?=$comentario->idComentario;?>">Aprovar para Exibição</button>
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
	</script>

	<?php $this->load->view('footer') ?>