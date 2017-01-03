<div class="mct_table_subhead_th">
            <ul>
                <li class="th_head_in">In/Out</li>
                <li class="th_head_asset">Asset</li>
                <li class="th_head_strategy">Strategy</li>
                <li class="th_head_invest">Investment</li>
                <li class="th_head_price">Price</li>
                <li class="th_head_exprice">Expiry Price</li>
                <li class="th_head_ex">Expiry</li>
                <li class="th_head_trade">Trade Started</li>
                <li class="th_head_pl">P&L</li>
            </ul>
        </div>
        <ul class="mct_open_trades_in_out">
		{foreach from=$tarde_history key=k item=v}
            <li class="in"></li>
		{/foreach}
        </ul>
        <ul class="mct_open_trades_asset">
		{foreach from=$tarde_history key=k item=v}
            <li>{$v.trade.asset}</li>
		{/foreach}
        </ul>
        <ul class="mct_open_trades_strategy">
           {foreach from=$tarde_history key=k item=v}
            <li>{if $v.trade.strategy eq 'boundary_inside'}<span>Boundary In</span>
                {elseif $v.trade.strategy eq 'no_touch'}<span>No Touch</span>
                {elseif $v.trade.strategy eq 'boundary_out'}<span>Boundary Out</span>
                {elseif $v.trade.strategy eq 'touch_up'} <span> Touch up</span>
                {elseif $v.trade.strategy eq 'touch_down'}<span> Touch Down</span>
                {elseif $v.trade.strategy eq 'no_touch_up'}<span  style="background-color:#FF8919"> No Touch Up</span>
                {elseif $v.trade.strategy eq 'no_touch_down'}<span  style="background-color:#FF8919"> No Touch Down</span>
                {elseif $v.trade.strategy eq 'call'}<span> Call</span>
                {elseif $v.trade.strategy eq 'high'}<span> Call</span>
                {elseif $v.trade.strategy eq 'put'}<span style="background-color: #2FC0FF;"> Low</span>
                {elseif $v.trade.strategy eq 'low'}<span  style="background-color: #2FC0FF;"> Low</span>
                {/if}

            </li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_investment">
            {foreach from=$tarde_history key=k item=v}
            <li>${$v.trade.investment}</li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_price">
            {foreach from=$tarde_history key=k item=v}
            <li>${$v.trade.price}</li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_exprice" style="min-width:60px">
            {foreach from=$tarde_history key=k item=v}
            <li>${$v.trade.price}</li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_names" style="margin-right:55px">
            {foreach from=$tarde_history key=k item=v}
            <li>{$v.trade.expiry_name}</li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_names" style="margin-right:60px">
           {foreach from=$tarde_history key=k item=v}
            <li>{$v.trade.created_at|date_format}</li>
			{/foreach}
        </ul>
        <ul class="mct_open_trades_names">
            {foreach from=$tarde_history key=k item=v}
            <li class="red">{if $v.pl<0}-{/if}${abs($v.pl)}</li>
          {/foreach}
        </ul>