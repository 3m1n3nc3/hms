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
							<img class="profile-user-img img-fluid img-circle" src="<?= base_url('backend/modern/dist/img'); ?>/user4-128x128.jpg" alt="User profile picture">
						</div>
						<h3 class="profile-username text-center"><?=$customer['customer_firstname'] . ' ' .$customer['customer_lastname']?></h3>
						<p class="text-muted text-center">Customer</p>
						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Checkins</b> <a class="float-right">22</a>
							</li>
							<li class="list-group-item">
								<b>Services</b> <a class="float-right">543</a>
							</li>
							<li class="list-group-item">
								<b>Expenses</b> <a class="float-right">13,287</a>
							</li>
						</ul>
						<?=form_open('reservation')?>
							<input type="hidden" name="customer_TCno" value="<?=$customer['customer_TCno']?>">
							<button class="btn btn-primary btn-block"><b>Reserve</b></button>
						<?=form_close()?>
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
							<li class="nav-item">
								<a class="nav-link<?= $this->input->post('update_profile') || $this->session->flashdata('update_profile') ? ' active' : ''?>" href="#settings" data-toggle="tab">Settings</a>
							</li>
						</ul>
					</div><!-- /.card-header -->

					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane<?= !$this->input->post('update_profile') && !$this->session->flashdata('update_profile') ? ' active' : ''?>" id="profile">
								<strong><i class="fas fa-user mr-1"></i> Name</strong>
								<p class="text-muted">
									<?=$customer['customer_firstname'] . ' ' .$customer['customer_lastname']?>
								</p>
								<hr>
								<strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>
								<p class="text-muted">
									<?=($customer['customer_address'] ? $customer['customer_address'].', ' : '') . ($customer['customer_city'] ? $customer['customer_city'] : '') . ($customer['customer_state'] ? ', '.$customer['customer_state'] : '') . ($customer['customer_country'] ? ', '.$customer['customer_country'] : '')?>
										
									</p>
								<hr>
								<strong><i class="fas fa-at mr-1"></i> Email</strong>
								<p class="text-muted">
									<?=$customer['customer_email'] ?? 'N/A'?>
								</p>
								<hr>
								<strong><i class="fas fa-phone mr-1"></i> Phone</strong>
								<p class="text-muted">
									<?=$customer['customer_telephone'] ?? 'N/A'?>
								</p>
								<hr>
								<strong><i class="fas fa-id-card mr-1"></i>Customer Identity Code</strong>
								<p class="text-muted">
									<?=$customer['customer_TCno'] ?? 'N/A'?>
								</p>
							</div>

							<div class="tab-pane<?= $this->input->post('update_profile') || $this->session->flashdata('update_profile') ? ' active' : ''?>" id="settings">
								<?= form_open('customer/data/' . $customer['customer_id'])?> 
									<input type="hidden" name="update_profile" value="1">

									<div class="form-group row">
										<label for="firstname" class="col-sm-3 col-form-label">First Name</label>
										<div class="col-sm-9">
											<input type="text" id="firstname" name="customer_firstname" class="form-control" value="<?= $customer['customer_firstname'] ?>" required>
	                  						<?= form_error('customer_firstname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
										<div class="col-sm-9">
											<input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= $customer['customer_lastname'] ?>" required>
	                  						<?= form_error('customer_lastname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-sm-3 col-form-label">Email</label>
										<div class="col-sm-9">
					                    	<input type="text" id="email" name="customer_email" class="form-control" value="<?= $customer['customer_email'] ?>">
					                  		<?= form_error('customer_email'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="telephone" class="col-sm-3 col-form-label">Phone Number</label>
										<div class="col-sm-9">
					                    	<input type="text" id="telephone" name="customer_telephone" class="form-control" value="<?= $customer['customer_telephone'] ?>" required>
					                  		<?= form_error('customer_telephone'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="address" class="col-sm-3 col-form-label">Address</label>
										<div class="col-sm-9">
				                            <textarea id="address" name="customer_address" class="form-control"><?= $customer['customer_address'] ?></textarea>
				                            <?= form_error('customer_address'); ?>
										</div>
									</div> 
									<div class="form-group row">
										<label for="city" class="col-sm-3 col-form-label">City</label>
										<div class="col-sm-9">
					                    	<input type="text" id="city" name="customer_city" class="form-control" value="<?= $customer['customer_city'] ?>" required>
					                  		<?= form_error('customer_city'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="state" class="col-sm-3 col-form-label">State</label>
										<div class="col-sm-9">
					                    	<input type="text" id="state" name="customer_state" class="form-control" value="<?= $customer['customer_state'] ?>" required>
					                  		<?= form_error('customer_state'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="country" class="col-sm-3 col-form-label">Country</label>
										<div class="col-sm-9">
					                    	<input type="text" id="country" name="customer_country" class="form-control" value="<?= $customer['customer_country'] ?>" required>
					                  		<?= form_error('customer_country'); ?>
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
