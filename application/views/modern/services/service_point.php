    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"> 
                    <?= $this->session->flashdata('message') ?? '' ?>
                </div>

                <!-- /.col-md-12 Important Shortcuts -->

                <div class="col-lg-12" id="form">
                    <div class="card">
                        <div class="card-header">
                            <strong class="m-0 p-0">
                            <i class="fa fa-plus mx-2 text-gray"></i>
                            Sell Service
                            </strong>
                            <div class="float-right d-none d-sm-inline text-sm my-0 p-0">
                                <?//= $pagination ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= form_open('services/sale') ?>
                            <div class="row">
                                <input type="hidden" id="last_item_id" value="">
                                <input type="hidden" id="service" name="service" class="form-control" value="<?= $service->service_name ?? '';?>" required>

                                <div class="col-md-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="customer">Customer</label>
                                        <select id="customer" name="customer" class="form-control" required>
                                            <option value="0">Generic Customer (Unregistered)</option>
                                            <?php foreach ($customers as $customer): ?>
                                            <option value="<?= $customer->customer_id ?>">
                                                <?= $customer->customer_firstname.' '.$customer->customer_lastname?>
                                            </option>
                                            <?php endforeach;?>
                                        </select>
                                        <?= form_error('customer'); ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" id="date" name="date" class="form-control" value="<?= set_value('date') ?>" required>
                                        <?= form_error('date'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label for="price">Total Price</label>
                                        <input type="price" id="price" name="price" class="form-control" value="<?= set_value('price') ?>" readonly required>
                                        <?= form_error('price'); ?>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#stockitems-modal">
                                Choose Items
                                </button>
                                <?php
                                $param = array(
                                'modal_target' => 'stockitems-modal',
                                'modal_title' => 'Choose Items to Buy',
                                'modal_content' => '
                                <div class="col-md-12">
                                    <div class="row p-2" id="stock_item">
                                        <div class="col-12">'.alert_notice('This store has no items on stock', 'error', FALSE, FALSE).'</div>
                                    </div>
                                </div>'
                                );
                                echo $this->load->view($this->h_theme.'/modal', $param, TRUE);
                                ?>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(){
            fetch_stock(1);
        });
    </script>
