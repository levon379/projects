<ul class="nav main-menu">
    <?php foreach($menu as $item): ?>
        <?php if (array_key_exists('submenu', $item)): ?>
            <li class="dropdown <?php echo $this->is_active($item)? "active": "" ?>">
                <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                    <i class="<?php echo $item['image_class'] ?>"></i>
                    <span class="hidden-xs"><?php echo $item['title'] ?></span>
                </a>
                <ul class="dropdown-menu">
                    <?php foreach ($item['submenu'] as $subitem): ?>
                        <li><a class="" href="<?php echo $subitem['url'] ?>"><?php echo $subitem['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php else: ?>
            <li class="dropdown <?php echo $this->is_active($item)? "active": "" ?>">
                <a href="<?php echo $item['url'] ?>" class="dropdown-toggle">
                    <i class="<?php echo $item['image_class'] ?>"></i>
                    <span class="hidden-xs"><?php echo $item['title'] ?></span>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>