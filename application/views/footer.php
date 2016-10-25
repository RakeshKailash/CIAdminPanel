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

<!-- /Importar JS Aqui -->

<!-- Demais Scripts -->
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

	// Editar Contato
	setTarget('#select_img_contato', '#imagem_contato');
	// /Editar Contato

	$(document).ready(function() {
		$(":input").inputmask();
	});
</script>
<!-- /Meu JS -->

</body>
</html>