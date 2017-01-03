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
                {if $send == 0}
                    <input type="checkbox" id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                {else}
                    <input type="checkbox" checked id="email_alert" name="email_alert" value="{$send}" onChange="sendEmailAlert(); return false;">Get Email Alert
                {/if}
            </td>
            <td id="is_alert">
                {if $send == 0}
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
            <td class="td_name">Reset my demo account</td>
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
