<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <a href="<?= site_url('customer/add/reservation')?>" class="btn btn-success text-white mb-2">
      <i class="fa fa-plus mx-2"></i>
      <?=lang('add_customer')?>
    </a>

    <?= $this->session->flashdata('message') ?? '' ?>

    <div class="row">
      <!-- /.col-md-4 Important Shortcuts -->
      	<div class="col-lg-12"> 
            
	        <?= form_open('reservation/make')?>

	            <div class="row">

	                <div class="col-sm-3">
	                  <!-- text input -->
	                  <div class="form-group">
	                    <label for="customer_TCno"><?=lang('customer_id_code')?></label>
	                    <input type="text" id="customer_TCno" name="customer_TCno" class="form-control form-control-sm" value="<?= set_value('customer_TCno') ?>" required readonly>
	                  </div>
	                </div>

	                <div class="col-sm-3">
	                  <!-- select -->
	                  <div class="form-group">
	                    <label for="room_type"><?=lang('room_type')?></label>
	                    <input type="text" id="room_type" name="room_type" class="form-control form-control-sm" value="<?= set_value('room_type') ?>" required readonly> 
	                  </div>
	                </div>

	                <div class="col-sm-3">
	                	<div class="row">
		                  	<!-- text input -->
		                  	<div class="form-group col-6">
		                    	<label for="adults"><?=lang('adults')?></label>
		                    	<input type="number" min="1" id="adults" name="adults" class="form-control form-control-sm" value="<?= set_value('adults') ?>" required readonly>
		                  	</div> 

		                  	<!-- text input -->
		                  	<div class="form-group col-6">
		                    	<label for="children"><?=lang('children')?></label>
		                    	<input type="number" min="1" id="children" name="children" class="form-control form-control-sm" value="<?= set_value('children') ?>" required readonly>
		                  	</div>
		                </div>
	                </div>

	                <div class="col-sm-3">
	                	<div class="row">
		                  	<!-- text input -->
		                  	<div class="form-group col-6"> 
		                    	<label for="checkin_date"><?=lang('checkin')?></label>
		                    	<input type="text" id="checkin_date" name="checkin_date" class="form-control form-control-sm" value="<?= set_value('checkin_date') ?>" required readonly>
	                 	 	</div>  

	                  		<!-- text input -->
	                  		<div class="form-group col-6">
	                    		<label for="checkout_date"><?=lang('checkout')?></label>
	                    		<input type="text" id="checkout_date" name="checkout_date" class="form-control form-control-sm" value="<?= set_value('checkout_date') ?>" required readonly>
	                  		</div>
	                	</div>  
	            	</div>
	            </div>
				
		        <div class="card">
		          	<div class="card-header">
		            	<h5 class="m-0">
			            	<i class="fa fa-bed mx-2 text-gray"></i>
			            	<?=lang('available_rooms')?>
		            	</h5>
		          	</div>
		          	<div class="card-body">

					<?php if ($rooms): ?>
						<?php
							$size = count($rooms);
							$cols = ceil(sqrt($size));
							$rows = ceil($size/$cols);
						?>
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="<?=$cols?>"><?=lang('select_a_room')?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($t=0, $i=0; $t<$rows; ++$t): ?>
                                <tr>
                                    <?php for($j=0; $j<$cols && $i<$size; ++$i, ++$j): ?>
                                    <td class="td-actions">
                                        <button name="room_id" value="<?=$rooms[$i]->room_id?>" onclick="return confirm('Reserve this room?')" class="btn btn-lg py-4 m-2 font-weight-bold btn-success shadow">
                                        <?=$rooms[$i]->room_type?>
                                        <br>
                                        Room <?=$rooms[$i]->room_id?>
                                        <i class="btn-icon-only fa fa-calendar-check"> </i>
                                        <br>
                                        <?='At $' . $rooms[$i]->room_price;?>
                                        </button>
                                    </td>
                                    <?php endfor; ?>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
					<?php else: ?>
						<?php alert_notice(lang('no_available_room_message'), 'info', TRUE, 'FLAT') ?>
					<?php endif; ?>

		          	</div>
		        </div>
	        <?= form_close()?>

      		</div>
      		<!-- /.col-md-12 --> 
    	</div>
    	<!-- /.row -->
  	</div><!-- /.container-fluid -->
</div>
<!-- /.content -->
