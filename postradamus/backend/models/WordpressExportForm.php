<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\cListPost;

/**
 * Export form
 */
class WordpressExportForm extends Model
{
    public $list_id;
    public $blog_name;
    public $category_id = 0;

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
            [['list_id'], 'required'],
            [['list_id'], 'hasScheduledPosts', 'on' => ['publish']],
			[['list_id'], 'notSentRecent', 'on' => ['publish']],
            [['blog_name', 'category_id'], 'safe'],
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
		if(!empty($this->list_id)&&!empty($this->blog_name)){
			// if this list has been sent to same target page/board/blog within last 24 hours then raise an error 
			
			$limitTime=time()-(60*60*24);
			
			// possible keys - page_id, board_id, blog_name
			$cnt=cListSentMeta::find()->where(['and',['list_id'=>$this->list_id],['key'=>'blog_name'],['value'=>$this->blog_name],['>', 'created_at', $limitTime]])->count();
			if($cnt>0){
				$this->addError($attribute, 'Postradamus has prevented this export because you already exported this list to the same place recently.');
			}	
		}
    }
	
    public function attributeLabels()
    {
        return [
            'list_id' => 'List',
            'blog_name' => 'Wordpress Blog',
            'category_id' => 'Category',
        ];
    }

}
