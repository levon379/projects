<?php

namespace backend\components\exporters;

use backend\components\Common;
use Yii;

class FacebookMacroBasic extends FacebookMacro {

    private $_posts;
    protected $_images;
    public $list_id;
    public $random_cta;
    public $page_id;

    public function merge_images()
    {
        //add the images
        $macro_text = 'SET !TIMEOUT_PAGE 5000' . "\r\n";
 		$macro_text .= 'URL GOTO=' . Yii::$app->urlManager->createAbsoluteUrl(['export/download-images', 'list_id' => $this->list_id, 'random_cta' => ($this->random_cta), 'user_id' => Yii::$app->user->id]) . "\n";

        if(is_array($this->_images))
        {
            foreach($this->_images as $key => $image)
            {
                //$zip->addFile(sys_get_temp_dir() . '/' . $v, $v);
                $macro_text .= 'ONDOWNLOAD FOLDER=* FILE='.$image.' WAIT=YES' . "\n" . 'TAG POS=1 TYPE=IMG ATTR=ID:'.$key.' CONTENT=EVENT:SAVEITEM' . "\n";
            }
        }
        $macro_text .= 'URL GOTO=http://www.facebook.com/' . $this->page_id . "\n\n";
        return $macro_text;
    }

}