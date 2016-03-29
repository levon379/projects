<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 28.08.15
 * Time: 13:34
 */

?>
<?php if(empty($_POST['action']) || $_POST['action'] !== "create"): ?>
<h2 class="title-head text-center"><img src="<?php echo BASE_URL; ?>assets/admin/img/instagram.png" /></h2>
<?php endif; ?>
<div id="preview-instagram" class="text-center preview-instagram preview-coupon">
    <img class="coupon" src="<?php echo $coupon_data['data']; ?>" alt="<?php echo $coupon_data['filename']; ?>">
</div>