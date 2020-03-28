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
            		Add a new customer
            	</h5>
          	</div>
          	<div class="card-body">
            
	            <?= form_open('customer/add/' . $reference . '/update')?> 
	            <div class="row"> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="firstname">First Name</label>
	                    	<input type="text" id="firstname" name="customer_firstname" class="form-control" value="<?= set_value_switch('customer_firstname', $customer['customer_firstname']) ?>" required>
	                  		<?= form_error('customer_firstname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="lastname">Last Name</label>
	                    	<input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= set_value_switch('customer_lastname', $customer['customer_lastname']) ?>" required>
	                  		<?= form_error('customer_lastname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="email">Email Address</label>
	                    	<input type="text" id="email" name="customer_email" class="form-control" value="<?= set_value_switch('customer_email', $customer['customer_email']) ?>">
	                  		<?= form_error('customer_email'); ?>
	                  	</div>
	                </div>  

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="telephone">Phone</label>
	                    	<input type="text" id="telephone" name="customer_telephone" class="form-control" value="<?= set_value_switch('customer_telephone', $customer['customer_telephone']) ?>" required>
	                  		<?= form_error('customer_telephone'); ?>
	                  	</div>
	                </div>

                    <div class="col-md-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="customer_address" class="form-control"><?= set_value_switch('customer_address', $customer['customer_address']) ?></textarea>
                            <?= form_error('customer_address'); ?>
                        </div>
                    </div>   

                    <div class="col-md-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="customer_city" class="form-control" value="<?= set_value_switch('customer_city', $customer['customer_city']) ?>" required>
                            <?= form_error('customer_city'); ?>
                        </div>
                    </div> 

                    <div class="col-md-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="customer_state" class="form-control" value="<?= set_value_switch('customer_state', $customer['customer_state']) ?>" required>
                            <?= form_error('customer_state'); ?>
                        </div>
                    </div>  

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="country">Country</label>
	                    	<input type="text" id="country" name="customer_country" class="form-control" value="<?= set_value_switch('customer_country', $customer['customer_country']) ?>" required>
	                  		<?= form_error('customer_country'); ?>
	                  	</div>
	                </div>  

	                <div class="col-md-12">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="TCno">Customer Identity Code</label>
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
