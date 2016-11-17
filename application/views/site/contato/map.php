<div class="map-area">
	<h2 class="subtitle  wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".3s">Nos Encontre</h2>

	<?php if (isset($map_message)) : ?>
		<p class="subtitle-des wow fadeInDown" data-wow-duration="500ms" data-wow-delay=".5s">
			<?=$map_message;?>
		</p>
	<?php endif ?>
	<div class="map">
		<iframe width="100%" height="400" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCGFrB3MI-kCSz76Op_xBGnmB4qO3MguUI&q=<?=$address;?>" allowfullscreen></iframe>

	</div>
</div>