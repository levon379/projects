<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 08:19:25
         compiled from "application/views/about_games.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1849997005185ebddc8e220-39610836%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f661a3d3a4963d698f6e5636cdb3d484307532a0' => 
    array (
      0 => 'application/views/about_games.tpl',
      1 => 1362262320,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1849997005185ebddc8e220-39610836',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_name' => 0,
    'aboutRows' => 0,
    'send' => 0,
    'url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebddd37e0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebddd37e0')) {function content_5185ebddd37e0($_smarty_tpl) {?><table class="table table-bordered td_name">
    <thead>
        <tr class="table_header">
            <th>About <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Country</td>
            <td ><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['country'];?>
</td>
        </tr>
        <tr>
            <td class="td_name">Occupation</td>
            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['occupation'];?>
</td>
        </tr>
        <tr>
            <td class="td_name table_header_second"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
 Trading Specs</td>
            <td class="td_name table_header_second"></td>
        </tr>
        <tr>
            <td class="td_name">Lose Trades Rate</td>
            <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['loseTradesRate'];?>
 %</td>
        </tr>
        <tr>
            <td class="td_name">Broker Name</td>
            <td></td>
        </tr>
        <tr>
            <td class="td_name">
                <?php if ($_smarty_tpl->tpl_vars['send']->value==0){?>
                    <input type="checkbox" id="email_alert" name="email_alert" value="<?php echo $_smarty_tpl->tpl_vars['send']->value;?>
" onChange="sendEmailAlert(); return false;">Get Email Alert
                <?php }else{ ?>
                    <input type="checkbox" checked id="email_alert" name="email_alert" value="<?php echo $_smarty_tpl->tpl_vars['send']->value;?>
" onChange="sendEmailAlert(); return false;">Get Email Alert
                <?php }?>
            </td>
            <td id="is_alert">
                <?php if ($_smarty_tpl->tpl_vars['send']->value==0){?>
                    No
                <?php }else{ ?>
                    Yes
                <?php }?>
            </td>
        </tr>
        <tr>
            <td class="td_name">Demo/Live</td>
            <td></td>
        </tr>
        <tr>
            <td class="td_name">Reset my demo account</td>
            <?php if ($_smarty_tpl->tpl_vars['aboutRows']->value['resetCounter']==0){?>
                <td>never</td>
            <?php }else{ ?>
                <td><?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['resetCounter'];?>
&nbsp;times</td>    
            <?php }?>    
        </tr>
        <tr>
            <td class="td_name">Current Account Balance</td>
            <td>
                $&nbsp;<?php echo $_smarty_tpl->tpl_vars['aboutRows']->value['balance'];?>

                <?php if ($_smarty_tpl->tpl_vars['aboutRows']->value['balance']<=100){?>
                    <div id="reset">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
ajax/renewBalance" class="btn btn-info">Renew balance</a>
                    </div>
                <?php }?>
            </td>
        </tr>
    </tbody>
</table>
<?php }} ?>