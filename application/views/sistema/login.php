<?php 
$info['title'] = array('Sistema', 'Login');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
if ($this->session->userdata('login') != null) {
	redirect('sistema');
}
?>

<div class="" style="background-color: #F7F7F7;">
	<a class="hiddenanchor" id="tologin"></a>

	<div id="wrapper">
		<div id="login" class="animate form">
			<section class="login_content">
				<form method="post" action="<?php echo base_url('sistema/login'); ?>">
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
			<!-- content -->
		</div>
	</div>
</div>

<?php $this->load->view('footer'); ?>