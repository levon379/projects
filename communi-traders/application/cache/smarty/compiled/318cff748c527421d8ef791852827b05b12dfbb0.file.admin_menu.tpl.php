<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 10:54:56
         compiled from "application/views/admin_menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:43223530851861050e2b7e8-65228590%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '318cff748c527421d8ef791852827b05b12dfbb0' => 
    array (
      0 => 'application/views/admin_menu.tpl',
      1 => 1363868387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '43223530851861050e2b7e8-65228590',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_51861050e57a4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51861050e57a4')) {function content_51861050e57a4($_smarty_tpl) {?><div id="nav_part">
    <ul class="nav nav-list">
        <li class="nav-header">Menu list</li>
        <li id="report"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/report/read">Report</a></li>
        <li id="assets"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/read">Assets</a></li>
        <li id="rooms"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/rooms/read">Forum rooms</a></li>
    </ul>
</div>    
<div id="content_part"><?php }} ?>