<?php

namespace backend\components\exporters;

use backend\components\Common;
use backend\components\ParseCsv;
use Yii;


class Csv extends Export {

    public function createCsv($posts,$add_image_name=false,$onlyDataReturn=false)
    {
        $format = Yii::$app->postradamus->get_user_date_time_format();

        $csv = new ParseCsv();
        $i = 0;
        foreach($posts as $post)
        {
            $newcsv[$i] = [] ; 
			$newcsv[$i]['name'] = $post->name; 
			$newcsv[$i]['text'] = $post->text; 
			$newcsv[$i]['image_url'] = $post->image_url; 
			
			if($add_image_name){
				$newcsv[$i]['local_image'] = basename($post->image_filename_with_path);
			}
            
			$newcsv[$i]['origin'] = $post->origin_name; 
			$newcsv[$i]['post_type'] = (!empty($post->postType) ? $post->postType->name : 'None') ; 
			$newcsv[$i]['scheduled_time'] = ($post->scheduled_time != 0 ? date($format, $post->scheduled_time) : 'Not scheduled'); 
			$newcsv[$i]['last_updated'] =  date($format, $post->updated_at); 
			$newcsv[$i]['created'] =  date($format, $post->created_at); 
			
			$i++;
        }
        // convert 2D array to csv data and output as a file to download it
        // (filename, csv-data, csv-header, delimiter)
        if(isset($newcsv))
        {	
			if($onlyDataReturn){
				return $newcsv;		
			}
            $csv->output('converted.csv', $newcsv, array_keys($newcsv[0]), ',');
            Yii::$app->end();
        }
        else
        {
            Yii::$app->session->setFlash('danger', 'Could not build a CSV');
        }
    }

}