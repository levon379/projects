<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends MX_Controller {

    public function index() {

        return true;
    }

    public function get_data() 
    {
        $this->load->model('authmodel');
        //To keep alive session we must update session table in vBulletin base
        $this->authmodel->setSession();
        $this->load->model('gamemodel');

        $price = '';
        $price_from = '';
        $price_to = '';
        $symbol = $this->input->post('asset');
        if (preg_match("/^\d+/", $symbol)) {
            $this->load->model('options_model');
            $this->load->model('authmodel');
            $location = $this->authmodel->getLocation();
            if (preg_match("/^\d+/", $location[0])) {
                $forumid  = $location[0];
            }
            else if (preg_match("/^\d+/", $location[1])) {
                $forumid  = $location[1];
            }
            $symbol = $this->options_model->getDefaultAsset($forumid);
        }
        $what     = $this->get_type_of_symbol($symbol);
        $row_data = $this->parse_data($what, $symbol);
        /*echo '<pre>';
        print_r($row_data);
        echo '</pre>';
        exit;*/
        $if_start = $this->input->post('if_start');
        if ($if_start == 1) {
            $expire = $this->input->post('expire');
            $strategy = $this->input->post('strategy');
            $strategy = preg_replace("/_/", ' ', $strategy);
            $investment = $this->input->post('investment');
            $save_option = $this->input->post('save_option');
            $how_to_play = $this->input->post('how_to_play');
            if ($strategy != 'boundary_out' and $strategy != 'boundary_inside') {
                $price = $this->input->post('price');
                $price = preg_replace("/\,/", '.', $price);
            } 
            else {
                $price_from = $this->input->post('price_from');
                $price_from = preg_replace("/\,/", '.', $price_from);
                $price_to = $this->input->post('price_to');
                $price_to = preg_replace("/\,/", '.', $price_to);
            }
        }
        if ($row_data == 'unavailable') {
            echo $row_data;
            exit;
        }
        $data = explode(",", $row_data);
        // The x value 
        $x = time();
        // The y value
        $y = '';
        $avg_ex_price   = trim($data[2]);
        if (preg_match("/\-/", $avg_ex_price)) {
            $avg_ex_price = preg_replace("/\-/", '', $avg_ex_price);
            $avg_ex_price = floatval($avg_ex_price);
            $y = floatval($data[7]) - $avg_ex_price;
            $avg_ex_price = '-' . $avg_ex_price;
        }
        else {
            $avg_ex_price = preg_replace("/\+/", '', $avg_ex_price);
            $avg_ex_price = floatval($avg_ex_price);
            $y = floatval($data[7]) + $avg_ex_price;
        }
        if ($y == '' || $y == 0 || $y == 'N/A' || $y == '0.00') {
            $y = floatval($data[1]);
        }
        
        if (preg_match("/N\/A/", $avg_ex_price)) {
            $avg_ex_price = '';
        }
        // The avg exchange percent 50 days
        $avg_ex_percent = preg_replace("/\r\n/", '', $data[3]);
        $avg_ex_percent =  preg_replace("/\+/", '', $avg_ex_percent);
        if ($if_start == 1) {
            $this->gamemodel->create_game($strategy, $investment, $expire, $price, $price_from, $price_to, $what, $symbol, 0);
        }
        
        $asset_full_name = $this->gamemodel->get_asset_f_name($symbol, $what);
        $t_range_min = 0;
        $t_range_max = 0;
        
        if (!preg_match("/N\/A/", $data[4])) {
            $data[4] = preg_replace("/\"/", '', $data[4]);
            $temp = explode("-", $data[4]);
            $t_range_min = trim($temp[0]);
            $t_range_max = trim($temp[1]); 
        }
        $min    = preg_replace("/[\"\s+]/", '', $data[5]);
        $max    = preg_replace("/[\"\\r\\n]/", '', $data[6]);
        $close  = preg_replace("/N\/A/", '0', $data[7]);
        $volume = preg_replace("/N\/A/", '0', $data[8]);
        $volume = preg_replace("/\r\n/", '', $volume);
        // Create a PHP array and echo it as JSON
        $out = array(
            'x'       => $x,
            'y'       => $y,
            'a_pr'    => $avg_ex_price,
            'a_per'   => $avg_ex_percent,
            't_r_min' => $t_range_min,
            't_r_max' => $t_range_max,
            'min_d'   => $min,
            'max_d'   => $max,     
            'z'       => $asset_full_name,
            'close'   => $close,
            'volume'  => $volume
        );
        echo json_encode($out);

        return false;
    }

    private function parse_data($what, $symbol) {
        $this->get_type_of_symbol($symbol);
        $keys = '';
        switch ($what) {
            case 'commodities':
                if (preg_match("/XAUUSD/", $symbol) || preg_match("/XAGUSD/", $symbol)) {
                    $symbol .= '=X';
                }
                //$keys = 'nl1w4m7m8mjkpa2';
                $keys = 'nl1w4cmjkpa2';
            break;
            case 'stock':
                //$keys = 'nl1w4m7m8mjkpa2';
                $keys = 'nl1w4cmjkpa2';
            break;
            case 'currency':
                $symbol .= '=X';
                //$keys = 'nl1w4m7m8mjkpa2&e=.csv';
                $keys = 'nl1w4cmjkpa2&e=.csv';
            break;
            case 'indices':
                //$keys = 'nl1w4m7m8mjkpa2';
                $keys = 'nl1w4cmjkpa2';
            break;
        }
        $row_data = $this->get_row_data($symbol, $keys);
        $row_data = preg_replace("/\,\s+Inc/", '', $row_data);
        $data     = explode(',', $row_data);
        if (count($data) > 3) {
            $exchange    = explode(' - ', $data[3]);
            $exchange_pr = preg_replace("/\"/", '',$exchange[0]);
            $exchange_pe = preg_replace("/\"/", '',$exchange[1]);
         
            $out      = $data[0] . ',' . $data[1] . ',' . $exchange_pr . ',' . $exchange_pe . ',' . $data[4] . ',' . $data[5] . ',' . $data[6] . ',' . $data[7] . ',' . $data[8];
        }
        else {
            $out = 'unavailable';
        }
        return $out;
    }

    private function get_row_data($symbol, $keys) {
        $data = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=' . $symbol . '&f=' . $keys);
        return $data;
    }

    private function get_type_of_symbol($symbol) 
    {
        $temp = array();
        $this->load->model('options_model');
        $symbols = $this->options_model->_getWhatValues();
        foreach ($symbols['symbols_currency'] as $currency) {
            array_push($temp, $currency['short_name']);
        }
        if (in_array($symbol, $temp)) {
            return 'currency';
        }
        $temp = array();
        foreach ($symbols['symbols_metall'] as $commodity) {
            array_push($temp, $commodity['short_name']);
        }
        if (in_array($symbol, $temp)) {
            return 'commodities';
        }
        $temp = array();
        foreach ($symbols['symbols_company'] as $stock) {
            array_push($temp, $stock['short_name']);
        }
        if (in_array($symbol, $temp)) {
            return 'stock';
        }
        $temp = array();
        foreach ($symbols['symbols_indices'] as $indices) {
            array_push($temp, $indices['short_name']);
        }
        if (in_array($symbol, $temp)) {
            return 'indices';
        }
    }
    
    public function get_preload() 
    {
        $quote      = $this->uri->segment(3);
        if (preg_match("/XAUUSD/", $quote) || preg_match("/XAGUSD/", $quote)) {
            $quote .= '=X';
        }
        $what   = $this->get_type_of_symbol($quote);
        if ($what == 'currency') {
            $quote .= '=X';
        }
        $row_data = file_get_contents('http://chartapi.finance.yahoo.com/instrument/1.0/' . $quote . '/chartdata;type=quote;range=6d/csv');
        $row_data = preg_split("/volume:\d+\,\d+/", $row_data);
        echo $row_data[1] . "\n";
    }

    public function renewBalance(){
        $this->load->model('authmodel');
        $userParam = $this->authmodel->getUserParam();
        
        $this->load->model('money_model');
        $userBalance = $this->money_model->getUserBalance($userParam['userId']);
        
        if($userBalance<=100){
            $userBalance = 20000;
            $this->money_model->renewUserBalance($userParam['userId'],$userBalance);
        }
        
        redirect($this->config->item('base_url').'myperformance');
    }
    
    public function get_promt(){
       $liname = $this->input->post('liname');
       $this->load->model('options_model');
       $promt = $this->options_model->getStrategyPromt($liname);
       
       echo $promt;
    }
    
    public function get_intraday_stat()
    {
        $t = array();
        $high = 0;
        $low  = 0;
        $symbol = $this->input->post('asset'); 
        $what   = $this->get_type_of_symbol($symbol);
        if ($what == 'currency') {
            $symbol .= '=X';
        }
        if (preg_match("/XAUUSD/", $symbol) || preg_match("/XAGUSD/", $symbol)) {
            $symbol .= '=X';
        }
        $row_data = file_get_contents('http://chartapi.finance.yahoo.com/instrument/1.0/' . $symbol . '/chartdata;type=quote;range=6d/csv');
        if (!preg_match("/XAUUSD/", $symbol) and !preg_match("/XAGUSD/", $symbol)) {
            preg_match("/(low:)(\d+\.?\d*)/", $row_data, $matches);
            $low = $matches[2];
            preg_match("/(high:)(\d+\.?\d*.?\,\d+\.?\d+)/", $row_data, $matches);
            $high = $matches[2];
            $temp = explode(',', $high);
            $high = $temp[1];
        }
        $row_data = preg_split("/volume:\d+\,\d+\n/", $row_data);
        
        if (count($row_data) > 1) {
            $row_data = $row_data[1];
            $data = explode("\n", $row_data);
            $count = count($data) - 1;
            for ($i = 0; $i < count($data)-20; $i++) {
                $temp = explode(',', $data[$i]);
                $x = $temp[0] * 1000;
                $y = number_format($temp[0], 4, '.', '');//floatval($temp[1]);
                $r = array($x, $y);
                array_push($t, $r);
            }
        }
        else {
            $x = strtotime(date('Y-m-d H:i:s')) * 1000;
            $y = floatval(1);
            $r = array($x, $y);
            array_push($t, $r);
        }
        $intr_data = array('intr_data' => $t, 'high' => $high, 'low' => $low);
        echo json_encode($intr_data);
    }
    
    public function get_game_series()
    {
        $out_data = array();
        $this->load->model('gamemodel');
        $game_id = $this->input->post('game_id');
        $game_data = $this->gamemodel->get_game_data(8);
        /*echo '<pre>';
        print_r($game_data);
        echo '</pre>';
        exit;*/
        foreach ($game_data as $data) {
            $x = strtotime($data['created_at'])*1000;
            $y = floatval($data['price']);
            $temp = array($x, $y);
            array_push($out_data, $temp);
        }
        echo json_encode($out_data);
    }
    
    public function get_active_games()
    {
        $json_data = array();
        $content  = '';
        $balance  = '';
        $open_pos = 0;
        $url  = $this->config->item('base_url');
        $flag = $this->input->post('flag');
        $user_id = $this->input->post('user_id');
        if ($user_id == 0) {
           $this->load->model('authmodel');
           $data = $this->authmodel->getUserParam();
           $user_id = $data['userId'];
        }
        $this->load->model('statistic_model');
        $data = $this->statistic_model->getActiveGame($user_id);

        foreach ($data as &$d) {
            $open_pos += $d['investment'];
            if($d['thread_url']!="") {
                $d['url'] = "/threads/".$d['thread_url']."#post".$d['post_id'];
            } else {
                $d['url'] = "";
            }
        }

        $balance  = $this->statistic_model->getBalance($user_id);
        $today_pl = $this->statistic_model->get_today_pl($user_id);
        if (count($data) > 0) {
            $user_name = $this->statistic_model->getUserName($user_id);
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('user_name', $user_name);
            $this->mysmarty->assign('currentTrades', $data);
            $this->mysmarty->assign('balance', $balance);
            $this->mysmarty->assign('open_pos', $open_pos);
            if ($flag == 1) {
                $content = $this->mysmarty->fetch('active_games.tpl');
            }
            else {
                $content = $this->mysmarty->fetch('active_games_per.tpl');
            }
        }
        else {
            $balance = $this->statistic_model->getBalance($user_id);
            if ($flag != 1) {
                $content = '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h2>No open trades</h2>';
            }
        }
        $json_data['html']     = $content;
        $json_data['balance']  = $balance;
        $json_data['open_pos'] = $open_pos;
        $json_data['t_pl']     = $today_pl;
        echo json_encode($json_data);
    }
    
    public function get_other_game_info()
    {
        $json_data         = array();
        $closed_games      = '';
        $about_games       = '';
        $performance_games = '';
        $user_id = $this->input->post('user_id');
        if ($user_id == 0) {
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_id = $data['userId'];
        }
        $this->load->model('statistic_model');
        $data = $this->statistic_model->getClosedGames($user_id);
        $url  = $this->config->item('base_url');
        $this->mysmarty->assign('url', $url); 
        //if (count($data) > 0) {
            $user_name = $this->statistic_model->getUserName($user_id);
            $this->mysmarty->assign('user_name', $user_name);
            $this->mysmarty->assign('finishedTrades', $data);
            $closed_games = $this->mysmarty->fetch('closed_games.tpl');
            $data = $this->statistic_model->getAboutData($user_id);
            $this->mysmarty->assign('aboutRows', $data);
//            $send = $this->statistic_model->getAlert($data['userId']);
            $send = $this->statistic_model->getAlert($user_id);
            $this->mysmarty->assign('send', $send);
            $about_games = $this->mysmarty->fetch('about_games.tpl');
            $data = $this->statistic_model->getPerformanceData($user_id);
            $this->mysmarty->assign('performanceRows', $data);
            $performance_games = $this->mysmarty->fetch('performance_games.tpl');
        //}
        $json_data['closed_games']       = $closed_games;
        $json_data['about_games']        = $about_games;
        $json_data['performance_games']  = $performance_games; 
        echo json_encode($json_data);
    }
    
    public function create_game()
    {
        $this->load->model('gamemodel');
        $price_from  = '';
        $price_to    = '';
        $strategy    = $this->input->post('strategy');
        $strategy_clear    = str_replace('_', ' ', $strategy);
        $investment  = $this->input->post('investment');
        $expire      = $this->input->post('expire');
        $symbol      = $this->input->post('asset');
        $how_to_play = $this->input->post('how_to_play');
        $price       = $this->input->post('price');
        $disclosure  = $this->input->post('disclosure');
        $thread_id_to_answer  = $this->input->post('thread_id');
        $data = array(
                    'comment_field' => $this->input->post('comment'),
                    'title'         => $this->input->post('title'),
                    'forumid'       => $this->input->post('forum_id'),
                    'iconid'        => $this->input->post('icon_id'),
                    'visible'       => $this->input->post('visible'),
                    'comment_kw'    => $this->input->post('comment_kw')
                );
        $what        = $this->get_type_of_symbol($symbol);

//        $expireName = $this->gamemodel->getExpiryName($expire);
//        $data['comment_kw'] = $symbol.', '.$strategy_clear.', '.$expireName.', '.$investment;
//        $expireName  =  date('Y-m-d H:i:s', strtotime('+' . $expire . 'seconds'));
//        $data['comment_kw'] = $symbol.', '.$strategy_clear.', expired at '.$expireName.', $'.$investment;
        $data['comment_kw'] = '';

        if ($strategy != 'boundary_out' and $strategy != 'boundary_inside') {
                $price = preg_replace("/\,/", '.', $price);
        } 
        else {
            $price_from = $this->input->post('price_from');
            $price_from = preg_replace("/\,/", '.', $price_from);
            $price_to = $this->input->post('price_to');
            $price_to = preg_replace("/\,/", '.', $price_to);
        }
        $last_game_id = $this->gamemodel->create_game($strategy, $investment, $expire, $price, $price_from, $price_to, $what, $symbol, $how_to_play, $disclosure);
        if($thread_id_to_answer > 0) {
            $this->load->model('newpostmodel');
            $post_id = $this->newpostmodel->postInThread($data, $last_game_id, $thread_id_to_answer);
            $json_data['post_id'] = $post_id;
            $json_data['thread_id'] = $thread_id_to_answer;
            $json_data['game_id'] = $last_game_id;
        } elseif($how_to_play) {
            $this->load->model('newpostmodel');
            $thread_id = $this->newpostmodel->insertNewThread($data, $last_game_id);
            $json_data['thread_id'] = $thread_id;
            $json_data['game_id'] = $last_game_id;
        }
        echo json_encode($json_data);
        exit;
    }
    
    public function get_closed_game()
    {
        $this->load->model('gamemodel');
        $game_id   = $this->input->post('game_id');
        $game_data = $this->gamemodel->get_game_data($game_id);
        $json_data = $game_data;
        echo json_encode($json_data);
    }
    
    public function get_last_closed_games()
    {
        $limit = 5;
        $json_data = array();
        $this->load->model('gamemodel');
        $last_closed = $this->gamemodel->get_last_closed_games($limit);
        if ($last_closed == 0) {
            $json_data['html'] = '';
        }
        else {
            $url = $this->config->item('base_url').'myperformance';
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('last_closed', $last_closed);
            $html = $this->mysmarty->fetch('last_closed_games.tpl');
            $json_data['html'] = $html;
        }
        echo json_encode($json_data);
    }
    
    public function get_news()
    {
        $symbol = $this->input->post('asset');
        if (preg_match("/^\d+/", $symbol)) {
            $this->load->model('options_model');
            $this->load->model('authmodel');
            $location = $this->authmodel->getLocation();
            if (preg_match("/^\d+/", $location[0])) {
                $forumid  = $location[0];
            }
            else if (preg_match("/^\d+/", $location[1])) {
                $forumid  = $location[1];
            }
            $symbol = $this->options_model->getDefaultAsset($forumid);
        }
        $json_data = array();
        $this->load->model('gamemodel');
        $news = $this->gamemodel->get_news($symbol);
        $this->mysmarty->assign('news', $news);
        $content = $this->mysmarty->fetch('news_block.tpl');
        $json_data['news'] = $content;
        echo json_encode($json_data);
        exit;
    }
    
    public function get_calendar()
    {
        $json_data = array();
        $this->load->model('gamemodel');
        $calendar = $this->gamemodel->get_calendar();
        /*echo '<pre>';
        print_r($calendar);
        echo '</pre>';
        exit;*/
        $this->mysmarty->assign('calendar', $calendar);
        $content = $this->mysmarty->fetch('calendar_block.tpl');
        $json_data['calendar'] = $content;
        echo json_encode($json_data);
        exit;
    }
    
    public function get_leader_board($period='week')
    {
        if (!in_array($period,array('week','month','all'))) exit;
        $this->load->driver('cache');
        if (!$content=$this->cache->file->get('get_leader_board_'.$period)) {
            $this->load->model('statistic_model');
            $leaders = $this->statistic_model->get_leaders($period);
            $url    = $this->config->item('base_url');
            $this->mysmarty->assign('leaders', $leaders);
            $this->mysmarty->assign('url', $url);
            $content = $this->mysmarty->fetch('leader_board_block.tpl');
            $this->cache->file->save('get_leader_board_'.$period, $content, 10);
        }
        echo $content;
        exit;
    }
    public function get_topfive_board()
    {
        $this->load->model('statistic_model');
        $url    = $this->config->item('base_url');
        $leaders = $this->statistic_model->get_leaders();

        $this->mysmarty->assign('topleaders', $leaders);
        $this->mysmarty->assign('url', $url);


        $content = $this->mysmarty->fetch('topfive_board_block.tpl');
        echo $content;

    }
    public function get_latesttrade_board()
    {
        $this->load->model('statistic_model');
        $url    = $this->config->item('base_url');
        $leaders = $this->statistic_model->get_leaders();


        $this->mysmarty->assign('topleaders', $leaders);
        $this->mysmarty->assign('url', $url);


        $content = $this->mysmarty->fetch('latest_live_trades.tpl');
        echo $content;;

    }
    public function get_in_or_out_board()
    {
        $this->load->model('statistic_model');
        $url    = $this->config->item('base_url');
        $leaders = $this->statistic_model->get_leaders();


        $this->mysmarty->assign('topleaders', $leaders);
        $this->mysmarty->assign('url', $url);


        $content = $this->mysmarty->fetch('in_or_out.tpl');
        echo $content;

    }

    public function get_open_trades_board()
    {
        $this->load->model('statistic_model');
        $url    = $this->config->item('base_url');
        $leaders = $this->statistic_model->get_leaders();


        $this->mysmarty->assign('topleaders', $leaders);
        $this->mysmarty->assign('url', $url);


        $content = $this->mysmarty->fetch('open_trades.tpl');
        echo $content;

    }
    public function get_homepage_forum_asset()
    {
        $data = array(
            array('asset_name' => 'Eur/Usd', 'asset_value' => '1.32056','asset_time' => '12 09 13:45'),
            array('asset_name' => 'AApl', 'asset_value' => '342.056','asset_time' => '12 09 13:45'),
            array('asset_name' => 'S&P', 'asset_value' => '1320.056','asset_time' => '12 09 13:45')
        );
        $this->mysmarty->assign('asset',$data);
        $content = $this->mysmarty->fetch('homepage_forum_asset.tpl');
        echo  $content;
    }
    
    public function change_alert_status()
    {
        $this->load->model('statistic_model');
        $alert_status = $this->input->post('is_alert');
        $this->load->model('authmodel');
        $data = $this->authmodel->getUserParam();
        $user_id = $data['userId'];
        $this->statistic_model->changeAlertStatus($user_id, $alert_status);
        echo 1;
        exit;
    }
    
    public function set_default_asset()
    {
        $room_id    = $this->input->post('room_id');
        $asset_name = $this->input->post('quote');
        $this->load->model('rooms_model');
        $this->rooms_model->set_default_asset($room_id, $asset_name);
        echo 'ok';
        exit;
    }
    
    public function set_real_trade_link()
    {
        $link = $this->input->post('link');
        $this->load->model('rooms_model');
        $this->rooms_model->set_real_trade_link($link);
        echo 'ok';
        exit;
    }
    
    public function get_game_data()
    {
        $game_id     = $this->uri->segment(3);
        $asset_short = $this->uri->segment(4);
        $this->load->model('gamemodel');
        $csv = $this->gamemodel->get_game_data_new($game_id, $asset_short);
        echo $csv;
        exit;
    }
    
    public function get_game_xml()
    {
        ob_start();
        //$game_id = $this->input->post('game_id');
        //echo $game_id; exit;
        $game_id = $this->uri->segment(3);
        $this->load->model('assets_model');
        $url    = $this->config->item('base_url');
        $data   = $this->assets_model->get_fname_by_game_id($game_id);
        $asset  = $data['asset'];
        $symbol = $data['asset_short'];
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<stock xmlns="http://anychart.com/products/stock/schemas/1.0.0/schema.xsd">
	<data>
		<data_sets>
			<data_set id="dataSet' . $asset . '" source_url="' . $url. 'ajax/get_game_data/' . $game_id . '/' . $symbol . '">
				<csv_settings ignore_first_row="true" rows_separator="\n" columns_separator=","/>
				<locale>
					<date_time>
						<format><![CDATA[%u]]></format>
					</date_time>
				</locale>
			</data_set>
		</data_sets>
		<data_providers>
			<general_data_providers>
				<data_provider data_set="dataSet' . $asset . '" id="dp' . $asset . '">
					<fields>
						<field type="Value" column="4" />
					</fields>
				</data_provider>
			</general_data_providers>
			<scroller_data_providers>
				<data_provider id="scrDp" data_set="dataSet' . $asset . '" column="4"/>
			</scroller_data_providers>
		</data_providers>
	</data>
	<settings>
		<charts>
			<chart>
                <value_axes>
                    <primary position="Right" offset="10">
                    </primary>
                </value_axes>
				<series_list>
					<series type="Line" data_provider="dp' . $asset . '" color="#3463B0">
						<name><![CDATA[' . $asset . ']]></name>
					</series>
				</series_list>
			</chart>
		</charts>
		<time_scale>
            <selected_range type="Custom" start_date="2000-01-02"/>
        </time_scale>
		<scroller data_provider="scrDp"/>
	</settings>
</stock>
';
echo $xml;ob_end_flush();
    }
    
    public function save()
    {
        $this->load->model('gamemodel');
        $img     = $this->input->post('imgData');
        $game_id = $this->input->post('game_id'); 
        $this->gamemodel->save_img($game_id, $img);
        echo 'Ok';
        exit;
    }
    
    public function get_data_draw()
    {
        $csv = '';
        $this->load->model('gamemodel');
        $game_id = $this->input->post('game_id');
        $data    = $this->gamemodel->get_data($game_id);
        if ($data != '') {
            $date    = strtotime(date('Y-m-d H:i:s'));
            $csv  = $date . ',';
            $csv .= $data;
        }
        echo $csv;
    }
    
    public function get_default_asset()
    {
        $this->load->model('options_model');
        $this->load->model('authmodel');
        $forumid = '';
        $location = $this->authmodel->getLocation();
        if (preg_match("/^\d+/", $location[0])) {
            $forumid  = $location[0];
        }
        else { 
            if (preg_match("/^\d+/", $location[1])) {
                $forumid  = $location[1];
            }
        }
        $symbol = $this->options_model->getDefaultAsset($forumid);
        echo $symbol; 
        exit;
    }
    
    public function change_visibility()
    {
        $asset_id   = $this->input->post('asset_id');
        $type       = $this->input->post('type');
        $visibility = $this->input->post('visibility');
        $this->load->model('assets_model');
        $this->assets_model->change_visibility($asset_id, $type, $visibility);
        echo 'ok';
        exit;
    }
    
    public function make_default_room()
    {
        $room_id = $this->input->post('room_id');
        $this->load->model('rooms_model');
        $this->rooms_model->add_default_room($room_id);
        echo 'ok';
        exit;
    }
    
    public function mass_assets_update()
    {
        $visible   = $this->input->post('elements_checked');
        $invisible = $this->input->post('elements_unchecked');
        $this->load->model('adminmodel');
        $this->adminmodel->mass_assets_update($visible, $invisible);
        echo 'Ok';
        exit; 
    }
    public function view_tables()
    {
        $this->load->database('offpista',TRUE,TRUE);
        $tables = $this->db->list_tables();
        echo "<ul>";
        foreach ($tables as $table)
        {
            echo "<li>".$table."</li>";
        }
        echo "</ul>";

        $this->db = $this->load->database('default', TRUE, TRUE);
        //$this->db->select('short_name');
        //$this->db->from('game_strategy');
        $result = $this->db->get('game');
        $query = $result->result_array();
        echo "<pre>";
        print_r($query);
        echo "<pre>";



    }
}
