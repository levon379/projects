{if $act=='read'}
    <div class="table_menu">
        <ul class="nav nav-pills">
            <li class="active">
                <a href="{$url}admin/dashboard/rooms/read">Rooms</a>
            </li>
            <li>
                <a class="new_item" href="{$url}admin/dashboard/rooms/real_trade">Real Trade Link</a>
            </li>
        </ul>
    </div>   
    <div id="forum_rooms">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="span1">#</th>
                    <th class="span6">Forum room</th>
                    <th class="span1">Make as default</th>
                    <th class="span1">Status</th>
                    <th class="span1">Allow</th>
                    <th class="span1">Keywords</th>
                </tr>
            </thead>
            <tbody>
                {assign var=foo value = 1}
                {section name=i loop=$rows}
                    <tr>
                        <td class="span1">{$foo}</td>
                        <td class="span6">{$rows[i].title}</td>
                        {if isset($rows[i].default_room) and ($rows[i].default_room == 1)}
                            <td class="span1"><input type="radio" checked name="def_room" value="{$rows[i].forumid}" onclick="make_default_room({$rows[i].forumid}); return true;"></td>
                        {else}
                            <td class="span1"><input type="radio" name="def_room" value="{$rows[i].forumid}" onclick="make_default_room({$rows[i].forumid}); return true;"></td>
                        {/if}
                        <th class="span1">
                            {if $rows[i].status|default:''==1}
                                Yes
                            {else}
                                No   
                            {/if}    
                        </th>
                        <td class="span1">
                            {if $rows[i].status|default:''==1}
                               <a href="{$url}admin/dashboard/rooms/update/abandon/{$rows[i].forumid}">Deny</a>
                            {else}
                               <a href="{$url}admin/dashboard/rooms/update/allow/{$rows[i].forumid}">Allow</a>   
                            {/if} 
                        </td>
                        <td>
                            <form method="POST" action="{$url}admin/dashboard/rooms/update/update_metakeywors/{$rows[i].forumid}">
                                <textarea></textarea>
                                <input type="submit" value="Save">
                            </form>
                        </td>
                    </tr>
                    {assign var=foo value =$foo+1}
                {/section}
            </tbody>
        </table>
    </div>
{/if}
{if $act=='real_trade'}
        <label for="link">Link to Real Trade</label> <div id="changed"></div>
        <input type="text" name="link" id="link" value="{$link}">
        <input type="button" value="Set" onclick="set_new_link(); return false;">
{/if}
{if $act==new}

{/if}
