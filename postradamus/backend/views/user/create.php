<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\cUser */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = 'Settings' ;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
        <div class="note note-info padding-xs-vr"><h4>What is this?</h4> We'll send an email with a username, password and link where your user can sign in to start using Postradamus.</div>

        <div class="c-user-create">

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>

    </div>
</div>