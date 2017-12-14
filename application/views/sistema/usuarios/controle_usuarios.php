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

					<div class="modal" tabindex="-1" role="dialog" id="user_full_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="title_user_modal">Visualizar/Editar Usuário</h4>
								</div>
								<div class="modal-body" id="img_modal_body" style="overflow: hidden;">
									<div class="col-lg-4 col-xs-12 col-md-4" style="text-align: center;">
										<p><b>Imagem de Perfil</b></p>
										<img src="#" alt="Não foi possível carregar" class="thumbnail col-lg-12 col-xs-12 col-md-12" id="img_modal_full" style="height: auto;">
									</div>
									<div class="tools_modal_inside col-md-8">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<form action="<?=base_url('sistema/usuarios/delete')?>" method="post" accept-charset="utf-8">
													<table class="table">
														<tr>
															<th>ID</th>
															<td id="id_usuario_modal">ID</td>
														</tr>
														<tr>
															<th>Nome Completo</th>
															<td id="nome_usuario_modal">Nome Completo</td>
														</tr>
														<tr>
															<th>Data de Nascimento</th>
															<td id="nascimento_usuario_modal">00/00/0000</td>
														</tr>
														<tr>
															<th>E-mail</th>
															<td id="email_usuario_modal">exemplo@exemplo.com</td>
														</tr>
														<tr>
															<th>Privilégios</th>
															<td id="privilegios_usuario_modal">Colaborador</td>
														</tr>
														<tr>
															<th>Login</th>
															<td id="login_usuario_modal">exemplo</td>
														</tr>
														<tr>
															<th>Último Acesso</th>
															<td id="acesso_usuario_modal">00/00/0000</td>
														</tr>
													</table>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12 col-lg-3">
															<input type="hidden" name="id_usuario_modal" id="id_usuario_hidden" value="">
															<?php if ($_SESSION['tipoUsuario'] == 1): ?>
																<button type="submit" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Excluir Usuário</button>
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
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<div class="modal" tabindex="-1" role="dialog" id="user_pass_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="title_user_modal">Alterar Senha</h4>
								</div>
								<div class="modal-body" id="pass_modal_body" style="overflow: hidden;">
									<div class="tools_modal_inside col-md-12">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<form action="<?=base_url('sistema/usuarios/update_current_password')?>" method="post" accept-charset="utf-8" class="form-horizontal form-label-left">
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="oldpass_usuario_modal">Senha Atual</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="oldpass_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="newpass_usuario_modal">Nova Senha</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="newpass_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="newpass_confirm_usuario_modal">Confirme a Nova Senha</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="newpass_confirm_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12 col-lg-3">
															<input type="hidden" name="id_usuario_modal" value=<?=$_SESSION['id']?>>
															<button type="submit" class="btn btn-success">Salvar</button>
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
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal senha -->

					<div class="modal" tabindex="-1" role="dialog" id="user_create_modal">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="title_user_modal">Novo Usuário</h4>
								</div>
								<div class="modal-body" id="create_modal_body" style="overflow: hidden;">
									<div class="tools_modal_inside col-md-12">
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<form action="<?=base_url('sistema/usuarios/create')?>" method="post" accept-charset="utf-8" class="form-horizontal form-label-left">
													<div class="form-group col-md-4 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="name_usuario_modal">Nome</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="text" name="name_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group col-md-4 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="surname_usuario_modal">Sobrenome</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="text" name="surname_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group col-md-4 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="birth_usuario_modal">Data de Nascimento</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12 daterange_container">
															<input type="text" name="birth_usuario_modal" data-inputmask="'mask': '99/99/9999'" class="form-control">
															<!-- <input id="nascimento_novo_usuario" name="birth_usuario_modal" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text"> -->
														</div>
													</div>
													<div class="form-group col-md-6 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="login_usuario_modal">Nome de Usuário (utilizado para acessar o sistema)</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="text" name="login_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group col-md-6 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="email_confirm_usuario_modal">E-mail</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="text" name="email_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group col-md-6 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="pass_usuario_modal">Senha (no mínimo 8 caracteres)</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="pass_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group col-md-6 col-sm-12">
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="repass_usuario_modal">Repita a Senha</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="repass_usuario_modal" class="form-control">
														</div>
													</div>
													<div class="form-group">
														<div class="col-md-12 col-sm-6 col-xs-12 col-lg-3">
															<button type="submit" class="btn btn-success">Salvar</button>
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
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal senha -->

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12 col-xs-12">
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
										<form class="form-horizontal form-label-left" id="form_editar_usuario" action="<?=base_url('sistema/usuarios/update_current')?>" method="post" enctype="multipart/form-data">
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
													<div class="col-md-6 col-xs-12">
														<div id='img_selecionada'>
															<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem'])?>" alt="Não foi possível carregar a imagem" class="preview_img_form">
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
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="id_usuario" value="<?=$_SESSION['id']?>">
													<input type="hidden" name="has_img" value="<?=$_SESSION['imagem'] == 'user.png' ? '0' : '1'?>" id="has_img">
													<button type="reset" class="btn btn-warning">Limpar</button>
													<button type="submit" id="salvar_edicao_usuario" class="btn btn-success">Salvar</button>
													<button type="button" id="alterar_senha_usuario" class="btn btn-primary">Alterar Senha</button>
												</div>
											</div>
										</form>
										<?php if ($_SESSION['tipoUsuario'] != 2): ?>
											<div class="ln_solid"></div>
											<h2>Gerenciar Usuários</h2>
											<?php if ($_SESSION['tipoUsuario'] == 1): ?>
												<button type="button" class="btn btn-success create_user"><i class="fa fa-plus" aria-hidden="true"></i> Novo Usuário</button>
												<div id="excluir_multiplas_div" style="display: none;">
													<label class="excluir_multiplas_legenda"></label> <br>
													<a href="javascript:void(0)" class="excluir_multiplas_link" style="text-decoration: none; color: #fff;"><button type="button" class="btn btn-default" id="botao_delete_multiple"><span class="glyphicon glyphicon-remove icon_inline icone_delete"></span> Excluir Múltiplos</button></a>
												</div>
											<?php endif; ?>
											<table class="table">
												<thead>
													<tr>
														<th></th>
														<th></th>
														<th>Nome Completo</th>
														<th class="hidden-xs">Data de Nascimento</th>
														<th class="hidden-xs">E-mail</th>
														<th class="hidden-xs">Login</th>
														<th class="hidden-xs">Último Acesso</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($usuarios as $usuario): ?>
														<?php if ($usuario->id != $_SESSION['id']): ?>
															<tr class="linha_usuario linha_tabela" data-userid="<?=$usuario->id?>">
																<td>
																	<?php if ($_SESSION['tipoUsuario'] == 1): ?>
																		<div class="checkbox check_usuarios">
																			<input type="checkbox" name="select_all_users" value="<?=$usuario->id?>" class="flat usuario_check" />
																		</div>
																	<?php endif ?>
																</td>
																<td style="position: relative;">
																	<span class="status_span"></span>
																	<img class="mini-thumb" src="<?=base_url('images/uploads/profile/' . $usuario->imagem)?>" alt="Não foi possível localizar a imagem">
																</td>
																<td><?=$usuario->nome . ' ' . $usuario->sobrenome?></td>
																<td class="hidden-xs"><?=$usuario->dataNascimento?></td>
																<td class="hidden-xs"><?=$usuario->email?></td>
																<td class="hidden-xs"><?=$usuario->login?></td>
																<td class="hidden-xs"><?=$usuario->ultimoAcesso?></td>
																<td class="delete_user_td" style="vertical-align: middle;"><a href="javascript:void(0)" data-userid="<?=$usuario->id?>" title="Excluir usuário"><span class="glyphicon glyphicon-remove anim_icon icone_delete" style="font-size: 18pt;"></span></a></td>
															</tr>
														<?php endif ?>
													<?php endforeach ?>
												</tbody>
											</table>
										<?php endif ?>
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
	var curUserProps = <?=json_encode($_SESSION) ?>;

	getOnlineUsers();

	$(".delete_user_td > a, .excluir_multiplas_link").on('click', function () {
		var id = $(this).data('userid');

		if (! id) {
			return false;
		}

		swal({
			title: 'Deseja excluir o(s) usuário(s)?',
			text: "Essa ação não pode ser desfeita!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Sim, excluir'
		}).then((result) => {
			if (result.value) {
				window.location = base_url + 'sistema/usuarios/delete/' + id;
			}
		});
	});

	$(".linha_usuario").click(function (e) {
		var target = e.target || e.srcElement;
		if (target.className != "glyphicon glyphicon-remove anim_icon icone_delete") {

			var id = $(this).data('userid');
			var url = base_url + 'sistema/usuarios/get_info/'+id;
			$.get(url, function(retorno) {
				retorno = JSON.parse(retorno);

				if (retorno.status == 0) {
					return false;
				}

				var usuario = retorno.user;

				$("#id_usuario_modal").html(usuario.id);
				$("#id_usuario_hidden").val(usuario.id);
				$("#nome_usuario_modal").html(usuario.nome + " " + usuario.sobrenome);
				$("#title_user_modal").html("Editar Usuário: <b>" + usuario.nome + "</b>")
				$("#nascimento_usuario_modal").html(usuario.dataNascimento);
				$("#email_usuario_modal").html(usuario.email);
				$("#privilegios_usuario_modal").html(usuario.tipoUsuarioNome);

				$("#login_usuario_modal").html(usuario.login);
				$("#acesso_usuario_modal").html(usuario.ultimoAcesso);
				$("#img_modal_full").prop('src', base_url + 'images/uploads/profile/' + usuario.imagem);

				$("#user_full_modal").modal('show');

			});
		}
	});

	$("#alterar_senha_usuario").click(function () {
		$("#user_pass_modal").modal('show');
	})

	$(".create_user").click(function () {
		$("#user_create_modal").modal('show');
	});

	window.setInterval(function () {
		getOnlineUsers();
	}, 10000);

	function getOnlineUsers () {
		var url = base_url + 'sistema/main/get_online_users';
		$.get(url, function (retorno) {
			retorno = JSON.parse(retorno);

			var id = null
			, status = 'offline'
			, badge_color = 'red'
			;

			for (var i = 0; i < retorno.length; i++) {
				id = retorno[i].id;

				status = 'offline';
				badge_color = 'red';

				if (retorno[i].status == "1") {
					status = 'online';
					badge_color = 'green';
				}

				$(".linha_usuario[data-userid~='"+id+"'] > td > span.status_span").removeClass('bg-red');
				$(".linha_usuario[data-userid~='"+id+"'] > td > span.status_span").removeClass('bg-green');

				$(".linha_usuario[data-userid~='"+id+"'] > td > span.status_span").addClass('bg-' + badge_color);
			}
		})
	}
</script>

<?php $this->load->view('footer') ?>