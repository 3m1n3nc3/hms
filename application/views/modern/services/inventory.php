    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <a href="<?= site_url('services/add_inventory')?>" class="btn btn-success text-white my-2">
              <i class="fas fa-plus"></i> Add Item
            </a> 

            <?= $this->session->flashdata('message') ?? '' ?>
		  </div>

          <!-- /.col-md-12 Important Shortcuts -->
 
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <strong class="m-0 p-0">
                  <i class="fa fa-store mx-2 text-gray"></i>
                  Inventory
                </strong>
                <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                  <?//= $pagination ?>
                </div>
              </div>
              <div class="card-body p-1">
                <table class="table table-striped">
                  <thead>
                    <tr>
					    <th> Item </th>
					    <th> Available Quantity </th>
					    <th> Price (Per Item) </th>
					    <th> Sales Service </th>
					    <th> Date Added </th>
                      <th class="td-actions"> Actions </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($inventory): ?>
                    <?php foreach ($inventory as $item): ?>
                    <tr> 
					    <td> <?=$item['item_name'] ?> </td>
					    <td> <?=$item['item_quantity'] ?> </td>
					    <td> <?=$item['item_price'] ?> </td>
                        <td> <?=$item['item_service'] ?> </td> 
					    <td> <?=date('Y-m-d', strtotime($item['item_add_date'])) ?> </td> 
                        <td class="td-actions">
                            <a href="<?= site_url('services/inventory/'.$item['item_id']) ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                                <i class="btn-icon-only fa fa-edit text-white"></i>
                            </a>
                            <a href="<?= site_url('services/delete_inventory/'.$item['item_id']) ?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                                <i class="btn-icon-only fa fa-trash text-white"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
					<?php else: ?>
						<tr>
						    <td colspan="6"><?php alert_notice('No inventory items available', 'info', TRUE) ?></td>
						</tr>
					<?php endif;?>
                  </tbody>
                </table>
              </div>
            </div>
            
            <?= $pagination ?>

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
