{literal}
<script>
function unfollow(ufing){
              url ='/CommuniTraders/ajax/unfollow';
              cct = $('input[name=ci_csrf_token]').val();
               var json_data = {
						'followeeid': ufing,
                        'ci_csrf_token' : cct
                    }
	
    $.post(url, json_data, function(data) {
      if(data){
        $('#'+data).remove();
       }
   });
}
</script>
{/literal}
<ul class="follow_list">
{$ci_csrf_token}

{foreach from=$data key=id item=val}
		<li class="follow_list_user" id="{$val[0].followeeid}">
			<div class="follow_list_user_avatar"><img src="{$data[{$id}].img.img}"></div>
			<div class="follow_list_user_name"><a href="members/{$val[0].userid}-{$val.followusername}">{$val.followusername}</a></div>
			{if !empty($val[0].userid)}
			<div class="follow_list_user_wrap"><a href="javascript:void(0);" {if $user.userId == $user_id} onclick="unfollow({$val[0].followeeid});"{/if} id="follow_{$val[0].followeeid}">
				<div class="follow_list_user_link {if $user.userId != $user_id} hide_follow{/if}"></div></a></div>
			{else}
			<div class="follow_list_user_wrap"><a href="javascript:void(0);" {if $user.userId == $user_id} onclick="unfollow({$val[0].followeeid});"{/if}  id="follow_{$val[0].followeeid}">
				<div class="follow_list_user_link {if $user.userId != $user_id} hide_follow{/if}"></div></a></div>
			{/if}
		</li>

{/foreach}
	</ul>
<script>

    $( document ).ready(function() {
        var name1 = $('.welcomelink a').text();
        var name2 = $('.ct_member_username').text();

        if (name1 != name2 ) {

            $('.hide_follow').hide()
        }
    });

</script>