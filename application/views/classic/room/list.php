<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        <div class="span12">
			<a href="<?= site_url('room/add')?>" class="btn btn-small btn-primary">
				<i class="btn-icon-only icon-ok"></i>Add Rooms
			</a>

			<br><br>

			<?= $this->session->flashdata('message') ?? '' ?> 

			<table class="table table-striped table-bordered">
				<thead>
				  <tr>
				    <th> Room Type </th>
				    <th> Min ID </th>
				    <th> Max ID </th>
				    <th> Quantity </th>
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
					    	<a href="/room/edit/<?=$rm->room_type?>/<?=$rm->min_id?>/<?=$rm->max_id?>" class="btn btn-small btn-primary"><i class="btn-icon-only icon-edit"> </i></a>
					    	<a href="/room/delete/<?=$rm->min_id?>/<?=$rm->max_id?>" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-small"><i class="btn-icon-only icon-remove"> </i></a>
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
  </div>
</div>
