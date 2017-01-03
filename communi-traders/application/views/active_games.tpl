<div class="open_trades_header">
    <ul>
        <li class="ot_head_in">In/Out</li>
        <li class="ot_head_asset">Asset</li>
        <li class="ot_head_strategy">Strategy</li>
        <li class="ot_head_invest">Investment</li>
        <li class="ot_head_entry">Entry</li>
        <li class="ot_head_current">Current</li>
        <li class="ot_head_expiry">Expiry</li>
</div>
<div class="open_trades_content">
    {section name=i loop=$currentTrades}
        <ul class="open_trades_list" id="active_games_{$currentTrades[i].id}">
            <li class="in_money_small" style="margin-right: 20px">In</li>
            {if $currentTrades[i].url!="" }
                <li class="asset_short"><a href="{$currentTrades[i].url}">{$currentTrades[i].asset}</a></li>
            {else}
                <li class="asset_short">{$currentTrades[i].asset}</li>
            {/if}
			
            <li class="strategy">
					{if $currentTrades[i].strategy eq 'boundary_inside'}Boundary In
					{elseif $currentTrades[i].strategy eq 'no_touch'}No Touch
					{elseif $currentTrades[i].strategy eq 'boundary_out'} Boundary Out
					{elseif $currentTrades[i].strategy eq 'touch_up'} Touch up
					{elseif $currentTrades[i].strategy eq 'touch_down'} Touch Down
					{elseif $currentTrades[i].strategy eq 'no_touch_up'} No Touch Up
					{elseif $currentTrades[i].strategy eq 'no_touch_down'} No Touch Down
					{elseif $currentTrades[i].strategy eq 'call'} Call
					{elseif $currentTrades[i].strategy eq 'high'} Call
					{elseif $currentTrades[i].strategy eq 'put'} Low
					{elseif $currentTrades[i].strategy eq 'low'} Low
					{/if}
					</li>
            <li class="investment">$&nbsp;{$currentTrades[i].investment}</li>
            <li class="price">$&nbsp;{$currentTrades[i].price}</li>
            <li class="price">$&nbsp;{$currentTrades[i].price}</li><!-- This need to be Currnet price -->
            {if $currentTrades[i].status eq 'In'}
                <li class="in_money_open_trade" class="expired_at">{$currentTrades[i].expired_at}</li>
            {else}
                <li class="out_money_open_trade" class="expired_at">{$currentTrades[i].expired_at}</li>
            {/if}
          <!--  <li class="close_now"><a class="btn btn-primary btn-xs" href="#">Close Now</a></li> -->
            <li class="view_post"><a href="{$currentTrades[i].url}">View Post</a></li>
        </ul>
    {/section}

</div>

