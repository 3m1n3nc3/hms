<?php $this->load->view($this->h_theme.'/header_plain', ['title' => $title])?>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice p-5 m-2">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h2 class="page-header">
            <img src="<?= $this->creative_lib->fetch_image(my_config('site_logo'), 2); ?>" alt="<?=my_config('site_name')?> Logo" class="brand-image" style="opacity: .8">
            <?=my_config('site_name')?>
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
            <?php if ($expenses): ?>
            <table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%">
              <thead>
                <tr>
                  <th> <?= lang('subject'); ?> </th>
                  <th> <?= lang('date'); ?> </th>
                  <th> <?= lang('amount'); ?> </th>
                  <th> <?= lang('remark'); ?> </th> 
                </tr>
              </thead>
              <tbody>
                <?php foreach ($expenses as $expense): ?>
                <tr> 
                  <td> <?=$expense['subject'];?> </td>
                  <td> <?=$expense['date'];?> </td>
                  <td> <?=$expense['amount'];?> </td> 
                  <td> <?=$expense['remark'];?> </td> 
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <?php else: ?>
            <?php alert_notice('No sales records available', 'info', TRUE, FALSE) ?>
            <?php endif;?>
          </div>
          <!-- /.col -->
                        
          <?php if ($expenses): ?>
          <div class="card-footer">
              <span class="mr-5">
                  <strong class="p-0"> 
                      <?=lang('total')?>: 
                  </strong> 
                  <?=$this->cr_symbol.number_format($expense['total'], 2);?>
              </span>
              <span class="mr-5">
                  <strong class="p-0"> 
                      <?=lang('total_entries')?>: 
                  </strong> 
                  <?=$expense['entries']?>
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
