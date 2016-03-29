<ul class="list-group sortable_list" id="todo_list_<?=$list_id?>_items">
<?php foreach($tasks as $task): ?>
    <li id="row_task_item_<?=$task->id?>" class="no-borders list-group-item list-container" data-id="toolbar_task_item_<?=$task->id?>">
        <table class="table table-condensed table-borderless" style="margin-bottom:-12px; border-top: solid 1px;border-color: lightgray;">
            <tr>
                <td style="width:50px;">
                    <img src="/images/drag_icon.png" style="margin-right: 2px;" class="drag_handle">    
                    <input type="checkbox" id="task_<?=$task->id?>" name="tasks[]" class="" style="margin-right:2px">
                </td>
                <td>
                    <span class="text text-success" style="font-size:14px;"><?= $task->todo ?></span>
                </td>
                <td style="width:73px;">
                <?= $this->render('_task_toolbar',['task_id'=>$task->id,'task' => $task,'swot_id' => $swot_id, 'list' => $list, 'list_id' => $list->id]) ?>    
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <?php if(!empty($task->details)):?>
                    <span class="text text-info" style="font-size:13px;"><?= $task->details ?></span>
                    <?php else:?>
                    <span class="text text-muted" style="border-bottom: dotted 1px;font-size:13px;">No description</span>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2">
                    <span class="text text-muted" style="border-bottom: dotted 1px;font-size:13px;"><i class="fa fa-calendar"></i> No due date</span></small>
                    <span class="text text-muted" style="margin-left:10px; border-bottom: dotted 1px;font-size:13px;"><i class="fa fa-comments-o"></i> No comments</span>
                </td>
            </tr>
        </table>
    </li>
<?php endforeach; ?>
</ul>
