<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gamemodel extends CI_Model {
    
    public function index() {
        return true;
    }

    /**
     * @desc Function create_game
     * @params $strategy, $time_expire
     * @return last game id
     */
    public function create_game($strategy, $investment, $expire, $price = '', $price_from = '', $price_to = '', $what, $symbol, $how_to_play, $disclosure) 
    {
        $date    = date('Y-m-d H:i:s', strtotime("now"));
        $expireName = $this->getExpiryName($expire);
        $expire  =  date('Y-m-d H:i:s', strtotime('+' . $expire . 'seconds'));
        $user_id = $this->getUserId();
        $asset   = '';
        switch ($what) {
            case 'commodities':
                $table = 'symbols_metall';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'stock':
                $table = 'symbols_company';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'currency':
                $table = 'symbols_currency';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'indices':
                $table = 'symbols_indices';
                $asset = $this->get_asset_name($table, $symbol);
            break;
        }
        
        if ($price == '') {
            $price = 0;
        }
              
        $data = array(
            'user_id'     => $user_id,
            'strategy'    => $strategy,
            'investment'  => $investment,
            'price_from'  => $price_from,
            'price'       => $price,
            'price_to'    => $price_to,
            'asset'       => $asset,
            'asset_short' => $symbol,
            'is_post'     => $how_to_play,
            'disclosure'  => $disclosure,
            'created_at'  => $date,
            'expired_at'  => $expire,
            'expiry_name' => $expireName 
        );
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->insert('game', $data);
        
        $this->db->query("UPDATE user_money SET user_cache=user_cache-$investment WHERE user_id=$user_id");
        
        $this->db->select('id');
        $this->db->from('game');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data[0]['id'];
    }
    
    /**
     * @desc Function update_game_data
     * @params $game_id, $symbol, $price
     */
    public function update_game_data($game_id, $symbol, $price, $in_money)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array(
            'game_id'  => $game_id,
            'symbol'   => $symbol,
            'price'    => $price,
            'in_money' => $in_money
        );
        $this->db->insert('game_data', $data);
    }
    
    /**
     * @desc Function get_game 
     * @params $game_id
     * @return 1 or 0
     */
    public function is_game_expire($game_id)
    {
        $expired = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        $date = date('Y-m-d H:i:s');
        if (strtotime($date) > strtotime($data[0]['expired_at'])) {
            $expired = 1;
        }
       return $expired;
    }
    public function get_game_expire($userId)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
		$this->db->order_by('expired_at', 'DESC');
        $res  = $this->db->get();
        $data = $res->result_array();
        $date = date('Y-m-d H:i:s');
		$expired_game = array();
		foreach($data as $key=>$val){
			if ((strtotime($date) > strtotime($val['expired_at'])) && (strtotime($date)-600 < strtotime($val['expired_at']))) {
				$expired_game[] = $val;
			}
		}
		return $expired_game;
    }
    /**
     * @desc  Function getUserId
     * @return $user_id
     */
    private function getUserId()
    {
        $user_id = '';
        $bb__sessionhash = $_COOKIE['bb_sessionhash'];
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('session');
        $this->db->where('sessionhash',$bb__sessionhash);     
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $user_id = $data[0]['userid'];
        }
        if ($user_id == 0) {
            $this->db = $this->load->database('default', TRUE, TRUE);
            $user_id   = $this->session->userdata('user_id');
        }
        return $user_id;
    }
    
    /**
     * @desc Function get_game_info
     * @params $game_id
     * @return $game_info
     */
    public function get_game_info($game_id)
    {
        $game_info = '';
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        $game_info = $data[0];
        return $game_info;
    }
    
    /**
     * @desc Function is_in_money 
     * @params $game_id
     * @return $in_money
     */
    public function is_in_money($game_id, $price)
    {
        $in_money = 0;
        $game_info = $this->get_game_info($game_id);
        $strategy = $game_info['strategy'];
        switch ($strategy) {
            case 'call':
                if ($game_info['price'] < $price) {
                    $in_money = 1;
                }
            break;
            case 'put';
                if ($game_info['price'] > $price) {
                    $in_money = 1;
                }
            break;
            case 'touch':
                if ($game_info['price'] == $price) {
                    $in_money = 1;
                }
            break;
            case 'no touch':
                if ($game_info['price'] != $price) {
                    $in_money = 1;
                }
            break;
            case 'boundary out':
                if ($game_info['price_from'] == $price or $game_info['price_to'] == $price) {
                    $in_money = 1;
                }
            break;
            case 'boundary inside':
                if ($game_info['price_from'] < $price and $game_info['price_to'] > $price) {
                    $in_money = 1;
                }
            break;
        }
        return $in_money;
    }
    
    /**
     * @desc Function remove_the_game
     * @params $game_id
     */
    public function remove_the_game($game_id)
    {
         $this->db = $this->load->database('default', TRUE, TRUE);
         $this->db->where('id', $game_id);
         $this->db->delete('game');
         
         $this->db->where('game_id', $game_id);
         $this->db->delete('game_data');
    }
    
    /**
     * @desc Function get_asset_name
     * @return $full_name 
     */
    public function get_asset_name($table, $short_name)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('full_name');
        $this->db->from($table);
        $this->db->where('short_name', $short_name);
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data[0]['full_name'];
    }
    
    /**
     * @desc Function save_the_game
     * @params game_id
     */
    public function save_the_game($game_id)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game_data');
        $this->db->where('game_id', $game_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
        $in_money = $data[0]['in_money'];
        $data = array('game_result'=> $in_money);
        $this->db->where('id', $game_id);
        $this->db->update('game', $data);
    }
    
    /**
     * Function post_the_game
     * @params $game_id
     */
    public function post_the_game($game_id)
    {
        $this->save_the_game($game_id);
        $data = array('is_post' => 1, 'visible' => 1);
        $this->db->where('id', $game_id);
        $this->db->update('game', $data);
    }
    
    public function getExpiryName($expiry_value)
    { 
		//var_dump($expiry_value);die;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('expiry_name');
        $this->db->from('expiry_time');
        $this->db->where('expiry_value', $expiry_value);
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
       
        return $data[0]['expiry_name'];
    }
    
	public function getExpiryValue($expiry_name)
    { 
		//var_dump($expiry_value);die;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('expiry_value');
        $this->db->from('expiry_time');
        $this->db->where('expiry_name', $expiry_name);
        $this->db->limit(1);
        $res  = $this->db->get();
        $data = $res->result_array();
       if(!empty($data[0])){
        return $data[0]['expiry_value'];
		}else{
			return true;
		}
    }
    /**
     * Function  get_game_data
     * @params $game_id
     * @return $game_data
     */
    public function get_game_data($game_id)
    {
        $game_data = array();
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $res   = $this->db->get();
        $data  = $res->result_array();
        $table =  $this->getTableName($data[0]['asset_short']);
        $this->db->select();
        $this->db->from($table);
        $this->db->where('game_id', $game_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        foreach ($data as $d) {
            $x = strtotime($d['created_at']);
            $y = (float)$d['price'];
            $temp = array($x, $y);
            array_push($game_data, $temp);
        }
        return $game_data;
    }
    
    private function getTableName($symbol) {
        $limit = 4; // use for 4 letter from symbol name
        $len = strlen($symbol);
        if ($len < $limit) {
            $limit = $len;
        }
        $i = 0;
        $sum = 0;
        $arr = str_split($symbol);
        while ($i < $limit) {
            $sum += ord($arr[$i]);
            $i++;
        }
        $mod = $sum % 26;
        $result = "game_data_" . $mod;
        return $result;
    }
    
    public function get_news($asset)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('finance_news');
        $this->db->where('asset_short', $asset);
        $this->db->where('description IS NOT NULL');
        $this->db->order_by('pub_date DESC');
        $this->db->limit(5);
        $res  = $this->db->get();
        $data = $res->result_array();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['title']       = stripcslashes($data[$i]['title']);
            $data[$i]['description'] = stripcslashes($data[$i]['description']);
        }
        return $data;
    }

    public function get_calendar()
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('finance_calendar');
        $res  = $this->db->get();
        $data = $res->result_array();
        return $data;
    }
    
    public function get_asset_f_name($symbol, $what)
    {
        $table = '';
        $asset = '';
        switch ($what) {
            case 'commodities':
                $table = 'symbols_metall';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'stock':
                $table = 'symbols_company';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'currency':
                $table = 'symbols_currency';
                $asset = $this->get_asset_name($table, $symbol);
            break;
            case 'indices':
                $table = 'symbols_indices';
                $asset = $this->get_asset_name($table, $symbol);
            break;
        }
        return $asset;
    }
    
    public function get_game_data_new($game_id, $asset_short)
    {
        $csv = '';
        $table =  $this->getTableName($asset_short);
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from($table);
        $this->db->where('game_id', $game_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        foreach ($data as $d) {
            $date  = strtotime($d['created_at']);
            $open  = $d['price'];
            $high  = $d['max_d'];
            $low   = $d['min_d'];
            $close = $d['close'];
            $vol   = $d['volume'];
            $csv .= $date . ',' . $open . ',' . $high . ',' . $low . ',' . $close . ',' . $vol . "\n";
        }
        return $csv;
    }
    
    public function get_last_closed_games($limit)
    {
        $this->load->model('authmodel');
        $data = $this->authmodel->getUserParam();
        $user_id = $data['userId'];
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('expiry_name !=', "60 seconds");
        /*$this->db->where('game_result', 1);
        $this->db->or_where('game_result', 0);*/
        $this->db->where('game_result IS NOT NULL');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['price'] = number_format($data[$i]['price'], 4, '.', ' ');
                if($data[$i]['thread_url']!="") {
                    $data[$i]['url'] = "/threads/".$data[$i]['thread_url']."#post".$data[$i]['post_id'];
                } else {
                    $data[$i]['url'] = "";
                }
            }
            return $data;
        }
        return 0;
    }
    
    public function save_img($game_id, $img)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array('game_img' => $img);
        $this->db->where('id', $game_id);
        $this->db->update('game', $data);
    }
    
    public function get_data($game_id)
    {
        $csv = '';
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('asset_short');
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $this->db->where('game_result IS NULL');
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $table = $this->getTableName($data[0]['asset_short']);
            $this->db->select();
            $this->db->from($table);
            $this->db->where('game_id', $game_id);
            $this->db->order_by('id DESC');
            $this->db->limit(1);
            $res  = $this->db->get();
            $data = $res->result_array();
            $open  = $data[0]['price'];
            $high  = $data[0]['max_d'];
            $low   = $data[0]['min_d'];
            $close = $data[0]['close'];
            $vol   = $data[0]['volume'];
            $csv   = $open . ',' . $high . ',' . $low . ',' . $close . ',' . $vol . "\n";
        }
        return $csv;
    }
    
    public function get_asset_by_game($game_id, $flag)
    {
        $asset = '';
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($flag == 'full') {
            $this->db->select('asset');
            $this->db->from('game');
            $this->db->where('id', $game_id);
            $res  = $this->db->get();
            $data = $res->result_array();
            $asset = $data[0]['asset'];
        }
        else if ($flag == 'short') {
             $this->db->select('asset_short');
            $this->db->from('game');
            $this->db->where('id', $game_id);
            $res  = $this->db->get();
            $data = $res->result_array();
            $asset = $data[0]['asset_short'];
        }
        return $asset;
    }
    
    public function get_user_game_allowed($user_id, $game_id=NULL)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
		if(is_numeric($game_id)){
			$this->db->where('id', $game_id);
		}
        $this->db->where('user_id', $user_id);
        $res  = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
	public function get_game_date($start,$end)
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->select("DATE_FORMAT(g.created_at, '%Y-%m-%d') as trade_date",FALSE)->from('game as g');
		$this->db->where('g.created_at BETWEEN "'. date('Y-m-d', $start). '" and "'. date('Y-m-d', $end).'"');
		$data = $this->db->get();
		$res = $data->result_array();
		return $res;
	}
	public function get_user_game($user_id,$limit=0,$count = false)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
		if($limit>0){
			$this->db->limit($limit);
		}
        $res  = $this->db->get();
        $data = $res->result_array();
		if($count){
			return count($data);
		}else{
			if (count($data) > 0) {
				for ($i = 0; $i < count($data); $i++) {
					$data[$i]['price'] = number_format($data[$i]['price'], 4, '.', ' ');
					if($data[$i]['thread_url']!="") {
						$data[$i]['url'] = "/threads/".$data[$i]['thread_url']."#post".$data[$i]['post_id'];
					} else {
						$data[$i]['url'] = "";
					}
				}
				return $data;
			}
		}
		return  0;

    }
	
	public function getCountPosted_for_admin($start_date,$end_date)
    {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
		$dateRange = "game.created_at BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
        $this->db->where($dateRange);
        $this->db->where('is_post', 1);
        $res  = $this->db->get();
        $data = $res->result_array();
        return count($data);
    }
	public function chek_game_exp_date($game_id,$date){
		$this->db = $this->load->database('default', TRUE, TRUE);
		$this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
		$res  = $this->db->get();
        $data = $res->result_array();
		if (strtotime($date) == strtotime($data[0]['expired_at'])) {
            return true;
        }else{
			return false;
		}
		
	}
	public function update_game($game_id,$data_update)
	{
		$this->db = $this->load->database('default', TRUE, TRUE);
		$data = array('disclosure'=> $data_update);
        $this->db->where('id', $game_id);
        $this->db->update('game', $data);
	}
}
