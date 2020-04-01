    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">  

            <!-- /.col-md-4 Important Shortcuts -->
            <div class="col-lg-12"> 
                
                <?= form_open('accounting/cashier', array('method' => 'get'))?>

                    <div class="row"> 

                        <div class="col-7">
                            <div class="row">
                                <!-- text input -->
                                <label class="col-2 font-weight-bold"> 
                                    Date: 
                                </label>
                                <div class="form-group col-4 row"> 
                                    <label for="checkin_date" class="col-sm-4 col-form-label">From</label>
                                    <input type="date" id="from" name="from" class="form-control form-control-sm col-sm-8" value="<?= $this->input->get('from') ?>" required>
                                </div>  

                                <!-- text input -->
                                <div class="form-group col-4 row">
                                    <label for="checkout_date" class="col-sm-4 col-form-label">To</label>
                                    <input type="date" id="to" name="to" class="form-control form-control-sm col-sm-8" value="<?= $this->input->get('to') ?>">
                                </div>

                                <!-- text input -->
                                <div class="form-group col-2"> 
                                    <button class="button btn btn-info btn-sm">Filter</button>
                                </div>

                            </div>  
                        </div>
                    </div> 
                <?= form_close()?>

                </div>
                <!-- /.col-md-12 -->  

                <div class="col-lg-12">

                    <?= $this->session->flashdata('message') ?? '' ?>

                    <?= form_open('accounting/cashier'.$filter_query, array('class' => 'my-2'))?>
                        <button class="btn btn-default" name="print" value="print"><i class="fas fa-print"></i> Print</button>
                    <?= form_close()?>

                    <div class="card">
                        <div class="card-header">
                            <strong class="m-0 p-0">
                                <i class="fa fa-receipt mx-2 text-gray"></i>
                                Cashier's Report
                            </strong>
                            <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                                <?//= $pagination ?>
                            </div>
                        </div>
                        <div class="card-body p-1">
                            <?php if ($expenses): ?>
                            <table class="table table-striped display" id="datatables_table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th> Subject </th>
                                        <th> Date </th>
                                        <th> Amount </th> 
                                        <th> Remark </th>
                                        <th> Added By </th>
                                        <th> Added On </th>
                                        <th class="td-actions"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <?php alert_notice('No sales records available', 'info', TRUE, FALSE) ?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
