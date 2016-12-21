<?php
$info['title'] = array('Sistema', 'Login');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
// if ($this->session->userdata('login') != null) {
// 	redirect('sistema');
// }

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

?>

<style type="text/css">
	body {
		background: #F7F7F7;
		overflow: hidden;
	}
</style>

<div>
	<a class="hiddenanchor" id="tologin"></a>

				<div class="modal" role="dialog" id="pass_recover_modal">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="title_pass_modal">Recuperação de Senha</h4>
							</div>
							<div class="modal-body" style="overflow: hidden;">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12">
											<form class="form-horizontal form-label-left" action="<?=base_url('sistema/usuarios/lost_password')?>" method="post" accept-charset="utf-8">
												<div class="form-group">
													<label for="email_pass_recover" class="control-label col-md-4 col-sm-6 col-xs-12">E-mail cadastrado</label>
													<div class="col-md-4 col-sm-6 col-xs-12">
														<input type="text" name="email_pass_recover" placeholder="E-mail cadastrado na sua conta" class="form-control">
													</div>
												</div>
												<div class="form-group col-md-4">
													<button type="submit" class="btn btn-success submit">Enviar</button>
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
	<div id="wrapper">
		<div id="login" class="animate form">
			<section class="login_content">


				<form method="post" action="<?php echo base_url('sistema/main/logar'); ?>">
					<h1>Entrar no Sistema</h1>

					<div>
						<input type="text" class="form-control" placeholder="Usuário" required="" name="login" />
					</div>
					<div>
						<input type="password" class="form-control" placeholder="Senha" required="" name="senha" />
					</div>
					<div>
						<input class="btn btn-default submit" type="submit" value="Entrar">
						<a class="reset_pass" href="javascript:void(0)">Esqueceu a senha?</a>
					</div>
					<div class="clearfix"></div>
				</form>
				<!-- form -->
			</section>
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
			<!-- content -->
		</div>
	</div>
</div>

<script>
	$(".reset_pass").click(function () {
		$("#pass_recover_modal").modal('show');
	})
</script>

<?php $this->load->view('footer'); ?>