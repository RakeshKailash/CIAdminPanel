<div class="col-md-3 left_col">
	<div class="left_col scroll-view">

		<div class="navbar nav_title" style="border: 0;">
			<a href="javascript:void(0)" class="site_title"><i class="fa fa-dashboard"></i> <span><?php echo "Projeto CI" ?></span></a>
		</div>
		<div class="clearfix"></div>


		<!-- menu prile quick info -->
		<div class="profile">
			<div class="profile_pic">
				<img src="<?=base_url('images/uploads/profile/' . $_SESSION['imagem']); ?>" alt="..." class="img-circle profile_img">
			</div>
			<div class="profile_info">
				<span>Bem-vindo,</span>
				<h2><?php echo $_SESSION['nome']; ?></h2>
			</div>
		</div>
		<!-- /menu prile quick info -->

		<br />

		<!-- sidebar menu -->
		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

			<div class="menu_section">
				<h3>Sistema</h3>
				<ul class="nav side-menu">
					<li><a href="<?=base_url('sistema'); ?>"><i class="fa fa-home"> </i> Home </a></li>
					<li><a><i class="fa fa-comment"></i> Comentários <span class="fa fa-chevron-down"></span></a>
						<ul class="nav child_menu" style="display: none">
							<li><a href="<?=base_url('sistema/Comentarios/configurar'); ?>">Configurações de Comentários</a>
							</li>
							<li><a href="<?=base_url('sistema/Comentarios/gerenciar'); ?>">Gerenciar Comentários <span class="badge bg-green comment-badge">5</span></a>
							</li>
						</ul>
					</li>
				</ul>
			</div>

			<div class="menu_section">
				<h3>Editar Seções</h3>
				<ul class="nav side-menu">
					<?php
					foreach ($secoes as $secao_info):
						if ($secao_info->nome != 'Home') :
							?>

						<li><a href="<?=base_url('sistema/' . $secao_info->link . '/editar'); ?>"><i class="fa fa-<?php echo $secao_info->icone; ?>"> </i> <?php echo $secao_info->nome ?> </a></li>

					<?php endif;
					endforeach; ?>
				</ul>
			</div>

		</div>

		<!-- /sidebar menu -->


	</div>
</div>