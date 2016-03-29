<?php
/**
 * Created by PhpStorm.
 * User: dev31
 * Date: 26.08.15
 * Time: 16:07
 */

?>

<div class="coupon-preview-wrapper">
    <h2 class="title-head text-center">Coupons preview</h2>
    <div class="carousel-container">
        <span class="carousel-left-arrow"><img src="<?php echo BASE_URL; ?>assets/admin/img/arrow.png"/></span>
        <span class="carousel-right-arrow"><img src="<?php echo BASE_URL; ?>assets/admin/img/arrow.png"/></span>
        <div id="carousel" class="carousel">
            <?php foreach ($htmls as $key => $value):?>
                <div class="item-carousel"><?php echo $value; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-center"><span class="go-back btn btn-lg btn-info">go back</span></div>
</div>
