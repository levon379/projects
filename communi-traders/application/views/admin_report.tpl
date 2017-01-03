<div id="export_to_xls">
    {if $action eq 'read'}
        <a href="{$url}admin/dashboard/report/export_by_read"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'by_asset'}
        <a href="{$url}admin/dashboard/report/export_by_asset"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'by_strategies'}
        <a href="{$url}admin/dashboard/report/export_by_strategies"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'by_expire'}
        <a href="{$url}admin/dashboard/report/export_by_expire"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'by_asset_expire'}
        <a href="{$url}admin/dashboard/report/export_by_asset_expire"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'this_week_registrations'}
        <a href="{$url}admin/dashboard/report/export_this_week_registrations"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
    {if $action eq 'this_week_all_users'}
        <a href="{$url}admin/dashboard/report/export_this_week_registrations"><img src="{$url}assets/images/xls.jpeg"/></a>
    {/if}
</div>
<div class="table_menu">
        <ul class="nav nav-pills">
            <li {if $action eq 'read'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/read">By List of user</a>
            </li>
            <li {if $action eq 'by_asset'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/by_asset">By List of asset</a>
            </li>
            <li {if $action eq 'by_strategies'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/by_strategies">By List of Strategies</a>
            </li>
            <li {if $action eq 'by_expire'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/by_expire">By List of expires</a>
            </li>
            <li {if $action eq 'by_asset_expire'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/by_asset_expire">By Asset/Expire</a>
            </li>

            <li {if $action eq 'this_week_registrations'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/this_week_registrations">This week: registered</a>
            </li>
            <li {if $action eq 'this_week_all_users'}class="active"{/if}>
                <a href="{$url}admin/dashboard/report/this_week_all_users">This week: all users</a>
            </li>
        </ul>
</div>
<input type="hidden" name="is_report" id="is_report" value="1" />
{if $action eq 'by_asset' || $action eq 'by_asset_expire'}
    <input type="hidden" name="is_paginate" id="is_paginate" value="0" />
{else}
    <input type="hidden" name="is_paginate" id="is_paginate" value="1" />
{/if}
<div id="reports">
        <table id="all" class="table table-bordered"> 
        {if $action eq 'read'}
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Country</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Total of Shares</th>
                <th>Winning Ratio</th>
                <th>Losing Ratio</th>
                <th>Last Logged</th>
                <th>How many times logged in</th>
                <th>Logged Last month</th>
            </tr>
        </thead>
        <tbody>
            {section name=i loop=$user_info}
            <tr>
                <td>{$user_info[i].username}</td>
                <td>{$user_info[i].email}</td>
                <td>{$user_info[i].country}</td>
                <td align="center">{$user_info[i].open_games}</td>
                <td align="center">{$user_info[i].closed_games}</td>
                <td align="center">{$user_info[i].total_shares}</td>
                <td align="center">{$user_info[i].winn_rate}</td>
                <td align="center">{$user_info[i].loose_rate}</td>
                <td align="center">{$user_info[i].last_logged}</td>
                <td align="center">{$user_info[i].h_m_t_loged}</td>
                <td align="center">{$user_info[i].l_m_logged}</td>
            </tr>
            {/section}
        </tbody>
        {/if}
        {if $action eq 'by_asset'}
        <thead>
            <tr>
                <th>Asset</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Losing Ratio</th>
            </tr>
        </thead>
            <tbody>
            {section name=i loop=$asset_info}
            <tr>
                <td>{$asset_info[i].asset}</td>
                <td align="center">{$asset_info[i].open_trades}</td>
                <td align="center">{$asset_info[i].closed_trades}</td>
                <td align="center">{$asset_info[i].winning_rate}%</td>
                <td align="center">{$asset_info[i].loosing_rate}%</td>
            </tr>
            {/section}
            </tbody>
        {/if}
        {if $action eq 'by_strategies'}
        <thead>
            <tr>
                <th>Strategy</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Loosing Ratio</th>
            </tr>
        </thead>
            <tbody>
                {section name=i loop=$strategy_info}
                <tr>
                    <td>{$strategy_info[i].strategy}</td>
                    <td align="center">{$strategy_info[i].open_trades}</td>
                    <td align="center">{$strategy_info[i].closed_trades}</td>
                    <td align="center">{$strategy_info[i].winning_rates}%</td>
                    <td align="center">{$strategy_info[i].loosing_rates}%</td>
                </tr>
                {/section}
            </tbody>
        {/if}
        {if $action eq 'by_expire'}
        <thead>
            <tr>
                <th>Expire name</th>
                <th>Open Trades</th>
                <th>Closed Trades</th>
                <th>Winning Ratio</th>
                <th>Loosing Ratio</th>
            </tr>
        </thead>
            <tbody>
                {section name=i loop=$expire_info}
                <tr>
                    <td>{$expire_info[i].expire}</td>
                    <td align="center">{$expire_info[i].open_trades}</td>
                    <td align="center">{$expire_info[i].closed_trades}</td>
                    <td align="center">{$expire_info[i].winning_rates}%</td>
                    <td align="center">{$expire_info[i].loosing_rates}%</td>
                </tr>
                {/section}
            </tbody>
        {/if}
        {if $action eq 'by_asset_expire'}
        <thead>
            <tr>
                <th>Assest/expiry</th>
                <th>60 seconds</th>
                <th>15 miutes</th>
                <th>1 hour</th>
                <th>4 hours</th>
                <th>1 day</th>
                <th>3 days</th>
                <th>1 week</th>
                <th>1 month</th>
            </tr>
        </thead>
            <tbody>
                {section name=i loop=$asset_expire_info}
                <tr>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].asset}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].60sec}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].15min}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].1h}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].4h}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].1d}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].3d}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].1w}&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;{$asset_expire_info[i].1mon}&nbsp;&nbsp;</td>
                </tr>
                {/section}
            </tbody>
        {/if}
            {if $action eq 'this_week_registrations'}
                <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Open Trades</th>
                    <th>Closed Trades</th>
                    <th>Total of Shares</th>
                    <th>Winning Ratio</th>
                    <th>Losing Ratio</th>
                </tr>
                </thead>
                <tbody>
                {section name=i loop=$user_info}
                    <tr>
                        <td>{$user_info[i].username}</td>
                        <td>{$user_info[i].email}</td>
                        <td>{$user_info[i].country}</td>
                        <td align="center">{$user_info[i].open_games}</td>
                        <td align="center">{$user_info[i].closed_games}</td>
                        <td align="center">{$user_info[i].total_shares}</td>
                        <td align="center">{$user_info[i].winn_rate}</td>
                        <td align="center">{$user_info[i].loose_rate}</td>
                    </tr>
                {/section}
                </tbody>
            {/if}
            {if $action eq 'this_week_all_users'}
                <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th>Open Trades</th>
                    <th>Closed Trades</th>
                    <th>Total of Shares</th>
                    <th>Winning Ratio</th>
                    <th>Losing Ratio</th>
                </tr>
                </thead>
                <tbody>
                {section name=i loop=$user_info}
                    <tr>
                        <td>{$user_info[i].username}</td>
                        <td>{$user_info[i].email}</td>
                        <td>{$user_info[i].country}</td>
                        <td align="center">{$user_info[i].open_games}</td>
                        <td align="center">{$user_info[i].closed_games}</td>
                        <td align="center">{$user_info[i].total_shares}</td>
                        <td align="center">{$user_info[i].winn_rate}</td>
                        <td align="center">{$user_info[i].loose_rate}</td>
                    </tr>
                {/section}
                </tbody>
            {/if}
        </table>
</div>
