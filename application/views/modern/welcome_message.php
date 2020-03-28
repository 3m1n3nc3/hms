
        <!-- Main content -->
        <div class="content">
          <div class="container-fluid">

          <!-- Info boxes -->
          <div class="row" id="target-1">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-utensils"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Restaurant</span>
                  <span class="info-box-number">
                    <?=$today_stats["restaurant"]?>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-futbol"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Sport</span>
                  <span class="info-box-number"><?=$today_stats["sport"]?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-first-aid"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Medical Service</span>
                  <span class="info-box-number"><?=$today_stats["medicalservice"]?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hand-rock"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Massage</span>
                  <span class="info-box-number"><?=$today_stats["massage"]?></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->
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
                    <a href="<?=site_url('room')?>" class="btn btn-light px-4">
                      <i class="fa fa-home fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Home</div>
                    </a>

                    <a href="<?=site_url('employee')?>" class="btn btn-light px-2">
                      <i class="fa fa-user-tie fa-2x fa-fw mx-2 text-gray"></i>
                      <div class="font-weight-bold">Employees</div>
                    </a>

                    <a href="<?=site_url('login/logout')?>" class="btn btn-light px-4">
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
