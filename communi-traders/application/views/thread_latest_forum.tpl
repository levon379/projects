{foreach from=$latest_post  key=postid item=post}
{$post.threadid}
			<li class="avatarcontent floatcontainer widget_post_bit">
				<div class="widget_post_userinfo">
				
				<div class="cms_widget_post_useravatar widget_post_useravatar">
				<a class="smallavatar comments_member_avatar_link" href="">				 
						<img src="{$post.img.img}" alt="{$post.username}"/>
						</a>
				</div>
				</div>
				<div class="smallavatartext widget_post_comment_noavatar">
					<p class="widget_post_content">{$post.keywords}</p>
					<h5 class="widget_post_header"><a href="" class="title">{$post.title}</a></h5>
					<div class="meta">
						<span class="time">{$post.lastpost|date_format}</span> 
						<br/>
					</div>
				</div>
			</li>
			
			{/foreach}
			<li id="thread_post">
			</li>
		