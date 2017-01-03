<table class="table table-bordered">
    <thead>
        <tr class="table_header">
            <th colspan="9"><a href="#" class="table_header_log">Open Positions</a></th>
        </tr>
        <tr class="table_header_perpel">
            <th colspan="9"><a href="#" class="table_header_perpel"></a></th>
        </tr>
        <tr class="open_games_th">
            <th>Asset</th>
            <th>Strategy</th>
            <th>Investment</th>
            <th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th>
            <th>Curr.Price</th>
            <th>Expiry</th>
            <th>In/Out Of the money</th>
            <th>Time left for expire</th>
            <th>&nbsp;</th>
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
                    <td class="in_money">{$currentTrades[i].status}</td>
                {else}
                    <td class="out_money">{$currentTrades[i].status}</td>
                {/if}
                <td>{$currentTrades[i].time_remains}</td>
                {if $currentTrades[i].is_post == 1}
                    <td><a href="{$url}edit/{$currentTrades[i].id}">Edit</a></td>
                {else}
                    <td></td>
                {/if}
            </tr>
        {/section} 
    </tbody>
</table>             
