<div class="modal atualizacoes_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?=count($todasAtualizacoes);?> Modificações <span class="badge bg-green count-update-badge-modal"><?=(count($naoVisualizadas) > 0 ? count($naoVisualizadas) . ' novas' : null);?></span></h4>
			</div>
			<div class="modal-body" id="atualizacoes_modal_body" style="overflow: auto; height: 400px; padding: 0;">
				<ul class="list-unstyled msg_list" id="lista_att">
					<?php if ($todasAtualizacoes) : foreach ($todasAtualizacoes as $atualizacaoItem) : ?>
						<li class="atualizacao-visualizada-<?=$atualizacaoItem->status?>" data-id="<?=$atualizacaoItem->id;?>">
							<a>
								<span class="image">
									<img src="<?php echo base_url("images/uploads/profile/$atualizacaoItem->imagem"); ?>" alt="Imagem de Perfil" />
								</span>
								<span>
									<span><?php echo $atualizacaoItem->nome; ?></span>
									<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', strtotime($atualizacaoItem->data)); ?></span>
								</span>
								<span class="message">
									<?php echo $atualizacaoItem->titulo . ": " . $atualizacaoItem->tipo; ?>
								</span>
							</a>
						</li>
					<?php endforeach; endif; ?>
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
	#lista_att.msg_list li {
		display: list-item;
		padding: 5px;
		width: 100% !important;
		margin: 0;
		border-bottom: 1px solid #ccc;
		border-top: 1px solid #fff;
	}

	#lista_att.msg_list li a .image img {
		width: 9%;
	}

	#lista_att.msg_list li a:hover {
		text-decoration: none;
		color: #5A738E;
	}
</style>