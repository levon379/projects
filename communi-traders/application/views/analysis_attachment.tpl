 <html>
 <head>
     <meta charset="utf-8"/>
     <meta http-equiv="content-type" content="text/html; charset=utf-8">

 </head>
    <body>
       <div id="preshare">
        <ul class="post_top_list">
            <li><div class="title_pl text-left">P&L<br><div id="pl">&nbsp;&nbsp;-</div></div></li>
            <li><div class="title_investment text-left">Investments<br><div id="investments">&nbsp;&nbsp;-</div></div></li>
            <li><div class="title_time text-left"><span id="time_top">-</span><br/><span class="clock"></span><span id="time_bot">-</span></div></li>

        </ul>

    </div>
      <div id="chart_box">
            <input type="hidden" id="game_id" name="game_id" value="{$game_id}" />
            <div id="container"><img id="ct_chart_image" alt="{$title}" src="/get_graph_image.php?game_id={$game_id}"/></div>

            <div id="status_content">
                <div id="status_option_name">
                    <div class="name_option">
                        Assets
                    </div>
                    <div id="status_assets">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Expiry Time
                    </div>
                    <div id="status_expire">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Will Expire in
                    </div>
                    <div id="status_expire_in">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Strategy
                    </div>
                    <div id="status_strategy">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Entry Price
                    </div>
                    <div id="status_prices">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Cur/Exp Price
                    </div>
                    <div id="current_price">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Trade's LIVE status
                    </div>
                    <div id="status_live">
                        &nbsp;&nbsp;-
                    </div>
                    <div class="name_option">
                        Disclosure
                    </div>
                    <div id="disclosure">
                        &nbsp;&nbsp;-
                    </div>

                </div>

            </div>
        </div>
      <div id="chart_message">{$chart_message}</div>
    <div class="chart_devider"></div>
       <div id="status_value" class="game_value">

           <div id="share_facebook_btn">
               <a href="#" onclick="refreshGameStat({$game_id}); return false;"><span class="share_facebook_btn"></span></a>
           </div>
           <div id="share_twitter_btn">
               <a href="#" onclick="refreshGameStat({$game_id}); return false;"><span class="share_twitter_btn"></span></a>
           </div>
           <div id="like_btn">
               <a href="#" onclick="refreshGameStat({$game_id}); return false;"><span class="like_btn">677</span></a>
           </div>
           <div id="suck_btn">
               <a href="#" onclick="refreshGameStat({$game_id}); return false;"><span class="suck_btn">223</span></a>
           </div>

           <div id="refresh_btn">
               <a href="#" onclick="refreshGameStat({$game_id}); return false;"><span class="refresh_btn"></span></a>
           </div>

           <div id="copy_trade_btn">
               <a href="{$url}?game_id={$game_id}" ><span class="copy_trade_btn"></span></a>
           </div>



       </div>

    </body>
</html>
