<?php /* Smarty version Smarty 3.1.0, created on 2013-05-12 20:39:02
         compiled from "application/views/admin_rooms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:125838220518fd3b6910ce8-59591228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c3419e753189132ec3b8f7cddd413cb3fde3232' => 
    array (
      0 => 'application/views/admin_rooms.tpl',
      1 => 1363868387,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '125838220518fd3b6910ce8-59591228',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'act' => 0,
    'url' => 0,
    'rows' => 0,
    'foo' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_518fd3b6a93c9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_518fd3b6a93c9')) {function content_518fd3b6a93c9($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['act']->value=='read'){?>
    <div class="table_menu">
        <ul class="nav nav-pills">
            <li class="active">
                <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/rooms/read">Rooms</a>
            </li>
            <li>
                <a class="new_item" href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/rooms/real_trade">Real Trade Link</a>
            </li>
        </ul>
    </div>   
    <div id="forum_rooms">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="span1">#</th>
                    <th class="span6">Forum room</th>
                    <th class="span1">Make as default</th>
                    <th class="span1">Status</th>
                    <th class="span1">Allow</th>
                </tr>
            </thead>
            <tbody>
                <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable(1, null, 0);?>
                <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['rows']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
                        <td class="span6"><?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['title'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['default_room']==1){?>
                            <td class="span1"><input type="radio" checked name="def_room" value="<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
" onclick="make_default_room(<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
); return true;"></td>
                        <?php }else{ ?>
                            <td class="span1"><input type="radio" name="def_room" value="<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
" onclick="make_default_room(<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
); return true;"></td>
                        <?php }?>
                        <th class="span1">
                            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status'])===null||$tmp==='' ? '' : $tmp)==1){?>
                                Yes
                            <?php }else{ ?>
                                No   
                            <?php }?>    
                        </th>
                        <td class="span1">
                            <?php if ((($tmp = @$_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status'])===null||$tmp==='' ? '' : $tmp)==1){?>
                               <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/rooms/update/abandon/<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
">Deny</a>
                            <?php }else{ ?>
                               <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
admin/dashboard/rooms/update/allow/<?php echo $_smarty_tpl->tpl_vars['rows']->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forumid'];?>
">Allow</a>   
                            <?php }?> 
                        </td>
                    </tr>
                    <?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_variable($_smarty_tpl->tpl_vars['foo']->value+1, null, 0);?>
                <?php endfor; endif; ?>
            </tbody>
        </table>
    </div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['act']->value=='real_trade'){?>
        <label for="link">Link to Real Trade</label> <div id="changed"></div>
        <input type="text" name="link" id="link" value="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
">
        <input type="button" value="Set" onclick="set_new_link(); return false;">
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['act']->value=='new'){?>

<?php }?>
<?php }} ?>