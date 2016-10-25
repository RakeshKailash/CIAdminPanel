<ul class="menu_cabecalho hide-sm">
	<?php if ($this->session->userdata('login') != null) : ?>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/home/editar' ); ?>">
				<i class="fa fa-pencil" aria-hidden="true"></i>Home
			</a>
		</li>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/servicos/editar' ); ?>">
				<i class="fa fa-pencil" aria-hidden="true"></i>Serviços
			</a>
		</li>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/empresa/editar' ); ?>">
				<i class="fa fa-pencil" aria-hidden="true"></i>Empresa
			</a>
		</li>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/imagens/editar' ); ?>">
				<i class="fa fa-pencil" aria-hidden="true"></i>Imagens
			</a>
		</li>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/contato/editar' ); ?>">
				<i class="fa fa-pencil" aria-hidden="true"></i>Contato
			</a>
		</li>
		<li class="item_menu_cabecalho">
			<a href="<?php echo base_url('sistema/usuario/editar' ); ?>">
				<i class="fa fa-user" aria-hidden="true"></i>Usuário
			</a>
		</li>
	<?php endif; ?>
	<li class="item_menu_cabecalho">
		<a href="<?php echo base_url('site' ); ?>">
			<i class="fa fa-chevron-circle-left" aria-hidden="true" style="margin-left: 0; margin-right: 10px;"></i>Voltar ao Site
		</a>
	</li>
</ul>

<span class="botao_menu_mobile hide-l"><i class="fa fa-bars" aria-hidden="true"></i></span>

<ul class="menu_mobile hide-l menu_hidden">
<?php if ($this->session->userdata('login') != null) : ?>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/home/editar' ); ?>">
				Home<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</li>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/servicos/editar' ); ?>">
				Serviços<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</li>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/empresa/editar' ); ?>">
				Empresa<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</li>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/imagens/editar' ); ?>">
				Imagens<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</li>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/contato/editar' ); ?>">
				Contato<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</li>
		<li class="item_menu_mobile">
			<a href="<?php echo base_url('sistema/usuario/editar' ); ?>">
				Usuário<i class="fa fa-user" aria-hidden="true"></i>
			</a>
		</li>
	<?php endif; ?>
	<li class="item_menu_mobile">
		<a href="<?php echo base_url('site' ); ?>">
			Voltar ao Site<i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
		</a>
	</li>
</ul>