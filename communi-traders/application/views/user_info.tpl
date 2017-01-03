
<div class="mct_table_subhead_ot">
		<ul>
			<li class="mct_table_subhead_in">In/Out</li>
			<li class="mct_table_subhead_asset">Asset</li>
			<li class="mct_table_subhead_strategy">Strategy</li>
			<li class="mct_table_subhead_investment">Investment</li>
			<li class="mct_table_subhead_price">Price</li>
			<li class="mct_table_subhead_cprice">Curr. Price</li>
			<li class="mct_table_subhead_expiry">Expiry</li>
			<li class="mct_table_subhead_time">Time Left</li>
		</ul>
            </div>
            <ul class="mct_open_trades_in_out">
				{foreach from=$user_info key=k item=v}	
					<li class="in"></li>
					{if $k >5}{break}{/if}
				{/foreach}
            </ul>
            <ul class="mct_ot_asset">
				{foreach from=$user_info key=k item=v}
					<li>{if $v.asset_short eq '^GSPC'}SP/ASX200
                        {else}
                            {$v.asset}
                        {/if}</li>
					{if $k >5}{break}{/if}
				{/foreach}
            </ul>
            <ul class="mct_ot_strategy">
				{foreach from=$user_info key=k item=v}
					<li>{if $v.strategy eq 'boundary_inside'}<span>Boundary In</span>
					{elseif $v.strategy  eq 'no_touch'}<span>No Touch</span>
					{elseif $v.strategy  eq 'boundary_out'}<span>Boundary Out</span>
					{elseif $v.strategy  eq 'touch_up'} <span style="background-color:#7FA9C9"> Touch up</span>
					{elseif $v.strategy  eq 'touch_down'}<span style="background-color:#7FA9C9"> Touch Down</span>
					{elseif $v.strategy  eq 'no_touch_up'}<span  style="background-color:#FF8919"> No Touch Up</span>
					{elseif $v.strategy  eq 'no_touch'}<span  style="background-color:#FF8919"> No Touch Up</span>
					{elseif $v.strategy  eq 'no_touch_down'}<span  style="background-color:#FF8919"> No Touch Down</span>
					{elseif $v.strategy  eq 'call'}<span> Call</span>
					{elseif $v.strategy  eq 'high'}<span> Call</span>
					{elseif $v.strategy  eq 'put'}<span style="background-color: #2FC0FF;"> Low</span>
					{elseif $v.strategy  eq 'low'}<span  style="background-color: #2FC0FF;"> Low</span>
					{/if}
					</li>
					{if $k >5}{break}{/if}
				{/foreach}
            </ul>
            <ul class="mct_ot_investment">
               {foreach from=$user_info key=k item=v}
               <li>${$v.investment}</li>
			   {if $k >5}{break}{/if}
				{/foreach}
            </ul>
            <ul class="mct_ot_price">
               {foreach from=$user_info key=k item=v}
                <li>${round($v.price,4)}</li>
				{if $k >5}{break}{/if}
			{/foreach}
            </ul>
            <ul class="mct_ot_cprice">
                {foreach from=$user_info key=k item=v}
               <li>$462.9480</li>
				{if $k >5}{break}{/if}
			{/foreach}
            </ul>
            <ul class="mct_open_trades_expiry">
				{foreach from=$user_info key=k item=v}
					<li>{$v.expiry_name}</li>
				{if $k >5}{break}{/if}
				{/foreach}

            </ul>
            <ul class="mct_ot_time" id="expireleft">
				{foreach  from=$user_info key=k item=v}
				<li><div><span  class="timer" ></span>{$v.time_remains}</div></li>
				{if $k >5}{break}{/if}
				{/foreach} 
            </ul>
            <ul class="mct_ot_link">
                {foreach from=$user_info key=k item=v}
                <li><a href="/threads/{$v.thread_url}" target="_blank"><div class="edit_button"></div></a></li>
				{if $k >5}{break}{/if}
				{/foreach}
                

            </ul>
			
</div>

