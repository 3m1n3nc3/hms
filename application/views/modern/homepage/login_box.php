            <div class="container-fluid p-5 mb-5 bg-light">
                <div class="row">
                    <!-- /.col-md-4 Important Shortcuts -->
                    <div class="col-md-12"> 
                    <?php 
                    if (isset($room->room_type)) {
                        alert_notice(sprintf(lang('login_to_book'), $room->room_type), 'info', TRUE, FALSE);
                    }?>
                    </div>
                    <div class="<?=($login_box ?? null) == 'login' ? 'col-md-6' : 'col-md-8' ?> mx-auto"> 

                        <div class="card">
                            <div class="card-header">
                                <h5 class="m-0">
                                <i class="fa fa-user mx-2 text-gray"></i>
                                <?=($login_box ?? null) == 'login' ? lang('account_login') : lang('account_register') ?>
                                </h5>
                            </div>
                            <div class="card-body login-card-body">
    
                                <?= $this->session->flashdata('message') ?> 

                                <?php if (($login_box ?? null) == 'login'):?>

                                    <?= form_open($login_action);?>

                                        <input type="hidden" name="login_form" value="1">

                                        <label class="font-weight-bold" for="username"><?=lang('username')?></label>
                                        <div class="input-group mb-3">
                                            <input type="username" id="username" autocomplete="off" name="username" class="form-control" value="<?= set_value('username', set_value('email')) ?>" placeholder="<?=lang('username_email')?>" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <label class="font-weight-bold" for="password"><?=lang('password')?></label>
                                        <div class="input-group mb-3">
                                            <input type="password" id="password" autocomplete="off" name="password" class="form-control" value="<?= set_value('password') ?>" placeholder="<?=lang('password')?>" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-lock"></span>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="icheck-primary">
                                                    <input type="checkbox" id="remember" name="remember">
                                                    <label for="remember">
                                                        <?=lang('remember_me')?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary btn-block"><?=lang('signin')?></button>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <p class="mb-1">
                                            <a href="<?= site_url('account/login/forgot')?>"><?=lang('forgot_password')?></a>
                                        </p>
                                        <p class="mb-0">
                                            <a href="<?= site_url('account/login/register')?>" class="text-center"><?=lang('register')?></a>
                                        </p>
                                    <?= form_close();?>
                                <?php else: ?>
                                    <?= form_open($login_action);?>

                                        <input type="hidden" id="login_form" name="login_form" value="2">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <label class="font-weight-bold" for="username"><?=lang('username')?></label>
                                                <div class="input-group mb-3">
                                                    <input type="text" id="username" name="customer_username" class="form-control" value="<?= set_value('customer_username') ?>" placeholder="<?=lang('username_email')?>" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-user"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?= form_error('customer_username'); ?>
                                            </div>
                                                
                                            <div class="col-md-6">
                                                <label class="font-weight-bold" for="password"><?=lang('password')?></label>
                                                <div class="input-group mb-3">
                                                    <input type="password" id="password" autocomplete="off" name="customer_password" class="form-control" value="<?= set_value('customer_password') ?>" placeholder="<?=lang('password')?>" required>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text">
                                                            <span class="fas fa-lock"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?= form_error('customer_password'); ?>
                                            </div>
                                                
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold" for="email"><?=lang('email_address')?></label> 
                                                    <input type="email" id="email" name="customer_email" class="form-control" value="<?= set_value('customer_email', ($_SESSION['reservation']['email']??null)) ?>" placeholder="<?=lang('email_address')?>" required> 
                                                    <?= form_error('customer_email');?>
                                                </div>
                                            </div>
                                                
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold" for="phone"><?=lang('phone')?></label>
                                                    <input type="phone" id="phone" name="customer_telephone" class="form-control" placeholder="<?=lang('phone')?>" value="<?= set_value('customer_telephone') ?>" required> 
                                                    <?= form_error('customer_telephone'); ?>
                                                </div>
                                            </div>
                                                
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold" for="firstname"><?=lang('firstname')?></label>
                                                    <input type="text" id="firstname" name="customer_firstname" class="form-control" placeholder="<?=lang('firstname')?>" value="<?= set_value('customer_firstname') ?>" required> 
                                                    <?= form_error('customer_firstname'); ?>
                                                </div>
                                            </div>
                                                
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold" for="lastname"><?=lang('lastname')?></label>
                                                    <input type="text" id="lastname" name="customer_lastname" class="form-control" value="<?= set_value('customer_lastname') ?>" placeholder="<?=lang('lastname')?>" required>  
                                                    <?= form_error('customer_lastname'); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <!-- text input -->
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-bold" for="address"><?=lang('address')?></label>
                                                    <textarea id="address" name="customer_address" class="form-control"><?= set_value('customer_address') ?></textarea>
                                                    <?= form_error('customer_address'); ?>
                                                </div>
                                            </div> 

                                            <div class="col-md-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="select-country"><?=lang('country')?></label>
                                                    <select id="country" name="customer_country" class="form-control select-country" data-target="state" required>
                                                        <?=select_countries(set_value('customer_country'))?>
                                                    </select> 
                                                    <?= form_error('customer_country'); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="state"><?=lang('state')?></label> 
                                                    <select id="state" name="customer_state" class="form-control select-state" data-target="city" required>
                                                        
                                                    </select> 
                                                    <?= form_error('customer_state'); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="city"><?=lang('city')?></label> 
                                                    <select id="city" name="customer_city" class="form-control select-city" required>
                                                        
                                                    </select> 
                                                    <?= form_error('customer_city'); ?>
                                                </div>
                                            </div> 
                  
                                    
                                            <label for="country" class="text-info"><?= sprintlang('for_non_citizens', config_item('site_country'))?> </label>
                                            <div class="col-md-12 border p-3 mb-3">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="nationality"><?=lang('nationality')?></label>
                                                            <select id="nationality" name="customer_nationality" class="form-control" required>
                                                                <?=select_countries(set_value('customer_nationality'), 0, TRUE)?>
                                                            </select>
                                                            <?= form_error('customer_nationality'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label for="passport_no"><?=lang('passport_number')?></label>
                                                            <input type="text" id="passport_no" name="customer_passport_no" class="form-control" value="<?= set_value('customer_passport_no') ?>">
                                                            <?= form_error('customer_passport_no'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?=lang('required_upload_passport', 'passport_no', ['class'=>'text-danger font-weight-light'])?>
                                            </div>


                                            <div class="col-md-12">
                                                <!-- text input -->
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="TCno"><?=lang('customer_id_code')?></label>
                                                    <input type="text" id="TCno" name="customer_TCno" class="form-control" value="<?= $this->enc_lib->generateToken(rand(10,15), 1, 'HRSC-', TRUE) ?>" required readonly>
                                                    <?= form_error('customer_TCno') . lang('you_need_to_note')?> 
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="row">
                                            <div class="col-8">
                                                <div class="icheck-primary">
                                                    <input value="1" type="checkbox" id="remember" name="accept" required>
                                                    <label for="remember">
                                                        <?=lang('read_accepted_terms')?>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary btn-block"><?=lang('signin')?></button>
                                            </div>
                                            <!-- /.col -->
                                        </div>

                                        <p class="mb-1">
                                            <a href="<?= site_url('account/login/forgot')?>"><?=lang('forgot_password')?></a>
                                        </p>
                                        <p class="mb-0">
                                            <a href="<?= site_url('account/login')?>" class="text-center"><?=lang('signin')?></a>
                                        </p>
                                    <?= form_close();?>
                                <?php endif; ?>
                            </div>
                            <!-- /.login-card-body -->
                        </div>

                    </div>
                </div>
            </div>
