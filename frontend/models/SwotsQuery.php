<?php
namespace frontend\models;

use creocoder\taggable\TaggableQueryBehavior;

class SwotsQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
}
?>
