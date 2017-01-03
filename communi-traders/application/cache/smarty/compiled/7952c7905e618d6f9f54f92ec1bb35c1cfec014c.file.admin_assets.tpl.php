<?php /* Smarty version Smarty 3.1.0, created on 2013-05-13 12:08:20
         compiled from "application/views/admin_assets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8997104425190ad840f5cf8-36831904%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7952c7905e618d6f9f54f92ec1bb35c1cfec014c' => 
    array (
      0 => 'application/views/admin_assets.tpl',
      1 => 1365603466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8997104425190ad840f5cf8-36831904',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'act' => 0,
    'url' => 0,
    'message' => 0,
    'message_content' => 0,
    'assets' => 0,
    'foo' => 0,
    'asset' => 0,
    'asset_type' => 0,
    'ci_csrf_token' => 0,
    'rooms' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5190ad8463eb0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5190ad8463eb0')) {function content_5190ad8463eb0($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['act']->value=='read'){?>   
    <div class="table_menu">
        <ul class="nav nav-pills">
            <li class="active">
                <a href="#stock">Stock</a>
            </li>
            <li>
                <a href="#pairs">Currency Pairs</a>
            </li>
            <li>
                <a href="#commodities">Commodities</a>
            </li>
            <li>
                <a href="#indices">Indices</a>
            </li>
            <li>
                <a class="new_item" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/default/set">Set Default Asset</a>
            </li>
            <li>
                <a class="new_item" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/create/new">Add new asset</a>
            </li>
        </ul>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['message']->value=='success'){?>
        <div id="msg">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>        
                <div id="errors_box" class="errors"><strong><?php echo (($tmp = @$_smarty_tpl->tpl_vars['message_content']->value)===null||$tmp==='' ? '' : $tmp);?>
</strong></div>
            </div>
        </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['message']->value=='error'){?>
        <div id="msg">
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>        
                <div id="errors_box" class="errors"><strong><?php echo (($tmp = @$_smarty_tpl->tpl_vars['message_content']->value)===null||$tmp==='' ? '' : $tmp);?>
</strong></div>
            </div>
        </div>
    <?php }?>
    <div class="table_box">
        <a name="stock"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Stock</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable(1, null, 0);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['stock']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
                    <tr>
                        <td class="span1"><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['short_name'];?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['full_name'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['visibility']==1){?>
                            <td><input type="checkbox" checked name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
, 'company', <?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['visibility'];?>
); return true;"></td>
                        <?php }else{ ?>
                            <td><input type="checkbox" name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
, 'company', <?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['visibility'];?>
); return true;"></td>
                        <?php }?>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/update/edit/stock/<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
">Edit</a></td>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/delete/stock/<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable($_smarty_tpl->tpl_vars['foo']->value+1, null, 0);?>
                <?php endfor; endif; ?>
            </tbody>
        </table>
    </div>
    <div class="table_box">
        <a name="pairs"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Currency Pairs</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable(1, null, 0);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['currency']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>            
                    <tr>
                        <td class="span1"><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['short_name'];?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['full_name'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['visibility']==1){?>
                            <td><input type="checkbox" checked name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
, 'currency', <?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['visibility'];?>
); return true;"></td>
                        <?php }else{ ?>
                            <td><input type="checkbox" name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
, 'currency', <?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['visibility'];?>
); return true;"></td>
                        <?php }?>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/update/edit/currency/<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
">Edit</a></td>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/delete/currency/<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['id'];?>
" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable($_smarty_tpl->tpl_vars['foo']->value+1, null, 0);?>
                <?php endfor; endif; ?>
            </tbody>
        </table>
    </div>
    <div class="table_box">
        <a name="commodities"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Commodities</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable(1, null, 0);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['commodities']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>           
                    <tr>
                        <td class="span1"><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['short_name'];?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['full_name'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['visibility']==1){?>
                            <td><input type="checkbox" checked name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
, 'metall', <?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['visibility'];?>
); return true;"></td>
                        <?php }else{ ?>
                            <td><input type="checkbox" name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
, 'metall', <?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['visibility'];?>
); return true;"></td>
                        <?php }?>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/update/edit/commodities/<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
">Edit</a></td>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/delete/commodities/<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['id'];?>
" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable($_smarty_tpl->tpl_vars['foo']->value+1, null, 0);?>
                <?php endfor; endif; ?>
            </tbody>
        </table>
    </div>
    <div class="table_box">
        <a name="indices"></a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Indices</th>
                <tr>
                    <th class="span1">#</th>
                    <th>Short name</th>
                    <th>Full name</th>
                    <th>Show/Hide</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable(1, null, 0);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['indices']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?>
                    <tr>
                        <td class="span1"><?php echo $_smarty_tpl->tpl_vars['foo']->value;?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['short_name'];?>
</td>
                        <td class="span3"><?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['full_name'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['visibility']==1){?>
                            <td><input type="checkbox" checked name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
" id="show_hide" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
, 'indices', <?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['visibility'];?>
); return true;"></td>
                        <?php }else{ ?>
                            <td><input type="checkbox" name="show_hide<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
" id="show_hide" value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
" onclick="changeVisibility(<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
, 'indices', <?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['visibility'];?>
); return true;"></td>
                        <?php }?>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/update/edit/indices/<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
">Edit</a></td>
                        <td class="span1"><a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/delete/indices/<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['id'];?>
" onclick="return confirmDelete();">Delete</a></td>
                    </tr>
                    <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable($_smarty_tpl->tpl_vars['foo']->value+1, null, 0);?>
                <?php endfor; endif; ?>
            </tbody>
        </table>    
    </div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['act']->value=='edit'){?>
    <br/>
    <h4>Edit&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['asset']->value[0]['full_name'];?>
</strong></h4>
    <form action="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/update/update/<?php echo $_smarty_tpl->tpl_vars['asset_type']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['asset']->value[0]['id'];?>
" method="post">
        <?php echo $_smarty_tpl->tpl_vars['ci_csrf_token']->value;?>

        <label for="short_name">Short name: &nbsp;</label><input type="text" id="short_name" name="short_name" value="<?php echo $_smarty_tpl->tpl_vars['asset']->value[0]['short_name'];?>
" /><br />
        <br/>
        <label for="full_name">Full name: &nbsp;</label><input type="text" id="full_name" name="full_name" value="<?php echo $_smarty_tpl->tpl_vars['asset']->value[0]['full_name'];?>
" /><br />
        <br/>
        <input type="submit" class="btn btn-primary" value="Edit">
    </form>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['act']->value=='new'){?>
    <br/>
    <h4>Add new asset</h4>
    <form action="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/assets/create/add" method="post">  
        <label for="asset">Asset group:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <select id="asset" name="asset">
            <option value="" selected>Select an asset</option>
            <option value="symbols_company">STOCK</option>
            <option value="symbols_currency">CURRENCY PAIRS</option>
            <option value="symbols_metall">COMMODITIES</option>
            <option value="symbols_indices">INDICES</option>
        </select>
        <br/><br/>
        <?php echo $_smarty_tpl->tpl_vars['ci_csrf_token']->value;?>

        <label for="short_name">Short name: &nbsp;</label><input type="text" id="short_name" name="short_name" placeholder="Input short name of the asset..."/><br />
        <br/>
        <label for="full_name">Full name: &nbsp;</label><input type="text" id="full_name" name="full_name" placeholder="Input full name of the asset..."/><br />
        <br/>
        <input type="submit" class="btn btn-primary" value="Add">
    </form>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['act']->value=='set'){?>
<div id="def" style="float: right; font-size: 14pt; font-weight: bold; color: #F31C1C"></div>
    <div class="table_box">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Asset</th>
                    <th>Change</th>
                </tr>
            </thead>
            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['rooms']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
            <tr>
                <td><?php echo $_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'];?>
</td>
                <td>
                    <select id="quote_<?php echo $_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" name="quote">
                        <option selected value="">Undefined</option>
                        <optgroup label="STOCK">
                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['s']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['name'] = 's';
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['stock']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['s']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['s']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['s']['total']);
?>
                                <?php if ($_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name']==$_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['def_asset']){?>
                                    <option selected value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['full_name'];?>
</option>
                                <?php }else{ ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['stock'][$_smarty_tpl->getVariable('smarty')->value['section']['s']['index']]['full_name'];?>
</option>
                                <?php }?>
                            <?php endfor; endif; ?> 
                        </optgroup>
                        <optgroup label="INDICES">
                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['m']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['name'] = 'm';
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['indices']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['m']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['m']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['m']['total']);
?>
                                <?php if ($_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['short_name']==$_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['def_asset']){?>
                                    <option selected value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['full_name'];?>
</option>
                                <?php }else{ ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['indices'][$_smarty_tpl->getVariable('smarty')->value['section']['m']['index']]['full_name'];?>
</option>
                                <?php }?>
                            <?php endfor; endif; ?>
                        </optgroup>
                        <optgroup label="CURRENCY PAIRS">
                             <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['k']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['name'] = 'k';
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['currency']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['k']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['k']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['k']['total']);
?>
                                <?php if ($_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['short_name']==$_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['def_asset']){?>
                                    <option selected value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['full_name'];?>
</option>
                                <?php }else{ ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['currency'][$_smarty_tpl->getVariable('smarty')->value['section']['k']['index']]['full_name'];?>
</option>
                                <?php }?>
                            <?php endfor; endif; ?>
                        </optgroup>
                        <optgroup label="COMMODITIES">
                            <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['l']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['name'] = 'l';
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['assets']->value['commodities']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['l']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['l']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['l']['total']);
?>
                                <?php if ($_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['short_name']==$_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['def_asset']){?>
                                    <option selected value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['full_name'];?>
</option>
                                <?php }else{ ?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['short_name'];?>
"><?php echo $_smarty_tpl->tpl_vars['assets']->value['commodities'][$_smarty_tpl->getVariable('smarty')->value['section']['l']['index']]['full_name'];?>
</option>
                                <?php }?>
                            <?php endfor; endif; ?>
                        </optgroup>
                    </select>
                </td>
                <td><a href="#" onclick="set_default_asset(<?php echo $_smarty_tpl->tpl_vars['rooms']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
);">Change</a></td>
            </tr>
        <?php endfor; endif; ?>
        </table
    </div>
<?php }?>
<?php }} ?>