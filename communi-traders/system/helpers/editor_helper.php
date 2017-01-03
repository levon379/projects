<?php

function tinymce($url, $element, $mode, $theme) { //***урл сайта, элемент формы для редактирования, тип элемента, тема
    return '
<script type="text/javascript" src="' . $url . 'assets/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>          
<script type="text/javascript">       
tinyMCE.init({
       plugins : "jbimages,autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
       force_br_newlines: false,
       force_p_newlines: false,
       forced_root_block: "",
       elements: "' . $element . '",
       cleanup : 0,
       extended_valid_elements : "iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder]",
       media_strict: false,
       mode : "' . $mode . '", 
       theme : "' . $theme . '",
       width:"100%",
       skin : "o2k7",
       skin_variant : "silver",
       language : "en",
       plugins : "jbimages,autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
       theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
       theme_advanced_buttons2 : "outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor,|,charmap,emotions,iespell,advhr,print,fullscreen",
       theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left"
       });
      </script>';
}
?>