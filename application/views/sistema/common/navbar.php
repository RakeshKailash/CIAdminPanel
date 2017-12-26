<div class="top_nav">
	<div class="nav_menu">
		<nav class="" role="navigation">
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i></a>
			</div>

			<ul class="nav navbar-nav navbar-right">
				<li class="">
					<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="<?php echo base_url('images/uploads/profile/' . $_SESSION['imagem']); ?>" alt=""><?php echo $_SESSION['nome'] ?>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
						<li><a href="<?=base_url('sistema/usuarios') ?>"><i class="fa fa-user pull-right"></i> Contas de Usuário</a>
						</li>
						<li>
							<a href="<?=base_url('sistema/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Sair</a>
						</li>
					</ul>
				</li>

				<li role="presentation" class="dropdown">
					<a href="javascript:void(0);" id="notif_icon" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
						<i class="fa fa-bell-o"></i>
						<span class="count-update-badge badge bg-green"><?=(count($atualizacoes['naoVisualizadas']) > 0 ? count($atualizacoes['naoVisualizadas']) : null)?></span>
					</a>
					<ul class="dropdown-menu list-unstyled msg_list animated fadeInDown atualizacoes_site_lista" role="menu">
						<?php if ($atualizacoes['limitadas']) : foreach ($atualizacoes['limitadas'] as $atualizacao) : ?>
							<li class="atualizacao-visualizada-<?=$atualizacao->status;?>" data-id="<?=$atualizacao->id;?>">
								<a <?=!empty($atualizacao->link) ? "href='".base_url('sistema/'.$atualizacao->link)."'" : "";?>>
									<span class="image">
										<?php if ($atualizacao->usuario != 0): ?>
											<img src="<?php echo base_url("images/uploads/profile/$atualizacao->imagem"); ?>" alt="Imagem de Perfil" />
										<?php else: ?>
											<span><i class="fa fa-comment"></i></span>
										<?php endif ?>
									</span>
									<span>
										<span><?=!empty($atualizacao->nome) ? $atualizacao->nome : "Site";?></span>
										<span class="time"><?php echo date('d/m/Y\, \à\s H:i\h', strtotime($atualizacao->data)); ?></span>
									</span>
									<span class="message">
										<?php echo $atualizacao->titulo; ?>
									</span>
								</a>
							</li>
						<?php endforeach; endif; ?>
						<li>
							<div class="text-center open_att_modal">
								<a>
									<strong>Ver todas as Modificações</strong>
									<i class="fa fa-angle-right"></i>
								</a>
							</div>
						</li>
					</ul>
				</li>

			</ul>
		</nav>
	</div>

</div>

<script type="text/javascript">
	refreshSession();

	function refreshSession () {
		var url = base_url + 'sistema/main/refresh_session';
		$.get(url);
	}

	window.setInterval(function () {
		refreshSession();
	}, 10000);
</script>