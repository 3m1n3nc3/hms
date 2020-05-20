        <?php
            $i_query    = array('parent' => $content['safelink']); 
            $infochildren = $this->content_model->get($i_query); 
        ?>

        <?php if ($content['banner']): ?> 

            <!--================ Breadcrumb Area =================-->
            <section class="breadcrumb_area">
                <div class="overlay bg-parallax" data-stellar-ratio="0.8" data-stellar-vertical-offset="0" data-background=""></div>
                <div class="container">
                    <div class="page-cover text-center">
                        <h2 class="page-cover-tittle"><?= $room->room_type??''?></h2>
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
                    <p> <?= showBBcodes(decode_html($content['content'])) ?></p>
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
                    
                    <?= form_open('page/rooms/book/' . $room->id)?>
                    <input type="hidden" id="reserve_room" name="reserve_room" value="1">
                    <input type='hidden' name="room_type_id" value="<?=$room_type_id?>">
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
                                            <button name="room_id" type="button" value="<?=$rooms[$i]->room_id?>" onclick="return re(this)" class="btn btn-lg py-4 m-2 font-weight-bold btn-success shadow">
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
        <?= $this->hms_parser->show_rooms(int_bool($content['rooms']), $page)?> 
        <!--================ Accomodation Area  =================-->
 
        <script>
            function re(event) {
                // return $(event).form.submit();

                var room_id     = $(event).val();
                var form        = $(event.form);
                var from        = form.find('input[name="from"]').val();
                var destination = form.find('input[name="destination"]').val();

                $.post(site_url('ajax/connect/checkroom'), {room_id:room_id}, function(data) {
                    if (data.available==false) {
                        bootbox.dialog({
                            title: 'Reservation Error',
                            message: data.message,
                            size: 'large',
                            onEscape: true,
                            backdrop: true 
                        });
                    } else {
                        $('<input />').attr('type', 'hidden')
                            .attr('name', "room_id")
                            .attr('value', room_id)
                            .appendTo($(event.form));

                        if (typeof from == 'undefined' || typeof destination == 'undefined') {
                            fromToDestination(event.form);
                        } else {
                            bootbox.confirm('Reserve this room?', function(e) {
                                if (e == true) {
                                    return $(event.form).submit();
                                }
                            });
                        }
                    }
                });
                return false;
            }

            window.onload = function () {
                var loader = 
                '<div class="text-center preloader">'+
                    '<div class="spinner-light text-info spinner-grow" role="status">'+
                        '<span class="sr-only">Loading...</span>'+
                   '</div>'+
                '</div>';  
            }
        </script>
