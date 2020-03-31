<!-- Main content -->
<div class="content">
  <div class="container-fluid"> 

    <?= $this->session->flashdata('message') ?? '' ?>

    <div class="row">
        <!-- /.col-md-4 Important Shortcuts -->
        <div class="col-md-12"> 

        <div class="card">
            <div class="card-header">
                <h5 class="m-0">
                    <i class="fa fa-columns mx-2 text-gray"></i>
                    <?=$record_id ? 'Update' : 'Add a new' ?> expense record
                </h5>
            </div>
            <div class="card-body">
            
                <?= form_open('accounting/cashier/expenses_register/'.$record_id ?? '')?> 
                <div class="row"> 

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" class="form-control" value="<?= set_value_switch('date', $date ?? null) ?>" required>
                            <?= form_error('date'); ?>
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" value="<?= set_value_switch('subject', $subject ?? null) ?>" required>
                            <?= form_error('subject'); ?>
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" min="1" id="amount" name="amount" class="form-control" value="<?= set_value_switch('amount', $amount ?? null) ?>">
                            <?= form_error('amount'); ?>
                        </div>
                    </div>    

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea id="remark" name="remark" class="form-control"><?= set_value_switch('remark', $remark ?? null) ?></textarea required>
                            <?= form_error('remark'); ?>
                        </div>
                    </div>    

                </div>
     
                <button class="button btn btn-success">Add</button>
                <?= form_close()?>
            
                </div>
            </div>
        </div>
      <!-- /.col-md-12 --> 
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
