<link href="<?php echo $base_url; ?>assets/admin/css/c3.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $base_url; ?>assets/admin/js/d3.v3.min.js"></script>
<script type="text/javascript" src="<?php echo $base_url; ?>assets/admin/js/c3.min.js"></script>
<div id="content" class="col-xs-12 col-sm-10">

    <!--<div id="about">

        <div class="about-inner">

            <h4 class="page-header">Open-source admin theme for you</h4>



            <p>DevOOPS team</p>



            <p>Homepage - <a href="http://devoops.me" target="_blank">http://devoops.me</a></p>



            <p>Email - <a href="mailto:devoopsme@gmail.com">devoopsme@gmail.com</a></p>



            <p>Twitter - <a href="http://twitter.com/devoopsme" target="_blank">http://twitter.com/devoopsme</a>

            </p>



            <p>Donate - BTC 123Ci1ZFK5V7gyLsyVU36yPNWSB5TDqKn3</p>

        </div>

    </div>-->
    <div id="ajax-content">

        <?php if(!$twitter_meta): ?>
        <div class="tw-add-account">
            <div id="dashboard-header" class="row dashboard-head">

                <div class="dashboard-headline">

                    <div class="col-xs-12 col-sm-8 col-md-8">

                        <h3>Add a Twitter Account</h3>
                        <br>
                        <p>Please add you Twitter account to get feed.</p>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="row stats_wrap">
                <div class="col-xs-12 col-sm-8 col-md-8">
                    <a href="/Twitter/add_account" class="btn btn-info add-twitter-account">Add an account</a>
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="col-xs-12 col-md-8 daily-progress">
                <div class="col-inner section">
                    <h3 class="title">Twitter account information</h3>
                    <p class="description"></p>

                    <div class="pull-right timeline">

                        <div class="period_time pull-right">

                            <input type="text" class="form-control twitter_datepicker" value="<?php echo sprintf('%s - %s', $startDate, $endDate) ?>">

                        </div>

                    </div>

                    <div class="twitter-chart-info">
                        <?php echo $this->view('dashboard/social/_twitter_chart', array(
                            'favorites_chart'   => $favorites_chart,
                            'chart_categories'  => $chart_categories,
                            'startDate'         => $startDate,
                            'endDate'           => $endDate,
                        ), TRUE) ?>
                    </div>
                    <div id="twitter_chart" data-columns='[<?php echo json_encode($favorites_chart) ?>, <?php echo json_encode($retweets_chart) ?> ]' data-categories='<?php echo json_encode($chart_categories) ?>'></div>
                </div>
            </div>

            <!--<div class="col-xs-6 col-md-4">
                <div class="col-inner section">
                    <form id="new-tweet" role="form">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input type="password" class="form-control" id="pwd">
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox"> Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            </div>-->

        <?php endif; ?>

    </div>
</div>

<!--End Dashboard -->
