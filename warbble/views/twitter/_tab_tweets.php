<?php if(!$current_user->get_twitter_tokens()): ?>
    <div class="col-xs-12 col-md-12">
        <div class="alert alert-warning margin-top-25" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Warning:</span>
            Currently you don't have Twitter account. You can add <a href="/Twitter/add_account">this one</a>.
        </div>
    </div>
<?php else: ?>
    <div class="tab-tweets">
        <div class="col-xs-12 col-md-5 first-col margin-top-25 tweets">
            <div class="col-inner section">
                <form id="new-tweet" role="form">
                    <div class="col-xs-6 no-padding form-title">New Tweet</div>
                    <div class="col-xs-6 no-padding">
                        <input type="text" name="tweet[date]" id="tweet_date" class="form-control single-datepiker">
                    </div>

                    <div class="form-separator"></div>

                    <div class="col-xs-12 no-padding">
                        <textarea name="tweet[text]" id="tweet_text" maxlength="140" class="form-control"></textarea>
                        <p class="tweet-text-count-left">140</p>
                    </div>

                    <div class="form-separator"></div>

                    <div class="col-xs-12 no-padding actions">
                        <div class="col-xs-6 no-padding">
                            <div class="upload-btn">
                                <img src="<?php echo BASE_URL; ?>assets/admin/img/empty-pic.png" alt="">
                                <span>Upload photo</span>
                            </div>
                        </div>
                        <div class="col-xs-6 no-padding">
                            <button type="submit" data-type="<?php echo Tweets_Model::TYPE_NOW ?>" class="btn btn-blue pull-right new-tweet-submit btn-submit-now">TWEET NOW</button>
                            <button type="submit" data-type="<?php echo Tweets_Model::TYPE_TIME ?>" class="btn btn-green pull-right new-tweet-submit btn-submit-sedule">SHEDULE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-md-7 last-col margin-top-25">
            <div class="tweets-table no-padding">
                <?php $this->view('twitter/_tweets_table', array(
                    'gridview'          => $gridview
                )) ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $medialibrary->render('tweets', array("title" => "Pictures bank", "dragtext" => "Drag your picture here", "accept" => 'image/*')); ?>
