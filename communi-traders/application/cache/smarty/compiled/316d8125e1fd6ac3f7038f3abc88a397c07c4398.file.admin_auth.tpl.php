<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 10:54:47
         compiled from "application/views/admin_auth.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21284831505186104727a399-43337688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '316d8125e1fd6ac3f7038f3abc88a397c07c4398' => 
    array (
      0 => 'application/views/admin_auth.tpl',
      1 => 1363868386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21284831505186104727a399-43337688',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'url' => 0,
    'ci_csrf_token' => 0,
    'error_string' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5186104737c76',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5186104737c76')) {function content_5186104737c76($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Analysis tool admin panel</title>
        <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/css/admin_style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    </head>
    <body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true">        
        <div id="input_center" class="span6">
            <form action="" method="post" class="form-inline log_form">
                <h4>CoomuniTrader admin panel</h4>
                <br/>
                <?php echo $_smarty_tpl->tpl_vars['ci_csrf_token']->value;?>

                <input id="login" type="text" name="login" class="input" placeholder="Login"/>
                <input type="password" name="password" class="input" placeholder="Password"/>
                <button type="submit" class="btn btn-small">Sign in</button>
            </form>
            <?php echo $_smarty_tpl->tpl_vars['error_string']->value;?>

        </div>
    </body>
</html><?php }} ?>