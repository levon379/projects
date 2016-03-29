<table class="table">
    <tr>
        <?php foreach ($columns as $column): ?>
            <th><?php echo $column['title'] ?></th>
        <?php endforeach; ?>
    </tr>
    <?php if(!empty($models)): ?>
        <?php foreach ($models as $model): ?>
            <tr>
                <?php foreach ($columns as $column): ?>
                    <?php if(array_key_exists('filter', $column) && is_callable($column['filter'])): ?>
                        <td><?php echo $column['filter']($model) ?></td>
                    <?php else: ?>
                        <td><?php echo $model->$column['name'] ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="<?php echo count($columns) ?>">No Items</td>
        </tr>
    <?php endif; ?>
</table>

<?php if($pagination['total_pages'] > 1): ?>
    <div class="gridview-pagination pagination-<?php echo "ajax_$model_name" ?>" class="pull-right"></div>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function(){
        <?php echo "gridview_{$model_name}" ?> = new OGridview({
            page: '<?php echo $pagination['current_page'] ?>',
            total: '<?php echo $pagination['total_pages'] ?>',
            selector: '<?php echo $css_class ?>',
            action: '<?php echo "ajax_$model_name" ?>',
        });
    })
</script>
