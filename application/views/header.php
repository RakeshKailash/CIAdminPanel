<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title><?php echo $title[1] ?> - Projeto CI</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Roboto:400,500,700" rel="stylesheet"> 
	<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script>
	<link href="<?php echo base_url('fonts/css/font-awesome.min.css'); ?>" rel="stylesheet">


	<?php if ($cabecalho['header'] == 'sistema') : ?>
		<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('css/animate.min.css'); ?>" rel="stylesheet">
		<!-- Custom styling plus plugins -->
		<link href="<?php echo base_url('css/custom.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('css/icheck/flat/green.css'); ?>" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/maps/jquery-jvectormap-2.0.3.css'); ?>" />
		<link href="<?php echo base_url('css/floatexamples.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('js/nprogress.js'); ?>"></script>
		<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
		<!-- editor -->
		<link href="<?php echo base_url('css/editor/external/google-code-prettify/prettify.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('css/editor/index.css'); ?>" rel="stylesheet">
		<!-- select2 -->
		<link href="<?php echo base_url('css/select/select2.min.css'); ?>" rel="stylesheet">
		<!-- switchery -->
		<link rel="stylesheet" href="<?php echo base_url('css/switchery/switchery.min.css'); ?>" />


	<?php endif; ?>

		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">

		<script > var base_url = "<?=base_url()?>";</script>



</head>
<body>

	<?php 

	if ($cabecalho['menu'] != null && $cabecalho['header'] == 'site') {
		echo "<div id='cabecalho'> <p id='titulo_site'>Lorem Ipsum</p>";
		$this->load->view($cabecalho['menu']);
		echo "</div>";
	}
	?>