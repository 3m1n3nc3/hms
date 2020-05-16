<?php if ($notif_list): ?>
    <?php foreach ($notif_list as $notification):?>
        <a href="<?=$notification['url']?>" class="dropdown-item">
            <!-- Notification Start -->
            <div class="media">
                <i class="fas fa-envelope fa-2x mr-2"></i>
                <div class="media-body">
                    <h3 class="dropdown-item-title">
                    <?=$notification['type']?>
                    </h3>
                    <p class="text-sm"><?=$notification['type']?></p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?=timeAgo($notification['time'])?></p>
                </div>
            </div>
            <!-- Notification End -->
        </a>
        <div class="dropdown-divider"></div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="dropdown-item text-center text-info">
        <i class="fas fa-bell-slash fa-5x mr-2"></i>
        <h5 class="text-danger">No Notifications</h5>
    </div>
<?php endif ?>
             
<div class="dropdown-divider"></div>  
<a href="#" class="dropdown-item dropdown-footer">All Notifications</a>
