<?php
$info['title'] = array('Sistema', 'Contas de Usuário');
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
							<h4>Contas de Usuário</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12">
										<h2>Alterar Minha Conta</h2>
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
										<form class="form-horizontal form-label-left" id="form_editar_usuario" action="<?=base_url('sistema/usuarios/update')?>" method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Nome: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="nome" class="form-control" value="<?=$_SESSION['nome']?>" required="required">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Sobrenome:</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="sobrenome" class="form-control" value="<?=$_SESSION['sobrenome']?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Data de Nascimento: <span class="required">*</span>
												</label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input id="nascimento" name="data_nascimento" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="<?=$_SESSION['dataNascimento']?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Nome de Usuário: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="nome_usuario" class="form-control" value="<?=$_SESSION['login']?>" required="required">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="email_usuario" class="form-control" value="<?=$_SESSION['email']?>" required="required">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Imagem de Perfil:</label>
												<div class="col-md-6 col-sm-6 col-xs-12" style="text-align: center;">
													<div class="container">
														<div class="col-md-6 col-xs-12">
															<div id='img_selecionada'>
																<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem'])?>" alt="Não foi possível carregar a imagem" class="profile_img_userpage">
															</div>
														</div>
														<div class="col-md-6 col-xs-12">
															<button type="button" class="btn btn-primary" id="select_img" style="margin-top: 20px;">Selecionar Imagem</button>
															<button type="button" class="btn btn-danger" id="remove_img">Remover Imagem</button>
															<input type="file" name="imagem" style="display: none;" id="imagem">
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="id_usuario" value="<?=$_SESSION['id']?>">
													<input type="hidden" name="has_img" value="<?=$_SESSION['imagem'] == 'user.png' ? '0' : '1'?>" id="has_img">
													<button type="reset" class="btn btn-warning">Limpar</button>
													<button type="submit" id="salvar_edicao_usuario" class="btn btn-success">Salvar</button>
												</div>
											</div>
										</form>
										<div class="ln_solid"></div>
										<h2>Gerenciar Usuários</h2>
										<table class="table">
											<thead>
												<tr>
													<th>ID</th>
													<th>Imagem de Perfil</th>
													<th>Nome Completo</th>
													<th>Data de Nascimento</th>
													<th>E-mail</th>
													<th>Login</th>
													<th>Último Acesso</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($usuarios as $usuario): ?>
													<tr>
														<th scope="row"><?=$usuario->id?></th>
														<td><img class="mini-thumb" src="<?=base_url('images/uploads/profile/' . $usuario->imagem)?>" alt="Não foi possível localizar a imagem"></td>
														<td><?=$usuario->nome . ' ' . $usuario->sobrenome?></td>
														<td><?=$usuario->dataNascimento?></td>
														<td><?=$usuario->email?></td>
														<td><?=$usuario->login?></td>
														<td><?=$usuario->ultimoAcesso?></td>
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
</div>


<?php $this->load->view('footer') ?>