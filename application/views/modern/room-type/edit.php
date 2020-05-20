<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<!-- /.col-md-6 Important Shortcuts -->
			<div class="col-md-8"> 

				<?= $this->session->flashdata('message') ?? '' ?>

				<div class="card">
					<div class="card-header">
						<h5 class="m-0">
						<i class="fa fa-bed mx-2 text-gray"></i>
						Update Room Type
						</h5>
					</div>
					<div class="card-body">
						
						<?= form_open('room-type/edit/'.$room_type['room_type'])?> 
							<div class="row">
								<div class="col-sm-12">
									<!-- text input -->
									<div class="form-group">
										<label>Room Type</label>
										<input type="text" id="type" name="type" required placeholder="Room Type" class="form-control" value="<?=$room_type['room_type']?>">
									</div>
								</div>
								<div class="col-sm-12">
									<!-- text input -->
									<div class="form-group">
										<label>Price</label>
										<input type="number" min="1" id="price" name="price" required placeholder="Price" class="form-control" value="<?=$room_type['room_price']?>">
									</div>
								</div> 
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>Maximum Occupancy (Adults)</label>
										<input type="number" min="1" id="max_adults" name="max_adults" required placeholder="Maximum Occupance (Adults)" class="form-control" value="<?=$room_type['max_adults']?>">
									</div>
								</div> 
								<div class="col-sm-6">
									<!-- text input -->
									<div class="form-group">
										<label>Maximum Occupancy (Children)</label>
										<input type="number" min="1" id="max_kids" name="max_kids" required placeholder="Maximum Occupance (Children)" class="form-control" value="<?=$room_type['max_kids']?>">
									</div>
								</div> 
								<div class="col-sm-12">
									<!-- text input -->
									<div class="form-group">
										<label>Details</label>
										<textarea id="details" name="details" class="form-control textarea" rows="3" placeholder="Details" required=""><?=decode_html($room_type['room_details'])?></textarea>
									</div>
								</div> 
							</div>

							<div class="row">
								<div class="col-sm-12">

									<label>Included Amenities</label>

									<!-- checkbox -->
									<div class="form-group d-flex">
										<div class="form-check mx-auto">
											<input name="wifi" class="form-check-input" type="checkbox" value="1"<?= set_checkbox('wifi', 1, int_bool($room_type['wifi']))?>>
											<label class="form-check-label">Free Wifi</label>
										</div>

										<div class="form-check mx-auto">
											<input name="pool" class="form-check-input" type="checkbox" value="1"<?= set_checkbox('pool', 1, int_bool($room_type['pool']))?>>
											<label class="form-check-label">Swimming Pool</label>
										</div>

										<div class="form-check mx-auto">
											<input name="service" class="form-check-input" type="checkbox" value="1"<?= set_checkbox('room_service', 1, int_bool($room_type['room_service']))?>>
											<label class="form-check-label">Room Service</label>
										</div>
									</div>
								</div>
							</div>
							<button class="button btn btn-success">Update</button>
						<?= form_close()?>
						
					</div>
				</div>
			</div>
			<!-- /.col-md-6 -->
          
			<div class="col-md-4">
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h5 class="card-title"><?= lang('content_image') ?></h5>
					</div>
					<div class="card-body box-profile">
						<div class="text-center mb-3">
							<a href="<?//= $link ?>">
								<img class="profile-user-img img-fluid border-gray room" src="<?= $this->creative_lib->fetch_image($room_type['image']); ?>" alt="...">
							</a>
						</div>
						
						<?php if ($room_type): ?>
						<div id="upload_resize_image" data-endpoint="room" data-endpoint_id="<?= $room_type['id']; ?>" class="d-none"></div>
						<button type="button" id="upload_resize_image_button" class="btn btn-success btn-block text-white upload_resize_image" data-endpoint="room" data-endpoint_id="<?= $room_type['room_type']; ?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button>
						<?php else: ?>
						<?php alert_notice(lang('save_to_upload'), 'info', TRUE, 'FLAT') ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
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
