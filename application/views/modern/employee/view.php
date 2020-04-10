<!-- Main content -->
<section class="content">
	<div class="container-fluid">

    	<?= $this->session->flashdata('message') ?? '' ?>

		<div class="row">
			<div class="col-md-4">
				<!-- Profile Image -->
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?= $this->creative_lib->fetch_image($employee['image'], 3); ?>" alt="User profile picture">
						</div>
						<h3 class="profile-username text-center"><?=$employee['employee_firstname'] . ' ' .$employee['employee_lastname']?></h3>
						<p class="text-muted text-center"><?=$employee['employee_type']?></p>

					<?php if (isset($this->uid) && $this->uid == $employee['employee_id']):?>
						<?php if ($employee): ?>
	                        
	                        <div id="upload_resize_image" data-endpoint="employee" data-endpoint_id="<?= $employee['employee_id']; ?>" class="d-none"></div>
	                        <button type="button" id="resize_image_button" class="btn btn-success mb-2 btn-block text-white upload_resize_image" data-type="avatar" data-endpoint="employee" data-endpoint_id="<?= $employee['employee_id'];?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button>

	                    <?php else: ?>

	                        <?php alert_notice(lang('save_to_upload'), 'info', TRUE, 'FLAT') ?>

	                    <?php endif; ?>
	                <?php endif; ?>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Employment Date</b> 
								<a class="float-right"><?= date('M. d Y', strtotime($employee['employee_hiring_date']))?></a>
							</li>
							<li class="list-group-item">
								<b>Basic Salary</b> <a class="float-right"><?=$employee['employee_salary']?></a>
							</li>
							<li class="list-group-item">
								<b>Department</b> <a class="float-right"><?=$department['service_name']?></a>
							</li>
						</ul> 
						<a href="<?=site_url('employee/add/'.$employee['employee_id'])?>" class="btn btn-primary btn-block text-white"><b>Update Employee Data</b></a> 
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card --> 
			</div>
			<!-- /.col -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item">
								<a class="nav-link<?= !$this->input->post('update_profile') && !$this->session->flashdata('update_profile') ? ' active' : ''?>" href="#profile" data-toggle="tab">Profile</a>
							</li>
							<?php if (isset($this->uid) && $this->uid == $employee['employee_id']):?>
							<li class="nav-item">
								<a class="nav-link<?= $this->input->post('update_profile') || $this->session->flashdata('update_profile') ? ' active' : ''?>" href="#settings" data-toggle="tab">Settings</a>
							</li>
							<?php endif; ?>
						</ul>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane<?= !$this->input->post('update_profile') && !$this->session->flashdata('update_profile') ? ' active' : ''?>" id="profile">
								<strong><i class="fas fa-user mr-1"></i> Name</strong>
								<p class="text-muted">
									<?=$employee['employee_firstname'] . ' ' .$employee['employee_lastname']?>
								</p>
								<hr>
								<strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
								<p class="text-muted">
									<?=($employee['employee_address'] ? $employee['employee_address'].', ' : '') . ($employee['employee_city'] ? $employee['employee_city'] : '') . ($employee['employee_state'] ? ', '.$employee['employee_state'] : '') . ($employee['employee_country'] ? ', '.$employee['employee_country'] : '')?>
								</p>
								<hr>
								<strong><i class="fas fa-at mr-1"></i> Email</strong>
								<p class="text-muted">
									<?=$employee['employee_email'] ?? 'N/A'?>
								</p>
								<hr>
								<strong><i class="fas fa-phone mr-1"></i> Phone</strong>
								<p class="text-muted">
									<?=$employee['employee_telephone'] ?? 'N/A'?>
								</p> 
							</div>

							<?php if (isset($this->uid) && $this->uid == $employee['employee_id']):?>
							<div class="tab-pane<?= $this->input->post('update_profile') || $this->session->flashdata('update_profile') ? ' active' : ''?>" id="settings">
								<?= form_open('employee/profile/'.$employee['employee_id'])?> 
									<input type="hidden" name="update_profile" value="1">

									<div class="form-group row">
										<label for="firstname" class="col-sm-3 col-form-label">First Name</label>
										<div class="col-sm-9">
											<input type="text" id="firstname" name="employee_firstname" class="form-control" value="<?= set_value('employee_firstname', $employee['employee_firstname']) ?>" required>
	                  						<?= form_error('employee_firstname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
										<div class="col-sm-9">
											<input type="text" id="lastname" name="employee_lastname" class="form-control" value="<?= set_value('employee_lastname', $employee['employee_lastname']) ?>" required>
	                  						<?= form_error('employee_lastname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-sm-3 col-form-label">Email</label>
										<div class="col-sm-9">
					                    	<input type="text" id="email" name="employee_email" class="form-control" value="<?= set_value('employee_email', $employee['employee_email']) ?>">
					                  		<?= form_error('employee_email'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="telephone" class="col-sm-3 col-form-label">Phone Number</label>
										<div class="col-sm-9">
					                    	<input type="text" id="telephone" name="employee_telephone" class="form-control" value="<?= set_value('employee_telephone', $employee['employee_telephone']) ?>" required>
					                  		<?= form_error('employee_telephone'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="address" class="col-sm-3 col-form-label">Address</label>
										<div class="col-sm-9">
				                            <textarea id="address" name="employee_address" class="form-control"><?= set_value('employee_address', $employee['employee_address']) ?></textarea>
				                            <?= form_error('employee_address'); ?>
										</div>
									</div> 
									<div class="form-group row">
										<label for="country" class="col-sm-3 col-form-label">Country</label>
										<div class="col-sm-9">
	                                        <select id="country" name="employee_country" class="form-control select-country" data-target="state" required>
	                                            <?=select_countries(set_value('employee_country', $employee['employee_country']))?>
	                                        </select>  
					                  		<?= form_error('employee_country'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="state" class="col-sm-3 col-form-label">State</label>
										<div class="col-sm-9">
                                            <select id="state" name="employee_state" class="form-control select-state" data-target="city" required>
                                                <option value="<?=$employee['employee_state']?>" <?= set_select('employee_state', $employee['employee_state'], TRUE) ?>><?=$employee['employee_state'] ?></option>
                                            </select>  
					                  		<?= form_error('employee_state'); ?>
										</div>
									</div> 
									<div class="form-group row">
										<label for="city" class="col-sm-3 col-form-label">City</label>
										<div class="col-sm-9">
                                            <select id="city" name="employee_city" class="form-control select-city" required>
                                                <option value="<?=$employee['employee_city']?>" <?= set_select('employee_city', $employee['employee_city'], TRUE) ?>><?=$employee['employee_city'] ?></option>
                                            </select>   
					                  		<?= form_error('employee_city'); ?>
										</div>
									</div>    
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button class="btn btn-danger">Submit</button>
										</div>
									</div>
								<?=form_close()?>
							</div>
							<!-- /.tab-pane -->
							<?php endif; ?>

						</div>
					<!-- /.tab-content -->
					</div><!-- /.card-body -->
				</div>
				<!-- /.nav-tabs-custom -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->

  
<?php
    $param = array(
        'modal_target' => 'uploadModal',
        'modal_title' => 'Upload Image',
        'modal_size' => 'modal-md',
        'modal_content' => ' 
            <div class="m-0 p-0 text-center" id="upload_loader">
                <div class="loader"><div class="spinner-grow text-warning"></div></div> 
            </div>'
    );
    $this->load->view($this->h_theme.'/modal', $param);
?>
