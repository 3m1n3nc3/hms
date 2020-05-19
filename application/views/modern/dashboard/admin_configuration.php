      <?php $switch = ($this->input->post() ? 1 : null) ?>
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content">
        <div class="row">
          <div class="col-md-12"> 
            <div class="card">
              <div class="card-header"> 
                <h5 class="float-right card-title text-gray"><?= ucwords($step ? $step . ' ' . lang('configuration') : ''); ?></h5>
                <h5 class="card-title"><i class="text-gray fa fa-cogs"></i> <?=lang('site_configuration'); ?></h5>
     
                <!-- <h7 class="title text-info"></h7> -->
     
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <?= $this->session->flashdata('message'); ?> <?php //echo validation_errors(); ?>
                  </div>
                </div> 

                <div class="collections container">
                            
                  <?php $switch = ($this->input->post() ? 1 : null) ?> 

                  <?= form_open_multipart(uri_string(), ['id' => 'paform', 'class' => 'needs-validation', 'novalidate' => null]); ?>

                    <?php if ($enable_steps && $step === 'main'): ?> 
                    <input type="hidden" name="step" value="main">
                    <label class="font-weight-bold" for="basic_block">Main Configuration</label>
                    <hr class="my-0">
                    <div class="form-row p-3 mb-3" id="basic_block"> 

                      <div class="form-group col-md-6">
                        <label class="text-info" for="site_name">Site Name</label>
                        <input type="text" name="value[site_name]" value="<?= set_value('value[site_name]', my_config('site_name')) ?>" class="form-control" >
                        <small class="text-muted">The name of this website</small>
                        <?= form_error('value[site_name]'); ?>
                      </div>  

                      <div class="form-group col-md-6">
                        <label class="text-info" for="site_name_abbr">Site Name Abbreviation</label>
                        <input type="text" name="value[site_name_abbr]" value="<?= set_value('value[site_name_abbr]', my_config('site_name_abbr')) ?>" class="form-control" >
                        <small class="text-muted">Abbreviation of the Site name</small>
                        <?= form_error('value[site_name_abbr]'); ?>
                      </div>   

                      <div class="form-group col-md-6">
                          <div class="form-group">
                              <label class="text-info" for="country"><?=lang('country')?></label>
                              <select id="country" name="value[site_country]" class="form-control select-country" required>
                                  <?=select_countries(set_value('value[site_country]', my_config('site_country')))?>
                              </select>
                              <small class="text-muted">This will require international visitors to set their nationality and upload a passport </small>
                              <?= form_error('customer_country'); ?>
                          </div>
                      </div>

                      <div class="form-group col-md-6"> 
                          <div class="form-group">
                              <label class="text-info" for="debt-tolerance">Debt Tolerance</label>
                              <select id="debt-tolerance" name="value[debt_tolerance]" class="form-control" required> 
                                  <option value="0" <?= set_select('value[debt_tolerance]', '0', int_bool(my_config('debt_tolerance') == 0))?>>Allow Checkout</option>
                                  <option value="1" <?= set_select('value[debt_tolerance]', '1', int_bool(my_config('debt_tolerance') == 1))?>>Allow checkout on purchase debts</option>
                                  <option value="2" <?= set_select('value[debt_tolerance]', '2', int_bool(my_config('debt_tolerance') == 2))?>>Allow checkout on overstay debts</option>
                                  <option value="3" <?= set_select('value[debt_tolerance]', '3', int_bool(my_config('debt_tolerance') == 3))?>>Block Checkout on all debts</option>
                              </select>
                              <small class="text-muted">Set how debtors will be handled during checkout</small>
                              <?= form_error('customer_country'); ?>
                          </div>
                      </div>

                      <div class="form-group col-md-8">
                        <label class="text-info" for="site_logo">Site Logo</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="site_logo" class="custom-file-input" id="site_logo">
                            <label class="custom-file-label" for="site_logo">Choose file</label>
                          </div> 
                        </div>
                        <small class="text-muted">The logo of this website</small>
                        <?=$this->creative_lib->upload_errors('site_logo', '<span class="text-danger">', '</span>')?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info text-sm" for="logo_preview">Logo Preview</label><br>
                        <img src="<?= $this->creative_lib->fetch_image(my_config('site_logo'), 2); ?>" style="max-height: 50px;" id="logo_preview">
                      </div>

                      <div class="form-group col-md-8">
                        <label class="text-info" for="favicon">Site Favicon</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="favicon" class="custom-file-input" id="favicon">
                            <label class="custom-file-label" for="favicon">Choose file</label>
                          </div> 
                        </div>
                        <small class="text-muted">The favicon of this website</small>
                        <?=$this->creative_lib->upload_errors('favicon', '<span class="text-danger">', '</span>')?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info text-sm" for="logo_preview">Favicon Preview</label><br>
                        <img src="<?= $this->creative_lib->fetch_image(my_config('favicon')); ?>" style="max-height: 50px;" id="logo_preview">
                      </div>

                      <div class="form-group col-md-8">
                        <label class="text-info" for="facilities_banner">Facilities Banner</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="facilities_banner" class="custom-file-input" id="facilities_banner">
                            <label class="custom-file-label" for="facilities_banner">Choose file</label>
                          </div> 
                        </div>
                        <small class="text-muted">Banner shown under the site facilities of the front page</small>
                        <?=$this->creative_lib->upload_errors('facilities_banner', '<span class="text-danger">', '</span>')?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info text-sm" for="facilities_banner">Facilities Banner Preview</label><br>
                        <img src="<?= $this->creative_lib->fetch_image(my_config('facilities_banner')); ?>" style="max-height: 50px;" id="facilities_banner">
                      </div>

                      <div class="form-group col-md-8">
                        <label class="text-info" for="breadcrumb_banner">Breadcrumb Area Banner</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="breadcrumb_banner" class="custom-file-input" id="breadcrumb_banner">
                            <label class="custom-file-label" for="breadcrumb_banner">Choose file</label>
                          </div> 
                        </div>
                        <small class="text-muted">Banner shown under the breadcrumb area of the front page</small>
                        <?=$this->creative_lib->upload_errors('breadcrumb_banner', '<span class="text-danger">', '</span>')?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info text-sm" for="breadcrumb_banner">Breadcrumb Banner Preview</label><br>
                        <img src="<?= $this->creative_lib->fetch_image(my_config('breadcrumb_banner')); ?>" style="max-height: 50px;" id="breadcrumb_banner">
                      </div>

                    </div>
                    <?php endif; ?> 


                    <?php if ($enable_steps &&  $step === 'payment'): ?> 
                    <input type="hidden" name="step" value="payment">
                    <label class="font-weight-bold" for="payment_block">Payment Settings</label>
                    <hr class="my-0">
                    <div class="row p-3 mb-3" id="payment_block"> 
                      <div class="form-group col-md-4">
                        <label class="text-info" for="password">Site Currency</label>
                        <input type="text" name="value[site_currency]" value="<?= set_value('value[site_currency]', my_config('site_currency')) ?>" class="form-control" >
                        <small class="text-muted">The base currency for all purchases originating from this site (E.g USD)</small>
                        <?= form_error('value[site_currency]'); ?>
                      </div>  

                      <div class="form-group col-md-4">
                        <label class="text-info" for="password">Currency Symbol</label>
                        <input type="text" name="value[currency_symbol]" value="<?= set_value('value[currency_symbol]', my_config('currency_symbol')) ?>" class="form-control" >
                        <small class="text-muted">The symbol for the base currency</small>
                        <?= form_error('value[currency_symbol]'); ?>
                      </div>    

                      <div class="form-group col-md-4">
                        <label class="text-info" for="password">Reference Prefix</label>
                        <input type="text" name="value[payment_ref_pref]" value="<?= set_value('value[payment_ref_pref]', my_config('payment_ref_pref')) ?>" class="form-control" >
                        <small class="text-muted">The prefix for generated payment reference</small>
                        <?= form_error('value[payment_ref_pref]'); ?>
                      </div> 

                      <div class="form-group col-md-12">
                        <label class="text-info" for="paystack_public">Paystack Public Key</label>
                        <input type="text" name="value[paystack_public]" value="<?= set_value('value[paystack_public]', my_config('paystack_public')) ?>" class="form-control" > 
                        <?= form_error('value[paystack_public]'); ?>
                      </div>  

                      <div class="form-group col-md-12">
                        <label class="text-info" for="paystack_secret">Paystack Secret Key</label>
                        <input type="text" name="value[paystack_secret]" value="<?= set_value('value[paystack_secret]', my_config('paystack_secret')) ?>" class="form-control" > 
                        <?= form_error('value[paystack_secret]'); ?>
                      </div>

                      <div class="form-group col-md-12">
                        <label class="text-info" for="checkout_info">Checkout Info</label>
                        <textarea name="value[checkout_info]" class="form-control" ><?= set_value('value[checkout_info]', my_config('checkout_info')) ?></textarea>
                        <small class="text-muted">This is shown on the generated invoice for a user purchase</small>
                        <?= form_error('value[checkout_info]'); ?>
                      </div> 
                    </div>
                    <?php endif; ?> 


                    <?php if ($enable_steps &&  $step === 'contact'): ?> 
                    <input type="hidden" name="step" value="contact">
                    <label class="font-weight-bold" for="contact_block">Contact Settings</label>
                    <hr class="my-0">
                    <div class="row p-3 mb-3" id="contact_block"> 
                      <div class="form-group col-md-6">
                        <label class="text-info" for="contact_email"><?=lang('contact').' ' .lang('email_address')?></label>
                        <input type="text" name="value[contact_email]" value="<?= set_value('value[contact_email]', my_config('contact_email')) ?>" class="form-control" >
                        <small class="text-muted">Contact email address for the site</small>
                        <?= form_error('value[contact_email]'); ?>
                      </div>

                      <div class="form-group col-md-6">
                        <label class="text-info" for="contact_phone"><?=lang('contact').' ' .lang('phone')?></label>
                        <input type="text" name="value[contact_phone]" value="<?= set_value('value[contact_phone]', my_config('contact_phone')) ?>" class="form-control" >
                        <small class="text-muted">Contact phone for the site</small>
                        <?= form_error('value[contact_phone]'); ?>
                      </div>

                      <div class="form-group col-md-12">
                        <label class="text-info" for="contact_days"><?=lang('contact').' ' .lang('days')?></label>
                        <input type="text" name="value[contact_days]" value="<?= set_value('value[contact_days]', my_config('contact_days')) ?>" class="form-control" >
                        <small class="text-muted">Days when agents are available to respond to queries (Eg. Mon to Fri 9am to 6 pm)</small>
                        <?= form_error('value[contact_days]'); ?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info" for="contact_facebook"><?=lang('site').' ' .lang('facebook')?></label>
                        <input type="text" name="value[contact_facebook]" value="<?= set_value('value[contact_facebook]', my_config('contact_facebook')) ?>" class="form-control" >
                        <small class="text-muted">Facebook account for the site</small>
                        <?= form_error('value[contact_facebook]'); ?>
                      </div>

                      <div class="form-group col-md-4">
                        <label class="text-info" for="contact_twitter"><?=lang('site').' ' .lang('twitter')?></label>
                        <input type="text" name="value[contact_twitter]" value="<?= set_value('value[contact_twitter]', my_config('contact_twitter')) ?>" class="form-control" >
                        <small class="text-muted">Twitter account for the site</small>
                        <?= form_error('value[contact_twitter]'); ?>
                      </div>

                      <div class="form-group col-md-4"> 
                        <label class="text-info" for="contact_instagram"><?=lang('site').' ' .lang('instagram')?></label>
                        <input type="text" name="value[contact_instagram]" value="<?= set_value('value[contact_instagram]', my_config('contact_instagram')) ?>" class="form-control" >
                        <small class="text-muted">Instagram account for the site</small>
                        <?= form_error('value[contact_instagram]'); ?>
                      </div>

                      <div class="form-group col-md-12">
                        <label class="text-info" for="contact_address"><?=lang('contact').' ' .lang('address')?></label>
                        <textarea name="value[contact_address]" class="form-control" ><?= set_value('value[contact_address]', my_config('contact_address')) ?></textarea>
                        <small class="text-muted">The site's contact or office address</small>
                        <?= form_error('value[contact_address]'); ?>
                      </div> 
                    </div>
                    <?php endif; ?> 


                    <div class="send-button">

                      <button type="submit" class="btn btn-info btn-round btn-sm text-white">Update Configuration</button>

                      <?php if ($step !== 'main'): ?> 
                      <a href="<?= site_url('admin/configuration/main')?>" class="btn btn-danger btn-round btn-sm text-white">
                        <i class="fas fa-home"></i>
                        Main Configuration
                      </a> 
                      <?php endif; ?>

                      <?php if ($step !== 'payment'): ?> 
                      <a href="<?= site_url('admin/configuration/payment')?>" class="btn btn-danger btn-round btn-sm text-white">
                        <i class="fas fa-credit-card"></i>
                        Payment Settings
                      </a> 
                      <?php endif; ?>

                      <?php if ($step !== 'contact'): ?> 
                      <a href="<?= site_url('admin/configuration/contact')?>" class="btn btn-danger btn-round btn-sm text-white">
                        <i class="fas fa-map"></i>
                        Contact Settings
                      </a> 
                      <?php endif; ?>

                      <?php if ($step === 'settings'): ?>  
                      <a href="<?= site_url('contest/create/update/1')?>" class="btn btn-danger btn-round btn-sm text-white">
                        <i class="fas fa-chevron-left"></i>
                        Return
                      </a> 
                      <?php endif; ?>

                    </div>

                  <?= form_close(); ?>  
                </div>

              </div>
            </div> 
          </div>
          
          <!-- Right profile sidebar -->
          <?php //$this->load->view('layout/_right_profile_sidebar') ?> 

        </div>
      </div>
