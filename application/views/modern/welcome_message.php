<!-- Main content --> 
<div class="content"> 
    <div class="container-fluid">  
        <!-- Small boxes (Stat box) --> 
        <div class="row"> 
            <div class="col-lg-3 col-6"> 
                <!-- small box --> 
                <div class="small-box bg-info"> 
                    <div class="inner"> 
                        <h3><?=show_money($sales_stats["payments"], 0);?></h3> 
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
                        <h3><?=show_money($sales_stats["sales"], 0);?></h3> 
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
                        <h3><?=show_money($sales_stats["room_sales"], 0);?></h3> 
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

        <div class="row">
            <div class="col-md-12">
                <div class="card" id="target-6"<?=c_card_state('target-6', $page, $this->uid)?>>
                    <div class="card-header">
                        <h5 class="card-title">Monthly Recap Report</h5>
                        <div class="card-tools"> 
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a> 
                                </div>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>
                                        Sales: 
                                        <?=date('d M, Y', strtotime($monthly_summary['fr']))?> - 
                                        <?=date('d M, Y', strtotime($monthly_summary['to']))?>
                                    </strong>
                                </p>
                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Goal Completion</strong>
                                </p>
                                <div class="progress-group">
                                    Room Sales
                                    <span class="float-right"><b>
                                        <?=$monthly_summary['reservation']?></b>/<?=$monthly_summary['rooms']?>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: <?=show_percent($monthly_summary['reservation'],$monthly_summary['rooms']);?>"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Stock Sales
                                    <span class="float-right"><b>
                                        <?=$monthly_summary['stock_orders']?></b>/<?=$monthly_summary['stock']?>
                                    </span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: <?=show_percent($monthly_summary['stock_orders'],$monthly_summary['stock']);?>"></div>
                                    </div>
                                </div> 
                                <!-- /.progress-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <?php if ($p = show_percent($site_stats['revenue'],$site_stats['total_revenue'])): ?>
                                        <span class="description-percentage <?=percent_color($p)?>">
                                            <i class="fas <?=percent_color($p, 1)?>"></i> 
                                            <?=$p;?>
                                        </span>
                                    <?php endif ?>
                                    <h5 class="description-header"><?=show_money($site_stats['total_revenue'], 0);?></h5>
                                    <span class="description-text">TOTAL REVENUE</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <?php if ($p = show_percent($site_stats['cost'],$site_stats['total_revenue'])): ?>
                                        <span class="description-percentage <?=percent_color($p)?>">
                                            <i class="fas <?=percent_color($p, 1)?>"></i> 
                                            <?=$p;?>
                                        </span>
                                    <?php endif ?>
                                    <h5 class="description-header"><?=show_money($site_stats['cost'], 0);?></h5>
                                    <span class="description-text">TOTAL COST</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block border-right">
                                    <?php if ($p = show_percent($site_stats['total_profit'],$site_stats['total_revenue'])): ?>
                                        <span class="description-percentage <?=percent_color($p)?>">
                                            <i class="fas <?=percent_color($p, 1)?>"></i> 
                                            <?=$p;?>
                                        </span>
                                    <?php endif ?> 
                                    <h5 class="description-header"><?=show_money($site_stats['total_profit'], 0);?></h5>
                                    <span class="description-text">TOTAL PROFIT</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 col-6">
                                <div class="description-block">
                                    <?php if ($p = show_percent($monthly_summary['goal_complete'],$monthly_summary['goal'])): ?>
                                        <span class="description-percentage <?=percent_color($p)?>">
                                            <i class="fas <?=percent_color($p, 1)?>"></i> 
                                            <?=$p;?>
                                        </span>
                                    <?php endif ?> 
                                    <h5 class="description-header"><?=$monthly_summary['goal_complete']?></h5>
                                    <span class="description-text">GOAL COMPLETIONS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- /.row --> 
        <div class="row"> 
            <div class="col-lg-6"> 
                <div class="card" id="target-1"<?=c_card_state('target-1', $page, $this->uid)?>>
                    <div class="card-header"> 
                        <h5 class="card-title m-0">
                            <i class="fa fa-users mx-2 text-gray"></i>Top Customers
                        </h5> 
                        <div class="card-tools"> 
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
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
                                        <!--td class="td-actions">
                                            <a href="javascript:;" class="btn btn-small btn-success">
                                                <i class="btn-icon-only icon-ok"> </i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-danger btn-small">
                                                <i class="btn-icon-only icon-remove"> </i>
                                            </a>
                                        </td--> 
                                    </tr> 
                                <?php endforeach; ?> 
                            </tbody> 
                        </table> 
                    </div> 
                </div> 
                <div class="card card-primary card-outline text-sm" id="target-2"<?=c_card_state('target-2', $page, $this->uid)?>>
                    <div class="card-header"> 
                        <h5 class="card-title m-0">
                            <i class="fa fa-tasks mx-2 text-gray"></i>Bookings
                        </h5> 
                        <div class="card-tools"> 
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div> 
                    <div class="card-body"> 
                        <div id="calendar"></div> 
                    </div> 
                </div><!-- /.card --> 
            </div> 
            <!-- /.col-md-6 Important Shortcuts --> 
            <div class="col-lg-6"> 
                <div class="card" id="target-3"<?=c_card_state('target-3', $page, $this->uid)?>>
                    <div class="card-header"> 
                        <h5 class="card-title m-0">
                            <i class="fa fa-bookmark mx-2 text-gray"></i>Important Shortcuts
                        </h5> 
                        <div class="card-tools"> 
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div> 
                    <div class="card-body text-center"> 
                        <a href="<?=site_url('employee')?>" class="btn btn-light px-2 m-1 border"> 
                            <i class="fa fa-user-tie fa-2x fa-fw mx-2 text-gray"></i> 
                            <div class="font-weight-bold">Employees</div> 
                        </a> 
                        <a href="<?=site_url('customer/list')?>" class="btn btn-light px-2 m-1 border"> 
                            <i class="fa fa-users fa-2x fa-fw mx-2 text-gray"></i> 
                            <div class="font-weight-bold">Customers</div> </a> 
                        <a href="<?=site_url('accounting/cashier/payments')?>" class="btn btn-light px-2 m-1 border"> 
                            <i class="fa fa-file fa-2x fa-fw mx-2 text-gray"></i> 
                            <div class="font-weight-bold">Sales Report</div> 
                        </a> 
                        <a href="<?=site_url('login/logout')?>" class="btn btn-light px-4 m-1 border"> 
                            <i class="fa fa-power-off  fa-2x fa-fw mx-2 text-gray"></i> 
                            <div class="font-weight-bold">Logout</div> 
                        </a> 
                    </div> 
                </div> 
                <div class="card card-primary card-outline" id="target-4"<?=c_card_state('target-4', $page, $this->uid)?>>
                    <div class="card-header"> 
                        <h5 class="card-title m-0">
                            <i class="fa fa-user-clock mx-2 text-gray"></i>Most Frequent Customers
                        </h5> 
                        <div class="card-tools"> 
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
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
                                        <!--td class="td-actions">
                                            <a href="javascript:;" class="btn btn-small btn-success">
                                                <i class="btn-icon-only icon-ok"> </i>
                                            </a>
                                            <a href="javascript:;" class="btn btn-danger btn-small">
                                                <i class="btn-icon-only icon-remove"> </i>
                                            </a>
                                        </td--> 
                                    </tr> 
                                <?php endforeach; ?> 
                            </tbody> 
                        </table> 
                    </div> 
                </div> 

                <div class="card card-primary card-outline" id="target-5"<?=c_card_state('target-5', $page, $this->uid)?>>
                    <div class="card-header"> 
                        <h5 class="card-title m-0">
                            <i class="fa fa-book mx-2 text-gray"></i>Booked For next week
                        </h5> 
                        <div class="card-tools"> 
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-window-maximize"></i>
                            </button> 
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div> 
                    <div class="card-body p-1">  
                        <canvas id="next_weekChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> 
                    </div> 
                </div> 
            </div> 
            <!-- /.col-md-6 --> 
        </div> 
        <!-- /.row --> 
    </div>
    <!-- /.container-fluid --> 
</div> <!-- /.content --> 


<script>
    window.onload = function () {
    }
</script>
