<div class="container-fluid">
    <div class="admin_section">
        <ul class="nav nav-tabs tab_admin">
            <li class="<?php echo $_SERVER['REQUEST_URI'] == '/Posts/index' ? "active" : "" ?>" ><a href="/Posts/index">Posts</a></li>
            <li class="<?php echo $_SERVER['REQUEST_URI'] == '/twitter/activity' ? "active" : "" ?>" ><a  href="/twitter/activity">Twitter</a></li>
            <li class="<?php echo $_SERVER['REQUEST_URI'] == '/facebook/activity' ? "active" : "" ?>" ><a  href="/facebook/activity">Facebook</a></li>
            <li class="<?php echo $_SERVER['REQUEST_URI'] == '/blogger/activity' ? "active" : "" ?>" ><a  href="/blogger/activity">Blogger</a></li>
        </ul>
    </div>
</div>
</div>