<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Wrapper
 *
 * @package         CodeIgniter 2
 * @author          Toxa Bes < toxabes@gmail.com >
 * @copyright       Copyright (c) 2011.
 * @since           Version 1.0
 */
define('SMARTY_DIR', APPPATH . 'third_party/smarty/');
require_once(SMARTY_DIR.'Smarty.class.php');

class Mysmarty extends Smarty
{
    public function __construct ( )
    {
        parent::__construct();
        $config =& get_config();            
        $this->template_dir   = $config['smarty_template_dir'];                                                                        
        $this->compile_dir    = $config['smarty_compile_dir']; 
        $this->cache_dir      = $config['cache_dir'];   
        $this->caching        = $config['caching'];
    }
    
    function view($resource_name, $params = array())   {
        if (strpos($resource_name, '.') === false) {
            $resource_name .= '.tpl';
        }
        
        if (is_array($params) && count($params)) {
            foreach ($params as $key => $value) {
                $this->assign($key, $value);
            }
        }
        
        if (!is_file($this->template_dir . $resource_name)) {
            show_error("template: [$resource_name] cannot be found.");
        }
        
        return parent::display($resource_name);
    }
} 