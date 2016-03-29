Your <?=Yii::$app->name?> account has been upgraded to <?php $plan = \common\models\cPlan::find()->where(['id' => $model->plan_id])->one(); if(!empty($plan)) { echo $plan->name; } ?>.

We should issue a refund of <?=$refund?>.

The <?=Yii::$app->name?> Team

---

Looking for support?
Please join the <?=Yii::$app->name?> Facebook group by requesting access here: <?=Yii::$app->params['facebookGroupUrl']?> or visit <?=Yii::$app->params['supportDeskUrl']?> to submit a support request.

--- ADMIN ONLY ---
1) This email was sent to: <?php echo $model->first_name . ' (' . $model->email . ')'; ?>

2) We may want issue a refund of $<?=round($refund, 2)?>.

3) The customer's previous payment plan at JVZoo has been cancelled automatically.