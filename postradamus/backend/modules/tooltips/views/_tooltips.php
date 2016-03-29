<?php
$tooltipMessages = [
    'recentSection' => 'You can read up on new features and announcements for Postradamus below in the \'Recent\' section.',
    'profilePhoto' => 'You can click on the image below (above your name) to set your profile photo - however this step is not required.',
	'help'=>'You can click the blue \'Help\' button on the left menu to get training or submit a support request.',
    'instapost'=>'You can click the green \'InstaPost\' button on the left menu to access your free bonus tool InstaPost.',
    'postTextQuickEdit' => 'You can click on any post\'s text and perform a \'quick edit\' on the text.',
    'postsMassActions' => 'Selecting one or more posts allows you to mass delete, duplicate or change the post type of multiple posts at once.',
    'selectedPostsMassActions' => 'With selected posts, you can mass delete, clear text, duplicate or change the post type of multiple posts at once.',
    'selectAllListPosts' => 'You can click the \'Select All\' button to select all of the view-able posts in your list.',
	'editPost'=>'You can click the pencil icon underneath a post to edit all of its details such as post text, scheduled time, link, etc.',
	'trashPost'=>'You can click the trash can icon underneath a post to remove the post from your list.',
	'selectAllSearchResult'=>'You can click the \'Select All\' button to select all the search results.',
	'saveForLaterUse' => 'You can click the green \'Save\' button to remember this content source for later use.',
	'listToColumn' => 'The \'To\' column shows you which Facebook page, Wordpress blog or Pinterest board, you sent your list to. This can contain multiple items, if you sent your list to more than one place.',
	'listToColumnLog'=>'You can click the link(s) in the \'To\' column to see a log of all posts that were sent to your Facebook page, Wordpress blog or Pinterest board.',
	'linkPost'=>'The link field allows you to turn your post into a link post (Facebook only).',
	'nameWordpressBlog'=>'The name field is used as the title of your post when you send your post to a Wordpress blog.',
	'moreOptionsYoutubeSearch'=>'You can click the \'More Options\' link in the YouTube search form to have even more control over which types of videos are returned in your search results.',
    'turnOffTips' => 'You can turn off these tips by visiting the <a href=\"' . Yii::$app->urlManager->createUrl('setting/update') . '\">Settings > General page.</a>',
    'pinterestMoreResults' => 'You can get many more results from Pinterest by changing the \"Results\" parameter below. Note however, the more results you ask for, the longer it will take to return them.',
    'pinterestAdditionalKeywordIdeas' => 'You can click on one of the \"Additional Keyword Ideas\" in the search form to find more photos from Pinterest that match your keyword and the keyword idea you clicked.'
];

$pages = [
    'site/index' => [
        'pageLoad' => ['recentSection', 'profilePhoto','help','instapost','turnOffTips']
    ],
    'list/view' => [
        'pageLoad' => ['postTextQuickEdit', 'postsMassActions', 'selectAllListPosts','editPost','trashPost'],
        'elementClick' => ['.select_button' => 'selectedPostsMassActions']
    ],
    'content/facebook' => ['getParams' => ['FacebookSearchForm' => ['saveForLaterUse', 'selectAllSearchResult']]],
    /*'content/twitter-search' => ['pageLoad' => []],*/
    'content/pinterest' => ['pageLoad' => ['pinterestMoreResults'], 'getParams' => ['PinterestSearchForm' => ['selectAllSearchResult', 'pinterestAdditionalKeywordIdeas']]],
    'content/instagram' => ['getParams' => ['InstagramSearchForm' => 'selectAllSearchResult']],
    'content/youtube' => ['pageLoad' => ['moreOptionsYoutubeSearch'], 'getParams' => ['YoutubeSearchForm' => 'selectAllSearchResult']],
    'content/amazon' => ['getParams' => ['AmazonSearchForm' => 'selectAllSearchResult']],
    'content/reddit' => ['getParams' => ['RedditSearchForm' => 'selectAllSearchResult']],
    'content/tumblr' => ['getParams' => ['TumblrSearchForm' => 'selectAllSearchResult']],
    'content/imgur' =>  ['getParams' => ['ImgurSearchForm' => 'selectAllSearchResult']],
    'content/webpage' => ['getParams' => ['WebpageSearchForm' =>'selectAllSearchResult']],
    'content/feed' => ['getParams' => ['FeedSearchForm' => 'saveForLaterUse', 'selectAllSearchResult']],
	'list/sent' => ['pageLoad' => ['listToColumn', 'listToColumnLog']],				
	'post/update' => ['pageLoad' => ['linkPost', 'nameWordpressBlog']],				
];

$this->registerCss('
#tooltipBlock{position:fixed;top:60px;right:15px;width:300px;z-index:9999999;}
.awesome-tooltip{display:none;margin-bottom:7px;background-color:#2ecc71;padding:12px 15px;color:white;font-size:13px;border-radius:4px;}
.tooltip-title{margin-top: 2px;margin-bottom: 7px;}
.awesome-tooltip > .close-tooltip-icon{position: relative;bottom:8px;right:-9px;font-size:16px;}
.awesome-tooltip > a { color: white; text-decoration: underline; }
.footer-links {margin-top:12px;font-size:12px;}
.footer-links > a{color:inherit;}
.footer-links > a > span{text-decoration:underline;}
');

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
$page = $controller . '/' . $action;

use backend\modules\tooltips\models\TooltipDisplay;

if (array_key_exists($page, $pages)) {
    $tooltips = $pages[$page];
    $jsData = [];

    $displayedTooltips = TooltipDisplay::getDisabledTooltipsForUser(Yii::$app->user->id);
    /*
    foreach($displayedTooltips as $displayedTooltip){
        if(array_key_exists($displayedTooltip,$tooltipMessages)){
            unset($tooltipMessages[$displayedTooltip]);
        }
    }
    */

    if (is_array($tooltips)) {
		
		// iterating following loop to filter already displayed tooltips
        foreach ($tooltips as $tooltipType => $tempVals) {
            if (!is_array($tempVals)) {
                unset($tooltips[$tooltipType]);
                continue;
            }

            if($tooltipType == 'pageLoad'){
                foreach ($tempVals as $tempKey => $tempKeyword) {
                    if (in_array($tempKeyword, $displayedTooltips)) {
                        unset($tempVals[$tempKey]);
                    }
                }
                $tooltips[$tooltipType] = array_values($tempVals);
            } else if($tooltipType == 'getParams'){
                foreach ($tempVals as $tempKey => $tempKeyword) {
					if(is_array($tempKeyword)){
						foreach ($tempKeyword as $tempSubKey => $tempSubKeyword){
							if(in_array($tempSubKeyword, $displayedTooltips)){
								unset($tempKeyword[$tempSubKey]);
							}
						}
						if(!empty($tempKeyword)){
							$tempKeyword = array_values($tempKeyword);
							$tempVals[$tempKey]=$tempKeyword;
						}
						else{
							unset($tempVals[$tempKey]);
						}
					}
					else{
						if (in_array($tempKeyword, $displayedTooltips)) {
							unset($tempVals[$tempKey]);
						}	
					}
                }
                $tooltips[$tooltipType] = $tempVals;
            } else if($tooltipType == 'elementClick'){
                foreach ($tempVals as $tempKey => $tempKeyword) {
                    if (in_array($tempKeyword, $displayedTooltips)) {
                        unset($tempVals[$tempKey]);
                    }
                }
                $tooltips[$tooltipType] = $tempVals;
            }
        }

        if (array_key_exists('getParams', $tooltips) && is_array($tooltips['getParams'])) {
            $request = Yii::$app->request;
            foreach ($tooltips['getParams'] as $getParam => $tipKeyword) {
                if ($request->get($getParam)) {

                    if(!is_array($tipKeyword))
                    {
                        $tipKeywords = [$tipKeyword];
                    }
                    else
                    {
                        $tipKeywords = $tipKeyword;
                    }

                    $randomTips = $tipKeywords;
                    $tipKeyword = $randomTips[rand(0, count($randomTips) - 1)];

                    if (!array_key_exists('pageload', $jsData)) {
                        $jsData['pageload'] = [];
                    }
                    if (array_key_exists($tipKeyword, $tooltipMessages)) {
                        $temp = [];
                        $temp['keyword'] = $tipKeyword;
                        $temp['message'] = $tooltipMessages[$tipKeyword];
                        array_push($jsData['pageload'], $temp);
                    }

                }
            }
        }

        if (empty($temp) && array_key_exists('pageLoad', $tooltips)) {
            $randomTips = $tooltips['pageLoad'];
            $tipKeyword = $randomTips[rand(0, count($randomTips) - 1)];
            if (array_key_exists($tipKeyword, $tooltipMessages)) {
                $jsData['pageload'] = [];
                $temp = [];
                $temp['keyword'] = $tipKeyword;
                $temp['message'] = $tooltipMessages[$tipKeyword];
                array_push($jsData['pageload'], $temp);
            }
        }

        if (array_key_exists('elementClick', $tooltips) && is_array($tooltips['elementClick'])) {
            $jsData['elementclick'] = [];
            foreach ($tooltips['elementClick'] as $elementSelector => $tipKeyword) {
                if (array_key_exists($tipKeyword, $tooltipMessages)) {
                    $temp = [];
                    $temp['keyword'] = $tipKeyword;
                    $temp['selector'] = $elementSelector;
                    $temp['message'] = $tooltipMessages[$tipKeyword];
                    array_push($jsData['elementclick'], $temp);
                }
            }
        }

        //only select one of the tooltips (randomly)
    }

    if (!empty($jsData)) {
        echo '<div class="" id="tooltipBlock" data-disable-tooltip-url="'.Yii::$app->urlManager->createUrl(['tooltips/default/disable-tooltip']).'" data-disable-all-url="'.Yii::$app->urlManager->createUrl(['tooltips/default/on-off-tooltips']).'"></div>';
    }

}

$this->registerJS("
	var tooltipBlock=$('#tooltipBlock');
	if(tooltipBlock.length>0){
		displayedList=new Array(); 
		var tooltips={
			data:'" . str_replace("'", "\'", json_encode($jsData)) . "',
			displayedList:displayedList,
			tooltipBlock:'',
			init:function(tooltipBlock){
				tooltips.tooltipBlock=tooltipBlock;
				var jsData =  JSON.parse(tooltips.data);
				if( typeof jsData.pageload !== 'undefined' ){
					var pageload=jsData.pageload;
					for(var i=0;i<pageload.length;i++){
						tooltips.displayTooltip(pageload[i]['keyword'],pageload[i]['message']);	
					}
				}
				
				if( typeof jsData.elementclick !== 'undefined' ){
					var elementclick = jsData.elementclick;
					for(var i=0;i<elementclick.length;i++){
						var selector = elementclick[i]['selector'];
						var keyword = elementclick[i]['keyword'];
						var message = elementclick[i]['message'];
						$(selector).on('click',function(){
							if(tooltips.displayedList.indexOf(keyword)<0){
								tooltips.displayTooltip(keyword,message);	
								tooltips.displayedList.push(keyword);
							}
						});
					}	
				}
			},
			displayTooltip:function(keyword,message){
				var elem = $('<div></div>');
				elem.addClass( 'awesome-tooltip' );
				elem.data('keyword',keyword);
				var tooltipBody='';
				tooltipBody += '<i class=\"fa fa-close close-tooltip-icon close close-tooltip\"></i>' ;
				tooltipBody += '<h4 class=\"tooltip-title\">Did you know?</h4>'; 
				tooltipBody += message;
				tooltipBody += '<div class=\"footer-links\">';
					tooltipBody += '<a href=\"javascript:void(0);\" class=\"close-tooltip\"><i class=\"fa fa-times-circle\"></i> <span>Hide Tip</span></a>';
					tooltipBody += ' &nbsp; &nbsp;|&nbsp; &nbsp; ';
					tooltipBody += '<a href=\"javascript:void(0);\" class=\"disable-all-tooltips\"><i class=\"fa fa-eraser\"></i> <span>Hide All Tips</span></a>';
				tooltipBody += '</div>';
				//var closeLink=$('<i class=\"fa fa-close close\"></i>');
				
				elem.html(tooltipBody);
				tooltips.tooltipBlock.append(elem);
				elem.slideDown('slow','linear');
				
				$('.awesome-tooltip').find('.close-tooltip').unbind();
				$('.awesome-tooltip').find('.close-tooltip').on('click',function(){
					var keyword=$(this).closest('.awesome-tooltip').data('keyword');
					$(this).closest('.awesome-tooltip').fadeOut(600,function(){
						$(this).remove();
					});
					var disableTooltipUrl=tooltips.tooltipBlock.data('disableTooltipUrl');
					//alert(disableTooltipUrl);
					$.ajax({
						'url' : disableTooltipUrl, 
						'type' : 'POST',
						'dataType' : 'JSON', 
						'data':{keyword:keyword}, 
						'beforeSend' : function(){},
						'success':function(result){},
						'error' : function(){},
						'complete' : function(){}
					});
				});
				
				$('.awesome-tooltip').find('.disable-all-tooltips').unbind();
				$('.awesome-tooltip').find('.disable-all-tooltips').on('click',function(){
					var keyword=$(this).closest('.awesome-tooltip').data('keyword');
					$(this).closest('.awesome-tooltip').fadeOut(600,function(){
						$(this).remove();
					});
					var disableAllUrl=tooltips.tooltipBlock.data('disableAllUrl');
					//alert(disableTooltipUrl);
					$.ajax({
						'url' : disableAllUrl, 
						'type' : 'POST',
						'dataType' : 'JSON', 
						'data':{status:false}, 
						'beforeSend' : function(){},
						'success':function(result){},
						'error' : function(){},
						'complete' : function(){}
					});
				});
			},		
		};
		
		$(document).ready(function(){
			tooltips.init(tooltipBlock);
		});	
	}");
?>