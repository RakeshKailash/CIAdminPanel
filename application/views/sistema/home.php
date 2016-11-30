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

$formatData = count($views->count) > 10 ? "d/m" : "D d/m/Y";

for ($i=0; $i < count($views->count); $i++) {
	$day = str_replace($daysEn, $daysPt, date($formatData, strtotime($views->list[$i])));
	array_push($lastWeek, $day);
	$viewsLW = $views->count[$i];
	array_push($viewsLastWeek, $viewsLW);
}

$lastWeek = json_encode($lastWeek);
$viewsLastWeek = json_encode($viewsLastWeek);
$limitValue = $views->limitValue;
$currentday = str_replace($daysEn, $daysPt, date("D d/m/Y", time()));


$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

?>

<body class="nav-md">

	<div class="container body">

		<div class="main_container">

			<?php $this->load->view('sistema/common/sidebar');?>

			<!-- top navigation -->
			<?php $this->load->view('sistema/common/navbar');?>
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
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>Estatísticas de Acesso</h2>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<div class="col-md-12 col-sm-12 col-xs-12 container_graficos">
										<div id="echart_line" style="height:350px;"></div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-4 container_graficos">
										<div id="echart_pie" style="height:350px;"></div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-4 container_graficos">
										<div id="mainb" style="height:350px;"></div>
									</div>
									<!-- Custom Statiscs Stuff -->
									<!-- <div class="col-md-6 col-sm-6 col-xs-4 container_graficos">
										<div id="mainb2" style="height:350px;"></div>
									</div> -->
									<!-- <div class="col-md-6 col-sm-6 col-xs-4">
										<form data-parsley-validate class="form-horizontal form-label-left" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="form_custom_filters">
											<h4>Selecione os Filtros para as Estatísticas Personalizadas</h4>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtros">Período: </label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<fieldset>
														<div class="control-group">
															<div class="controls">
																<div class="input-prepend input-group">
																	<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
																	<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="<?php echo date('d/m/Y' , time()) . ' - ' . date('d/m/Y' , time())?>" />
																</div>
															</div>
														</div>
													</fieldset>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="filtros">Filtros Adicionais: </label>
												<div class="col-md-9 col-sm-9 col-xs-12">
													<div class="checkbox">
														<label>
															<input type="checkbox" class="flat"> Por Seções
														</label>
													</div>
													<div class="checkbox">
														<label>
															<input type="checkbox" class="flat"> Por Hora
														</label>
													</div>
												</div>
											</div>
										</form>
									</div> -->
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
	, currentDay = <?=json_encode($currentday)?>
	, views = <?=json_encode($views)?>
	;
</script>

<?php $this->load->view('footer'); ?>