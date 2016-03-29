Your <?=Yii::$app->name?> account has been upgraded to <?php $plan = \common\models\cPlan::find()->where(['id' => $model->plan_id])->one(); if(!empty($plan)) { echo $plan->name; } ?>.

The <?=Yii::$app->name?> Team

---

Looking for support?
Please join the <?=Yii::$app->name?> Facebook group by requesting access here: <?=Yii::$app->params['facebookGroupUrl']?> or visit <?=Yii::$app->params['supportDeskUrl']?> to submit a support request.