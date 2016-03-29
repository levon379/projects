<ul class="nav navbar-nav side-nav side_nav">
    <?php $count=0; foreach($menu as $item): ?>
        <?php if (array_key_exists('submenu', $item)): ?>
            <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
            <li class="dropdown <?php echo $this->is_active($item)? "active": "" ?>">
                <a href="javascript:;" data-toggle="collapse" data-target="#dropdown_<?php echo $count ?>" class="dropdown-toggle">
                    <i class="<?php echo $item['image_class'] ?>"></i>
                    <span class="hidden-xs"><?php echo $item['title'] ?></span>
                </a>
                <ul id="dropdown_<?php echo $count ?>" class="collapse">
                    <?php foreach ($item['submenu'] as $subitem): ?>
                        <?php if(array_key_exists('access', $subitem) && !$current_user->check_permission($subitem['access'])) continue; ?>
                        <?php if(array_key_exists('noaccess', $subitem) && $current_user->check_no_permission($subitem['noaccess'])) continue; ?>
                        <?php if(array_key_exists('show', $subitem) && ($subitem['show'])) continue; ?>
                        <li><a class="" href="<?php echo $subitem['url'] ?>"><i class="<?php echo $subitem['image_class'] ?>"></i>  <?php echo $subitem['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php else: ?>
            <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
            <li class="dropdown <?php echo $this->is_active($item)? "active": "" ?>">
                <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                    <i class="<?php echo $item['image_class'] ?>"></i>
                    <span class="hidden-xs"><?php echo $item['title'] ?></span>
                </a>
            </li>
        <?php endif; ?>
            <?php $count++; ?>
    <?php endforeach; ?>
</ul>