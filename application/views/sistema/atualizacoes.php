<div class="modal" tabindex="-1" role="dialog" id="atualizacoes_modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Modificações <span class="badge bg-green"><?=count($todasAtualizacoes);?> até Hoje</span></h4>
			</div>
			<div class="modal-body" id="atualizacoes_modal_body" style="overflow: auto; height: 400px; padding: 0;">
				<ul class="list-unstyled msg_list" id="lista_att">
					<?php foreach ($todasAtualizacoes as $atualizacaoItem) : ?>
						<li class="atualizacao-visualizada-<?=$atualizacaoItem->visualizada;?>">
							<a>
								<span class="image">
									<img src="<?php echo base_url("images/uploads/profile/$atualizacaoItem->imagem"); ?>" alt="Imagem de Perfil" />
								</span>
								<span>
									<span><?php echo $atualizacaoItem->nome; ?></span>
									<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', $atualizacaoItem->data); ?></span>
								</span>
								<span class="message">
									<?php echo $atualizacaoItem->titulo . ": " . $atualizacaoItem->tipo; ?>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
<!-- 				<table class="table">
					<tr>
						<td style="border-top: none;">Data</td>
						<td style="border-top: none;">Título da Atualização</td>
						<td style="border-top: none;">Tipo</td>
						<td style="border-top: none;">Usuário</td>
					</tr>
					<?php foreach ($todasAtualizacoes as $atualizacaoItem) : ?>
						<tr>
							<td><?php echo date('d/m/Y\  H:i\h', $atualizacaoItem->data); ?></td>
							<td><?php echo $atualizacaoItem->titulo; ?></td>
							<td><?php echo $atualizacaoItem->tipo; ?></td>
							<td><?php echo $atualizacaoItem->nome; ?></td>
						</tr>
					<?php endforeach; ?>
				</table> -->
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