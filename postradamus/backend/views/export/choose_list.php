<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->registerJs("
    $('#list_id').on('click', function() {
        $('#list_id_hidden').val($(this).val());
    });
    $('#page_id').on('click', function() {
        $('#page_id_hidden').val($(this).val());
    });
");
?>
        <?php
        $options = [];
        foreach($lists as $id => $list)
        {
            if((int)$list->scheduled_count == 0)
            {
                $options[$list->id] = ['disabled' => 'disabled'];
            }
        }


        $this->registerJs('
function format(page) {
    el = $(page.element);
    if (!el.data("image_url")) return page.text; // optgroup
    return \'<img class=\"select-image\" src=\"\' + el.data("image_url") + \'" />\' + page.text;
}

$("#page_id").select2({
    formatResult: format,
    formatSelection: format,
    placeholder: "(Choose one)",
    escapeMarkup: function(m) { return m; }
});

');

        $pages = $fh->get_user_pages();
        foreach($pages as $page)
        {
            $new_pages[$page->id] = $page->name;
            $data_elements[$page->id] = ['data-image_url' => ($page->cover->source ? $page->cover->source : 'http://placehold.it/25x25')];
        }
        //array_multisort(array_map('strtolower', $new_pages), $new_pages);

        ?>
        <label class="control-label">Step 1: Choose your List</label> <?= Html::dropDownList('list_id', [], $lists, ['prompt' => '', 'class' => 'form-control select2', 'id' => 'list_id', 'options' => $options]) ?>
        <label class="control-label" style="margin-top:15px">Step 2: Choose your Page</label> <?= Html::dropDownList('page_id', [], $new_pages, ['prompt' => '', 'options' => $data_elements, 'class' => 'form-control', 'id' => 'page_id']) ?>
        <label class="control-label" style="margin-top:15px">Step 3: Click the <b>Continue</b> button in your iMacros panel on the left...</label>
        <br /><img src="<?php echo Yii::$app->params['imageUrl']?>macro-help.png" />
    </div>
</div>
<input type="hidden" name="list_id_hidden" id="list_id_hidden" value="" />
<input type="hidden" name="page_id_hidden" id="page_id_hidden" value="" />