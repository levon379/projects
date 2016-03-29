<?php
$this->title = 'Image Template';
?>

<div class="msg">Please wait... Applying image templates.</div>

<div class="progress progress-striped active"><div class="progress-bar progress-bar-info" style="width:50%"></div></div>
<?php foreach((array)$images as $image) { ?>
<img src="<?=$image?>" style="display:none">
<?php } ?>

</div>
</div>