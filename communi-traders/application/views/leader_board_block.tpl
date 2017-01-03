{counter start=0}
{section name=i loop=$leaders}
    <tr class="lb_table">
    <td class="lb_counter"><div>{counter}</div></td>
    <td class="lb_name"><a href="{$url}profile/{$leaders[i].username}/{$leaders[i].user_id}">{$leaders[i].username}</a></td>
    <td class="lb_arrow {if $leaders[i].profit_loss_rate > 100}green_arrow{else}red_arrow{/if} "><div></div></td>
    <td class="lb_avatar"><img src="{$leaders[i].img}"></td>
    <td class="lb_tottrades">{$leaders[i].total_trades}(w+b)</td>
    <td class="lb_trades">{$leaders[i].w_trades}</td>
    <td class="lb_rates">{$leaders[i].w_rates}%</td>
    <td class="lb_pl">{$leaders[i].profit_loss_rate}</td>
    <td class="lb_follow"><a href="javascript:void(0);" id="follow_{$leaders[i].user_id}" {if !$leaders[i].is_follow}  onclick="follow_platform({$leaders[i].user_id});" {else} onclick="unfollow_platform({$leaders[i].user_id});" class="unfollow" {/if} >{$leaders[i].username}</a></td>
    </tr>
{/section}

