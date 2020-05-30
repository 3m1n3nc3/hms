<?php if ($customer_notif): ?>
    <?php foreach ($customer_notif as $notification):?>
        <?php $userdata = $this->account_data->fetch($notification['notifier_id'], 1)?>
        <a href="<?=$notification['url']?>" class="dropdown-item">
            <!-- Notification Start -->
            <div class="media">
                <img src="<?= $this->creative_lib->fetch_image($userdata['image'], 3); ?>" alt="User Photo" class="img-size-50 mr-3 img-circle">
                <!-- <i class="fas fa-envelope fa-2x mr-2"></i> -->
                <div class="media-body">
                    <h3 class="dropdown-item-title text-danger">
                        <?=lang($notification['type'])?>
                    </h3>
                    <p class="text-sm">
                        <?=sprintf(lang($notification['type'].'_message'), ucfirst($userdata['customer_username']))?> 
                    </p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?=timeAgo($notification['time'])?></p>
                </div>
            </div>
            <!-- Notification End -->
        </a>
        <div class="dropdown-divider"></div>
    <?php endforeach; ?>
<?php endif ?>

<?php if ($employee_notif): ?>
    <?php foreach ($employee_notif as $notification):?>
        <?php $userdata = $this->account_data->fetch($notification['notifier_id'])?>
        <a href="<?=$notification['url']?>" class="dropdown-item">
            <!-- Notification Start -->
            <div class="media">
                <img src="<?= $this->creative_lib->fetch_image($userdata['image'], 3); ?>" alt="User Photo" class="img-size-50 mr-3 img-circle">
                <!-- <i class="fas fa-envelope fa-2x mr-2"></i> -->
                <div class="media-body">
                    <h3 class="dropdown-item-title text-danger">
                        <?=lang($notification['type'])?>
                    </h3>
                    <p class="text-sm">
                        <?=sprintf(lang($notification['type'].'_message'), $notification['username'])?> 
                    </p>
                </div>
            </div>
            <!-- Notification End -->
        </a>
        <div class="dropdown-divider"></div>
    <?php endforeach; ?>
<?php endif ?>

<?php if (!$employee_notif && !$customer_notif): ?>
    <div class="dropdown-item text-center text-info">
        <i class="fas fa-bell-slash fa-5x mr-2"></i>
        <h5 class="text-danger">No Notifications</h5>
    </div>
<?php endif ?>
             
<div class="dropdown-divider"></div>  
<a href="#" class="dropdown-item dropdown-footer">All Notifications</a>
