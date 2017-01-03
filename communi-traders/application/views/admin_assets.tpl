{if $act=='read'}   
    <div class="table_menu">
        <ul class="nav nav-pills">
            <li class="active">
                <a href="#stock">Stock</a>
            </li>
            <li>
                <a href="#pairs">Currency Pairs</a>
            </li>
            <li>
                <a href="#commodities">Commodities</a>
            </li>
            <li>
                <a href="#indices">Indices</a>
            </li>
            <li>
                <a class="new_item" href="{$url}admin/dashboard/assets/default/set">Set Default Asset</a>
            </li>
            <li>
                <a class="new_item" href="{$url}admin/dashboard/assets/create/new">Add new asset</a>
            </li>
        </ul>
    </div>
    {if $message == 'success'}
        <div id="msg">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>        
                <div id="errors_box" class="errors"><strong>{$message_content|default:''}</strong></div>
            </div>
        </div>
    {/if}
    {if $message == 'error'}
        <div id="msg">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>        
                <div id="errors_box" class="errors"><strong>{$message_content|default:''}</strong></div>
            </div>
        </div>
    {/if}
    <div class="table_box">
        <a name="stock"></a>
		<form method="post" id="stock_form" name="assets">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Stock</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide <input type="checkbox" id="chek_all" onclick="checkAll();"></th>
                    <th>Trading Hourse</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                {assign var=foo value = 1}
                {section name=i loop=$assets.stock}
			
                    <tr>
                        <td class="span1">{$foo}</td>
                        <td class="span3">{$assets.stock[i].short_name}</td>
                        <td class="span3">{$assets.stock[i].full_name}</td>
                        {if $assets.stock[i].visibility == 1}
                            <td id="checkbox1"><input type="checkbox" checked name="show_hide_{$assets.stock[i].id}" value="{$assets.stock[i].id}" /></td>
                        {else}
                            <td id="checkbox1"><input type="checkbox" name="show_hide_{$assets.stock[i].id}" value="{$assets.stock[i].id}" /></td>
                        {/if}
						<td>
							<select name="m_time_{$assets.stock[i].id}">
								<option {if $assets.stock[i].m_id == NULL} selected {/if} value="">Please Select</option>
								{foreach from=$assets.m_time key=k item=v}
									<option {if $assets.stock[i].m_id == $v.id}selected{/if} value="{$v.id}">{$v.name}</option>
								{/foreach}
							</select>
						</td>
                        <td class="span1"><a href="{$url}admin/dashboard/assets/update/edit/stock/{$assets.stock[i].id}">Edit</a></td>
                        <td class="span1"><a href="{$url}admin/dashboard/assets/delete/stock/{$assets.stock[i].id}" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    {assign var=foo value =$foo+1}
                {/section}
            </tbody>
        </table>
		<input type="button" class="btn btn-success" onclick="save_stock_change();" value="Save Change">
		</form>
    </div>
    <div class="table_box">
        <a name="pairs"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Currency Pairs</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                {assign var=foo value = 1}
                {section name=k loop=$assets.currency}            
                    <tr>
                        <td class="span1">{$foo}</td>
                        <td class="span3">{$assets.currency[k].short_name}</td>
                        <td class="span3">{$assets.currency[k].full_name}</td>
                        {if $assets.currency[k].visibility == 1}
                            <td><input type="checkbox" checked name="show_hide{$assets.currency[k].id}" value="{$assets.currency[k].id}" onclick="changeVisibility({$assets.currency[k].id}, 'currency', {$assets.currency[k].visibility}); return true;"></td>
                        {else}
                            <td><input type="checkbox" name="show_hide{$assets.currency[k].id}" value="{$assets.currency[k].id}" onclick="changeVisibility({$assets.currency[k].id}, 'currency', {$assets.currency[k].visibility}); return true;"></td>
                        {/if}
                        <td class="span1"><a href="{$url}admin/dashboard/assets/update/edit/currency/{$assets.currency[k].id}">Edit</a></td>
                        <td class="span1"><a href="{$url}admin/dashboard/assets/delete/currency/{$assets.currency[k].id}" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    {assign var=foo value =$foo+1}
                {/section}
            </tbody>
        </table>
    </div>
    <div class="table_box">
        <a name="commodities"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Commodities</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                {assign var=foo value = 1}
                {section name=l loop=$assets.commodities}           
                    <tr>
                        <td class="span1">{$foo}</td>
                        <td class="span3">{$assets.commodities[l].short_name}</td>
                        <td class="span3">{$assets.commodities[l].full_name}</td>
                        {if $assets.commodities[l].visibility == 1}
                            <td><input type="checkbox" checked name="show_hide{$assets.commodities[l].id}" value="{$assets.commodities[l].id}" onclick="changeVisibility({$assets.commodities[l].id}, 'metall', {$assets.commodities[l].visibility}); return true;"></td>
                        {else}
                            <td><input type="checkbox" name="show_hide{$assets.commodities[l].id}" value="{$assets.commodities[l].id}" onclick="changeVisibility({$assets.commodities[l].id}, 'metall', {$assets.commodities[l].visibility}); return true;"></td>
                        {/if}
                        <td class="span1"><a href="{$url}admin/dashboard/assets/update/edit/commodities/{$assets.commodities[l].id}">Edit</a></td>
                        <td class="span1"><a href="{$url}admin/dashboard/assets/delete/commodities/{$assets.commodities[l].id}" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    {assign var=foo value =$foo+1}
                {/section}
            </tbody>
        </table>
    </div>
    <div class="table_box">
        <a name="indices"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Indices</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                {assign var=foo value = 1}
                {section name=m loop=$assets.indices}
                    <tr>
                        <td class="span1">{$foo}</td>
                        <td class="span3">{$assets.indices[m].short_name}</td>
                        <td class="span3">{$assets.indices[m].full_name}</td>
                        {if $assets.indices[m].visibility == 1}
                            <td><input type="checkbox" checked name="show_hide{$assets.indices[m].id}" id="show_hide" value="{$assets.indices[m].id}" onclick="changeVisibility({$assets.indices[m].id}, 'indices', {$assets.indices[m].visibility}); return true;"></td>
                        {else}
                            <td><input type="checkbox" name="show_hide{$assets.indices[m].id}" id="show_hide" value="{$assets.indices[m].id}" onclick="changeVisibility({$assets.indices[m].id}, 'indices', {$assets.indices[m].visibility}); return true;"></td>
                        {/if}
                        <td class="span1"><a href="{$url}admin/dashboard/assets/update/edit/indices/{$assets.indices[m].id}">Edit</a></td>
                        <td class="span1"><a href="{$url}admin/dashboard/assets/delete/indices/{$assets.indices[m].id}" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    {assign var=foo value =$foo+1}
                {/section}
            </tbody>
        </table>    
    </div>
{/if}
{if $act=='edit'}
    <br/>
    <h4>Edit&nbsp;<strong>{$asset[0].full_name}</strong></h4>
    <form action="{$url}admin/dashboard/assets/update/update/{$asset_type}/{$asset[0].id}" method="post">
        {$ci_csrf_token}
        <label for="short_name">Short name: &nbsp;</label><input type="text" id="short_name" name="short_name" value="{$asset[0].short_name}" /><br />
        <br/>
        <label for="full_name">Full name: &nbsp;</label><input type="text" id="full_name" name="full_name" value="{$asset[0].full_name}" /><br />
        <br/>
        <input type="submit" class="btn btn-primary" value="Edit">
    </form>
{/if}
{if $act==new}
    <br/>
    <h4>Add new asset</h4>
    <form action="{$url}admin/dashboard/assets/create/add" method="post">  
        <label for="asset">Asset group:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <select id="asset" name="asset">
            <option value="" selected>Select an asset</option>
            <option value="symbols_company">STOCK</option>
            <option value="symbols_currency">CURRENCY PAIRS</option>
            <option value="symbols_metall">COMMODITIES</option>
            <option value="symbols_indices">INDICES</option>
        </select>
        <br/><br/>
        {$ci_csrf_token}
        <label for="short_name">Short name: &nbsp;</label><input type="text" id="short_name" name="short_name" placeholder="Input short name of the asset..."/><br />
        <br/>
        <label for="full_name">Full name: &nbsp;</label><input type="text" id="full_name" name="full_name" placeholder="Input full name of the asset..."/><br />
        <br/>
        <input type="submit" class="btn btn-primary" value="Add">
    </form>
{/if}
{if $act==set}
<div id="def" style="float: right; font-size: 14pt; font-weight: bold; color: #F31C1C"></div>
    <div class="table_box">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Asset</th>
                    <th>Change</th>
                </tr>
            </thead>
            {section name=i loop=$rooms}
            <tr>
                <td>{$rooms[i].title}</td>
                <td>
                    <select id="quote_{$rooms[i].id}" name="quote">
                        <option selected value="">Undefined</option>
                        <optgroup label="STOCK">
                            {section name=s loop=$assets.stock}
                                {if $assets.stock[s].short_name eq $rooms[i].def_asset}
                                    <option selected value="{$assets.stock[s].short_name}">{$assets.stock[s].full_name}</option>
                                {else}
                                    <option value="{$assets.stock[s].short_name}">{$assets.stock[s].full_name}</option>
                                {/if}
                            {/section} 
                        </optgroup>
                        <optgroup label="INDICES">
                            {section name=m loop=$assets.indices}
                                {if $assets.indices[m].short_name eq $rooms[i].def_asset}
                                    <option selected value="{$assets.indices[m].short_name}">{$assets.indices[m].full_name}</option>
                                {else}
                                    <option value="{$assets.indices[m].short_name}">{$assets.indices[m].full_name}</option>
                                {/if}
                            {/section}
                        </optgroup>
                        <optgroup label="CURRENCY PAIRS">
                             {section name=k loop=$assets.currency}
                                {if $assets.currency[k].short_name eq $rooms[i].def_asset}
                                    <option selected value="{$assets.currency[k].short_name}">{$assets.currency[k].full_name}</option>
                                {else}
                                    <option value="{$assets.currency[k].short_name}">{$assets.currency[k].full_name}</option>
                                {/if}
                            {/section}
                        </optgroup>
                        <optgroup label="COMMODITIES">
                            {section name=l loop=$assets.commodities}
                                {if $assets.commodities[l].short_name eq $rooms[i].def_asset}
                                    <option selected value="{$assets.commodities[l].short_name}">{$assets.commodities[l].full_name}</option>
                                {else}
                                    <option value="{$assets.commodities[l].short_name}">{$assets.commodities[l].full_name}</option>
                                {/if}
                            {/section}
                        </optgroup>
                    </select>
                </td>
                <td><a href="#" onclick="set_default_asset({$rooms[i].id});">Change</a></td>
            </tr>
        {/section}
        </table
    </div>
{/if}
