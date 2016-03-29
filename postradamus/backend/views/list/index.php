<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\cListSearch $searchModel
 */

$this->title = 'Lists';
$this->params['help']['message'] = 'You create lists and then perform actions such as adding posts to them as well as scheduling the posts. After you have finished building your list, you can export it to various sources such as Facebook or Pinterest.';

if(Yii::$app->controller->action->id == 'not-ready')
{	
	$this->title = 'Lists (Not Ready)';
    $this->params['help']['message'] .= '<br /><br /><b>The lists on this page are not yet ready because not all posts have valid scheduled times and dates.</b>';
}
if(Yii::$app->controller->action->id == 'ready')
{
	$this->title = 'Lists (Ready)';	
    $this->params['help']['message'] .= '<br /><br /><b>The lists on this page are ready to be <a href="' . Yii::$app->urlManager->createUrl('export/facebook-api') . '">exported</a>.</b>';
}
if(Yii::$app->controller->action->id == 'sending')
{
	$this->title = 'Lists (Sending)';	
    $this->params['help']['message'] .= '<br /><br /><b>The lists on this page are in the process of being published. Once all the posts in a list have been sent, this list will move to the "Sent" tab.</b>';
}
if(Yii::$app->controller->action->id == 'sent')
{
	$this->title = 'Lists (Sent)';		
    $this->params['help']['message'] .= '<br /><br /><b>The lists on this page have already been published at one time or another.</b>';
}

$this->params['breadcrumbs'][] = $this->title;

?>

        <div class="c-list-index">
            <?php
            $table_header = <<<EOF
<div class="table-header">
    <div class="table-caption">
        Lists
    </div>
</div>
EOF;
            ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        //'user_id',
						[
						'class' => 'yii\grid\CheckboxColumn',
						'visible'=>(Yii::$app->controller->action->id=='sent'?true:false),
						'checkboxOptions'=>['class'=>'listCheckbox']
						],
                        [
                            'attribute' => 'name',
                            'value' => function ($data) {
                                    return ($data->campaign_id == 0 ? '(Master) ' : '') . $data->name;
                                }
                        ],
                        'post_count',
                        [
                            'visible' => (Yii::$app->controller->action->id == 'sending' || Yii::$app->controller->action->id == 'sent' ? true : false),
                            'header' => (Yii::$app->controller->action->id == 'sent') ? 'Sent To' : 'To',
                            'format' => 'html',
                            'value' => function ($data) {
                                $to = '';
                                $targets = [];
                                foreach($data->listSent as $sent)
                                {
                                    $targets[] = Html::a(ucwords($sent->target_name) . ' (' . $sent->main_meta . ')', ['list-sent/view', 'id' => $sent->id]);
                                }
                                $to = implode(", ", $targets);
                                return $to;
                            }
                        ],
                        //[
                        //    'attribute' => 'list.postCount',
                        //    'value' => function ($data) {
                        //            return $data->postCount;
                        //       }
                        //],
                        [
                            'header' => 'First Scheduled Post',
                            'value' => function ($data)
                            {
                                $post = \common\models\cListPost::find()->where(['list_id' => $data->id])->orderBy('scheduled_time ASC')->one();
                                if($post->scheduled_time != 0)
                                {
                                    return date(Yii::$app->postradamus->get_user_date_time_format(), $post->scheduled_time);
                                }
                                else
                                {
                                    return "NA";
                                }
                            }
                        ],
                        [
                            'header' => 'Last Scheduled Post',
                            'value' => function ($data)
                            {
                                $post = \common\models\cListPost::find()->where(['list_id' => $data->id])->orderBy('scheduled_time DESC')->one();
                                if($post->scheduled_time != 0)
                                {
                                    return date(Yii::$app->postradamus->get_user_date_time_format(), $post->scheduled_time);
                                }
                                else
                                {
                                    return "NA";
                                }
                            }
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function ($data)
                            {
                                return date(Yii::$app->postradamus->get_user_date_time_format(), $data->created_at);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {delete}',
                        ],
                    ],
                ]);

            /*
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item'],
                'itemView' => '_list_view',
                'layout' => '<div class="row"><div class="col-xs-12">{summary}</div></div><div class="row">{items}</div><div class="row"><div class="col-xs-12">{pager}</div></div>',
            ]);
            */

            ?>
			
			<?php 
			if(Yii::$app->controller->action->id == 'sent'){
			?>
				<div class="clearfix"></div>
				<div>
					<a href="javascript:void(0);" id="delete-lists-link" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Selected">Delete</a>
				</div>
				<div class="clearfix"></div>
			<?php
			}
			?>
        </div>
    </div>

    <div class="panel-footer text-left">
        <div class="form-group">
            <?= Html::a('New List', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    </div>
<?php 
if(Yii::$app->controller->action->id == 'sent'){
?>
	<div id="dataBlock" data-delete-lists-url="<?= Yii::$app->urlManager->createUrl( ['list/delete-lists'] ) ?>"></div>
	<?php $this->beginBlock('viewJs'); ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();

			$('#delete-lists-link').on('click',function(){
				var deleteLink=$(this);
				var checkboxes = $('.listCheckbox:checked') ; 
				if( checkboxes.length <= 0 ){
					alert( "Please select at-least one list." );
					return false;
				}
				
				if(!window.confirm('Are you sure, you wish to delete selected lists?')){
					return false;
				}
				
				var ids = new Array();
				checkboxes.each(function(){
					var id = $(this).val();	
					ids.push(id);
				});
				
				$.ajax({
					'url' : $('#dataBlock').data('deleteListsUrl'), 
					'type' : 'POST',
					'dataType' : 'JSON', 
					'data':{ids:ids}, 
					'beforeSend' : function(){
						//display loader
						deleteLink.attr('disabled',true).html( 'Deleting ...' );
					},
					'success':function(result){
						if(result.success=='1'){
							window.location.reload();
							deleteLink.replaceWith('<div class="alert alert-success">Selected lists have been deleted.</div>');
						}
						else{
							alert( 'Error! While deleting selected lists.' );
							deleteLink.attr('disabled',false).html( 'Delete' );
						}
					},
					'error' : function(){
						alert( 'Error! While deleting selected lists.' );
						deleteLink.attr('disabled',false).html( 'Delete' );
					},
					'complete' : function(){
						// hide loader 
					}
				});
		
			});
		});
	</script>
	<?php $this->endBlock(); ?>
<?php
}
?>	