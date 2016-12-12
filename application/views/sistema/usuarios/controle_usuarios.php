<?php
$info['title'] = array('Sistema', 'Contas de Usuário');
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
							<h4>Contas de Usuário</h4>
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
										<h2>Alterar Minha Conta</h2>
										<form class="form-horizontal form-label-left" action="<?=base_url('sistema/usuarios/update')?>" method="post">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Nome de Usuário:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="nome_usuario" class="form-control" value="<?=$_SESSION['login']?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="email_usuario" class="form-control" value="<?=$_SESSION['email']?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Imagem de Perfil:</label>
												<div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;">
													<div class="container">
														<div class="col-md-4 col-xs-12">
															<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem'])?>" alt="Não foi possível carregar a imagem" class="profile_img_userpage">
														</div>
														<div class="col-md-4 col-xs-12">
															<button type="button" class="btn btn-primary" id="select_img" style="margin-top: 20px;">Selecionar Imagem</button>
															<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
														</div>
													</div>
												</div>
											</div>
										</form>
										<div class="ln_solid"></div>
										<h2>Gerenciar Usuários</h2>
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