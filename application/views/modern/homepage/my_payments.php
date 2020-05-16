<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= $this->session->flashdata('message') ?? '' ?>
        <?php $active_reservation = date('Y-m-d', strtotime($reservation['checkin_date'])) <= date('Y-m-d', strtotime('NOW')) && date('Y-m-d', strtotime($reservation['checkout_date'])) >= date('Y-m-d', strtotime('NOW')) ? 1 : 0 ?>
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card <?= $active_reservation ? 'card-success' : 'card-secondary' ?> card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle <?= $active_reservation ? 'border-success' : '' ?>" src="<?= $this->creative_lib->fetch_image($reservation['image'], 3); ?>" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">
                            <?=$reservation['customer_firstname'] . ' ' .$reservation['customer_lastname']?>
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
                                <b><?= lang('reservation') ?> <?= lang('date') ?></b>
                                <a class="float-right"><?= $reservation ? date('D d M Y', strtotime($reservation['reservation_date'])) : 'N/A'?></a>
                            </li>
                        </ul>
                        <?php if (isset($this->uid)):?>
                            <?=form_open('reservation')?>
                                <input type="hidden" name="customer_TCno" value="<?=$reservation['customer_TCno']?>">
                                <input type="hidden" name="change_booking" value="<?=$reservation['reservation_id']?>">
                                <button class="btn btn-primary btn-block"><b><?= lang('change_reservation') ?></b></button>
                            <?=form_close()?>
                        <?php endif;?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <h5 class="m-0">
                            <i class="far fa-credit-card mx-2 text-gray"></i>
                            <?=isset($space) && $space == 'person' ? lang('my_payments') : lang('all_reservations_this_room')?>
                        </h5>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> <?=lang('by')?> </th>
                                    <th> <?=lang('amount')?> </th>  
                                    <th> <?=lang('reference')?> </th>
                                    <th> <?=lang('description')?> </th>
                                    <th> <?=lang('date')?> </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($payments): ?>
                                <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td> <?=$customer['name'];?> </td>
                                    <td> <?=$this->cr_symbol.number_format($payment['amount'], 2);?> </td> 
                                    <td> <?=$payment['reference'];?> </td>
                                    <td> <?=$payment['description'];?> </td> 
                                    <td> <?=$payment['date'];?> </td>  
                                    <td class="td-actions">
                                        <a href="<?= site_url('my-payments/print/?print=true&reference='.$payment['reference'])?>" class="btn btn-sm btn-success">
                                            <i class="btn-icon-only fa fa-print text-white"></i>
                                        </a> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center"><?php alert_notice(lang('no_payment_records'), 'info', TRUE, FALSE) ?></td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.card-body -->
                </div>
                        <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
