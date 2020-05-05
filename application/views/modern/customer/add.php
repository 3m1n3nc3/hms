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
            		<i class="fa fa-user mx-2 text-gray"></i>
            		<?=$action_title?>
            	</h5>
          	</div>
          	<div class="card-body">
            
	            <?= form_open('customer/add/' . $reference)?> 
	            <div class="row"> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="firstname"><?=lang('firstname')?></label>
	                    	<input type="text" id="firstname" name="customer_firstname" class="form-control" value="<?= set_value('customer_firstname') ?>" required>
	                  		<?= form_error('customer_firstname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="lastname"><?=lang('lastname')?></label>
	                    	<input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= set_value('customer_lastname') ?>" required>
	                  		<?= form_error('customer_lastname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="email"><?=lang('email_address')?></label>
	                    	<input type="text" id="email" name="customer_email" class="form-control" value="<?= set_value('customer_email') ?>">
	                  		<?= form_error('customer_email'); ?>
	                  	</div>
	                </div>  

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="telephone"><?=lang('phone')?></label>
	                    	<input type="text" id="telephone" name="customer_telephone" class="form-control" value="<?= set_value('customer_telephone') ?>" required>
	                  		<?= form_error('customer_telephone'); ?>
	                  	</div>
	                </div>

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="address"><?=lang('address')?></label>
                            <textarea id="address" name="customer_address" class="form-control"><?= set_value('customer_address') ?></textarea>
                            <?= form_error('customer_address'); ?>
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country"><?=lang('country')?></label>
                            <select id="country" name="customer_country" class="form-control select-country" data-target="state" required>
                                <?=select_countries(set_value('customer_country'))?>
                            </select>  
                            <?= form_error('customer_country'); ?>
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="country"><?=lang('state')?></label>
                            <select id="state" name="customer_state" class="form-control select-state" data-target="city" required> 
                            </select>  
                            <?= form_error('customer_state'); ?>
                        </div>
                    </div> 

                    <div class="col-md-4">
                        <div class="form-group">
                           <label for="country"><?=lang('city')?></label>
                            <select id="city" name="customer_city" class="form-control select-city" required> 
                            </select>   
                            <?= form_error('customer_city'); ?>
                        </div>
                    </div>    

	                <div class="col-md-12">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="TCno"><?=lang('customer_id_code')?></label>
	                    	<input type="text" id="TCno" name="customer_TCno" class="form-control" value="<?= set_value_switch('customer_TCno', $ref_token) ?>" required readonly>
	                  		<?= form_error('customer_TCno'); ?>
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
