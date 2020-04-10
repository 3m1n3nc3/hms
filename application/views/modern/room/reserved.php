        <!-- Main content -->
        <div class="content">
          <div class="container-fluid"> 

            <div class="row"> 

              <!-- /.col-md-6 Important Shortcuts -->
              <div class="col-lg-12"> 

                <?= $this->session->flashdata('message') ?? '' ?>

                <div class="card">
                  <div class="card-header">
                    <h5 class="m-0">
                      <i class="fa fa-bed mx-2 text-gray"></i>
                      Rooms
                    </h5>
                  </div>

                  <div class="card-body p-1">
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
                            <a href="javascript:void(0)" onclick="return confirmDelete('<?= site_url('room/reserved/delete_reservation/'.$rm->room_id)?>', 1)" class="btn btn-danger btn-sm">
                              <i class="btn-icon-only fa fa-trash text-white"></i>
                            </a>
                          </td>
                          <td> 
                            <?php if ($rm->checkin_date < date('Y-m-d', strtotime('NOW')) && $rm->checkout_date < date('Y-m-d', strtotime('NOW'))): ?>
                            <i class="fa fa-arrow-down text-danger"></i> 
                            <?php else: ?>
                            <i class="fa fa-arrow-up text-success"></i> 
                            <?php endif; ?>
                          </td>
                        </tr>
                        </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                      <tr>
                        <td colspan="6"><?php alert_notice('No rooms available', 'info', TRUE, FALSE) ?></td>
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
