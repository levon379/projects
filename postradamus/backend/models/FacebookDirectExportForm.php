<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;
use common\models\cListSentMeta;

/**
 * Export form
 */
class FacebookDirectExportForm extends Model
{
    public $list_id;
    public $export_type;
    public $fb_page_id;
    public $fb_page_name;
	public $fb_target_type; // Pages or Groups
    public $internal_scheduler = 1;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['publish'] = ['list_id', 'fb_page_id', 'fb_page_name','fb_target_type', 'internal_scheduler'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id', 'fb_page_id'], 'required'],
            [['list_id'], 'hasScheduledPosts', 'on' => ['publish']],
			[['list_id'], 'notSentRecent', 'on' => ['publish']],
			// rememberMe must be a boolean value
            [['fb_page_name','fb_target_type'], 'safe'],
            [['list_id', 'export_type', 'fb_page_id', 'internal_scheduler'], 'integer'],
        ];
    }

    public function hasScheduledPosts($attribute)
    {
        $posts = cListPost::find()->where('scheduled_time IS NOT NULL')->andWhere(['list_id' => $this->$attribute])->count();
        if ($posts == 0) {
            $this->addError($attribute, 'The list you chose contains no scheduled posts.');
        }
    }
	
	public function notSentRecent($attribute, $params){
		if(!empty($this->list_id)&&!empty($this->fb_page_id)){
			// if this list has been sent to same target page/board/blog within last 24 hours then raise an error 
			
			$limitTime=time()-(60*60*24);
			
			// possible keys - page_id, board_id, blog_name
			$cnt=cListSentMeta::find()->where(['and',['list_id'=>$this->list_id],['key'=>'page_id'],['value'=>$this->fb_page_id],['>', 'created_at', $limitTime]])->count();
			if($cnt>0){
				$this->addError($attribute, 'Postradamus has prevented this export because you already exported this list to the same place recently.');
			}	
		}
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'fb_page_id' => 'Facebook Page',
            'fb_page_name' => 'Facebook Page Name',
			'fb_target_type' => 'Facebook Target Type',
            'internal_scheduler' => 'Send posts one at a time instead of to the Facebook Scheduler (Recommended)'
        ];
    }

}
