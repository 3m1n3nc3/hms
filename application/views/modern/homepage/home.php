        <?php
            $i_query    = array('parent' => $content['safelink']); 
            $infochildren = $this->content_model->get($i_query); 
        ?>

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
                foreach ($infochildren AS $info): 
                $i++;
            ?>
            <section class="about_history_area <?= ($i%2 === 0) ? 'section_gap' : '' ?>">
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
