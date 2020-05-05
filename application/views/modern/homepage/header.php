
<!doctype html>
<html lang="en">
    <head> 
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="<?= $this->creative_lib->fetch_image(my_config('favicon'), 2); ?>" type="image/png">
        <title> <?= $page_title ?> </title>
        <!-- Bootstrap CSS --> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/dist/bootstrap/bootstrap.min.css'); ?>"> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/linericon/style.css'); ?>">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fontawesome-free/css/all.min.css'); ?>">   
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/socicon/style.css'); ?>">   
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/nice-select/css/nice-select.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/owl-carousel/owl.carousel.min.css'); ?>"> 
    
        <!-- DateTimePicker -->
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/datetimepicker/jquery.datetimepicker.css'); ?>">
    
        <!-- main css --> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/style.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/responsive.css'); ?>"> 
        <!-- Croppie -->
        <link rel="stylesheet" href="<?= base_url('backend/css/plugins/croppie.css'); ?>">

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">

        <style type="text/css">
            .banner_area .bg-parallax {
                <?php if (isset($content['banner'])): ?> 
                background: url("<?= $this->creative_lib->fetch_image($content['banner']); ?>") no-repeat scroll center 0/cover; 
                <?php else: ?>
                background: linear-gradient(47deg, #00BCD4, #FF9800) scroll;
                <?php endif; ?>
            }

            .facilities_area .bg-parallax {  
                background: url("<?= $this->creative_lib->fetch_image(my_config('facilities_banner')); ?>") no-repeat scroll center 0/cover; 
            }

            .blog_banner_two .bg-parallax {
                background: url("<?= $this->creative_lib->fetch_image(my_config('breadcrumb_banner')); ?>") no-repeat scroll center top/cover;
            }

            .breadcrumb_area .bg-parallax { 
                background: url("<?= $this->creative_lib->fetch_image(my_config('breadcrumb_banner')); ?>") no-repeat scroll center 0/cover; 
            }
            
            .blog_banner .bg-parallax { 
                background: url("<?= $this->creative_lib->fetch_image(my_config('facilities_banner')); ?>") no-repeat scroll center center;
            }
        </style>
    </head>
    <body>

        <script type="text/javascript">
          siteUrl = "<?=site_url()?>";
          site_currency = "$";
        </script> 

        <!--================Header Area =================-->
        <header class="header_area">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="<?= site_url() ?>"><img src="<?= $this->creative_lib->fetch_image(my_config('site_logo'), 2); ?>" style="max-height: 50px" alt="<?=my_config('site_name')?> Logo"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav ml-auto"> 
                            <?= $this->hms_parser->navbar_links($page, int_bool(1))?> 
                        </ul>
                    </div> 
                </nav>
            </div>
        </header>
        <!--================Header Area =================-->
        
