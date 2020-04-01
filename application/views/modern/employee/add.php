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
            		Add a new employee
            	</h5>
          	</div>
          	<div class="card-body">
            
	            <?= form_open('employee/add/'.($employee['employee_id'] ?? ''))?> 
	            <div class="row"> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="username">Username</label>
	                    	<input type="text" id="username" name="username" class="form-control" value="<?= set_value_switch('username', $employee['employee_username']) ?>" required>
	                  		<?= form_error('username'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="password">Password</label>
	                    	<input type="text" id="password" name="password" class="form-control" value="<?= set_value('password') ?>" <?= !$employee['employee_id'] ? 'required' : ''?>>
	                  		<?= form_error('password'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="firstname">First Name</label>
	                    	<input type="text" id="firstname" name="firstname" class="form-control" value="<?= set_value_switch('firstname', $employee['employee_firstname']) ?>" required>
	                  		<?= form_error('firstname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="lastname">Last Name</label>
	                    	<input type="text" id="lastname" name="lastname" class="form-control" value="<?= set_value_switch('lastname', $employee['employee_lastname']) ?>" required>
	                  		<?= form_error('lastname'); ?>
	                  	</div>
	                </div> 

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="email">Email Address</label>
	                    	<input type="text" id="email" name="email" class="form-control" value="<?= set_value_switch('email', $employee['employee_email']) ?>">
	                  		<?= form_error('email'); ?>
	                  	</div>
	                </div>  

	                <div class="col-md-6">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="telephone">Phone</label>
	                    	<input type="text" id="telephone" name="telephone" class="form-control" value="<?= set_value_switch('telephone', $employee['employee_telephone']) ?>" required>
	                  		<?= form_error('telephone'); ?>
	                  	</div>
	                </div> 

                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="salary">Salary</label>
                            <input type="text" id="salary" name="salary" class="form-control" value="<?= set_value_switch('salary', $employee['employee_salary']) ?>" required>
                            <?= form_error('salary'); ?>
                        </div>
                    </div> 

                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="hiring_date">Hiring Date</label>
                            <input type="date" id="hiring_date" name="hiring_date" class="form-control" value="<?= set_value_switch('hiring_date', $employee['employee_hiring_date']) ?>" required>
                            <?= form_error('hiring_date'); ?>
                        </div>
                    </div> 

                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="departments_id">Department</label>
							<select id="department_id" name="department_id" class="form-control">
							<?php foreach ($departments as $dept): ?>
								<option value="<?=$dept->id?>"<?php echo set_select('department_id', $dept->id) ?>>
                                    <?=$dept->service_name?> 
                                </option>
							<?php endforeach; ?>
							</select> 
                            <?= form_error('departments_id'); ?>
                        </div>
                    </div> 

                    <div class="col-md-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="type">Employee Type</label>
                            <input type="text" id="type" name="type" class="form-control" value="<?= set_value_switch('type', $employee['employee_type']) ?>" required>
                            <?= form_error('type'); ?>
                        </div>
                    </div> 

                    <div class="col-md-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control"><?= set_value_switch('address', $employee['employee_address'] ?? '') ?></textarea>
                            <?= form_error('address'); ?>
                        </div>
                    </div>   

                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" class="form-control" value="<?= set_value_switch('city', $employee['employee_city'] ?? '') ?>" required>
                            <?= form_error('city'); ?>
                        </div>
                    </div> 

                    <div class="col-md-4">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" id="state" name="state" class="form-control" value="<?= set_value_switch('state', $employee['employee_state'] ?? '') ?>" required>
                            <?= form_error('state'); ?>
                        </div>
                    </div>  

	                <div class="col-md-4">
	                  	<!-- text input -->
	                  	<div class="form-group">
	                    	<label for="country">Country</label>
	                    	<input type="text" id="country" name="country" class="form-control" value="<?= set_value_switch('country', $employee['employee_country'] ?? '') ?>" required>
	                  		<?= form_error('country'); ?>
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
