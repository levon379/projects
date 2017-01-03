<div class="body_wrapper" onmouseover="hidePromt();">
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">How to trade</h3>
        </div>
        <div class="modal-body">
            <p>
            <table border="0" align="center" cellpadding="15" cellspacing="10" style="background:#6AEB6A;">
                <tr>
                    <td align="center" id="first_colum" valign="top" width="25%">
                        <h4>How it works?</h4>
                        <p>Choose the asset to trade</p>
                        <p>&darr;</p>
                        <p>Choose your <b>Strategy</b></p>
                        <p>&darr;</p>
                        <p>Choose an <b>expire</b></p>
                        <p>&darr;</p>
                        <p>Set the <b>Investment</b></p>
                        <p>&darr;</p>
                        <p>
                            Enter your <b>price/s</b>
                            (only if it's boundary or touch option)
                        </p>
                        <p>&darr;</p>
                        <p>Add <b>text</b> or <b>drawing</b> to the analysis</p>
                        <p>&darr;</p>
                        <p>
                            Add <b>title and describe</b>, Why you<br /> think
                            its a great trade?
                        </p>
                        <p>&darr;</p>
                        <p>
                            <b>"Share"</b>
                            or Just Press <b>"Trade!"</b> To see how your trade
                            did after expire.
                        </p>
                    </td>
                    <td align="center" id="second_colum" valign="top" width="25%">
                        <h4>Your Balance</h4>
                        <p>
                            Your accaunt is privided with<br />
                            an initial amount of <b>$20.000</b>
                        </p>
                        <p>&darr;</p>
                        <p>Maximun investment is <b>$2.000</b></p>
                        <p>&darr;</p>
                        <p>Minimum trade is <b>$10</b></p>
                        <p>&darr;</p>
                        <p>Increments are <b>10$</b></p>
                        <p>&darr;</p>
                        <p><b>Win and share!</b></p>
                        <p><br/><br /><h5>My Performance</h5></p>
                        <p>
                            In <b>My Performance</b> you can<br /> see
                            your past trade statistic.<br />
                            For ex: what is your or another
                            forum member <b>Best Trading
                                Strategy?</b>
                        </p>
                    </td>
                    <td align="center" id="third_colum" valign="top" width="25%">
                        <h4>Strategies</h4>
                        <p>
                            <b>Call</b> - price has to close
                            above entry price to be in the
                            money, after the expiry.
                        </p><br />
                        <p>
                            <b>Put</b> - price has to close
                            below entry price to be in the
                            money, after the expiry.
                        </p><br />
                        <p>
                            <b>Touch</b> - Price has to reach a
                            specific value until the expiry
                            is over to be in the money.
                        </p><br />
                        <p>
                            <b>No Touch</b> - Price doesn't has
                            to be reach a specific value
                            until the expiry is over to be
                            in the money.
                        </p><br />
                        <p>
                            <b>Bounderi Out</b> - Price has to
                            go or above 3 or below 1 to
                            be In the money, (current
                            price is in the middle at 2).
                            User Has to be able to place
                            two prices. ( 1,3)
                        </p>
                        <p>
                            <b>Bounderi inside</b> - Price has
                            to stay between two numbers
                            for ex: below 3 and above 1
                            to be In the money. (current
                            price is in the middle at 2).
                            User Has to be able to place
                            two prices. ( 1,3)
                        </p>
                    </td>
                    <td align="center" id="fourth_colum" valign="top" width="25%">
                        <h4>Sharing And Trading</h4>
                        <p>
                            Each trade you do at
                            CommuniTraders can be
                            shared with the rest of the
                            forum members with the
                            "Share" button. If you prefer
                            not  to share and just trade
                            for fun you can use the
                            "Trade!"  button , which will
                            just save your  trade into
                            your trading <b>Profile</b>. In your
                            user profile you will be able
                            to see your performance
                            report, open and closed
                            trades as well, along with
                            great statistics for yourself
                            and also other Communi Traders.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="justify" id="fifth_colum" valign="top" colspan="4">
                        <br />
                        We are inviting you to share your stock analysis , Ideas and market outlook at CommuniTraders Forum! Enjoy!
                        BinaryOptionsThatSuck.com Team
                    </td>
                </tr>
            </table>
            </p>
        </div>
    </div>
    <div id="myCalendar" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">       
        <div class="modal-header calendar_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Financial calendar</h3>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">
                    <tr>
                        <th>Date (GMT)</th>
                        <th>Event</th>
                        <th>Cons.</th>
                        <th>Actual</th>
                        <th>Previous</th>
                    </tr>
                </thead>
                <tbody id="event_block">

                </tbody>
            </table>
        </div>
    </div>
    <div id="myLeaderBoard" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">       
        <div class="modal-header calendar_header">
            <button type="button" class="close close_white" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">CommuniTraders Leaders Board</h3>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead class="table_header_leader">
                    <tr>
                        <th></th>
                        <th>Avatar</th>
                        <th>NickName</th>
                        <th>% Winning Rates</th>
                        <th># Winning Trades</th>
                        <th>Best Strategy</th>
                        <th>Best Asset</th>
                    </tr>
                </thead>
                <tbody id="leader_block">
                </tbody>
            </table>
        </div>
    </div>
    <div id="tool_container">
        <form action="{$url}newpost/newthread" method="post" id="post_form" enctype="multipart/form-data">
            {$ci_csrf_token}
            {if $validation_erros <> ''}
            <div id="errors">
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">×</button>        
                    <div id="errors_box" class="errors"><strong>{$validation_erros|default:''}</strong></div>
                </div>
            </div>
            {/if}      
            <div id="blockrow">
                <label for="subject" class="full">Title:</label>
                <input type="text" class="primary_full_textbox" value="{$inputRows.comment_header|default:''}" id="title" name="title" placeholder="Enter Your Analysis's Title Here (default text)"/>
            </div>    
            <div id="tool_menu">
                <div id="tab_menu">
                    <div id="slogan">
                        <div id="slogan_box">Add Lines And Text To You Analysis</div>
                    </div>
                    <div id="tab_box">
                        <div class="menu_tab">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#">CommuniTraders</a>
                                </div>
                            </div>
                            <div class="corner"></div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="{$url}myperformance">My performance</a>
                                </div>
                            </div>
                            <div class="corner"></div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myModal" data-toggle="modal">How To Trade</a>
                                </div>
                            </div>
                            <div class="corner"></div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myCalendar" data-toggle="modal" onclick="getCalendar(); return FALSE">Financial Calendar</a>
                                </div>
                            </div>
                            <div class="corner"></div>
                        </div>
                        <div class="menu_tab menu_tab_border">
                            <div class="menu_a">
                                <div class="a_text">
                                    <a href="#myLeaderBoard" data-toggle="modal" onclick="getLeadersBoard(); return FALSE">Leaders Board</a>
                                </div>
                            </div>
                            <div class="corner"></div>
                        </div>
                    </div>
                </div>
                <div id="chart_panel">
                    <div id="draw_box">
                        <div id="draw_data"></div>
                        <ul class="chart_buttons">
                            <li><a href="#" id="line" class="button toolButton" onclick="selectedTool(this.id);return false;">      
                                    <img src="{$url}assets/images/buttons/h_line.png" alt=""/>
                                </a>
                            </li>
                            <li><a href="#" id="remove" class="button toolButton" onclick="selectedTool(this.id);return false;">      
                                    <img src="{$url}assets/images/buttons/crosser.png" alt=""/>
                                </a>
                            </li>                               
                            <li><a href="#" id="full_screen_0" class="button toolButton">      
                                    <img src="{$url}assets/images/buttons/full_screen.png" alt=""/>
                                </a>
                            </li>
                            <li><a href="#" id="exit_full_screen_1" class="button toolButton">      
                                    <img src="{$url}assets/images/buttons/exit_full_screen.png" alt=""/>
                                </a>    
                            </li>                             
                        </ul>
                    </div>
                    <div class="info_box">
                        <div id="info_balance">Balance1:&nbsp;</div>
                        <div id="info_oppos">Open position1:&nbsp;</div>
                        <div id="info_pl">Today's P&L1:&nbsp;</div>
                    </div>
                </div>                      
            </div>
            <div id="buble">
                <div id="tool_box">                  
                    <div id="container"></div>
                    <div id="select_status"></div>
                    <input id="userCache" type="hidden" value="{$userCache}">
                    <div id="lower_box">
                        <div id="post_box">
                            <div id="dashboard">
                                <div id="dashboard_container">
                                    <select id="what" onChange="runWithoutGame()" class="chzn-select">
                                        <option selected="selected" value="">Choose Asset--></option>
                                        <optgroup label="STOCK">
                                            {section name=co loop=$symbols_company} 
                                            <option value="{$symbols_company[co].short_name}">{$symbols_company[co].full_name}</option>
                                            {/section} 
                                        </optgroup>
                                        <optgroup label="INDICES">
                                            {section name=i loop=$symbols_indices} 
                                            <option value="{$symbols_indices[i].short_name}">{$symbols_indices[i].full_name}</option>
                                            {/section} 
                                        </optgroup>
                                        <optgroup label="CURRENCY PAIRS">
                                            {section name=c loop=$symbols_currency} 
                                            <option value="{$symbols_currency[c].short_name}">{$symbols_currency[c].full_name}</option>
                                            {/section} 
                                        </optgroup>
                                        <optgroup label="COMMODITIES">
                                            {section name=m loop=$symbols_metall} 
                                            <option value="{$symbols_metall[m].short_name}">{$symbols_metall[m].full_name}</option>
                                            {/section} 
                                        </optgroup>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select id="expire" class="select_small chzn-select">
                                        <option selected value="">Expiry--></option>
                                        {section name=ex loop=$expiry} 
                                        <option value="{$expiry[ex].expiry_value}">{$expiry[ex].expiry_name}</option>
                                        {/section} 
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div id="strategy_select" onmouseout="hidePromt();">
                                        <div id="strategy_val">
                                            <input id="strategy" type="hidden" value="">
                                        </div>
                                        <ul class="nav" id="strategy_ul" role="navigation" onmouseout="hidePromt();">
                                            <li class="dropdown">
                                                <a id="drop1" href="#" role="button" class="dropdown-toggle" onmouseout="hidePromt();" data-toggle="dropdown">
                                                    Choose Srategy-->
                                                </a>
                                                <span id="caret_box" class="caret"></span>
                                                <ul class="dropdown-menu" id="dropdown_items" role="menu" aria-labelledby="drop1">
                                                    {section name=s loop=$strategy} 
                                                    <li onmouseover="showPromt('{$strategy[s].short_name}');">
                                                        <a href="#" id="{$strategy[s].short_name}" onclick="setStrategyInput('{$strategy[s].short_name}','{$strategy[s].full_name}'); return false;">{$strategy[s].full_name}</a>
                                                    </li>
                                                    {/section} 
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <select id="investment" class="chzn-select">
                                        <option selected value="">Set Investment--></option>
                                        {section name=inv loop=$investment}
                                        {if $investment[inv].value == 100}
                                        <option selected value="{$investment[inv].value}">${$investment[inv].value}</option>
                                        {else}
                                        <option value="{$investment[inv].value}">${$investment[inv].value}</option>
                                        {/if}                                  
                                        {/section} 
                                    </select>
                                    <div id="price_input">
                                        <input id="price" type="text" value="Input price" onClick="appear_disapeare(this.id);">
                                    </div>     

                                    <div id="trade_value">
                                        <input id="game_id" name="game_id" type="hidden" value="0">
                                    </div>
                                    <input id="isstart" type="hidden" value="0">                          
                                    <input id="is_post" type="hidden" value="0">
                                    <input id="is_full_screen" type="hidden" value="0">
                                    <input id="current_price" type="hidden" value="0">
                                    <input id="already_selected" type="hidden" value="0">
                                    <input id="main_page_tool" type="hidden" value="1"> 
                                    <input id="run_w_g" type="hidden" value="0"> 
                                    <input id="high_price" type="hidden" value="0">
                                    <input id="low_price" type="hidden" value="0">                                  
                                </div>
                                <div id="button_container">
                                    <button id="share" class="btn btn-success share_button action_button" onclick="run(1); return false;" alt="Trade & Share with the Community">Trade & Share</button>
                                    <br/>
                                    <button id="go" class="btn go_button action_button upper_btn" onclick="run(0); return false;" alt="Let me just trade">Trade</button>
                                </div>
                            </div>    
                            <div id="message_box">
                                <textarea id="comment_field" name="comment_field">{$inputRows.comment_field|default:''}</textarea>
                            </div>
                        </div>
                        <div id="info_box">
                            <div id="strategy_promt" class="alert-info"></div>
                            <!-- <label class="full">Key words and visibility</label>
                             <div id="game_comment_kw">
                                 <input type="text" id="comment_kw" name="comment_kw" placeholder="Input kewy words. For example: trade, APPLE etc">
                             </div>
                             <br/>
                             <div id="game_comment_visible">
                                 <select id="visible" name="visible">
                                     <option selected="selected" value="0">Visibility</option>
                                     <option value="1">Yes</option>
                                     <option value="2">No</option>
                                 </select>
                             </div>      -->
                        </div>
                    </div>
                </div>
                <div id="app_box">
                    <div class="accordion" id="accordion">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                    Asset details
                                </a>
                            </div>
                            <div class=""></div>
                            <div id="collapseOne" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                    <p id="asset_" style="font-weight: bold; font-size: 12pt;"></p><br />
                                    <p id="curr_price" style="font-weight: bold; font-size: 14pt;"></p><br />
                                    <p><em id="low_price_"></em><em id="high_price_" style="float:right"></em></p>
                                    <div id="slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>                  
                    <div class="accordion" id="accordion3">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
                                    Open trades
                                </a>
                            </div>
                            <div id="collapseThree" class="accordion-body collapse in">
                                <div class="accordion-inner" id="open_trades"></div>
                            </div>
                        </div>
                    </div>   
                    <div class="accordion" id="news_block">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#news_block" href="#collapseNewsBlcok">
                                    Asset news
                                </a>
                            </div>
                            <div id="collapseNewsBlcok" class="accordion-body collapse in">
                                <div id="news_block" class="accordion-inner">
                                    <div class="news_box">
                                        {section name=i loop=$news}
                                        <div class="news_title"><h5><a href="{$news[i].link}" target="_blank">{$news[i].title}</a></h5></div>
                                        <div class="news_date">{$news[i].pub_date}</div>
                                        <div class="news_content">{if $news[i].description ne 'NULL'}{$news[i].description}{/if}</div>
                                        {/section}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lower_button">
                <button id="share" class="btn btn-success share_button action_button lower_share" onclick="run(1); return false;" alt="Trade & Share with the Community">Trade & Share</button>                       
            </div>          
            <input type="hidden" id="forumid" name="forumid" value="{$location[0].forumid}"/>
    </div>
</form>
</div>



<div id="open_trades_box">
                <div id="open_trades_header">
                    <div class="info_a">
                        <a href="#">
                            Open trades
                        </a>
                    </div>
                </div>
                <div id="blue_line"></div>
                <div id="open_trades_content">
                    <div id="open_trades"></div>
                </div>
                <div id="open_trades_bottom">
                    <div class="box_dev"></div>
                </div>
            </div>
            <div id="news_trades_box">
                <div id="news_trades_header">
                    <div class="info_a">
                        <a href="#">
                            Asset news
                        </a>
                    </div>
                </div>
                <div id="orange_line"></div>
                <div id="news_trades_content">
                    <div id="news_block" class="accordion-inner">
                        <div class="news_box">
                            {section name=i loop=$news}
                                <div class="news_title"><h5><a href="{$news[i].link}" target="_blank">{$news[i].title}</a></h5></div>
                                <div class="news_date">{$news[i].pub_date}</div>
                                <div class="news_content">{if $news[i].description ne 'NULL'}{$news[i].description}{/if}</div>
                            {/section}
                        </div>
                    </div>
                </div>
                <div id="news_trades_bottom">
                    <div class="box_dev"></div>
                </div>
            </div>