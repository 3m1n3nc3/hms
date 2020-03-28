<!DOCTYPE html>
<html>
  <head>
    <title><?=$title?></title>
    <meta charset="utf8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
  <!-- <link href="<?php echo base_url('backend/hoolicon/frontsite/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
	<link href="<?php echo base_url('backend/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('backend/css/bootstrap-responsive.min.css'); ?>" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
	        rel="stylesheet">
	<link href="<?php echo base_url('backend/css/font-awesome.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('backend/css/style.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('backend/css/pages/dashboard.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('backend/css/pages/signin.css'); ?>" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url('backend/js/guidely/guidely.css'); ?>" rel="stylesheet"> 


	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	    <![endif]-->
  </head>
  <body style="margin-bottom: 50px;">
  <div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> 

      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </a>
      <a class="brand" href="<?= site_url() ?>">
        <i class="icon-home"></i> <?=HOTEL_NAME?>
      </a>

      <?php if(UID): ?>
        <div class="nav-collapse">
          <ul class="nav pull-right">
            <!-- <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                              class="icon-cog"></i> Account <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="javascript:;">Settings</a></li>
                <li><a href="javascript:;">Help</a></li>
              </ul>
            </li> -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="icon-user"></i> <?=FULLNAME?> (<?=USERNAME?>) <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?= site_url('login/logout')?>">Logout</a></li>
                </ul>
            </li>

            <li>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=DEPARTMENT_NAME?></a>
            </li>
          </ul>
          
          <?= form_open('search', ['class' => 'navbar-search pull-right', 'method' => 'post'])?> 
            <input type="text" name="customer" class="search-query" placeholder="Search Customer">
          <?= form_close()?>
        </div>
        <!--/.nav-collapse --> 
      <?php endif; ?>
    </div>
    <!-- /container --> 
  </div>
  <!-- /navbar-inner --> 
</div>
<!-- /navbar -->
<?php if(UID): ?>
  <div class="subnavbar">
    <div class="subnavbar-inner">
      <div class="container">
        <ul class="mainnav">
          <li <?= ($page == "dashboard" ? 'class="active"' : '')?>>
            <a href="<?= site_url()?>"><i class="icon-dashboard"></i><span>Dashboard</span> </a> 
          </li>

          <li <?= ($page == "employee" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('employee')?>"><i class="icon-user"></i><span>Employees</span> </a> 
          </li>

          <li <?= ($page == "reservation" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('reservation')?>"><i class="icon-list-alt"></i><span>Reservation</span> </a> 
          </li>

          <li class="dropdown <?= ($page == "room" || $page == "room_type" ? 'active' : '') ?>">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-home"></i><span>Rooms</span> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?= site_url('room')?>">Rooms</a></li>
              <li><a href="<?= site_url('room-type')?>">Room Types</a></li>
            </ul>
          </li>

          <li <?= ($page == "departments" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('departments')?>"><i class="icon-file"></i><span>Depatments</span> </a> 
          </li>

          <li <?= ($page == "restaurant" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('restaurant')?>"><i class="icon-fire"></i><span>Restaurants</span> </a> 
          </li>

          <li <?= ($page == "medical_service" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('medical_service')?>"><i class="icon-user-md"></i><span>Medical Service</span> </a> 
          </li>

          <li <?= ($page == "sport_facility" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('sport_facility')?>"><i class="icon-trophy "></i><span>Sport Facility</span> </a> 
          </li>

          <li <?= ($page == "massage_room" ? 'class="active"' : '') ?>>
            <a href="<?= site_url('massage_room')?>"><i class="icon-retweet "></i><span>Massage Room</span> </a> 
          </li>

        </ul>
      </div>
      <!-- /container --> 
    </div>
    <!-- /subnavbar-inner --> 
  </div>
<?php endif; ?>
<!-- /subnavbar -->
