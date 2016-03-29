Thank you for trying <?=Yii::$app->name?> (<?=$model->email?>).

Unfortunately, it looks like your paypal payment plan has been cancelled. This means your <?=Yii::$app->name?> account will be deactivated once your term expires (<?=$ending_date?>). If you feel this might be in error or you would like to get your payment plan reinstated please contact us immediately.

We hope you enjoyed using <?=Yii::$app->name?> and will consider becoming a <?=Yii::$app->name?> member again in the future.

The <?=Yii::$app->name?> Team

---

Looking for support?
Please join the <?=Yii::$app->name?> Facebook group by requesting access here: <?=Yii::$app->params['facebookGroupUrl']?> or visit <?=Yii::$app->params['supportDeskUrl']?> to submit a support request.

--- ADMIN ONLY ---
1) This email was sent to: <?php echo $model->first_name . ' (' . $model->email . ')'; ?>
2) This email was sent out because the JVZoo payment plan was cancelled.
3) The customers <?=Yii::$app->name?> account will remain active until <?=$ending_date?>.