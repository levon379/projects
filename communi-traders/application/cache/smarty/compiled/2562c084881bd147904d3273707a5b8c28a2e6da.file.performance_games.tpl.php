<?php /* Smarty version Smarty 3.1.0, created on 2013-05-05 08:19:18
         compiled from "application/views/performance_games.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19593661865185ebd6ecc562-79345098%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2562c084881bd147904d3273707a5b8c28a2e6da' => 
    array (
      0 => 'application/views/performance_games.tpl',
      1 => 1362262328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19593661865185ebd6ecc562-79345098',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_name' => 0,
    'performanceRows' => 0,
    'key' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_5185ebd73e5f1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5185ebd73e5f1')) {function content_5185ebd73e5f1($_smarty_tpl) {?><table class="table table-bordered td_name">
    <thead>
        <tr class="table_header">
            <th><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
 Performance Report:</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th>Today</th>
            <th>This Week</th>
            <th>This Month</th>
            <th>This Year</th>
            <th>All time</th>
        </tr>
    </thead>
        <tbody>
            <tr>
                <td>Number of winning trades</td>                    
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['dayResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['weekResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['monthResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['yearResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winningTrades']['allTimePeriod'];?>
</td>
            </tr>
            <tr>
                <td>Number of bad trades</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['dayResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['weekResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['monthResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['yearResult'];?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['badTrades']['allTimePeriod'];?>
</td>
            </tr>
            <tr>
                <td>Win trades rate</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['day'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['week'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['month'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['year'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['winTradesRate']['allTime'];?>
 %</td>
            </tr>
            <tr>
                <td>Loose trades rate</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['day'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['week'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['month'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['year'];?>
 %</td>
                <td><?php echo $_smarty_tpl->tpl_vars['performanceRows']->value['loseTradesRate']['allTime'];?>
 %</td>
            </tr>
            <tr>
                <td>Best asset</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestAsset']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
            </tr>
            <tr>
                <td>Worst asset</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstAsset']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
            </tr>
            <tr>
                <td>Best strategy</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['bestStrategy']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
            </tr>
            <tr>
                <td>Worst strategy</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['dayRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['weekRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['monthRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['yearRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
                <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['worstStrategy']['allTimeRate'])===null||$tmp==='' ? '-' : $tmp);?>
</td>
            </tr>
            <tr>
                <td>Success Rate of Calls strategy</td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['call'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                </tr>
                <tr>
                <td>Success Rate of puts strategy</td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['put'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
            </tr>
            <tr>
                <td>Success Rate of touch strategy</td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                <td>
                    <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                </td>
                </tr>
                <tr>
                    <td>Success Rate of no touch strategy</td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['no touch'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                </tr>
                <tr>
                    <td>Success Rate of boundery out  strategy</td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                </tr>
                <tr>
                    <td>Success Rate of boundary in  strategy</td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyDay'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi out'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyWeek'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyMonth'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyYear'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                    <td>
                        <?php $_smarty_tpl->tpl_vars['key'] = new Smarty_variable((($tmp = @$_smarty_tpl->tpl_vars['performanceRows']->value['procentStrategyAllTime'][0])===null||$tmp==='' ? '' : $tmp), null, 0);?>
                        <?php echo (($tmp = @$_smarty_tpl->tpl_vars['key']->value['bounderi inside'])===null||$tmp==='' ? '0' : $tmp);?>
&nbsp;%
                    </td>
                </tr>
        </tbody>
</table><?php }} ?>