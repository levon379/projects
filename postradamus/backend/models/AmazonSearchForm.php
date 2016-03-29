<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Export form
 */
class AmazonSearchForm extends Model
{
    public $keywords;
    public $category;
    public $min_price;
    public $max_price;
    public $country = 'com';
    public $hide_used_content = true;
    public $cache = 1;

    public function rules()
    {
        return [
            // username and password are both required
            [['hide_used_content', 'keywords', 'category', 'country', 'min_price', 'max_price', 'cache'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'keywords' => 'Keywords',
            'category' => 'Category',
            'min_price' => 'Minimum Price',
            'max_price' => 'Maximum Price',
            'hide_used_content' => 'Don\'t show content i\'ve already saved.'
        ];
    }

    public function countryCodeToName()
    {
        if($this->country == 'com')
            return 'US';
        if($this->country == 'ca')
            return 'Canada';

        return $this->country;
    }

}
