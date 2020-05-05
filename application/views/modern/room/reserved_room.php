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
        ?>
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card <?= $active_reservation && $reservation['status'] ? 'card-success' : 'card-secondary' ?> card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle <?= $active_reservation && $reservation['status'] ? 'border-success' : '' ?>" src="<?= $this->creative_lib->fetch_image($reservation['image'], 3); ?>" alt="User profile picture">
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
                        <a href="<?=site_url($invoice_link)?>" class="btn btn-success btn-block text-white mt-1"><b>Print Invoice</b></a>
                        <?php if (isset($this->uid) && ($active_reservation || $reservation['status'])):?>
                            <?=form_open('reservation')?>
                                <input type="hidden" name="customer_TCno" value="<?=$reservation['customer_TCno']?>">
                                <input type="hidden" name="change_booking" value="<?=$reservation['reservation_id']?>">
                                <button class="btn btn-primary btn-block mt-1"><b><?= lang('change_reservation') ?></b></button>
                            <?=form_close()?>
                        <?php endif;?>
                        <?php if ($active_reservation || $reservation['status']): ?>
                            <a href="<?=site_url('room/checkout/'.$reservation['reservation_id'])?>" class="btn btn-danger btn-block text-white mt-1"><b>Checkout</b></a>
                        <?php endif;?>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-8">

                <?php if ($expired_reservation):?>
                    <?= alert_notice(sprintf(lang('customer_overstay'), dateDifference(date('Y-m-d', strtotime($reservation['checkout_date'])), date('Y-m-d', strtotime('NOW')))), 'warning')?>
                <?php endif;?>

                <div class="card">
                    <div class="card-header p-2">
                        <h5 class="m-0">
                            <i class="fa fa-calendar-check mx-2 text-gray"></i>
                            <?=isset($space) && $space == 'person' ? lang('your_reservations') : lang('all_reservations_this_room')?>
                        </h5>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> <?= lang('room_number') ?> </th>
                                    <th> <?= lang('room_type') ?> </th>
                                    <th> <?= lang('checkin') ?> <?= lang('date') ?> </th>
                                    <th> <?= lang('checkout') ?> <?= lang('date') ?> </th>
                                    <?php if (isset($this->uid)):?>
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
                                    <?php if (isset($this->uid)):?>
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
                                        <?php if ($reservation['checkin_date'] < date('Y-m-d', strtotime('NOW')) && $reservation['checkout_date'] < date('Y-m-d', strtotime('NOW'))): ?>
                                        <i class="fa fa-arrow-down text-danger"></i>
                                        <?php else: ?>
                                        <i class="fa fa-arrow-up text-success"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7"><?php alert_notice(lang('no_more_reservations_this_room'), 'info', TRUE, FALSE) ?></td>
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
