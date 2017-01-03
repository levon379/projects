<table class="table table-bordered">
    <thead>
        <tr class="table_header">
            <th colspan="8">{$user_name}&nbsp;&nbsp; Trading Log&nbsp;&nbsp;(Closed Trades)</th>
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
                {if $finishedTrades[ft].game_result == 0}
                <td bgcolor="#E87D8B">
                    &nbsp;$&nbsp;-{$finishedTrades[ft].pl}
                </td>
                {else}
                <td bgcolor="#15B841">
                    &nbsp;$&nbsp;{$finishedTrades[ft].pl}
                </td>
                {/if}
                <td>$&nbsp;{$finishedTrades[ft].price}</td>
                <td>{$finishedTrades[ft].expiry_name}</td>
                {if $finishedTrades[ft].game_result == 1}
                    <td bgcolor="#15B841"><a href="#" onclick="loadClosedGame({$finishedTrades[ft].id}, '{$finishedTrades[ft].asset}');">&nbsp;In</a></td>
                {else}
                    <td><a href="#" onclick="loadClosedGame({$finishedTrades[ft].id}, '{$finishedTrades[ft].asset}');">&nbsp;Out</a></td>                                    
                {/if}
             </tr>
        {/section} 
    </tbody>
</table>
