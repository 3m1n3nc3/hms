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
              <strong><?= date('d/m/Y', strtotime($to ?? $date_to)); ?></strong>
            </address>
          </div> 
        </div>
        <!-- /.row -->
        <!-- Table row -->
        <div class="row mt-5">
          <div class="col-12 table-responsive">
            <?php if ($room_sales): ?>
            <table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%">
              <thead>
                <tr>
                  <th> <?=lang('customer')?> </th>
                  <th> <?=lang('room')?> </th>
                  <th> <?=lang('amount')?> </th>  
                  <th> <?=lang('reference')?> </th>
                  <th> <?=lang('date')?> </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($room_sales as $room_sale): ?>
                <?php 
                  $customer = $this->account_data->fetch($room_sale['customer_id'], 1);
                  $room = $this->room_model->getRoom(['id' => $room_sale['room_id']]); 
                ?>
                <tr> 
                  <td> <?=$customer['name'];?> </td>
                  <td> <?=$room['room_type'] . ' ' . lang('room') .' ' . $room_sale['room_id'];?> </td> 
                  <td> <?=$this->cr_symbol.number_format($room_sale['room_sales_price'], 2);?> </td> 
                  <td> <?=$room_sale['reservation_ref'];?> </td>
                  <td> <?=$room_sale['reservation_date'];?> </td> 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <?php else: ?>
            <?php alert_notice('No sales records available', 'info', TRUE, FALSE) ?>
            <?php endif;?>
          </div>
          <!-- /.col -->
                        
          <?php if ($room_sales): ?>
          <div class="card-footer">
              <span class="mr-5">
                  <strong class="p-0"> 
                      <?=lang('total')?>: 
                  </strong> 
                  <?=$this->cr_symbol.number_format($room_sale['total'], 2)?>
              </span>
              <span class="mr-5">
                  <strong class="p-0"> 
                      <?=lang('total_entries')?>: 
                  </strong> 
                  <?=$room_sale['entries']?>
              </span>
          </div>
          <?php endif;?>
          
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- ./wrapper -->
    <script type="text/javascript">
      window.addEventListener("load", window.print());
    </script>
    <!-- jQuery -->
    <script src="<?= base_url('backend/modern/plugins/jquery/jquery.min.js'); ?>"></script> 
  </body>
</html>
