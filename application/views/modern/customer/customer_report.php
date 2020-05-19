  <?php $this->load->view($this->h_theme.'/header_plain', ['title' => $title])?>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice p-5 m-2">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h2 class="page-header">
          <img src="<?= $this->creative_lib->fetch_image(my_config('site_logo'), 2); ?>" alt="<?=my_config('site_name')?> Logo" class="brand-image" style="opacity: .8"></i> <?=my_config('site_name')?>.
          <small class="float-right"><?= lang('date'); ?>: <?= date('d/m/Y'); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <address>
            <strong><?=supr_replace($page, 1)?></strong><br>
            From<br>
            <strong><?= date('d/m/Y', strtotime($from ?? $date_from)); ?></strong>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
            <strong><?=supr_replace($page, 1)?></strong><br>
            To<br>
            <strong><?= date('d/m/Y', strtotime($to ?? $date_to));?></strong>
          </address>
        </div>
      </div>
                
      <?= form_open('customer/report/'.$customer['customer_id'].'/', array('method' => 'get', 'class' => 'no-print'))?>
        <div class="row">
          <div class="col-7">
            <div class="row">
              <!-- text input --> 
              <div class="form-group col-4 row">
                <label for="checkin_date" class="col-sm-4 col-form-label"><?=lang('from')?></label>
                <input type="date" id="from" name="from" class="form-control form-control-sm col-sm-8" value="<?= $this->input->get('from') ?>" required>
              </div>
              <!-- text input -->
              <div class="form-group col-4 row">
                <label for="checkout_date" class="col-sm-4 col-form-label"><?=lang('to')?></label>
                <input type="date" id="to" name="to" class="form-control form-control-sm col-sm-8" value="<?= $this->input->get('to') ?>">
              </div>
              <!-- text input -->
              <div class="form-group col-2">
                <button class="button btn btn-info btn-sm"><?=lang('filter')?></button>
              </div>
            </div>
          </div>
        </div>
      <?= form_close()?>
      <!-- /.row -->

      <div class="d-flex justify-content-center">
        <div class="mx-5">
          <a href="javascript:void(0)">
          <img class="profile-user-img img-fluid rounded img-thumbnail" src="<?= $this->creative_lib->fetch_image($customer['image'], 3); ?>" alt="User profile picture">
          </a>
        </div>   

        <?php if ($customer['customer_passport_no']): ?>
          <div class="mx-5">
            <a href="javascript:void(0)">
            <img class="profile-user-img img-fluid rounded img-thumbnail" src="<?= $this->creative_lib->fetch_image($customer['passport'], 3); ?>" alt="User Passport">
            </a>
          </div>   
        <?php endif ?>
      </div>

      <hr>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-md-3 invoice-col">
          <address>
            Customer Name<br>
            <strong><?=$customer['name']?></strong> 
          </address>
        </div> 
        <div class="col-md-3 invoice-col">
          <address>
            Customer Address<br>
            <strong><?=$customer['address']?></strong> 
          </address>
        </div> 
        <div class="col-md-2 invoice-col">
          <address>
            Country<br>
            <strong><?=$customer['customer_country']?></strong> 
          </address>
        </div> 
        <div class="col-md-2 invoice-col">
          <address>
            State<br>
            <strong><?=$customer['customer_state']?></strong> 
          </address>
        </div> 
        <div class="col-md-2 invoice-col">
          <address>
            Country<br>
            <strong><?=$customer['customer_city']?></strong> 
          </address>
        </div> 
      </div>
      <!-- /.row -->
      <!-- info row -->
      <div class="row invoice-info">
        <?php if ($customer['customer_nationality']): ?>
          <div class="border col-md-5 row mr-5 pt-3">
            <div class="col-md-6 invoice-col">
              <address>
                Nationality<br>
                <strong><?=$customer['customer_nationality']?></strong> 
              </address>
            </div> 
            <div class="col-md-6 invoice-col">
              <address>
                Passport Number<br>
                <strong><?=$customer['customer_passport_no']?></strong> 
              </address>
            </div>  
          </div>
        <?php endif ?>

        <div class="col-md-3 invoice-col">
          <address>
            Phone Number<br>
            <strong><?=$customer['customer_telephone']?></strong> 
          </address>
        </div> 
        <div class="col-md-3 invoice-col">
          <address>
            Email Address<br>
            <strong><?=$customer['customer_email']?></strong> 
          </address>
        </div> 

      </div>
      <!-- /.row -->
      <hr>

      <!-- Table row -->
      <div class="row mt-5">
        <div class="col-12 table-responsive">
          <?php if ($reservations): ?>
          <h2><?=lang('reservations')?></h2>
          <table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%">
            <thead>
              <tr>
                <th> Room Number </th>
                <th> Room Type </th>
                <th> Checkin Date </th>
                <th> Checkout Date </th>
                <th> Reservation Date </th>
                <th> Adults </th>
                <th> Children </th>
                <th> Checkin From </th>
                <th> Checkout Destination </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $reservation): 
                $reservation = o2Array($reservation)?> 
              <tr>
                <td> <?=$reservation['room_id'];?> </td> 
                <td> <?=$reservation['room_type'];?> </td> 
                <td> <?=date('d M Y h:i A', strtotime($reservation['checkin_date']));?> </td>
                <td> <?=date('d M Y h:i A', strtotime($reservation['checkout_date']));?> </td>
                <td> <?=date('d M Y h:i A', strtotime($reservation['reservation_date']));?> </td>
                <td> <?=$reservation['adults'];?> </td> 
                <td> <?=$reservation['children'];?> </td> 
                <td> <?=$reservation['coming_from'];?> </td> 
                <td> <?=$reservation['destination'];?> </td> 
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          <?php alert_notice('No sales records available', 'info', TRUE, FALSE) ?>
          <?php endif;?>


          <?php if ($payments): ?>
          <h2><?=lang('payments')?></h2>
          <table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%">
            <thead>
              <tr> 
                <th> <?=lang('amount')?> </th>
                <th> <?=lang('reference')?> </th>
                <th> <?=lang('description')?> </th>
                <th> <?=lang('date')?> </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payments as $payment): ?> 
              <tr> 
                <td> <?=$this->cr_symbol.number_format($payment['amount'], 2);?> </td>
                <td> <?=$payment['reference'];?> </td>
                <td> <?=$payment['description'];?> </td>
                <td> <?=date('d M Y h:i A', strtotime($payment['date']));?> </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table> 
          <?php endif;?>


          <?php if ($purchases): ?>
          <h2>Purchases</h2>
          <table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%">
            <thead>
              <tr>
                <th> Order Items </th> 
                <th> Order Amount </th> 
                <th> Paid </th>
                <th> Bal. </th>
                <th> Bought At </th>
                <th> Sold By </th>
                <th> Order Time </th> 
              </tr>
            </thead>
            <tbody>
              <?php foreach ($purchases as $item): ?> 
              <tr>   
                <td> <?=$this->hms_data->explode_sales_items($item['order_items'], [$item['order_quantity'], $item['order_items']], ', ');?> </td>
                <td> <?=$this->cr_symbol.number_format($item['order_price'], 2);?> </td>
                <td> <?=$this->cr_symbol.number_format($item['paid'], 2);?> </td>
                <td> <?=$this->cr_symbol.number_format($item['order_price']-$item['paid'], 2);?> </td>
                <td> <?=$item['service_name'];?> </td>
                <td> <?=$this->account_data->fetch($item['employee_id'] ?? '')['name'];?> </td>
                <td> <?=date('d M Y h:i A', strtotime($item['ordered_datetime']));?> </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table> 
          <?php endif; ?>
        </div>
        <!-- /.col -->
        
        <?php if ($statistics): ?>
        <div class="card-footer row">
          <span class="mr-5">
            <strong class="p-0">
            <?=lang('reservations')?>:
            </strong>
            <?=$this->cr_symbol.number_format($statistics['room_sales'], 2)?>
          </span>
          <span class="mr-5">
            <strong class="p-0">
            Payments and Charges:
            </strong>
            <?=$this->cr_symbol.number_format($statistics['payments'], 2)?>
          </span>
          <span class="mr-5">
            <strong class="p-0">
            Debts:
            </strong>
            <?=$this->cr_symbol.number_format($statistics['debt'], 2)?>
          </span>
          <span class="mr-5">
            <strong class="p-0">
            Total Expenses:
            </strong> 
            <?=$this->cr_symbol.number_format($statistics['total_expenses'], 2)?>
          </span>
        </div>
        <?php endif;?>

        <!-- this row will not appear when printing -->
        <hr>
        <div class="no-print mb-3 mt-3">
          <?= form_open('customer/report/'.$customer['customer_id'].'/'.(($from && $to) ? '?from='.$from.'&to='.$to : ($from ?'?from='.$from : ($to?'?to='.$to:''))))?>
            <input type="hidden" name="print" value="1">
            <button type="submit" class="btn btn-default">
              <i class="fas fa-print"></i> Print
            </button>
          <?= form_close()?> 
        </div>
        
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- ./wrapper -->
  <?php if ($this->input->post('print')): ?>
    <script type="text/javascript">
      window.addEventListener("load", window.print());
    </script>
  <?php endif;?>
  <!-- jQuery -->
  <script src="<?= base_url('backend/modern/plugins/jquery/jquery.min.js'); ?>"></script> 
  </body>
</html>
