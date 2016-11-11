<?php
$info['title'] = array('Sistema', 'Painel de Administração');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
// $views;
// $viewsToday;
// $viewsSections;

$lastWeek = array();
$daysEn = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
$daysPt = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
$viewsLastWeek = array();

for ($i=0; $i < count($views->count); $i++) {
	$day = str_replace($daysEn, $daysPt, date("D d/m/Y", strtotime($views->list[$i])));
	array_push($lastWeek, $day);
	$viewsLW = $views->count[$i];
	array_push($viewsLastWeek, $viewsLW);
}

$lastWeek = json_encode($lastWeek);
$viewsLastWeek = json_encode($viewsLastWeek);
$limitValue = $views->limitValue;

$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);
?>

<body class="nav-md">

	<div class="container body">

		<div class="main_container">

			<div class="col-md-3 left_col">
				<div class="left_col scroll-view">

					<div class="navbar nav_title" style="border: 0;">
						<a href="javascript:void(0)" class="site_title"><i class="fa fa-dashboard"></i> <span><?php echo "Projeto CI" ?></span></a>
					</div>
					<div class="clearfix"></div>


					<!-- menu prile quick info -->
					<div class="profile">
						<div class="profile_pic">
							<img src="<?=base_url('images/uploads/profile/image.jpg'); ?>" alt="..." class="img-circle profile_img">
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

			<!-- top navigation -->
			<div class="top_nav">

				<div class="nav_menu">
					<nav class="" role="navigation">
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						</div>

						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<img src="<?php echo base_url('images/uploads/profile/image.jpg'); ?>" alt=""><?php echo $_SESSION['nome'] ?>
									<span class=" fa fa-angle-down"></span>
								</a>
								<ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
									<li><a href="<?="Editar_usuario" ?>"><i class="fa fa-user pull-right"></i> Conta de Usuário</a>
									</li>
									<li>
										<a href="<?="Ajuda" ?>"><i class="fa fa-question-circle pull-right"></i> Ajuda</a>
									</li>
									<li>
										<a href="<?=base_url('sistema/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Sair</a>
									</li>
								</ul>
							</li>

							<li role="presentation" class="dropdown">
								<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-wrench"></i>
									<span class="count-update-badge badge bg-green"><?=(count($atualizacoes['naoVisualizadas']) > 0 ? count($atualizacoes['naoVisualizadas']) : null)?></span>
								</a>
								<ul class="dropdown-menu list-unstyled msg_list animated fadeInDown atualizacoes_site_lista" role="menu">
									<?php if ($atualizacoes['limitadas']) : foreach ($atualizacoes['limitadas'] as $atualizacao) : ?>
										<li class="atualizacao-visualizada-<?=$atualizacao->status;?>" data-id="<?=$atualizacao->id;?>">
											<a>
												<span class="image">
													<img src="<?php echo base_url("images/uploads/profile/$atualizacao->imagem"); ?>" alt="Imagem de Perfil" />
												</span>
												<span>
													<span><?php echo $atualizacao->nome; ?></span>
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
			<!-- /top navigation -->

			<!-- page content -->
			<div class="right_col" role="main">
				<div class="">

					<div class="page-title">
						<div class="title_left">
							<h3>Painel de Administração</h3>
						</div>
						<div class="title_right">
							<h4>Página Principal</h4>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Estatísticas</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div id="echart_line" style="height:350px;"></div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-4">
										<div id="echart_bar_horizontal" style="height:370px;"></div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-4">
										<div id="mainb" style="height:350px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var lastWeekJS = <?=$lastWeek?>
	, viewsLastWeek = <?=$viewsLastWeek?>
	, limitValue = <?=$limitValue?>
	, todaysViews = <?=json_encode($viewsToday)?>
	, sectionsViews = <?=json_encode($viewsSections)?>
	;

	console.log(todaysViews);
</script>

<?php

$this->load->view('footer') 
?>