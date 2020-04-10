<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <?= $this->session->flashdata('message') ?? '' ?>
        <div class="row">
            <!-- /.col-md-4 Important Shortcuts -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">
                        <i class="fa fa-user mx-2 text-gray"></i>
                        <?=$action_title?>
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <?= form_open('customer/add/' . $reference . '/update')?>
                        <div class="row">
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="firstname"><?=lang('firstname')?></label>
                                    <input type="text" id="firstname" name="customer_firstname" class="form-control" value="<?= set_value_switch('customer_firstname', $customer['customer_firstname']) ?>" required>
                                    <?= form_error('customer_firstname'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="lastname"><?=lang('lastname')?></label>
                                    <input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= set_value_switch('customer_lastname', $customer['customer_lastname']) ?>" required>
                                    <?= form_error('customer_lastname'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="email"><?=lang('email_address')?></label>
                                    <input type="text" id="email" name="customer_email" class="form-control" value="<?= set_value_switch('customer_email', $customer['customer_email']) ?>">
                                    <?= form_error('customer_email'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="telephone"><?=lang('phone')?></label>
                                    <input type="text" id="telephone" name="customer_telephone" class="form-control" value="<?= set_value_switch('customer_telephone', $customer['customer_telephone']) ?>" required>
                                    <?= form_error('customer_telephone'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="address"><?=lang('address')?></label>
                                    <textarea id="address" name="customer_address" class="form-control"><?= set_value_switch('customer_address', $customer['customer_address']) ?></textarea>
                                    <?= form_error('customer_address'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country"><?=lang('country')?></label>
                                    <select id="country" name="customer_country" class="form-control select-country" data-target="state" required>
                                        <?=select_countries(set_value('customer_country'))?>
                                    </select>
                                    <?= form_error('customer_country'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state"><?=lang('state')?></label>
                                    <select id="state" name="customer_state" class="form-control select-state" data-target="city" required>
                                        <option value="<?=$customer['customer_state']?>" <?= set_select('customer_state', $customer['customer_state'], TRUE) ?>><?=$customer['customer_state'] ?></option>
                                    </select>
                                    <?= form_error('customer_state'); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city"><?=lang('city')?></label>
                                    <select id="city" name="customer_city" class="form-control select-city" required>
                                        <option value="<?=$customer['customer_city']?>" <?= set_select('customer_city', $customer['customer_city'], TRUE) ?>><?=$customer['customer_city'] ?></option>
                                    </select>
                                    <?= form_error('customer_city'); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label for="TCno"><?=lang('customer_id_code')?></label>
                                    <input type="text" id="TCno" name="customer_TCno" class="form-control" value="<?= set_value_switch('customer_TCno', $ref_token) ?>" required readonly>
                                    <?= form_error('customer_TCno'); ?>
                                </div>
                            </div>
                            
                        </div>
                        
                        <button class="button btn btn-success"><?=$action?></button>
                        <?= form_close()?>
                        
                    </div>
                </div>
            </div>
            <!-- /.col-md-12 -->
          
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title"><?= lang('content_image') ?></h5>
                    </div>
                    <div class="card-body box-profile">
                        <div class="text-center mb-3">
                            <a href="<?//= $link ?>">
                                <img class="profile-user-img img-fluid border-gray" src="<?= $this->creative_lib->fetch_image($customer['image'], 3); ?>" alt="...">
                            </a>
                        </div>

                    <?php if ($customer): ?>
                        
                        <div id="upload_resize_image" data-endpoint="customer" data-endpoint_id="<?= $customer['customer_id']; ?>" class="d-none"></div>
                        <button type="button" id="resize_image_button" class="btn btn-success btn-block text-white upload_resize_image" data-type="avatar" data-endpoint="customer" data-endpoint_id="<?= $customer['customer_id'];?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button>

                    <?php else: ?>

                        <?php alert_notice(lang('save_to_upload'), 'info', TRUE, 'FLAT') ?>

                    <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
  
<?php
    $param = array(
        'modal_target' => 'uploadModal',
        'modal_title' => 'Upload Image',
        'modal_size' => 'modal-md',
        'modal_content' => ' 
            <div class="m-0 p-0 text-center" id="upload_loader">
                <div class="loader"><div class="spinner-grow text-warning"></div></div> 
            </div>'
    );
    $this->load->view($this->h_theme.'/modal', $param);
?>
