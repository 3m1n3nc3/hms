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
              <img class="profile-user-img img-fluid img-circle <?= $active_reservation ? 'border-success' : '' ?>" src="<?= base_url('backend/modern/dist/img'); ?>/user4-128x128.jpg" alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?=$reservation['customer_firstname'] . ' ' .$reservation['customer_lastname']?></h3>
            <p class="text-muted text-center">Customer</p>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Room Number</b> 
                <a class="float-right"><?= $reservation['room_id'] ?></a>
              </li>
              <li class="list-group-item">
                <b>Room Type</b> 
                <a class="float-right"><?= $reservation['room_type'] ?></a>
              </li>
              <li class="list-group-item">
                <b>Checkin Date</b> 
                <a class="float-right"><?= date('D d M Y', strtotime($reservation['checkin_date'])) ?></a>
              </li>
              <li class="list-group-item">
                <b>Checkout Date</b> 
                <a class="float-right"><?= date('D d M Y', strtotime($reservation['checkout_date'])) ?></a>
              </li>
              <li class="list-group-item">
                <b>Reservation Date</b> 
                <a class="float-right"><?= date('D d M Y', strtotime($reservation['reservation_date'])) ?></a>
              </li>
            </ul>
            <?=form_open('reservation')?>
              <input type="hidden" name="customer_TCno" value="<?=$reservation['customer_TCno']?>">
              <input type="hidden" name="change_booking" value="<?=$reservation['reservation_id']?>">
              <button class="btn btn-primary btn-block"><b>Change Reservation</b></button>
            <?=form_close()?>
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
              <i class="fa fa-calendar-check mx-2 text-gray"></i>
              All reservations for this room
            </h5>
          </div><!-- /.card-header -->

          <div class="card-body">  
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Room Number </th>
                  <th> Room Type </th>
                  <th> Checkin Date </th>
                  <th> Checkout Date </th>
                  <th> Customer </th>
                  <th class="td-actions"> Actions </th>
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
                  <td>
                    <a href="<?=site_url('customer/data/'.$rm->customer_id)?>">
                      <?=$rm->customer_firstname ?> <?=$rm->customer_lastname ?>
                    </a>
                  </td>
                  <td class="td-actions">
                    <a href="<?= site_url('room/reserved_room/'.$rm->room_id.'/'.$rm->customer_id)?>" class="btn btn-sm btn-primary">
                      <i class="btn-icon-only fa fa-calendar-check text-white"></i>
                    </a>
                    <a href="<?= site_url('room/delete/'.$rm->room_id.'/'.$rm->room_id)?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">
                      <i class="btn-icon-only fa fa-trash text-white"></i>
                    </a>
                  </td>
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
                <td colspan="6"><?php alert_notice('No other reservations for this room', 'info', TRUE, FALSE) ?></td>
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
