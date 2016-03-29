<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.08.15
 * Time: 16:06
 */
?>
<div class="header-wrapper text-center col-md-12 col-sm-12 col-xs-12">
    <h2 class="title-head text-center">Create your own coupon</h2>
    <h4 class="title-text text-center">Enter further details about the offer</h4>
</div>
<form id="coupon-create-form" enctype="multipart/form-data" method="post" class="container">
    <div class="coupon-wrapper container text-center col-md-6 col-sm-12 col-xs-12 col-md-offset-3 col-sm-offset-1">

        <div class="coupon container col-md-12 col-sm-12 col-xs-12">
            <div class="logo text-center col-md-4 col-sm-12 col-xs-12">
<!--                <input type="file" id="company-logo" name="logo" class="logo-input" value="--><?php //echo $coupon['company']['name']; ?><!--" />-->
                <div type="file" id="company-logo" name="logo" class="logo-input" data-typeattach="logo" ><?php echo $coupon['company']['name']; ?></div>
                <span class="images">
                    <?php if(empty($coupon['company']['logo_url'])): ?>
                        <img src="<?php echo BASE_URL; ?>assets/admin/img/question.png" />
                        <img src="<?php echo BASE_URL; ?>assets/admin/img/empty-pic.png" />
                    <?php else: ?>
                        <img src="<?php echo $coupon['company']['logo_url']; ?>" />
                    <?php endif; ?>
                </span>
            </div>

            <div class="company-details text-right col-md-7 col-md-offset-1 col-sm-12 col-xs-12 container">
                <input type="text"
                       id="company-name"
                       name="coupon[company][name]"
                       class="company-name"
                       maxlength="25"
                       placeholder="my company"
                       value="<?php echo $coupon['company']['name']; ?>"
                       required="required"/>
                <input type="text"
                       id="company-site"
                       name="coupon[company][site]"
                       class="company-site"
                       maxlength="25"
                       placeholder="www.mycompany.com"
                       value="<?php echo $coupon['company']['site']; ?>"
                       required="required"/>
                <input type="text"
                       id="company-address"
                       name="coupon[company][address]"
                       class="company-address"
                       maxlength="36"
                       placeholder="Paseo Drive Palm Desert, California"
                       value="<?php echo $coupon['company']['address']; ?>"
                       required="required" />
                <input type="text"
                       id="company-phone"
                       name="coupon[company][phone]"
                       class="company-phone"
                       maxlength="18"
                       placeholder="730-12345"
                       value="<?php echo $coupon['company']['phone']; ?>"
                       required="required"/>
                <input type="hidden"
                       id="company-logo-id"
                       name="coupon[company][logo_id]"
                       class="company-logo-id"
                       value="<?php echo $coupon['company']['logo_id']; ?>" />
            </div>
            <input type="text" id="coupon-title" name="coupon[title]" class="coupon-title col-md-12 col-sm-12 col-xs-12" maxlength="30" placeholder="Special offer" value="<?php echo $coupon['title']; ?>" />
            <textarea id="coupon-text" name="coupon[text]" class="coupon-text col-md-12 col-sm-12 col-xs-12" maxlength="110" placeholder="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda eaque est, iure maiores molestias odit omnis, optio quo ."><?php echo $coupon['text']; ?></textarea>
            <div class="discount-info-wrapper col-md-12 col-sm-12 col-xs-12 container">
                <div class="discount-wrapper col-md-offset-1 col-sm-offset-1 col-xs-offset-1 text-center">
                    <input type="text" id="discount" name="coupon[discount]" class="discount col-md-12 col-sm-12 col-xs-12" maxlength="5" placeholder="0%" value="<?php echo $coupon['discount']; ?>">
                    <div class="discount-label">discount</div>
                </div>
                <div class="qrcode-wrapper col-md-offset-1 col-sm-offset-1 col-xs-offset-1 text-center">
                    <div class="qrcode-image-wrapper">
                        <img src="<?php echo BASE_URL; ?>assets/admin/img/sample-QR-Code.png" />
                    </div>
                    <div class="hover-choise-barcode">
                        <span id="barcode-choice" data-typeattach="barcode" class="glyphicon glyphicon-barcode"></span>
                        <span id="clear-choice" data-typeattach="qrcode" class="glyphicon glyphicon-remove-circle hidden"></span>
                        <span id="qrcode-choice" data-typeattach="qrcode" class="glyphicon glyphicon-qrcode"></span>
                    </div>
                    <input type="hidden" id="code-choice" name="coupon[code-choice]" class="" value="<?php echo $coupon['code-choice']; ?>">
                    <input type="hidden" id="barcode-attach-id" name="coupon[barcode-attach-id]" class="" value="<?php echo $coupon['barcode-attach-id']; ?>">
                </div>
            </div>
            <div class="duration-wrapper col-md-12 col-sm-12 col-xs-12 container">
                <div class="from-duration col-md-7 col-sm-12 col-xs-12">
                    <label>Valid from:</label>
                    <input type="text" id="duration-from" name="coupon[duration-from]" class="duration-datepicker" value="<?php echo $coupon['duration-from']?$coupon['duration-from']:time(); ?>">
                    <input type="hidden" id="timestamp-duration-from" name="coupon[timestamp-duration-from]" class="duration-datepicker" value="<?php echo time(); ?>">
                </div>
                <div class="to-duration col-md-5 col-sm-12 col-xs-12">
                    <label>To:</label>
                    <input type="text" id="duration-to" name="coupon[duration-to]" class="duration-datepicker" value="<?php echo $coupon['duration-to']?$coupon['duration-to']:time(); ?>">
                    <input type="hidden" id="timestamp-duration-to" name="coupon[timestamp-duration-to]" class="duration-datepicker" value="<?php echo time(); ?>">
                </div>
            </div>
            <div class="conditions col-md-12 col-sm-12 col-xs-12">No Cash Value. No rain checks. No cash back. Coupon not valid on prior purchases, online purchases or gift cards. Must present coupon at time of purchase to redeem. Cannot be combined with any other offer, coupon, or Employee or Friends & Family discount.</div>
        </div>
    </div>
    <div class="schedule_datepicker_dropdown"></div>
    <div class="form-separator"></div>
    <h2 class="text-center col-md-12 col-sm-12 col-xs-12"></br>select social networks to send coupons</h2>
    <div class="text-center col-md-12 col-sm-12 col-xs-12"></br>
        <input type="hidden" id="formToken" name="formToken" value="<?php echo $formToken ?>">
        <?php $current_user = Users_Model::get_current_user(); ?>
        <?php $social_accounts =  $current_user->get_social_accounts(); ?>
        <?php $social_possible =  get_config('social_types'); ?>
        <?php $result_soc =  array(); ?>
        <?php foreach($social_possible as $sockey => $socvalue) :?>
            <?php foreach($social_accounts as $social_account) {
                if(!isset($result_soc[$socvalue]) && $socvalue !== $social_account) {
                    $result_soc[$socvalue] = false;
                } elseif($socvalue === $social_account) {
                    $result_soc[$socvalue] = true;
                }
            } ?>
        <?php endforeach; ?>
        <?php foreach($result_soc as $sockey => $socvalue) :?>
            <?php if($socvalue ===  true) {?>
                <label class="socials-label selected" for="post[socials][<?php echo $sockey; ?>]">
                    <span class="<?php echo Posts_Model::get_socialclases($sockey); ?>"></span>
                    <input class="socials" type="checkbox" checked="checked" name="post[socials][<?php echo $sockey; ?>]" value="<?php echo $sockey; ?>" />
                </label>
            <?php }else{ ?>
                <label class="socials-label">
                    <?php $add_account_link = get_config('add_accounts_urls')->{$sockey}; ?>
                    <a class="add-account-url" href="<?= $add_account_link; ?>"><span class="<?php echo Posts_Model::get_socialclases($sockey); ?>-possible"></span></a>
                </label>
            <?php } ?>
        <?php endforeach; ?>
    </div>
    <div class="form-separator"></div>

    <div class="submit-wrapper text-center col-md-12 col-sm-12 col-xs-12" id="submit-wrapper">
        <input type="submit" id="coupon-previev" name="coupon-action" class="btn btn-lg btn-info btn-coupon" value="preview" />
        <input type="submit" id="coupon-create" name="coupon-action" class="btn btn-lg btn-danger btn-coupon" value="create" />
        <input type="submit" id="coupon-shedule" name="coupon-action" class="btn btn-lg btn-danger btn-coupon" value="schedule" />
        <input type="hidden" id="date-shedule" name="date-shedule" class="" value="" />
    </div>
</form>
<?php $medialibrary->render('logo', array("title" => "Pictures bank", "dragtext" => "Upload your picture here", "accept" => "image/*")); ?>
