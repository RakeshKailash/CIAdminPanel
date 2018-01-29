<?php if (!$enquete->votado): ?>
	
	<div class="modal" tabindex="-1" role="dialog" id="enquete_modal">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Enquete</h4>
				</div>
				<div class="modal-body" id="enquete_modal_body">
					<div class="tools_modal_inside">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div class="x_title">
										<h2 class="control-label col-md-12 col-sm-12 col-xs-12"><?=$enquete->titulo?></h2>
										<h4 class="col-md-12 col-sm-12 col-xs-12"><?=$enquete->descricao?></h4>
										<div class="clearfix"></div>
									</div>
									<div class="x_content">
										<br />
										<form action="<?=base_url('site/ferramentas/enquete/vote') ?>" method="post" accept-charset="utf-8" data-parsley-validate class="form-horizontal form-label-left col-md-12 col-sm-12 col-xs-12">
											<div class="form-group container_survey_options">
												<?php foreach ($enquete->opcoes as $opcao): ?>
													<div class="option nofill" data-votes="<?=$opcao->votos?>" data-optid="<?=$opcao->id;?>"><span class="option_label"><i class="fa fa-circle-o"></i><?=$opcao->descricao?></span><div class="percent_answers hidden"><span><?=$opcao->votos?></span></div></div>
												<?php endforeach ?>
											</div>
											<input type="hidden" name="id_enquete_modal" id="id_enquete_modal" value="0">
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning">Não quero responder</button>
					<button type="button" class="btn btn-success">Confirmar</button>
				</div>
			</div>
		</div>
	</div>

<?php endif ?>