<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var \frontend\models\ResetPasswordForm $model
 */
$this->title = 'Special for FB Post Bot customers only';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    td { padding:3px; }
</style>
<h1>Order Page For FB Post Bot Customers</h1>
<h2 style="color:red">This offer expires on 6/30/2014</h2>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="margin-left:20px; margin-top:25px" class="well">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="6AM36CYCMNR46">
    <table>
        <tr><td><input type="hidden" name="on0" value="">Payment Option</td></tr><tr><td><select name="os0">
                    <option value="Monthly">Monthly : $9.00 USD - monthly</option>
                    <option value="Yearly">Yearly : $99.00 USD - yearly</option>
                </select> </td></tr>
        <tr><td><input type="hidden" name="on1" value="Postradamus Username">What is your Postradamus Username?</td></tr><tr><td><input type="text" name="os1" maxlength="200"></td></tr>
    </table>
    <input type="hidden" name="currency_code" value="USD">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="margin-top:5px">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>