<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 08:19:24
         compiled from "application/views/head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19053105045185ebdc371621-12537202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0177178dd6ae4931e322b6757f49f46f4f44dde2' => 
    array (
      0 => 'application/views/head.tpl',
      1 => 1362262325,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19053105045185ebdc371621-12537202',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'username' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebdc39c7c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebdc39c7c')) {function content_5185ebdc39c7c($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'application/third_party/smarty/plugins/modifier.date_format.php';
?><div class="navbar">
    <div class="navbar-inner">
        <div id="nav_box">
            <div id="left_part_navbar">
                <a class="brand" href="#" ><img class="img_logo" src="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/images/logo.png" alt=""/></a>
                <a class="pull-right user_link">Welcome,&nbsp;<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
</a>
            </div>  <div id="nav_bar_dev"></div>       
                <div id="right_part_navbar">
                    
                    <div id="date_div"><?php echo smarty_modifier_date_format(time());?>
</div>
                </div>
        </div>
    </div>
</div><?php }} ?>