<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use backend\components\FastImage;

class Webpage extends Import {

    protected $origin_type = cListPost::ORIGIN_WEBPAGE;

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
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $html = $this->curl_exec_follow($ch);

        curl_close($ch);
        return $html;
    }

    public function curl_exec_follow(/*resource*/ &$ch, /*int*/ $redirects = 20, /*bool*/ $curlopt_header = false) {
        if ((!ini_get('open_basedir') && !ini_get('safe_mode')) || $redirects < 1) {
            curl_setopt($ch, CURLOPT_HEADER, $curlopt_header);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $redirects > 0);
            curl_setopt($ch, CURLOPT_MAXREDIRS, $redirects);
            return curl_exec($ch);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);

            do {
                $data = curl_exec($ch);
                if (curl_errno($ch))
                    break;
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($code != 301 && $code != 302)
                    break;
                $header_start = strpos($data, "\r\n")+2;
                $headers = substr($data, $header_start, strpos($data, "\r\n\r\n", $header_start)+2-$header_start);
                if (!preg_match("!\r\n(?:Location|URI): *(.*?) *\r\n!", $headers, $matches))
                    break;
                curl_setopt($ch, CURLOPT_URL, $matches[1]);
            } while (--$redirects);
            if (!$redirects)
                trigger_error('Too many redirects. When following redirects, libcurl hit the maximum amount.', E_USER_WARNING);
            if (!$curlopt_header)
                $data = substr($data, strpos($data, "\r\n\r\n")+4);
            return $data;
        }
    }

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        try {
            $url = $search_params['webpage_url'];
            $html = $this->impersonateBrowser($url);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('notice', "Could not load the web page. Please try again later." . "\n\n". $e->getMessage());
        }

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $x = new \DOMXPath($dom);
        $i=0;

        foreach($x->query("//img") as $node)
        {
            if(!$img_url = $node->getAttribute("rel:bf_image_src"))
            {
                $img_url = $node->getAttribute("src");
            }
            $img_url = $this->rel2abs($this->imgurFix($img_url), $url);
            /*
            $img = new FastImage($img_url);
            list($width, $height) = $img->getSize();
            set_time_limit(25);
            if($width > 100 && $height > 100)
            {*/
            if($img_url != 'https://images.search.yahoo.com/search/' && $img_url != 'http://images.search.yahoo.com/search/')
            {
                $id = md5($search_params['webpage_url'] . $img_url);
                $posts[$i]['id'] = $id;
                $posts[$i]['img'] = $img_url;
                $i++;
            }
/*
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($id, Yii::$app->user->id))
                    {
                        continue;
                    }
                }
            }*/
        }

        if(empty($posts))
        {
            Yii::$app->session->setFlash("error", "No results found. Please try a different URL.");
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
        if (isset($rel[0]) && ($rel[0]=='#' || $rel[0]=='?')) return $base.$rel;

        /* parse base URL and convert to local variables:
         $scheme, $host, $path */
        extract(parse_url($base));

        /* remove non-directory element from path */
        $path = preg_replace('#/[^/]*$#', '', $path);

        /* destroy path if relative url points to root */
        if (isset($rel[0]) && $rel[0] == '/') $path = '';

        /* dirty absolute URL */
        $abs = "$host$path/$rel";

        /* replace '//' or '/./' or '/foo/../' with '/' */
        $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for($n=1; $n>0; $abs=preg_replace($re, '/', $abs, -1, $n)) {}

        /* absolute URL is ready! */
        return $scheme.'://'.$abs;
    }

}