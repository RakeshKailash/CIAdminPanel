<?php
$comentariosEstrutura = null;


$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;
?>
<section id="call-to-action" style="margin-top: 100px; margin-bottom: 50px;">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block">
					<h2 class="title wow fadeInDown" data-wow-delay=".5s" data-wow-duration="1000ms">Comentários</h2>
				</div>
			</div>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php foreach ($comentarios as $comentario) : ?>
					<div class='comentario'>
						<span class='autor_comentario'><?=$comentario->nomeAutor;?></span>
						<span class='data_comentario'><?=", em ".date('d/m/Y\ \à\s H:i\h', strtotime($comentario->dataComentario));?></span>
						<p class='texto_comentario'><?=$comentario->textoComentario;?></p>
					</div>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</section>
<section style="margin-bottom: 21px;">
	<form action="<?=base_url('site/Main/enviarComentario');?>" id="form_comment" method="post">
		<div class="container rounded-border">
			<h2 class="title-site">Deixe seu comentário</h2>

			<div id="mensagens"></div>

			<div class="row" style="margin-bottom: 21px;">
				<div class="col-md-6 col-lg-6 col-xs-12">
					<label for="autor_comentario" class="control-label site-label">Nome</label>
					<input type="text" name="autor_comentario" class="form-control" placeholder="Seu Nome (opcional)" style="margin-bottom: 21px;">

					<label for="email_comentario" class="control-label site-label">E-mail</label>
					<input type="text" name="email_comentario" class="form-control" placeholder="Seu E-mail (opcional)">
				</div>
				<div class="col-md-6 col-lg-6 col-xs-12">
					<label for="mensagem_comentario" class="col-md-12 control-label site-label">Comentário * <span id="limit_characters">250 restantes</span></label>
					<textarea class="form-control no-resize" rows="5" name="mensagem_comentario" id="mensagem_comentario" placeholder="Sua Mensagem" maxlength="250"></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6 col-xs-12">
					<input type="hidden" name="id_secao" value="2">
					<button type="button" id="btn_enviar" class="btn btn-default">Enviar</button>
					<button type="reset" id="btn_clear" class="btn btn-default">Limpar</button>
				</div>
			</div>
		</div>
	</form>
</section>

<script type="text/javascript">
	var maxLength = 250;

	$("#btn_enviar").click(function () {
		var postValues = $("#form_comment").serialize();
		var statusMessages = {};
		statusMessages.createMessage = function (index, message) {
			var messages = {
				'error' : "<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Erro!</strong>",
				'success' : "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Sucesso!</strong>",
				'warning' : "<div class='alert alert-warning fade in'><a href='#' class='close' data-dismiss='alert'>×</a><strong>Atenção!</strong>"
			};

			return messages[index] + message + "</div>";
		};

		$.post(base_url+'site/Main/enviarComentario', postValues, function (retorno) {
			retorno = JSON.parse(retorno);
			$("#mensagens").html(statusMessages.createMessage(retorno.status, retorno.message));
		});
	});

	$("#mensagem_comentario").keyup(function () {
		var remaining_length = maxLength - $("#mensagem_comentario").val().length;
		$("#limit_characters").html(remaining_length + " restantes");
	});

	$("#btn_clear").click(function () {
		$("#limit_characters").html("250 restantes");
	});

</script>