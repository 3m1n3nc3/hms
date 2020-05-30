<!-- Main content -->
<div class="content">
	<div class="container-fluid">

		<?= $this->session->flashdata('message') ?? '' ?>
		
		<div class="row">
			<!-- /.col-md-8 Important Shortcuts -->
			<div class="col-md-8"> 

				<div class="card">
					<div class="card-header">
						<h5 class="m-0">
						<i class="fa fa-swimmer mx-2 text-gray"></i>
						<?=$sub_page_title?>
						</h5>
					</div>
					<div class="card-body">
						
					<?= form_open('admin/facilities/' . $action . '/' . $facilities['id'] ?? '')?>
						<input type="hidden" name="save_facility" value="1">
						<div class="row">
							<div class="col-md-6">
								<!-- select -->
								<div class="form-group">
									<label>Name</label> 
									<input type="text" name="title" class="form-control" placeholder="Facility Name" value="<?=set_value('title', $facilities['title'])?>" required>
	                  				<?= form_error('title'); ?>
								</div>
							</div>

							<div class="col-md-6">
								<!-- select -->
								<div class="form-group">
									<label>Icon</label> 
									<select name="icon" class="form-control" required>
										<?=pass_icon(1, set_value('icon', $facilities['icon']), TRUE)?>
									</select> 
	                  				<?= form_error('icon'); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<!-- text input -->
								<div class="form-group">
									<label>Description</label>
									<textarea name="details" class="form-control textarea" required><?=set_value('details', decode_html($facilities['details']))?></textarea>
	                  				<?= form_error('details'); ?>
								</div>
							</div> 
						</div> 
						<button class="button btn btn-success"><?=ucwords($action)?></button>
					<?= form_close()?>
					
					</div>
				</div>
			</div>
			<!-- /.col-md-8 -->

			<div class="col-md-4"> 

				<div class="card">
					<div class="card-header">
						<h5 class="m-0">
						<i class="fa fa-swimmer mx-2 text-gray"></i>
						<?=lang('facilities')?> <?=lang('page')?>
						</h5>
					</div>
					<div class="card-body">

					<?= form_open('admin/facilities/add')?>
						<input type="hidden" name="save_home" value="1">
						<div class="form-group">
							<label><?=lang('facilities')?> <?=lang('introduction')?> <?=lang('title')?></label> 
							<input type="text" name="value[facilities_title]" class="form-control" value="<?=set_value('value[facilities_title]', my_config('facilities_title'))?>" required>
              				<?= form_error('value[facilities_title]'); ?>
						</div>
						<div class="form-group">
							<label><?=lang('facilities')?> <?=lang('introduction')?> <?=lang('content')?></label>
							<textarea name="value[facilities_content]" class="form-control" required><?=set_value('value[facilities_content]', my_config('facilities_content'))?></textarea>
              				<?= form_error('value[facilities_content]'); ?>
						</div>
						<button class="button btn btn-success"><?=lang('update')?></button>
					<?= form_close()?>

					</div>
				</div>
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h5 class="card-title"><?= lang('content_image') ?></h5>
					</div>
					<div class="card-body box-profile">
						<div class="text-center mb-3">
							<a href="javascript:void(0)" onclick="modalImageViewer('.profile-user-img')">
								<img class="profile-user-img img-fluid border-gray facility" src="<?= $this->creative_lib->fetch_image($facilities['image']); ?>" alt="...">
							</a>
						</div>
						
						<?php if ($facilities): ?>
						<div id="upload_resize_image" data-endpoint="facility" data-endpoint_id="<?= $facilities['id']; ?>" class="d-none"></div>
						<button type="button" id="upload_resize_image_button" class="btn btn-success btn-block text-white upload_resize_image" data-endpoint="facility" data-endpoint_id="<?= $facilities['id']; ?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button>
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
