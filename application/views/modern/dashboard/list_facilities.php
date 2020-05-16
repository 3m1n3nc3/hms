        <!-- Main content -->
        <div class="content">
          <div class="container-fluid"> 

            <div class="row"> 

              <!-- /.col-md-6 Important Shortcuts -->
              <div class="col-lg-12">

				<a href="<?= site_url('admin/facilities')?>" class="btn btn-success text-white my-2">
					<i class="fas fa-plus"></i> Add Facility
				</a>

				<?= $this->session->flashdata('message') ?? '' ?> 

                <div class="card">
                  <div class="card-header">
                    <h5 class="m-0">
                    	<i class="fa fa-swimmer mx-2 text-gray"></i>
                    	Facilities
                    </h5>
                  </div>
                  <div class="card-body p-1"> 

					<table class="table table-striped">
						<thead>
						  <tr>
                            <th> Icon </th>
						    <th> Name </th>
						    <th> Details </th> 
						    <th class="td-actions"> Actions </th>
						  </tr>
						</thead>
						<tbody>
						<?php if ($facilities): ?>
							<?php foreach ($facilities as $facility): ?>
							  <tr> 
                                <td> <?=pass_icon(4, $facility['icon'])?> </td>
							    <td> <?=$facility['title'] ?> </td>
							    <td> <?=$facility['details'] ?> </td>
							    <td class="td-actions">
							    	<a href="<?= site_url('admin/facilities/edit/'.$facility['id'])?>" class="btn btn-sm btn-primary">
                                        <i class="btn-icon-only fa fa-edit text-white"></i>
                                    </a>
							    	<a href="javascript:void(0)" onclick="return confirmDelete('<?= site_url('admin/facilities/delete/'.$facility['id']
                                    )?>', 1)" class="btn btn-danger btn-sm my-1">
                                        <i class="btn-icon-only fa fa-trash fa-fw text-white"></i>
                                    </a>
							    </td>
							  </tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
							    <td colspan="4" class="text-center"><?php alert_notice('No facilities available', 'info', TRUE, FALSE) ?></td>
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

