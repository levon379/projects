<div class="panel panel-gridview panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading"><?php echo $table_name ?></div>
    <div class="panel-body <?php echo $css_class ?>" data-action="<?php echo "ajax_$model_name" ?>">
        <!-- Table -->
        <?php $this->view('_table', $this->config) ?>
        <!-- /Table -->
    </div>

</div>