<div class="block">
<h2 class="subtitle wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Entre em Contato</h2>

	<?php if(isset($message)) : ?>
		<p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
			<?=$message;?>
		</p>
	<?php endif ?>

	<div class="contact-form">
		<form id="contact-form" method="post" data-parsley-validate action="<?=base_url('site/contato/send_mail') ?>" role="form">

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
				<input type="submit" id="contact-submit" class="btn btn-default btn-send" value="Enviar Mensagem">
			</div>                      

		</form>
	</div>
</div>