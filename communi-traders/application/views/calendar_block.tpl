{section name=i loop=$calendar}
<tr><td colspan="5"><h5><a href="{$calendar[i].link}">{$calendar[i].title}</a></h5><td></tr>
{$calendar[i].description}
{/section}
