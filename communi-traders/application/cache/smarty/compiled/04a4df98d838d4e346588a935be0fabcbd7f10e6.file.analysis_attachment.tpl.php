<?php /* Smarty version Smarty 3.1.0, created on 2013-07-29 15:55:07
         compiled from "application/views/analysis_attachment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:153951236451870426a696f6-83758484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '04a4df98d838d4e346588a935be0fabcbd7f10e6' => 
    array (
      0 => 'application/views/analysis_attachment.tpl',
      1 => 1375101851,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153951236451870426a696f6-83758484',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.0',
  'unifunc' => 'content_51870426be474',
  'variables' => 
  array (
    'chart_message' => 0,
    'game_id' => 0,
    'title' => 0,
    'forum_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51870426be474')) {function content_51870426be474($_smarty_tpl) {?> <html>
    <body>
     <div id="chart_message"><?php echo $_smarty_tpl->tpl_vars['chart_message']->value;?>
</div>
        <div id="chart_box">
            <input type="hidden" id="game_id" name="game_id" value="<?php echo $_smarty_tpl->tpl_vars['game_id']->value;?>
" />
            <div id="container"><img id="ct_chart_image" alt="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" src="/get_graph_image.php?game_id=<?php echo $_smarty_tpl->tpl_vars['game_id']->value;?>
"
                        /></div>
            <div id="status_content">
                <div id="status_option_name">
                    <div class="name_option strape">
                        &nbsp;&nbsp;Assets
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp;Expire  
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp;Will Expire in  
                    </div>
                    <div class="name_option strape">
                        &nbsp;&nbsp;Strategy
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp;Entry Price  
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp; Cur/Exp Price  
                    </div>
                    <div class="name_option live_status">
                        &nbsp;&nbsp;Trade's LIVE 
                        &nbsp;&nbsp;status 
                    </div>
                    <div class="name_option live_status">
                        &nbsp;&nbsp;Disclosure 
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp;Investments
                    </div>
                    <div class="name_option">
                        &nbsp;&nbsp;P&L
                    </div>
                </div>
                <div id="status_value" class="game_value">
                    <div id="status_assets" class="strape">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="status_expire">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="status_expire_in">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="status_strategy" class="strape">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="status_prices">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="current_price">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="status_live">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="disclosure">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="investments">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="pl">
                        &nbsp;&nbsp;-
                    </div>
                    <div id="refresh_btn">
                        <a href="#" onclick="refreshGameStat(<?php echo $_smarty_tpl->tpl_vars['game_id']->value;?>
); return false;"><img src="<?php echo $_smarty_tpl->tpl_vars['forum_url']->value;?>
clientscript/chart/img/refresh.png" alt="Refresh"></a>
                    </div>
                </div>
            </div>
        </div>     
    </body>
</html>
<?php }} ?>