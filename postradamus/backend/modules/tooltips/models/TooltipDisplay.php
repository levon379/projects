<?php

namespace backend\modules\tooltips\models;

use Yii;

/**
 * This is the model class for table "tbl_tooltip_display".
 *
 * @property integer $id
 * @property integer $user_id
 * @property text  disabled_tooltips
 */
class TooltipDisplay extends \yii\db\ActiveRecord{
    
    public static function tableName(){
        return 'tbl_tooltip_display';
    }

    public function rules(){
        return [
            [['user_id', 'disabled_tooltips'], 'required'],
            [['user_id'], 'unique'],
        ];
    }

    public function attributeLabels(){
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'disabled_tooltips' => 'Disabled Tooltips',
        ];
    }
	
	static function isTooltipsOnForUser($userId){
		$rec=TooltipDisplay::find()->where(['user_id'=>$userId])->one();
		if(!empty($rec)&&empty($rec->on)){
			return false;
		}
		return true;
	}
	
	static function onOffTooltipsForUser($userId,$status){
		$rec=TooltipDisplay::find()->where(['user_id'=>$userId])->one();
		if(empty($rec)){
			$rec=new TooltipDisplay();	
			$rec->user_id=$userId;
			$rec->disabled_tooltips=json_encode([]);
		}
		if($status==false||$status=='false'){
			$rec->on=0;	
		}
		else{
			$rec->on=1;	
		}
		
		if($rec->save()){
			return true;
		}
		return false;
	}
	
	static function disableTooltipForUser($userId,$tooltipId){
		$rec=TooltipDisplay::find()->where(['user_id'=>$userId])->one();
		$disabled_tooltips=[]; 
		if(empty($rec)){
			$rec=new TooltipDisplay();	
			$rec->user_id=$userId;
		}
		else{
			if(!empty($rec->disabled_tooltips)){
				$disabled_tooltips=json_decode($rec->disabled_tooltips,true); 
			}
		}
		
		if(in_array($tooltipId,$disabled_tooltips)){
			return true;
		}
		else{
			array_push($disabled_tooltips,$tooltipId);
			$rec->disabled_tooltips=json_encode($disabled_tooltips);
			if($rec->save()){
				return true;
			}	
		}
		return false;
	}
	
	static function getDisabledTooltipsForUser($userId){
		$rec=TooltipDisplay::find()->where(['user_id'=>$userId])->one();
		$disabled_tooltips=[]; 
		if(!empty($rec)&&!empty($rec->disabled_tooltips)){
			$disabled_tooltips=json_decode($rec->disabled_tooltips,true); 
		}
		return $disabled_tooltips;
	}
	

}
