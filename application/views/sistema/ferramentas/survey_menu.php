<div class="container_menu_gallery_item_display">
	<i class="fa fa-ellipsis-v more_gallery_item_display inactive" aria-hidden="true"></i>
	<ul class="menu_gallery_item_display inactive">
		<li class="item_menu_gallery_item_display" data-item="details">
			<i class="fa fa-info-circle icon_menu_gallery_item" aria-hidden="true"></i>
			<span class="text_menu_gallery_item">Detalhes</span>
		</li>
		<?php if (!!$running): ?>
			<li class="item_menu_gallery_item_display" data-item="edit">
				<i class="fa fa-pencil-square-o icon_menu_gallery_item" aria-hidden="true"></i>
				<span class="text_menu_gallery_item">Editar</span>
			</li>
		<?php endif ?>
		<li class="item_menu_gallery_item_display" data-item="delete">
			<i class="fa fa-times icon_menu_gallery_item" aria-hidden="true"></i>
			<span class="text_menu_gallery_item">Excluir</span>
		</li>
	</ul>
</div>