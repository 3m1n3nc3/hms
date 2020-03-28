        <!-- Main content -->
        <div class="content">
          <div class="container-fluid"> 

            <div class="row"> 

              <!-- /.col-md-6 Important Shortcuts -->
              <div class="col-lg-12">

        				<a href="<?= site_url('room-type/add')?>" class="btn btn-success text-white my-2">
        					<i class="fas fa-plus"></i> Add Room Type
        				</a>

        				<?= $this->session->flashdata('message') ?? '' ?> 

                <div class="card">
                  <div class="card-header">
                    <h5 class="m-0">
                    	<i class="fa fa-bed mx-2 text-gray"></i>
                    	Room Types
                    </h5>
                  </div>
                  <div class="card-body p-1"> 

          					<table class="table table-striped">
          						<thead>
          						  <tr>
          						    <th> Room Type </th>
          						    <th> Price </th>
          						    <th> Details </th>
                          <th> Occupancy </th>
          						    <th> Extra </th>
          						    <th class="td-actions"> Actions </th>
          						  </tr>
          						</thead>
          						<tbody>
          						<?php if ($room_types): ?>
          							<?php foreach ($room_types as $rt): ?>
          							  <tr>
          							    <td> <?=$rt->room_type ?> </td>
          							    <td> <?=$rt->room_price ?>$ </td>
          							    <td> <?=$rt->room_details ?> </td> 
                            <td class="text-gray"> 
                              <i class="fa fa-child"></i><?=$rt->max_kids ?> 
                              <i class="fa fa-user"></i><?=$rt->max_adults ?> 
                            </td>
                            <td class="text-gray"> 
                              <?= $rt->wifi ? '<i title="Free Wifi" class="fa fa-wifi">' : '' ?> 
                              <?= $rt->pool ? '<i title="Pool Services" class="fa fa-swimmer">' : '' ?>  
                              <?= $rt->room_service ? '<i title="Room Services" class="fa fa-handshake">' : '' ?>  
                            </td>
          							    <td class="td-actions"> 
                              <a href="<?= site_url('room-type/edit/'.$rt->room_type)?>" class="btn btn-sm btn-primary">
                                  <i class="btn-icon-only fa fa-edit text-white"></i>
                              </a>
                              <a href="<?= site_url('room-type/delete/'.$rt->room_type)?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm">
                                  <i class="btn-icon-only fa fa-trash text-white"></i>
                              </a>
          							    </td>
          							  </tr>
          							<?php endforeach; ?>
          						<?php else: ?>
          							<tr>
          							    <td colspan="5"><?php alert_notice('No rooms available', 'info', TRUE) ?></td>
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
