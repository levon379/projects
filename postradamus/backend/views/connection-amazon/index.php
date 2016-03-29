<?php

use yii\helpers\Html;
use common\models\cConnectionAmazon;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cConnectionAmazonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Amazon Connections';
$this->params['breadcrumbs'][] = 'Settings' ;
$this->params['breadcrumbs'][] = $this->title;

$this->params['help']['message'] = 'If you have one or more <a href="https://affiliate-program.amazon.com/gp/associates/help/t22/a13" target="blank">Amazon Affiliate Accounts</a> you can set them up here. When searching for <a href="' . Yii::$app->urlManager->createUrl('content/amazon') . '">Amazon content</a>, Postradamus will turn the product links into affiliate links so you can earn commissions on any sales.';
$this->params['help']['modal_body'] = '<iframe width="853" height="480" src="//www.youtube.com/embed/US70TA0yxUQ" id="youtube-video" frameborder="0" allowfullscreen></iframe>';

?>
    <div class="c-connection-amazon-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'country',
                'value' => function ($data) {
                        return ($data->campaign_id == 0 ? '(Master) ' : '') . countryCodeToName($data->country);
                   }
            ],
            //'aws_api_secret_key',
            'aws_associate_tag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);


    function countryCodeToName($code)
    {
        $countries = [
        'ca' => 'Canada',
        'cn'=> 'China',
        'de' => 'Denmark',
        'fr' => 'France',
        'it'=>'Italy',
        'in'=> 'India',
        'co.jp'=> 'Japan',
        'es'=>'Spain',
        'com' => 'US',
        'co.uk' => 'UK'
        ];

        return $countries[$code];
    }

    ?>

</div>
        </div>
        <div class="panel-footer text-left">
            <div class="form-group">
                <?= Html::a('New Amazon Connection', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
