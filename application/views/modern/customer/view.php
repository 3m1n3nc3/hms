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
							<img class="profile-user-img img-fluid rounded img-thumbnail" src="<?= $this->creative_lib->fetch_image($customer['image'], 3); ?>" alt="User profile picture">
						</div>    

						<h3 class="profile-username text-center"><?=$customer['customer_firstname'] . ' ' .$customer['customer_lastname']?></h3>
						<p class="text-muted text-center">Customer</p>

					<?php if (isset($this->cuid) && $this->cuid == $customer['customer_id']):?>
						<?php if ($customer): ?>
	                        
	                        <div id="upload_resize_image" data-endpoint="customer" data-endpoint_id="<?= $customer['customer_id']; ?>" class="d-none"></div>
	                        <button type="button" id="resize_image_button" class="btn btn-success mb-2 btn-block text-white upload_resize_image" data-type="avatar" data-endpoint="customer" data-endpoint_id="<?= $customer['customer_id'];?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button>

	                    <?php else: ?>

	                        <?php alert_notice(lang('save_to_upload'), 'info', TRUE, 'FLAT') ?>

	                    <?php endif; ?>
	                <?php endif; ?>

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Checkins</b> 
								<a class="float-right"><?= $statistics['checkins']?></a>
							</li>
							<li class="list-group-item">
								<b>Card Payments</b> 
								<a class="float-right"><?= $this->cr_symbol.number_format($statistics['payments'], 2)?></a>
							</li>
							<li class="list-group-item">
								<b>Service Orders</b> 
								<a class="float-right"><?= $this->cr_symbol.number_format($statistics['service_orders'], 2)?></a>
							</li>
							<li class="list-group-item">
								<b>Room Bookings</b> 
								<a class="float-right"><?= $this->cr_symbol.number_format($statistics['room_sales'], 2)?></a>
							</li>
							<li class="list-group-item">
								<b>Expenses</b> 
								<a class="float-right"><?= $this->cr_symbol.number_format($statistics['expenses'], 2)?></a>
							</li>
							<li class="list-group-item text-danger">
								<b>Debt</b> 
								<a class="float-right" id="customer_debt"><?= $this->cr_symbol.number_format($statistics['debt'], 2)?></a>
							</li>
							<?php 
								$total_expenses = ($statistics['total_expenses'] <= 0 ? ($statistics['service_orders']+$statistics['room_sales']) : $statistics['total_expenses'])
							?>
							<li class="list-group-item text-success">
								<b>Total Expenses</b> 
								<a class="float-right"><?= $this->cr_symbol.number_format($total_expenses, 2)?></a>
							</li>
						</ul>

						<?php if (has_privilege('customers') && $customer['customer_id'] !== '0'):?>
						<?=form_open('reservation')?>
							<input type="hidden" name="customer_TCno" value="<?=$customer['customer_TCno']?>">
							<button class="btn btn-primary btn-block"><b>Reserve</b></button>
						<?=form_close()?>
						<?php endif;?>
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
							<?php if ($set_view == 'home'):?>
							<li class="nav-item">
								<a class="nav-link<?= $set_view == 'home' && (!$this->input->post('update_profile') && !$this->session->flashdata('update_profile')) ? ' active' : ''?>" href="#profile" data-toggle="tab">Profile</a>
							</li>
							<?php else:?>
							<li class="nav-item">
								<a class="nav-link" href="<?= site_url('customer/data/'.$customer['customer_TCno'])?>">Profile</a>
							</li>
							<?php endif;?>
							<?php if (isset($this->cuid) && $this->cuid == $customer['customer_id']):?>
							<li class="nav-item">
								<a class="nav-link<?= $set_view == 'home' && ($this->input->post('update_profile') || $this->session->flashdata('update_profile')) ? ' active' : ''?>" href="#settings" data-toggle="tab">Settings</a>
							</li>
							<?php endif;?>
							<li class="nav-item">
								<a class="nav-link<?= $set_view == 'purchases' ? ' active' : ''?>" href="<?= site_url('customer/data/'.$customer['customer_TCno'].'/purchases') ?>">Purchases</a>
							</li>
						</ul>
					</div><!-- /.card-header -->

					<?php if ($set_view == 'home'):?>
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

							<?php if (isset($this->cuid) && $this->cuid == $customer['customer_id']):?>
							<div class="tab-pane<?= $this->input->post('update_profile') || $this->session->flashdata('update_profile') ? ' active' : ''?>" id="settings">
								<?= form_open($form_action ?? 'customer/data/' . $customer['customer_id'])?> 
									<input type="hidden" name="update_profile" value="1">

									<div class="form-group row">
										<label for="firstname" class="col-sm-3 col-form-label">First Name</label>
										<div class="col-sm-9">
											<input type="text" id="firstname" name="customer_firstname" class="form-control" value="<?= set_value('customer_firstname', $customer['customer_firstname']) ?>" required>
	                  						<?= form_error('customer_firstname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
										<div class="col-sm-9">
											<input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= set_value('customer_lastname', $customer['customer_lastname']) ?>" required>
	                  						<?= form_error('customer_lastname'); ?>
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-sm-3 col-form-label">Email</label>
										<div class="col-sm-9">
					                    	<input type="text" id="email" name="customer_email" class="form-control" value="<?= set_value('customer_email', $customer['customer_email']) ?>">
					                  		<?= form_error('customer_email'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="telephone" class="col-sm-3 col-form-label">Phone Number</label>
										<div class="col-sm-9">
					                    	<input type="text" id="telephone" name="customer_telephone" class="form-control" value="<?= set_value('customer_telephone', $customer['customer_telephone']) ?>" required>
					                  		<?= form_error('customer_telephone'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="address" class="col-sm-3 col-form-label">Address</label>
										<div class="col-sm-9">
				                            <textarea id="address" name="customer_address" class="form-control"><?= set_value('customer_address', $customer['customer_address']) ?></textarea>
				                            <?= form_error('customer_address'); ?>
										</div>
									</div> 
									<div class="form-group row">
										<label for="country" class="col-sm-3 col-form-label">Country</label>
										<div class="col-sm-9">
	                                        <select id="country" name="customer_country" class="form-control select-country" data-target="state" required>
	                                            <?=select_countries(set_value('customer_country', $customer['customer_country']))?>
	                                        </select>  
					                  		<?= form_error('customer_country'); ?>
										</div>
									</div>  
									<div class="form-group row">
										<label for="state" class="col-sm-3 col-form-label">State</label>
										<div class="col-sm-9">
                                            <select id="state" name="customer_state" class="form-control select-state" data-target="city" required>
                                                <option value="<?=$customer['customer_state']?>" <?= set_select('customer_state', $customer['customer_state'], TRUE) ?>><?=$customer['customer_state'] ?></option>
                                            </select>  
					                  		<?= form_error('customer_state'); ?>
										</div>
									</div> 
									<div class="form-group row">
										<label for="city" class="col-sm-3 col-form-label">City</label>
										<div class="col-sm-9">
                                            <select id="city" name="customer_city" class="form-control select-city" required>
                                                <option value="<?=$customer['customer_city']?>" <?= set_select('customer_city', $customer['customer_city'], TRUE) ?>><?=$customer['customer_city'] ?></option>
                                            </select>   
					                  		<?= form_error('customer_city'); ?>
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
							<?php endif;?>
							
						</div>
					<!-- /.tab-content -->
					</div><!-- /.card-body -->
					<?php elseif ($set_view == 'purchases'):?>  
						<div class="card-body px-0">
				            <table class="table table-striped">
				              	<thead>
					                <tr> 
					                  	<th> Made At </th>
					                  	<th> Items </th>
					                  	<th> Paid </th>
					                  	<th> Bal. </th>
					                  	<?php if (has_privilege('customers') && $statistics['debt']): ?>
					                  	<th class="td-actions"> Actions </th>
					                  	<?php endif; ?>
					                </tr>
				              	</thead>
				              	<tbody>
				                <?php if ($purchases): ?>
					                <?php foreach ($purchases as $purchase): 
					                	$debt = $purchase['order_price']-$purchase['paid'];
					                	?>
						                <tr> 
						                  	<td> <?=$purchase['service_name']?> </td>
						                  	<td> <?=$this->hms_data->explode_sales_items($purchase['order_items'], $purchase['order_quantity'], ', ')?> </td>
						                  	<td id="paid_<?=$purchase['id']?>"> <?=$this->cr_symbol.number_format($purchase['paid'], 2)?> </td>
						                  	<td id="debt_<?=$purchase['id']?>"> <?=$this->cr_symbol.number_format($debt, 2)?> </td> 
						                  	<?php if (has_privilege('customers') && $debt > 0): ?> 
						                  	<td class="td-actions">
							                    <a href="javascript:void(0)" class="btn btn-danger text-white btn-sm update_debt" data-toggle="tooltip" data-id="<?=$purchase['id']?>" data-ref="<?=$customer['customer_TCno']?>" title="Update">
							                      Update
							                    </a>
						                  	</td>
						                  <?php endif; ?>
						                </tr>
					                <?php endforeach; ?>
				                <?php else: ?>
					                <tr>
					                  <td colspan="5" class="text-center"><?php alert_notice('No Purchases', 'info', TRUE, FALSE) ?></td>
					                </tr>
				                <?php endif; ?>
				              	</tbody>
				            </table>
						</div> <!-- /.card-body -->
				        <?php if ($pagination): ?>
							<div class="card-footer mb-0 pb-0"> <?=$pagination?> </div>
				        <?php endif; ?>
					<?php endif;?>
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

<script>
	window.onload = function () {
    	$('.update_debt').click(function(event) { 
    		var item = $(this);
    		var ref  = item.data('ref');
    		var link = siteUrl+'customer/update_debt/';
    		var item_id = item.data('id');
			bootbox.dialog({ 
			    title: 'Update user debt of <span>'+$('#debt_'+item.data('id')).text()+'</span>',
			    message: '<span id="bootbox-message"></span><input class="bootbox-input bootbox-input-number form-control" autocomplete="off" type="number" placeholder="Amount" required="" id="update_amount">',
			    size: 'large',
			    onEscape: true,
			    backdrop: true,
			    buttons: {
			        update: {
			            label: 'Update',
			            className: 'btn-success',
			            callback: function(e){
			            	$(e.target).attr('disabled',true).text('Please Wait...');
			            	var amount = $('#update_amount').val();
			            	$.post(link+'update',{item_id:item_id,amount:amount}, function(data){
			            		$('#bootbox-message').html(data.message);
			            		$('.modal-title span, #debt_'+item_id).html(data.debt);
			            		$('#paid_'+item_id).html(data.paid);
			            		$('#customer_debt').html(data.total_debt);
			            		$(e.target).removeAttr('disabled').text('Update');
			            	})
			            	return false;
			            }
			        },
			        clear: {
			            label: 'Clear Debt',
			            className: 'btn-primary',
			            callback: function(e){
			            	$(e.target).attr('disabled',true).text('Please Wait...');
			            	$.post(link+'clear',{item_id:item_id}, function(data){
			            		$('#bootbox-message').html(data.message);
			            		$('.modal-title span, #debt_'+item_id).html(data.debt);
			            		$('#paid_'+item_id).html(data.paid);
			            		$('#customer_debt').html(data.total_debt);
			            		$(e.target).removeAttr('disabled').text('Clear Debt');
			            	})
			            	return false;
			            }
			        }, 
			        cancel: { label: 'Cancel', className: 'btn-danger', callback: function(d){  } }
			    }
			})
    	});
	}
</script>
