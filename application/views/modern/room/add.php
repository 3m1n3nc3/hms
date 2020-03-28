<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<!-- /.col-md-6 Important Shortcuts -->
			<div class="col-lg-12"> 

				<?= $this->session->flashdata('message') ?? '' ?>

				<div class="card">
					<div class="card-header">
						<h5 class="m-0">
						<i class="fa fa-bed mx-2 text-gray"></i>
						Add Rooms
						</h5>
					</div>
					<div class="card-body">
						
						<?= form_open('room/add')?>
						<div class="row">
							<div class="col-sm-12">
								<!-- select -->
								<div class="form-group">
									<label>Room Type</label>
									<select id="room_type" name="room_type" class="form-control">
										<?php foreach ($room_types as $k=>$rt): ?>
										<option value="<?=$rt->room_type?>" <?= ($k==0 ? "selected" : '')?>>
											<?=$rt->room_type?>
										</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<!-- text input -->
								<div class="form-group">
									<label>Room Numbered from</label>
									<input type="number" min="1" id="min_id" name="min_id" required class="form-control" placeholder="1">
								</div>
							</div>
							<div class="col-sm-6">
								<!-- text input -->
								<div class="form-group">
									<label>Room Numbered to</label>
									<input type="number" min="1" id="max_id" name="max_id" required class="form-control" placeholder="2">
								</div>
							</div>
						</div> 
						<button class="button btn btn-success">Add</button>
						<?= form_close()?>
						
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
