<?php 
$info['title'] = array('Sistema', 'Editar Usuário');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$user = $this->usuario_model->getInfo('admin', 'admin');
?>

<div class="container_secao">
	<p class="titulo_secao_sistema">Editar Usuário <i class="fa fa-user" aria-hidden="true"></i></p>
	<form action="<?php echo base_url('sistema/usuario/editar'); ?>" method="post">
		<span>Nome:</span>
		<input type="text" name="nome" value="<?php echo $user['nome']; ?>">
		<br>
		<span>Usuário:</span>
		<input type="text" name="login" value="<?php echo $user['login']; ?>">
		<br>
		<span>E-mail:</span>
		<input type="text" name="email" value="<?php echo $user['email']; ?>">
		<br>

		<input type="submit" value="Salvar">
		<input type="reset" value="Limpar">
	</form>
</div>
<?php $this->load->view('footer'); ?>