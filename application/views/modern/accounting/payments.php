    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">  

            <!-- /.col-md-4 Important Shortcuts -->
            <div class="col-lg-12"> 
                
                <?= form_open('accounting/cashier/payments', array('method' => 'get'))?>

                    <div class="row"> 

                        <div class="col-7">
                            <div class="row">
                                <!-- text input -->
                                <label class="col-2 font-weight-bold"> 
                                    <?=lang('date')?>: 
                                </label>
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

                </div>
                <!-- /.col-md-12 -->  

                <div class="col-lg-12">

                    <?= $this->session->flashdata('message') ?? '' ?>

                    <?= form_open('accounting/cashier/payments'.$filter_query, array('class' => 'my-2'))?>
                        <button class="btn btn-default" name="print" value="print"><i class="fas fa-print"></i> Print</button>
                    <?= form_close()?>

                    <div class="card">
                        <div class="card-header">
                            <strong class="m-0 p-0">
                                <i class="far fa-credit-card mx-2 text-gray"></i>
                                <?=lang('sales_report')?>
                            </strong>
                            <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                                <?//= $pagination ?>
                            </div>
                        </div>
                        <div class="card-body p-1">
                            <?php if ($payments): ?>
                            <table class="table table-striped display" id="datatables_table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th> <?=lang('by')?> </th>
                                        <th> <?=lang('amount')?> </th>  
                                        <th> <?=lang('reference')?> </th>
                                        <th> <?=lang('description')?> </th>
                                        <th> <?=lang('date')?> </th>
                                        <th class="td-actions"> <?=lang('actions')?> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <?php alert_notice(lang('no_payment_records'), 'info', TRUE, FALSE) ?>
                            <?php endif;?>
                        </div>
                        
                        <?php if ($payments): ?>
                        <div class="card-footer">
                            <span class="mr-5">
                                <strong class="p-0"> 
                                    <?=lang('total')?>: 
                                </strong> 
                                <?=$this->cr_symbol.number_format($payments[0]['total'], 2)?>
                            </span>
                            <span class="mr-5">
                                <strong class="p-0"> 
                                    <?=lang('total_entries')?>: 
                                </strong> 
                                <?=$payments[0]['entries']?>
                            </span>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
