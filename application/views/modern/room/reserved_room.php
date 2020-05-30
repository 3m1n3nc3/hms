<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= $this->session->flashdata('message') ?? '' ?>
        <?php 
            $active_reservation = 
                $reservation['checkin_date'] <= date('Y-m-d H:i:s', strtotime('NOW')) && 
                $reservation['checkout_date'] >= date('Y-m-d H:i:s', strtotime('NOW')) ? TRUE : FALSE;

            $expired_reservation = $reservation['checkout_date'] < date('Y-m-d H:i:s', strtotime('NOW')) && 
                $reservation['status'] ? TRUE : FALSE;

            $allow_checkout_os = (($overstay['overstay_days']??0)<=0 || my_config('debt_tolerance')==0);
            $allow_checkout_dt = (!($statistics['debt']??null) || my_config('debt_tolerance')==0);
            $overstay_checkout = ($allow_checkout_os || my_config('debt_tolerance') == 2);
            $debt_checkout     = ($allow_checkout_dt || my_config('debt_tolerance') == 1);
            $allow_checkout    = ($overstay_checkout || $debt_checkout);
            if (my_config('debt_tolerance') == 3 && (!$allow_checkout_os || !$allow_checkout_dt)) {
                $allow_checkout  = FALSE;
            }
        ?>
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card <?= $active_reservation && $reservation['status'] ? 'card-success' : 'card-secondary' ?> card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <a href="javascript:void(0)" onclick="modalImageViewer('.profile-user-img')">
                                <img class="profile-user-img img-fluid img-circle <?= $active_reservation && $reservation['status'] ? 'border-success' : '' ?>" src="<?= $this->creative_lib->fetch_image($reservation['image'], 3); ?>" alt="User profile picture"></a>
                        </div>
                        <h3 class="profile-username text-center">
                            <?=$customer_link?>
                        </h3>
                        <p class="text-muted text-center"><?= lang('customer') ?></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><?= lang('room_number') ?></b>
                                <a class="float-right"><?= $reservation['room_id'] ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('room_type') ?></b>
                                <a class="float-right"><?= $reservation['room_type'] ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('checkin') ?> <?= lang('date') ?></b>
                                <a class="float-right"><?= $reservation ? date('D d M Y', strtotime($reservation['checkin_date'])) : 'N/A'?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('checkout') ?> <?= lang('date') ?></b>
                                <a class="float-right"><?= $reservation ? date('D d M Y', strtotime($reservation['checkout_date'])) : 'N/A'?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('checkin_from') ?></b>
                                <a class="float-right"><?= $reservation['coming_from'] ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('checkout_to') ?></b>
                                <a class="float-right"><?= $reservation['destination'] ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b><?= lang('reservation') ?> <?= lang('date') ?></b>
                                <a class="float-right"><?= $reservation ? date('D d M Y', strtotime($reservation['reservation_date'])) : 'N/A'?></a>
                            </li>
                        </ul>
                         
                        <?=$print_invoice?>

                        <?php if (has_privilege('customers') && $allow_checkout && ($active_reservation || $reservation['status'])):?>
                            <?=form_open('reservation')?>
                                <input type="hidden" name="customer_TCno" value="<?=$reservation['customer_TCno']?>">
                                <input type="hidden" name="change_booking" value="<?=$reservation['reservation_id']?>">
                                <button class="btn btn-primary btn-block mt-1"><b><?= lang('change_reservation') ?></b></button>
                            <?=form_close()?>
                        <?php endif;?>
                        <?php if (has_privilege('customers') && ($active_reservation || $reservation['status'])): ?>
                            <a href="<?=$allow_checkout ? site_url('room/checkout/'.$reservation['reservation_id']) : 'javascript:void(0)'?>" class="btn btn-<?=$allow_checkout ? 'danger text-white' : 'light text-danger checkout_blocked'?> border btn-block mt-1"><b><?=$allow_checkout ? 'Checkout' : 'Checkout Blocked'?></b></a>
                            <?php if (!$allow_checkout): ?>
                                <button class="btn btn-info btn-block mt-1" id="overdue_settlement" data-days="<?=($overstay['overstay_days']??0)?>" data-id="<?=($overstay['reservation_id']??'')?>" data-room_price="<?=($overstay['room_price']??0)?>" data-amount-curr="<?=$this->cr_symbol.number_format(($overstay['overdue_cost']??0), 2)?>"><b>Overdue Settlement</b></button>
                            <?php endif;?>
                        <?php endif;?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
    
                <div id="error_boxes">
                    <?php if (has_privilege('customers')):?>
                        <?php if (!empty($overstay) && $overstay['overstay_days']>0):?>
                            <?= alert_notice(sprintf(lang('customer_overstay'), $overstay['overstay_days'], $this->cr_symbol.number_format($overstay['overdue_cost'], 2), site_url("customer/data/{$reservation['customer_id']}")), 'warning')?>
                        <?php endif;?>
                        <?php if ($statistics['debt']??null):?>
                            <?= alert_notice(sprintf(lang('customer_has_debt'), $this->cr_symbol.number_format($statistics['debt'], 2), site_url("customer/data/{$reservation['customer_id']}/purchases")), 'danger')?>
                        <?php endif;?> 
                    <?php elseif ($this->cuid): ?> 
                        <?php if (!empty($overstay) && $overstay['overstay_days']>0):?>
                            <?= alert_notice('You have overstayed your reservation by '. $overstay['overstay_days'].'  days and have incurred debts of up to '.$this->cr_symbol.number_format($overstay['overdue_cost'], 2).', you can visit the reception to clear these debts.', 'warning')?>
                        <?php endif;?>
                        <?php if ($statistics['debt']??null):?>
                            <?= alert_notice('You have unpaid debts of up to '.$this->cr_symbol.number_format($statistics['debt'], 2).', you can visit the reception to clear these debts.', 'danger')?>
                        <?php endif;?> 
                    <?php endif;?> 
                </div> 

                <?php if (isset($this->cuid) && $this->cuid == $customer['customer_id'] && $customer['customer_nationality'] && $customer['customer_nationality'] !== config_item('site_country') && !$customer['passport']):?>
                    <?php alert_notice('You are required to upload the data page of your passport!', 'danger', TRUE, FALSE) ?>
                    <div class="card mb-5">
                        <div class="card-header"> 
                            <h5 class="card-title"><?= lang('customer_passport') ?></h5>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center mb-3">
                                <a href="javascript:void(0)" onclick="modalImageViewer('.passport')">
                                    <img class="profile-user-img img-fluid border-gray passport" src="<?= $this->creative_lib->fetch_image($customer['passport'], 1); ?>" alt="<?= lang('customer_passport') ?>">
                                </a>
                            </div> 
                            
                            <div id="upload_resize_passport" data-set_type="3" data-endpoint="passport" data-endpoint_id="<?= $customer['customer_id']; ?>" class="d-none"></div>
                            <button type="button" id="resize_image_button" class="btn btn-success btn-block text-white upload_resize_image" data-type="cover" data-endpoint="passport" data-endpoint_id="<?= $customer['customer_id'];?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang($customer['passport'] ? 'change_image' : 'upload_passport_image')?></b></button> 
                        </div>
                    </div>
                <?php endif;?>
                
                <div class="card">
                    <div class="card-header p-2">
                        <h5 class="m-0">
                            <i class="fa fa-calendar-check mx-2 text-gray"></i>
                            <?=isset($space) && $space == 'person' ? lang('your_reservations') : lang('all_reservations_this_room')?>
                        </h5>
                    </div><!-- /.card-header -->
                    <div class="card-body px-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> <?= lang('room_number') ?> </th>
                                    <th> <?= lang('room_type') ?> </th>
                                    <th> <?= lang('checkin') ?> <?= lang('date') ?> </th>
                                    <th> <?= lang('checkout') ?> <?= lang('date') ?> </th>
                                    <?php if (has_privilege('customers')):?>
                                    <th> <?= lang('customer') ?> </th>
                                    <th class="td-actions"> <?= lang('actions') ?> </th>
                                    <?php endif;?>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if ($rooms): ?>
                                <?php foreach ($rooms as $rm): ?>
                                <tr>
                                    <td> <?=$rm->room_id ?> </td>
                                    <td> <?=$rm->room_type ?> </td>
                                    <td> <?= date('D d M Y', strtotime($rm->checkin_date)) ?> </td>
                                    <td> <?= date('D d M Y', strtotime($rm->checkout_date)) ?> </td>
                                    <?php if (has_privilege('customers')):?>
                                    <td>
                                        <a href="<?=site_url('customer/data/'.$rm->customer_id)?>">
                                            <?=$rm->customer_firstname ?> <?=$rm->customer_lastname ?>
                                        </a>
                                    </td>
                                    <td class="td-actions">
                                        <a href="<?= site_url('room/reserved_room/'.$rm->room_id.'/'.$rm->customer_id)?>" class="btn btn-sm btn-primary">
                                            <i class="btn-icon-only fa fa-calendar-check text-white"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="return confirmDelete('<?= site_url('room/delete_reservation/'.$rm->reservation_id.'/'.$rm->room_id)?>', 1)" class="btn btn-danger btn-sm">
                                            <i class="btn-icon-only fa fa-trash text-white"></i>
                                        </a>
                                    </td>
                                    <?php endif;?>
                                    <td>
                                        <?php if (!$reservation['status'] && $reservation['checkin_date'] < date('Y-m-d H:i:s', time()) && $reservation['checkout_date'] < date('Y-m-d H:i:s', time())): ?>
                                        <i class="fa fa-arrow-down text-danger"></i>
                                        <?php else: ?>
                                        <i class="fa fa-arrow-up text-success"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center"><?php alert_notice(lang('no_more_reservations_this_room'), 'info', TRUE, FALSE) ?></td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->
                </div>
                <?=$pagination?>
                <!-- /.nav-tabs-custom -->  
            </div>
            <!-- /.col -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content --> 

<script>
    window.onload = function () {
        $('.checkout_blocked').click(function(event) { 
            bootbox.dialog({ 
                title: 'Unable to process checkout!',
                message: $('#error_boxes').html(),
                size: 'large',
                onEscape: true,
                backdrop: true,
                centerVertical: true,
                buttons: {
                    view: {
                        label: 'View Details',
                        className: 'btn-info',
                        callback: function(e){
                            location.href=site_url('<?= 'customer/data/'.$reservation['customer_id'] ?>');
                            return false;
                        }
                    }
                }
            });
        });

        $('#overdue_settlement').click(function(event) { 
            var item = $(this);
            var ref  = item.data('ref');
            var link = siteUrl+'customer/update_debt/';
            var item_id = item.data('id');
            var o_days  = '<?=($overstay['overstay_days']??0) ?>';

            bootbox.dialog({ 
                title: 'Update user overstay debt of <span>'+$(this).data('amount-curr')+' for '+o_days+' days</span>',
                message: '<span id="bootbox-message"></span><label for="amount_to_pay">Amount to pay</label><select class="bootbox-select form-control" required="" id="amount_to_pay"></select>',
                size: 'large',
                onEscape: true,
                backdrop: true,
                centerVertical: true, 
                scrollable: true, 
                onShow: function(e) { 
                    var s_options = "";
                    for (var i = 0; i < o_days; i++) {
                        var sum_i  = (i+1);
                        var days   = (i >= 1 ? ' Days' : ' Day'); 
                        var amount = ($(item).data('room_price')*sum_i); 
                        s_options += '<option value="'+ amount +'" data-p_days="'+sum_i+'">'+currency_symbol+amount+' For ' + sum_i + days + '</option>';
                    }
                    $('#amount_to_pay').append(s_options);
                },
                buttons: {
                    update: {
                        label: 'Update',
                        className: 'btn-success',
                        callback: function(e){
                            $(e.target).attr('disabled',true).text('Please Wait...');
                            var selected = $('#amount_to_pay');
                            var amount   = selected.val();
                            var p_days   = $(selected[0].selectedOptions).data('p_days'); 
                            console.log(p_days)
                            $.post(link+'pay_overstay',{item_id:item_id,p_days:p_days,amount:amount}, function(data){
                                $('#bootbox-message').html(data.message);
                                $('.modal-title span, #debt_'+item_id).html(data.debt);
                                $('#paid_'+item_id).html(data.paid);
                                $('#customer_debt').html(data.total_debt);
                                $(e.target).removeAttr('disabled').text('Update');
                            })
                            return false;
                        }
                    },
                    cancel: { label: 'Cancel', className: 'btn-danger', callback: function(d){} }
                }
            })
        });
    }
</script> 
