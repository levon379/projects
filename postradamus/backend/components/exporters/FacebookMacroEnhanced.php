<?php

namespace backend\components\exporters;

use backend\components\Common;
use Yii;

class FacebookMacroEnhanced extends FacebookMacro {

    private $_posts;
    protected $_images;
    public $list_id;
    public $random_cta;
    public $page_id;

    public function merge_images()
    {
        $macro_text = '';
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

    public function create_automated_macro()
    {
        $script = <<<EOF
function ajax(url, callbackFunction) {
    const XMLHttpRequest = Components.Constructor("@mozilla.org/xmlextras/xmlhttprequest;1");
    var request = XMLHttpRequest();
    request.open("GET", url, false);
    request.setRequestHeader("Content-Type",
      "application/x-www-form-urlencoded");

    request.onreadystatechange = function() {
      var done = 4, ok = 200;
      if (request.readyState == done && request.status == ok) {
        if (request.responseText) {
          callbackFunction(request.responseText);
        }
      }
    };
    request.send();
}

var getComplete = function (text) {
    lines = text.split("\r\n");
    lines1 = lines.join('\n');
    iimPlay("CODE:" + lines1);
}

iimDisplay("Postradamus Started...");

ajax('http://localhost/fbpostbot3/index.php?r=export/get-macro-text', getComplete);

iimDisplay("Postradamus Completed.");
EOF;
        return $script;
    }

}