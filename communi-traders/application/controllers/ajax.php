<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends MX_Controller {

    public $short_name;

    public function index() {
        return true;
    }

    public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
    }

    public function get_data() {
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
                $forumid = $location[0];
            } else if (preg_match("/^\d+/", $location[1])) {
                $forumid = $location[1];
            }
            $symbol = $this->options_model->getDefaultAsset($forumid);
        }
        $what = $this->get_type_of_symbol($symbol);
        $row_data = $this->parse_data($what, $symbol);
        /* echo '<pre>';
          print_r($row_data);
          echo '</pre>';
          exit; */
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
            } else {
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
        $avg_ex_price = trim($data[2]);
        if (preg_match("/\-/", $avg_ex_price)) {
            $avg_ex_price = preg_replace("/\-/", '', $avg_ex_price);
            $avg_ex_price = floatval($avg_ex_price);
            $y = floatval($data[7]) - $avg_ex_price;
            $avg_ex_price = '-' . $avg_ex_price;
        } else {
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
        $avg_ex_percent = preg_replace("/\+/", '', $avg_ex_percent);
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
        $min = preg_replace("/[\"\s+]/", '', $data[5]);
        $max = preg_replace("/[\"\\r\\n]/", '', $data[6]);
        $close = preg_replace("/N\/A/", '0', $data[7]);
        $volume = preg_replace("/N\/A/", '0', $data[8]);
        $volume = preg_replace("/\r\n/", '', $volume);
        // Create a PHP array and echo it as JSON
        $out = array(
            'x' => $x,
            'y' => $y,
            'a_pr' => $avg_ex_price,
            'a_per' => $avg_ex_percent,
            't_r_min' => $t_range_min,
            't_r_max' => $t_range_max,
            'min_d' => $min,
            'max_d' => $max,
            'z' => $asset_full_name,
            'close' => $close,
            'volume' => $volume
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
        $data = explode(',', $row_data);
        if (count($data) > 3) {
            $exchange = explode(' - ', $data[3]);
            $exchange_pr = preg_replace("/\"/", '', $exchange[0]);
            $exchange_pe = preg_replace("/\"/", '', $exchange[1]);

            $out = $data[0] . ',' . $data[1] . ',' . $exchange_pr . ',' . $exchange_pe . ',' . $data[4] . ',' . $data[5] . ',' . $data[6] . ',' . $data[7] . ',' . $data[8];
        } else {
            $out = 'unavailable';
        }
        return $out;
    }

    private function get_row_data($symbol, $keys) {
        $data = file_get_contents('http://download.finance.yahoo.com/d/quotes.csv?s=' . $symbol . '&f=' . $keys);
        return $data;
    }

    private function get_type_of_symbol($symbol) {
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

    public function get_preload() {
        $quote = $this->uri->segment(3);
        if (preg_match("/XAUUSD/", $quote) || preg_match("/XAGUSD/", $quote)) {
            $quote .= '=X';
        }
        $what = $this->get_type_of_symbol($quote);
        if ($what == 'currency') {
            $quote .= '=X';
        }
        $row_data = file_get_contents('http://chartapi.finance.yahoo.com/instrument/1.0/' . $quote . '/chartdata;type=quote;range=6d/csv');
        $row_data = preg_split("/volume:\d+\,\d+/", $row_data);
        echo $row_data[1] . "\n";
    }

    public function renewBalance() {
        $this->load->model('authmodel');
        $userParam = $this->authmodel->getUserParam();

        $this->load->model('money_model');
        $userBalance = $this->money_model->getUserBalance($userParam['userId']);

        if ($userBalance <= 100) {
            $userBalance = 20000;
            $this->money_model->renewUserBalance($userParam['userId'], $userBalance);
        }

        redirect($this->config->item('base_url') . 'myperformance');
    }

    public function get_promt() {
        $liname = $this->input->post('liname');
        $this->load->model('options_model');
        $promt = $this->options_model->getStrategyPromt($liname);

        echo $promt;
    }

    public function get_intraday_stat() {
        $t = array();
        $high = 0;
        $low = 0;
        $symbol = $this->input->post('asset');
        $what = $this->get_type_of_symbol($symbol);
        if ($what == 'currency') {
            $symbol .= '=X';
        }
        if (preg_match("/XAUUSD/", $symbol) || preg_match("/XAGUSD/", $symbol)) {
            $symbol .= '=X';
        }
        $row_data = file_get_contents('http://chartapi.finance.yahoo.com/instrument/1.0/' . $symbol . '/chartdata;type=quote;range=6d/csv');
        if (!preg_match("/XAUUSD/", $symbol) and ! preg_match("/XAGUSD/", $symbol)) {
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
            for ($i = 0; $i < count($data) - 20; $i++) {
                $temp = explode(',', $data[$i]);
                $x = $temp[0] * 1000;
                $y = number_format($temp[0], 4, '.', ''); //floatval($temp[1]);
                $r = array($x, $y);
                array_push($t, $r);
            }
        } else {
            $x = strtotime(date('Y-m-d H:i:s')) * 1000;
            $y = floatval(1);
            $r = array($x, $y);
            array_push($t, $r);
        }
        $intr_data = array('intr_data' => $t, 'high' => $high, 'low' => $low);
        echo json_encode($intr_data);
    }

    public function get_game_series() {
        $out_data = array();
        $this->load->model('gamemodel');
        $game_id = $this->input->post('game_id');
        $game_data = $this->gamemodel->get_game_data(8);
        /* echo '<pre>';
          print_r($game_data);
          echo '</pre>';
          exit; */
        foreach ($game_data as $data) {
            $x = strtotime($data['created_at']) * 1000;
            $y = floatval($data['price']);
            $temp = array($x, $y);
            array_push($out_data, $temp);
        }
        echo json_encode($out_data);
    }

    public function get_active_games() {
        $json_data = array();
        $content = '';
        $balance = '';
        $open_pos = 0;
        $url = $this->config->item('base_url');
        $flag = $this->input->post('flag');
        $user_id = $this->input->post('user_id');
        if ($user_id == 0) {
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_id = $data['userId'];
        }
        $this->load->model('statistic_model');
        $this->load->model('gamemodel');
        $data = $this->statistic_model->getActiveGame($user_id);

        foreach ($data as &$d) {
            $open_pos += $d['investment'];
            if ($d['thread_url'] != "") {
                $d['url'] = "/threads/" . $d['thread_url'] . "#post" . $d['post_id'];
            } else {
                $d['url'] = "";
            }
        }
        $currentTrades = array();
        $expired_trade = array();
        foreach ($data as $key => $value) {
            if ($this->gamemodel->is_game_expire($value['id'])) {
                $expired_trade[] = $value;
            } else {
                $currentTrades[] = $value;
            }
        }
        $balance = $this->statistic_model->getBalance($user_id);
        $today_pl = $this->statistic_model->get_today_pl($user_id);
        if (count($data) > 0) {
            $user_name = $this->statistic_model->getUserName($user_id);
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('user_name', $user_name);
            $this->mysmarty->assign('currentTrades', $currentTrades);
            $this->mysmarty->assign('balance', $balance);
            $this->mysmarty->assign('open_pos', $open_pos);
            if ($flag == 1) {
                $content = $this->mysmarty->fetch('active_games.tpl');
            } else {
                $content = $this->mysmarty->fetch('active_games_per.tpl');
            }
        } else {
            $balance = $this->statistic_model->getBalance($user_id);
            if ($flag != 1) {
                $content = '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h2>No open trades</h2>';
            }
        }
        $json_data['html'] = $content;
        $json_data['expired_trade'] = $expired_trade;
        $json_data['balance'] = $balance;
        $json_data['open_pos'] = $open_pos;
        $json_data['t_pl'] = $today_pl;
        echo json_encode($json_data);
    }

    public function get_other_game_info() {
        $json_data = array();
        $closed_games = '';
        $about_games = '';
        $performance_games = '';
        $user_id = $this->input->post('user_id');
        if ($user_id == 0) {
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_id = $data['userId'];
        }
        $this->load->model('statistic_model');
        $data = $this->statistic_model->getClosedGames($user_id);
        $url = $this->config->item('base_url');
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
        $json_data['closed_games'] = $closed_games;
        $json_data['about_games'] = $about_games;
        $json_data['performance_games'] = $performance_games;
        echo json_encode($json_data);
    }

    public function create_game() {
        $this->load->model('gamemodel');
        $price_from = '';
        $price_to = '';
        $trade_url = $this->input->post('trade_url');
        $trade_id_and_game_id = explode('&', $trade_url);
        $strategy = $this->input->post('strategy');
        $strategy_clear = str_replace('_', ' ', $strategy);
        $investment = $this->input->post('investment');
        $expire = $this->input->post('expire');
        $symbol = $this->input->post('asset');
        $how_to_play = $this->input->post('how_to_play');
        $price = $this->input->post('price');
        $disclosure = $this->input->post('disclosure');
        $thread_id_to_answer = $this->input->post('thread_id');
        $forum_id = $this->input->post('forum_id');
        $what = $this->get_type_of_symbol($symbol);

//        $expireName = $this->gamemodel->getExpiryName($expire);
//        $data['comment_kw'] = $symbol.', '.$strategy_clear.', '.$expireName.', '.$investment;
//        $expireName  =  date('Y-m-d H:i:s', strtotime('+' . $expire . 'seconds'));
//        $data['comment_kw'] = $symbol.', '.$strategy_clear.', expired at '.$expireName.', $'.$investment;

        if ($strategy != 'out' and $strategy != 'in') {
            $price = preg_replace("/\,/", '.', $price);
        } else {
            $price_from = $this->input->post('price_from');
            $price_from = preg_replace("/\,/", '.', $price_from);
            $price_to = $this->input->post('price_to');
            $price_to = preg_replace("/\,/", '.', $price_to);
        }
        $last_game_id = $this->gamemodel->create_game($strategy, $investment, $expire, $price, $price_from, $price_to, $what, $symbol, $how_to_play, $disclosure);

        //if($thread_id_to_answer > 0) {
        //	$this->load->model('newpostmodel');
        //	$post_id = $this->newpostmodel->postInThread($data, $last_game_id, $thread_id_to_answer);
        //	$json_data['post_id'] = $post_id;
        //$json_data['thread_id'] = $thread_id_to_answer;
        //$json_data['game_id'] = $last_game_id;
        /* } elseif($how_to_play) {
          $this->load->model('newpostmodel');
          $thread_id = $this->newpostmodel->insertNewThread($data, $last_game_id);
          $json_data['thread_id'] = $thread_id;
          $json_data['game_id'] = $last_game_id;
          } */
        $json_data = array(
            'what' => $what,
            'symbol' => $symbol,
            'last_game_id' => $last_game_id,
            'thread_id' => $thread_id_to_answer,
            'forum_id' => $forum_id
        );
        echo json_encode($json_data);
        exit;
    }

    public function send_post_forum() {
        $last_game_id = $this->input->post('last_game_id');
        $thread_id_to_answer = $this->input->post('thread_id');
        $disclosure = $this->input->post('disclosure');

        $data = array(
            'comment_field' => $this->input->post('comment'),
            'title' => $this->input->post('title'),
            'forumid' => $this->input->post('forum_id'),
            'iconid' => $this->input->post('icon_id'),
            'visible' => $this->input->post('visible'),
                //'comment_kw'    => $this->input->post('comment_kw')
        );
        $json_data = array();
        $this->load->model('gamemodel');
        $this->gamemodel->update_game($last_game_id, $disclosure);
        if ($thread_id_to_answer > 0) {
            $this->load->model('newpostmodel');
            $post_id = $this->newpostmodel->postInThread($data, $last_game_id, $thread_id_to_answer);
            $json_data['post_id'] = $post_id;
            $json_data['thread_id'] = $thread_id_to_answer;
            $json_data['game_id'] = $last_game_id;
        } else {
            $this->load->model('newpostmodel');
            $thread_id = $this->newpostmodel->insertNewThread($data, $last_game_id);
            $json_data['thread_id'] = $thread_id;
            $json_data['game_id'] = $last_game_id;
        }

        echo json_encode($json_data);
        exit;
    }

    public function get_closed_game() {
        $this->load->model('gamemodel');
        $game_id = $this->input->post('game_id');
        $game_data = $this->gamemodel->get_game_data($game_id);
        $json_data = $game_data;
        echo json_encode($json_data);
    }

    public function get_news() {
        $symbol = $this->input->post('asset');
        if (preg_match("/^\d+/", $symbol)) {
            $this->load->model('options_model');
            $this->load->model('authmodel');
            $location = $this->authmodel->getLocation();
            if (preg_match("/^\d+/", $location[0])) {
                $forumid = $location[0];
            } else if (preg_match("/^\d+/", $location[1])) {
                $forumid = $location[1];
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

    public function get_calendar() {
        $json_data = array();
        $this->load->model('gamemodel');
        $calendar = $this->gamemodel->get_calendar();
        $this->mysmarty->assign('calendar', $calendar);
        $content = $this->mysmarty->fetch('calendar_block.tpl');
        $json_data['calendar'] = $content;
        echo json_encode($json_data);
        exit;
    }

    public function get_leader_board($period = 'week') {

        if (!in_array($period, array('week', 'month', 'all')))
            exit;
        $this->load->driver('cache');
        if (!$content = $this->cache->file->get('leader_board_' . $period)) {
            $json_data = array();
            $this->load->model('authmodel');
            $ci_csrf_token = $this->authmodel->getCSRF();
            $this->load->model('statistic_model');
            $leaders = $this->statistic_model->get_leaders($period);
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_id = $data['userId'];
            foreach ($leaders as $key => $val) {
                if ($this->statistic_model->is_follow($val['user_id'], $user_id)) {
                    $leaders[$key]['is_follow'] = true;
                } else {
                    $leaders[$key]['is_follow'] = false;
                }
            }

            $url = $this->config->item('base_url');
            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
            $this->mysmarty->assign('leaders', $leaders);
            $this->mysmarty->assign('url', $url);
            $content = $this->mysmarty->fetch('leader_board_block.tpl');
            $this->cache->file->save('leader_board_' . $period, $content, 3600);
        }
        echo $content;
        exit;
    }

    public function get_topfive_board() {

        $this->load->model('statistic_model');
        $this->load->driver('cache');
        if (!$content = $this->cache->file->get('topfive_board_block')) {
            $url = $this->config->item('base_url');
            $leaders = $this->statistic_model->get_leaders();

            $assets_current_price = array();
         /*   foreach ($leaders as $key => $val) {
                $what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
                $asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
                $leaders[$key]['current_price'] = pars_asset($asset_data);
            }*/

            $this->mysmarty->assign('topleaders', $leaders);
            $this->mysmarty->assign('url', $url);
			$content = $this->mysmarty->fetch('topfive_board_block.tpl');
            $this->cache->file->save('topfive_board_block', $content, 3600);
            
        }
        echo $content;
    }

    public function get_latesttrade_board() {

        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $this->load->model('assets_model');
        $this->load->driver('cache');

        if (!$content = $this->cache->file->get('latest_live_trades')) {
		//var_dump($this->cache->get('latest_live_trades.tpl'));die;
            $json_data = array();
            $url = $this->config->item('base_url');

            $ci_csrf_token = $this->authmodel->getCSRF();

            $leaders = $this->statistic_model->get_leaders();

            /* $assets_current_price = array();
           foreach ($leaders as $key => $val) {
                $what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
                $asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
                $leaders[$key]['current_price'] = pars_asset($asset_data);
            }*/

                $user_id = $this->authmodel->getUserParam();
                foreach ($leaders as $key => $val) {
                    $leaders[$key]['like_count'] = $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id']);
                    $leaders[$key]['unlike_count'] = $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id'],false);
                    if ($this->statistic_model->chek_like_and_unlike($user_id['userId'], $val['b_asset_id'])) {
                        $leaders[$key]['you_like'] = true;
                        
                    } else {
                        $leaders[$key]['you_like'] = false;
                    }
					if($this->statistic_model->chek_like_and_unlike($user_id['userId'], $val['b_asset_id'],false))
					{
						$leaders[$key]['you_unlike'] = true;
					}else{
						$leaders[$key]['you_unlike'] = false;
					}
                }
                $this->mysmarty->assign('like_user_id', $user_id['userId']);


            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
            $this->mysmarty->assign('topleaders', $leaders);
            $this->mysmarty->assign('url', $url);
			$content = $this->mysmarty->fetch('latest_live_trades.tpl');
            $this->cache->file->save('latest_live_trades', $content, 3600);
            
        }
        echo $content;
        
    }

    public function get_in_or_out_board() {
        $this->load->model('statistic_model');
        $this->load->model('authmodel');
		$this->load->driver('cache');

        if (!$content = $this->cache->file->get('in_or_out')) {
			$url = $this->config->item('base_url');
			$leaders = $this->statistic_model->get_leaders();
			$user_id = $this->authmodel->getUserParam();

			$assets_current_price = array();
		   /* foreach ($leaders as $key => $val) {
				$what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
				$asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
				$leaders[$key]['current_price'] = pars_asset($asset_data);
			}*/

			$like_count = array();
			foreach ($leaders as $key => $val) {
				$leaders[$key][]['like_count'] = $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id']);
				$leaders[$key]['unlike_count'] = $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id'],false);
				if ($this->statistic_model->chek_like_and_unlike($user_id['userId'], $val['b_asset_id'])) {
					$leaders[$key][]['you_like'] = true;
				} else {
					$leaders[$key][]['you_like'] = false;
				}
				if($this->statistic_model->chek_like_and_unlike($user_id['userId'], $val['b_asset_id'],false))
				{
					$leaders[$key]['you_unlike'] = true;
				}else{
					$leaders[$key]['you_unlike'] = false;
				}
			}
			$this->mysmarty->assign('like_count', $like_count);
			$this->mysmarty->assign('like_user_id', $user_id['userId']);
			$this->mysmarty->assign('topleaders', $leaders);
			$this->mysmarty->assign('url', $url);
			
			$content = $this->mysmarty->fetch('in_or_out.tpl');
			$this->cache->file->save('in_or_out', $content, 3600);
		}
        echo $content;
    }

    public function get_open_trades_board() {
        $this->load->model('statistic_model');
        $this->load->model('newpostmodel');
        $this->load->model('options_model');
        $this->load->driver('cache');
        if (!$content = $this->cache->file->get('open_trades')) {
            $url = $this->config->item('base_url');
            $leaders = $this->statistic_model->get_live_trade(); //There We can got Live open trade.....
            //$leaders = $this->statistic_model->get_leaders();

            $data = $this->options_model->getToolsOptions();
            $symbols_currency = $data['what']['symbols_currency'];
            $symbols_metall = $data['what']['symbols_metall'];
            $symbols_company = $data['what']['symbols_company'];
            $symbols_indices = $data['what']['symbols_indices'];
            $strategy = $data['strategy'];
            $expiry = $data['expiry'];
            $this->mysmarty->assign('symbols_currency', $symbols_currency);
            $this->mysmarty->assign('symbols_metall', $symbols_metall);
            $this->mysmarty->assign('symbols_company', $symbols_company);
            $this->mysmarty->assign('symbols_indices', $symbols_indices);
            $this->mysmarty->assign('strategy', $strategy);
            $this->mysmarty->assign('expiry', $expiry);

            $ci_csrf_token = $this->authmodel->getCSRF();
            $config['time'] = '%D %H.%M';
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_follow = $data['userId'];
            foreach ($leaders as $key => $val) {
                if ($val['asset_expire']['asset_short']) {
                    $what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
                    $asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
                }
                $leaders[$key]['current_price'] = pars_asset($asset_data);
                $post_date = $this->newpostmodel->get_post($val['asset_expire']['post_id']);
                $leaders[$key]['username'] = $this->authmodel->getUserName($val['user_id']);
                if (!empty($post_date)) {
                    $leaders[$key]['post_date'] = $post_date;
                } else {
                    $leaders[$key]['post_date'] = array(array('dateline' => 'N/A'));
                }
                if ($this->statistic_model->is_follow($val['user_id'], $user_follow)) {
                    $leaders[$key]['is_follow'] = true;
                } else {
                    $leaders[$key]['is_follow'] = false;
                }
                if ($val['asset_expire']['thread_url'] != "") {
                    $leaders[$key]['url'] = "/threads/" . $val['asset_expire']['thread_url'] . "#post" . $val['asset_expire']['post_id'];
                    $url_trade = trim($val['asset_expire']['thread_url'], "-");
                    $leaders[$key]['thread_id'] = $url_trade;
                } else {

                    $leaders[$key]['thread_id'] = trim($val['asset_expire']['thread_url'], '-');
                    $leaders[$key]['url'] = "";
                }
            }
            $like_count = array();
            foreach ($leaders as $key => $val) {

                $leaders[$key][] = array(
                    'like_count' => $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id']),
                    'unlike_count' => $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id'],false),
                    'followed_count' => count($this->statistic_model->get_follow_users($val['user_id'], true, false))
                );
            }
            $this->mysmarty->assign('config', $config);
            $this->mysmarty->assign('like_count', $like_count);
            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
            $this->mysmarty->assign('topleaders', $leaders);
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('user_id', $user_follow);

            $content = $this->mysmarty->fetch('open_trades.tpl');
            $this->cache->file->save('open_trades', $content, 3600);
        }
        echo $content;
    }

    public function get_homepage_forum_asset() {

        $url = $this->config->item('base_url');
        //$this->load->model('assets_model');
        $short_name = array('eur' => 'EURUSD=X', 'gold' => 'XAUUSD=X', 'sp' => '^GSPC', 'usd_jpy' => 'USDJPY=X');
        $key = 'nl1w4cmjkpa2';
        $key1 = 'nl1w4cmjkpa2&e=.csv';
        //$this->assets_model->get_short_name();
        $url_server = $_SERVER['SERVER_NAME'];
        $eur = $this->get_row_data($short_name['eur'], $key1);
        $eur = explode(',', $eur);
        $gold = $this->get_row_data($short_name['gold'], $key);
        $gold = explode(',', $gold);
        $sp = $this->get_row_data($short_name['sp'], $key);
        $sp = explode(',', $sp);
        $usd_jpy = $this->get_row_data($short_name['usd_jpy'], $key1);
        $usd_jpy = explode(',', $usd_jpy);
        $time = date('d m H:i');
        $data = array(
            array('asset_name' => 'Eur/Usd', 'asset_value' => $eur[1], 'asset_time' => $time, 'url_forum' => '/threads/7436-The-EUR-USD-Live-Trading-Arena'),
            array('asset_name' => 'GOLD', 'asset_value' => $gold[1], 'asset_time' => $time, 'url_forum' => '/threads/9894-Gold'),
            array('asset_name' => 'S&P', 'asset_value' => $sp[1], 'asset_time' => $time, 'url_forum' => '/threads/9893-SPX-(s-amp-P-500)-Live-Trading-Arena'),
            array('asset_name' => 'USDJPY', 'asset_value' => $usd_jpy[1], 'asset_time' => $time, 'url_forum' => '/threads/8544-Yen-USD-Trading-Arena')
        );
        $this->mysmarty->assign('asset', $data);
        $this->mysmarty->assign('url', $url);
        $this->mysmarty->assign('eur', $eur);
        $content = $this->mysmarty->fetch('homepage_forum_asset.tpl');
        echo $content;
    }

    public function change_alert_status() {
        $this->load->model('statistic_model');
        $alert_status = $this->input->post('is_alert');
        $this->load->model('authmodel');
        $data = $this->authmodel->getUserParam();
        $user_id = $data['userId'];
        $this->statistic_model->changeAlertStatus($user_id, $alert_status);
        echo 1;
        exit;
    }

    public function set_default_asset() {
        $room_id = $this->input->post('room_id');
        $asset_name = $this->input->post('quote');
        $this->load->model('rooms_model');
        $this->rooms_model->set_default_asset($room_id, $asset_name);
        echo 'ok';
        exit;
    }

    public function set_real_trade_link() {
        $link = $this->input->post('link');
        $this->load->model('rooms_model');
        $this->rooms_model->set_real_trade_link($link);
        echo 'ok';
        exit;
    }

    public function get_game_data() {
        $game_id = $this->uri->segment(3);
        $asset_short = $this->uri->segment(4);
        $this->load->model('gamemodel');
        $csv = $this->gamemodel->get_game_data_new($game_id, $asset_short);
        echo $csv;
        exit;
    }

    public function get_game_xml() {
        ob_start();
        //$game_id = $this->input->post('game_id');
        //echo $game_id; exit;
        $game_id = $this->uri->segment(3);
        $this->load->model('assets_model');
        $url = $this->config->item('base_url');
        $data = $this->assets_model->get_fname_by_game_id($game_id);
        $asset = $data['asset'];
        $symbol = $data['asset_short'];
        $xml = '<?xml version="1.0" encoding="utf-8"?>
<stock xmlns="http://anychart.com/products/stock/schemas/1.0.0/schema.xsd">
	<data>
		<data_sets>
			<data_set id="dataSet' . $asset . '" source_url="' . $url . 'ajax/get_game_data/' . $game_id . '/' . $symbol . '">
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
        echo $xml;
        ob_end_flush();
    }

    public function save() {
        $this->load->model('gamemodel');
        $img = $this->input->post('imgData');
        $game_id = $this->input->post('game_id');
        $this->gamemodel->save_img($game_id, $img);
        echo 'Ok';
        exit;
    }

    public function get_data_draw() {
        $csv = '';
        $this->load->model('gamemodel');
        $game_id = $this->input->post('game_id');
        $data = $this->gamemodel->get_data($game_id);
        if ($data != '') {
            $date = strtotime(date('Y-m-d H:i:s'));
            $csv = $date . ',';
            $csv .= $data;
        }
        echo $csv;
    }

    public function get_default_asset() {
        $this->load->model('options_model');
        $this->load->model('authmodel');
        $forumid = '';
        $location = $this->authmodel->getLocation();
        if (preg_match("/^\d+/", $location[0])) {
            $forumid = $location[0];
        } else {
            if (preg_match("/^\d+/", $location[1])) {
                $forumid = $location[1];
            }
        }
        $symbol = $this->options_model->getDefaultAsset($forumid);
        echo $symbol;
        exit;
    }

    public function change_visibility() {
        $asset_id = $this->input->post('asset_id');
        $type = $this->input->post('type');
        $visibility = $this->input->post('visibility');
        $this->load->model('assets_model');
        $this->assets_model->change_visibility($asset_id, $type, $visibility);
        echo 'ok';
        exit;
    }

    public function make_default_room() {
        $room_id = $this->input->post('room_id');
        $this->load->model('rooms_model');
        $this->rooms_model->add_default_room($room_id);
        echo 'ok';
        exit;
    }

    public function mass_assets_update() {
        $visible = $this->input->post('elements_checked');
        $invisible = $this->input->post('elements_unchecked');
        $this->load->model('adminmodel');
        $this->adminmodel->mass_assets_update($visible, $invisible);
        echo 'Ok';
        exit;
    }

    public function view_tables() {
        $this->load->database('offpista', TRUE, TRUE);
        $tables = $this->db->list_tables();
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . $table . "</li>";
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

    public function save_assets() {
        $this->load->model('assets_model');
        $form = $this->input->post();

        $time_arr = array();
        $visibility_arr = array();
        $temp_arr = array();

        foreach ($form['asset_save'] as $asset) {
            $id = end(explode('_', $asset['name']));

            $temp_arr[] = $id;

            if (strstr($asset['name'], 'show_hide')) {
                $visibility_arr[$id] = 0;
            }

            if (strstr($asset['name'], 'm_time')) {
                $time_arr[$id] = $asset['value'];
            }
        }

        $temp_arr = array_unique($temp_arr);
        sort($temp_arr);

        foreach ($temp_arr as $id) {
            if (isset($visibility_arr[$id])) {
                $visibility = 0;
            } else {
                $visibility = 1;
            }
            $this->assets_model->change_visibility($id, 'company', $visibility);
            $this->assets_model->change_time($id, $time_arr[$id]);
        }
        echo 'Ok';
        exit;
    }

    public function csvToArray($file, $delimiter) {
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
        return $arr;
    }

    public function get_assets_options() {
        $if_start = $this->input->post('if_start');
        $asset_type = $this->input->post('asset');
        if ($asset_type == 'currencies') {
            $asset_type = 'currency';
        }
        $this->load->model('assets_model');
        $short_name = $this->assets_model->get_short_name($asset_type);
        $for_yahoo = '';
        $count = count($short_name);
        $this->short_name = $short_name;
        $from_yahoo = array();
        foreach ($short_name as $key => $val) {
            $from_yahoo[$val['short_name']][] = $this->parse_data($asset_type, $val['short_name']);
        }

        $out = array();
        foreach ($from_yahoo as $key => $value) {

            $data = explode(',', $value[0]);
            if (!empty($data[2])) {
                $asset_short_name = $key;
                $full_name = $this->assets_model->get_full_name($key, $asset_type);
                $avg_ex_price = trim($data[2]);
                if (preg_match("/\-/", $avg_ex_price)) {
                    $avg_ex_price = preg_replace("/\-/", '', $avg_ex_price);
                    $avg_ex_price = floatval($avg_ex_price);
                    $y = floatval($data[7]) - $avg_ex_price;
                    $avg_ex_price = '-' . $avg_ex_price;
                } else {
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
                $avg_ex_percent = preg_replace("/\+/", '', $avg_ex_percent);
                // $a_per = explode('-',$avg_ex_percent);
                /* if(isset($a_per[0])){

                  $a_per_curr[] = $a_per[0];

                  }elseif(isset($a_per[1])){

                  $a_per_curr[] = $a_per[1];

                  }else{

                  $a_per_curr[] = $a_per;
                  } */
                if (!empty($full_name[0]['full_name'])) {
                    $asset_full_name = $full_name[0]['full_name'];
                } else {
                    $asset_full_name = $full_name['full_name'];
                }

                $t_range_min = 0;
                $t_range_max = 0;

                if (!preg_match("/N\/A/", $data[4])) {
                    $data[4] = preg_replace("/\"/", '', $data[4]);
                    $temp = explode("-", $data[4]);
                    $t_range_min = trim($temp[0]);
                    $t_range_max = trim($temp[1]);
                }
                $min = preg_replace("/[\"\s+]/", '', $data[5]);
                $max = preg_replace("/[\"\\r\\n]/", '', $data[6]);
                $close = preg_replace("/N\/A/", '0', $data[7]);
                $volume = preg_replace("/N\/A/", '0', $data[8]);
                $volume = preg_replace("/\r\n/", '', $volume);
                // Create a PHP array and echo it as JSON
                $out[] = array(
                    'y' => $y,
                    'a_pr' => $avg_ex_price,
                    'a_per' => $avg_ex_percent,
                    't_r_min' => $t_range_min,
                    't_r_max' => $t_range_max,
                    'min_d' => $min,
                    'max_d' => $max,
                    'full_name' => $asset_full_name,
                    'short_name' => $asset_short_name,
                    'close' => $close,
                    'volume' => $volume
                );
            }
        }

        echo json_encode($out);
        exit;
    }

    public function count_trade_and_share() {
        $this->load->model('gamemodel');

        $start_date_old = $this->input->post('start');
        $end_date_old = $this->input->post('end');

        $start_date_exp_1 = explode(',', $start_date_old);
        $end_date_exp_1 = explode(',', $end_date_old);

        $start_date_y_m = explode(' ', $start_date_exp_1[0]);
        $end_date_y_m = explode(' ', $end_date_exp_1[0]);

        $start_date = strtotime($start_date_y_m[0] . '-' . $start_date_y_m[1] . '-' . trim($start_date_exp_1[1]));
        $end_date = strtotime($end_date_y_m[0] . '-' . $end_date_y_m[1] . '-' . trim($end_date_exp_1[1]));


        $trade = $this->gamemodel->get_game_date($start_date, $end_date);
        //$posted = $this->gamemodel->getCountPosted_for_admin($start_date,$end_date);

        $data = array();
        foreach ($trade as $key => $val) {
            $data[] = $val['trade_date'];
        }
        $value = array_count_values($data);
        echo json_encode($value);
        exit;
    }

    public function get_user_assets($id) {

        $this->load->model('gamemodel');
        $this->load->model('statistic_model');

        $user_info = $this->statistic_model->getActiveGame($id);
        $user_opent_trade = array();
        foreach ($user_info as $key => $value) {
            if ($this->gamemodel->is_game_expire($value['id']))
                continue;
            //$what     = $this->get_type_of_symbol($value['asset_short']);
            //$asset_val = $this->parse_data($what,$value['asset_short']);
            $user_opent_trade[] = $value;
            //$user_opent_trade['cur_price'] = $asset_val;
        }

        $expirevalue = array();
        foreach ($user_opent_trade as $key => $val) {
            $expirevalue[$key][] = $this->gamemodel->getExpiryValue($val['expiry_name']);
        }
        if (!empty($expirevalue)) {

            //$this->mysmarty->assign('expirevalue',$expirevalue);
        }

        $this->mysmarty->assign('user_info', $user_opent_trade);

        //$this->mysmarty->assign('pagination',$pagination);
        $content = $this->mysmarty->fetch('user_info.tpl');
        echo $content;
    }

    public function get_user_interesting_info($id) {
        $this->load->model('statistic_model');
        $balance = $this->statistic_model->getBalance($id);
        $timeperod = $this->statistic_model->getTimePeriodArray();
        $statistic = $this->statistic_model->getWinningTrades($id, $timeperod);
        if (!empty($statistic['dataAllInfo']['yearResult'])) {
            $yearResult_best = $statistic['dataAllInfo']['yearResult'][0]['asset'];
        } else {
            $yearResult_best = '';
        }
        if (!empty($statistic['dataAllInfo']['yearResult'])) {
            $strategy = $statistic['dataAllInfo']['yearResult'][0]['strategy'];
        } else {
            $strategy = '';
        }
        $allTimePeriod = $statistic['dataCounted']['allTimePeriod'];
        $winratio = $this->statistic_model->get_user_info_for_forum($id);
        $this->mysmarty->assign('balance', $balance);
        $this->mysmarty->assign('winratio', $winratio);
        $this->mysmarty->assign('allTimePeriod', $allTimePeriod);
        $this->mysmarty->assign('statistic', $yearResult_best);
        $this->mysmarty->assign('strategy', $strategy);
        $content = $this->mysmarty->fetch('interesting_user_info.tpl');
        echo $content;
    }

    /* 	
      public function chek_end_game(){
      $now_time = time();
      $data = $this->authmodel->getUserParam();
      $user_id = $data['userId'];


      } */

    public function user_trade_history($id) {

        $limit = 5;
        $json_data = array();
        $this->load->model('gamemodel');
        $this->load->model('statistic_model');
        $tarde_history = $this->gamemodel->get_user_game($id, $limit);
        $trade = array();
        foreach ($tarde_history as $key => $val) {

            $pl = $this->statistic_model->get_game_pl($val['id']);
            $trade[] = array('pl' => $pl, 'trade' => $val);
        }

        $this->mysmarty->assign('tarde_history', $trade);

        $content = $this->mysmarty->fetch('trade_history.tpl');
        echo $content;
    }

    public function get_last_closed_games() {
        $limit = 5;
        $json_data = array();
        $this->load->model('gamemodel');
        $this->load->model('authmodel');
        $data = $this->authmodel->getUserParam();
        $user_id = $data['userId'];
        $last_closed = $this->gamemodel->get_user_game($data['userId'], $limit);
        //$last_closed = $this->gamemodel->get_last_closed_games($limit);

        if ($last_closed == 0) {
            $json_data['html'] = '';
        } else {
            $url = $this->config->item('base_url') . 'myperformance';
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('last_closed', $last_closed);
            $html = $this->mysmarty->fetch('last_closed_games.tpl');

            $json_data['html'] = $html;
        }
        echo json_encode($json_data);
    }

    public function user_performance_report($id) {
        $this->load->model('statistic_model');
        $time_period = $this->statistic_model->getTimePeriodArray();

        $winning_trades = $this->statistic_model->getWinningTrades($id, $time_period);
        $this->mysmarty->assign('winning_trades', $winning_trades);

        $bad_trades = $this->statistic_model->getBadTrades($id, $time_period);
        $this->mysmarty->assign('bad_trades', $bad_trades);
        $user_strategy = $this->statistic_model->success_rate_of_strategy($id);
        $this->mysmarty->assign('user_strategy', $user_strategy);


        /*         * ************************************************************** */
        $performanceRows = $this->statistic_model->getPerformanceData($id);
        $this->mysmarty->assign('performanceRows', $performanceRows);
        /*         * ************************************************************** */



        $get_user_info_for_forum = $this->statistic_model->get_user_info_for_forum($id);
        $this->mysmarty->assign('allinfo', $get_user_info_for_forum);


        $content = $this->mysmarty->fetch('performance_report.tpl');
        echo $content;
    }

    private function like_this_trade($game_id) {
        $this->load->model('gamemodel');
        $game_info = $this->gamemodel->get_game_info($game_id);
        $price_from = '';
        $price_to = $game_info['price_to'];
        $strategy = $game_info['strategy'];
        $strategy_clear = str_replace('_', ' ', $strategy);
        $investment = $game_info['investment'];
        $expire = $this->gamemodel->getExpiryValue($game_info['expiry_name']);
        $symbol = $game_info['asset_short'];
        $how_to_play = 0;
        $price = $game_info['price'];
        $disclosure = $game_info['disclosure'];
        // $thread_id_to_answer  = $this->input->post('thread_id');
        // $forum_id = $this->input->post('forum_id');
        $what = $this->get_type_of_symbol($symbol);

        if ($strategy != 'boundary_out' and $strategy != 'boundary_inside') {
            $price = preg_replace("/\,/", '.', $price);
        } else {
            $price_from = $this->input->post('price_from');
            $price_from = preg_replace("/\,/", '.', $price_from);
            $price_to = $this->input->post('price_to');
            $price_to = preg_replace("/\,/", '.', $price_to);
        }
        $last_game_id = $this->gamemodel->create_game($strategy, $investment, $expire, $price, $price_from, $price_to, $what, $symbol, $how_to_play, $disclosure);
        return $last_game_id;
    }

    public function send_like() {
        $game_id = $this->input->post('game_id');
        $user_id = $this->input->post('user_id');
        $likes_user_id = $this->input->post('likes_user_id');
        $like_time = $this->input->post('like_time');
        $data = array('game_id' => $game_id, 'likes_user_id' => $likes_user_id, 'user_id' => $user_id, 'like_time' => date('Y-m-d H:i:s', strtotime($like_time)));
        $this->load->model('statistic_model');
        $this->like_this_trade($game_id);
        $ins = $this->statistic_model->send_notification($data);
        $json_out = array();

        if ($ins) {
            $json_out = array(
                'user_likes_count' => $this->statistic_model->get_likes_and_unlike_count($game_id),
                'game_id' => $game_id,
              //  'new_game_id' => $new_game_id,
                'likes_count' => $this->statistic_model->get_likes_and_unlike_count($game_id)
            );
            echo json_encode($json_out);
            exit;
        } else {
            echo 'false';
        }
    }
	public function send_unlike()
	{
		$game_id = $this->input->post('game_id');
        $user_id = $this->input->post('user_id');
        $unlikes_user_id = $this->input->post('unlikes_user_id');
        $like_time = $this->input->post('like_time');
        $data = array('game_id' => $game_id, 'unlikes_user_id' => $unlikes_user_id, 'user_id' => $user_id, 'like_time' => date('Y-m-d H:i:s', strtotime($like_time)));
        $this->load->model('statistic_model');
       // $this->like_this_trade($game_id);
        $ins = $this->statistic_model->send_notification($data);
        $json_out = array();

        if ($ins) {
            $json_out = array(
                'user_unlikes_count' => $this->statistic_model->get_likes_and_unlike_count($game_id,false),
                'game_id' => $game_id,
               // 'new_game_id' => $new_game_id,
               // 'likes_count' => $this->statistic_model->get_likes_count($game_id)
            );
            echo json_encode($json_out);
            exit;
        } else {
            echo 'false';
        }
	}

    public function chek_notification() {
        $user_id = $this->input->post('user_id');
        $this->load->model('statistic_model');
        $data = array(
            'notification_user' => $this->statistic_model->chek_notification($user_id),
            'notification_count' => count($this->statistic_model->chek_notification($user_id))
        );
        echo json_encode($data);
        exit;
    }

    public function looked_like() {
        $game_id = $this->input->post('game_id');
        $user_id = $this->input->post('user_id');
        $likes_user_id = $this->input->post('likes_user_id');
        $this->load->model('statistic_model');
        $this->statistic_model->looked_like($game_id, $user_id, $likes_user_id);
    }

    public function looked_follow() {
        $followerid = $this->input->post('followerid');
        $followeeid = $this->input->post('followeeid');
        $this->load->model('statistic_model');
        $this->statistic_model->looked_follow($followerid, $followeeid);
    }

    public function chek_expired_game() {
        $game_id = $this->input->post('game_id');
        $this->load->model('gamemodel');
        $json_data = array();
        if (!empty($game_id)) {
            foreach ($game_id as $key => $val) {
                if ($this->gamemodel->is_game_expire($val)) {
                    $json_data[$key][] = $this->gamemodel->get_game_info($val);
                }
            }
        }
        echo json_encode($json_data);
        exit;
    }

    public function get_cct() {
        $this->load->model('authmodel');
        $ci_csrf_token = $this->authmodel->getCSRF();
        echo $ci_csrf_token;
    }

    public function follow() {
        $user_following = $this->input->post('user_following');
        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $data = $this->authmodel->getUserParam();
        $user_follow = $data['userId'];
        $store_data = array(
            'followerid' => $user_follow,
            'followeeid' => $user_following,
            'dateline' => time()
        );
        if ($this->statistic_model->user_follow($store_data)) {
            echo $user_following;
        } else {
            echo 'NOT';
        }
    }

    public function unfollow() {
        $followeeid = $this->input->post('followeeid');
        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $data = $this->authmodel->getUserParam();
        $followerid = $data['userId'];
        $store_data = array(
            'followerid' => $followerid,
            'followeeid' => $followeeid,
                //'looked' => 2
        );
        if ($this->statistic_model->user_unfollow($store_data)) {
            echo $followeeid;
        } else {
            echo 'NOT';
        }
    }

    /*     * *************For Comment Notification************************ */

    public function get_comment_notification() {
        $this->load->model('statistic_model');
        $this->load->model('authmodel');
        $data = $this->authmodel->getUserParam();
        $userId = $data['userId'];
        $user_post_notification = $this->statistic_model->get_post_thread_id($userId);
        $not_empty_comment = array();
        $time = time();
        foreach ($user_post_notification as $key => $val) {
            $post_comment = $this->statistic_model->get_post_comment_notification($userId, $val['postid'], $val['threadid'], 0, $time);
            if (!empty($post_comment)) {

                $not_empty_comment = $post_comment;
            }
        }
        $count_post_notification = count($not_empty_comment);
        $json_data = array('post_comment' => $not_empty_comment, 'comment_caount' => $count_post_notification);
        echo json_encode($json_data);
        exit;
    }

    public function update_comment() {
        $this->load->model('newpostmodel');
        $post_id = $this->input->post('post_id');
        $this->newpostmodel->update_post($post_id);
        echo $post_id;
        exit;
    }

    public function is_follow($user_following) {
        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $data = $this->authmodel->getUserParam();
        $user_follow = $data['userId'];
        if (!$this->statistic_model->is_follow($user_following, $user_follow)) {
            echo '<a href="javascript:void(0);" onclick="follow(' . $user_following . ');" id="follow_' . $user_following . '">Follow Users</a>';
        } else {
            echo '<a href="javascript:void(0);" onclick="unfollow(' . $user_following . ');" id="follow_' . $user_following . '">Unfollow Users</a>';
        }
    }

    /*     * ****************FOR forum member info page ********************** */

    public function get_follow_users($user_id) {
        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $data = $this->statistic_model->get_follow_users($user_id, false, true);
		$domain = $_SERVER['SERVER_NAME'];
        $user = $this->authmodel->getUserParam();
        $ci_csrf_token = $this->authmodel->getCSRF();
        $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
        $this->mysmarty->assign('data', $data);
        $this->mysmarty->assign('domain', $domain);
        $this->mysmarty->assign('user_id', $user_id);
        $this->mysmarty->assign('user', $user);
        $content = $this->mysmarty->fetch('follow_user.tpl');
        echo $content;
    }

    public function get_follow_notification() {
        $user_id = $this->input->post('user_id');
        $this->load->model('statistic_model');
        $data = $this->statistic_model->get_follow_users($user_id, true, false);
        echo json_encode($data);
        exit;
    }

    public function copy_trade() {
        $game_id = $this->input->post('game_id');
        if ($game_id) {
            $game_id = explode('=', $game_id);
            $this->load->model('authmodel');
            $this->load->model('gamemodel');
            $data = $this->authmodel->getUserParam();
            $user_id = $data['userId'];

            $game_info = $this->gamemodel->get_game_info($game_id[1]);
            $symbol = $game_info['asset_short'];
            $what = $this->get_type_of_symbol($symbol);
            $asset_tab = '';
            $asset_tab_notouch = '';
            if ($what == 'currency') {
                $what = 'currencies';
            }
            if ($game_info['strategy'] == 'put' || $game_info['strategy'] == 'call') {
                $asset_tab = 'high_tab';
            }
            if ($game_info['strategy'] == 'boundary_inside' || $game_info['strategy'] == 'boundary_out') {
                $asset_tab = 'boundary_tab';
            }
            if ($game_info['strategy'] == 'touch_up' || $game_info['strategy'] == 'touch_down') {
                $asset_tab = 'touch_tab';
            }
            if ($game_info['strategy'] == 'no_touch_up' || $game_info['strategy'] == 'no_touch_down') {
                $asset_tab = 'touch_tab';
                $asset_tab_notouch = '#tab_no_touch';
            }



            $json_data = array(
                'asset_short' => $game_info['asset_short'],
                'what' => $what,
                'asset_tab' => $asset_tab,
                'asset_tab_notouch' => $asset_tab_notouch
            );
            echo json_encode($json_data);
            exit;
        }
    }

    public function filter_by_any() {
        $assets = trim($this->input->post('assets'));
        $strategy = trim($this->input->post('strategy'));
        $expiry_post = trim($this->input->post('expiry'));
        $this->load->model('statistic_model');
        $this->load->model('gamemodel');
        $this->load->model('newpostmodel');
        $this->load->model('options_model');
        $cahing = '';
        if ($assets != '') {
            $cahing .= $assets;
        }
        if ($strategy != '') {
            $cahing .= $strategy;
        }
        if ($expiry_post != '') {
            $cahing .= $expiry_post;
        }
        $this->load->driver('cache');
        if (!$content = $this->cache->file->get('open_trades' . $cahing)) {

            $data = $this->options_model->getToolsOptions();
            $symbols_currency = $data['what']['symbols_currency'];
            $symbols_metall = $data['what']['symbols_metall'];
            $symbols_company = $data['what']['symbols_company'];
            $symbols_indices = $data['what']['symbols_indices'];
            $strategy = $data['strategy'];
            $expiry = $data['expiry'];
            $this->mysmarty->assign('symbols_currency', $symbols_currency);
            $this->mysmarty->assign('symbols_metall', $symbols_metall);
            $this->mysmarty->assign('symbols_company', $symbols_company);
            $this->mysmarty->assign('symbols_indices', $symbols_indices);
            $this->mysmarty->assign('strategy', $strategy);
            $this->mysmarty->assign('expiry', $expiry);
            $url = $this->config->item('base_url');
            $ci_csrf_token = $this->authmodel->getCSRF();
            $leaders = $this->statistic_model->get_live_trade();
            $this_url = trim($this->input->post('this_url'));
            $config['time'] = '%D %H.%M';
            $this->load->model('authmodel');
            $data = $this->authmodel->getUserParam();
            $user_follow = $data['userId'];

            $filter_leaders = $leaders;
            $filter_leaders_by_assets = array();
            $filter_leaders_by_strategy = array();
            $filter_leaders_by_expiry = array();

            if ($assets != '') {
                foreach ($leaders as $key => $val) {
                    if ($val['asset_short'] == $assets) {
                        $filter_leaders_by_assets[] = $val;
                    }
                }
            }

            if (!empty($filter_leaders_by_assets)) {
                $filter_leaders = $filter_leaders_by_assets;
            }

            if ($strategy != '') {
                foreach ($filter_leaders as $key => $val) {
                    if ($val['b_strat'] == $strategy) {
                        $filter_leaders_by_strategy[] = $val;
                    }
                }
            }

            if (!empty($filter_leaders_by_strategy)) {
                $filter_leaders = $filter_leaders_by_strategy;
            }

            if ($expiry_post != '') {
                $expire_name = $this->gamemodel->getExpiryName($expiry_post);
                foreach ($filter_leaders as $key => $val) {
                    if ($val['asset_expire']['expiry_name'] == $expire_name) {
                        $filter_leaders_by_expiry[] = $val;
                    }
                }
            }

            if (!empty($filter_leaders_by_expiry)) {
                $filter_leaders = $filter_leaders_by_expiry;
            }

            if ($assets == '' && $strategy == '' && $expiry_post == '') {
                $filter_leaders = $leaders;
            }

            if (empty($filter_leaders)) {
                $this->mysmarty->assign('this_url', $this_url);
                $content = $this->mysmarty->fetch('not_found.tpl');
                echo $content;
                exit;
            }

            foreach ($filter_leaders as $key => $val) {
                $what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
                $asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
                $post_date = $this->newpostmodel->get_post($val['asset_expire']['post_id']);
                $filter_leaders[$key]['username'] = $this->authmodel->getUserName($val['user_id']);
                if ($this->statistic_model->is_follow($val['user_id'], $user_follow)) {
                    $filter_leaders[$key]['is_follow'] = true;
                } else {
                    $filter_leaders[$key]['is_follow'] = false;
                }


                if (!empty($post_date)) {
                    $filter_leaders[$key]['post_date'] = $post_date;
                } else {
                    $filter_leaders[$key]['post_date'] = array(array('dateline' => 'N/A'));
                }


                $filter_leaders[$key]['current_price'] = pars_asset($asset_data);

                if ($val['asset_expire']['thread_url'] != "") {

                    $url_trade = trim($val['asset_expire']['thread_url'], "-");
                    $filter_leaders[$key]['thread_id'] = $url_trade;

                    $filter_leaders[$key]['url'] = "/threads/" . $val['asset_expire']['thread_url'] . "#post" . $val['asset_expire']['post_id'];
                } else {
                    $filter_leaders[$key]['thread_id'] = trim($val['asset_expire']['thread_url'], '-');
                    $filter_leaders[$key]['url'] = "";
                }
            }

            foreach ($filter_leaders as $key => $val) {
                $filter_leaders[$key][] = array(
                    'like_count' => $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id']),
                    'followed_count' => count($this->statistic_model->get_follow_users($val['user_id'], true, false))
                );
            }

            $this->mysmarty->assign('config', $config);
            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
            $this->mysmarty->assign('topleaders', $filter_leaders);
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('user_id', $user_follow);
            $content = $this->mysmarty->fetch('open_trades.tpl');
            $this->cache->file->save('open_trades' . $cahing, $content, 3600);
        }

        echo $content;
    }

    /*     * *************For order by filed******************* */

    public function order_by_any() {
        $this->load->model('statistic_model');
        $this->load->model('gamemodel');
        $this->load->model('newpostmodel');
        $this->load->model('authmodel');
        $this->load->driver('cache');
        $cach = '';
        $assets = $this->input->post('assets');
        $select_sort = $this->input->post('select_sort_');
        if (!empty($assets)) {
            $cach .= $assets;
        }
        if (!empty($select_sort)) {
            $cach .= $select_sort;
        }
        if (!$content = $this->cache->file->get('open_trades' . $cach)) {

            $url = $this->config->item('base_url');

            $data = $this->authmodel->getUserParam();
            $user_follow = $data['userId'];
            $leaders = $this->statistic_model->get_live_trade();
            $ci_csrf_token = $this->authmodel->getCSRF();
            $this_url = trim($this->input->post('this_url'));


            $config['time'] = '%D %H.%M';
            $this->load->model('options_model');
            $data = $this->options_model->getToolsOptions();
            $symbols_currency = $data['what']['symbols_currency'];
            $symbols_metall = $data['what']['symbols_metall'];
            $symbols_company = $data['what']['symbols_company'];
            $symbols_indices = $data['what']['symbols_indices'];
            $strategy = $data['strategy'];
            $expiry = $data['expiry'];
            $this->mysmarty->assign('symbols_currency', $symbols_currency);
            $this->mysmarty->assign('symbols_metall', $symbols_metall);
            $this->mysmarty->assign('symbols_company', $symbols_company);
            $this->mysmarty->assign('symbols_indices', $symbols_indices);
            $this->mysmarty->assign('strategy', $strategy);
            $this->mysmarty->assign('expiry', $expiry);


            foreach ($leaders as $key => $val) {
                $volume[$key] = $val['b_asset'];
            }

            if ($select_sort == 'asc') {
                array_multisort($volume, SORT_ASC, $leaders); ////Continue
            }

            if ($select_sort == 'desc') {
                array_multisort($volume, SORT_DESC, $leaders); ////Continue
            }

            foreach ($leaders as $key => $val) {
                $what = $this->get_type_of_symbol($val['asset_expire']['asset_short']);
                $asset_data = $this->parse_data($what, $val['asset_expire']['asset_short']);
                $leaders[$key]['current_price'] = pars_asset($asset_data);
                $post_date = $this->newpostmodel->get_post($val['asset_expire']['post_id']);
                $leaders[$key]['username'] = $this->authmodel->getUserName($val['user_id']);
                if ($this->statistic_model->is_follow($val['user_id'], $user_follow)) {
                    $leaders[$key]['is_follow'] = true;
                } else {
                    $leaders[$key]['is_follow'] = false;
                }
                if (!empty($post_date)) {
                    $leaders[$key]['post_date'] = $post_date;
                } else {
                    $leaders[$key]['post_date'] = array(array('dateline' => 'N/A'));
                }

                if ($val['asset_expire']['thread_url'] != "") {
                    $leaders[$key]['url'] = "/threads/" . $val['asset_expire']['thread_url'] . "#post" . $val['asset_expire']['post_id'];
                    $leaders[$key]['thread_id'] = $leaders[$key]['url'];
                } else {
                    $leaders[$key]['thread_id'] = trim($val['asset_expire']['thread_url'], '-');
                    $leaders[$key]['url'] = "";
                }
            }

            //$like_count = array();
            foreach ($leaders as $key => $val) {
                $leaders[$key][] = array(
                    'like_count' => $this->statistic_model->get_likes_and_unlike_count($val['b_asset_id']),
                    'followed_count' => count($this->statistic_model->get_follow_users($val['user_id'], true, false))
                );
            }

            //$this->mysmarty->assign('like_count', $like_count);
            $this->mysmarty->assign('config', $config);
            $this->mysmarty->assign('ci_csrf_token', $ci_csrf_token);
            $this->mysmarty->assign('topleaders', $leaders);
            $this->mysmarty->assign('url', $url);
            $this->mysmarty->assign('user_id', $user_follow);

            $content = $this->mysmarty->fetch('open_trades.tpl');
            $this->cache->file->save('open_trades' . $cach, $content, 3600);
        }
        echo $content;
    }
 
    /*     * ** Nenad  ** */

    public function get_user_forum_post_data($id) {
        $this->load->model('statistic_model');
        $this->load->model('gamemodel');
        $this->load->model('newpostmodel');
		
        $user_game_count = $this->gamemodel->get_user_game($id,0,true);
		$this->mysmarty->assign('user_game_count', $user_game_count);
		
		$get_user_info_for_forum = $this->statistic_model->get_user_info_for_forum($id);
		$users_agree = $this->statistic_model->get_likes_and_unlike_count(0,true,$id);
		$users_disagree = $this->statistic_model->get_likes_and_unlike_count(0,false,$id);
		$post_count = $this->newpostmodel->get_user_post_count($id);
        $this->mysmarty->assign('post_count', $post_count);
        $this->mysmarty->assign('users_agree', $users_agree);
        $this->mysmarty->assign('users_disagree', $users_disagree);
        $this->mysmarty->assign('allinfo', $get_user_info_for_forum);
		
        $content = $this->mysmarty->fetch('user_forum_post_data.tpl');
        /*         * **Continue Tomorrow** */
        echo $content;
    }

    public function get_regulyar_post() {
        $this->load->model('authmodel');
        $this->load->model('statistic_model');
        $time_end = time();
        $time_start = time() - strtotime("-1 week");
        $latest_post = $this->statistic_model->get_regulyar_post($time_start, $time_end);
        $this->mysmarty->assign('latest_post', $latest_post);
        $content = $this->mysmarty->fetch('thread_latest_forum.tpl');
        echo $content;
    }

}
