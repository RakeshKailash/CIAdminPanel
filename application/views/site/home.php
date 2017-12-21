<?php
$info['title'] = array('Lorem Ipsum', 'Home');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['itens'] = $itens;
$this->load->view('header', $info);
?>
<section id="hero-area" style="height: 100%; <?php if (! empty($secao_info->caminho)):?>background-size: cover; background-position: center; background-image: url(<?=base_url($secao_info->caminho);?>); <?php endif; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<div class="block wow fadeInUp" data-wow-delay=".3s">

					<!-- Slider -->
					<section class="cd-intro">
						<h1 class="wow fadeInUp animated cd-headline slide" data-wow-delay=".4s" >
							<span><?=$secao_info->conteudo?></span>
							<!-- <span class="cd-words-wrapper">
								<b class="is-visible">CONSECTETUR</b>
								<b>ADIPISCING</b>
								<b>ELIT</b>
							</span> -->
						</h1>
					</section> <!-- cd-intro -->
					<!-- /.slider -->
					<!-- <h2 class="wow fadeInUp animated" data-wow-delay=".6s" >
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat...
					</h2> -->
					<!-- <a class="btn-lines dark light wow fadeInUp animated btn btn-default btn-green" data-wow-delay=".9s" href="<?=base_url('site/servicos')?>">Saiba Mais</a> -->

				</div>
			</div>
		</div>
	</div>
</section><!--/#main-slider-->

<?php $this->load->view('footer'); ?>