<?php
$info['title'] = array('Sistema', 'Redefinição de Senha');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);

?>

<style type="text/css">
	body {
		background: #F7F7F7;
		overflow: hidden;
	}
</style>

<div>
	<a class="hiddenanchor" id="tologin"></a>
	<div id="wrapper">
		<div id="login" class="animate form">
			<section class="login_content">

				<form method="post" action="<?=base_url('sistema/usuarios/update_password');?>">
					<h1>Redefinir Senha</h1>

					<div>
						<input type="password" class="form-control" placeholder="Nova Senha" required="" name="nova_senha" />
					</div>
					<div>
						<input type="password" class="form-control" placeholder="Repita a Senha" required="" name="nova_senha_confirmar" />
					</div>
					<div>
						<input type="hidden" name="userid" value="<?=$userid?>">
						<input class="btn btn-default submit" type="submit" value="Salvar">
					</div>
					<div class="clearfix"></div>
				</form>
				<!-- form -->

			</section>
			<?php if (isset($error)) : ?>
				<div class="alert alert-danger fade in">
					<a href="#" class="close" data-dismiss="alert">×</a>
					<strong>Erro!</strong> <?php echo $error; ?>
				</div>
			<?php endif; ?>
			<?php if (isset($success)) : ?>
				<div class="alert alert-success fade in">
					<a href="#" class="close" data-dismiss="alert">×</a>
					<strong>Sucesso!</strong> <?php echo $success; ?>
				</div>
			<?php endif; ?>
			<?php if (isset($warning)) : ?>
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