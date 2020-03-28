<div class="account-container" style="margin: 0 auto;">
	
	<div class="content clearfix">
		
		<?= form_open('customer/add/' . $reference) ?> 
		
			<h1>Add Customer</h1>		
			<?= $this->session->flashdata('message') ?? '' ?> 

			<div class="add-fields">
				
				<div class="field">
					<label for="customer_firstname">First name:</label>
					<input type="text" id="firstname" name="customer_firstname" required value="" placeholder="Firstname"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_lastname">Last name:</label>
					<input type="text" id="lastname" name="customer_lastname" required value="" placeholder="Lastname"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_TCno">TC no:</label>
					<input type="text" id="TCno" name="customer_TCno" required value="" placeholder="Lastname"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_telephone">Telephone:</label>
					<input type="text" id="telephone" name="customer_telephone" value="" placeholder="Telephone"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_email">Email:</label>
					<input type="email" id="email" name="customer_email" required value="" placeholder="Email"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_city">City:</label>
					<input type="text" id="city" name="customer_city" value="" placeholder="City"/>
				</div> <!-- /field -->

				<div class="field">
					<label for="customer_country">Country:</label>
					<input type="text" id="country" name="customer_country" value="" placeholder="Country"/>
				</div> <!-- /field -->

			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<button class="button btn btn-success btn-large">Add</button>
				
			</div> <!-- .actions -->
			
		<?= form_close() ?>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->
<br>
