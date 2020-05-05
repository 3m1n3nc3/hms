            <div class="hotel_booking_area position">
                <div class="container">
                    <div class="hotel_booking_table">
                        <div class="col-md-3">
                            <h2><?=lang('book_your_room')?></h2>
                        </div>
                        <div class="col-md-9">
                            <div class="boking_table">
                                <?=form_open('page/rooms/book/'.$room['room_type'])?>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="book_tabel_item">
                                            <div class="form-group">
                                                <input type='hidden' name="room_type" value="<?=$room['room_type']?>">
                                                <input type='hidden' name="by_booking_area" value="1">

                                                <div class='input-group date'>
                                                    <input type='text' id="checkin_date" name="checkin_date" class="form-control" style="padding: 19px;" value="<?=set_value('checkin_date')?>" placeholder="<?=lang('arrival').' '.lang('date')?>" required autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class='input-group dat'>
                                                    <input type='text' id="checkout_date" name="checkout_date" class="form-control" style="padding: 19px;" value="<?=set_value('checkout_date')?>" placeholder="<?=lang('departure').' '.lang('date')?>" required autocomplete="off">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="book_tabel_item">
                                            <div class="input-group">
                                                <select class="wide nice-selector" name="adults" required> 
                                                    <option value="0" data-display="<?=plural(lang('adult'))?>">
                                                        <?=plural(lang('adult'))?>
                                                     </option>
                                                    <?php if (isset($room['max_adults'])):?>
                                                        <?php for ($i = 0; $room['max_adults'] > $i; $i++):?>
                                                        <?php $x = ($i+1)?>
                                                        <option value="<?=$x?>"<?=set_select('adults', $x)?>>
                                                            <?=$x?>
                                                        </option> 
                                                        <?php endfor;?>
                                                    <?php else: ?>
                                                        <?php for ($i = 0; 5 > $i; $i++):?>
                                                        <?php $x = ($i+1)?>
                                                        <option value="<?=$x?>"<?=set_select('children', $x)?>>
                                                            <?=$x?>
                                                        </option> 
                                                        <?php endfor;?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                            <div class="input-group">
                                                <select class="wide nice-selector" name="children">
                                                    <option value="0" data-display="<?=lang('children')?>">
                                                        <?=lang('children')?>
                                                    </option>
                                                    <?php if (isset($room['max_kids'])):?>
                                                        <?php for ($i = 0; $room['max_kids'] > $i; $i++):?>
                                                        <?php $x = ($i+1)?>
                                                        <option value="<?=$x?>"<?=set_select('children', $x)?>>
                                                            <?=$x?>
                                                        </option> 
                                                        <?php endfor;?>
                                                    <?php else: ?>
                                                        <?php for ($i = 0; 5 > $i; $i++):?>
                                                        <?php $x = ($i+1)?>
                                                        <option value="<?=$x?>"<?=set_select('children', $x)?>>
                                                            <?=$x?>
                                                        </option> 
                                                        <?php endfor;?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="book_tabel_item">
                                            <div class="form-group">
                                                <div class='input-group'>
                                                    <?php $email = $this->cuid ? $this->logged_customer['customer_email'] : ''; ?>
                                                    <input type='text' name="email" class="form-control" style="padding: 19px;" value="<?=set_value('email', $email)?>" placeholder="<?=lang('email').' '.lang('address')?>" required <?=$email ? 'readonly' : ''?>>
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-at" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="submit" class="book_now_btn button_hover"><?=lang('book_now')?></button>
                                        </div>
                                    </div>
                                </div>
                                <?=form_close()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
