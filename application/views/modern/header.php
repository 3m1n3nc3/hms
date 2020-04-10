<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php 
  $list_services = $this->services_model->get_service();
  $employee = $this->employee_model->getEmployee($this->uid, 1);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= $this->creative_lib->fetch_image(my_config('favicon'), 2); ?>" type="image/png">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?=$title?></title>

    <!-- Font Awesome Icons --> 
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fontawesome-free/css/all.min.css'); ?>">  

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
    
    <!-- Datatables -->
    <?php if (isset($use_table) && $use_table): ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/modern/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <?php endif ?>
    
    <!-- fullCalendar -->
    <?php if (isset($has_calendar)): ?>  
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fullcalendar/main.min.css'); ?>">
    <!-- <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fullcalendar-interaction/main.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fullcalendar-daygrid/main.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fullcalendar-timegrid/main.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fullcalendar-bootstrap/main.min.css'); ?>">
    <?php endif; ?>

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('backend/modern/dist/css/adminlte.min.css'); ?>">
    <!-- Croppie -->
    <link rel="stylesheet" href="<?= base_url('backend/css/plugins/croppie.css'); ?>">

    <link href="<?= base_url('backend/js/guidely/guidely.css'); ?>" rel="stylesheet">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  </head>
  <body class="hold-transition sidebar-mini accent-info">
    
    <script type="text/javascript">
      siteUrl = "<?=site_url()?>";
      site_theme = "<?=$this->h_theme?>";
      currency_symbol = "<?=$this->cr_symbol?>";
      site_currency = "<?=$this->cr_symbol?>";
    </script>
 
    <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-light navbar-warning text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=site_url('dashboard')?>" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=site_url('page/contact-us')?>" class="nav-link">Contact</a>
          </li>
        </ul> 
        
        <!-- SEARCH FORM -->
        <?= form_open('search', ['class' => 'form-inline ml-3', 'method' => 'post'])?> 
          <div class="input-group input-group-sm">
            <input type="text" name="customer" class="form-control form-control-navbar" type="search" placeholder="Search Customer" aria-label="Search" value="<?= set_value('customer')?>">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        <?= form_close()?> 

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

          <!-- Add Messages Dropdown Menu Here --> 

          <!-- Add Notifications Dropdown Menu Here --> 

          <?php if(UID): ?> 
          <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $this->creative_lib->fetch_image($employee['image'], 3); ?>" class="user-image img-circle elevation-2" alt="Employee Image">
              <span class="d-none d-md-inline"><?=USERNAME?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-light">
                <img src="<?= $this->creative_lib->fetch_image($employee['image'], 3); ?>" class="img-circle elevation-2" alt="User Image">

                <p>
                  <?=FULLNAME?> - <?= $employee['employee_type']?>
                  <small>Employed <?= date('M. d Y', strtotime($employee['employee_hiring_date']))?></small>
                </p>
              </li> 
              <!-- Menu Footer-->
              <li class="user-footer bg-warning">
                <a href="<?=site_url('employee/profile/my_profile')?>" class="btn btn-default btn-flat"><?=lang('profile')?></a>
                <a href="<?=site_url('login/logout')?>" class="btn btn-default btn-flat float-right">Sign out</a>
              </li>
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light-warning elevation-4">
        <!-- Brand Logo -->
        <a href="<?= site_url() ?>" class="brand-link text-sm">
          <img src="<?= $this->creative_lib->fetch_image(my_config('site_logo'), 4); ?>" alt="<?=my_config('site_name')?> Logo" class="brand-image elevation-3"
          style="opacity: .8">
          <span class="brand-text font-weight-light"></i> <?=my_config('site_name_abbr') ?? '&nbsp;'?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar"> 

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
              <?php if (has_privilege('dashboard')): ?>
                <li class="nav-item">
                  <a href="<?= site_url('dashboard')?>" class="nav-link <?= ($page == "dashboard" ? 'active' : '')?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                      <!-- <span class="right badge badge-danger">New</span> -->
                    </p>
                  </a>
                </li>
              <?php endif;?>

              <?php if (has_privilege('reservation')): ?>
                <li class="nav-item">
                  <a href="<?= site_url('reservation')?>" class="nav-link <?= ($page == "reservation" ? 'active' : '')?>">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                      Reservation
                    </p>
                  </a>
                </li>
              <?php endif;?>

              <?php if (has_privilege('rooms') || has_privilege('room-sales') || has_privilege('room-types') || has_privilege('reserved-rooms')): ?>
                <li class="nav-item has-treeview <?= ($page == "room" || $page == "room_type" || $page == "reserved" ? 'menu-open' : '') ?>">
                  <a href="#" class="nav-link <?= ($page == "room" || $page == "room_type" || $page == "reserved" ? 'active' : '') ?>">
                    <i class="nav-icon fas fa-bed"></i>
                    <p>
                      Rooms
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                  <?php if (has_privilege('reserved-rooms') || has_privilege('room-sales') ): ?>
                    <li class="nav-item"> 
                      <a href="<?= site_url('room/reserved')?>" class="nav-link <?= ($page == "reserved" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "reserved" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Reserved</p>
                      </a>
                    </li> 
                  <?php endif;?>

                  <?php if (has_privilege('rooms')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('room')?>" class="nav-link <?= ($page == "room" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "room" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Rooms</p>
                      </a>
                    </li> 
                  <?php endif;?> 

                  <?php if (has_privilege('room-types')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('room-type')?>" class="nav-link <?= ($page == "room_type" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "room_type" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Room Types</p>
                      </a>
                    </li> 
                  <?php endif;?> 

                  </ul>
                </li>
              <?php endif;?>

              <?php if (has_privilege('customers')): ?>
                <li class="nav-item">
                  <a href="<?= site_url('customer/list')?>" class="nav-link <?= ($page == "customers" ? 'active' : '')?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Customers
                    </p>
                  </a>
                </li> 
              <?php endif;?>

              <?php if (has_privilege('sales-services') || has_privilege('sales-records') || has_privilege('inventory')): ?>
                <li class="nav-item has-treeview <?= ($page == "sales-services" || $page == "inventory" || $page == "sales-records" ? 'menu-open' : '') ?>">
                  <a href="#" class="nav-link <?= ($page == "sales-services" || $page == "inventory" || $page == "sales-records" ? 'active' : '') ?>">
                    <i class="nav-icon fas fa-store"></i>
                    <p>
                      Sales Services
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">

                  <?php if (has_privilege('sales-services')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('services')?>" class="nav-link <?= ($page == "sales-services" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "sales-services" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Services</p>
                      </a>
                    </li> 
                  <?php endif;?> 

                  <?php if (has_privilege('inventory')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('services/inventory')?>" class="nav-link <?= ($page == "inventory" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "inventory" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Inventory</p>
                      </a>
                    </li> 
                  <?php endif;?> 
                  
                  <?php if (has_privilege('sales-records')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('services/sales_records')?>" class="nav-link <?= ($page == "sales-records" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "sales-records" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Sales Records</p>
                      </a>
                    </li> 
                  <?php endif;?> 

                  </ul>
                </li>
              <?php endif;?>
              
              <?php if ($list_services && service_point_access_session(TRUE) || has_privilege('sales-services')): ?>
                <li class="nav-item has-treeview <?= ($page == "service-point" ? 'menu-open' : '') ?>">
                  <a href="#" class="nav-link <?= ($page == "service-point" ? 'active' : '') ?>">
                    <i class="nav-icon fas fa-store-alt"></i>
                    <p>
                      Service Point
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>

                  <?php foreach ($list_services AS $service): ?>

                    <?php $active = isset($active_page) && $active_page == $service->service_name ? ' active' : '' ?>

                    <?php if (service_point_access($service->id) || has_privilege('sales-services')): ?>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="<?= site_url('service/point/'.$service->service_name)?>" class="nav-link<?= $active?>">
                            <i class="fa<?= ($active ? 's' : 'r')?> fa-circle nav-icon"></i>
                            <p><?= $service->service_name?></p>
                          </a>
                        </li>  
                      </ul>
                    <?php endif;?> 

                  <?php endforeach; ?>
                </li>
              <?php endif; ?>

              <?php if (has_privilege('cashier-report') || has_privilege('expense-register') || has_privilege('payments') || has_privilege('room-sales')): ?>
                <li class="nav-item has-treeview <?= ($page == "cashier-report" || $page == "expenses-register" || $page == "online_payments" || $page == "room_sales" ? 'menu-open' : '')?>">
                  <a href="#" class="nav-link <?= ($page == "cashier-report" || $page == "expenses-register" || $page == "online_payments" || $page == "room_sales" ? 'active' : '')?>">
                    <i class="nav-icon fas fa-calculator"></i>
                    <p>
                      Cashier
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>  
                  <ul class="nav nav-treeview"> 
                  
                  <?php if (has_privilege('expense-register')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('accounting/cashier/expenses_register')?>" class="nav-link <?= ($page == "expenses-register" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "expenses-register" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Expenses Register</p>
                      </a>
                    </li>  
                  <?php endif;?> 
                  
                  <?php if (has_privilege('cashier-report')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('accounting/cashier')?>" class="nav-link <?= ($page == "cashier-report" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "cashier-report" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Cashier's Report</p>
                      </a>
                    </li> 
                  <?php endif;?> 
                  
                  <?php if (has_privilege('payments')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('accounting/cashier/payments')?>" class="nav-link <?= ($page == "online_payments" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "online_payments" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Online Payments</p>
                      </a>
                    </li> 
                  <?php endif;?> 
                  
                  <?php if (has_privilege('room-sales')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('accounting/cashier/room_sales')?>" class="nav-link <?= ($page == "room_sales" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "room_sales" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Room Sales</p>
                      </a>
                    </li> 
                  <?php endif;?>  

                  </ul> 
                </li>
              <?php endif; ?>


              <?php if (has_privilege('manage-employee')): ?>
                <li class="nav-item">
                  <a href="<?= site_url('employee')?>" class="nav-link <?= ($page == "employee" ? 'active' : '')?>">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                      Employees
                    </p>
                  </a>
                </li> 
              <?php endif; ?>

              <?php if (has_privilege('manage-pages') || has_privilege('manage-privilege') || has_privilege('manage-configuration')): ?>
                <li class="nav-item has-treeview <?= ($page == "configuration" || $page == "pages" || $page == "create_page" || $page == "privilege" || $page == "facilities" ? 'menu-open' : '') ?>">
                  <a href="#" class="nav-link <?= ($page == "configuration" || $page == "pages" || $page == "create_page" || $page == "privilege" || $page == "facilities" ? 'active' : '') ?>">
                    <i class="nav-icon fas fa-user-secret"></i>
                    <p>
                      Administrator
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    
                  <?php if (has_privilege('manage-pages')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('admin/pages')?>" class="nav-link <?= ($page == "pages" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "pages" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Pages</p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="<?= site_url('admin/create_page')?>" class="nav-link <?= ($page == "create_page" ? 'active' : '')?>">
                        <i class="fa<?= ($page == "create_page" ? 's' : 'r')?> fa-circle nav-icon"></i>
                        <p>Create Page</p>
                      </a>
                    </li> 
                  <?php endif;?> 
                    
                  <?php if (has_privilege('manage-privilege')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('employee/permissions')?>" class="nav-link <?= ($page == "privilege" ? 'active' : '')?>">
                        <i class="fa fa-id-card nav-icon"></i>
                        <p>User Privileges</p>
                      </a>
                    </li> 
                  <?php endif;?> 
                    
                  <?php if (has_privilege('manage-configuration')): ?>
                    <li class="nav-item">
                      <a href="<?= site_url('admin/facilities/list')?>" class="nav-link <?= ($page == "facilities" ? 'active' : '')?>">
                        <i class="fa fa-swimmer nav-icon"></i>
                        <p>Hotel Facilities</p>
                      </a>
                    </li> 
                    <li class="nav-item">
                      <a href="<?= site_url('admin/configuration')?>" class="nav-link <?= ($page == "configuration" ? 'active' : '')?>">
                        <i class="fa fa-cogs nav-icon"></i>
                        <p>Site Configuration</p>
                      </a>
                    </li> 
                  <?php endif;?> 

                  </ul>
                </li>
              <?php endif; ?>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content (Closes at view/classic/footer.php)-->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <?php $sub_page_title = isset($sub_page_title) ? ' - ' . $sub_page_title : ''?>
                <h1 class="m-0 text-dark">
                  <span class="font-weight-bold"><?= ucwords(supr_replace($page))?></span>
                  <?= $sub_page_title ?>
                </h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="<?= site_url() ?>">Home</a>
                  </li>
                  <?php if ($this->uri->segment(1, NULL) && !$this->uri->segment(2, NULL)): ?>
                    <li class="breadcrumb-item active">
                      <?= ucwords(supr_replace($this->uri->segment(1, NULL))) ?>
                    </li> 
                  <?php elseif ($this->uri->segment(1, NULL) && $this->uri->segment(2, NULL)): ?>
                    <li class="breadcrumb-item">
                      <a href="<?= site_url($this->uri->segment(1, NULL)) ?>"><?= ucwords(supr_replace($this->uri->segment(1, NULL))) ?></a>
                    </li>
                    <li class="breadcrumb-item active">
                      <?= ucwords(supr_replace($this->uri->segment(2, NULL))) ?>
                    </li> 
                  <?php else: ?> 
                    <li class="active">
                        Home
                    </li>
                  <?php endif; ?> 
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
