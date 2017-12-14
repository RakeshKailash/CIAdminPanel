<?php
$info['title'] = array('Lorem Ipsum', 'Imagens');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
$countImg = 0;

$commentInfo['comentarios'] = $comentarios;
?>

<div class="container_secao" id="secao_imagens">
	<section class="global-page-header">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block">
						<h2>Imagens</h2>
						<ol class="breadcrumb">
							<li>
								<a href="<?=base_url('site');?>">
									<i class="ion-ios-home"></i>
									Home
								</a>
							</li>
							<li class="active">Imagens</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#Page header-->

	<section id="gallery" class="gallery">
		<div class="container">
			<div class="row">
				<?php foreach ($imagens as $imagem): ?>
					<?php
					if ($countImg == 3)
					{
						echo "</div><div class='row'>";
						$countImg = 0;
					}
					?>
					<div class="col-sm-4 col-xs-12">
						<figure class="wow fadeInLeft animated portfolio-item animated" data-imgid="<?=$imagem->id?>" data-wow-duration="500ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 300ms; -webkit-animation-duration: 300ms; animation-delay: 0ms; -webkit-animation-delay: 0ms; animation-name: fadeInLeft; -webkit-animation-name: fadeInLeft;">
							<div class="img-wrapper">
								<img src="<?=base_url($imagem->caminho);?>" class="img-responsive">
								<div class="overlay">
									<div class="buttons">
										<a class="img_thumb_site" data-title="<?=$imagem->titulo;?>" data-caption="<?=$imagem->texto;?>" href="<?=base_url($imagem->caminho);?>">Visualizar</a>
									</div>
								</div>
							</div>
						</figure>
					</div>
					<?php $countImg++; ?>
				<?php endforeach ?>
			</div>
		</div>
	</section>

	<div class="modal" tabindex="-1" role="dialog" id="img_full_modal_site" style="z-index: 1041;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Título da Imagem</h4>
				</div>
				<div class="modal-body" id="img_modal_body">
					<div class="image_modal_inside col-lg-12 col-xs-12 col-md-12">
						<img src="#" alt="Não foi possível carregar" class="thumbnail col-lg-12 col-xs-12 col-md-12" id="img_modal_full" style="height: auto;">
					</div>
					<div class="tools_modal_inside">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<h6>Legenda da imagem</h6>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<?php
	if ($secao_info->comentarios) {
		$this->load->view('site/common/comentarios', $commentInfo);
	}
	?>

</div>

<script type="text/javascript">
	$(".img_thumb_site").click(function (e) {
		e.preventDefault();

		var link = $(this).attr("href")
		, title = $(this).data('title')
		, caption = $(this).data('caption')
		;

		$("#img_full_modal_site #img_modal_full").attr("src", link);
		$("#img_full_modal_site .modal-title").html(title);
		$("#img_full_modal_site .modal-title").html(title);
		$("#img_full_modal_site .tools_modal_inside h6").html(caption);
		$("#img_full_modal_site").modal("show");
	})
</script>

<?php $this->load->view('footer'); ?>