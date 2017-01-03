<div class="body_wrapper">
    <div id="breadcrumb" class="breadcrumb">
        <ul class="floatcontainer">
            <li class="navbithome">
                <a href="{$forum_url}" accesskey="1">
                    <img src="{$forum_url}images/misc/navbit-home.png" alt="Home" title="Home"/>
                </a>
            </li>
            <li class="navbit">
                <a href="{$forum_url}">Forum</a>
            </li>
            <li class="navbit lastnavbit">
                CoomuniTrader
            </li>
        </ul>
    </div>
    <div id="ad_global_below_navbar">
        <iframe class="frm_board" src="http://www.binaryoptionsthatsuck.com/ShowBanner.php" frameborder="0" width="485" height="80"></iframe>
    </div>
    <div class="table_container report_font">
        <div id="tool_menu">
            <ul class="nav nav-pills">
                <li>
                    <a href="{$url}"> CoomuniTrader</a>
                </li>
                <li class="active">
                    <a href="#"> My Performance</a>
                </li>
            </ul>
        </div>
        <div id="reports_left_part">
            <input id="main_page_tool" type="hidden" value="0">
            <div id="about">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th>About {$user_name}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Country</td>
                            <td >{$aboutRows.country}</td>
                        </tr>
                        <tr>
                            <td class="td_name">Occupation</td>
                            <td>{$aboutRows.occupation}</td>
                        </tr>
                        <tr>
                            <td class="td_name table_header_second">{$user_name} Trading Specs</td>
                            <td class="td_name table_header_second"></td>
                        </tr>
                        <tr>
                            <td class="td_name">Lose Trades Rate</td>
                            <td>{$aboutRows.loseTradesRate} %</td>
                        </tr>
                        <tr>
                            <td class="td_name">Broker Name</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td_name">
                                {if $send eq 0}
                                    <input type="checkbox" id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                                {else}
                                    <input type="checkbox" checked id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                                {/if}
                            </td>
                            <td id="is_alert">
                                {if $send eq 0}
                                    No
                                {else}
                                    Yes
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td class="td_name">Demo/Live</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td_name">Reset his demo account</td>
                            {if $aboutRows.resetCounter==0}
                                <td>never</td>
                            {else}
                                <td>{$aboutRows.resetCounter}&nbsp;times</td>    
                            {/if}    
                        </tr>
                        <tr>
                            <td class="td_name">Current Account Balance</td>
                            <td>
                                $&nbsp;{$aboutRows.balance}
                                {if $aboutRows.balance <= 100 }
                                    <div id="reset">
                                        <a href="{$url}ajax/renewBalance" class="btn btn-info">Renew balance</a>
                                    </div>
                                {/if}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>        

            <div id="performance_table">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th>{$user_name} Performance Report:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Today</th>
                            <th>This Week</th>
                            <th>This Month</th>
                            <th>This Year</th>
                            <th>All time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Number of winning trades</td>                    
                            <td>
                                {$performanceRows['winningTrades'].dayResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].weekResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].monthResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].yearResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].allTimePeriod}
                            </td>
                        </tr>
                        <tr>
                            <td>Number of bad trades</td>
                            <td>{$performanceRows['badTrades'].dayResult}</td>
                            <td>{$performanceRows['badTrades'].weekResult}</td>
                            <td>{$performanceRows['badTrades'].monthResult}</td>
                            <td>{$performanceRows['badTrades'].yearResult}</td>
                            <td>{$performanceRows['badTrades'].allTimePeriod}</td>
                        </tr>
                        <tr>
                            <td>Win trades rate</td>
                            <td>{$performanceRows['winTradesRate'].day} %</td>
                            <td>{$performanceRows['winTradesRate'].week} %</td>
                            <td>{$performanceRows['winTradesRate'].month} %</td>
                            <td>{$performanceRows['winTradesRate'].year} %</td>
                            <td>{$performanceRows['winTradesRate'].allTime} %</td>
                        </tr>
                        <tr>
                            <td>Loose trades rate</td>
                            <td>{$performanceRows['loseTradesRate'].day} %</td>
                            <td>{$performanceRows['loseTradesRate'].week} %</td>
                            <td>{$performanceRows['loseTradesRate'].month} %</td>
                            <td>{$performanceRows['loseTradesRate'].year} %</td>
                            <td>{$performanceRows['loseTradesRate'].allTime} %</td>
                        </tr>
                        <tr>
                            <td>Best asset</td>
                            <td>{$performanceRows['bestAsset'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Worst asset</td>
                            <td>{$performanceRows['worstAsset'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Best strategy</td>
                            <td>{$performanceRows['bestStrategy'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Worst strategy</td>
                            <td>{$performanceRows['worstStrategy'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Success Rate of Calls strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of puts strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of touch strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of no touch strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of boundery out  strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of boundary in  strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>        
        </div>
        <div id="reports_right_part">
            <div id="container"></div><br />
            <div class="statistic_box">
                <div id="open_trades">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table_header">
                                <th colspan="8">{$user_name}&nbsp;&nbsp;({$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'})</th>
                            </tr>
                            <tr>
                                <th>Asset</th>
                                <th>Strategy</th>
                                <th>Investment</th>
                                <th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th>
                                <th>Curr.Price</th>
                                <th>Expiry</th>
                                <th>In/Out Of the money</th>
                                <th>Time left for expire</th>
                            </tr>
                        </thead>
                        <tbody>
                            {section name=i loop=$currentTrades}
                                <tr class="history_trade" id="active_games_{$currentTrades[i].id}">
                                    <!--<td>{$currentTrades[i].created_at|date_format:"%m.%d.%Y"}</td>-->
                                    <td>{$currentTrades[i].asset}</td>
                                    <td>{$currentTrades[i].strategy}</td>
                                    <td>$&nbsp;{$currentTrades[i].investment}</td>
                                    {if $currentTrades[i].strategy eq 'bounderi inside'}
                                        <td>$&nbsp;{$currentTrades[i].price_from} - {$currentTrades[i].price_to}</td>
                                    {elseif $currentTrades[i].strategy eq 'bounderi out'}
                                        <td>$&nbsp;{$currentTrades[i].price_from} - {$currentTrades[i].price_to}</td>
                                    {else}
                                        <td>$&nbsp;{$currentTrades[i].price}</td>
                                    {/if}
                                    <td>$&nbsp;{$currentTrades[i].curr_price}</td>
                                    <td>{$currentTrades[i].expiry_name}</td>
                                    {if $currentTrades[i].status eq 'In'}
                                        <td bgcolor="#15B841">{$currentTrades[i].status}</td>
                                    {else}
                                        <td bgcolor="#FF0000">{$currentTrades[i].status}</td>
                                    {/if}
                                    <td>{$currentTrades[i].time_remains}</td>
                                </tr>
                            {/section} 
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="statistic_box">
                <div id="closed_trades">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table_header">
                                <th>{$user_name}&nbsp;&nbsp;({$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'})</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Date start trade</th>
                                <th>Asset</th>
                                <th>Strategy</th>
                                <th>Investment</th>
                                <th>P&amp;L</th>
                                <th>Price</th>
                                <th>Expiry</th>
                                <th>In/Out Of the money</th>
                            </tr>
                        </thead>
                        <tbody>
                            {section name=ft loop=$finishedTrades}
                                <tr class="history_trade">
                                    <td>{$finishedTrades[ft].created_at|date_format:"%m.%d.%Y"}</td>
                                    <td>{$finishedTrades[ft].asset}</td>
                                    <td>{$finishedTrades[ft].strategy}</td>
                                    <td>$&nbsp;{$finishedTrades[ft].investment}</td>
                                    <td>
                                        {if $finishedTrades[ft].game_result==1}
                                            $&nbsp;{$finishedTrades[ft].pl}
                                        {else}
                                           -$&nbsp;{$finishedTrades[ft].pl} 
                                        {/if}
                                    </td>
                                    <td>$&nbsp;{$finishedTrades[ft].price}</td>
                                    <td>{$finishedTrades[ft].expiry_name}</td>
                                    {if $finishedTrades[ft].game_result==1}
                                        <td class="in_money">&nbsp;In</td>
                                    {else}
                                        <td class="out_money">&nbsp;Out</td>                                    
                                    </tr>
                                {/if}
                            {/section} 
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>
</div>
                        
                        
                        <div class="body_wrapper">
    <div id="table_cntainer" class="report_font">
        <div id="tool_menu">
            <ul class="nav nav-pills">
                <li>
                    <a href="{$url}"> CoomuniTrader</a>
                </li>
                <li class="active">
                    <a href="#"> My Performance</a>
                </li>
            </ul>
        </div>
        <div id="reports_left_part">
            <input id="main_page_tool" type="hidden" value="0">
            <div id="about">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th>About {$user_name}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        <tr>
                            <td>Country</td>
                            <td >{$aboutRows.country}</td>
                        </tr>
                        <tr>
                            <td class="td_name">Occupation</td>
                            <td>{$aboutRows.occupation}</td>
                        </tr>
                        <tr>
                            <td class="td_name table_header_second">{$user_name} Trading Specs</td>
                            <td class="td_name table_header_second"></td>
                        </tr>
                        <tr>
                            <td class="td_name">Lose Trades Rate</td>
                            <td>{$aboutRows.loseTradesRate} %</td>
                        </tr>
                        <tr>
                            <td class="td_name">Broker Name</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td_name">
                                {if $send eq 0}
                                    <input type="checkbox" id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                                {else}
                                    <input type="checkbox" checked id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                                {/if}
                            </td>
                            <td id="is_alert">
                                {if $send eq 0}
                                    No
                                {else}
                                    Yes
                                {/if}
                            </td>
                        </tr>
                        <tr>
                            <td class="td_name">Demo/Live</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="td_name">Reset his demo account</td>
                            {if $aboutRows.resetCounter==0}
                                <td>never</td>
                            {else}
                                <td>{$aboutRows.resetCounter}&nbsp;times</td>    
                            {/if}    
                        </tr>
                        <tr>
                            <td class="td_name">Current Account Balance</td>
                            <td>
                                $&nbsp;{$aboutRows.balance}
                                {if $aboutRows.balance <= 100 }
                                    <div id="reset">
                                        <a href="{$url}ajax/renewBalance" class="btn btn-info">Renew balance</a>
                                    </div>
                                {/if}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>        
        </div>
        <div id="reports_right_part">
            <div id="container"></div><br/>
            <div id="open_trades_per">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table_header">
                            <th colspan="8">{$user_name}&nbsp;&nbsp;({$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'})</th>
                        </tr>
                        <tr>
                            <th>Asset</th>
                            <th>Strategy</th>
                            <th>Investment</th>
                            <th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th>
                            <th>Curr.Price</th>
                            <th>Expiry</th>
                            <th>In/Out Of the money</th>
                            <th>Time left for expire</th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        {section name=i loop=$currentTrades}
                            <tr class="history_trade" id="active_games_{$currentTrades[i].id}">
                                <!--<td>{$currentTrades[i].created_at|date_format:"%m.%d.%Y"}</td>-->
                                <td>{$currentTrades[i].asset}</td>
                                <td>{$currentTrades[i].strategy}</td>
                                <td>$&nbsp;{$currentTrades[i].investment}</td>
                                {if $currentTrades[i].strategy eq 'bounderi inside'}
                                    <td>$&nbsp;{$currentTrades[i].price_from} - {$currentTrades[i].price_to}</td>
                                {elseif $currentTrades[i].strategy eq 'bounderi out'}
                                    <td>$&nbsp;{$currentTrades[i].price_from} - {$currentTrades[i].price_to}</td>
                                {else}
                                    <td>$&nbsp;{$currentTrades[i].price}</td>
                                {/if}
                                <td>$&nbsp;{$currentTrades[i].curr_price}</td>
                                <td>{$currentTrades[i].expiry_name}</td>
                                {if $currentTrades[i].status eq 'In'}
                                    <td bgcolor="#15B841">{$currentTrades[i].status}</td>
                                {else}
                                    <td bgcolor="#FF0000">{$currentTrades[i].status}</td>
                                {/if}
                                <td>{$currentTrades[i].time_remains}</td>
                            </tr>
                        {/section} 
                    </tbody>
                </table>             
            </div>
            <div id="performance_table">
                <table class="table table-bordered td_name">
                    <thead>
                        <tr class="table_header">
                            <th>{$user_name} Performance Report:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Today</th>
                            <th>This Week</th>
                            <th>This Month</th>
                            <th>This Year</th>
                            <th>All time</th>
                        </tr>
                    </thead>
                    <tbody class="reports_block">
                        <tr>
                            <td>Number of winning trades</td>                    
                            <td>
                                {$performanceRows['winningTrades'].dayResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].weekResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].monthResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].yearResult}
                            </td>
                            <td>
                                {$performanceRows['winningTrades'].allTimePeriod}
                            </td>
                        </tr>
                        <tr>
                            <td>Number of bad trades</td>
                            <td>{$performanceRows['badTrades'].dayResult}</td>
                            <td>{$performanceRows['badTrades'].weekResult}</td>
                            <td>{$performanceRows['badTrades'].monthResult}</td>
                            <td>{$performanceRows['badTrades'].yearResult}</td>
                            <td>{$performanceRows['badTrades'].allTimePeriod}</td>
                        </tr>
                        <tr>
                            <td>Win trades rate</td>
                            <td>{$performanceRows['winTradesRate'].day} %</td>
                            <td>{$performanceRows['winTradesRate'].week} %</td>
                            <td>{$performanceRows['winTradesRate'].month} %</td>
                            <td>{$performanceRows['winTradesRate'].year} %</td>
                            <td>{$performanceRows['winTradesRate'].allTime} %</td>
                        </tr>
                        <tr>
                            <td>Loose trades rate</td>
                            <td>{$performanceRows['loseTradesRate'].day} %</td>
                            <td>{$performanceRows['loseTradesRate'].week} %</td>
                            <td>{$performanceRows['loseTradesRate'].month} %</td>
                            <td>{$performanceRows['loseTradesRate'].year} %</td>
                            <td>{$performanceRows['loseTradesRate'].allTime} %</td>
                        </tr>
                        <tr>
                            <td>Best asset</td>
                            <td>{$performanceRows['bestAsset'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['bestAsset'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Worst asset</td>
                            <td>{$performanceRows['worstAsset'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['worstAsset'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Best strategy</td>
                            <td>{$performanceRows['bestStrategy'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['bestStrategy'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Worst strategy</td>
                            <td>{$performanceRows['worstStrategy'].dayRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].weekRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].monthRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].yearRate|default:'-'}</td>
                            <td>{$performanceRows['worstStrategy'].allTimeRate|default:'-'}</td>
                        </tr>
                        <tr>
                            <td>Success Rate of Calls strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['call']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of puts strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['put']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of touch strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['touch']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of no touch strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['no touch']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of boundery out  strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>Success Rate of boundary in  strategy</td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyDay'][0]|default:''}
                                {$key['bounderi out']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyWeek'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyMonth'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyYear'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                            <td>
                                {assign var='key' value=$performanceRows['procentStrategyAllTime'][0]|default:''}
                                {$key['bounderi inside']|default:'0'}&nbsp;%
                            </td>
                        </tr>
                    </tbody>
                </table>                                          
            </div>   
            <div class="statistic_box">
                <div id="closed_trades">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table_header">
                                <th>{$user_name}&nbsp;&nbsp;({$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'})</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th>Date start trade</th>
                                <th>Asset</th>
                                <th>Strategy</th>
                                <th>Investment</th>
                                <th>P&amp;L</th>
                                <th>Price</th>
                                <th>Expiry</th>
                                <th>In/Out Of the money</th>
                            </tr>
                        </thead>
                        <tbody class="reports_block">
                            {section name=ft loop=$finishedTrades}
                                <tr class="history_trade">
                                    <td>{$finishedTrades[ft].created_at|date_format:"%m.%d.%Y"}</td>
                                    <td>{$finishedTrades[ft].asset}</td>
                                    <td>{$finishedTrades[ft].strategy}</td>
                                    <td>$&nbsp;{$finishedTrades[ft].investment}</td>
                                    <td>
                                        {if $finishedTrades[ft].game_result==1}
                                            $&nbsp;{$finishedTrades[ft].pl}
                                        {else}
                                            -$&nbsp;{$finishedTrades[ft].pl} 
                                        {/if}
                                    </td>
                                    <td>$&nbsp;{$finishedTrades[ft].price}</td>
                                    <td>{$finishedTrades[ft].expiry_name}</td>
                                    {if $finishedTrades[ft].game_result==1}
                                        <td class="in_money">&nbsp;In</td>
                                    {else}
                                        <td class="out_money">&nbsp;Out</td>                                    
                                    </tr>
                                {/if}
                            {/section} 
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>