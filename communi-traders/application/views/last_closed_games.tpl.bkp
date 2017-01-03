<div class="open_trades_header">
    <ul>
        <li class="ot_head_in">In/Out</li>
        <li class="ot_head_asset">Asset</li>
        <li class="ot_head_strategy">Strategy</li>
        <li class="ot_head_invest">Investment</li>
        <li class="ot_head_entry">Price</li>
        <li class="ot_head_current">Expiry Price</li>
        <li class="ot_head_expiry">Expiry</li>
        <li class="ot_head_trade">Trade Started</li>
        <li class="ot_head_pl">P&L</li>
</div>
<div class="open_trades_content">
    {section name=i loop=$last_closed}
        <ul class="open_trades_list">
            <li class="in_money_small" style="margin-right: 20px">In</li>
            {if $last_closed[i].url!="" }
                <li class="asset_short"><a href="{$last_closed[i].url}">{$last_closed[i].asset_short}</a></li>
            {else}
                <li class="asset_short">{$last_closed[i].asset_short}</li>
            {/if}
            <li  class="strategy">{$last_closed[i].strategy}</li>
            <li class="investment">$&nbsp;{$last_closed[i].investment}</li>
            <li class="price">$&nbsp;{$last_closed[i].price}</li>
            {if $last_closed[i].game_result==1}
            <li class="in_money_open_trade"><a href="{$url}">More</a><li>
                {else}
            <li class="out_money_open_trade"><a href="{$url}">More</a><li>
                {/if}

        </ul>

    {/section}
</div>