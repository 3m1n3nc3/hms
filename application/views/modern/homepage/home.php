
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="image/favicon.png" type="image/png">
        <title> <?= $page_title ?> </title>
        <!-- Bootstrap CSS --> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/dist/bootstrap/bootstrap.min.css'); ?>"> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/linericon/style.css'); ?>">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fontawesome-free/css/all.min.css'); ?>">   
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/nice-select/css/nice-select.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/vendors/owl-carousel/owl.carousel.min.css'); ?>"> 
        <!-- main css --> 
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/style.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('backend/modern/front/responsive.css'); ?>"> 

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
        <style type="text/css">
            .banner_area .bg-parallax {
                <?php if ($content['banner']): ?> 
                background: url("<?= $this->creative_lib->fetch_image($content['banner']); ?>") no-repeat scroll center 0/cover; 
                <?php else: ?>
                background: linear-gradient(47deg, #00BCD4, #FF9800) scroll;
                <?php endif; ?>
            }

            .facilities_area .bg-parallax {
                background: url("<?= base_url('backend/modern/front/image'); ?>/facilites_bg.jpg") no-repeat scroll center 0/cover; 
            }

            .blog_banner_two .bg-parallax {
                background: url("<?= base_url('backend/modern/front/image'); ?>/banner/banner-2.jpg") no-repeat scroll center top/cover;
            }
            .breadcrumb_area .bg-parallax { 
                background: url("<?= base_url('backend/modern/front/image'); ?>/about_banner.jpg") no-repeat scroll center 0/cover; 
            }
            .blog_banner .bg-parallax { 
                background: url("<?= base_url('backend/modern/front/image'); ?>/banner-1.jpg") no-repeat scroll center center;
            }
        </style>
    </head>
    <body>

        <?php
            $i_query    = array('parent' => $content['safelink']); 
            $infochildren = $this->content_model->get($i_query); 
        ?>

        <!--================Header Area =================-->
        <header class="header_area">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <a class="navbar-brand logo_h" href="index.html"><img src="<?= base_url('backend/modern/front/image'); ?>/Logo.png" alt=""></a>
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
        
        <?php if ($content['banner']): ?>

            <?php if ($page === 'homepage'): ?>

            <!--================Banner Area =================-->
            <section class="banner_area">
                <div class="booking_table d_flex align-items-center">
                    <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
                    <div class="container">
                        <div class="banner_content text-center">
                            <h6><?= $content['intro'] ?></h6>
                            <h2 <?= $content['color'] ? 'class="'.$content['color'].'"' : ''?>><?= $content['title'] ?></h2>
                            <p><?= showBBcodes($content['content']) ?></p>
                            <?= $content['button'] ? showBBcodes($content['button'], 'btn theme_btn button_hover') : ''?> 
                        </div>
                    </div>
                </div>
                <?= $this->hms_parser->show_booking_area(int_bool($content['booking']))?> 
            </section>

            <!--================Banner Area =================-->

            <?php else: ?> 

            <!--================ Breadcrumb Area =================-->
            <section class="breadcrumb_area">
                <div class="overlay bg-parallax" data-stellar-ratio="0.8" data-stellar-vertical-offset="0" data-background=""></div>
                <div class="container">
                    <div class="page-cover text-center">
                        <h2 class="page-cover-tittle">About Us</h2>
                        <ol class="breadcrumb">
                        <?php if ($this->uri->segment(1, NULL) && !$this->uri->segment(2, NULL)): ?>
                            <li class="active">
                                <?= ucwords(supr_replace($this->uri->segment(1, NULL))) ?>
                            </li> 
                        <?php elseif ($this->uri->segment(1, NULL) && $this->uri->segment(2, NULL)): ?>
                            <li>
                              <a href="<?= site_url($this->uri->segment(1, NULL)) ?>"><?= ucwords(supr_replace($this->uri->segment(1, NULL))) ?></a>
                            </li>
                            <li class="active">
                              <?= ucwords(supr_replace($this->uri->segment(2, NULL))) ?>
                            </li> 
                        <?php else: ?> 
                            <li class="active">
                                Home
                            </li>
                        <?php endif; ?> 
                        </ol>
                    </div>
                </div>

                <?= $this->hms_parser->show_booking_area(int_bool($content['booking']))?> 
            </section>
            <!--================ Breadcrumb Area =================-->  

            <?php endif; ?> 

        <?php else: ?> 

        <!--================ Page Introduction Area =================-->  
        <section class="d_flex align-items-center mt-5 pt-5">
            <div class="container mt-5">
                <div class="section_title text-center">
                    <h6><?= $content['intro'] ?></h6>
                    <h2 <?= $content['color'] ? 'class="'.$content['color'].'"' : ''?>><?= $content['title'] ?></h2>
                    <p><?= showBBcodes($content['content']) ?></p>
                    <?= $content['button'] ? showBBcodes($content['button'], 'btn theme_btn button_hover') : ''?> 
                </div> 
            </div>
            <hr class="bg-info">
        </section>
        <!--================ Page Introduction Area =================-->  

        <?php endif; ?> 

        <!--================ Accomodation Area  =================-->
        <?= $this->hms_parser->show_rooms(int_bool($content['rooms']))?> 
        <!--================ Accomodation Area  =================-->
        
        <!--================ About History Area  =================--> 
        <?php if ($infochildren): ?>
            <?php 
                $i = 0;
                $infochildren = array_reverse($infochildren);
                foreach ($infochildren AS $info): 
                $i++;
            ?>
            <section class="about_history_area <?= ($i%2) ? 'section_gap' : '' ?>">
                <div class="container">
                    <div class="row">

                        <?php if ($info['banner'] && $info['align'] == 'left'): ?>
                        <div class="col-md-6">
                            <img class="img-fluid" src="<?= $this->creative_lib->fetch_image($info['banner']); ?>" alt="<?=$info['title']?> Img">
                        </div>
                        <?php endif; ?>

                        <div class="<?= $info['banner'] ? 'col-md-6' : 'col-md-12' ?> d_flex align-items-center">
                            <div class="about_content ">
                                <h2 class="title <?=$info['color']?> title_color"><?= $info['title']?></h2>
                                <p><?= showBBcodes($info['content'])?></p>
                                <?= $info['button'] ? showBBcodes($info['button'], 'button_hover theme_btn_two') : ''?>  
                            </div>
                        </div>

                        <?php if ($info['banner'] && $info['align'] == 'right'): ?>
                        <div class="col-md-6">
                            <img class="img-fluid" src="<?= $this->creative_lib->fetch_image($info['banner']); ?>" alt="<?=$info['title']?> Img">
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </section>  
            <?php endforeach; ?>
        <?php endif; ?>
        <!--================ About History Area  =================-->  
        
        <!--================ Facilities Area  =================--> 
        <?= $this->hms_parser->show_facilities(int_bool($content['facilities']))?> 
        <!--================ Facilities Area  =================-->

        <!--================Contact Area =================-->
        <?= $this->hms_parser->show_contact_area(int_bool($content['contact']))?> 
        <!--================Contact Area =================-->

        <!--================ start footer Area  =================-->    
        <footer class="footer-area section_gap mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3  col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">About <?=HOTEL_NAME?></h6>
                            <p>The world has become so fast paced that people don’t want to stand by reading a page of information, they would much rather look at a presentation and understand the message. It has come to a point </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">Navigation Links</h6>
                            <div class="row">
                                <div class="col-4">
                                    <ul class="list_style">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">Feature</a></li>
                                        <li><a href="#">Services</a></li>
                                        <li><a href="#">Portfolio</a></li>
                                    </ul>
                                </div>
                                <div class="col-4">
                                    <ul class="list_style">
                                        <li><a href="#">Team</a></li>
                                        <li><a href="#">Pricing</a></li>
                                        <li><a href="#">Blog</a></li>
                                        <li><a href="#">Contact</a></li>
                                    </ul>
                                </div>                                      
                            </div>                          
                        </div>
                    </div>                          
<!--                     <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">Newsletter</h6>
                            <p>For business professionals caught between high OEM price and mediocre print and graphic output, </p>     
                            <div id="mc_embed_signup">
                                <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative">
                                    <div class="input-group d-flex flex-row">
                                        <input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                        <button class="btn sub-btn"><span class="lnr lnr-location"></span></button>     
                                    </div>                                  
                                    <div class="mt-10 info"></div>
                                </form>
                            </div>
                        </div>
                    </div>   -->                   
                </div>
                <div class="border_line"></div>
                <div class="row footer-bottom d-flex justify-content-between align-items-center">
                    <p class="col-lg-8 col-sm-12 footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved <?= HOTEL_NAME?> <!-- | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib --></a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    <div class="col-lg-4 col-sm-12 footer-social">
                        <a href="#"><i class="fa fa-facebook-f"></i></a>
                        <a href="#"><i class="fa fa-twitter-square"></i></a> 
                    </div>
                </div>
            </div>
        </footer>
        <!--================ End footer Area  =================-->
        
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
        <script src="<?= base_url('backend/modern/front/js/jquery-3.2.1.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/js/popper.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>  
        <script src="<?= base_url('backend/modern/front/vendors/owl-carousel/owl.carousel.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/js/jquery.ajaxchimp.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/js/mail-script.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/vendors/bootstrap-datepicker/bootstrap-datetimepicker.min.js'); ?>"> </script>
        <script src="<?= base_url('backend/modern/front/vendors/nice-select/js/jquery.nice-select.js'); ?>"> </script> 
        <script src="<?= base_url('backend/modern/front/js/stellar.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/vendors/lightbox/simpleLightbox.min.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/js/custom.js'); ?>"> </script>   
    </body>
</html>
