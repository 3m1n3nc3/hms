<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
       		<a href="javascript:open_form();" class="btn btn-small btn-success">
       			<i class="btn-icon-only icon-plus"></i>Register Medical Service
       		</a>

			<?= $this->session->flashdata('message') ?? '' ?> 
			
			<div class="account-container" style="display: none;" id="form">
				<div class="content clearfix">
					<?= form_open('service/sport_facility')?>
					
						<div class="add-fields">

							<div class="field">
								<label for="customer">Customer:</label>
								<select name="customer" required>
									<?php foreach ($customers as $customer): ?>
										<option value="<?=$customer->customer_id ?>">
											<?= $customer->customer_firstname.' '.$customer->customer_lastname ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div> <!-- /restaurant -->

							<div class="field">
								<label for="maage">Medical Service:</label>
								<select name="sport" required>
									<?php foreach ($medicalServices as $medic): ?>
										<option value="<?= $medic->medicalservice_id ?>">
											<?=$medic->medicalservice_details ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div> <!-- /restaurant -->
							
							<div class="field">
								<label for="restaurant_checkin_date">Date:</label>
								<input type="date" name="date" required value="" placeholder="Date"/>
							</div> <!-- /date -->

							<div class="field">
								<label for="details">Medical Service Details:</label>
								<input type="text" name="details" placeholder="Details" /> 
							</div> <!-- /field -->

							<div class="field">
								<label for="price">Total Price:</label>
								<input type="text" name="price" required value="" placeholder="Total Price"/> 
							</div> <!-- /field -->

						</div> <!-- /login-fields -->
						
						<div class="login-actions">
							
							<button class="button btn btn-success btn-large">Add</button>
							
						</div> <!-- .actions -->
						
					<?= form_close() ?>
				</div>
			</div>
			<hr>
			<a href="/medical_service/add" class="btn btn-small btn-primary"><i class="btn-icon-only icon-ok"></i>Add Medical Services</a>
			<br><br>
			<table class="table table-striped table-bordered">
				<thead>
				  <tr>
				    <th> Medical Service Opentime </th>
				    <th> Medical Service Closetime </th>
				    <th> Medical Service Details </th>
				    <th class="td-actions", width="100"> Actions </th>
				  </tr>
				</thead>
				<tbody>
				<?php if ($medicalServices): ?>
					<?php foreach ($medicalServices as $medServ): ?>
					  <tr>
					    <td> <?=$medServ->medicalservice_open_time?> </td>
					    <td> <?=$medServ->medicalservice_close_time?> </td>
					    <td> <?=$medServ->medicalservice_details?> </td>
					    <td class="td-actions">
					    	<a href="<?= site_url('medical_service/edit/'.$medServ->medicalservice_id)?>" class="btn btn-small btn-primary"><i class="btn-icon-only icon-edit"> </i>
					    	</a>
					    	<a href="<?= site_url('medical_service/delete/'.$medServ->medicalservice_id)?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-small">
					    		<i class="btn-icon-only icon-remove"> </i>
					    	</a>
					    </td>
					  </tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
					    <td colspan="4"><?php alert_notice('No medical services available', 'info', TRUE, FALSE) ?></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	  </div>
	</div>
  </div>
</div>
