<?php
namespace backend\components\importers;

use common\models\cListPost;
use backend\components\Common;
use backend\components\FastImage;
use Yii;

class Feed extends Import {

    protected $origin_type = cListPost::ORIGIN_FEED;
    protected $max_results = 100;
    protected $feed_title, $feed_url, $feed_website_url;

    public function get_feeds($query)
    {
        $json = file_get_contents('http://ajax.googleapis.com/ajax/services/feed/find?v=1.0&userip=' . $_SERVER['REMOTE_ADDR'] . '&q=' . urlencode($query));
        $json_decode = json_decode($json);
        $i=0;

        foreach($json_decode->responseData->entries as $element)
        {
            if($element->url == '')
            {
                unset($json_decode->responseData->entries[$i]);
            }
            $i++;
        }

        $json_decode->responseData->entries = array_values($json_decode->responseData->entries);


        $json = json_encode($json_decode);
        return $json;
    }

    public function getFeedTitle()
    {
        return $this->feed_title;
    }

    public function getFeedUrl()
    {
        return $this->feed_url;
    }

    public function getFeedWebsiteUrl()
    {
        return $this->feed_website_url;
    }

    /* Searches pinterest (screen scrape) for photos */
    public function search($search_params)
    {
        try {
            // START ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $results = array();
            // BUILD SEARCH URL
            $search_url = $search_params['search_url'];

            // FETCH MAIN SEARCH RESULT PAGE
            $client = new \Zend\Http\Client('', array('adapter' => 'Zend\Http\Client\Adapter\Curl', 'sslverifyhost' => false, 'sslverifypeer' => false));
            //tell the Reader to use the client we've just created
            \Zend\Feed\Reader\Reader::setHttpClient($client);
            $results = \Zend\Feed\Reader\Reader::import($search_url);

            if($results->count() != 0)
            {
                $this->feed_title = $results->getTitle();
                $this->feed_url = $results->getFeedLink();
                $this->feed_website_url = $results->getLink();

                $i = 0;
                foreach($results as $key => $result)
                {

                    $dom = new \DOMDocument();
                    @$dom->loadHTML($result->getContent());
                    $x = new \DOMXPath($dom);
                    $i2 = 0;

                    $post_id = md5($search_url . $result->getTitle() . $result->getContent() . $result->getLink());

                    $enclosure = $result->getEnclosure();
                    if(isset($enclosure)) {
                        if(strstr($enclosure->type, 'image'))
                        {
                            $image[$i2]['url'] = $enclosure->url;
                        }
                    }

                    //look through all images in the getContent
                    foreach($x->query("//img") as $node)
                    {
                        $img = Yii::$app->cache->get(md5($node->getAttribute('src')));
                        if($img === false)
                        {
                            $img = new FastImage($node->getAttribute('src'));
                            list($width, $height) = $img->getSize();

                            if($width && $height)
                            Yii::$app->cache->set(md5($node->getAttribute('src')), ['width' => $width, 'height' => $height], 10 * 24 * 60 * 60);
                        }
                        else
                        {
                            $width = $img['width'];
                            $height = $img['height'];
                        }
                        set_time_limit(25);
                        $image_id = md5($node->getAttribute('src'));
                        $image[$i2]['url'] = $node->getAttribute('src');
                        $image[$i2]['size'] = $width + $height;
                        if($width + $height < 50)
                        {
                            unset($image[$i2]);
                        }
                        $i2++;
                    }

                    //look through all links for images
                    foreach($x->query("//a") as $node)
                    {
                        $image_id = md5($node->getAttribute('href'));
                        $url = $node->getAttribute('href');
                        $parts = pathinfo($url);
                        if($parts['extension'] == 'jpg' || $parts['extension'] == 'png' || $parts['extension'] == 'jpeg' || $parts['extension'] == 'gif')
                        {
                            $img = Yii::$app->cache->get(md5($node->getAttribute('href')));
                            if($img === false)
                            {
                                $img = new FastImage($node->getAttribute('href'));
                                list($width, $height) = $img->getSize();

                                if($width && $height)
                                Yii::$app->cache->set(md5($node->getAttribute('href')), ['width' => $width, 'height' => $height], 10 * 24 * 60 * 60);
                            }
                            else
                            {
                                $width = $img['width'];
                                $height = $img['height'];
                            }
                            set_time_limit(25);
                            $image[$i2]['url'] = $node->getAttribute('href');
                            $image[$i2]['size'] = $width + $height;
                            if($width + $height < 0)
                            {
                                unset($image[$i2]);
                            }
                            $i2++;
                        }
                    }

                    //look for a enclosure url


                    $images = Common::array_key_multi_sort($image, 'size', 'desc');

                    //if($images[0]['width'] != 0 && $images[0]['height'] != 0)
                    //{
                       $image_url = $images[0]['url'];
                    //}

                    //print("<pre>");
                    //print_r($results->getImage());
                    //die();

                    //choose largest $image
                    $posts[$i]['id'] = $post_id;
                    $posts[$i]['feed_title'] = $this->getFeedTitle();
                    $posts[$i]['feed_url'] = $this->getFeedUrl();
                    $posts[$i]['feed_website_url'] = $this->getFeedWebsiteUrl();
                    $posts[$i]['title'] = $result->getTitle();
                    $posts[$i]['modified'] = $result->getDateModified();
                    $posts[$i]['created'] = ($result->getDateCreated() ? $result->getDateCreated()->format("U") : '');
                    $posts[$i]['author_name'] = ($result->getAuthor()['name'] ? $result->getAuthor()['name'] : ($results->getAuthor()['name'] ? $results->getAuthor()['name'] : $results->getTitle()));
                    $posts[$i]['name'] = $posts[$i]['author_name'];
                    $posts[$i]['author_url'] = $results->getAuthor()['link'];
                    $posts[$i]['author_image_url'] = $results->getImage()['uri'];
                    $posts[$i]['link'] = $result->getLink();
                    $posts[$i]['image_url'] = $image_url;
                    $posts[$i]['url'] = $result->getLink();
                    $posts[$i]['text_raw'] = $result->getContent();
                    $posts[$i]['text'] = strip_tags($result->getContent());
                    $posts[$i]['comment_count'] = $result->getCommentCount();
                    $i++;
                    unset($image);
                }

                $i=0;
                foreach($posts as $post)
                {
                    if(isset($search_params['hide_used_content']) && $search_params['hide_used_content'] == 1)
                    {
                        if($this->is_used($posts[$i]['id'], Yii::$app->user->id))
                        {
                            unset($posts[$i]);
                        }
                    }
                    $i++;
                }
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }

        if(empty($posts))
        {
            \Yii::$app->session->setFlash("warning", "No results found. Please try different keywords.");
            return array();
        }

        return $posts;
    }

}