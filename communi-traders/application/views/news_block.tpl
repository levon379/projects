{section name=i loop=$news}
    <div class="news_wrap">
    <div class="news_title"><h6><a href="{$news[i].link}" target="_blank">{$news[i].title}</a></h6></div>
    <div class="news_date"><span></span>{$news[i].pub_date}</div>
    <div class="news_content"><span></span>{if $news[i].description ne 'NULL'}{$news[i].description}{/if}</div>
    </div>
{/section}
