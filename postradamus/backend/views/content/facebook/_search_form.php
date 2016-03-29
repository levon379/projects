<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\cList $model
 * @var yii\widgets\ActiveForm $form
 */

/* code added by - Jateen P. 
 * purpose - to break tabs into diff. actions 
 */
$fbSearchPill=isset($_GET['facebook_search_pill'])?$_GET['facebook_search_pill']: '#pill_my_pages';
$myPagesUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_my_pages']);
$otherPagesUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_other_pages']);
$savedPagesUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_saved_pages']);
$myGroupsUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_my_groups']);
$otherGroupsUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_other_groups']);
$savedGroupsUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_saved_groups']);
$commentsUrl=Yii::$app->urlManager->createUrl(['content/facebook','facebook_search_pill'=>'#pill_comments']);
/* code ends .. 
 */
 
?>
<?php ob_start(); ?>
<div style="background-color:#3b5999; margin-bottom:15px; padding-left:20px; padding-top:12px; padding-bottom: 12px; border-radius: 4px;">
    <img src="<?=Yii::$app->params['imageUrl']?>Facebook_Logo.png" style="max-height:30px" />
</div>
<p>Using Facebook as: <?php echo $fh->get_user_profile()['name']; ?> (<a href="<?=Yii::$app->urlManager->createUrl('site/logout-facebook')?>">Logout</a>)</p>
<?php $this->context->before_panel = ob_get_clean(); ?>

<div class="c-list-form">

    <?php $form = ActiveForm::begin(['method' => 'get', 'id' => 'content-form', 'options' => ['data-persist' => 'garlic', 'data-destroy' => 'false'], 'action' => Yii::$app->urlManager->createUrl(['content/' . $source])]); ?>

    <?php echo $form->errorSummary($model); ?>
	<!-- code added by - Jateen P. 
		 purpose - to break tabs into diff. actions 
	-->
	<ul class="nav nav-pills">
        <li class="<?php if($fbSearchPill=='#pill_my_pages'){echo 'active';}?>">
			<a href="<?=$myPagesUrl?>" style="padding:6px 19px 6px 19px;">My Pages</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_other_pages'){echo 'active';} ?>">
			<a href="<?=$otherPagesUrl?>" style="padding:6px 19px 6px 19px">Other Pages</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_saved_pages'){echo 'active';} ?>">
			<a href="<?=$savedPagesUrl?>" style="padding:6px 19px 6px 19px">Saved Pages</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_my_groups'){echo 'active';} ?>">
			<a href="<?=$myGroupsUrl?>" style="padding:6px 19px 6px 19px">My Groups</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_other_groups'){echo 'active';} ?>">
			<a href="<?=$otherGroupsUrl?>"  style="padding:6px 19px 6px 19px">Other Groups</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_saved_groups'){echo 'active';} ?>">
			<a href="<?=$savedGroupsUrl?>" style="padding:6px 19px 6px 19px">Saved Groups</a>
		</li>
        <li class="<?php if($fbSearchPill=='#pill_comments'){echo 'active';} ?>">
			<a href="<?=$commentsUrl?>" style="padding:6px 19px 6px 19px">Comments</a>
		</li>
        <?php /* ?><li class=""><a href="#pill_recent_pages" data-toggle="pill" style="padding:6px 19px 6px 19px">Recently Used Pages</a></li><?php */ ?>
    </ul>
	<!-- code ends -->
	
	<!--
    <ul class="nav nav-pills">
        <li class="<?php if(!isset($_GET['facebook_search_pill']) || $_GET['facebook_search_pill'] == '#pill_my_pages') { ?>active<?php } ?>"><a href="#pill_my_pages" data-toggle="pill" style="padding:6px 19px 6px 19px;">My Pages</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_other_pages') { ?>active<?php } ?>"><a href="#pill_other_pages" data-toggle="pill" style="padding:6px 19px 6px 19px">Other Pages</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_saved_pages') { ?>active<?php } ?>"><a href="#pill_saved_pages" data-toggle="pill" style="padding:6px 19px 6px 19px">Saved Pages</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_my_groups') { ?>active<?php } ?>"><a href="#pill_my_groups" data-toggle="pill" style="padding:6px 19px 6px 19px">My Groups</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_other_groups') { ?>active<?php } ?>"><a href="#pill_other_groups" data-toggle="pill" style="padding:6px 19px 6px 19px">Other Groups</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_saved_groups') { ?>active<?php } ?>"><a href="#pill_saved_groups" data-toggle="pill" style="padding:6px 19px 6px 19px">Saved Groups</a></li>
        <li class="<?php if(isset($_GET['facebook_search_pill']) && $_GET['facebook_search_pill'] == '#pill_comments') { ?>active<?php } ?>"><a href="#pill_comments" data-toggle="pill" style="padding:6px 19px 6px 19px">Comments</a></li>
        <?php /* ?><li class=""><a href="#pill_recent_pages" data-toggle="pill" style="padding:6px 19px 6px 19px">Recently Used Pages</a></li><?php */ ?>
    </ul>
	-->
    <div class="tab-content" style="margin-top:10px">

        <div class="tab-pane<?php if($fbSearchPill=='#pill_my_pages'){echo 'active';} ?>" id="pill_my_pages">
			<?php
				if($fbSearchPill=='#pill_my_pages'){
					echo $form->field($model, 'from_page1')->label(false)->dropDownList($fh->get_user_page_list(), ['prompt' => '']);
				}
			?>
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_other_pages'){echo 'active';} ?>" id="pill_other_pages">
			<?php 
				if($fbSearchPill=='#pill_other_pages'){
				?>
				<div style="margin-bottom:5px">
					<?php echo Html::activeHiddenInput($model, 'from_page2', ['id' => 'from_page2']); ?>
				</div>
				<?php
				}
			?>	
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_saved_pages'){echo 'active';} ?>" id="pill_saved_pages">
			<?php 
				if($fbSearchPill=='#pill_saved_pages'){
					echo $form->field($model, 'from_page3')->label(false)->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\cSavedSearch::find()->andWhere(['fb_type' => 'page', 'origin_type' => \common\models\cListPost::ORIGIN_FACEBOOK])->orderBy('name')->all(), 'search_value', 'name'), ['prompt' => '']);
				}	
			?>
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_my_groups'){echo 'active';} ?>" id="pill_my_groups">
			<?php
				if($fbSearchPill=='#pill_my_groups'){
					echo $form->field($model, 'from_group1')->label(false)->dropDownList($fh->get_user_group_list(), ['prompt' => '']);
				}
			?>
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_other_groups'){echo 'active';} ?>" id="pill_other_groups">
			<?php
				if($fbSearchPill=='#pill_other_groups'){
				?>
				<div style="margin-bottom:5px">
					<?php echo Html::activeHiddenInput($model, 'from_group2', ['id' => 'from_group2']); ?>
				</div>
				<?php
				}
			?>
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_saved_groups'){echo 'active'; } ?>" id="pill_saved_groups">
			<?php
				if($fbSearchPill=='#pill_saved_groups'){
					echo $form->field($model, 'from_group3')->label(false)->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\cSavedSearch::find()->andWhere(['fb_type' => 'group', 'origin_type' => \common\models\cListPost::ORIGIN_FACEBOOK])->orderBy('name')->all(), 'search_value', 'name'), ['prompt' => '']);
				}
			?>
        </div>

        <div class="tab-pane<?php if($fbSearchPill=='#pill_comments'){echo 'active'; } ?>" id="pill_comments">
			<?php
				if($fbSearchPill=='#pill_comments'){
					echo $form->field($model, 'from_post_id')->textInput(['maxlength' => 255, 'placeholder' => '']);
				}
			?>
        </div>

        <?php /* ?>
        <div class="tab-pane" id="pill_recent_pages">
            <select name="from_page3" id="from_page3" style="width:320px">
            </select>
        </div>
        <?php */ ?>

    </div>

    <?php echo Html::activeHiddenInput($model, 'page_id', ['id' => 'page_id']); ?>
    <?php echo Html::activeHiddenInput($model, 'group_id', ['id' => 'group_id']); ?>
    <input type='hidden' id='facebook_search_pill' name='facebook_search_pill' value='<?=$fbSearchPill?>'>

    <?= $form->field($model, 'hide_used_content')->checkbox() ?>

    <p><a href="#" class="show_more_link" id="more_options_<?=$source?>">More Options</a></p>
    <div class="more well well-sm" style="display:none">
        <div id="extras" style="display:none">
            <?= $form->field($model, 'posted_by')->inline()->radioList(['0' => 'All Users', '1' => 'Fans', '2' => 'Page Owner']) ?>
        </div>
        <div id="normal">
            <?= $form->field($model, 'post_type')->inline()->radioList(['0' => 'All Posts', '1' => 'Photo', '2' => 'Status', '3' => 'Link', '4' => 'Video']) ?>

            <?= $form->field($model, 'large_results')->inline()->radioList(['0' => 'No', '1' => 'Yes']) ?> (Can be slow)

            <?= $form->field($model, 'cache')->inline()->radioList(['0' => 'No', '1' => 'Yes']) ?> (Speed up subsequent searches for same page/group)
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'id' => 'submit_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
