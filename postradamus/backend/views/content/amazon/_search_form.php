<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<?php ob_start(); ?>
<div style="background-color:#000000; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Amazon_Logo.png" style="max-height:30px" />
</div>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => 255, 'data-storage' => 'false']) ?>

    <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
    <div class="more well well-sm" style="display:none">


        <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'category')->dropDownList([
            'All' => 'All',
            'Apparel' => 'Apparel',
            'Appliances' => 'Appliances',
            'ArtsAndCrafts' => 'Arts And Crafts',
            'Automotive' => 'Automotive',
            'Baby'=> 'Baby',
            'Beauty'=>'Beauty',
            'Blended'=>'Blended',
            'Books'=>'Books',
            'Classical'=>'Classical',
            'Collectibles'=>'Collectibles',
            'DigitalMusic'=>'Digital Music',
            'Grocery'=>'Grocery',
            'DVD'=>'DVD',
            'Electronics'=>'Electronics',
            'HealthPersonalCare'=>'Health Personal Care',
            'HomeGarden'=>'Home Garden',
            'Industrial'=>'Industrial',
            'Jewelry'=>'Jewelry',
            'KindleStore'=>'Kindle Store',
            'Kitchen'=>'Kitchen',
            'LawnGarden'=>'Lawn Garden',
            'Magazines'=>'Magazines',
            'Marketplace'=>'Marketplace',
            'Merchants'=>'Merchants',
            'Miscellaneous'=>'Miscellaneous',
            'MobileApps'=>'Mobile Apps',
            'MP3Downloads'=>'MP3 Downloads',
            'Music'=>'Music',
            'MusicalInstruments'=>'Musical Instruments',
            'MusicTracks'=>'Music Tracks',
            'OfficeProducts'=>'Office Products',
            'OutdoorLiving'=>'Outdoor Living',
            'PCHardware'=>'PC Hardware',
            'PetSupplies'=>'Pet Supplies',
            'Photo'=>'Photo',
            'Shoes'=>'Shoes',
            'Software'=>'Software',
            'SportingGoods'=>'Sporting Goods',
            'Tools'=>'Tools',
            'Toys'=>'Toys',
            'UnboxVideo'=>'Unbox Video',
            'VHS'=>'VHS',
            'Video'=>'Video',
            'VideoGames'=>'Video Games',
            'Watches'=>'Watches',
            'Wireless'=>'Wireless',
            'WirelessAccessories'=>'Wireless Accessories',
        ]); ?>
            </div>
            <div class="col-md-6">

        <?= $form->field($model, 'country')->dropDownList([
            'ca' => 'Canada',
            'cn'=> 'China',
            'de' => 'Germany',
            'fr' => 'France',
            'it'=>'Italy',
            'in'=> 'India',
            'co.jp'=> 'Japan',
            'es'=>'Spain',
            'com' => 'US',
            'co.uk' => 'UK',
        ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'min_price')->textInput(['maxlength' => 255]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'max_price')->textInput(['maxlength' => 255]) ?>
            </div>
        </div>

        <?= $form->field($model, 'cache')->inline()->radioList(['0' => 'No', '1' => 'Yes']) ?> (This will cache your searches for 10 days)

    </div>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
