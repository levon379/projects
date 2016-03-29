<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;

/**
 * Export form
 */
class PinterestExportForm extends Model
{
    public $list_id;
    public $export_type;
    public $board_id;
    public $board_name;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['publish'] = ['list_id'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            // username and password are both required
            [['list_id', 'board_id'], 'required'],
            [['list_id', 'board_id'], 'hasScheduledPosts', 'on' => ['publish']],
			[['list_id'], 'notSentRecent', 'on' => ['publish']],
            [['board_name'], 'safe'],
            // rememberMe must be a boolean value
            [['list_id', 'export_type'], 'integer'],
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
		if(!empty($this->list_id)&&!empty($this->board_id)){
			// if this list has been sent to same target page/board/blog within last 24 hours then raise an error 
			
			$limitTime=time()-(60*60*24);
			
			// possible keys - page_id, board_id, blog_name
			$cnt=cListSentMeta::find()->where(['and',['list_id'=>$this->list_id],['key'=>'board_id'],['value'=>$this->board_id],['>', 'created_at', $limitTime]])->count();
			if($cnt>0){
				$this->addError($attribute, 'Postradamus has prevented this export because you already exported this list to the same place recently.');
			}	
		}
    }

    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'board_id' => 'Board',
            'board_name' => 'Board Name'
        ];
    }

}
