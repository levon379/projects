<?php
/**
 * @var yii\web\View $this
 */

use common\models\User;
use backend\components\Common;

$this->registerJs('
init.push(function () {

$("#dashboard-recent-comments > div > div").slimScroll({ height: 300, alwaysVisible: true, color: "#888",allowPageScroll: false });

$(".accordion-toggle").on("click", function () {
   $(".panel").removeClass("panel-success");
   $(this).parent().parent().addClass("panel-success");
});

});
');

$this->title = 'Dashboard';

?>
    <div class="row">

        <div class="col-md-4">

            <!-- 7. $PROFILE_WIDGET_CENTERED_EXAMPLE ===========================================================

                            Profile widget - Centered example
            -->
            <div class="panel panel-primary panel-dark panel-body-colorful widget-profile widget-profile-centered">
                <div class="panel-heading">
                    <a href="http://www.gravatar.com" target="new"><img class="widget-profile-avatar"
                                                                        src="http://www.gravatar.com/avatar/<?php if (is_object(Yii::$app->user->identity)) {
                                                                            echo md5(strtolower(trim(Yii::$app->user->identity->getField('email'))));
                                                                        } ?>" alt="" class=""></a>

                    <div class="widget-profile-header">
                        <span><?php if (is_object(Yii::$app->user->identity)) {
                                echo Yii::$app->user->identity->getField('first_name');
                            } ?></span>
                    </div>
                </div>
                <!-- / .panel-heading -->
                <div class="panel-body">
                    <div class="widget-profile-text" style="padding: 0;">
                        <?php if (is_object(Yii::$app->user->identity)) {
                            echo Yii::$app->user->identity->getField('email');
                        } ?><br/>[<a href="<?= Yii::$app->urlManager->createUrl('profile/update') ?>">Update Profile</a>]
                    </div>
                </div>
            </div>
            <!-- / .panel -->
            <!-- /7. $PROFILE_WIDGET_CENTERED_EXAMPLE -->

        </div>

        <div class="col-md-5">
            <div class="stat-cell col-sm-4 padding-sm-hr bordered valign-top">
                <!-- Small padding, without top padding, extra small horizontal padding -->
                <h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-info-circle text-primary"></i>&nbsp;&nbsp;<?= $plans['name'] ?>
                    Plan<span style="font-size:80%"><?php if ($plans['name'] != 'Unlimited') { ?> [<a
                            href="https://1s0s.freshdesk.com/support/home">Upgrade</a>]<?php } ?></span></h4>
                <!-- Without margin -->
                <ul class="list-group no-margin">
                    <!-- Without left and right borders, extra small horizontal padding, without background, no border radius -->
                    <li class="list-group-item no-border-hr padding-xs-hr no-bg no-border-radius">
                        Campaigns <span class="label label-pa-purple pull-right"><?php echo $camp_count; ?>
                            / <?php echo $plans['campaigns']; ?></span>
                    </li>
                    <!-- / .list-group-item -->
                    <!-- Without left and right borders, without bottom border, extra small horizontal padding, without background -->
                    <li class="list-group-item no-border-hr no-border-b padding-xs-hr no-bg">
                        Users <span class="label label-success pull-right"><?php echo $user_count; ?>
                            / <?php echo $plans['users']; ?></span>
                    </li>
                    <!-- / .list-group-item -->
                </ul>
            </div>
        </div>
    </div>

    <div class="row">

    <div class="col-md-12">

    <div class="panel panel-default" id="dashboard-recent">
    <div class="panel-heading">
        <span class="panel-title"><i class="panel-title-icon fa fa-exclamation-triangle"></i>Recent</span>
        <ul class="nav nav-tabs nav-tabs-xs">
            <li class="active">
                <a href="#dashboard-recent-comments" data-toggle="tab"><i class="fa fa-bullhorn"></i> News</a>
            </li>
            <li>
                <a href="#dashboard-scheduled-posts" data-toggle="tab"><i class="fa fa-clock-o"></i> Scheduled Posts</a>
            </li>
            <li>
                <a href="#dashboard-features" data-toggle="tab"><i class="fa fa-gears"></i> Features</a>
            </li>
        </ul>
    </div>

    <!-- / .panel-heading -->
    <div class="tab-content">

    <!-- Comments widget -->

    <!-- Without padding -->
    <div class="widget-comments panel-body tab-pane no-padding fade active in" id="dashboard-recent-comments">
        <!-- Panel padding, without vertical padding -->
        <div style="position: relative; overflow: hidden; width: auto; height: 300px;">
            <div class="panel-padding no-padding-vr" style="overflow: hidden; width: auto; height: 300px;">
                <?php foreach ($news as $news_item) { ?>
                    <div class="comment" style="margin-top:10px">
                        <img
                            src="http://www.gravatar.com/avatar/<?php if (is_object(Yii::$app->user->identity)) {
                                echo md5(strtolower(trim('natesanden@gmail.com')));
                            } ?>" alt="" class="comment-avatar">

                        <div class="comment-body">
                            <div class="comment-by">
                                <?= date("M d Y h:i A", $news_item->created) ?>
                                <span
                                    class="pull-right"><?php echo Common::seconds_to_human(time() - $news_item->created); ?>
                                    ago</span>
                            </div>
                            <div class="comment-text">
                                <?php echo $news_item->body; ?>
                            </div>
                            <div class="comment-actions">
                                <?php if (Yii::$app->user->id == 1) { ?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['news/update', 'id' => $news_item->id]) ?>"><i
                                            class="fa fa-pencil"></i>Edit</a>
                                    <a href="#"><i class="fa fa-times"></i>Remove</a>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- / .comment-body -->
                    </div> <!-- / .comment -->
                <?php } ?>
            </div>
            <div class="slimScrollBar"
                 style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; height: 91.93054136874362px; background: rgb(136, 136, 136);"></div>
            <div class="slimScrollRail"
                 style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
        </div>
    </div>
    <!-- / .widget-comments -->


    <div class="widget-scheduled-posts panel-body tab-pane no-padding fade" id="dashboard-scheduled-posts">
        <div style="position: relative; overflow: hidden; width: auto;">
            <div class="panel-padding no-padding-vr"
                 style="overflow: hidden; width: auto;">


    <?php
    Yii::$app->session->open();

    $this->registerJs("
function populateScheduledPosts(page_id)
{
    $.ajax({
        url: '" . Yii::$app->urlManager->createUrl('site/get-scheduled-posts') . "',
        type: 'GET',
        dataType: 'html',
        data: ({
          page_id: page_id,
        }),
        success: function(data, textStatus) {
        console.log('yes');
          $('#scheduled_posts').html(data);
          $('#dashboard-recent-comments > div > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: false });
        }
    });
}
$(document.body).on('change', '#fb_page_dropdown', function(e) {
    populateScheduledPosts($(this).val());
});
");

    //logs the user into FB
    if($_SESSION['fb_token'])
    {
        $fh = Yii::$app->postradamus->setupFacebook([
            'permissions' => ['manage_pages'],
            'redirect_url' => Yii::$app->params['siteUrl'] . Yii::$app->urlManager->createUrl('site/index')
        ]);

        $pages = $fh->get_user_page_list();

        echo "<br />";
        echo yii\helpers\Html::dropDownList('fb_page', '', $pages, ['id' => 'fb_page_dropdown', 'prompt' => 'Choose a page']);
        ?><br /><br />
        <?php
        echo '<div id="scheduled_posts"></div>';
    }
    else
    {
        echo "<a href='" . Yii::$app->urlManager->createUrl('site/login-facebook') . "'>Connect to Facebook</a>";
    }
    ?>
            </div>


    </div>
    </div>


    <!-- Threads widget -->

    <!-- Without padding -->
    <div class="widget-threads panel-body tab-pane no-padding fade" id="dashboard-features">
    <div style="position: relative; overflow: hidden; width: auto;">
    <div class="panel-padding no-padding-vr"
         style="overflow: hidden; width: auto;">



    <?php

    $accordian = [
        'Working with <b>Content</b>|<a href="https://www.youtube.com/watch?v=6IoPzblh_aI" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Content really is King as they say. You need good content if you want to compete at Facebook.
        Postradamus does a good job of helping you find content (mostly viral photos, but also videos and text).<div style="clear:both"></div>' => [
            'Ways to Find Content' => [
                'Find on Web' => [
                    'Facebook' => [
                        'My Pages' => 'Find content on the Facebook pages you manage. This can be really useful if you want to find fan content.',
                        'Other Pages' => 'Search for a similar facebook page using the dropdown search, then pull in all the content from that page.',
                        'Saved Pages' => 'After searching an "other page", you can tell Postradamus to remember it for next time so you can quickly find it again.',
                        'My Groups' => 'Find content on the Facebook groups you manage or are a part of.',
                        'Other Groups' => 'Search for a Facebook group you don\'t belong to and pull in content from it.',
                        'Saved Groups' => 'After searching an "other group", you can tell Postradamus to remember it for next time so you can quickly find it again.',
                        'Remembering Pages and Groups' => 'After searching a page or group, you can click the green "Save" button to tell Postradamus to remember it for next time so you can quickly find it again.',
                        'More Options|If you click the "more options" link you can make your searches more specific.' => [
                            'Posted By' => 'Search for posts that were posted by just <b>fans</b> or just the <b>page owner</b>.',
                            'Post Type' => 'Search for posts that are either <b>Photos</b>, <b>Status updates</b> or <b>Links</b>.',
                            'Caching' => 'If you turn on caching your searches will be much faster. If you turn off caching, your searches will return the most recently created content. Caching lasts for 12 hours for Facebook content.'
                        ],
                    ],
                    'Twitter' => [
                        'Search' => 'Specify one or more keywords to search the entire Twitter website.',
                        'My Timeline' => 'Pull in all the latest tweets from your own Timeline',
                        'My Lists' => 'Pull in all the latest tweets from a specific list you have built at Twitter.',
                        'More Options|If you click the "more options" link you can make your searches more specific.' => [
                            'Result Type' => [
                                'Popular' => 'This will search for the most popular tweets.',
                                'Recent' => 'This will search for the most recent tweets.',
                                'Mixed' => '(Default) This will search for the most popular and recent tweets.'
                            ],
                            'Include Retweets' => [
                                'There could be a lot of duplicate tweets that are pulled. Disable this option to filter them out of search results.',
                            ],
                        ],
                    ],
                    'Pinterest' => [
                        'Keywords' => 'Simply enter a keyword you want to search for and Postradamus will pull back results from all of Pinterest',
                    ],
                    'Instagram' => [
                        'Search by Tag' => 'Search all photos at Instragram for a specific tag (or keyword).',
                        'Most Popular' => 'Search for the most popular Instagram photos.',
                        'More Options|If you click the "more options" link you can make your searches more specific.' => [
                            'Type' => [
                                'All' => 'Retrieve both images and videos.',
                                'Images' => 'Retrieve just images.',
                                'Videos' => 'Retrieve just videos.',
                            ]
                        ],
                    ],
                    'YouTube|YouTube is great for finding, you guessed it, videos! Videos can help tremendously by giving new but interesting content to your fans.' => [
                        'Keywords' => 'Search all videos at YouTube for a specific keyword.',
                        'More Options|If you click the "more options" link you can make your searches more specific.' => [
                            'Category' => 'There are multiple categories at YouTube you can search through to narrow your searches.',
                            'Duration' => 'Choose what duration (time length) videos you want to find - Long, Medium or Short.',
                            'Definition' => 'Choose the definition (HD or Standard) videos you want to find - High or Standard.',
                            'Film Type' => 'Choose which film types you want to find - Episodes or Movies. ',
                            'Result Type' => 'Choose which metric you want to use when determining which videos to retrieve - Newest, Highest Rated, Most Relevant, Highest View Count.',
                            'Safe Search' => 'Choose which safety rating you want to use when determining which videos to retrieve - Moderate, Strict, None.',
                        ],
                    ],
                    'Amazon|Find books, toys and all kinds of other products on Amazon. Search results automatically include your affiliate link!' => [
                        'Keywords' => 'Search all products at Amazon for a specific keyword.',
                        'More Options|If you click the "more options" link you can make your searches more specific.' => [
                            'Category' => 'There are multiple categories at Amazon you can search through to narrow your searches.',
                            'Country' => 'Choose which country you want to search for products in.',
                            'Minimum Price' => 'You can choose a minimum price you want your search to return products for.',
                            'Maximum Price' => 'You can choose a maximum price you want your search to return products for.',
                            'Caching' => 'If you turn on caching your searches will be much faster. If you turn off caching, your searches will return the most recently created content. Caching lasts for 10 days for Amazon content.',
                        ],
                    ],
                    'Imgur' => [
                        'Keywords' => 'Search Imgur for a specific keyword.',
                    ],
                    'Webpage' => [
                        'Webpage URL' => 'Enter a webpage URL and find the images contained on the webpage.',
                    ],
                    'Feeds' => [
                        'Search Feeds' => 'Search for a similar feed using the dropdown search, then pull in all the content from that feed.',
                        'Specific Feed URL' => 'Enter a custom feed URL and retrieve all the entries from it.',
                        'Remembering Feeds' => 'After searching a feed on the "Search Feeds" tab, you can click the green "Save" button to tell Postradamus to remember it for next time so you can quickly find it again.',
                        'Saved Feeds' => 'Find content from a feed that you previously saved.',
                    ],
                ],
                'Find on Computer' => 'Browse your hard drive for photos and mass upload them to Postradamus.',
                'Find in Existing List' => 'Search through a list you created previously for content. You can use this to copy content between lists.',
                'Don\'t show content i\'ve already saved' => 'Turn this option on to hide any content you\'ve previously saved to a list.',
            ],
            'Deciding Which Content to Save' =>
            'Most types of content you find will also have statistics that help you in choosing the best content to repost to your page.
            Facebook content for example, tells you how many likes, comments and shares the post has.
            Twitter, will tell you the retweets and favorites counts each tweet has. You should choose content that you know will resonate well with your audience. Look in your Facebook insights for old posts that did well. Also look at your competitors Facebook pages (you can use Postradamus for that) to see which of their posts have done well. Also don\'t be afraid to experiment and be bold. Put up a post that you know will be controversial from time to time to get people talking.'
            ,
            'Saving Content|There are a few steps to take in order to save the content you find so you can later send them to your Facebook page.' => [
                'Selecting the Content' => 'You can press the "select" button underneath each piece of content or press the "Select All" button to select them all at once.',
                'Choose Where to Save the Content|After selecting which content you want to save, simply scroll to the bottom of the page and choose which list to save it all to.' => [
                    'Existing List' => 'If you already have a list created that you want to save the content to, you can choose it from the drop down.',
                    'New List' => 'If you want to save the content to a new list that you haven\'t yet created, you can do so by choosing this option and entering a name for your list.',
                ],
                'Additional Options|If you click the "more options" link you can perform some actions on your content before it gets saved to a list.' => [
                    'Assign a Post Type' => 'You can assign a "<a href="' . Yii::$app->urlManager->createUrl('post-type/index') . '">Post Type</a>" that you have previously created, to all of the selected posts, before adding them to a list.',
                    'Apply a Post Template' => 'You can apply a "<a href="' . Yii::$app->urlManager->createUrl('post-template/index') . '">Post Template</a>" that you have previously created, to all of the selected posts, before adding them to a list.'
                ]
            ]
        ],
        'Working with <b>Lists</b>|<a href="https://www.youtube.com/watch?v=ld45NMwZPEw" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>You create lists and then perform actions such as adding posts to them as well as scheduling the posts. After you have finished building your list, you can export it to various sources such as Facebook.<div style="clear:both"></div>' => [
            'Types of Lists' => [
                'Not Ready' => 'These lists have posts in them that are not yet scheduled or are scheduled incorrectly.',
                'Ready' => 'The posts in theses lists are all scheduled properly and the lists are ready to be exported.',
                'Sent' => 'Theses lists have already been exported.',
            ],
            'Create List' => 'You can create a new list by supplying a name.',
            'Manipulating a List' => [
                'List View' => 'List view will display all the posts in your list as a list in a gallery type format.',
                'Calendar View' => 'Calendar view will show all your posts on a day/week or month calendar. You also have drag and drop abilities to move posts to different days and times on the calendar.',
                'Search|You can search through your list and only display certain types of posts.' => [
                    'Post Type' => 'You can specify which posts you want to view based on their "Post Type".',
                    'Scheduled' => 'You can specify whether you want to see all scheduled posts or unscheduled posts or both.',
                    'Name' => 'You can search for posts with a name value that contains certain keywords.',
                    'Text' => 'You can search for posts with a text value that contains certain keywords.',
                ],
                'Modify List|This is your go to button to access many of the various ways to make changes to your list.' => [
                    'Rename' => 'This screen allows you to rename your list.',
                    'Clear' => 'Remove all posts from your list.',
                    'Duplicate' => 'Duplicate your entire list, including all of its posts. This will create a new list with the name you specify.',
                    'Mark as Sent' => 'If use the <b>Macros</b> export option you should use this tool to mark your list as "Sent" after you run the macro.',
                    'Scheduler|The scheduler is a powerful tool that automatically chooses dates and times for all posts in your list given a schedule you choose.' => [
                        'Lookup Last Scheduled Time' => 'You can use this tool to find the last scheduled post for any of your Facebook pages. This helps you choose a schedule Start Date for your list.',
                        'Start Date' => 'You can choose a Start Date of when you want your first post to be scheduled.',
                        'Schedule' => 'You must choose a <b>Schedule</b> that you have previously created for the Scheduler to use.',
                        'Time Randomization' => 'This will add or subtract up to 20 minutes onto the scheduled time of each post. Useful if you want more randomized/varied times.',
                        'Post Randomization' => 'This will shuffle your posts as the scheduler runs.',
                        'Unscheduled Posts Only' => 'You can tell the scheduler to only run on posts that are not already scheduled. This way if you schedule things manually, the scheduler will not overwrite your scheduled posts.',
                    ],
                ],
                'Sorting' => 'Sort the posts in your list by their Name, Content Source, Post Type, Scheduled Time, Last Updated, Created Date',
                'Select All' => 'You can press a Select All button to select all posts that are visible on your screen.',
                'Working with Posts' => [
                    'Create a Post' => 'You can click the "New Post" button to create a new post in your list.',
                    'Content Source Icon' => 'Each post in your list will have a small icon on the top left that indicates where the post came from. Mouse over the icon for more information.',
                    'Post Type Icon' => 'Each post in your list will have a small icon on the top left that indicates what <b>Post Type</b> the post is. Mouse over the icon for more information.',
                    'Scheduled Date and Time' => 'Each post in your list will have a date and time you have scheduled it for or it will display "Not yet scheduled" in red.
                If the scheduled date and time is in <font color="green">green</font>, it means the date is in the future and is valid.
                If the scheduled date and time is in <font color="red">red</font>, it means the date is in the past or is invalid.
                You will need to fix the post by either running the <b>Scheduler</b> again or by editing the post itself and choosing a new scheduled date and time.',
                    'Image Editor|<a href="https://www.youtube.com/watch?v=hMaeDcPFlkM" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Mouse over any post image and you should see an icon on the top right of it that you can click to open the Image Editor.
                    The Image Editor allows you to add text and images to your post image. Any text or images you add can be dragged around and modified in various ways.' => [
                        'Canvas Controls' => [
                            'Add Text' => 'Add Text to your Image. Text can be resized and rotated once added to the canvas.',
                            'Add Meme Text' => 'Adds text to the top and bottom of your image. This text is styled in the typical way that most Memes on the web are created.',
                            'Add Image' => 'You can upload your own images, buttons, icons which you can then add to your image.',
                        ],
                        'Object Controls|Select an object on your image like text or another image and drag it around, resize it and manipulate it all kinds of ways.' => [
                            'Opacity' => 'You can move the slider up or down to change the opacity of the object.',
                            'Bring to Front' => 'You can bring an object forward so it sits on top of other objects.',
                            'Delete' => 'Delete the object.',
                            'Bold' => 'You can bold text with the "bold" button.',
                            'Italic' => 'You can italicize text with the "italic" button',
                            'Font Family' => 'You can change the font of any text.'
                        ],
                        'Save' => 'You can save the changes you made to your post image and even come back to it later to make more changes.',
                    ],
                    'Quick Edit' => 'If you mouse over the text of a post it should turn gray. You can then click the text and a box should open allowing you to quickly modify the text.',
                    'Select|You can select individual posts one at a time with the "Select" button. Once selected, you can perform various tasks on the selected posts.' => [
                        'Change Post Type' => 'You can change the <b>Post Type</b> of all selected posts at once.',
                        'Delete' => 'Delete the selected posts from your list.',
                        'Duplicate' => 'Duplicate the selected posts.'
                    ],
                    'Edit Post|Click the blue pencil button to go into an individual post and make changes to the post itself.' => [
                        'Scheduled Time' => 'Manually choose a date and time for your post to be scheduled.',
                        'Name' => 'Give your post a name of your choosing. This is for your own internal purposes only.',
                        'Text' => 'Change the post text that will appear when you publish the post to Facebook.',
                        'Link' => 'If you choose to specify a link for your post, the post will turn into a "Link" (or "Video" if the link is to a YouTube video) post on Facebook.',
                        'Image' => 'Add or change the image(s) attached to the post. You can upload multiple images but this feature only works if you use the <b>Facebook Macros (Advanced)</b> option when exporting to Facebook.',
                        'Post Type' => 'You can choose a <b>Post Type</b> for your post.',
                    ],
                ],
            ],
        ],
        'Working with <b>Campaigns</b>|<a href="https://www.youtube.com/watch?v=f-rFLvBAbcw" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Campaigns allow you to group specific lists, schedules, post types and post templates. Think of a "campaign" as a Facebook page.
        If you have several Facebook pages you work with it might make sense to use different schedules, post templates, post types, etc for each of your Facebook pages.' => [
            'Master Campaign' => 'Anything you build inside of the "Master Campaign" can be seen and used inside your other campaigns.
            For example, if you create a schedule in your Master Campaign, then all campaigns will be able to see and use that schedule.
            This is useful if you only want to build a schedule one time and use it no matter which campaign you\'re working with.',
            'Creating a Campaign' => 'You can go into Settings > Campaigns and then click the "New Campaign" button to create a new Campaign.
            Or, on any page of Postradamus, look near the top right for the text "Master Campaign". Click that text and choose "New Campaign".',
            'Switching Campaigns' => 'Near the top right of any page, you can click the drop down to change to a different Campaign.
            Once you have changed to a different campaign, you will only see lists, post templates, post types, schedules, etc that you have created for that specific campaign or the <b>Master Campaign</b>.',
        ],
        'Working with <b>Users</b>' => 'Users allow you to give others (such as employees or virtual assistants) access to your Postradamus account.
            These users will have limited privileges (they will not be able to view/modify users or view/modify connections) but will be able to see and modify any lists, posts, schedules, templates and post types you have created.',
        'Working with <b>Schedules</b>|<a href="https://www.youtube.com/watch?v=FlYCXNLyqy4" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>When you create a schedule you are essentially building a template that can be used over and over to give all the posts in your lists times and days to publish to your Facebook page.
        This saves you time so you don\'t have to pick individual dates and times for each post. It also can give you a good starting point when using the Calendar feature of Lists.' => [
            'Creating a Schedule|After providing a name for your schedule you are brought into the schedule editor where you can times (for each day of the week) you want Facebook posts to publish to your page.' => [
                'View Individual Weekday' => 'You can click on a weekday (for example Tuesday) and view the specific times you have created for that weekday.',
                'Existing Times' => 'You can edit or delete the existing times for the specific weekday you are looking at.',
                'Add Time' => 'Using the time field, you can enter a specific time you want to schedule a post for your Facebook page. You then need to choose which weekdays (using the checkboxes) you want to add the specified time to.',
                'Post Types Field' => 'You can choose a specific <b>Post Type</b> (or multiple) for each time you enter into your schedule. This gives you the ability to do things like only scheduling "Money" posts on Monday morning.',
            ],
            'Using a Schedule' => 'When inside a list, you can click "Modify List" and then choose "Scheduler" from the dropdown. You can then choose the Schedule you created previously and apply that to the posts in your list.',
        ],
        'Working with <b>Post Templates</b>|<a href="https://www.youtube.com/watch?v=CJQKra3XLds" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Post templates allow you to construct the layout of the text and images in posts you get back from various sources so you don\'t have to do as much editing to posts before sending them to Facebook.<div style="clear:both"></div>' => [
            'Modifying the Text' => 'Typically, when you send a post to your Facebook page, you\'re going to want to have some text that goes along with it (and/or a photo). When finding content from various sources, Postradamus tries its best to find text that you can use for your posts. Sometimes you may not want to use that text, or you may want to tweak it. Using Post Templates, that is very easy to do. For example, you could use a blank Post Template to completely ignore the text Postradamus found. Or you could use the following Post Template to add your own plug below the text Postradamus finds. "{text} Check out MyDogs.com".',
            'Modifying the Image' => '<a href="http://youtu.be/LkCMDcqd4HM?list=PLGZu5E9ifiNf0XiGK4_WiOarOcFDnqHj4" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Just as you can edit the text of the post, you can also edit the image that Postradamus finds. You can add your own watermarks, copyrights, call to actions, etc.',
            'Tokens' => 'Each source of content has its own "tokens" that you can use to help construct the text elements of your post. For example, Facebook has tokens such as {text} {author_name} {like_count}. You could construct a post like "{text} by {author_name}" and this would result in {text} being replaced by the text that was found from the Facebook post and {author_name} being replaced with the authors name (in the case of Facebook, that would be the page name typically).<br /><br />Tokens can also be shortened like {text:50} in the case that text might be longer than you\'d like it to be. Finally, tokens can be used inside spin text to make for very powerful templates.',
            'Spin Text' => 'Spin text is a feature which allows you to create several versions of text that will be randomly cycled through and chosen from when the template is applied to your content. For example, you could create some spin text like: {text} [Check out MyDogs.com|Learn more at MyDogs.com|More dogs at MyDogs.com] and Postradamus will randomly select only one of the 3 versions of "MyDogs.com" text when it applies your template to your selected content.<br /><br />Spin text is very flexible allowing you to use "tokens" as well as even nested spin tags.',
        ],
        'Working with <b>Post Types</b>' => '<a href="https://www.youtube.com/watch?v=G-sDq_zKuXw" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Post types are a way to categorize your posts. For example, you might create a post type called \'Money\', then any affiliate link posts that you create (for example an amazon book link) you would assign with the \'Money\' post type.
    You then can setup your scheduler to assign the \'Money\' post type at certain times of the day or certain weekdays only.',
        '<b>Exporting</b> (or <b>Publishing</b>)|<a href="https://www.youtube.com/watch?v=jCdOo3l_NSY" target="youtube"><img src="' . Yii::$app->params['imageUrl'] . '/video-icon.png" align="left" style="margin-right: 10px; margin-bottom:10px"></a>Publish your posts to Facebook or export your posts to a CSV file.<div style="clear:both"></div>' => [
            'FB Direct (Easy)|Using this export method will send your list directly to Facebook using the Facebook API.
            Posts will show up in your Facebook Scheduler and will be published when they\'re ready.' => [
                'From' => 'You can choose which list you want to export to Facebook.',
                'Facebook Page' => 'You can choose which page you want your list to be published to.',
            ],
            'FB Macro (Advanced)' => [
                'From' => 'You can choose which list you want to export to Facebook.',
                'Facebook Page' => 'You can choose which page you want your list to be published to.',
                'Proceed' => 'After clicking the "Proceed" button you will have a list of instructions you must follow to get this advanced feature working.'
            ],
            'CSV' => 'Choose a list you want to export and Postradamus will give you a CSV file containing all of your posts along with their text, image url\'s, scheduled date and more.',
        ],
        'Configuration <b>Settings</b>' => [
            'Timezone' => 'If you plan on using the Facebook Direct (easy) export option you should <a href="' . Yii::$app->urlManager->createUrl('setting/update') . '">specify your timezone</a> in Postradamus so your posts get scheduled to Facebook at the correct times.',
            'Time and Date Format' => 'You can setup your own <a href="' . Yii::$app->urlManager->createUrl('setting/update') . '">time and date format</a> for Postradamus to use any time it displays a time or date. Right now, your times and dates will look like this: <i>' . date(Yii::$app->postradamus->get_user_date_time_format()) . '</i>',
            'Connections' => [
                'Facebook' => 'You can choose to setup your own Facebook App to connect Postradamus to.
            The advantages of this are minimal right now, but in the future this step may be required, if you plan to use the Facebook export option.',
                'Amazon' => 'If you have one or more Amazon Affiliate Accounts you can set them up here.
            When searching for Amazon content, Postradamus will turn the product links into affiliate links so you can earn commissions on any sales.',
            ]
        ],
    ];

    $i = 1;
    $parent = 'p1';

    ?>




    <div class="row" style="padding-top:15px; padding-bottom: 15px">
        <div class="col-md-12">

            <?php
            $iterator = new RecursiveIteratorIterator(
                new RecursiveArrayIterator($accordian),
                RecursiveIteratorIterator::SELF_FIRST
            );
            ?>
            <div class="panel-group" id="accordion<?php $parent ?>">
                <?php foreach ($accordian as $key => $item): ?>
                    <div class="panel">
                        <div class="panel-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php $parent ?>"
                               href="#collapse<?php echo $i ?>">
                                <?php $newkey = explode("|", $key); ?>
                                <?php echo $newkey[0] ?>
                            </a>
                        </div>
                        <div id="collapse<?php echo $i ?>" class="accordion-body collapse">
                            <div class="panel-body">
                                <?php if ($newkey[1]) { ?><p><?php echo $newkey[1]; ?></p><?php } ?>
                                <div class="accordion-inner">
                                    <!-- Here we insert another nested accordion -->
                                    <?php if (is_array($item)): $slug = make_slug($key);
                                        loop($item, $slug) ?>
                                    <?php else: echo $item; endif ?>


                                    <!-- Inner accordion ends here -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; endforeach ?>
            </div>
            <?php
            function make_slug($parent)
            {
                return md5($parent . rand(0,99999));
            }

            function loop($array, $slug)
            {
                ?>
                <?php foreach ($array as $key => $val): $key_slug = make_slug($key); ?>
                <div class="panel">
                    <div class="panel-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_<?php echo $slug ?>"
                           href="#collapseInner<?php echo $key_slug ?>">
                            <?php $newkey = explode("|", $key); ?>
                            <?php echo $newkey[0] ?>
                        </a>
                    </div>
                    <div id="collapseInner<?php echo $key_slug ?>" class="accordion-body collapse">
                        <div class="panel-body">
                            <?php if ($newkey[1]) { ?><p><?php echo $newkey[1]; ?></p><?php } ?>
                            <div class="accordion-inner">
                                <?php if (is_array($val)): $slug = make_slug($key) ?>
                                    <?php loop($val, $slug) ?>
                                <?php else: echo $val; endif ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php
            }

            ?>

        </div>
    </div>



    </div>
    <div class="slimScrollBar"
         style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; background: rgb(136, 136, 136);"></div>
    <div class="slimScrollRail"
         style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
    </div>
    </div>
    <!-- / .panel-body -->
    </div>
    </div>
    <!-- / .widget-threads -->
    </div>

    </div>

<?php if (Yii::$app->user->id == 1) { ?>
    <p style="margin-top:20px"><a href="<?= Yii::$app->urlManager->createUrl('news/create') ?>">Add News</a></p>
<?php } ?>