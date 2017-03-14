<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	<title><?php echo $title[1] ?> - Projeto CI</title>
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700|Roboto:400,500,700" rel="stylesheet">
	<script src="<?php echo base_url('js/jquery.min.js'); ?>" type="text/javascript"></script>
	<link href="<?php echo base_url('fonts/css/font-awesome.min.css'); ?>" rel="stylesheet">


	<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/animate.min.css'); ?>" rel="stylesheet">
	<?php if ($cabecalho['header'] == 'sistema') : ?>
		<!-- Custom styling plus plugins -->
		<link href="<?php echo base_url('css/custom.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('css/icheck/flat/green.css'); ?>" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/maps/jquery-jvectormap-2.0.3.css'); ?>" />
		<link href="<?php echo base_url('css/floatexamples.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('js/nprogress.js'); ?>"></script>
		<link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
	<?php endif; ?>
	<!-- editor -->
	<link href="<?php echo base_url('css/editor/external/google-code-prettify/prettify.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/editor/index.css'); ?>" rel="stylesheet">
	<!-- select2 -->
	<link href="<?php echo base_url('css/select/select2.min.css'); ?>" rel="stylesheet">
	<!-- switchery -->
	<link rel="stylesheet" href="<?php echo base_url('css/switchery/switchery.min.css'); ?>" />

	<?php if ($cabecalho['header'] != 'sistema') : ?>

	<!-- Template CSS Files
        ================================================== -->
        <!-- Ionicons Fonts Css -->
        <link rel="stylesheet" href="<?=base_url('css/ionicons.min.css');?>">
        <!-- animate css -->
        <link rel="stylesheet" href="<?=base_url('css/animate.css');?>">
        <!-- Hero area slider css-->
        <link rel="stylesheet" href="<?=base_url('css/slider.css');?>">
        <!-- owl craousel css -->
        <link rel="stylesheet" href="<?=base_url('css/owl.carousel.css');?>">
        <link rel="stylesheet" href="<?=base_url('css/owl.theme.css');?>">
        <link rel="stylesheet" href="<?=base_url('css/jquery.fancybox.css');?>">
        <!-- template main css file -->
        <link rel="stylesheet" href="<?=base_url('css/main.css');?>">
        <link rel="stylesheet" href="<?=base_url('css/overrided_styles.css');?>">
        <!-- responsive css -->
        <link rel="stylesheet" href="<?=base_url('css/responsive.css');?>">

        <!-- Template Javascript Files
        ================================================== -->
        <!-- modernizr js -->
        <script src="<?=base_url('js/vendor/modernizr-2.6.2.min.js');?>"></script>
        <!-- owl carouserl js -->
        <script src="<?=base_url('js/owl.carousel.min.js');?>"></script>
        <!-- wow js -->
        <script src="<?=base_url('js/wow.min.js');?>"></script>
        <!-- slider js -->
        <script src="<?=base_url('js/slider.js');?>"></script>
        <script src="<?=base_url('js/jquery.fancybox.js');?>"></script>
        <!-- template main js -->
        <script src="<?=base_url('js/main.js');?>"></script>

    <?php endif; ?>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/style.css'); ?>">

	<script>
		var base_url = "<?=base_url()?>";
	</script>

</head>
<body>

	<?php

	if ($cabecalho['menu'] != null && $cabecalho['header'] == 'site') {
		$this->load->view($cabecalho['menu']);
	}
	?>
