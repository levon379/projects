<?php

namespace backend\components\importers;

use backend\components\Common;
use backend\components\ParseCsv;
use yii\data\ArrayDataProvider;
use Yii;

class Csv
{
    public static function ParseCsv($file) {
        $csv = new ParseCsv();
        $rows = $csv->parse_file($file);
        $posts = [];
        if ($rows) {
            foreach ($rows as $row) {
				$posts[] = [
                    'text' => $row['text'], 
                    'image_url' => $row['image_url'], 
                    'scheduled_time' => $row['scheduled_time'],
					'name' => (array_key_exists('name',$row))?$row['name']:null,
					'link' => (array_key_exists('link',$row))?$row['link']:null,
					];
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $posts,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        return $dataProvider;
    }
}
