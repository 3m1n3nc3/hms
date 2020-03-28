<div class="account-container" style="margin: 0 auto;">
	
	<div class="content clearfix">
		
		<form action="/room/add" method="post">
		
			<h1>Add Rooms</h1>		
			<?= $this->session->flashdata('message') ?? '' ?> 

			<div class="add-fields">

				<div class="field">
					<label for="room_range">Room Type:</label>
					<select id="room_type" name="room_type">
					<?php foreach ($room_types as $k=>$rt): ?>
						<option value="<?=$rt->room_type?>" <?= ($k==0 ? "selected" : '')?>>
							<?=$rt->room_type?>
						</option>
					<?php endforeach; ?>
					</select>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="min_id">ID range start:</label>
					<input type="number" min="1" id="min_id" name="min_id" required value="" placeholder="-"/>
					<i icon="icon-dollar"></i>
				</div> <!-- /field -->

				<div class="field">
					<label for="max_id">ID range end:</label>
					<input type="number" min="1" id="max_id" name="max_id" value="" placeholder="-"/>
				</div> <!-- /field -->

			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<button class="button btn btn-success btn-large">Add</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<br>
