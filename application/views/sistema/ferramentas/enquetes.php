<?php
$info['title'] = array('Sistema', 'Enquetes');
$info['cabecalho'] = array('menu' => null, 'header' => 'sistema');
$this->load->view('header', $info);
$this->load->view('sistema/atualizacoes', $atualizacoes);

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$success = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$warning = isset($_SESSION['warning']) ? $_SESSION['warning'] : null;

$check_state = isset($enquete_edit) ? "value='".$enquete_edit->status."'" : "value='1'";

if (isset($enquete_edit) && $enquete_edit->status == 2) {
	$check_state .= " checked";
}

$cur_date = date('d/m/Y', time());

$usuarios = $this->usuario_model->getUser();

$status_classes = array(1 => 'exclamation-circle listed_post false', 2 => 'check-circle listed_post true', 3 => 'clock-o listed_post false');

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
							<h4>Ferramentas <i class="fa fa-angle-right" style="font-size: 12pt;" aria-hidden="true"></i> Enquetes</h4>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="container">
									<div class="col-md-12 col-xs-12">
										<?php if (isset($enquete_edit)): ?>
											<h2>Editar Enquete: "<?=$enquete_edit->titulo?>"</h2>
										<?php else: ?>
											<h2>Nova Enquete</h2>
										<?php endif ?>
										<div id="mensagens">
											<?php if ($error) : ?>
												<div class="alert alert-danger fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Erro!</strong> <?=$error; ?>
												</div>
											<?php endif; ?>
											<?php if ($success) : ?>
												<div class="alert alert-success fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Sucesso!</strong> <?=$success; ?>
												</div>
											<?php endif; ?>
											<?php if ($warning) : ?>
												<div class="alert alert-warning fade in">
													<a href="#" class="close" data-dismiss="alert">×</a>
													<strong>Atenção!</strong> <?=$warning; ?>
												</div>
											<?php endif; ?>
										</div>
										<form class="form-horizontal form-label-left" id="form_criar_enquete" action="<?=base_url('sistema/ferramentas/saveSurvey');?>" <?=isset($enquete_edit) ? "data-enqueteid='".$enquete_edit->id."'" : null?> method="post" enctype="multipart/form-data">
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Título: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="titulo" id="titulo" class="form-control" required="required" value="<?=isset($enquete_edit) ? $enquete_edit->titulo: ''?>">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Conteúdo: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<textarea name="descricao" id="descricao" class="form-control"><?=isset($enquete_edit) ? $enquete_edit->descricao : ''?></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Duração: <span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<input type="text" name="datas" id="data_selector" class="form-control" required="required" value="<?=isset($enquete_edit) ? $enquete_edit->data_inicio . ' - ' .$enquete_edit->data_final : ''?>">
												</div>
											</div>
											<div class="form-group opcoes">
												<label class="control-label col-md-3 col-sm-3 col-xs-12">Opções<span class="required">*</span></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="col-md-12 col-sm-12 col-xs-12 opcoes_form_container">
														<?php if (isset($enquete_edit)): ?>
															<?php foreach ($enquete_edit->opcoes as $opcao): ?>
																<input type="text" name="opcoes[]" class="form-control opcoes_form opcao_adicionada" required="required" value="<?=$opcao->descricao?>" data-pos="<?=$opcao->numero?>">
																<div class="acoes_opcoes">
																	<button type="button" data-opt="<?=$opcao->numero?>" class="btn btn-danger remover_opcao"><i class="fa fa-minus"></i></button>
																</div>
															<?php endforeach ?>
														<?php endif ?>
													</div>
													<div class="col-md-12 col-sm-12 col-xs-12 nova_opcao_container no-padding">
														<input type="text" name="nova_opcao" class="form-control opcoes_form nova_opcao" placeholder="Adicionar Opção...">
														<div class="acoes_opcoes">
															<button type="button" class="btn btn-success add_opcao"><i class="fa fa-plus"></i></button>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div>
														<input type="checkbox" class="js-switch" id="status_post_modal" name="status_post" <?=$check_state?>>
														Publicar
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
													<input type="hidden" name="save_type" id="save_type" value="1">
													<input type="hidden" id="id_enquete" name="id_enquete" value="<?=isset($enquete_edit) ? $enquete_edit->id : '0' ?>">
													<button type="reset" class="btn btn-warning">Limpar</button>
													<button type="button" id="salvar_postar_enquete" class="btn btn-success">Salvar Enquete</button>
													<?php if (isset($enquete_edit)): ?>
														<button type="button" id="cancelar_edit" class="btn btn-danger">Cancelar</button>
													<?php endif ?>
												</div>
											</div>
										</form> <!-- /Criar Editar Enquetes -->
										<?php if (!isset($enquete_edit)): ?>
											<div class="ln_solid"></div>
											<h2>Enquetes Criadas</h2>
											<div class="posts_gallery_subtitle col-md-12">
												<p class="subtitle">
													<i class="fa fa-check-circle" aria-hidden="true" style="color: #3FC1A5"></i>
													<label class="control-label">Publicada</label>
												</p>
												<p class="subtitle">
													<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #F4A72D"></i>
													<label class="control-label">Rascunho</label>
												</p>
												<p class="subtitle">
													<i class="fa fa-clock-o" aria-hidden="true" style="color: #D33734"></i>
													<label class="control-label">Finalizada (não pode ser alterada)</label>
												</p>
												<p class="subtitle"><label class="control-label">
													Clique nos ícones para alterar o status das enquetes (<i class="fa fa-check-circle" aria-hidden="true" style="color: #3FC1A5"></i>/<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #F4A72D"></i>)</label>
												</p>
											</div>
											<div class="gallery_posts">
												<?php foreach ($enquetes as $enquete): ?>
													<div class="container_gallery_nc_display no_cover">
														<div class="container_content_gallery_item_display">
															<div class="gallery_item_display" data-enqueteid="<?=$enquete->id?>" data-totalr="<?=$enquete->total_resp?>">
																<div class="author_gallery_item_display">
																	<span>Por: <?=$enquete->autor?></span>
																	<span> | </span>
																	<span>Respostas: <?=$enquete->total_resp?></span>
																</div>
																<div class="info_gallery_item_display">
																	<p class="title_gallery_item_display"><?=$enquete->titulo;?></p>
																	<p class="description_gallery_item_display"><?=sizeof($enquete->descricao) > 98 ? strip_tags(mb_substr($enquete->descricao, 0, 97)) . '...' : $enquete->descricao?></p>
																	<div class="options_gallery_item_display">
																		<?php foreach ($enquete->opcoes as $opcao): ?>
																			<div class="option" data-votes="<?=$opcao->votos?>"><span class="option_label"><?=$opcao->descricao?></span><div class="percent_answers"><span><?=$opcao->votos?></span></div></div>
																		<?php endforeach ?>
																	</div>
																</div>
															</div>
															<?php
															if ($_SESSION['tipoUsuario'] == 1) {
																$this->load->view('sistema/ferramentas/survey_menu');
															}
															?>
															<?php if ($enquete->data_final < $cur_date): ?>
																<i class="fa fa-<?=$status_classes[3]?>" aria-hidden='true'></i>
															<?php else: ?>
																<i class="fa fa-<?=$status_classes[$enquete->status]?>" aria-hidden='true' data-status="<?=$enquete->status?>"></i>
															<?php endif ?>
														</div>
													</div>
												<?php endforeach ?>
											</div>
										<?php endif ?>
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

<script type="text/javascript" charset="utf-8" async defer>

	var color_list = [
	'#F55C3D',
	'#F5993D',
	'#99F53D',
	'#FCDC31',
	'#0183BD',
	'#993DF5',
	'#FF8DA2',
	'#966A4F'
	];

	$(document).ready(function () {
		moment.locale("pt-br");
		var cur_date = moment().format('l');

		$('input[name="datas"]').daterangepicker({
			startDate: cur_date,
			endDate: cur_date,
			format: 'DD/MM/YYYY',
			minDate: cur_date,
			alwaysShowCalendars: true,
			ranges: {
				"Hoje" : [cur_date, cur_date],
				"Amanhã" : [moment().add(1, 'days').format("l"), moment().add(1, 'days').format("l")],
				"Uma semana" : [cur_date, moment().add(7, 'days').format("l")]
			}
		});

		fillAnswersBars();
	});

	function shadeColor(color, percent) {

		var R = parseInt(color.substring(1,3),16);
		var G = parseInt(color.substring(3,5),16);
		var B = parseInt(color.substring(5,7),16);

		R = parseInt(R * (100 + percent) / 100);
		G = parseInt(G * (100 + percent) / 100);
		B = parseInt(B * (100 + percent) / 100);

		R = (R<255)?R:255;  
		G = (G<255)?G:255;  
		B = (B<255)?B:255;  

		var RR = ((R.toString(16).length==1)?"0"+R.toString(16):R.toString(16));
		var GG = ((G.toString(16).length==1)?"0"+G.toString(16):G.toString(16));
		var BB = ((B.toString(16).length==1)?"0"+B.toString(16):B.toString(16));

		return "#"+RR+GG+BB;
	}

	function fillAnswersBars () {
		var cont = 0;

		$(".container_gallery_nc_display").each(function () {

			$(this).find(".option").each(function () {
				var votos = $(this).data('votes')
				, total = $(this).parents('.gallery_item_display').data('totalr')
				, percent
				;

				if (votos > total || (votos == 0 && total == 0)) {
					percent = "0%";
				} else {
					percent = (Math.floor((votos / total) * 100)) + "%";
				}

				if (percent == "0%") {
					$(this).find('.percent_answers').css('display', 'none');
					return;
				}

				if (cont > color_list.length) {
					cont = 0;
				}

				$(this).find('.percent_answers').css('width', percent);
				$(this).find('.percent_answers').css('background', color_list[cont]);
				$(this).find('.percent_answers').css('borderBottomColor', shadeColor(color_list[cont], -20));

				cont++;
			});
			cont = 0;
		});

		// hue = 0;
	}

	$("#salvar_postar_enquete").click(function () {
		$("#form_criar_enquete").submit();
		// var data = []
		// , idEnquete = $("#form_criar_enquete").data('enqueteid')
		// ;

		// data['titulo'] = $("#titulo").val();
		// data['descricao'] = $("#descricao").val();
		// data['status'] = $("#save_type").val();
		// data['datas'] = $("#data_selector").val();
		// data['opcoes'] = [];

		// if (!data['titulo'] || !data['descricao'] || !data['datas']) {
		// 	return false;
		// }

		// $("input[name='opcoes[]']").each(function() {
		// 	data['opcoes'].push({'descricao' : $(this).val(), 'numero' : $(this).data('pos')});
		// });

		// var url = base_url+"sistema/ferramentas/saveSurvey";

		// $.post(url, {'survey_id' : idEnquete, 'survey_data' : data}, function(retorno) {

		// });
	});

	$("#cancelar_edit").click(function () {
		window.location=base_url+"sistema/ferramentas/enquetes";
	});

	$(".add_opcao").click(function () {
		var descricao = $(".nova_opcao").val()
		, pos = 1
		;

		if ($(".opcao_adicionada").length > 0) {
			pos = ($(".opcao_adicionada").last().data('pos') + 1);
		}

		if (descricao.length < 1) {
			swal("Preencha todos os campos", "Escreva a Descrição da opção, para adicioná-la!", "error");
			return false;
		}

		var input = $("<input />", {
			type: "text",
			name: "opcoes[]",
			"class": "form-control opcoes_form opcao_adicionada",
			required: "required",
			value: descricao,
			"data-pos": pos
		})
		, div = $("<div />", {
			"class": "acoes_opcoes"
		})
		, btn = $("<button />", {
			type: "button",
			"class": "btn btn-danger remover_opcao",
			"data-opt": pos
		})
		, icon = $("<i />", {
			"class": "fa fa-minus"
		})
		;

		$(btn).append(icon);
		$(div).append(btn);

		$(".opcoes_form_container").append(input);
		$(".opcoes_form_container").append("&nbsp;");
		$(".opcoes_form_container").append(div);
		$(".nova_opcao").val("").focus();

		var enqueteid = $("#form_criar_enquete").data('enqueteid');

		if ($("#form_criar_enquete").attr("data-enqueteid")) {
			updateSurveyOptions(enqueteid);
		}
	});

	$(".opcoes_form_container").on("click", ".remover_opcao", function () {
		var pos = $(this).data('opt');

		$(".opcao_adicionada[data-pos='"+pos+"']").remove();
		$(this).parent('.acoes_opcoes').remove();

		var enqueteid = $("#form_criar_enquete").data('enqueteid');

		updateInputData();

		if ($("#form_criar_enquete").attr("data-enqueteid")) {
			updateSurveyOptions(enqueteid);
		}
	});

	function configResults (data) {
		
	}

	function getRandomColor () {
		var color = ('#' + (function co(lor){   return (lor +=
			[0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f'][Math.floor(Math.random()*16)])
		&& (lor.length == 6) ?  lor : co(lor); })(''));

		if (color.length != 7) {
			return false;
		}

		return color;
	}

	function updateSurveyOptions(enqueteid) {
		if (! enqueteid) {
			return false;
		}

		var data = [];

		$("input[name='opcoes[]']").each(function() {
			data.push({'descricao' : $(this).val(), 'numero' : $(this).data('pos')});
		})

		var post_url = base_url+"sistema/ferramentas/updateSurveyOptions";

		$.post(post_url, {'options' : data, 'survey_id' : enqueteid}, function (result) {
			if (JSON.parse(result) === false) {
				swal({
					title: 'Ops...',
					text: 'Não foi possível atualizar as opções. A página será atualizada em alguns segundos...',
					type: "error",
					timer: 5000,
					allowOutsideClick: false,
					onOpen: () => {
						swal.showLoading()
					}
				}).then((result) => {
					location.reload();
				})
			}
		});
	}

	function updateInputData() {
		var pos = 1
		, current_pos = null
		;

		$("input[name='opcoes[]']").each(function() {
			current_pos = $(this).data('pos');
			$(this).data('pos', pos);
			$('opcao_adicionada[data-opt="'+current_pos+'"]').data('opt', pos);
			pos++;
		});
	}

	$(".gallery_posts").on('click', ".more_gallery_item_display", function () {
		if ($(this).hasClass('inactive')) {
			$(".more_gallery_item_display").removeClass('active');
			$(".more_gallery_item_display").next().removeClass('active');
			$(".more_gallery_item_display").addClass('inactive');
			$(".more_gallery_item_display").next().addClass('inactive');

			$(this).addClass('active');
			$(this).removeClass('inactive');
			$(this).next().addClass('active');
			$(this).next().removeClass('inactive');
			return true;
		}

		$(this).addClass('inactive');
		$(this).removeClass('active');
		$(this).next().addClass('inactive');
		$(this).next().removeClass('active');
	});

	$(".gallery_posts").on('click', '.gallery_item_display', function () {
		var idEnquete = $(this).data('enqueteid');

		window.location = base_url + 'sistema/ferramentas/enquetes/' + idEnquete;
	});

	$(".container_menu_gallery_item_display").on('click', '.item_menu_gallery_item_display', function () {
		var idEnquete = $(this).parent().parent().parent().children(".gallery_item_display").first().data('enqueteid');

		switch ($(this).data('item')) {
			case 'edit' :
			window.location = base_url + 'sistema/ferramentas/enquetes/' + idEnquete;
			break;

			case 'delete' :
			window.location = base_url + 'sistema/ferramentas/enquetes/delete/' + idEnquete;
			break;
		}
	});

	$(".container_content_gallery_item_display").on('click', '.listed_post:not(.fa-clock-o)', function () {
		var idEnquete = $(this).siblings("div.gallery_item_display").first().data('enqueteid')
		, url = base_url + "sistema/ferramentas/switchSurvey"
		, info = {enqueteid: idEnquete, status: ($(this).data('status'))}
		, elemento = $(this)
		;

		$.post(url, info, function (result) {
			result = JSON.parse(result);

			if (!result[0]) {
				return false;
			}

			if ($(elemento).hasClass('true')) {
				$(elemento).removeClass("fa fa-check-circle listed_post true");
				$(elemento).addClass("fa fa-exclamation-circle listed_post false");
				$(elemento).data('status', 1);
				return true;
			}

			$(elemento).removeClass("fa fa-exclamation-circle listed_post false");
			$(elemento).addClass("fa fa-check-circle listed_post true");
			$(elemento).data('status', 2);
			return true;
		});

	});

	$("#status_post_modal").on("change", function () {
		$("#status_post_modal").val($("#status_post_modal").val() == 1 ? 2 : 1);
	});

	$("#order_by_posts").change(function () {
		var orderBy = $(this).val();

		// if (orderBy == '0') {
		// 	return false;
		// }

		$.get(base_url + 'sistema/postagens/filterPosts/' + orderBy, function (result) {
			result = JSON.parse(result);

			fillPostsGallery(result);
		});

	});

	function fillPostsGallery (elements) {
		var posts = [];
		for (var i = 0; i < elements.length; i++) {
			posts.push(
				"<div class='container_gallery_display'>",
				"<div class='container_content_gallery_item_display'>",
				"<div class='gallery_item_display' data-postid='"+elements[i].id+"'>",
				"<div class='img_gallery_item_display' style='background-image: url("+base_url+elements[i].capa+");'></div>",
				"<div class='author_gallery_item_display'>",
				"<span>Por: "+elements[i].autor+"</span>",
				"</div>",
				"<div class='info_gallery_item_display'>",
				"<p class='title_gallery_item_display'>"+elements[i].titulo+"</p>",
				"<p class='description_gallery_item_display'>"+elements[i].conteudo.substring(0, 97)+"...</p>",
				"</div>",
				"</div>",
				<?php if ($_SESSION['tipoUsuario'] == 1): ?>
				"<div class='container_menu_gallery_item_display'>",
				"<i class='fa fa-ellipsis-v more_gallery_item_display inactive' aria-hidden='true'></i>",
				"<ul class='menu_gallery_item_display inactive'>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-info-circle icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Detalhes</span>",
				"</li>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-external-link icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Visitar</span>",
				"</li>",
				"<li class='item_menu_gallery_item_display'>",
				"<i class='fa fa-pencil-square-o icon_menu_gallery_item' aria-hidden='true'></i>",
				"<span class='text_menu_gallery_item'>Editar</span>",
				"</li>",
				"</ul>",
				"</div>",
				<?php endif ?>
				"</div>",
				"</div>");
		}

		$(".gallery_posts").html(posts.join(""));
	}

</script>

<?php $this->load->view('footer') ?>