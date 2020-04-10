      <?php $switch = ($this->input->post() ? 1 : null); ?>
      
      <div class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header"> 
              <div class="float-right">
                <?php if (!$content['parent'] && $content['safelink']): ?>
                  <?= form_open('admin/create_page'); ?>
                    <input type="hidden" name="parent" value="<?= $content['safelink']; ?>">
                    <button type="submit" class="btn btn-primary text-white mr-1">Link with New Content</button>
                  <?= form_close() ?> 
                <?php endif ?>
              </div>
                <h5 class="card-title">
                  <i class="fa fa-file fa-fw text-gray"></i>
                  <?php 
                    $parent = $parent ?? set_value('parent');
                    $pager = $this->content_model->get(['safelink' => $parent]);  
                  ?>
                  <?= $parent ? 'Create Content for '.$pager['title'] : lang('create_page'); ?>
                </h5>
              </div>

              <?= form_open(uri_string(), ['id' => 'sett_form', 'class' => 'needs-validation', 'novalidate' => null]); ?>
                <div class="card-body">
                  <div class="form-row">
                    <div class="col-md-12">
                      <?= $this->session->flashdata('msg'); ?>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" onkeyup="safeLinker(this)" class="form-control" name="title" placeholder="Title" value="<?= set_value('title', $content['title']); ?>">
                        <?= form_error('title'); ?>
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="safelink">Safelink</label>
                        <input type="text" class="form-control" name="safelink" placeholder="Safelink" value="<?= set_value('safelink', $content['safelink']); ?>">
                        <?= form_error('safelink'); ?>
                      </div>
                    </div> 
                  </div>
                  <div class="form-row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label for="icon">Icon</label> 
                        <select class="form-control" id="icon" name="icon">
                           <?= pass_icon(1, set_value('icon', $content['icon']), TRUE); ?>
                        </select>
                        <?= form_error('icon'); ?>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" name="color" placeholder="Color" value="<?= set_value('color', $content['color']); ?>">
                        <small class="text-primary">Use bootstrap Colors</small>
                        <?= form_error('color'); ?>
                      </div>
                    </div>
 
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="align">Align Items</label>
                        <select class="form-control" id="align" name="align">
                          <option value="left" <?= set_select('align', 'left', int_bool($content['align'] == 'left' ? 1 : 0)) ?>>Left</option> 
                          <option value="right" <?= set_select('align', 'right', int_bool($content['align'] == 'right' ? 1 : 0)) ?>>Right</option>
                        </select>
                      </div>
                    </div> 

                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label for="priority">Priority</label>
                        <select class="form-control" id="priority" name="priority">
                          <option value="1" <?= set_select('priority', '1', int_bool($content['priority'] == '1' ? 1 : 0)) ?>>1</option> 
                          <option value="2" <?= set_select('priority', '2', int_bool($content['priority'] == '2' ? 1 : 0)) ?>>2</option>
                          <option value="3" <?= set_select('priority', '3', int_bool($content['priority'] == '3' ? 1 : 0)) ?>>3</option>
                          <option value="4" <?= set_select('priority', '4', int_bool($content['priority'] == '4' ? 1 : 0)) ?>>4</option>
                          <option value="5" <?= set_select('priority', '5', int_bool($content['priority'] == '5' ? 1 : 0)) ?>>5</option>
                        </select>
                        <?= form_error('priority'); ?>
                      </div> 
                    </div>

                    <?php if (set_value('parent')): ?> 
                      <input type="hidden" name="parent" id="parent" value="<?= set_value('parent') ?>"> 
                    <?php else: ?>
                      <input type="hidden" name="parent" id="parent" value=""> 
                    <?php endif ?>

                    <div class="col-md-12<?php //echo set_value('parent') ? '12' : '6' ?>">
                      <div class="form-group">
                        <label for="button">Button Link</label>
                        <input type="text" class="form-control" name="button" placeholder="Button Link" value="<?= set_value('button', $content['button']); ?>">
                        <?= form_error('button'); ?>
                      </div>
                    </div> 
                    
                    <div class="col-md-12">
                      <label>Button Link Example: </label> <code>[link=https://example.com] Example[/link]</code>
                      <hr class="border-danger">
                    </div>

                    <div class="form-group col-12 m-0 p-0 <?= $content['parent'] || set_value('parent') ? 'd-none' : '';?>">
                      <div class="form-check">
                        <label class="form-check-label mr-5" for="in_footer">
                          <input name="in_footer" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('in_footer', '1', int_bool($content['in_footer'])) ?> id="in_footer">
                          Show in Footer
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label> 

                        <label class="form-check-label mr-5" for="in_header">
                          <input name="in_header" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('in_header', '1', int_bool($content['in_header'])) ?> id="in_header">
                          Show in Header
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>

                        <label class="form-check-label mr-5" for="rooms">
                          <input name="rooms" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('rooms', '1', int_bool($content['rooms'])) ?> id="rooms">
                          Show Rooms
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>

                        <label class="form-check-label mr-5" for="facilities">
                          <input name="facilities" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('facilities', '1', int_bool($content['facilities'])) ?> id="facilities">
                          Show Facilities
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>

                        <label class="form-check-label mr-5" for="booking">
                          <input name="booking" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('booking', '1', int_bool($content['booking'])) ?> id="booking">
                          Show Booking Form
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>

                        <label class="form-check-label mr-5" for="contact">
                          <input name="contact" class="form-check-input text-primary" type="checkbox" value="1"<?= set_checkbox('contact', '1', int_bool($content['contact'])) ?> id="contact">
                          Show Contact Form
                          <span class="form-check-sign">
                            <span class="check"></span>
                          </span>
                        </label>
                      </div>
                    </div>

                    <hr class="border-danger">

                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="intro">Introductory Text</label>
                        <input type="text" class="form-control" name="intro" placeholder="Introductory Text" value="<?= set_value('intro', $content['intro']); ?>">
                        <?= form_error('intro'); ?>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                      <label for="content">Content</label>
                      <textarea class="form-control" id="content" name="content"><?= $content['content']; ?></textarea>
                      <?= form_error('content'); ?>
                    </div>
  
                    <div class="col-md-12">
                      <div>
                        <?php if ($content): ?>
                        <button type="submit" class="btn btn-success">Update Content</button>
                        <?php else: ?>
                        <button type="submit" class="btn btn-success">Create Content</button>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>  
                </div>
              <?= form_close() ?>

            </div>
          </div>
          
          <div class="col-md-4">
            <div class="card card-primary card-outline"> 
              <div class="card-header"> 
                <h5 class="card-title"><?= lang('content_image') ?></h5> 
              </div>
              <div class="card-body box-profile"> 
                <div class="text-center mb-3">
                  <a href="<?//= $link ?>">
                    <img class="profile-user-img img-fluid border-gray" src="<?= $this->creative_lib->fetch_image($content['banner']); ?>" alt="...">
                  </a>
                </div>
                
                <?php if ($content): ?>
                <div id="upload_resize_image" data-endpoint="page" data-endpoint_id="<?= $content['id']; ?>" class="d-none"></div>
                <button type="button" id="upload_resize_image_button" class="btn btn-success btn-block text-white upload_resize_image" data-endpoint="page" data-endpoint_id="<?= $content['id']; ?>" data-toggle="modal" data-target="#uploadModal"><b><?=lang('change_image')?></b></button> 
                <?php else: ?>
                <?php alert_notice(lang('save_to_upload'), 'info', TRUE, 'FLAT') ?>
                <?php endif; ?>

              </div>
            </div>

            <div class="card"> 
              <div class="card-header"> 
                <h5 class="card-title"><?= $children_title ?></h5> 
              </div>
              <div class="card-body px-0"> 

                <ul class="todo-list" data-widget="todo-list">
                <?php if ($children): ?>
                  <?php $i = 0 ?>
                  <?php foreach ($children AS $child): ?>
                  <?php $i++ ?>
                  <li id="item-<?= $child['id']?>">
                    <!-- drag handle -->
                    <span class="handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div  class="icheck-primary d-inline ml-2">
                      <input type="checkbox" value="" name="todo<?= $child['id']?>" id="SortItem-<?= $child['id']?>" disabled <?= $content['id'] === $child['id'] ? ' checked' : ''?>>
                      <label for="todoCheck1"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">
                      <a href="<?= site_url('admin/create_page/edit/'.$child['id'])?>"><?= $child['title'] ?></a>
                    </span> 
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <a href="<?= site_url('admin/create_page/edit/'.$child['id'])?>"><i class="far fa-edit"></i></a>
                      <button class="btn btn-danger text-white m-1 deleter btn-sm" 
                          onclick="deleteItem({type: 'page', action: 1, id: '<?= $child['id'];?>', init: 'list'})">
                          <i class="fa fa-trash fa-fw"></i>
                      </button>
                    </div>
                  </li>     
                  <?php endforeach; ?>
                <?php else: ?>
                <?=alert_notice('This page has no content', 'info')?>
                <?php endif; ?>
                </ul>
                <span id="sort_message"></span>
              </div> 
            </div>
          </div>
          
        </div>
      </div>
  
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
