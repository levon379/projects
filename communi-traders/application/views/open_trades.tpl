<script>
          function follow(ufing,key){
              url ='follow.php';
              //cct = $('input[name=ci_csrf_token]').val();
               var json_data = {
                        'do':'profile',
                        'action':'send', 
                        'insert_follow':true,
                         'followeeid'  : ufing
		        //'user_following': ufing,
                       // 'ci_csrf_token' : cct
                    }
	
    $.post(url, json_data, function(data) {
var obj = jQuery.parseJSON(data);
if(obj.ok == 'ok'){
        $('#follow_'+ufing+'_'+key).attr('onclick','unfollow('+ufing+','+key+')')  
        $('#follow_'+ufing+'_'+key).addClass("unfollow");
}
   });
}
function unfollow(ufing,key){
              url ='/CommuniTraders/ajax/unfollow';
              cct = $('input[name=ci_csrf_token]').val();
               var json_data = {
						'followeeid': ufing,
                        'ci_csrf_token' : cct
                    }
	
    $.post(url, json_data, function(data) {
      if(data){
        $('#follow_'+ufing+'_'+key).attr('onclick','follow('+ufing+','+key+')')  
        $('#follow_'+ufing+'_'+key).removeClass('unfollow');
       }
   });
}

</script>
<div class="ct_control">
    <form action="" method="post" id="filter_form">
	{$ci_csrf_token}
    <!-- Filter By -->
<div class="ct_filter_bg"> <div class="ct_filter_heading">Filter by:</div>
    <div class="select_asset">
        <select name="assets">
                <option value="">Asset</option>
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
    </div>
    <div class="select_strategy">
        <select name="strategy">
            <option value="">Strategy</option>
            {section name=s loop=$strategy} 
				 <option value="{$strategy[s].short_name}">{$strategy[s].full_name}</option>
			{/section} 
        </select>
    </div>
    <div class="select_expiry">
        <select name="expiry">
            <option value="">Expiry</option>
				{foreach from=$expiry key=k item=val}
					{if $val.sort>=1 && $val.sort<=6}
						<option value="{$val.expiry_value}">{$val.expiry_name}</option>
					{/if}
				{/foreach}
					{foreach from=$expiry key=k item=val}
					{if $val.sort>=7 && $val.sort<=10}
						<option value="{$val.expiry_value}">{$val.expiry_name}</option>
					{/if}
				{/foreach}
					{foreach from=$expiry key=k item=val}
					{if $val.sort>=11 && $val.sort<=13}
						<option value="{$val.expiry_value}">{$val.expiry_name}</option>
					{/if}
				{/foreach}

        </select>
    </div>
    </div>
	<div class="ct_submit_form"><input type="button" onclick="filter();" value="" class="ct_button" id="filter_button" /></div>
	</form>
<!-- Order By -->
<form action="" method="post" id="order_form">
{$ci_csrf_token}
<div class="ct_filter_bg"> <div><h2 class="ct_filter_heading">Order by:</h2></div>
    <div class="select_profit">
        <select name="assets">
            <option value="">Profit</option>
            <option value="">Asset</option>
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
    </div>
    <div class="select_sort">
        <select name="sorting">
			<option value="">Order</option>
            <option value="desc">Descending</option>
            <option value="asc">Ascending</option>

        </select>
    </div>

</div>
<div class="ct_submit_form"><input type="button" value="" onclick="order();" class="ct_button" id="order_button" /></div>

</form><!-- End CT Control Form -->


</div><!-- End CT Control -->
<!-- CT Control Gray divider -->

<div class="ct_wrapper">
    <div class="ct_gray_divider"></div>
    {counter start=0}

    {section name=i max=20 loop=$topleaders step=1}

   <div class="ct_report_holder">
		{if $topleaders[i].status neq 'unavailable' && $topleaders[i].status.0.in_money eq 'In'}
			<div class="ct_in_out green_in"></div>
		{elseif $topleaders[i].status eq 'unavailable'}
			<div class="ct_in_out"></div> 
		{else}
			<div class="ct_in_out red_out"></div>
		{/if}
        <div class="ct_avatar"><img src="{$topleaders[i].img}" width="46"> </div>
        <div class="ct_asset">{$topleaders[i].b_asset}</div>
        <div class="ct_strategy">{$topleaders[i].b_strat}<br/><span>{$topleaders[i].asset_expire.expiry_name}</span></div>
        <div class="ct_open_table">
            <div class="ct_open_table_heading">SPX setting up for long term bounce</div>
            <div class="ct_open_table_data">
                <div class="ct_open_table_data_expire">
                Expire<br/><span>{$topleaders[i].asset_expire.expired_at|date_diff}</span>
                </div>
                <div class="ct_open_table_data_entry">
                Entry Price<br/><span>{$topleaders[i].asset_expire.price}</span>
                </div>
                <div class="ct_open_table_data_exp_price">
                Cur/Exp Price<br/><span>{$topleaders[i].current_price}</span>
                </div>
                <div class="ct_open_table_data_investment">
                    Investment<br/><span>${$topleaders[i].asset_expire.investment}</span>
                </div>
                <div class="ct_open_table_data_posted">
                    Posted:{$topleaders[i].post_date.0.dateline|date_format:$config.time}<br/>
                    <span class="ct_like">{$topleaders[i].0.like_count}</span>
                    <span class="ct_disslike">{$topleaders[i].0.unlike_count}</span>
                    <span class="ct_viewed">32</span>
                    <span class="ct_followed">{$topleaders[i].0.followed_count}</span>
                </div>
				
                <div class="ct_open_table_data_user">
				
                    {$topleaders[i].username}<br/>{if $topleaders[i].user_id != $user_id}<a href="javascript:void(0)" id="follow_{$topleaders[i].user_id}_{$topleaders[i].id}" {if !$topleaders[i].is_follow}  onclick="follow({$topleaders[i].user_id},{$topleaders[i].id});" {else} onclick="unfollow({$topleaders[i].user_id},{$topleaders[i].id});" class="unfollow" {/if}>Follow</a>{/if}
                </div>

            </div>
        </div>
        <div class="ct_active_links">
            <a href="{$url}?game_id={$topleaders[i].b_asset_id}" target="_blank"><span  class="copy">Copy Trade</span></a>
            <a href="{$url}?reply={$topleaders[i].thread_id}" target="_blank"><span  class="reply">Reply Trade</span></a>
            <a href="{$topleaders[i].url}"><span  class="view">View Post</span></a>
            <a href="#"><span  class="share">Share</span></a>

        </div>
    </div>

    {/section}

</div>

<div class="ct_footer">
    <div class="ct_gray_divider">
        <div class="ct_search">
            <form action="#">
                <input class="search_input" type="text" name="search_box" value="Search Trades">
                <input class="search_input_go" type="submit" value="Go">
            </form></div></div></div>
