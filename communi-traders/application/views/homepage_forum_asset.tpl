
{section name=i loop=$asset}

<div class="trade_arena">
    <span class="ta_heading">Trade Arena</span><br/>
	<span class="ta_asset"><a href="{$asset[i].url_forum}" style="color:#43A6DF !important">{$asset[i].asset_name}</a></span><br/>
    <span class="ta_asset" style="font-size: 14px !important;color:#999999 !important;line-height: 26px;">{$asset[i].asset_value}</span></div>

{/section}
<!--<div class="trade_arena">
    <a href="#" class="join_now">
        <span class="ta_heading">Join Now</span><br/>
        <span class="ta_asset">24H</span><br/>
        <span class="ta_asset">Competition</span>
    </a></div>-->