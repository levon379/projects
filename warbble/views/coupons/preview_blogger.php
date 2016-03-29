<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.15
 * Time: 12:33
 */

?>
<?php if(empty($_POST['action']) || $_POST['action'] !== "create"): ?>
<h2 class="title-head text-center"><img src="<?php echo BASE_URL; ?>assets/admin/img/blogger_logo.png" /></h2>
<?php endif; ?>
<div id="preview-facebook" class="text-center preview-facebook preview-coupon">
    <img class="coupon" src="<?php echo $coupon_data['data']; ?>" alt="<?php echo $coupon_data['filename']; ?>">
</div>