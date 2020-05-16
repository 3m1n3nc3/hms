		<?php if ($invoice_id): ?>
			<?php 
				$date = $date??date('Y/m/d', strtotime('NOW'));
				if (isset($variables)) {
					foreach ($variables as $key => $value) {
						${$key} = $value;
					}
				}
				?>
			<div class="row <?= $margin??'mr-4'?>">
				<div class="col-<?= $width??'12'?>"> 
					<div class="container border p-0 m-5">
						<!-- Main content -->
						<div class="invoice p-3 m-3">
							<!-- title row -->
							<div class="row">
								<div class="col-12">
									<h4>
									<img src="<?php echo $this->creative_lib->fetch_image(my_config('site_logo')) ?>" alt="<?php echo my_config('site_name') ?> Logo" class="elevation-3" style="opacity: .8; max-height: 50px;">
		 							<?php echo my_config('site_name'); ?>
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
										<strong><?= $customer_name??'N/A'; ?></strong><br>
										<?= $customer_addr??'N/A' ?>
									</address>
								</div>
								<!-- /.col -->
								<div class="col-sm-4 invoice-col">
									<b class="text-info">Invoice #<?= $invoice_no ?? (date('ymdHms', strtotime($date)) ?? date('ymdHms')) ?></b><br>
									<br>
									<b class="text-info">Order ID:</b> <?= $invoice_id ?><br>
									<b class="text-info">Payment <?= $invoice_id == 'pending' ? 'Due' : 'Date' ?>:</b> <?= $date?><br>
									<b class="text-info">Account ID:</b> <?= $customer_id??'N/A'; ?>
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
												<td><?= $qty ?? '1' ?></td>
												<td><?= $item??'N/A'?></td>
												<td><?= $reference??'N/A' ?></td>
												<td><?= $description??'N/A' ?></td>
												<td><?= $this->cr_symbol.number_format(($amount ?? 0), 2) ?></td>
											</tr> 
										</tbody>
									</table>
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							<div class="row">
								<!-- accepted payments column -->
								<?php if($invoice_id == 'pending'): ?>
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
								<?php endif; ?> 
								<!-- /.col -->
								<div class="col-6">
									<p class="lead">Amount <?= $invoice_id == 'pending' ? 'Due' : 'Paid' ?> <?= $date ?></p>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th style="width:50%">Subtotal:</th>
												<td><?= $this->cr_symbol.number_format(($amount ?? 0), 2) ?></td>
											</tr>
											<tr>
												<th>
													Vat (<?= ($vat??0) ?>%)
												</th>
												<td>
													<?= $this->cr_symbol.number_format(($amount ?? 0)*($vat??0)/100, 2) ?> 
												</td>
											</tr> 
											<tr>
												<th>Total:</th>
												<td><?= $this->cr_symbol.(number_format((($amount ?? 0)*($vat??0)/100)+($amount ?? 0), 2)) ?></td>
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
										
								<?php if($invoice_id == 'pending'): ?>
									<button type="submit" name="pay" id="paybtn" class="btn btn-success float-right">
										<i class="far fa-credit-card"></i> Pay Now 
									</button>   
								<?php endif; ?>
 
								<?php if (!empty($action) && stripos('-post', $action) !== null): ?>
									<?= form_open(str_ireplace('-post', '', $action))?>
										<input type="hidden" name="print" value="<?= $invoice_type??''?>">
										<button class="btn btn-default"><i class="fas fa-print"></i> Print</button>
									<?= form_close()?>
								<?php else: ?>
									<a href="<?php echo $action ? $action : site_url('homepage/invoice/'.($reference??'').'/?print=true') ?>" target="_blank" class="btn btn-default">
										<i class="fas fa-print"></i> Print
									</a> 
								<?php endif ?>

								</div>
							</div>
						</div> 
						<!-- /.invoice --> 
					</div>
					
				</div>
			</div>

			<?php 
				if($invoice_id == 'pending' && isset($post)) {  
					echo $this->hms_payments->payment_processor_loader('paystack', 
						['post' => $post, 'customer' => $customer, 'room' => $room]
					);
				} 
			?>


			<?php if($this->input->get('print') OR $this->input->post('print')): ?>
			    <script type="text/javascript">
			      window.addEventListener("load", window.print());
			    </script>
			<?php endif; ?>
			
	
			<?php if(isset($show_footer)): ?>

				    <!-- jQuery -->
				    <script src="<?= base_url('backend/modern/plugins/jquery/jquery.min.js'); ?>"></script> 
				</body>
			</html>
			<?php endif; ?>
		<?php endif;?>
