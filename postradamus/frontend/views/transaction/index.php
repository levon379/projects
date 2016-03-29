<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\cTransactionNewestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'C Transaction Newest';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="c-transaction-newest-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Sales', 'Profits'],
                <?php
                    $transes = (new \yii\db\Query())
                                ->select('DATE_FORMAT(FROM_UNIXTIME(`created`), "%M %Y") as `dates`, SUM(IF(amount > 0, amount, 0)) AS `sales`, SUM(net) AS profits, SUM(IF(`type` = "Payment" AND amount < 0, amount, 0)) AS `affiliate_payments`, SUM(fee) AS fees, SUM(IF(`type` = "Refund", amount, 0)) AS `refunds`')
                                ->from('tbl_transaction_newest')
                                ->groupBy('`dates`')
                                ->limit(1000)
                                ->orderBy('created')
                                ->all();
                    foreach($transes as $trans) {
                ?>
                ['<?=$trans['dates']?>', <?=round($trans['sales'])?>, <?=round($trans['profits'])?>],
                <?php } ?>
            ]);

            var options = {
                title: 'Monthly Income'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));

            chart.draw(data, options);
        }
    </script>
    <div id="chart_div1" style="height: 500px;"></div>

    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Affiliate Payments', 'Fees', 'Refunds'],
                <?php
                    $transes = (new \yii\db\Query())
                                ->select('DATE_FORMAT(FROM_UNIXTIME(`created`), "%M %Y") as `dates`, SUM(IF(amount > 0, amount, 0)) AS `sales`, SUM(net) AS profits, SUM(IF(`type` = "Payment" AND amount < 0, amount, 0)) AS `affiliate_payments`, SUM(fee) AS fees, SUM(IF(`type` = "Refund", amount, 0)) AS `refunds`')
                                ->from('tbl_transaction_newest')
                                ->groupBy('`dates`')
                                ->limit(1000)
                                ->orderBy('created')
                                ->all();
                    foreach($transes as $trans) {
                ?>
                ['<?=$trans['dates']?>', <?=abs(round($trans['affiliate_payments']))?>, <?=abs(round($trans['fees']))?>, <?=abs(round($trans['refunds']))?>],
                <?php } ?>
            ]);

            var options = {
                title: 'Monthly Expenses'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));

            chart.draw(data, options);
        }
    </script>
    <div id="chart_div2" style="height: 500px;"></div>

    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'New Users'],
                <?php
                    $transes = (new \yii\db\Query())
                                ->select('COUNT(id) AS users, DATE_FORMAT(FROM_UNIXTIME(`created_at`), "%M %Y") as `dates`')
                                ->from('tbl_user')
                                ->groupBy('`dates`')
                                ->limit(1000)
                                ->orderBy('created_at')
                                ->all();
                    foreach($transes as $trans) {
                ?>
                ['<?=$trans['dates']?>', <?=abs(round($trans['users']))?>],
                <?php } ?>
            ]);

            var options = {
                title: 'Monthly New Users'
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));

            chart.draw(data, options);
        }
    </script>
    <div id="chart_div3" style="height: 500px;"></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a($model->user->first_name . ' ' . $model->user->last_name, Yii::$app->urlManager->createUrl(['user/view', 'id' => $model->user_id]));
                },
            ],
            'type',
            'amount',
            'fee',
            'net',
            // 'details:ntext',
            [
                'attribute' => 'created',
                'format' => ['date', 'php:M d y h:i A'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
