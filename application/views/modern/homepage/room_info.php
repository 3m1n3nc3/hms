
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
    
        <script type="text/javascript">
          siteUrl = "<?=site_url()?>";
          site_currency = "$";
        </script>

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

            <!--================ Breadcrumb Area =================-->
            <section class="breadcrumb_area">
                <div class="overlay bg-parallax" data-stellar-ratio="0.8" data-stellar-vertical-offset="0" data-background=""></div>
                <div class="container">
                    <div class="page-cover text-center">
                        <h2 class="page-cover-tittle"><?= $room->room_type?></h2>
                        <ol class="breadcrumb">
                        <?php if ($this->uri->segment(1, NULL) && !$this->uri->segment(2, NULL)): ?>
                            <li class="active">
                                <?= ucwords(supr_replace($this->uri->segment(1, NULL))) ?>
                            </li> 
                        <?php elseif ($this->uri->segment(1, NULL) && $this->uri->segment(2, NULL)): ?>
                            <li>
                                <a href="<?= site_url($this->uri->segment(1, NULL) !== 'page' ? $this->uri->segment(1, NULL) : '') ?>">
                                    <?= ucwords(supr_replace($this->uri->segment(1, NULL) !== 'page' ? $this->uri->segment(1, NULL) : 'Home')) ?> 
                                </a>
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

            </section>
            <!--================ Breadcrumb Area =================-->   

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

        <!--================ Bookings Area  =================--> 
        <?php if (isset($book_rooms)): ?> 
        <div class="container-fluid p-5 bg-light">
            <div class="row">
                <!-- /.col-md-4 Important Shortcuts -->
                <div class="col-lg-12">
                    
                    <?= form_open('page/rooms/book/' . $room->room_type)?>
                    <input type="hidden" id="reserve_room" name="reserve_room" value="1">
                    <input type="hidden" id="email" name="email" value="<?= set_value('email')?>">
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="customer_TCno"><?=lang('customer_id_code')?></label>
                                <input type="text" id="customer_TCno" name="customer_TCno" class="form-control form-control-sm" value="<?= set_value('customer_TCno') ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <!-- select -->
                            <div class="form-group">
                                <label for="room_type"><?=lang('room_type')?></label>
                                <input type="text" id="room_type" name="room_type" class="form-control form-control-sm" value="<?= set_value('room_type') ?>" required readonly>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <!-- text input -->
                                <div class="form-group col-6">
                                    <label for="adults"><?=lang('adults')?></label>
                                    <input type="number" min="1" id="adults" name="adults" class="form-control form-control-sm" value="<?= set_value('adults') ?>" required readonly>
                                </div>
                                <!-- text input -->
                                <div class="form-group col-6">
                                    <label for="children"><?=lang('children')?></label>
                                    <input type="number" min="1" id="children" name="children" class="form-control form-control-sm" value="<?= set_value('children') ?>" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <!-- text input -->
                                <div class="form-group col-6">
                                    <label for="checkin_date"><?=lang('checkin')?> <?=lang('date')?></label>
                                    <input type="text" id="checkin_date" name="checkin_date" class="form-control form-control-sm" value="<?= set_value('checkin_date') ?>" required readonly>
                                </div>
                                <!-- text input -->
                                <div class="form-group col-6">
                                    <label for="checkout_date"><?=lang('checkout')?> <?=lang('date')?></label>
                                    <input type="text" id="checkout_date" name="checkout_date" class="form-control form-control-sm" value="<?= set_value('checkout_date') ?>" required readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">
                            <i class="fa fa-bed mx-2 text-gray"></i>
                            <?=lang('available_rooms')?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if ($book_rooms): ?>
                            <?php
                                $rooms = $book_rooms;
                                $size = count($rooms);
                                $cols = ceil(sqrt($size));
                                $rows = ceil($size/$cols);
                            ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th colspan="<?=$cols?>"><?=lang('select_a_room')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($t=0, $i=0; $t<$rows; ++$t): ?>
                                    <tr>
                                        <?php for($j=0; $j<$cols && $i<$size; ++$i, ++$j): ?>
                                        <td class="td-actions">
                                            <button name="room_id" value="<?=$rooms[$i]->room_id?>" onclick="return confirm('Reserve this room?')" class="btn btn-lg py-4 m-2 font-weight-bold btn-success shadow">
                                                <?=$rooms[$i]->room_type?>
                                                <br>
                                                Room <?=$rooms[$i]->room_id?>
                                                <i class="btn-icon-only fa fa-calendar-check"> </i>
                                                <br>
                                                <?='At $' . $rooms[$i]->room_price;?>
                                            </button>
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                            <?php alert_notice(lang('no_available_room_message'), 'info', TRUE, 'FLAT') ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?= form_close()?>
                </div>
                <!-- /.col-md-12 -->
            </div>
        </div>

        <?php elseif ($this->input->post('by_booking_area')): ?> 

        <div class="container-fluid p-5 mb-5 bg-light">
            <div class="row">
                <!-- /.col-md-4 Important Shortcuts -->
                <div class="col-lg-12">
                
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">
                            <i class="fa fa-bed mx-2 text-gray"></i>
                            <?=lang('available_rooms')?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php alert_notice(sprintf(lang('room_not_available'), $room->room_type), 'info', TRUE, FALSE)?>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <?php endif; ?> 
        <!--================ Bookings Area  =================--> 
        

        <!--================ Procedural Area  =================--> 
        <?= $reserve_room ?? '';?>
        <!--================ Procedural Area  =================--> 


        <!--================ About History Area  =================--> 
        <?php if ($room): ?> 
            <section class="about_history_area section_gap">
                <div class="container">
                    <div class="row">

                        <?php if ($room->image && $content['align'] == 'left'): ?>
                        <div class="col-md-6">
                            <img class="img-fluid" src="<?= $this->creative_lib->fetch_image($room->image); ?>" alt="<?=$room->room_type?> Img">
                        </div>
                        <?php endif; ?>

                        <div class="<?= $room->image ? 'col-md-6' : 'col-md-12' ?> d_flex align-items-center">
                            <div class="about_content ">
                                <h2 class="title title_color"><?= $room->room_type?></h2>
                                <p><?= showBBcodes($room->room_details)?></p>
                                <div class="container d-flex flex-row m-1"> 

                                    <?php if ($room->wifi): ?>
                                    <i class="fa fa-wifi mx-2" data-toggle="tooltip" title="<?= lang('free_wifi') ?>"></i>
                                    <?php endif; ?>

                                    <?php if ($room->pool): ?>
                                    <i class="fa fa-swimmer mx-2" data-toggle="tooltip" title="<?= lang('free_swimming') ?>"></i>
                                    <?php endif; ?>

                                    <?php if ($room->room_service): ?>
                                    <i class="fa fa-handshake mx-2" data-toggle="tooltip" title="<?= lang('room_service') ?>"></i>
                                    <?php endif; ?>

                                </div>
                                <div class="container d-flex flex-column m-1"> 
                                    <span><?= $room->max_adults . ' ' . ($room->max_adults > 1 ? plural(lang('adult')) : lang('adult'))?></span>
                                    <span><?= $room->max_kids . ' ' . ($room->max_kids > 1 ? lang('children') : lang('child'))?></span> 
                                </div>

                            </div>
                        </div>

                        <?php if ($room->image && $content['align'] == 'right'): ?>
                        <div class="col-md-6">
                            <img class="img-fluid" src="<?= $this->creative_lib->fetch_image($room->image); ?>" alt="<?=$room->room_type?> Img">
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </section>   
        <?php endif; ?> 

        <?= $this->hms_parser->show_booking_area(int_bool(1), $room->room_type ?? '')?> 
        
        <!--================ Accomodation Area  =================-->
        <?= $this->hms_parser->show_rooms(int_bool($content['rooms']))?> 
        <!--================ Accomodation Area  =================-->



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
                        <a href="#"><i class="fas fa-facebook-f"></i></a>
                        <a href="#"><i class="fas fa-twitter"></i></a> 
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
        <script src="<?= base_url('backend/modern/front/vendors/nice-select/js/jquery.nice-select.js?p=p'); ?>"> </script> 
        <script src="<?= base_url('backend/modern/front/js/stellar.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/vendors/lightbox/simpleLightbox.min.js'); ?>"> </script>  
        <script src="<?= base_url('backend/modern/front/js/custom.js'); ?>"> </script>   

        <script src="<?= base_url('backend/js/hhms.js?time='.strtotime('NOW')); ?>"></script>

        <!-- Tooltips and toggle Initialization -->
        <script type="text/javascript"> 
          $(function () {
            $('[data-toggle="tooltip"]').tooltip()
          });
           
          $(function () {
            $('[data-toggle="popover"]').popover()
          })
        </script>
    </body>
</html>
