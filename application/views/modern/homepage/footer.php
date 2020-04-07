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
                    <p class="col-lg-8 col-sm-12 footer-text m-0">
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<?=date('Y')?> All rights reserved <?= HOTEL_NAME?> <!-- | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib --></a>
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
        <script src="<?= base_url('backend/modern/front/vendors/nice-select/js/jquery.nice-select.js'); ?>"> </script> 
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
