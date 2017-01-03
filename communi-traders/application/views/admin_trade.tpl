{if $act=='read'}   
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
		<form method="post" action="{$url}admin/dashboard/trade/update/update">
       {$ci_csrf_token}
								<label>Stock</label><br>
          						<select id="stock">
								<option value="">Please Select</option>
								{foreach from=$assets.stock key=key item=value}
								{if $value.show_forum==0}
									<option id="stock_{$value.id}"  value="{$value.id}" data="{$value.full_name}">{$value.full_name}</option>
								{/if}
								{/foreach}
							</select>
							<br>
							<div id="stock_show">
							{foreach from=$assets.stock key=key item=value}
								{if $value.show_forum == 1}
								<p class="close_stock" id="{$value.id}" data="{$value.full_name}">
								<input type="hidden" name="stock[{$value.id}]" value="{$value.id}"/><span> {$value.full_name}| hidden</span></p>
								{/if}
								{/foreach}
							</div>
							<label>Currency</label><br>
          						<select id="currency">
								<option value="">Please Select</option>
								{foreach from=$assets.currency key=key item=value}
								{if $value.show_forum == 0}
									<option id="currency_{$value.id}"  value="{$value.id}" data="{$value.full_name}">{$value.full_name}</option>
								{/if}	
								{/foreach}
							</select>
							<br>
							<div id="currency_show">
								{foreach from=$assets.currency key=key item=value}
								{if $value.show_forum == 1}
								<p class="close_currency" id="{$value.id}" data="{$value.full_name}">
								<input type="hidden" name="currency[{$value.id}]" value="{$value.id}"/><span> {$value.full_name}| hidden</span></p>
								{/if}
								{/foreach}
							</div>
							<label>Commodities</label><br>
          						<select id="commodities">
								<option value="">Please Select</option>
								{foreach from=$assets.commodities key=key item=value}
								{if $value.show_forum == 0}
									<option id="commodities_{$value.id}"  value="{$value.id}" data="{$value.full_name}">{$value.full_name}</option>
									{/if}
								{/foreach}
							</select>
								<br>
								<div id="commodities_show">
								{foreach from=$assets.commodities key=key item=value}
								{if $value.show_forum == 1}
								<p class="close_commodities" id="{$value.id}" data="{$value.full_name}">
								<input type="hidden" name="commodities[{$value.id}]" value="{$value.id}"/><span> {$value.full_name}| hidden</span></p>
								{/if}
								{/foreach}
								</div>
							<label>Indices</label><br>
          						<select id="indices">
								<option value="">Please Select</option>
								{foreach from=$assets.indices key=key item=value}
								{if $value.show_forum == 0}
									<option id="indices_{$value.id}"  value="{$value.id}" data="{$value.full_name}">{$value.full_name}</option>
								{/if}
								{/foreach}
							</select>
							<br>
							<div id="indices_show">
							{foreach from=$assets.indices key=key item=value}
								{if $value.show_forum == 1}
								<p class="close_indices" id="{$value.id}" data="{$value.full_name}">
								<input type="hidden" name="indices[{$value.id}]" value="{$value.id}"/><span> {$value.full_name}| hidden</span></p>
								{/if}
								{/foreach}
							</div>
							<br>
		<input type="submit" class="btn btn-success" value="Save Change">
		</form>
    
{/if}
<script type="text/javascript">
$(document).ready(function(){

$("#stock").change(function(){
$("#stock_show").append('<p class="close_stock" id="'+$(this).val()+'" data="'+$("#stock_"+$(this).val()).attr("data")+'"><input type="hidden" name="stock['+$(this).val()+']" value="'+$(this).val()+'"/><span> '+$("#stock_"+$(this).val()).attr("data")+'| hidden</span></p>');
$("#stock_"+$(this).val()).remove();
});
$(".close_stock").live('click',function(){
$("#stock").append('<option id="stock_'+$(this).attr("id")+'"  value="'+$(this).attr("id")+'" data="'+$(this).attr("data")+'">'+$(this).attr("data")+'</option>');
$(this).remove();
})

$("#currency").change(function(){
$("#currency_show").append('<p class="close_currency" id="'+$(this).val()+'" data="'+$("#currency_"+$(this).val()).attr("data")+'"><input type="hidden" name="currency['+$(this).val()+']" value="'+$(this).val()+'"/><span> '+$("#currency_"+$(this).val()).attr("data")+'| hidden</span></p>');
$("#currency_"+$(this).val()).remove();
});
$(".close_currency").live('click',function(){
$("#currency").append('<option id="currency_'+$(this).attr("id")+'"  value="'+$(this).attr("id")+'" data="'+$(this).attr("data")+'">'+$(this).attr("data")+'</option>');
$(this).remove();
})

$("#commodities").change(function(){
$("#commodities_show").append('<p class="close_commodities" id="'+$(this).val()+'" data="'+$("#commodities_"+$(this).val()).attr("data")+'"><input type="hidden" name="commodities['+$(this).val()+']" value="'+$(this).val()+'"/><span> '+$("#commodities_"+$(this).val()).attr("data")+'| hidden</span></p>');
$("#commodities_"+$(this).val()).remove();
});
$(".close_commodities").live('click',function(){
$("#commodities").append('<option id="commodities_'+$(this).attr("id")+'"  value="'+$(this).attr("id")+'" data="'+$(this).attr("data")+'">'+$(this).attr("data")+'</option>');
$(this).remove();
})

$("#indices").change(function(){
$("#indices_show").append('<p class="close_indices" id="'+$(this).val()+'" data="'+$("#indices_"+$(this).val()).attr("data")+'"><input type="hidden" name="indices['+$(this).val()+']" value="'+$(this).val()+'"/><span> '+$("#indices_"+$(this).val()).attr("data")+'| hidden</span></p>');
$("#indices_"+$(this).val()).remove();
});
$(".close_indices").live('click',function(){
$("#indices").append('<option id="indices_'+$(this).attr("id")+'"  value="'+$(this).attr("id")+'" data="'+$(this).attr("data")+'">'+$(this).attr("data")+'</option>');
$(this).remove();
})


})
</script>
