<div class="row">
    <div class="col-md-4">
        <input type="checkbox" name="post[<?=$model['id']?>][selected]" value="1" id="<?=$model['id']?>" class="checkbox_activate hidden" />
        <a href="#" class="btn btn-sm btn-primary select_button"><i class="fa fa-square"></i> Select</a>
    </div>
    <div class="col-md-4" style="padding-left: 6px;" id="post_now_div_<?=$model['id']?>">
        <input type="checkbox" name="post[<?=$model['id']?>][post_now]" value="<?=$model['id']?>" id="post_now_<?=$model['id']?>" class="checkbox_activate hidden" />
        <a href="javascript:void(0)" class="btn btn-sm btn-primary" onclick="post_now('<?=$model['id']?>')"><i class="fa fa-square"></i> Post Now</a>
    </div>
    <div class="col-md-4" style="text-align: right">
        <a href="#" class="hide_post btn btn-sm btn-danger"><i class="fa fa-minus-square"></i> Hide</a>
    </div>
</div>
