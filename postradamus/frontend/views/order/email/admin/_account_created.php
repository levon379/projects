Thank you for ordering <?=Yii::$app->name?> (<?php $plan = \common\models\cPlan::find()->where(['id' => $model->plan_id])->one(); if(!empty($plan)) { echo $plan->name; } ?>). We're excited to help you with your Facebook pages!

Your account is now setup and ready to use.

------------------------------------

You can login at <?=Yii::$app->params['loginUrl']?> with the following username and password.

Username: <?=$model->username?>

Password: <?=$model->password?>

------------------------------------

We want to make <?=Yii::$app->name?> the best Facebook page management tool out there. We encourage you to explore <?=Yii::$app->name?> and share with others how you have been using it to your benefit. We'd also appreciate if you let us know what features you'd like to see added in the future.

The <?=Yii::$app->name?> Team

---

Looking for support?
Please join the <?=Yii::$app->name?> Facebook group by requesting access here: <?=Yii::$app->params['facebookGroupUrl']?> or visit <?=Yii::$app->params['supportDeskUrl']?> to submit a support request.

--- ADMIN ONLY ---
1) This email was sent to: <?php echo $model->first_name . ' (' . $model->email . ')'; ?>