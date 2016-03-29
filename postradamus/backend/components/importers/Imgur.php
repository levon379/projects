<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;

class Imgur extends Import {

    protected $origin_type = cListPost::ORIGIN_IMGUR;

    public function impersonateBrowser($url)
    {
        $ch = curl_init();
        $useragent="Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1)".
            " Gecko/20061204 Firefox/2.0.0.1";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $html = curl_exec($ch);

        curl_close($ch);
        return $html;
    }

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        try {
            $url = 'http://imgur.com/?q=' . urlencode($search_params['search_keywords']);
            $html = $this->impersonateBrowser($url);
        } catch (\Exception $e) {
            $this->message->set_message("Could not load the web page. Please try again later." . "\n\n". $e->getMessage(), Message::MSG_TYPE_ERROR);
            exit;
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $x = new \DOMXPath($dom);
        $i=0;

        foreach($x->query("//img") as $node)
        {
            if($node->getAttribute('src') == '//s.imgur.com/images/blog_rss.png')
            {
                continue;
            }
            $id = md5('IMGUR' . $node->getAttribute("src"));
            if(isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1)
            {
                if($this->is_used($id, Yii::$app->user->id))
                {
                    continue;
                }
            }
            $posts[$i]['id'] = $id;
            $posts[$i]['image_url'] = $this->rel2abs($this->imgurFix($node->getAttribute("src")), $url);
            $posts[$i]['text'] = ($node->getAttribute('original-title'));
            $i++;
        }

        if(empty($posts))
        {
            Yii::$app->session->setFlash("error", "No results found. Please try different keywords.");
            return array();
        }

        return $posts;
    }

    function imgurFix($imgsrc)
    {
        if(strstr($imgsrc, 'imgur.com'))
        {
            //remove the b from the end of the image url
            $imgsrc = str_replace('b.jpg', '.jpg', $imgsrc);
        }
        return $imgsrc;
    }

    function rel2abs($rel, $base)
    {
        $path = '';

        /* return if already absolute URL */
        if (parse_url($rel, PHP_URL_SCHEME) != '' || substr($rel, 0, 2) == '//') return $rel;

        /* queries and anchors */
        if ($rel[0]=='#' || $rel[0]=='?') return $base.$rel;

        /* parse base URL and convert to local variables:
         $scheme, $host, $path */
        extract(parse_url($base));

        /* remove non-directory element from path */
        $path = preg_replace('#/[^/]*$#', '', $path);

        /* destroy path if relative url points to root */
        if ($rel[0] == '/') $path = '';

        /* dirty absolute URL */
        $abs = "$host$path/$rel";

        /* replace '//' or '/./' or '/foo/../' with '/' */
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

        /* absolute URL is ready! */
        return $scheme.'://'.$abs;
    }

}