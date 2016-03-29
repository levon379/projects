<?php
if ($order->product->type == Product_Model::TYPE_FACEBOOK) {
    $image = '/assets/admin/img/complete-fb.png';
    $text_setup = 'FACEBOOK SETUP';
    $text_design = 'FACEBOOK CUSTOM DESIGN';
} else if($order->product->type == Product_Model::TYPE_TWITTER) {
    $image = '/assets/admin/img/complete-tw.png';
    $text_setup = 'TWITTER SETUP';
    $text_design = 'TWITTER CUSTOM DESIGN';
}
?>
<div class="form-row">
    <div class="col-xs-2">
        <img src="<?php echo $image ?>" alt="">
    </div>
    <div class="col-xs-7"><?php echo $text_setup ?></div>
    <div class="col-xs-3"><?php echo price_format($setupProductData->price/100) ?></div>
</div>

<div class="form-row">
    <div class="col-xs-2">
        <img src="<?php echo $image ?>" alt="">
    </div>
    <div class="col-xs-7"><?php echo $text_design ?></div>
    <div class="col-xs-3"><?php echo price_format($designProductData->price/100) ?></div>
</div>
<div class="form-row">
    <div class="col-xs-2">
        <img src="<?php echo $image ?>" alt="">
    </div>
    <div class="col-xs-7"></div>
    <div class="col-xs-3"><?php echo price_format($order->total) ?></div>
</div>