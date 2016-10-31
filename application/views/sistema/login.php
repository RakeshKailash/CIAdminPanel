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

<div class="" style="background-color: #F7F7F7;">
	<a class="hiddenanchor" id="tologin"></a>

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
						<a class="reset_pass" href="#">Esqueceu a senha?</a>
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

<?php $this->load->view('footer'); ?>