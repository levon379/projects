<?php
namespace backend\components\importers;

use common\models\cListPost;
use Yii;
use yii\web\HttpException;

class Amazon extends Import
{

    protected $origin_type = cListPost::ORIGIN_AMAZON;

    const AWS_API_ACCESS_KEY = 'AKIAJCS25HTA6JILOP6A';
    const AWS_API_SECRET_KEY = '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';
    const AWS_ASSOCIATE_TAG = 'myexpwitnatsk-20';

    public $amazon;
    public $aws_api_access_key;
    public $aws_api_secret_key;
    public $aws_associate_tag;

    public function __construct($config = [])
    {
        $this->aws_api_access_key = ((isset($config['aws_api_access_key']) && trim($config['aws_api_access_key']) != '') ? $config['aws_api_access_key'] : self::AWS_API_ACCESS_KEY);
        $this->aws_api_secret_key = ((isset($config['aws_api_secret_key']) && trim($config['aws_api_secret_key']) != '') ? $config['aws_api_secret_key'] : self::AWS_API_SECRET_KEY);
        $this->aws_associate_tag = ((isset($config['aws_associate_tag']) && trim($config['aws_associate_tag']) != '') ? $config['aws_associate_tag'] : self::AWS_ASSOCIATE_TAG);
    }

    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        $posts = [];

        if($search_params['cache'] == 0)
        {
            Yii::$app->cache->delete('amazon' . md5(serialize($search_params)));
        }

        try {
            //$formattedResponse = Yii::$app->cache->get('amazon' . md5(serialize($search_params)));
            //if($formattedResponse === false)
            //{
                $conf = new \ApaiIO\Configuration\GenericConfiguration();

                $conf
                    ->setCountry($search_params['search_country'])
                    ->setAccessKey($this->aws_api_access_key)
                    ->setSecretKey($this->aws_api_secret_key)
                    ->setAssociateTag($this->aws_associate_tag)
                    ->setRequest('\ApaiIO\Request\Soap\Request')
                    ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

                $apaiIO = new \ApaiIO\ApaiIO($conf);

                $this->amazon = $apaiIO;

                for ($i = 1; $i <= 3; $i++) {
                    $search = new \ApaiIO\Operations\Search();
                    $search->setCategory($search_params['search_category']);
                    $search->setKeywords($search_params['search_keywords']);
                    if($search_params['search_min_price'] != '') $search->setMinimumPrice($search_params['search_min_price']);
                    if($search_params['search_max_price'] != '') $search->setMaximumPrice($search_params['search_max_price']);

                    $search->setPage($i);
                    //$search->setSort('reviewrank');
                    $search->setResponseGroup(array('Large'));

                    \Yii::beginProfile('Amazon Search');
                    $formattedResponse[$i] = $this->amazon->runOperation($search);
                    \Yii::endProfile('Amazon Search');
                }

                $formattedResponse = @array_merge_recursive($formattedResponse[1], $formattedResponse[2], $formattedResponse[3] /*, $formattedResponse[4], $formattedResponse[5]*/);

                //Yii::$app->cache->set('amazon' . md5(serialize($search_params)), $formattedResponse, 60 * 60);
            //}

            if (empty($formattedResponse['Items']['Item'])) {
                Yii::$app->session->setFlash('success', 'No results found. Please try different keywords.');
                return [];
            }

            $i = 0;
            foreach ($formattedResponse['Items']['Item'] as $item)
            {
                if($search_params['hide_used_content'] == 1)
                {
                    if($this->is_used($this->get_post_id($item), Yii::$app->user->id))
                    {
                        continue;
                    }
                }
                $posts[$i]['id'] = $this->get_post_id($item);
                $posts[$i]['title'] = $this->get_post_title($item);
                $posts[$i]['text'] = $this->get_post_message($item);
                $posts[$i]['image_url'] = $this->get_post_image_src($item);
                $posts[$i]['author'] = $this->get_post_author($item);
                $posts[$i]['sales_rank'] = $this->get_sales_rank($item);
                $posts[$i]['product_link'] = $this->get_post_image_link($item);
                $posts[$i]['lowest_new_price'] = $this->get_lowest_new_price($item);
                $i++;
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', 'Amazon says: ' . $e->getMessage());
        }

        return $posts;
    }

    /* Helpers */
    public function get_post_id($v)
    {
        /*TODO*/
        return ($v['ASIN'] ? $v['ASIN'] : 1);
    }

    public function get_post_message($v)
    {
        //return iconv("UTF-8", "ISO-8859-1//IGNORE", ($v['EditorialReviews']['EditorialReview'][0]['Content'] ? $v['EditorialReviews']['EditorialReview'][0]['Content'] : $v['Title']));

        //\fbpostbot\Common::print_p($v['EditorialReviews']);
        $str = '';

        if (isset($v['EditorialReviews']['EditorialReview'])) {
            if (isset($v['EditorialReviews']['EditorialReview'][0]) && is_array($v['EditorialReviews']['EditorialReview'][0])) {
                $str = $v['EditorialReviews']['EditorialReview'][0]['Content'];
            } else {
                $str = $v['EditorialReviews']['EditorialReview']['Content'];
            }
        }

        $str = str_replace('<br />', "\n", $str);

        $str = strip_tags($str);

        return preg_replace('/\s+?(\S+)?$/', '', substr($str, 0, 201)) . '...';

    }

    public function get_lowest_new_price($v)
    {
        //return (isset($v['']))
    }

    public function get_post_image_src($v)
    {
        return (isset($v['LargeImage']) ? $v['LargeImage']['URL'] : '');
    }

    public function get_sales_rank($v)
    {
        return (isset($v['SalesRank']) ? $v['SalesRank'] : '');
    }

    public function get_post_image_link($v)
    {
        $url = $v['DetailPageURL'];
        //die(Yii::$app->session->get('campaign_id'));

        $json = Yii::$app->cache->get(md5(Yii::$app->user->id . Yii::$app->session->get('campaign_id') . 'bitly' . $url));
        if($json === false)
        {
            $json = file_get_contents("https://api-ssl.bitly.com/v3/shorten?access_token=b450d43c9facffba89a2e4f15309ae755b3b074d&longUrl=$url");
            Yii::$app->cache->set(md5(Yii::$app->user->id . Yii::$app->session->get('campaign_id') . 'bitly' . $url), $json);
        }

        set_time_limit(30);

        $json = json_decode($json);

        return $json->data->url;
    }

    public function get_post_title($v)
    {
        return ((isset($v['ItemAttributes']) && isset($v['ItemAttributes']['Title']) ? $v['ItemAttributes']['Title'] : ''));
    }

    public function get_post_author($v)
    {
        return ((isset($v['ItemAttributes']) && isset($v['ItemAttributes']['Author']) ? $v['ItemAttributes']['Author'] : ''));
    }

    public function get_post_created_time($v)
    {
        /*TODO*/
        return $v['created_time'];
    }

}