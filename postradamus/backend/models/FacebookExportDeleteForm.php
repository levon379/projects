<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;

/**
 * Export form
 */
class FacebookExportDeleteForm extends Model
{
    public $fb_page_id;

    public function rules()
    {
        return [
            // username and password are both required
            [['fb_page_id'], 'required'],
            // rememberMe must be a boolean value
            [['fb_page_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fb_page_id' => 'Facebook Page',
        ];
    }

}
