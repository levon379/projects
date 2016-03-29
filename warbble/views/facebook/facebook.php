<div id="ajax-content" class="wb-content">
    <!-- Nav tabs -->
    <?php $this->view("posts/_nav_tabs", array()) ?>

    <!-- Tab panes -->
    <div class="tab-content wb-tab-content">
        <div role="tabpanel" class="tab-pane active">
            <?php $this->view($_tab, $tab_data) ?>
        </div>
    </div>
</div>
<!--End Dashboard -->