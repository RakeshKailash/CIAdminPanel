<div class="main_contato">
	<!-- $user_name, $user_email, $subject, $message -->
	<p>Assunto: <b><?=$subject?></b></p>
	<p>Nome: <b><?=$user_name?></b></p>
	<p>E-mail: <b><?=$user_email?></b></p>
	<p>Mensagem: <br> <b><?=trim($message)?></b></p>
</div>

<style type="text/css">
	.main_contato {
		background: #eee;
	}

	p {
		color: #444;
	}
</style>