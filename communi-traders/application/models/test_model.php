<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Statistic_model extends CI_Model {

    public function index() {
        return true;
    }

    public function getAboutData($userId) {
        $country = '';
        $occupation = '';
        $loseTradesRate = '';
        $brokerName = '';
        $demoLive = '';
        $resetCounter = '';
        $balance = '';

        $this->load->model('money_model');
        $balance = $this->money_model->getUserBalance($userId);

        $resetCounter = $this->money_model->getResetCounter($userId);

        $data = array(
            'country' => $country,
            'occupation' => $occupation,
            'loseTradesRate' => $loseTradesRate,
            'brokerName' => $brokerName,
            'demoLive' => $demoLive,
            'resetCounter' => $resetCounter,
            'balance' => $balance
        );

        return $data;
    }

    public function getStatisticData($userId) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->order_by("created_at", "desc");
        $res = $this->db->get();
        $rows = $res->result_array();

        return $rows;
    }

    public function getPerformanceData($userId) {
        $timePeriodArray = $this->getTimePeriodArray();

        $winningTrades = $this->getWinningTrades($userId, $timePeriodArray);
        $badTrades = $this->getBadTrades($userId, $timePeriodArray);

        $tradesRate = $this->getWinLoseTradesRate($winningTrades['dataCounted'], $badTrades['dataCounted']);
        $assetsRate = $this->getBestWorstAssetsRate($winningTrades['dataAllInfo'], $badTrades['dataAllInfo'], $winningTrades['dataCounted']);
//        $dataStrategy = $this->formatStrategyArray($assetsRate['procentStrategy']);
//        echo '<pre>';
//        var_dump(array_values($assetsRate['procentStrategy']['week']));
//        echo '</pre>';
//        exit();
        $data = array(
            'winningTrades' => $winningTrades['dataCounted'],
            'badTrades' => $badTrades['dataCounted'],
            'winTradesRate' => $tradesRate['winTradesRate'],
            'loseTradesRate' => $tradesRate['loseTradesRate'],
            'bestAsset' => $assetsRate['best'],
            'worstAsset' => $assetsRate['worst'],
            'bestStrategy' => $assetsRate['bestStrategy'],
            'worstStrategy' => $assetsRate['worstStrategy'],
            'procentStrategyDay' => array_values($assetsRate['procentStrategy']['day']),
            'procentStrategyWeek' => array_values($assetsRate['procentStrategy']['week']),
            'procentStrategyMonth' => array_values($assetsRate['procentStrategy']['month']),
            'procentStrategyYear' => array_values($assetsRate['procentStrategy']['year']),
            'procentStrategyAllTime' => ''
        );

        return $data;
    }

    public function getTimePeriodArray() {
        /* Day period */
        $startDay = date('Y-m-d 00:00:00', strtotime("now"));
        $endDay = date('Y-m-d 23:59:59', strtotime('tomorrow - 1 second'));
        $dayPeriod = array(
            'startDay' => $startDay,
            'endDay' => $endDay
        );

        /* Week period */
        $weekStartDay = date('Y-m-d 00:00:00', strtotime("this week"));
        $weekEndDay = date('Y-m-d 23:59:59', strtotime("this week sunday"));
        $weekPeriod = array(
            'weekStartDay' => $weekStartDay,
            'weekEndDay' => $weekEndDay
        );

        /* Month period */
        $monthStartDay = date('Y-m-1 00:00:00');
        $monthEndDay = date('Y-m-t 23:59:59');
        $monthPeriod = array(
            'monthStartDay' => $monthStartDay,
            'monthEndDay' => $monthEndDay
        );

        /* Year period */
        $yearStartDay = date('Y-1-1', strtotime("this year"));
        $yearEndDay = date('Y-12-31', strtotime("this year"));
        $yearPeriod = array(
            'yearStartDay' => $yearStartDay,
            'yearEndDay' => $yearEndDay
        );

        /* All period */
        $allTimePeriodStartDay = date('1970-1-1');
        $allTimePeriodEndDay = date('Y-12-31', strtotime("this year"));
        $allTimePeriod = array(
            'allTimePeriodStartDay' => $allTimePeriodStartDay,
            'allTimePeriodEndDay' => $allTimePeriodEndDay
        );
        
        $data = array(
            'dayPeriod' => $dayPeriod,
            'weekPeriod' => $weekPeriod,
            'monthPeriod' => $monthPeriod,
            'yearPeriod' => $yearPeriod,
            'allTimePeriod' => $allTimePeriod
        );

        return $data;
    }

    public function getWinningTrades($userId, $timePeriodArray) {

        $data = array(
            'dayResult' => '',
            'weekResult' => '',
            'monthResult' => '',
            'yearResult' => '',
            'allTimePeriod' => ''
        );

        /* Day result */
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['dayPeriod']['startDay'] . "' AND '" . $timePeriodArray['dayPeriod']['endDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $day = $result->result_array();
        $dayCount = count($day);

        /* Week result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['weekPeriod']['weekStartDay'] . "' AND '" . $timePeriodArray['weekPeriod']['weekEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $week = $result->result_array();
        $weekCount = count($week);

        /* Month result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['monthPeriod']['monthStartDay'] . "' AND '" . $timePeriodArray['monthPeriod']['monthEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $month = $result->result_array();
        $monthCount = count($month);

        /* Year result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['yearPeriod']['yearStartDay'] . "' AND '" . $timePeriodArray['yearPeriod']['yearEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $year = $result->result_array();
        $yearCount = count($year);

        /* All time result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '".$timePeriodArray['allTimePeriod']['allTimePeriodStartDay']."' AND '".$timePeriodArray['allTimePeriodEndDay']['allTimePeriodEndDayEndDay']."'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $allTimePeriod = $result->result_array();
        $allTimePeriodCount = count($allTimePeriod);

        $dataCounted = array(
            'dayResult' => $dayCount,
            'weekResult' => $weekCount,
            'monthResult' => $monthCount,
            'yearResult' => $yearCount,
            'allTimePeriod' => $allTimePeriod
        );

        $dataAllInfo = array(
            'dayResult' => $day,
            'weekResult' => $week,
            'monthResult' => $month,
            'yearResult' => $year,
            'allTimePeriod' => $allTimePeriodCount
        );

        $data = array(
            'dataCounted' => $dataCounted,
            'dataAllInfo' => $dataAllInfo
        );

        return $data;
    }

    public function getBadTrades($userId, $timePeriodArray) {
        $data = array(
            'dayResult' => '',
            'weekResult' => '',
            'monthResult' => '',
            'yearResult' => '',
            'allTimePeriod' => ''
        );

        /* Day result */
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 0);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['dayPeriod']['startDay'] . "' AND '" . $timePeriodArray['dayPeriod']['endDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $day = $result->result_array();
        $dayCount = count($day);

        /* Week result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 0);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['weekPeriod']['weekStartDay'] . "' AND '" . $timePeriodArray['weekPeriod']['weekEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $week = $result->result_array();
        $weekCount = count($week);

        /* Month result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 0);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['monthPeriod']['monthStartDay'] . "' AND '" . $timePeriodArray['monthPeriod']['monthEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $month = $result->result_array();
        $monthCount = count($month);

        /* Year result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 0);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['yearPeriod']['yearStartDay'] . "' AND '" . $timePeriodArray['yearPeriod']['yearEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $year = $result->result_array();
        $yearCount = count($year);

        /* All time result */
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
        $dateRange = "expired_at BETWEEN '".$timePeriodArray['allTimePeriod']['allTimePeriodStartDay']."' AND '".$timePeriodArray['allTimePeriod']['allTimePeriodEndDay']."'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $allTimePeriod = $result->result_array();
        $allTimePeriodCount = count($allTimePeriod);

        $dataCounted = array(
            'dayResult' => $dayCount,
            'weekResult' => $weekCount,
            'monthResult' => $monthCount,
            'yearResult' => $yearCount,
            'allTimePeriod' => $allTimePeriodCount
        );

        $dataAllInfo = array(
            'dayResult' => $day,
            'weekResult' => $week,
            'monthResult' => $month,
            'yearResult' => $year,
            'allTimePeriod' => $allTimePeriod
        );

        $data = array(
            'dataCounted' => $dataCounted,
            'dataAllInfo' => $dataAllInfo
        );
        return $data;
    }

    public function getWinLoseTradesRate($winningTrades, $badTrades) {

        $winDay = $winningTrades['dayResult'];
        $loseDay = $badTrades['dayResult'];
        $dayTradesAmount = $winDay + $loseDay;
        if ($dayTradesAmount > 0) {
            $dayWinRate = round(($winDay / $dayTradesAmount) * 100);
            $dayLoseRate = round(($loseDay / $dayTradesAmount) * 100);
        } else {
            $dayWinRate = 0;
            $dayLoseRate = 0;
        }

        $winWeek = $winningTrades['weekResult'];
        $loseWeek = $badTrades['weekResult'];
        $weekTradesAmount = $winWeek + $loseWeek;
        if ($weekTradesAmount > 0) {
            $weekhWinRate = round(($winWeek / $weekTradesAmount) * 100);
            $weekLoseRate = round(($loseWeek / $weekTradesAmount) * 100);
        } else {
            $weekhWinRate = 0;
            $weekLoseRate = 0;
        }

        $winMonth = $winningTrades['monthResult'];
        $loseMonth = $badTrades['monthResult'];
        $monthTradesAmount = $winMonth + $loseMonth;
        if ($monthTradesAmount > 0) {
            $monthWinRate = round(($winMonth / $monthTradesAmount) * 100);
            $monthLoseRate = round(($loseMonth / $monthTradesAmount) * 100);
        } else {
            $monthWinRate = 0;
            $monthLoseRate = 0;
        }

        $winYear = $winningTrades['yearResult'];
        $loseYear = $badTrades['yearResult'];
        $yearTradesAmount = $winYear + $loseYear;
        if ($yearTradesAmount > 0) {
            $yearWinRate = round(($winYear / $yearTradesAmount) * 100);
            $yearLoseRate = round(($loseYear / $yearTradesAmount) * 100);
        } else {
            $yearWinRate = 0;
            $yearLoseRate = 0;
        }


        $winAllTime = count($winningTrades['allTimePeriod']); 
        $loseAllTime = count($badTrades['allTimePeriod']); 
        $allTimeTradesAmount = $winDay + $loseDay;
        $allTimeWinRate = ($winAllTime/$allTimeTradesAmount)*100;    
        $allTimeLoseRate = ($loseAllTime/$allTimeTradesAmount)*100; 

        $winTradesRate = array(
            'day' => $dayWinRate,
            'month' => $monthWinRate,
            'week' => $weekhWinRate,
            'year' => $yearWinRate,
            'allTime' => $allTimeWinRate
        );

        $loseTradesRate = array(
            'day' => $dayLoseRate,
            'month' => $monthLoseRate,
            'week' => $weekLoseRate,
            'year' => $yearLoseRate,
            'allTime' => $allTimeLoseRate
        );

        $data = array(
            'winTradesRate' => $winTradesRate,
            'loseTradesRate' => $loseTradesRate
        );

        return $data;
    }

    public function getBestWorstAssetsRate($win, $lose, $winGames) {
        /* Get STRATEGY names array from the database.
          Use it into the  getProcentPartOfTheStrategy() function
          to calculete success procent of the trades.
         */
        $this->db->select('short_name');
        $this->db->from('game_strategy');
        $result = $this->db->get();
        $strategyNames = $result->result_array();

        $winRate = array(
            'dayRate' => '',
            'weekRate' => '',
            'monthRate' => '',
            'allTimeRate' => ''
        );

        $winStrategyRate = array(
            'dayRate' => '',
            'weekRate' => '',
            'monthRate' => '',
            'allTimeRate' => ''
        );

        /* DAY BEST ASSET */
        $dayResult = array();
        $dayBestStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['dayResult'] as $value) {
            $dayResult[$i] = $value['asset'];
            $i++;
            $dayBestStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($dayResult) > 0) {
            /* ASSET */
            $dayResult = array_count_values($dayResult);
            arsort($dayResult);
            $dayResult = array_keys(array_slice($dayResult, 0, 1));
            $dayResult = $dayResult[0];
            /* STRATEGY */
            $dayBestStrategy = array_count_values($dayBestStrategy);
            arsort($dayBestStrategy);
            $procentStrategyDay = $this->getProcentPartOfTheStrategy($dayBestStrategy, $strategyNames, $winGames['dayResult']);
            $dayBestStrategy = array_keys(array_slice($dayBestStrategy, 0, 1));
            $dayBestStrategy = $dayBestStrategy[0];
        } else {
            $procentStrategyDay = array();
            $dayResult = '';
            $dayBestStrategy = '';
        }

        /* WEEK BEST ASSET */
        $weekResult = array();
        $weekBestStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['weekResult'] as $value) {
            $weekResult[$i] = $value['asset'];
            $i++;
            $weekBestStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($weekResult) > 0) {
            /* ASSET */
            $weekResult = array_count_values($weekResult);
            arsort($weekResult);
            $weekResult = array_keys(array_slice($weekResult, 0, 1));
            $weekResult = $weekResult[0];
            /* STRATEGY */
            $weekBestStrategy = array_count_values($weekBestStrategy);
            arsort($weekBestStrategy);
            $procentStrategyWeek = $this->getProcentPartOfTheStrategy($weekBestStrategy, $strategyNames, $winGames['weekResult']);

            $weekBestStrategy = array_keys(array_slice($weekBestStrategy, 0, 1));
            $weekBestStrategy = $weekBestStrategy[0];
        } else {
            $weekResult = '';
            $weekBestStrategy = '';
            $procentStrategyWeek = array();
        }

        /* MONTH BEST ASSET */
        $monthResult = array();
        $monthBestStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['monthResult'] as $value) {
            $monthResult[$i] = $value['asset'];
            $i++;
            $monthBestStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($monthResult) > 0) {
            /* ASSET */
            $monthResult = array_count_values($monthResult);
            arsort($monthResult);
            $monthResult = array_keys(array_slice($monthResult, 0, 1));
            $monthResult = $monthResult[0];
            /* STRATEGY */
            $monthBestStrategy = array_count_values($monthBestStrategy);
            arsort($monthBestStrategy);
            $procentStrategyMonth = $this->getProcentPartOfTheStrategy($monthBestStrategy, $strategyNames, $winGames['monthResult']);

            $monthBestStrategy = array_keys(array_slice($monthBestStrategy, 0, 1));
            $monthBestStrategy = $monthBestStrategy[0];
        } else {
            $monthResult = '';
            $monthBestStrategy = '';
            $procentStrategyMonth = array();
        }

        /* YEAR BEST ASSET */
        $yearResult = array();
        $yearBestStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['yearResult'] as $value) {
            $yearResult[$i] = $value['asset'];
            $i++;
            $yearBestStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($yearResult) > 0) {
            /* ASSET */
            $yearResult = array_count_values($yearResult);
            arsort($yearResult);
            $yearResult = array_keys(array_slice($yearResult, 0, 1));
            $yearResult = $yearResult[0];
            /* STRATEGY */
            $yearBestStrategy = array_count_values($yearBestStrategy);
            arsort($yearBestStrategy);
            $procentStrategyYear = $this->getProcentPartOfTheStrategy($yearBestStrategy, $strategyNames, $winGames['yearResult']);
            $yearBestStrategy = array_keys(array_slice($yearBestStrategy, 0, 1));
            $yearBestStrategy = $yearBestStrategy[0];
        } else {
            $yearResult = '';
            $yearBestStrategy = '';
            $procentStrategyYear = array();
        }

        /* ALL TIME BEST ASSET */
        $allTimePeriod = array();
        $allTimePeriodStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['allTimePeriod'] as $value) {
            $allTimePeriodResult[$i] = $value['asset'];
            $i++;
            $allTimePeriodBestStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($allTimePeriod) > 0) {
            /* ASSET */
            $allTimePeriodResult = array_count_values($allTimePeriodResult);
            arsort($allTimePeriodResult);
            $allTimePeriodResult = array_keys(array_slice($allTimePeriodResult, 0, 1));
            $allTimePeriodResult = $allTimePeriodResult[0];
            /* STRATEGY */
            $allTimePeriodBestStrategy = array_count_values($allTimePeriodBestStrategy);
            arsort($allTimePeriodBestStrategy);
            $procentStrategyallTimePeriod = $this->getProcentPartOfTheStrategy($allTimePeriodBestStrategy, $strategyNames, $winGames['allTimePeriod']);
            $allTimePeriodBestStrategy = array_keys(array_slice($allTimePeriodBestStrategy, 0, 1));
            $allTimePeriodBestStrategy = $allTimePeriodBestStrategy[0];
        } else {
            $allTimePeriodResult = '';
            $allTimePeriodBestStrategy = '';
            $procentStrategyallTimePeriod = array();
        }

        $winRate = array(
            'dayRate' => $dayResult,
            'weekRate' => $weekResult,
            'monthRate' => $monthResult,
            'yearRate' => $yearResult,
            'allTimeRate' => $allTimePeriodResult
        );

        $winStrategyRate = array(
            'dayRate' => $dayBestStrategy,
            'weekRate' => $weekBestStrategy,
            'monthRate' => $monthBestStrategy,
            'yearRate' => $yearBestStrategy,
            'allTimeRate' => ''
        );

        $procentStrategy = array(
            'day' => $procentStrategyDay,
            'week' => $procentStrategyWeek,
            'month' => $procentStrategyMonth,
            'year' => $procentStrategyYear,
            'allTime' => $procentStrategyallTimePeriod
        );

        /* WORST RATE */

        $loseRate = array(
            'dayRate' => '',
            'weekRate' => '',
            'monthRate' => '',
            'yearRate' => '',
            'allTimeRate' => ''
        );

        $loseStrategyRate = array(
            'dayRate' => '',
            'weekRate' => '',
            'monthRate' => '',
            'yearRate' => '',
            'allTimeRate' => ''
        );

        /* DAY WORST ASSET */
        $dayResult = array();
        $dayWorstStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($lose['dayResult'] as $value) {
            $dayResult[$i] = $value['asset'];
            $i++;
            $dayWorstStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($dayResult) > 0) {
            /* ASSET */
            $dayResult = array_count_values($dayResult);
            arsort($dayResult);
            $dayResult = array_keys(array_slice($dayResult, 0, 1));
            $dayResult = $dayResult[0];
            /* STRATEGY */
            $dayWorstStrategy = array_count_values($dayWorstStrategy);
            arsort($dayWorstStrategy);
            $dayWorstStrategy = array_keys(array_slice($dayWorstStrategy, 0, 1));
            $dayWorstStrategy = $dayWorstStrategy[0];
        } else {
            $dayResult = '';
            $dayWorstStrategy = '';
        }

        /* WEEK WORST ASSET */
        $weekResult = array();
        $weekWorstStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($lose['weekResult'] as $value) {
            $weekResult[$i] = $value['asset'];
            $i++;
            $weekWorstStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($weekResult) > 0) {
            /* ASSET */
            $weekResult = array_count_values($weekResult);
            arsort($weekResult);
            $weekResult = array_keys(array_slice($weekResult, 0, 1));
            $weekResult = $weekResult[0];
            /* STRATEGY */
            $weekWorstStrategy = array_count_values($weekWorstStrategy);
            arsort($weekWorstStrategy);
            $weekWorstStrategy = array_keys(array_slice($weekWorstStrategy, 0, 1));
            $weekWorstStrategy = $weekWorstStrategy[0];
        } else {
            $weekResult = '';
            $weekWorstStrategy = '';
        }

        /* MONTH WORST ASSET */
        $monthResult = array();
        $monthWorstStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($lose['monthResult'] as $value) {
            $monthResult[$i] = $value['asset'];
            $i++;
            $monthWorstStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($monthResult) > 0) {
            /* ASSET */
            $monthResult = array_count_values($monthResult);
            arsort($monthResult);
            $monthResult = array_keys(array_slice($monthResult, 0, 1));
            $monthResult = $monthResult[0];
            /* STRATEGY */
            $monthWorstStrategy = array_count_values($monthWorstStrategy);
            arsort($monthWorstStrategy);
            $monthWorstStrategy = array_keys(array_slice($monthWorstStrategy, 0, 1));
            $monthWorstStrategy = $monthWorstStrategy[0];
        } else {
            $monthResult = '';
            $monthWorstStrategy = '';
        }

        /* YEAR WORST ASSET */
        $yearResult = array();
        $yearWorstStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($lose['yearResult'] as $value) {
            $yearResult[$i] = $value['asset'];
            $i++;
            $yearWorstStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($yearResult) > 0) {
            /* ASSET */
            $yearResult = array_count_values($yearResult);
            arsort($yearResult);
            $yearResult = array_keys(array_slice($yearResult, 0, 1));
            $yearResult = $yearResult[0];
            /* STRATEGY */
            $yearWorstStrategy = array_count_values($yearWorstStrategy);
            arsort($yearWorstStrategy);
            $yearWorstStrategy = array_keys(array_slice($yearWorstStrategy, 0, 1));
            $yearWorstStrategy = $yearWorstStrategy[0];
        } else {
            $yearResult = '';
            $yearWorstStrategy = '';
        }

        /* ALL TIME WORST ASSET */
        $allTimePeriod = '';
        $i = 0;
        foreach ($win['allTimePeriod'] as $value) {
            $allTimePeriod[$i] = $value['asset'];
            $i++;
        }
        $allTimePeriod = array_count_values($allTimePeriod);
        arsort($allTimePeriod);
        $allTimePeriod = array_keys(array_slice($allTimePeriod, 0, 1));
        $allTimePeriod = $allTimePeriods[0];

        $loseRate = array(
            'dayRate' => $dayResult,
            'weekRate' => $weekResult,
            'monthRate' => $monthResult,
            'yearRate' => $yearResult,
            'allTimeRate' => $allTimePeriod
        );

        $loseStrategyRate = array(
            'dayRate' => $dayWorstStrategy,
            'weekRate' => $weekWorstStrategy,
            'monthRate' => $monthWorstStrategy,
            'yearRate' => $yearWorstStrategy,
            'allTimeRate' => ''
        );

        $data = array(
            'best' => $winRate,
            'worst' => $loseRate,
            'bestStrategy' => $winStrategyRate,
            'worstStrategy' => $loseStrategyRate,
            'procentStrategy' => $procentStrategy
        );

        return $data;
    }

    public function getProcentPartOfTheStrategy($importData, $strategyNames, $timePeriodResult) {
        $resultArray = array();
        $i = 0;
        foreach ($strategyNames as $value) {
            $result = 0;
            foreach ($importData as $key => $valueData) {
                if ($value['short_name'] == $key) {
                    $result = round(($valueData / $timePeriodResult) * 100);
                }
            }
            $resultArray[$i][$value['short_name']] = $result;
        }
        return $resultArray;
    }

    public function formatStrategyArray($inputData) {
        $day = array();
        $i = 0;
        foreach ($inputData['week'][0] as $key => $value) {
            var_dump($key);
            exit();
        }
    }

}