<?php
namespace common\models;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tbl_tooltip_display".
 *
 * @property integer $id
 * @property integer $user_id
 * @property text  disabled_tooltips
 */
class cPostTemplateImage extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'tbl_post_template_image';
    }

    public function rules(){
        return [
            [['post_template_id', 'file_name'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'post_template_id' => 'Post Template ID',
            'file_name' => 'File Name',
        ];
    }
	
	public function beforeDelete(){
		if (parent::beforeDelete()) {
			$tempImagePath=Yii::$app->params['imagePath'].'post-templates/'.Yii::$app->user->id.'/'. $this->post_template_id.'/'.$this->file_name;
			if(is_file($tempImagePath)){
				return unlink($tempImagePath);
			}
			return true;
		} else {
			return false;
		}
	}

	public static function findListByPostTemplateId($postTemplateId){
		$default_images=null;
		$rec=cPostTemplateImage::find()->where(['post_template_id'=>$postTemplateId])->select(['id','file_name'])->asArray()->all();
		if(!empty($rec)){
			$default_images=ArrayHelper::map($rec, 'id', 'file_name');
		}
		return $default_images;
	}
}