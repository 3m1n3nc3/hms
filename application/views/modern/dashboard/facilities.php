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
									<textarea name="details" class="form-control" required><?=set_value('details', $facilities['details'])?></textarea>
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
			</div>

		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
