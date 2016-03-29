<nav class="navbar-collapse bs-navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
    <ul>
        <?php foreach($menu as $item): ?>
            <?php if (array_key_exists('submenu', $item)): ?>
                <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
                <li class="item <?php echo $this->is_active($item)? "active": "" ?>">
                    <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                        <span><?php echo $item['title'] ?></span>
                    </a>
                </li>
                <?php foreach ($item['submenu'] as $subitem): ?>
                    <?php if(array_key_exists('access', $subitem) && !$current_user->check_permission($subitem['access'])) continue; ?>
                    <?php if(array_key_exists('noaccess', $subitem) && $current_user->check_no_permission($subitem['noaccess'])) continue; ?>
                    <?php if(array_key_exists('show', $subitem) && ($subitem['show'])) continue; ?>
                    <li class="sub-item"><a class="" href="<?php echo $subitem['url'] ?>"><?php echo $subitem['title'] ?></a></li>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
                <li class="item <?php echo $this->is_active($item)? "active": "" ?>">
                    <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                        <span><?php echo $item['title'] ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
<?php /*
<div class="mobile-menu">
    <div class="btn-menu">
        <i class="fa fa-bars"></i>
    </div>
    <ul class="nav hidden">
        <?php foreach($menu as $item): ?>
            <?php if (array_key_exists('submenu', $item)): ?>
                <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
                <li class="item <?php echo $this->is_active($item)? "active": "" ?>">
                    <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                        <span><?php echo $item['title'] ?></span>
                    </a>
                </li>
                <?php foreach ($item['submenu'] as $subitem): ?>
                    <?php if(array_key_exists('access', $subitem) && !$current_user->check_permission($subitem['access'])) continue; ?>
                    <li class="sub-item"><a class="" href="<?php echo $subitem['url'] ?>"><?php echo $subitem['title'] ?></a></li>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if(array_key_exists('access', $item) && !$current_user->check_permission($item['access'])) continue; ?>
                <li class="item <?php echo $this->is_active($item)? "active": "" ?>">
                    <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                        <span><?php echo $item['title'] ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>