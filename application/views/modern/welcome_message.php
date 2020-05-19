
        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">

            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?=$this->cr_symbol.number_format($sales_stats["payments"]);?></h3>
                    <p>Payments</p>
                  </div>
                  <div class="icon">
                    <i class="far fa-credit-card"></i>
                  </div>
                  <a href="<?= site_url('accounting/cashier/payments')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?=$this->cr_symbol.number_format($sales_stats["sales"]);?></h3>
                    <p>Service Sales</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-store"></i>
                  </div>
                  <a href="<?= site_url('services/sales_records')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?=$this->cr_symbol.number_format($sales_stats["room_sales"]);?></h3>
                    <p>Room Sales</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-bed"></i>
                  </div>
                  <a href="<?= site_url('accounting/cashier/room_sales')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?=$sales_stats["customers"];?></h3>
                    <p>Customers</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-users"></i>
                  </div>
                  <a href="<?= site_url('customer/list')?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row --> 

            <div class="row">
              <div class="col-lg-6">
                <div class="card" id="target-3">
                  <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-users mx-2 text-gray"></i>Top Customers</h5>
                  </div>
                  <div class="card-body p-1">  
                    <table class="table table-striped card-text">
                      <thead>
                        <tr>
                          <th> Name </th>
                          <th> TC no </th>
                          <th> Checkin Count </th>
                          <th> Total Paid </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($customer_most_paid as $k => $cust): ?>
                        <tr>
                          <td> <?= $cust->customer_firstname." ".$cust->customer_lastname;?> </td>
                          <td> <?= $cust->customer_TCno?> </td>
                          <td> <?= $cust->checkin_count?></td>
                          <td> <?= $cust->total_paid?></td>
                          <!--td class="td-actions"><a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td-->
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>  
                  </div>
                </div>

                <div class="card card-primary card-outline text-sm">
                  <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-tasks mx-2 text-gray"></i>Bookings</h5>
                  </div>
                  <div class="card-body"> 
                    <div id="calendar"></div>
                  </div>
                </div><!-- /.card -->
              </div>

              <!-- /.col-md-6 Important Shortcuts -->
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-bookmark mx-2 text-gray"></i>Important Shortcuts</h5>
                  </div>
                  <div class="card-body text-center"> 
                    <a href="<?=site_url('room')?>" class="btn btn-light px-4 border">
                      <i class="fa fa-home fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Rooms</div>
                    </a>

                    <a href="<?=site_url('employee')?>" class="btn btn-light px-2 border">
                      <i class="fa fa-user-tie fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Employees</div>
                    </a>

                    <a href="<?=site_url('customer/list')?>" class="btn btn-light px-2 border">
                      <i class="fa fa-users fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Customers</div>
                    </a>

                    <a href="<?=site_url('accounting/cashier/payments')?>" class="btn btn-light px-2 border">
                      <i class="fa fa-file fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Sales Report</div>
                    </a>

                    <a href="<?=site_url('login/logout')?>" class="btn btn-light px-4 border">
                      <i class="fa fa-power-off  fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Logout</div>
                    </a>
                  </div>
                </div>

                <div class="card card-primary card-outline" id="target-4">
                  <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-user-clock mx-2 text-gray"></i>Most Frequent Customers</h5>
                  </div>
                  <div class="card-body p-1">  
                    <table class="table table-striped card-text">
                      <thead>
                        <tr>
                          <th> Name </th>
                          <th> TC no </th>
                          <th> Checkin Count </th>
                          <th> Total Paid </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($customer_pay_list as $k => $cust): ?>
                        <tr>
                          <td> <?= $cust->customer_firstname." ".$cust->customer_lastname;?> </td>
                          <td> <?= $cust->customer_TCno?> </td>
                          <td> <?= $cust->checkin_count?></td>
                          <td> <?= $cust->total_paid?></td>
                          <!--td class="td-actions"><a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a><a href="javascript:;" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a></td-->
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>  
                  </div>
                </div>

                <div class="card card-primary card-outline" id="target-2">
                  <div class="card-header">
                    <h5 class="m-0"><i class="fa fa-book mx-2 text-gray"></i>Booked For next week</h5>
                  </div>
                  <div class="card-body p-1">  
                    <canvas id="area-chart" class="chart-holder" height="250" width="400"> </canvas>
                  </div>
                </div>
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
