{counter start=0}

{section name=i max=5 loop=$topleaders}
   <div class="top_user">
       <ul class="main_list">
           <li class="main_list"><img src="{$topleaders[i].img}"> </li>
           <li class="main_list">{$topleaders[i].username}</li>
       </ul>

   </div>
{/section}
