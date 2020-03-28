<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <a href="<?= site_url('customer/add/reservation')?>" class="btn btn-success text-white mb-2">
      <i class="fa fa-plus mx-2"></i>
      Add Customer
    </a>

    <?= $this->session->flashdata('message') ?? '' ?>
    <?php $customer_TCno = $this->session->flashdata('customer_TCno') ?? set_value('customer_TCno') ?>

    <div class="row">
      <!-- /.col-md-4 Important Shortcuts -->
      <div class="col-lg-5"> 

        <div class="card">
          <div class="card-header">
            <h5 class="m-0">
            <i class="fa fa-search mx-2 text-gray"></i>
            Search for Rooms
            </h5>
          </div>
          <div class="card-body">
            
            <?= form_open('reservation/check')?> 
              <div class="row">

                <div class="col-sm-12">
                  <!-- text input -->
                  <div class="form-group">
                    <label for="customer_TCno">Customer Identity Code</label>
                    <input type="text" id="customer_TCno" name="customer_TCno" class="form-control" value="<?= $customer_TCno ?>" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <!-- select -->
                  <div class="form-group">
                    <label for="room_type">Room Type</label>
                    <select id="room_type" name="room_type" class="form-control">
                    <?php foreach ($room_types as $k => $rt): ?>
                      <option value="<?=$rt->room_type?>" <?= ($k==0 ? "selected" : '')?>>
                        <?=$rt->room_type?>
                      </option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                    <label for="adults">Number of Adults</label>
                    <input type="number" min="1" id="adults" name="adults" class="form-control" value="<?= set_value('adults') ?>" required>
                  </div>
                </div>

                <div class="col-sm-6">
                  <!-- text input -->
                  <div class="form-group">
                    <label for="children">Number of Children</label>
                    <input type="number" min="1" id="children" name="children" class="form-control" value="<?= set_value('children') ?>" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <!-- text input -->
                  <div class="form-group">
                    <label for="checkin_date">Check-in Date</label>
                    <input type="date" id="checkin_date" name="checkin_date" class="form-control" value="<?= set_value('checkin_date') ?>" required>
                  </div>
                </div>

                <div class="col-sm-12">
                  <!-- text input -->
                  <div class="form-group">
                    <label for="checkout_date">Check-out Date</label>
                    <input type="date" id="checkout_date" name="checkout_date" class="form-control" value="<?= set_value('checkout_date') ?>" required>
                  </div>
                </div>  
              </div>
 
              <button class="button btn btn-success">List Available</button>
            <?= form_close()?>
            
          </div>
        </div>
      </div>
      <!-- /.col-md-5 -->

      <!-- /.col-md-7 Important Shortcuts -->
      <div class="col-lg-7">  
        <div class="card">
          <div class="card-header">
            <h5 class="m-0">
            <i class="fa fa-calendar mx-2 text-gray"></i>
            Booking Calendar
            </h5>
          </div>
          <div class="card-body text-xs">
            <div id='calendar' class='calendar'> </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
