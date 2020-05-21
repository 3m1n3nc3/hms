        <?php
            $showing_facilities = $info['facilities']??$content['facilities'];
            $i_query    = array('safelink' => 'footer'); 
            $footer     = $this->content_model->get($i_query); 
            $navigation = $this->content_model->get(['parent' => 'non', 'in' => 'footer', 'order_field' => ['name' => 'safelink', 'id' => 'homepage']]);

            $left_links = $right_links = [];
            $i     = 0; 
            foreach($navigation AS $link) 
            {
                $i++;
                $ltitle = ($link['safelink'] == 'homepage' ? lang('home') : $link['title']);
                $links = '
                <li>
                    <a href="'.site_url('page/'.$link['safelink']).'">'.$ltitle.'</a>
                </li>';
                if ($i%2 === 1)
                {
                    $left_links[] .= $links;
                }
                else
                {
                    $right_links[] .= $links;
                }
            }
            $show_links_l = implode(' ', $left_links);
            $show_links_r = implode(' ', $right_links);
        ?>

        <!--================ start footer Area  =================-->    
        <footer class="footer-area section_gap<?=(!$showing_facilities ? ' mt-5 py-3' : '')?>">
            <div class="container">
                <div class="row">
                    <?php if ($footer): ?>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-footer-widget">
                                <h6 class="footer_title"><?= $footer['title']?></h6>
                                <p><?= showBBcodes(decode_html($footer['content']))?></p>
                            </div>
                        </div>
                    <?php endif; ?> 
                    <?php if ($show_links_l || $show_links_r): ?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">Navigation Links</h6>
                            <div class="row">
                                <div class="col-4">
                                    <ul class="list_style">
                                        <?=$show_links_l?>
                                    </ul> 
                                </div>
                                <div class="col-4">
                                    <ul class="list_style">
                                        <?=$show_links_r?>
                                    </ul>
                                </div>                                      
                            </div>                          
                        </div>
                    </div>    
                    <?php endif; ?>  
                    <?php if ($footer): ?>                    
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget">
                            <h6 class="footer_title">
                                <?= $footer['button'] ? showBBcodes($footer['button'], $footer['color']) : ''?> 
                            </h6>
                            <p><?= $footer['intro'] ?></p>     
                 <!--            <div id="mc_embed_signup">
                                <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe_form relative">
                                    <div class="input-group d-flex flex-row">
                                        <input name="EMAIL" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address '" required="" type="email">
                                        <button class="btn sub-btn"><span class="lnr lnr-location"></span></button>     
                                    </div>                                  
                                    <div class="mt-10 info"></div>
                                </form>
                            </div> -->
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-footer-widget instafeed">
                            <img class="img-fluid" src="<?= $this->creative_lib->fetch_image($footer['banner']); ?>" alt="<?=$footer['title']?> Banner">
                        </div>
                    </div>  
                    <?php endif; ?>                     
                </div>
                <div class="border_line"></div>
                <div class="row footer-bottom d-flex justify-content-between align-items-center">
                    <p class="col-lg-8 col-sm-12 footer-text m-0">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<?=date('Y')?> All rights reserved. <?= my_config('site_name')?>  
                        <?= my_config('show_link_back') ? ' | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib </a>' : ''?>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                    <div class="col-lg-4 col-sm-12 footer-social">
                        <a href="<?=social_link(my_config('contact_facebook'), 'facebook');?>"><i class="socicon-facebook"></i></a>
                        <a href="<?=social_link(my_config('contact_twitter'), 'twitter');?>"><i class="socicon-twitter"></i></a> 
                    </div>
                </div>
            </div>
        </footer>
        <!--================ End footer Area  =================--> 
        
         
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS --> 
        <script src="<?= base_url('backend/modern/front/js/jquery-3.2.1.min.js'); ?>"> </script>
        <!-- jQuery UI -->
        <script src="<?= base_url('backend/modern/plugins/jquery-ui/jquery-ui.min.js'); ?>"></script>
        <!-- Croppie -->
        <script src="<?= base_url('backend/js/plugins/croppie.js'); ?>"></script>
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
        <script src="<?= base_url('backend/modern/plugins/bootbox/bootbox.all.js'); ?>"></script>
        <!-- DateTimePicker -->
        <script src="<?= base_url('backend/modern/plugins/datetimepicker/build/jquery.datetimepicker.full.js'); ?>"></script> 

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
