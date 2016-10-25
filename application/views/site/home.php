<?php
$info['title'] = array('Lorem Ipsum', 'Home');
// $info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$info['cabecalho'] = array('menu' => 'site/menu', 'header' => 'site');
$this->load->view('header', $info);
?>

<div class="container_secao">
	<div id="container_img_home" style="background-image: url(<?php echo base_url() . 'images/uploads/mountain.jpg' ?>);">
	</div>
	
</div>

<?php $this->load->view('footer'); ?>