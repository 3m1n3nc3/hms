<?php $title = isset($title) ? $title  : 'welcome' ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?=$title?></title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fontawesome-free/css/all.min.css'); ?>">  
		<!-- Theme style -->
		<link rel="stylesheet" href="<?= base_url('backend/modern/dist/css/adminlte.min.css'); ?>">
		<![endif]-->
		<!-- Google Font -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<body class="hold-transition layout-top-nav">
		<script type="text/javascript">
			site_url = '<?php echo base_url(); ?>';
		</script>
		<div class="wrapper">

			<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
				<div class="container">
					<a href="<?php echo base_url() ?>" class="navbar-brand">
						<img src="<?= base_url('backend/modern/dist/img')?>/AdminLTELogo.png" alt="<?=HOTEL_NAME?> Logo" class="brand-image img-circle elevation-3"
						style="opacity: .8">
						<span class="brand-text font-weight-light"><?=HOTEL_NAME?></span>
					</a>
	 				
					<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse order-3" id="navbarCollapse">
						<!-- Left navbar links -->
						<ul class="navbar-nav">
							<li class="nav-item">
								<a href="<?php echo base_url() ?>" class="nav-link">Home</a>
							</li>
							<li class="nav-item">
								<a href="#" class="nav-link">Contact</a>
							</li> 
						</ul> 
					</div> 
				</div>
			</nav>
			<!-- /.navbar -->




























 
