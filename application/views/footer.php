<!-- Importar JS aqui -->
<script src="<?php echo base_url('js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.pie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.orderBars.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.time.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/date.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.spline.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.stack.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/curvedLines.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.resize.js'); ?>"></script>
<script src="<?php echo base_url('js/progressbar/bootstrap-progressbar.min.js'); ?>"></script>
<script src="<?php echo base_url('js/nicescroll/jquery.nicescroll.min.js'); ?>"></script>
<!-- icheck -->
<script src="<?php echo base_url('js/icheck/icheck.min.js'); ?>"></script>
<!-- tags -->
<script src="<?php echo base_url('js/tags/jquery.tagsinput.min.js'); ?>"></script>
<!-- switchery -->
<script src="<?php echo base_url('js/switchery/switchery.min.js'); ?>"></script>
<!-- input mask -->
<script src="<?php echo base_url('js/input_mask/jquery.inputmask.js'); ?>"></script>
<!-- daterangepicker -->
<script type="text/javascript" src="<?php echo base_url('js/moment/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/datepicker/daterangepicker.js'); ?>"></script>
<!-- richtext editor -->
<script src="<?php echo base_url('js/editor/bootstrap-wysiwyg.js'); ?>"></script>
<script src="<?php echo base_url('js/editor/external/jquery.hotkeys.js'); ?>"></script>
<script src="<?php echo base_url('js/editor/external/google-code-prettify/prettify.js'); ?>"></script>
<!-- select2 -->
<script src="<?php echo base_url('js/select/select2.full.js'); ?>"></script>
<!-- form validation -->
<script type="text/javascript" src="<?php echo base_url('js/parsley/parsley.min.js'); ?>"></script>
<!-- textarea resize -->
<script src="<?php echo base_url('js/textarea/autosize.min.js'); ?>"></script>
<script>
	autosize($('.resizable_textarea'));
</script>
<!-- Autocomplete -->
<script type="text/javascript" src="<?php echo base_url('js/autocomplete/countries.js'); ?>"></script>
<script src="<?php echo base_url('js/autocomplete/jquery.autocomplete.js'); ?>"></script>
<!-- pace -->
<script src="<?php echo base_url('js/pace/pace.min.js'); ?>"></script>
<!-- custom.js -->
<script src="<?php echo base_url('js/custom.js'); ?>"></script>
<!-- dropzone -->
<script src="<?php echo base_url('js/dropzone/dropzone.js'); ?>"></script>
<!-- bootstrap progress js -->
<script src="<?php echo base_url('js/progressbar/bootstrap-progressbar.min.js'); ?>"></script>
<script src="<?php echo base_url('js/nicescroll/jquery.nicescroll.min.js'); ?>"></script>
<!-- flot js -->
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.pie.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.orderBars.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.time.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/date.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.spline.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.stack.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/curvedLines.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/flot/jquery.flot.resize.js'); ?>"></script>
<!-- echart -->
<script src="<?=base_url('js/echart/echarts-all.js')?>"></script>
<script src="<?=base_url('js/echart/green.js')?>"></script>

<!-- /Importar JS Aqui -->

<!-- Demais Scripts -->
<script type="text/javascript">
	var myChart = echarts.init(document.getElementById('echart_line'), theme);
	myChart.setOption({
		title: {
			text: 'Acessos na Última Semana',
			subtext: 'Acompanhe o número de acessos ao seu site dia-a-dia'
		},
		tooltip: {
			trigger: 'axis'
		},
		legend: {
			data: ['Acessos no dia']
		},
		calculable: false,
		xAxis: [{
			type: 'category',
			boundaryGap: false,
			data: lastWeekJS,
			axisLabel:{interval: 0}
		}],
		yAxis: [{
			type: 'value',
			min: 0,
			max: limitValue
		}],
		series: [{
			name: 'Acessos no dia',
			type: 'line',
			smooth: true,
			itemStyle: {
				normal: {
					areaStyle: {
						type: 'line'
					},
					lineStyle: {
						type: 'dotted'
					}
				}
			},
			data: viewsLastWeek
		}]
	});

	var myChart = echarts.init(document.getElementById('echart_bar_horizontal'), theme);
	myChart.setOption({
		title: {
			text: 'Acessos Totais por Seção',
			subtext: 'Descubra a popularidade de cada seção do seu site'
		},
		tooltip: {
			trigger: 'axis'
		},
		legend: {
			data: ['Acessos à Seção'],
			x: 'right'
		},
		calculable: false,
		xAxis: [{
			type: 'value',
			boundaryGap: [0, 0.01],
			min: 0,
			max: 100
		}],
		yAxis: [{
			type: 'category',
			data: ['Contato', 'Imagens', 'Empresa', 'Serviços', 'Home']
		}],
		series: [{
			name: 'Acessos à Seção',
			type: 'bar',
			data: [sectionsViews.contato.count,
					sectionsViews.imagens.count,
					sectionsViews.empresa.count,
					sectionsViews.servicos.count,
					sectionsViews.home.count]
		}]
	});

	var myChart9 = echarts.init(document.getElementById('mainb'), theme);
	myChart9.setOption({
		title: {
			text: 'Acessos Hoje',
			subtext: 'Monitore os acessos ao seu site no dia de hoje'
		},
		tooltip: {
			trigger: 'axis'
		},
		legend: {
			data: ['Home', 'Serviços', 'Empresa', 'Imagens', 'Contato'],
			x: 'right'
		},
		toolbox: {
			show: false
		},
		calculable: false,
		xAxis: [{
			type: 'category',
			data: ['Sex 11/11/2016'] //Get current day
		}],
		yAxis: [{
			type: 'value',
			max: 10 //Get value for max based on top value
		}],
		series: [{
			name: 'Home',
			type: 'bar',
			data: [todaysViews.home.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Serviços',
			type: 'bar',
			data: [todaysViews.servicos.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Empresa',
			type: 'bar',
			data: [todaysViews.empresa.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Imagens',
			type: 'bar',
			data: [todaysViews.imagens.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}, {
			name: 'Contato',
			type: 'bar',
			data: [todaysViews.contato.count],
			markLine: {
				data: [{
					type: 'max',
					name: 'Acessos'
				}],
				symbolSize: [6, 4]
			}
		}

		]
	});

</script>

<!-- form validation -->
<script type="text/javascript">
	$(document).ready(function() {
		$.listen('parsley:field:validate', function() {
			validateFront();
		});
		$('#demo-form .btn').on('click', function() {
			$('#demo-form').parsley().validate();
			validateFront();
		});
		var validateFront = function() {
			if (true === $('#demo-form').parsley().isValid()) {
				$('.bs-callout-info').removeClass('hidden');
				$('.bs-callout-warning').addClass('hidden');
			} else {
				$('.bs-callout-info').addClass('hidden');
				$('.bs-callout-warning').removeClass('hidden');
			}
		};
	});

	$(document).ready(function() {
		$.listen('parsley:field:validate', function() {
			validateFront();
		});
		$('#demo-form2 .btn').on('click', function() {
			$('#demo-form2').parsley().validate();
			validateFront();
		});
		var validateFront = function() {
			if (true === $('#demo-form2').parsley().isValid()) {
				$('.bs-callout-info').removeClass('hidden');
				$('.bs-callout-warning').addClass('hidden');
			} else {
				$('.bs-callout-info').addClass('hidden');
				$('.bs-callout-warning').removeClass('hidden');
			}
		};
	});
	try {
		hljs.initHighlightingOnLoad();
	} catch (err) {}
</script>
<!-- /form validation -->
<!-- editor -->
<script>
	$(document).ready(function() {
		$('.xcxc').click(function() {
			$('#descr').val($('#editor').html());
		});
	});

	$(function() {
		function initToolbarBootstrapBindings() {
			var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
			'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
			'Times New Roman', 'Verdana'
			],
			fontTarget = $('[title=Font]').siblings('.dropdown-menu');
			$.each(fonts, function(idx, fontName) {
				fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
			});
			$('a[title]').tooltip({
				container: 'body'
			});
			$('.dropdown-menu input').click(function() {
				return false;
			})
			.change(function() {
				$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
			})
			.keydown('esc', function() {
				this.value = '';
				$(this).change();
			});

			$('[data-role=magic-overlay]').each(function() {
				var overlay = $(this),
				target = $(overlay.data('target'));
				overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
			});
			if ("onwebkitspeechchange" in document.createElement("input")) {
				var editorOffset = $('#editor').offset();
				$('#voiceBtn').css('position', 'absolute').offset({
					top: editorOffset.top,
					left: editorOffset.left + $('#editor').innerWidth() - 35
				});
			} else {
				$('#voiceBtn').hide();
			}
		};

		function showErrorAlert(reason, detail) {
			var msg = '';
			if (reason === 'unsupported-file-type') {
				msg = "Unsupported format " + detail;
			} else {
				console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
				'<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
		};
		initToolbarBootstrapBindings();
		$('#editor').wysiwyg({
			fileUploadError: showErrorAlert
		});
		window.prettyPrint && prettyPrint();
	});
</script>
<!-- /editor -->
<!-- /Demais Scripts -->

<!-- Meu JS -->
<script type="text/javascript" charset="utf-8" async defer>
	var icones = ['arrow-circle-down', 'arrow-circle-left', 'arrow-circle-right',
	'arrow-circle-up', 'arrow-down', 'arrow-left', 'arrow-right', 'arrow-up', 'bolt', 'briefcase', 'building', 'building-o',
	'bus', 'car', 'caret-down', 'caret-left', 'caret-right', 'caret-up', 'check', 'check-circle', 'check-circle-o', 'chevron-circle-down', 'chevron-circle-left', 'chevron-circle-right', 'chevron-circle-up', 'desktop', 'envelope', 'exclamation-triangle', 'home', 'lightbulb-o', 'motorcycle', 'question', 'question-circle', 'shopping-bag', 'shopping-basket', 'star', 'star-o', 'sun-o', 'truck', 'user'];

	$(".botao_menu_mobile").click(function() {
		if ($(".menu_mobile").hasClass('menu_visible')) {
			$(".menu_mobile").addClass('menu_hidden');
			$(".menu_mobile").removeClass('menu_visible');
		} else {
			$(".menu_mobile").addClass('menu_visible');
			$(".menu_mobile").removeClass('menu_hidden');
		}
	});

	$(document).ready(function () {
		adjustElements();

		var icon_selector = [];

		for (var k = 0; k < icones.length; k++) {
			icon_selector.push("<i class='fa fa-"+icones[k]+" icone_seletor' data-value='"+icones[k]+"'></i>");
		}

		$(".select_icon").html(icon_selector.join(""));
		$(".icone_seletor").click(function () {
			$("#input_icone").val($(this).data('value'));
			$(".previa_icone").attr('class', 'fa fa-' + $(this).data('value') + ' previa_icone');
		});

	});

	window.onresize = function () {
		adjustElements();
	};


	function adjustElements () {
		$(".container_secao").css('height', (window.innerHeight - 60) + "px");
		$("#img_servicos").css('height', (($("#secao_servicos").outerHeight() / 100) * 50) + "px");
	}

	function setTarget (from, to, event) {
		if (event == null) {
			event = 'click';
		}

		$(from).click(function() {
			$(to).trigger(event);
		});
	}

	// Editar Imagens
	setTarget('#form_submit_galeria', '#submit_galeria');
	setTarget('#img_select_galeria', '#imagens_galeria');
	// /Editar Imagens

	// Editar Serviços
	setTarget('#select_img', '#imagem');
	// /Editar Serviços

	// Editar Contato
	setTarget('#select_img_contato', '#imagem_contato');
	// /Editar Contato

	$(document).ready(function() {
		$(":input").inputmask();
	});

	$('.popover_element').popover({
		placement: function (context, source) {
			var position = $(source).offset();

			if (position.left > 515)
			{
				return 'left';
			}

			if (position.left < 515)
			{
				if (position.left < 30) {
					if (position.top < 110) {
						return 'bottom';
					}

					return 'top';
				}

				return 'right';
			}

			if (position.top < 110)
			{
				return 'bottom';
			}

			return 'top';
		}
	});

	$('[data-toggle="popover"]').popover();

	$(document).ready(function () {
		if (($(".count-update-badge").html()) == null) {
			$(".count-update-badge").css('display', 'none');
		}

		if (($(".count-update-badge-modal").html()) == null) {
			$(".count-update-badge-modal").css('display', 'none');
		}
	});

	$(".atualizacao-visualizada-false").hover(function () {
		var idUpd = $(this).data('id')
		, url = base_url + 'sistema/main/viewUpdate/' + idUpd
		;

		$.get(url, function (retorno) {
			retorno = JSON.parse(retorno);

			if (retorno.count > 0) {
				$(".count-update-badge").html(retorno.count);
				$(".count-update-badge").css('display', 'inline-block');
				$(".count-update-badge-modal").html(retorno.count + " novas");
				$(".count-update-badge-modal").css('display', 'inline-block');
			} else {
				$(".count-update-badge").css('display', 'none');
				$(".count-update-badge-modal").css('display', 'none');
			}

			$('.atualizacao-visualizada-false[data-id="'+idUpd+'"]').addClass('atualizacao-visualizada-true');
			$('.atualizacao-visualizada-false[data-id="'+idUpd+'"]').removeClass('atualizacao-visualizada-false');

		});

	});

	$(".flat.imagem_galeria_check").on('ifChanged', function () {
		if ( $(".flat:checked").length > 1 ) {
			var imagens = getMultipleImages();

			$(".excluir_multiplas_link").prop('href', base_url + 'sistema/imagens/excluir/' + imagens['ids']);
			$(".download_multiplas_link").prop('href', base_url + 'sistema/imagens/download/' + imagens['ids']);
			$(".excluir_multiplas_legenda").html(imagens['mensagem']);
			$("#excluir_multiplas_div").css('display', 'block');
		} else {
			$(".excluir_multiplas_link").prop('href', 'javascript:void(0)');
			$(".download_multiplas_link").prop('href', 'javascript:void(0)');
			$("#excluir_multiplas_div").css('display', 'none');
		}
	});

	$("#select_full_gallery").on('ifChecked', function () {
		$(".flat").prop('checked', true);
		$(".icheckbox_flat-green").addClass('checked');

		var imagens = getMultipleImages();

		$(".excluir_multiplas_link").prop('href', base_url + 'sistema/imagens/excluir/' + imagens['ids']);
		$(".download_multiplas_link").prop('href', base_url + 'sistema/imagens/download/' + imagens['ids']);
		$(".excluir_multiplas_legenda").html(imagens['mensagem']);
		$("#excluir_multiplas_div").css('display', 'block');
	});

	$("#select_full_gallery").on('ifUnchecked', function () {
		$(".flat").prop('checked', false);
		$(".icheckbox_flat-green").removeClass('checked');

		$(".excluir_multiplas_link").prop('href', 'javascript:void(0)');
		$(".download_multiplas_link").prop('href', 'javascript:void(0)');
		$("#excluir_multiplas_div").css('display', 'none');
	});


	$("#remove_img").click(function () {
		$("#img_selecionada").html("Ainda não existe uma imagem para esta categoria");
		$("#has_img").val("false");
	});

	$("#editor").blur(function () {
		$("#descr").html($("#editor").html());
	});



	$("#imagens_galeria").change(function () {
		var label_text = []
		, arquivos = $("#imagens_galeria")[0].files
		, texto_imgs = "<h4>" + arquivos.length
		;

		for (var i = 0; i < arquivos.length; i++) {
			label_text.push("&bull; " + arquivos[i].name);
		}

		if (arquivos.length > 1) {
			texto_imgs +=" imagens selecionadas: </h4>";
		} else {
			texto_imgs +=" imagem selecionada: </h4>";
		}

		$("#img_selecionada").html("<label id='img_selecionada' for='imagem'>" + texto_imgs + label_text.join("<br />") + "</label>");
			// $("#has_img").val("true");
		});

	$("#btn_reset_form").click(function () {
		location.reload();
	});

	$(".miniatura_galeria_sistema").click(function () {

		var id = $(this).data('id');
		var url = base_url + 'sistema/imagens/getInfo/'+id;
		$.get(url, function(retorno) {
			retorno = JSON.parse(retorno);

			$("#titulo_img_modal").val(retorno.titulo);
			$("#legenda_img_modal").html(retorno.texto);
			$("#id_img_modal").val(retorno.id);
			$("#img_modal_full").attr('src', base_url + retorno.caminho);

			var caminho_imagem = base_url + retorno.caminho;
			$("#nome_imagem_modal").html(retorno.nome);
			$("#caminho_imagem_modal").html("<a href=" + caminho_imagem + ">"+ caminho_imagem +"</a>");
			$("#tamanho_imagem_modal").html(formatSizeNumber(retorno.tamanho));

			$("#img_full_modal").modal('show');
		});

	});

	$(".open_att_modal").click(function () {
		$(".atualizacoes_modal").modal('show');
	});

	function getMultipleImages () {
		var imagens_deletar = []
		, mensagem
		, retorno = []
		;

		$(".flat.imagem_galeria_check:checked").each(function () {
			imagens_deletar.push($(this).val());
		});

		if (imagens_deletar.length == $(".flat.imagem_galeria_check").length) {
			mensagem = "Todas as " + $(".flat.imagem_galeria_check").length + " imagens selecionadas.";
			$("#select_full_gallery").prop('checked', true);
			$("#select_full_gallery_div > .icheckbox_flat-green").addClass('checked');
		} else {
			mensagem = imagens_deletar.length + " de " + $(".flat.imagem_galeria_check").length + " imagens selecionadas.";
			$("#select_full_gallery").prop('checked', false);
			$("#select_full_gallery_div > .icheckbox_flat-green").removeClass('checked');
		}

		retorno['ids'] = imagens_deletar.join('_');
		retorno['mensagem'] = mensagem;

		return retorno;
	};

	function formatSizeNumber (num) {
		var retorno;
				// (retorno.tamanho / 1024).toFixed(2) + "Mb"
				num = parseFloat(num);
				if (num > 1024) {
					retorno = (num / 1024).toFixed(2) + "Mb";
					return retorno;
				}

				retorno = (num).toFixed(0) + "Kb";
				return retorno;
			}

		</script>
		<!-- /Meu JS -->

	</body>
	</html>