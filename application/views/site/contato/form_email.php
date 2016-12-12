<?php

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

?>

<div class="block">
	<h2 class="subtitle wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Entre em Contato</h2>

	<?php if(isset($message)) : ?>
		<p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
			<?=$message;?>
		</p>
	<?php endif ?>

	<div class="contact-form">

		<div id="mensagens"></div>

		<form id="contact-form" method="post" data-parsley-validate action="javascript:void(0)" role="form">

			<div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".6s">
				<input type="text" placeholder="Seu Nome" class="form-control" name="nome" id="name">
			</div>

			<div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".8s">
				<input type="email" placeholder="Seu Email" class="form-control" name="email" id="email" >
			</div>

			<div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1s">
				<input type="text" placeholder="Assunto" class="form-control" name="assunto" id="subject">
			</div>

			<div class="form-group wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.2s">
				<textarea rows="6" placeholder="Mensagem" class="form-control" name="mensagem" id="message"></textarea>
			</div>

			<div id="submit" class="wow fadeInDown" data-wow-duration="500ms" data-wow-delay="1.4s">
				<img src="<?=base_url('images/gear.svg')?>" alt="Enviando..." class="loading_gif">
				<input type="submit" id="contact-submit" class="btn btn-default btn-send" value="Enviar Mensagem">
			</div>

		</form>
	</div>
</div>

<script type="text/javascript">
	$("#contact-submit").click(function () {
		$("#contact-submit").attr('disabled', 'true');
		$("#contact-submit").css('background', '#ccc');
		$(".loading_gif").css('display', 'inline-block');
		var postValues = $("#contact-form").serialize();
		var statusMessages = {};
		statusMessages.createMessage = function (index, message) {
			var messages = {
				'error' : "<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Erro! </strong>",
				'success' : "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Sucesso! </strong>",
				'warning' : "<div class='alert alert-warning fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Atenção! </strong>"
			};

			return messages[index] + message + "</div>";
		};

		$.post(base_url+'site/contato/sendMail', postValues, function (retorno) {
			retorno = JSON.parse(retorno);
			$("#mensagens").html(statusMessages.createMessage(retorno.status, retorno.message));
			$(".loading_gif").css('display', 'none');
			$("#contact-submit").removeAttr('disabled');
			$("#contact-submit").css('background', '#e54040');
		});
	})
</script>