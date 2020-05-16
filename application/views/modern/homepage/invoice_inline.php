			<?php if ($post['invoice_id']): ?>
			<div class="container border p-0 m-5">
				<div class="row">
					<div class="col-12"> 
						<!-- Main content -->
						<div class="invoice p-3 m-3">
							<!-- title row -->
							<div class="row">
								<div class="col-12">
									<h4>
									<img src="<?php echo $this->creative_lib->fetch_image($this->my_config->item('site_logo')) ?>" alt="<?php echo $this->my_config->item('site_name') ?> Logo" class="elevation-3" style="opacity: .8; max-height: 50px;">
		 							<?php echo $this->my_config->item('site_name'); ?>
									<small class="float-right">Date: <?= date('Y/m/d', strtotime('NOW')) ?></small>
									</h4>
								</div>
								<!-- /.col -->
							</div>
							<!-- info row -->
							<div class="row">
								<div class="col-sm-4 invoice-col">
									From
									<address>
										<strong><?= my_config('site_name'); ?></strong><br>
										<?= my_config('contact_address'); ?>
									</address>
								</div>
								<!-- /.col -->
								<div class="col-sm-4 invoice-col">
									To
									<address>
										<strong><?= $customer['name']; ?></strong><br>
										<?= $customer['customer_address']??'' ?>
									</address>
								</div>
								<!-- /.col -->
								<div class="col-sm-4 invoice-col">
									<b class="text-info">Invoice #<?= $post['invoice'] ?? $post['room_id'].date('ymdHm') ?></b><br>
									<br>
									<b class="text-info">Order ID:</b> <?= $post['invoice_id'] ?><br>
									<b class="text-info">Payment <?= $post['invoice_id'] == 'pending' ? 'Due' : 'Date' ?>:</b> <?= $post['date']?><br>
									<b class="text-info">Account ID:</b> <?= $customer['customer_id']; ?>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							<!-- Table row -->
							<div class="row">
								<div class="col-12 table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>Qty</th>
												<th>Item</th>
												<th>Reference #</th>
												<th>Description</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td><?= ($post['room_type'] ?? $post['room_type']) . ' Room ' . $post['room_id']?></td>
												<td><?= $post['payment_ref'] ?></td>
												<td><?= $post['description'] ?></td>
												<td><?= $this->cr_symbol.number_format(($post['amount'] ?? $room[0]->room_price), 2) ?></td>
											</tr> 
										</tbody>
									</table>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							<div class="row">
								<!-- accepted payments column -->
								<div class="col-6 no-print">
									<p class="lead">Payment Methods:</p>
									<img src="<?php echo base_url('backend/img/credit/visa.png') ?>" alt="Visa">
									<img src="<?php echo base_url('backend/img/credit/mastercard.png') ?>" alt="Mastercard">
									<img src="<?php echo base_url('backend/img/credit/paystack.png') ?>" alt="American Express"> 
									<?php if ($this->my_config->item('checkout_info')): ?>
										<p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
											<?php echo $this->my_config->item('checkout_info'); ?>
										</p>
									<?php endif; ?> 
								</div>
								<!-- /.col -->
								<div class="col-6">
									<p class="lead">Amount <?= $post['invoice_id'] == 'pending' ? 'Due' : 'Paid' ?> <?= $post['date'] ?></p>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th style="width:50%">Subtotal:</th>
												<td><?= $this->cr_symbol.number_format(($post['amount'] ?? $room[0]->room_price), 2) ?></td>
											</tr>
											<tr>
												<th>
													Vat (<?= $room[0]->vat ?>%)
												</th>
												<td>
													<?= $this->cr_symbol.number_format(($post['amount'] ?? $room[0]->room_price)*$room[0]->vat/100, 2) ?> 
												</td>
											</tr> 
											<tr>
												<th>Total:</th>
												<td><?= $this->cr_symbol.(number_format((($post['amount'] ?? $room[0]->room_price)*$room[0]->vat/100)+($post['amount'] ?? $room[0]->room_price), 2)) ?></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							<!-- this row will not appear when printing -->
							<div class="row no-print">

								<div class="col-12"> 
										
								<?php if($post['invoice_id'] == 'pending'): ?>
									<button type="submit" name="pay" id="paybtn" class="btn btn-success float-right">
										<i class="far fa-credit-card"></i> Pay Now 
									</button>   
								<?php endif; ?>
								<?php $p_page = isset($p_page) ? $p_page.'/' : 'homepage/'?>

									<a href="<?php echo $action ?? site_url($p_page.'invoice/'.$post['payment_ref'].'/?print=true') ?>" target="_blank" class="btn btn-default">
										<i class="fas fa-print"></i> Print
									</a>

								</div>
							</div>
						</div>
						<!-- /.invoice --> 
					</div>
					
				</div>
			</div>

			<?php if($post['invoice_id'] == 'pending'):?>
				<?=$this->hms_payments->payment_processor_loader(
					'paystack', ['post' => $post, 'customer' => $customer, 'room' => $room]
				)?>
			<?php endif; ?>
			
	
	<?php if(isset($show_footer)): ?>

		<?php if($this->input->get('print')): ?>
		    <script type="text/javascript">
		      window.addEventListener("load", window.print());
		    </script>
		<?php endif; ?>

		    <!-- jQuery -->
		    <script src="<?= base_url('backend/modern/plugins/jquery/jquery.min.js'); ?>"></script> 
		</body>
	</html>
	<?php endif; ?>
<?php endif;?>
