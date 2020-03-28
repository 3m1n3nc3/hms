<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
        
	        <a href="javascript:open_form();" class="btn btn-small btn-success">
	        	<i class="btn-icon-only icon-plus"></i>Add Massage Service
	        </a>

	        <br>

			<?= $this->session->flashdata('message') ?? '' ?> 

			<div class="account-container" style="display: none;" id="form">
				<div class="content clearfix">
					<?= form_open('service/massage_room')?>
					
						<div class="add-fields">

							<div class="field">
								<label for="customer">Customer:</label>
								<select name="customer" required>
									<?php foreach ($customers as $customer): ?>
										<option value="<?=$customer->customer_id?>">
											<?=$customer->customer_firstname.' '.$customer->customer_lastname?>
										</option>
									<?php endforeach; ?>
								</select>
							</div> <!-- /restaurant -->

							<div class="field">
								<label for="maage">Massage Room:</label>
								<select name="massage" required>
									<?php foreach ($massageRooms as $massage): ?>
										<option value="<?=$massage->massageroom_id?>">
											<?=$massage->massageroom_details?>
										</option>
									<?php endforeach; ?>
								</select>
							</div> <!-- /restaurant -->
							
							<div class="field">
								<label for="restaurant_checkin_date">Date:</label>
								<input type="date" name="date" required value="" placeholder="Date"/>
							</div> <!-- /date -->

							<div class="field">
								<label for="details">Massage Details:</label>
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

					<?= form_close()?>
				</div>
			</div>

			<hr>

			<a href="/massage_room/add" class="btn btn-small btn-primary">
				<i class="btn-icon-only icon-ok"></i>Add Massage Room
			</a>

			<br><br>

			<table class="table table-striped table-bordered">
				<thead>
				  <tr>
				    <th> Massage Room Opentime </th>
				    <th> Massage Room Closetime </th>
				    <th> Massage Room Details </th>
				    <th class="td-actions", width="100"> Actions </th>
				  </tr>
				</thead>
				<tbody>
				<?php if ($massageRooms): ?>
					<?php foreach ($massageRooms as $massage): ?>
					  <tr>
					    <td> <?=$massage->massageroom_open_time?> </td>
					    <td> <?=$massage->massageroom_close_time?> </td>
					    <td> <?=$massage->massageroom_details?> </td>
					    <td class="td-actions">
					    	<a href="<?= site_url('massage_room/edit/' . $massage->massageroom_id)?>" class="btn btn-small btn-primary">
					    		<i class="btn-icon-only icon-edit"> </i>
					    	</a>

					    	<a href="<?= site_url('massage_room/delete/' . $massage->massageroom_id) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-small">
					    		<i class="btn-icon-only icon-remove"> </i>
					    	</a>
					    </td>
					  </tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr>
					    <td colspan="4"><?php alert_notice('No massage rooms available', 'info', TRUE, FALSE) ?></td>
					</tr>
				<?php endif; ?>
				</tbody>
			</table>
		</div>
	  </div>
	</div>
  </div>
</div>
