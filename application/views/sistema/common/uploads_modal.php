<div id="container_gallery_select">
	<div id="overlay_uploads_gallery"></div>
	<div id="gallery_select">
		<p id="title_gallery_select">Galeria de Uploads</p>
		<span id="author_uploads"><?=$_SESSION['login']?></span>
		<input type="file" name="arquivos_upload[]" id="arquivos_upload" multiple style="display: none;">
		<div id="new_upload_container">
			<div id="new_upload">
				<span>Novo Upload</span>
				<i class="fa fa-plus" aria-hidden="true"></i>
			</div>
			<div id="clear_uploads">
				<span>Remover Todos</span>
				<i class="fa fa-minus" aria-hidden="true"></i>
			</div>
			<div id="upload_files">
				<span>Enviar Arquivos</span>
				<i class="fa fa-check" aria-hidden="true"></i>
			</div>
			<div id="preview_uploads" style="text-align: center;"></div>
		</div>
		<div id="imgs_gallery_select">
			<?php foreach ($uploads as $upload): ?>
				<?php if ($upload->id_autor == $_SESSION['id']): ?>
					<div class="img_gallery_select" data-imgid="<?=$upload->id?>" style="background-image: url(<?=base_url($upload->caminho)?>)">
						<span><?=$upload->nome?></span>
					</div>
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	$("#arquivos_upload").change(function () {
		var label_text = []
		, arquivos = $("#arquivos_upload")[0].files
		, texto_imgs = "<h4>" + arquivos.length
		, preview_img
		;

		$("#clear_uploads").css('display', 'inline-block');
		$("#upload_files").css('display', 'inline-block');
		$("#preview_uploads").html(null);

		for (var i = 0; i < arquivos.length; i++) {
			label_text.push("&bull; " + arquivos[i].name);
			preview_img = "<div class='img_gallery_select preview'><span>"+arquivos[i].name+"</span></div>";
			$("#preview_uploads").append(preview_img);
			createImgPreview(arquivos[i], $('.img_gallery_select.preview')[i], 'div');
		}

		if (arquivos.length > 1) {
			texto_imgs +=" imagens selecionadas: </h4>";
		} else {
			texto_imgs +=" imagem selecionada: </h4>";
		}

		$("#img_selecionada").html(texto_imgs);
	});

	$("#clear_uploads").click(function () {
		clearUploads();
	});

	$("#upload_files").click(function () {
		console.log("clicou");
		var url = base_url + "sistema/uploads/uploadFiles";
		$('#arquivos_upload').wrap('<form action="<?=base_url('sistema/uploads/uploadFiles')?>" method="post" enctype="multipart/form-data">').closest('form').get(0).submit();
		// $.get(url, function (response) {
		// 	console.log("voltou");
		// 	response = JSON.parse(response);

		// 	console.log(response);

		// 	if (! response) {
		// 		return false;
		// 	}

		// 	clearUploads();

		// 	var filesList = [];

		// 	for(var i = 0; i < response.length; i++) {
		// 		filesList.push("<div class='img_gallery_select' data-imgid='"+response[i].id+"' style='background-image: url("+base_url+response[i].caminho+")'>",
		// 				"<span>"+response[i].nome+"</span>",
		// 			"</div>");
		// 	}

		// 	$("#imgs_gallery_select").html(filesList.join(""));
		// });
	});

	function clearUploads () {
		$('#arquivos_upload').wrap('<form>').closest('form').get(0).reset();
		$('#arquivos_upload').unwrap();

		$("#clear_uploads").css('display', 'none');
		$("#upload_files").css('display', 'none');
		$("#preview_uploads").html(null);
	}

</script>