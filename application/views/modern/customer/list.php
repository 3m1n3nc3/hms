    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 Important Shortcuts -->
          <div class="col-lg-12">
            <a href="<?= site_url('customer/add/customer')?>" class="btn btn-success text-white my-2">
              <i class="fas fa-plus"></i> Add Customer
            </a>
            <?= $this->session->flashdata('message') ?? '' ?>
            <div class="card">
              <div class="card-header">
                <strong class="m-0 p-0">
                  <i class="fa fa-users mx-2 text-gray"></i>
                  View Customers
                </strong>
                <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                  <?= $pagination ?>
                </div>
              </div>
              <div class="card-body p-1">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th> Name </th>
                      <th> Phone Number </th>
                      <th> Email Address</th>
                      <th> Identity Code </th>
                      <th> Debt </th>
                      <th class="td-actions"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($customers): ?>
                    <?php foreach ($customers as $customer): ?>
                    <?php $stats = $this->accounting_model->statistics(['customer' => $customer->customer_id]); ?>
                    <tr>
                      <td>
                        <a href="<?= $customer->customer_id !== '0' ? site_url('customer/data/'.$customer->customer_TCno) : 'javascript:void(0)' ?>">
                          <?=$customer->customer_firstname . ' ' . $customer->customer_lastname;?>
                        </a>
                      </td>
                      <td> <?=$customer->customer_telephone;?> </td>
                      <td> <?=$customer->customer_email;?> </td>
                      <td> <?=$customer->customer_TCno;?> </td>
                      <td> <?=$this->cr_symbol.number_format($stats['debt'], 2)?> </td>
                      <td class="td-actions">
                        <?php if ($customer->customer_id !== '0'): ?>
                        <a href="<?= site_url('customer/reserve/'.$customer->customer_TCno) ?>" class="btn btn-sm btn-success" data-toggle="tooltip" title="Reserve">
                          <i class="btn-icon-only fa fa-calendar-check text-white"></i>
                        </a>
                        <a href="<?= site_url('customer/add/'.$customer->customer_id.'/update') ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                          <i class="btn-icon-only fa fa-edit text-white"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="return confirmDelete('<?= site_url('customer/delete/'.$customer->customer_id) ?>', 1)" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                          <i class="btn-icon-only fa fa-trash text-white"></i>
                        </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center"><?php alert_notice('No rooms available', 'info', TRUE, FALSE) ?></td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
