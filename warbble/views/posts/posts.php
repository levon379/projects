<?php $this->view("posts/_nav_tabs", array()) ?>
<div class="container-fluid">
    <div class="admin_section">
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active ">
                <?php $this->view($_tab, $tab_data) ?>
            </div>
        </div>
    </div>
</div>
<!--End Dashboard -->