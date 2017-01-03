{section name=i max=5 loop=$topleaders}
    <div class="top_user">
        <div class="main_list_top">
            <div class="count_{counter} main_list"></div>

            <div class="user_name main_list"><a href="{$url}profile/{$topleaders[i].username}/{$topleaders[i].user_id}">{$topleaders[i].username}</a></div><div style="clear: both"></div>

            <div class="country main_list">{if ({$topleaders[i].country})=='' }
                    Country: N/A - Joined <span>[ {$topleaders[i].joined_date|date_format} ]</span> </div><div style="clear: both"></div>
            {else}
            {* do something *}
            {$topleaders[i].country} - Joined <span>[ {$topleaders[i].joined_date|date_format} ]</span> </div><div style="clear: both"></div>

        {/if}



        </div>
    <div class="main_list_right">

        <div class="lot_asset"><span>Latest open trade</span></br>{$topleaders[i].b_asset}</div>
        <div class="llt_in_out {if $topleaders[i].profit_loss_rate > 100}green_in{else}red_out{/if}"></div>
        <div class="numbers_asset"><span>{$topleaders[i].asset_expire.price}</span>{$topleaders[i].b_strat}</div>

</div>
        <div class="main_list_bottom">
            <div class="top_five_avatar main_list"><img src="{$topleaders[i].img}" width="40"> </div>
            <div class="asset"><span>Best asset</span></br>{$topleaders[i].b_asset}</div>
            <div class="strategy"><span>Best Strategy</span></br>{$topleaders[i].b_strat}</div>
            <div class="ratio"><span>Winning Ratio</span></br>{$topleaders[i].w_rates}%</div>
            <div class="pl"><span>Total P&L</span></br>${$topleaders[i].total_pl}</div>
        </div>
    <div class="main_list_right_bottom">

       <!-- <div class="c_price"><span>Current Price</span></br>{$topleaders[i].current_price}</div>-->
        <div class="c_price"><span>Expires</span></br>{$topleaders[i].asset_expire.expired_at|date_format}</div>
        <div class="invest"><input type="text" value="$invest"></div>
        <div class="copy_trade"><a href="{$url}?game_id={$topleaders[i]['b_asset_id']}" >Copy Trade</a></div>
    </div>

    </div>
{/section}
