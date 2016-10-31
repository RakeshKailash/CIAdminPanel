<div id="contato_form_site">
	<form action=".base_url('site/mail/send')." method="post">
		Nome:* <input type="text" name="nome"><br>
		Telefone: <input type="text" name="telefone"><br>
		E-mail:* <input type="text" name="email"><br>
		Mensagem:*<br>
		<textarea rows="5" name="mensagem" cols="30"></textarea><br>
		<input type="submit" name="submit" value="Enviar">
		<input type="reset" name="limpar" value="Limpar">
	</form>
</div>