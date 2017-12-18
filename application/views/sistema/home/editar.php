<?php
$info['title'] = array('Sistema', 'Seção Home');
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
							<h4>Editar Home</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<form data-parsley-validate action="<?php echo base_url('sistema/home/update'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
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
										<div id="alerts"></div>

										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="telefone">Legenda</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="text" name="conteudo" class="form-control" value="<?=$registro->conteudo;?>">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagem">Imagem de Fundo</label>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<input type="file" name="imagem" style="display: none;" id="imagem">
												<input type="hidden" name="has_img" value="<?php echo ($registro->caminho != null) ? '1' : '0';?>" id="has_img">

												<div id='img_selecionada'>
													<?php echo $imagem; ?>
												</div>
												<button type="button" class="btn btn-primary" id="select_img">Selecionar Imagem</button>
												<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
											</div>
										</div>
										<br />

									</div>
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

	<?php $this->load->view('footer') ?>