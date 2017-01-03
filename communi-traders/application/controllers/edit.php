<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Edit extends MX_Controller {
    
    public function _this() {
        $this->index();
    }
    
    public function index()
    {
        $this->load->model('authmodel');
        $user_params = $this->authmodel->getUserParam();
        $game_id = $this->uri->segment(2);
        $this->load->model('gamemodel');

        if ($this->gamemodel->get_user_game_allowed($user_params['userId'], $game_id) == 1) {
            $asset   = $this->gamemodel->get_asset_by_game($game_id, 'full');
            $short_asset = $this->gamemodel->get_asset_by_game($game_id, 'short'); 
            $this->mysmarty->assign('is_draw', 1);
            $this->mysmarty->assign('asset', $asset);
            $this->mysmarty->assign('short_asset', $short_asset);
            $this->mysmarty->assign('game_id', $game_id);
        }
        else {
            $base_url = $this->config->item('forum_url');
            redirect($base_url);
        }
    }
}
?>
