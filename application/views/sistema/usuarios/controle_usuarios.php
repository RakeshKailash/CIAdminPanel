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
												<form action="<?=base_url('sistema/usuarios/update_another')?>" method="post" accept-charset="utf-8">
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
															<input type="hidden" name="id_usuario_modal" id="id_usuario_hidden" value="0">
															<?php if ($_SESSION['tipoUsuario'] == 3 || $_SESSION['tipoUsuario'] == 4): ?>
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
														<div class="col-md-12 col-sm-6 col-xs-12">
															<label class="control-label" for="oldpass_usuario_modal">Senha Antiga</label>
														</div>
														<div class="col-md-12 col-sm-6 col-xs-12">
															<input type="password" name="oldpass_usuario_modal" class="form-control">
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
															<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem'])?>" alt="Não foi possível carregar a imagem" class="profile_img_userpage">
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
											<table class="table">
												<thead>
													<tr>
														<th>ID</th>
														<th style="text-align: center;">Imagem de Perfil</th>
														<th>Nome Completo</th>
														<th class="hidden-xs">Data de Nascimento</th>
														<th class="hidden-xs">E-mail</th>
														<th class="hidden-xs">Login</th>
														<th class="hidden-xs">Último Acesso</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($usuarios as $usuario): ?>
														<tr class="linha_usuario" data-userid="<?=$usuario->id?>">
															<th scope="row"><?=$usuario->id?></th>
															<td style="text-align: center;"><img class="mini-thumb" src="<?=base_url('images/uploads/profile/' . $usuario->imagem)?>" alt="Não foi possível localizar a imagem"></td>
															<td><?=$usuario->nome . ' ' . $usuario->sobrenome?></td>
															<td class="hidden-xs"><?=$usuario->dataNascimento?></td>
															<td class="hidden-xs"><?=$usuario->email?></td>
															<td class="hidden-xs"><?=$usuario->login?></td>
															<td class="hidden-xs"><?=date( 'd/m/Y H:i:s', strtotime($usuario->ultimoAcesso))?></td>
														</tr>
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

	$(".linha_usuario").click(function () {
		var id = $(this).data('userid');
		var url = base_url + 'sistema/usuarios/getInfo/'+id;
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
			var options = ['Monitor', 'Criador de Conteúdo', 'Administrador'];

			if (usuario.id == curUserProps.id || curUserProps.tipoUsuario == 1 || curUserProps.tipoUsuario == 2) {
				$("#privilegios_usuario_modal").html(usuario.tipoUsuario);
			} else {
				$("#privilegios_usuario_modal").html(createSelectWith(options, usuario.tipoUsuario));
			}

			$("#login_usuario_modal").html(usuario.login);
			$("#acesso_usuario_modal").html(usuario.ultimoAcesso);
			$("#img_modal_full").prop('src', base_url + 'images/uploads/profile/' + usuario.imagem);

			$("#user_full_modal").modal('show');

		});
	});

	$("#alterar_senha_usuario").click(function () {
		$("#user_pass_modal").modal('show');
	})

	function createSelectWith (options, selectedItem) {
		var htmlOptions = []
		, htmlSelect = "<select class='form-control' id='select_user_type' name='tipo_usuario'>"
		, value
		, selected = ""
		;

		for (var i = 0; i < options.length; i++) {
			if (options[i] == selectedItem) {
				selected = "selected";
			}

			value = i + 1;
			htmlOptions.push("<option "+selected+" value='"+value+"'>"+options[i]+"</option>");

			selected = "";
		}

		htmlSelect += htmlOptions.join('');
		htmlSelect += "</select>";

		return htmlSelect;

	}
</script>

<?php $this->load->view('footer') ?>