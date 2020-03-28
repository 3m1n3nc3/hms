<div class="account-container" style="margin: 0 auto;">
	
	<div class="content clearfix">

		<form action="/room/edit/<?=$room_range->room_type?>/<?=$room_range->min_id?>/<?=$room_range->max_id?>" method="post">
		
			<h1>Update Rooms</h1>		
			<?= $this->session->flashdata('message') ?? '' ?> 

			<div class="add-fields">

				<div class="field">
					<label for="room_range">Room Type:</label>
					<select id="room_type" name="room_type">
					<?php foreach ($room_types as $rt): ?>
						<option value="<?=$rt->room_type?>" <?= ($rt->room_type==$room_range->room_type ? "selected" : '') ?>>
							<?=$rt->room_type?>
						</option>
					<?php endforeach; ?>
					</select>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="min_id">ID range start:</label>
					<input type="number" min="1" id="min_id" name="min_id" required value="<?=$room_range->min_id?>" placeholder="1"/>
					<i icon="icon-dollar"></i>
				</div> <!-- /field -->

				<div class="field">
					<label for="max_id">ID range end:</label>
					<input type="number" min="1" id="max_id" name="max_id" value="<?=$room_range->max_id?>" placeholder="1"/>
				</div> <!-- /field -->

			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<button class="button btn btn-success btn-large">Save</button>
				
			</div> <!-- .actions -->			
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<br>
