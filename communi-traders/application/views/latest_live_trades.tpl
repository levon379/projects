{literal}
<script type="text/javascript">
function getThisURL()
{
    pathArray = location.href.split("://");
    pathArray = pathArray[1].split( '/' );
    host = pathArray[0];
    return host;
}
function send_zero(e)
{
	if(e<9){
		return '0'+e;
	}else{
		return e;
	}
}
function like(game_id,likes_user_id,user_id){
	url = '/CommuniTraders/ajax/send_like';
	cct = $('input[name=ci_csrf_token]').val();
	var curr_time = new Date();
    var curr_date = curr_time.getDate();
    var curr_month = curr_time.getMonth() + 1;
    var curr_year = curr_time.getFullYear();
    var curr_hours = curr_time.getHours();
    var curr_minutes = curr_time.getMinutes();
    var curr_sec = curr_time.getSeconds();
	var like_time = curr_year+'-'+send_zero(curr_month)+'-'+send_zero(curr_date)+' '+send_zero(curr_hours)+':'+send_zero(curr_minutes)+':'+send_zero(curr_sec);
	json_data = {
			'game_id':game_id,
			'user_id':user_id,
			'likes_user_id':likes_user_id,
			'like_time':like_time,
            'ci_csrf_token': cct
        } 
	$.post(url, json_data, function(data) {
		 var obj = jQuery.parseJSON(data);
		console.log(obj);
		if(obj){
			var out = '<div class="like_icon"></div><div class="like_text"><span id="like_count_"'+obj.game_id+'>'+obj.likes_count+'</span> likes this trade</div>';
			$('#like_'+obj.game_id).html(out);
		}
	});
}
function unlike(game_id,unlikes_user_id,user_id)
{
	url = '/CommuniTraders/ajax/send_unlike';
	cct = $('input[name=ci_csrf_token]').val();
	
	var curr_time = new Date();
    var curr_date = curr_time.getDate();
    var curr_month = curr_time.getMonth() + 1;
    var curr_year = curr_time.getFullYear();
    var curr_hours = curr_time.getHours();
    var curr_minutes = curr_time.getMinutes();
    var curr_sec = curr_time.getSeconds();
	var unlike_time = curr_year+'-'+send_zero(curr_month)+'-'+send_zero(curr_date)+' '+send_zero(curr_hours)+':'+send_zero(curr_minutes)+':'+send_zero(curr_sec);
	json_data = {
			'game_id':game_id,
			'user_id':user_id,
			'unlikes_user_id':unlikes_user_id,
			'like_time':unlike_time,
            'ci_csrf_token': cct
        } 
	$.post(url, json_data, function(data) {
		 var obj = jQuery.parseJSON(data);
		console.log(obj);
		if(obj){
			var out = '<div class="unlike_icon"></div><div class="unlike_text"><span id="unlike_count_"'+obj.game_id+'>'+obj.user_unlikes_count+'</span> unlikes this trade</div>';
			$('#unlike_'+obj.game_id).html(out);
		}
	});
}
</script>

{/literal}

{$ci_csrf_token}
{counter start=0}

{section name=i max=5 loop=$topleaders}
    <div class="top_user">
        <div class="llt_top_left">
            <div class="llt_avatar"><img src="{$topleaders[i].img}"> </div>
			{if !empty($topleaders[i].username)}
            <div class="llt_user_name">{$topleaders[i].username}</div>
				{/if}
            <div class="llt_country">{if ({$topleaders[i].country})=='' }
                    Country: N/A <br/></div>
            {else}
            {* do something *}
            {$topleaders[i].country} <br/></div>

        {/if}
        <div class="llt_country">WIN RATE:<span> {$topleaders[i].w_rates}%</span></div>


        </div>
    <div class="llt_top_right">

        <div class="llt_asset"><a href="javascript:void(0);">{$topleaders[i].b_asset}</a></div>
        <div class="llt_numbers_asset"><span>{$topleaders[i].asset_expire.price}</span>{$topleaders[i].b_strat}</div>

</div>
        <div class="llt_bottom_left">
            <div class="like" id="like_{$topleaders[i]['b_asset_id']}">
			<div class="like_icon"></div>
			
			{if $topleaders[i].you_like}
			<a href="javascript:void(0)"  onclick="like({$topleaders[i]['b_asset_id']},{$like_user_id},{$topleaders[i]['user_id']});">{/if}
				<div class="like_text">
				<span id="like_count_{$topleaders[i]['b_asset_id']}">{$topleaders[i].like_count}</span> likes this trade</div>
			{if $topleaders[i].you_like}</a>{/if}
		
			

			</div>
            <div class="like" id="unlike_{$topleaders[i]['b_asset_id']}">
                <div class="unlike_icon" ></div>

                {if $topleaders[i].you_unlike}
                <a href="javascript:void(0)"  onclick="unlike({$topleaders[i]['b_asset_id']},{$like_user_id},{$topleaders[i]['user_id']});">{/if}
                    <div class="like_text">
                        <span id="unlike_count_{$topleaders[i]['b_asset_id']}">{$topleaders[i].unlike_count}</span> unlikes this trade</div>
                    {if $topleaders[i].you_unlike}</a>{/if}
            </div>
        </div>
    <div class="llt_bottom_right">

        <!--<div class="llt_c_price"><span>Current Price</span></br>{$topleaders[i].current_price}</div>
        <div class="llt_c_price"><span>Opened</span></br>{$topleaders[i].asset_info.0.0|date_diff}</div>-->
        <div class="ratio" style="padding-left:0;width: 94px;"><span>Payout</span></br>85%</div>
        <div class="c_price"><span>Expires</span></br>{$topleaders[i].asset_expire.expired_at|date_format}</div>
        <div class="copy_trade"><a href="{$url}?game_id={$topleaders[i]['b_asset_id']}" >Copy Trade</a></div>

    </div>

    </div>
{/section}
