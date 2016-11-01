<div id="formulario_contato_site">
	<form action="<?=base_url('site/contato/send_mail') ?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">Nome <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="nome" name="nome" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="sobrenome">Sobrenome <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="sobrenome" name="sobrenome" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">E-Mail <span class="required">*</span>
			</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
			</div>
		</div>		
		<div class="form-group">
			<label for="telefone" class="control-label col-md-3 col-sm-3 col-xs-12">Telefone/Celular</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input id="telefone" class="form-control col-md-7 col-xs-12" type="text" name="telefone" data-inputmask="'mask': '(99) 9999-99999'">
			</div>
		</div>
		<div class="form-group">
			<label for="mensagem" class="control-label col-md-3 col-sm-3 col-xs-12">Mensagem</label>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<textarea id="mensagem" required="required" class="form-control" name="mensagem" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.."
                          data-parsley-validation-threshold="10"></textarea>
			</div>
		</div>
		<div class="form-group">
			<button type="button" class="btn btn-warning" id="btn_reset_contato">Limpar</button>
			<button type="submit" class="btn btn-success" id="btn_submit_contato">Enviar</button>
		</div>
	</form>
</div>