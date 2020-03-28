        <!-- Main content -->
        <div class="content">
          <div class="container-fluid"> 

            <div class="row"> 

              <!-- /.col-md-6 Important Shortcuts -->
              <div class="col-lg-12">

				<a href="<?= site_url('room/add')?>" class="btn btn-success text-white my-2">
					<i class="fas fa-plus"></i> Add Rooms
				</a>

				<?= $this->session->flashdata('message') ?? '' ?> 

                <div class="card">
                  <div class="card-header">
                    <h5 class="m-0">
                    	<i class="fa fa-bed mx-2 text-gray"></i>
                    	Rooms
                    </h5>
                  </div>
                  <div class="card-body p-1"> 

					<table class="table table-striped">
						<thead>
						  <tr>
						    <th> Room Type </th>
						    <th> Numbered From </th>
						    <th> Numbered To</th>
						    <th> Rooms Count </th>
						    <th class="td-actions"> Actions </th>
						  </tr>
						</thead>
						<tbody>
						<?php if ($rooms): ?>
							<?php foreach ($rooms as $rm): ?>
							  <tr>
							    <td> <?=$rm->room_type ?> </td>
							    <td> <?=$rm->min_id ?> </td>
							    <td> <?=$rm->max_id?> </td>
							    <td> <?=($rm->max_id-$rm->min_id+1) ?> </td>
							    <td class="td-actions">
							    	<a href="<?= site_url('room/edit/'.$rm->room_type.'/'.$rm->min_id)?>/<?=$rm->max_id?>" class="btn btn-sm btn-primary">
                                        <i class="btn-icon-only fa fa-edit text-white"></i>
                                    </a>
							    	<a href="<?= site_url('room/delete/'.$rm->min_id.'/'.$rm->max_id)?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">
                                        <i class="btn-icon-only fa fa-trash text-white"></i>
                                    </a>
							    </td>
							  </tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
							    <td colspan="5"><?php alert_notice('No rooms available', 'info', TRUE, FALSE) ?></td>
							</tr>
						<?php endif; ?>
						</tbody>
					</table>

                  </div>
                </div>  
              </div>
              <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->

