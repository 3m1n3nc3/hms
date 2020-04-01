<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('backend/modern/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('backend/modern/dist/css/adminlte.min.css'); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice p-5 m-2">
        <!-- title row -->
        <div class="row">
          <div class="col-12">
            <h2 class="page-header">
            <i class="fas fa-globe"></i> <?= HOTEL_NAME; ?>.
            <small class="float-right">Date: <?= date('d/m/Y'); ?></small>
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
                  <th> Subject </th>
                  <th> Date </th>
                  <th> Amount </th>
                  <th> Remark </th> 
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
