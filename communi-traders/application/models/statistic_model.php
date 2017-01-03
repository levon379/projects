<?php

ini_set("memory_limit", "128M");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Statistic_model extends CI_Model {

    public function index() {
        return true;
    }

    public function getAboutData($userId) {
        $user_info = $this->getCountryOccupation($userId);
        $country = $occupation = $broker = $demolive = $expirience = '';
        if (!empty($user_info)) {
            $country = $user_info['country'];
            $occupation = $user_info['occupation'];
            $broker = $user_info['broker'];
            $demolive = $user_info['demolive'];
            $expirience = $user_info['expirience'];
        }
        $loseTradesRate = $this->getLooseTradesRate('user', $userId);
        $winTradesRate = $this->getWinnTradesRate('user', $userId);
        $resetCounter = '';
        $balance = '';

        $this->load->model('money_model');
        $balance = $this->money_model->getUserBalance($userId);
        $resetCounter = $this->money_model->getResetCounter($userId);
        $pl = $balance['user_cache'] - 20000;
        $pl = number_format($pl, 2, ',', ' ');

        $data = array(
            'country' => $country,
            'occupation' => $occupation,
            'loseTradesRate' => $loseTradesRate,
            'winTradesRate' => $winTradesRate,
            'pl' => $pl,
            'broker' => $broker,
            'demolive' => $demolive,
            'resetCounter' => $resetCounter,
            'balance' => $balance['user_cache'],
            'expirience' => $expirience
        );

        return $data;
    }

    public function getStatisticData($userId) {
        /* Get finished trades */

        $finishedTrades = $this->getClosedGames($userId);

        /* Get current trades */
        $currentTrades = $this->getActiveGame($userId);

        $i = 0;
        foreach ($currentTrades as $value) {
            $currentTrades[$i]['time_remains'] = $this->getTimeRemained($value['expired_at'], date('Y-m-d H:i:s'));
            $i++;
        }

        $rows = array(
            'finishedTrades' => $finishedTrades,
            'currentTrades' => $currentTrades
        );
        return $rows;
    }

    public function getPerformanceData($userId) {
        $timePeriodArray = $this->getTimePeriodArray();

        $winningTrades = $this->getWinningTrades($userId, $timePeriodArray);
        $badTrades = $this->getBadTrades($userId, $timePeriodArray);

        $tradesRate = $this->getWinLoseTradesRate($winningTrades['dataCounted'], $badTrades['dataCounted']);
        $assetsRate = $this->getBestWorstAssetsRate($winningTrades['dataAllInfo'], $badTrades['dataAllInfo'], $winningTrades['dataCounted']);

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
            'procentStrategyAllTime' => array_values($assetsRate['procentStrategy']['allTime'])
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
        $yearStartDay = date('Y-1-1 00:00:00', strtotime("this year"));
        $yearEndDay = date('Y-12-31 23:59:59', strtotime("this year"));
        $yearPeriod = array(
            'yearStartDay' => $yearStartDay,
            'yearEndDay' => $yearEndDay
        );

        /* All period */
        $allTimePeriodStartDay = date('1970-1-1 00:00:00');
        $allTimePeriodEndDay = date('Y-12-31 23:59:59', strtotime("this year"));
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 1);
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
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
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('user_id', $userId);
        $this->db->where('game_result', 0);
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

        $winAllTime = $winningTrades['allTimePeriod'];
        $loseAllTime = $badTrades['allTimePeriod'];
        $allTimeTradesAmount = $winAllTime + $loseAllTime;
        if ($allTimeTradesAmount > 0) {
            $allTimeWinRate = round(($winAllTime / $allTimeTradesAmount) * 100);
            $allTimeLoseRate = round(($loseAllTime / $allTimeTradesAmount) * 100);
        } else {
            $allTimeWinRate = 0;
            $allTimeLoseRate = 0;
        }

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
        $this->db = $this->load->database('default', TRUE, TRUE);
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
        $allTimePeriodResult = array();
        $allTimePeriodBestStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($win['allTimePeriod'] as $value) {
            $allTimePeriodResult[$i] = $value['asset'];
            $i++;
            $allTimePeriodBestStrategy[$k] = $value['strategy'];
            $k++;
        }

        if (count($allTimePeriodResult) > 0) {
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
            'allTimeRate' => $allTimePeriodBestStrategy
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
        $allTimePeriodResult = array();
        $allTimePeriodWorstStrategy = array();
        $i = 0;
        $k = 0;
        foreach ($lose['allTimePeriod'] as $value) {
            $allTimePeriodResult[$i] = $value['asset'];
            $i++;
            $allTimePeriodWorstStrategy[$k] = $value['strategy'];
            $k++;
        }
        if (count($allTimePeriodResult) > 0) {
            /* ASSET */
            $allTimePeriodResult = array_count_values($allTimePeriodResult);
            arsort($allTimePeriodResult);
            $allTimePeriodResult = array_keys(array_slice($allTimePeriodResult, 0, 1));
            $allTimePeriodResult = $allTimePeriodResult[0];
            /* STRATEGY */
            $allTimePeriodWorstStrategy = array_count_values($allTimePeriodWorstStrategy);
            arsort($allTimePeriodWorstStrategy);
            $allTimePeriodWorstStrategy = array_keys(array_slice($allTimePeriodWorstStrategy, 0, 1));
            $allTimePeriodWorstStrategy = $allTimePeriodWorstStrategy[0];
        } else {
            $allTimePeriodResult = '';
            $allTimePeriodWorstStrategy = '';
        }

        $loseRate = array(
            'dayRate' => $dayResult,
            'weekRate' => $weekResult,
            'monthRate' => $monthResult,
            'yearRate' => $yearResult,
            'allTimeRate' => $allTimePeriodResult
        );

        $loseStrategyRate = array(
            'dayRate' => $dayWorstStrategy,
            'weekRate' => $weekWorstStrategy,
            'monthRate' => $monthWorstStrategy,
            'yearRate' => $yearWorstStrategy,
            'allTimeRate' => $allTimePeriodWorstStrategy
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
        foreach ($inputData['week'][0] as $key => $value) {
            var_dump($key);
            exit();
        }
    }

    public function getActiveGameThisWeek($user_id, $is_count = 0) {
        $data = $this->getActiveGame($user_id, $is_count);
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }
        return $new_data;
    }

    public function getActiveGame($user_id, $is_count = 0) {
        /* Get current trades */
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result IS NULL');
        $this->db->order_by("created_at", "desc");
        $res = $this->db->get();
        $data = $res->result_array();
        if ($is_count != 1) {
            if (count($data) > 0) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['price'] = number_format($data[$i]['price'], 4, '.', ' ');
                    $data[$i]['time_remains'] = $this->getTimeRemained($data[$i]['expired_at'], date('Y-m-d H:i:s'));
                    $status = $this->getGameStatus($data[$i]['id'], $data[$i]['asset_short']);
                    if ($status != 'unavailable') {
                        $data[$i]['status'] = $status[0]['in_money'];
                        $data[$i]['curr_price'] = number_format($status[0]['price'], 4, '.', ' ');
                    } else {
                        $data[$i]['status'] = $status;
                        $data[$i]['curr_price'] = $status;
                    }
                    if ($data[$i]['status'] == 'In') {
                        if ($this->is_start_final_equal($data[$i]['price'], $data[$i]['curr_price'], $data[$i]['strategy']) == 1) {
                            $data[$i]['pl'] = 0;
                        } else {
                            $data[$i]['pl'] = $data[$i]['investment'] * 1.85 - $data[$i]['investment'];
                        }
                    } else if ($data[$i]['status'] == 'Out') {
                        $data[$i]['pl'] = '-' . ($data[$i]['investment'] - $data[$i]['investment'] * 0.15);
                    }
                }
            }
        }
        return $data;
    }

    private function getGameStatus($game_id, $asset) {
        $status = 'unavailable';
        $this->db = $this->load->database('default', TRUE, TRUE);
        $table = $this->getTableName($asset);
        $this->db->select();
        $this->db->from($table);
        $this->db->where('game_id', $game_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $res = $this->db->get();
        $data = $res->result_array();
        //print_r($asset);die;
        if (count($data) > 0) {
            if ($data[0]['in_money'] == 1) {
                $data[0]['in_money'] = 'In';
            } else if ($data[0]['in_money'] == 0) {
                $data[0]['in_money'] = 'Out';
            }
            return $data;
        } else {
            return $status;
        }
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
        //$result = "game_data_" . gmp_strval($mod);
        $result = "game_data_" . $mod;
        return $result;
    }

    private function get_user_joined_date($user_id) {
        $user_name = '';
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('joindate');
        $this->db->from('user');
        $this->db->where('userid', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (!empty($data[0])) {
            $user_joined = $data[0]['joindate'];
        } else {
            $user_joined = 'N/A';
        }
        return $user_joined;
    }

    public function getUserName($user_id) {
        $user_name = '';
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('userid', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        $user_name = $data[0]['username'];
        return $user_name;
    }

    private function getCurrentPrice($game_id) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('price');
        $this->db->from('game_data');
        $this->db->where('game_id', $game_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            return $data[0]['price'];
        } else {
            return 'unavailable';
        }
    }

    public function getClosedGamesThisWeek($user_id, $is_count = 0) {
        $data = $this->getClosedGames($user_id, $is_count);
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }
        return $new_data;
    }

    public function getClosedGames($user_id, $is_count = 0) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('game_result IS NOT NULL');
        $this->db->order_by("created_at", "desc");
        $res = $this->db->get();
        $data = $res->result_array();
        if ($is_count != 1) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['price'] = number_format($data[$i]['price'], 4, '.', ' ');
                $table = $this->getTableName($data[$i]['asset_short']);
                $f_price = $this->get_last_price($data[$i]['id'], $data[$i]['asset_short'], $table);
                $data[$i]['f_price'] = number_format($f_price, 4, '.', ' ');
                if ($data[$i]['game_result'] == 0) {
                    $data[$i]['pl'] = $data[$i]['investment'] - $data[$i]['investment'] * 0.15;
                } else if ($data[$i]['game_result'] == 1) {
                    if ($this->is_start_final_equal($data[$i]['price'], $f_price, $data[$i]['strategy']) == 1) {
                        $data[$i]['pl'] = 0;
                    } else {
                        $data[$i]['pl'] = $data[$i]['investment'] * 1.85 - $data[$i]['investment'];
                    }
                }
            }
        }
        return $data;
    }

    private function getCountryOccupation($user_id) {
        $user_info = array();
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('userfield');
        $this->db->where('userid', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (!empty($data[0])) {
            $user_info['country'] = $data[0]['field2'];
            $user_info['occupation'] = $data[0]['field4'];
            $user_info['broker'] = $data[0]['field6'];
            $user_info['demolive'] = $data[0]['field7'];
            $user_info['expirience'] = $data[0]['field8'];
        }
        return $user_info;
    }

    public function getLooseTradesRateThisWeek($flag, $value = 0) {
        $rate = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result', 0);
        $this->db->from('game');
        $res = $this->db->get();
        $data = $res->result_array();
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }
        $count_loose = count($new_data);
        if ($count_loose != 0) {
            $count_all = $this->getCountAllTradesThisWeek($flag, $value);
            $rate = round(($count_loose / $count_all) * 100);
            if ($flag == 'user') {
                $rate = $rate . '%(' . $count_loose . ')';
            }
        }

        return $rate;
    }

    private function getLooseTradesRate($flag = 'asset', $value) {
        $rate = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $count_all = $this->db->count_all('game');
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result', 0);
        $count_loose = $this->db->count_all_results('game');
        if ($count_loose != 0) {
            $count_all = $this->getCountAllTrades($flag, $value);
            $rate = round(($count_loose / $count_all) * 100);
            if ($flag == 'user') {
                $rate = $rate . '%(' . $count_loose . ')';
            }
        }

        return $rate;
    }

    private function getTimeRemained($date_exp, $date_now) {
        $date_exp = strtotime($date_exp);
        $date_now = strtotime($date_now);
        $time_remained = '';
        $duration = $date_exp - $date_now;
        $second = $duration % 60;
        $minute = (($duration - $second) / 60) % 60;
        $hour = (($duration - $second) - ($minute * 60)) / 3600;
        if ($second >= 0) {
            if ($hour < 10) {
                $hour = '0' . $hour;
            }
            if ($minute < 10) {
                $minute = '0' . $minute;
            }
            if ($second < 10) {
                $second = '0' . $second;
            }
            $time_remained = $hour . ':' . $minute . ':' . $second;
        } else {
            $time_remained = 'EXPIRED';
        }

        return $time_remained;
    }

    public function getBalance($user_id) {
        $balance = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_cache');
        $this->db->from('user_money');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $balance = $data[0]['user_cache'];
        }
        return $balance;
    }

    public function get_users_report() {
        $users_info = array();
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_id');
        $this->db->from('user_money');
        $res = $this->db->get();
        $data = $res->result_array();
        $counter = 0;
        foreach ($data as $d) {
            $temp = $this->get_user_info($d['user_id']);
            if ($temp != 0) {
                $user_info[$counter]['username'] = $temp[0]['username'];
                $user_info[$counter]['email'] = $temp[0]['email'];
                $country_occupation = $this->getCountryOccupation($d['user_id']);
                $user_info[$counter]['country'] = $country_occupation['country'];
                $user_info[$counter]['open_games'] = count($this->getActiveGame($d['user_id'], 1));
                $user_info[$counter]['closed_games'] = count($this->getClosedGames($d['user_id'], 1));
                $user_info[$counter]['total_shares'] = $this->getCountPosted($d['user_id']);
                $user_info[$counter]['loose_rate'] = $this->getLooseTradesRate('user', $d['user_id']);
                $user_info[$counter]['winn_rate'] = $this->getWinnTradesRate('user', $d['user_id']);
                $user_info[$counter]['last_logged'] = date('Y-m-d', $temp[0]['lastvisit']);
                $user_info[$counter]['h_m_t_loged'] = $this->how_many_times_logged($d['user_id']);
                $user_info[$counter]['l_m_logged'] = $this->how_many_times_logged_month($d['user_id']);
            }
            $counter++;
        }
        return $user_info;
    }

    public function get_this_week_all_users_report() {
        $users_info = array();
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_id');
        $this->db->from('user_money');
        $res = $this->db->get();
        $data = $res->result_array();
        $counter = 0;
        foreach ($data as $d) {
            $temp = $this->get_user_info($d['user_id']);
            if ($temp != 0) {
                $user_info[$counter]['username'] = $temp[0]['username'];
                $user_info[$counter]['email'] = $temp[0]['email'];
                $country_occupation = $this->getCountryOccupation($d['user_id']);
                $user_info[$counter]['country'] = $country_occupation['country'];
                $user_info[$counter]['open_games'] = count($this->getActiveGameThisWeek($d['user_id'], 1));
                $user_info[$counter]['closed_games'] = count($this->getClosedGamesThisWeek($d['user_id'], 1));
                $user_info[$counter]['total_shares'] = $this->getCountPostedThisWeek($d['user_id']);
                $user_info[$counter]['loose_rate'] = $this->getLooseTradesRateThisWeek('user', $d['user_id']);
                $user_info[$counter]['winn_rate'] = $this->getWinnTradesRateThisWeek('user', $d['user_id']);
                $user_info[$counter]['last_logged'] = date('Y-m-d', $temp[0]['lastvisit']);
                $user_info[$counter]['h_m_t_loged'] = $this->how_many_times_logged($d['user_id']);
                $user_info[$counter]['l_m_logged'] = $this->how_many_times_logged_month($d['user_id']);
            }
            $counter++;
        }
        return $user_info;
    }

    public function get_this_week_registered_users_report() {
        $users_info = array();
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('*');
        $this->db->from('user');
        $res = $this->db->get();
        $data = $res->result_array();
        $new_user_ids = array();
        foreach ($data as $d) {
            if ($d['joindate'] > strtotime("last Sunday"))
                $new_user_ids[] = $d;
        }
        $counter = 0;
        foreach ($new_user_ids as $d) {
            $temp = $this->get_user_info($d['userid']);
            if ($temp != 0) {
                $user_info[$counter]['user_id'] = $d['userid'];
                $user_info[$counter]['username'] = $temp[0]['username'];
                $user_info[$counter]['email'] = $temp[0]['email'];
                $country_occupation = $this->getCountryOccupation($d['userid']);
                $user_info[$counter]['country'] = $country_occupation['country'];
                $user_info[$counter]['open_games'] = count($this->getActiveGame($d['userid'], 1));
                $user_info[$counter]['closed_games'] = count($this->getClosedGames($d['userid'], 1));
                $user_info[$counter]['total_shares'] = $this->getCountPosted($d['userid']);
                $user_info[$counter]['loose_rate'] = $this->getLooseTradesRate('user', $d['userid']);
                $user_info[$counter]['winn_rate'] = $this->getWinnTradesRate('user', $d['userid']);
                $user_info[$counter]['last_logged'] = date('Y-m-d', $temp[0]['lastvisit']);
                $user_info[$counter]['h_m_t_loged'] = $this->how_many_times_logged($d['userid']);
                $user_info[$counter]['l_m_logged'] = $this->how_many_times_logged_month($d['userid']);
            }
            $counter++;
        }
        return $user_info;
    }

    public function get_assets_report() {
        $assets_list = array();
        $asset_report = array();
        $counter = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('');
        $this->db->from('symbols_company');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select('');
        $this->db->from('symbols_currency');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select('');
        $this->db->from('symbols_indices');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select();
        $this->db->from('symbols_metall');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $counter = 0;
        for ($i = 0; $i < count($assets_list); $i++) {
            $asset_report[$i]['asset'] = $assets_list[$i]['full_name'];
            $asset_report[$i]['open_trades'] = $this->get_open_trades('asset', $assets_list[$i]['short_name']);
            $asset_report[$i]['closed_trades'] = $this->get_closed_trades('asset', $assets_list[$i]['short_name']);
            $asset_report[$i]['winning_rate'] = $this->getWinnTradesRate('asset', $assets_list[$i]['short_name']);
            $asset_report[$i]['loosing_rate'] = $this->getLooseTradesRate('asset', $assets_list[$i]['short_name']);
        }
        return $asset_report;
    }

    public function get_strategy_report() {
        $strategy_info = array();
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game_strategy');
        $res = $this->db->get();
        $data = $res->result_array();
        $counter = 0;
        foreach ($data as $d) {
            $strategy_info[$counter]['strategy'] = $d['full_name'];
            $strategy_info[$counter]['open_trades'] = $this->get_open_trades('strategy', $d['short_name']);
            $strategy_info[$counter]['closed_trades'] = $this->get_closed_trades('strategy', $d['short_name']);
            $strategy_info[$counter]['winning_rates'] = $this->getWinnTradesRate('strategy', $d['short_name']);
            $strategy_info[$counter]['loosing_rates'] = $this->getLooseTradesRate('strategy', $d['short_name']);
            $counter++;
        }
        return $strategy_info;
    }

    public function get_expire_report() {
        $expire_info = array();
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('expiry_name');
        $this->db->from('expiry_time');
        $res = $this->db->get();
        $data = $res->result_array();
        $counter = 0;
        foreach ($data as $d) {
            $expire_info[$counter]['expire'] = $d['expiry_name'];
            $expire_info[$counter]['open_trades'] = $this->get_open_trades('expire', $d['expiry_name']);
            $expire_info[$counter]['closed_trades'] = $this->get_closed_trades('expire', $d['expiry_name']);
            $expire_info[$counter]['winning_rates'] = $this->getWinnTradesRate('expire', $d['expiry_name']);
            $expire_info[$counter]['loosing_rates'] = $this->getLooseTradesRate('expire', $d['expiry_name']);
            $counter++;
        }
        return $expire_info;
    }

    public function get_asset_expire_report() {
        $asset_expire_info = array();
        $assets_list = array();
        $counter = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('');
        $this->db->from('symbols_company');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select('');
        $this->db->from('symbols_currency');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select('');
        $this->db->from('symbols_indices');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $this->db->select();
        $this->db->from('symbols_metall');
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $assets_list[$counter]['short_name'] = $d['short_name'];
                $assets_list[$counter]['full_name'] = $d['full_name'];
                $counter++;
            }
        }
        $counter = 0;
        for ($i = 0; $i < count($assets_list); $i++) {
            $temp = '';
            $asset_expire_info[$i]['asset'] = $assets_list[$i]['full_name'];
            // 60 seconds
            // card-19
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '60 seconds')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '60 seconds')) . '%';
            $asset_expire_info[$i]['60sec'] = $temp;
            // 15 minutes
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '15 miutes')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '15 miutes')) . '%';
            $asset_expire_info[$i]['15min'] = $temp;
            // 1 hour
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 hour')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 hour')) . '%';
            $asset_expire_info[$i]['1h'] = $temp;
            // 4 hours
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '4 hours')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '4 hours')) . '%';
            $asset_expire_info[$i]['4h'] = $temp;
            // 1 day
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 day')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 day')) . '%';
            $asset_expire_info[$i]['1d'] = $temp;
            // 3 days
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '3 days')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '3 days')) . '%';
            $asset_expire_info[$i]['3d'] = $temp;
            // 1 week
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 week')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 week')) . '%';
            $asset_expire_info[$i]['1w'] = $temp;
            // 1 month
            $temp = $this->getWinnTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 month')) . '%';
            $temp .= ' | ' . $this->getLooseTradesRate('expire_asset', array($assets_list[$i]['short_name'], '1 month')) . '%';
            $asset_expire_info[$i]['1mon'] = $temp;
        }
        return $asset_expire_info;
    }

    private function get_user_info($user_id) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('user');
        $this->db->where('userid', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            return $data;
        } else {
            return 0;
        }
    }

    public function getCountPostedThisWeek($user_id, $is_count = 0) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('*');
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_post', 1);
        $res = $this->db->get();
        $data = $res->result_array();
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }
        return count($new_data);
    }

    private function getCountPosted($user_id) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_id');
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_post', 1);
        $res = $this->db->get();
        $data = $res->result_array();
        return count($data);
    }

    public function getWinnTradesRateThisWeek($flag = "asset", $value = 0) {
        $rate = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result', 1);
        $this->db->from('game');
        $res = $this->db->get();
        $data = $res->result_array();
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }
        $count_win = count($new_data);
        if ($count_win != 0) {
            $count_all = $this->getCountAllTradesThisWeek($flag, $value);
            $rate = round(($count_win / $count_all) * 100);
            if ($flag == 'user') {
                $rate = $rate . '%(' . $count_win . ')';
            }
        }

        return $rate;
    }

    private function getWinnTradesRate($flag = 'asset', $value) {
        $rate = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result', 1);
        $count_win = $this->db->count_all_results('game');
        if ($count_win != 0) {
            $count_all = $this->getCountAllTrades($flag, $value);
            $rate = round(($count_win / $count_all) * 100);
            if ($flag == 'user') {
                $rate = $rate . '%(' . $count_win . ')';
            }
        }

        return $rate;
    }

    private function getCountWinTrades($user_id) {
        $count = 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result', 1);
        #Card 19
        $this->db->where('expiry_name !=', "60 seconds");
        $count = $this->db->count_all_results('game');
        return $count;
    }

    private function getCountAllTradesThisWeek($flag = 'asset', $value) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result IS NOT NULL');

        $res = $this->db->get();
        $data = $res->result_array();
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) > strtotime("last Sunday"))
                $new_data[] = $d;
        }

        return count($new_data);
    }

    private function getCountAllTrades($flag = 'asset', $value) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($flag == 'user') {
            $this->db->where('user_id', $value);
        }
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        }
        if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        }
        if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        if ($flag == 'expire_asset') {
            $this->db->where('asset_short', $value[0]);
            $this->db->where('expiry_name', $value[1]);
        }
        $this->db->where('game_result IS NOT NULL');
        $count_all = $this->db->count_all_results('game');

        return $count_all;
    }

    private function get_open_trades($flag = 'asset', $value) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        } else if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        } else if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        $this->db->where('game_result IS NULL');
        $count_open = $this->db->count_all_results('game');

        return $count_open;
    }

    private function get_closed_trades($flag = 'asset', $value) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        if ($flag == 'asset') {
            $this->db->where('asset_short', $value);
        } else if ($flag == 'strategy') {
            $this->db->where('strategy', $value);
        } else if ($flag == 'expire') {
            $this->db->where('expiry_name', $value);
        }
        $this->db->where('game_result IS NOT NULL');
        $count_closed = $this->db->count_all_results('game');

        return $count_closed;
    }

    public function getAlert($user_id) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select('alert');
        $this->db->from('user_money');
        $this->db->where('user_id', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        return $data[0]['alert'];
    }

    public function changeAlertStatus($user_id, $alert_status) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $data = array('alert' => $alert_status);
        $this->db->where('user_id', $user_id);
        $this->db->update('user_money', $data);
    }

    public function get_today_pl($user_id) {
        $today_pl = 0;
        $date = date('Y-m-d');
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->like('created_at', $date);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $status = $this->getGameStatus($d['id'], $d['asset_short']);
                if (!is_array($status)) {
                    continue;
                }
                if ($status[0]['in_money'] == 'In') {
                    if ($this->is_start_final_equal($d['price'], $status[0]['price'], $d['strategy']) == 1) {
                        $today_pl += 0;
                    } else {
                        $today_pl += $d['investment'] * 1.85 - $d['investment'];
                    }
                } else if ($status[0]['in_money'] == 'Out') {
                    $today_pl -= $d['investment'] - $d['investment'] * 0.15;
                }
            }
        }
        return $today_pl;
    }

    public function get_game_pl($game_id) {
        $pl = 0;
        $date = date('Y-m-d');
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('id', $game_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            foreach ($data as $d) {
                $status = $this->getGameStatus($d['id'], $d['asset_short']);
                if (!is_array($status)) {
                    continue;
                }
                if ($status[0]['in_money'] == 'In') {
                    if ($this->is_start_final_equal($d['price'], $status[0]['price'], $d['strategy']) == 1) {
                        $pl += 0;
                    } else {
                        $pl += $d['investment'] * 1.85 - $d['investment'];
                    }
                } else if ($status[0]['in_money'] == 'Out') {
                    $pl -= $d['investment'] - $d['investment'] * 0.15;
                }
            }
        }
        return $pl;
    }

    public function get_latest_trade($user_id) {
        $today_pl = 0;
        $date = date('Y-m-d');
        $this->db = $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result IS NULL');
        $this->db->order_by('id DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $status = $this->getGameStatus($data[0]['id'], $data[0]['asset_short']);
            if (!is_array($status)) {
                return;
            }
            if ($status[0]['in_money'] == 'In') {
                if ($this->is_start_final_equal($data[0]['price'], $status[0]['price'], $data[0]['strategy']) == 1) {
                    $today_pl += 0;
                } else {
                    $today_pl += $data[0]['investment'] * 1.85 - $data[0]['investment'];
                }
            } else if ($status[0]['in_money'] == 'Out') {
                $today_pl -= $data[0]['investment'] - $data[0]['investment'] * 0.15;
            }
        }
        return $today_pl;
    }

    private function get_user_data($user_id) {
        $user_data = array();
        $this->db = $this->load->database('offpista', TRUE, TRUE);


        $this->db->select('dateline');
        $this->db->from('customavatar');
        $this->db->where('userid', $user_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            $user_data['img'] = $this->config->item('forum_url') . 'image.php?u=' . $user_id . '&dateline=' . $data[0]['dateline'] . '&type=thumb';
        } else {
            $user_data['img'] = $this->config->item('base_url') . 'assets/images/no_image_icon.jpeg';
        }
        return $user_data;
    }

    public function get_leaders($period = '', $sort = '') {

        $this->load->model('gamemodel');
        $this->load->database('default', TRUE, TRUE);
        $this->load->model('money_model');
        $this->db->select('money.user_id,money.username as username,money.user_cache as cach');
        $this->db->from('user_money as money');
        $res = $this->db->get();
        $data = $res->result_array();
		
        foreach ($data as $key => $val) {
         
			/*****************************Offpisat Database**********************/
			
            $data[$key] = $this->get_user_data($val['user_id']);
			$user_info = $this->getCountryOccupation($val['user_id']);  
            //$win_rates            = $this->getWinnTradesRate('user', $data[$i]['user_id']);
			
			
			/* *********************Default table select ************************************************/
			
			$data[$key]['username'] = $val['username'];
			$data[$key]['user_id'] = $val['user_id'];
            $balance = $val['cach'];  
           
			$latestTrade = $this->get_today_pl($val['user_id']); 
			$best_asset = $this->get_best_asset($val['user_id'], 'YES'); 
            //$userData= $this->getAboutData($data[$i]['user_id']);
			$win_trades = $this->getCountWinTrades($val['user_id']); 
            $total_trades = $this->getCountAllUserTrades($val['user_id']); 
			$data[$key]['b_strat'] = $this->get_best_strategy($val['user_id']); 
			
            $pl =  $balance - 20000;
            $pl = number_format($pl, 2, ',', ' ');
			
           
            
            (!$total_trades) ? $win_rates = 100 : $win_rates = round($win_trades / $total_trades * 100);
           
            $data[$key]['w_trades'] = $win_trades;
            $data[$key]['total_trades'] = $total_trades;
            

            if (!empty($best_asset)) {
              //  $data[$key]['asset_info'] = $this->gamemodel->get_game_data($best_asset['best_game_id']);
                $data[$key]['asset_expire'] = $this->gamemodel->get_game_info($best_asset['best_game_id']);
                $data[$key]['b_asset'] = $best_asset['best_asset'];
                $data[$key]['b_asset_id'] = $best_asset['best_game_id'];
                $data[$key]['status'] = $this->getGameStatus($best_asset['best_game_id'], $data[$key]['asset_expire']['asset_short']);
            }
            $data[$key]['w_rates'] = $win_rates;
            $data[$key]['joined_date'] = $this->get_user_joined_date($val['user_id']);
            if (isset($user_info['country'])) {
                $data[$key]['country'] = $user_info['country'];
            } else {
                $data[$key]['country'] = '';
            }
            $data[$key]['total_pl'] = $pl;
            $data[$key]['profit_loss_rate'] = $this->getProfitLossRate($val['user_id']);
            $data[$key]['latest_trade'] = $latestTrade;
        }

        foreach ($data as $key => $row) {
            $volume[$key] = $row['w_trades'];
        }

        array_multisort($volume, SORT_DESC, $data);
        return array_slice($data, 0, 15);
    }

    public function get_live_trade() {
        $this->load->model('gamemodel');
        //$this->load->model('money_model');
        $this->load->database('default', TRUE, TRUE);
        $this->db->select('*');
        $this->db->from('game');
        $start_time = time() - 24*60 * 60 * 1000;

        $this->db->limit(15);
        $this->db->order_by("created_at", "ASC");
		$this->db->group_by('user_id');
        $res = $this->db->get();
        $data = $res->result_array();
        
        $new_data = array();
        foreach ($data as $d) {
            if (strtotime($d['created_at']) >= $start_time && strtotime($d['created_at']) < time())
                $new_data[] = $d;
        }

        $count = count($new_data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $temp = $this->get_user_data($new_data[$i]['user_id']);

                $latestTrade = $this->get_today_pl($new_data[$i]['user_id']);

                $best_asset = $this->get_best_asset($new_data[$i]['user_id'], 'YES');
                if (empty($best_asset)) {
                    $best_asset = array(
                        'best_asset' => $new_data[$i]['asset'],
                        'best_game_id' => $new_data[$i]['id']
                    );
                }

                $win_trades = $this->getCountWinTrades($new_data[$i]['user_id']);
                $total_trades = $this->getCountAllUserTrades($new_data[$i]['user_id']);

                (!$total_trades) ? $win_rates = 100 : $win_rates = round($win_trades / $total_trades * 100);
                $new_data[$i]['img'] = $temp['img'];
                $new_data[$i]['w_trades'] = $win_trades;
                $new_data[$i]['total_trades'] = $total_trades;
                $b_strat = $this->get_best_strategy($new_data[$i]['user_id']);

                if (empty($b_strat)) {
                    $new_data[$i]['b_strat'] = $new_data[$i]['strategy'];
                } else {
                    $new_data[$i]['b_strat'] = $b_strat;
                }


                if (!empty($best_asset)) {
                    $new_data[$i]['asset_info'] = $this->gamemodel->get_game_data($best_asset['best_game_id']);
                    $new_data[$i]['asset_expire'] = $this->gamemodel->get_game_info($best_asset['best_game_id']);
                    $new_data[$i]['b_asset'] = $best_asset['best_asset'];
                    $new_data[$i]['b_asset_id'] = $best_asset['best_game_id'];
                    $status = $this->getGameStatus($best_asset['best_game_id'], $new_data[$i]['asset_expire']['asset_short']);
                    if (!empty($status)) {
                        $new_data[$i]['status'] = $status;
                    } else {
                        $new_data[$i]['status'] = '';
                    }
                }
                $new_data[$i]['w_rates'] = $win_rates;
                $new_data[$i]['joined_date'] = $this->get_user_joined_date($new_data[$i]['user_id']);
                //$data[$i]['country']  = $userData['country'];
                //$data[$i]['total_pl']  = $userData['pl'];
                $new_data[$i]['profit_loss_rate'] = $this->getProfitLossRate($new_data[$i]['user_id']);
                $new_data[$i]['latest_trade'] = $latestTrade;
                $new_data[$i]['nesa'] = 'test';
            }
        }
        foreach ($new_data as $key => $row) {
            $volume[$key] = $row['w_trades'];
        }

        array_multisort($volume, SORT_DESC, $new_data);
        return $new_data;
    }

    private function getProfitLossRate($user_id) {
        $this->load->database('default', TRUE, TRUE);
        $this->db->select('SUM(investment) AS amount');
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result', 1);
        $this->db->where('expiry_name !=', "60 seconds");
        $profit = $this->db->get()->row_array();
        $profit = $profit['amount'];
        $this->db->select('SUM(investment) AS amount');
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result', 0);
        $this->db->where('expiry_name !=', "60 seconds");
        $loss = $this->db->get()->row_array();
        $loss = $loss['amount'];
        if ($loss == 0) {
            $rate = 100;
        } else {
            $rate = round(($profit / $loss) * 100);
        }
        return $rate;
    }

    private function getCountAllUserTrades($user_id) {
        $this->load->database('default', TRUE, TRUE);
        $this->db->select('COUNT(id) AS count');
        $this->db->from('game');
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result IS NOT NULL');
        $this->db->where('expiry_name !=', "60 seconds");
        $res = $this->db->get();
        $data = $res->row_array();
        return $data['count'];
    }

    private function get_best_strategy($user_id) {
        $best_strategy = '';
        $strategies = array();
        $this->load->database('default', TRUE, TRUE);
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('user_id', $user_id);
        #Card 19
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('game_result', 1);
        $res = $this->db->get();
        $data = $res->result_array();

        for ($i = 0; $i < count($data); $i++) {
            $strategies[$data[$i]['strategy']] = 0;
        }

        foreach ($data as $d) {
            $strategies[$d['strategy']] += 1;
        }
        arsort($strategies);
        foreach ($strategies as $key => $value) {
            $best_strategy = $key;
            break;
        }
        return $best_strategy;
    }

    private function get_best_asset($user_id, $game_id = '') {
        $best_asset = '';
        $assets = array();
        $best_game_id = array();
        $this->load->database('default', TRUE, TRUE);
        if ($game_id == 'YES') {
            $this->db->select('asset,id');
        } else {
            $this->db->select('asset');
        }
        $this->db->from('game');
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('user_id', $user_id);
        $this->db->where('game_result', 1);
        #Card 19
        $this->db->where('expiry_name !=', "60 seconds");
        $res = $this->db->get();
        $data = $res->result_array();

        for ($i = 0; $i < count($data); $i++) {
            $assets[$data[$i]['asset']] = 0;
        }

        foreach ($data as $d) {
            if (isset($d['id'])) {
                $best_game_id[$d['asset']] = $d['id'];
            }
            $assets[$d['asset']] += 1;
        }
        arsort($assets);

        foreach ($assets as $key => $value) {
            $best_asset = $key;
            break;
        }

        if ($game_id == 'YES' && isset($best_game_id[$best_asset])) {
            $data_post = array('best_asset' => $best_asset, 'best_game_id' => $best_game_id[$best_asset]);
            return $data_post;
        } else {
            return $best_asset;
        }
    }

    private function get_last_price($game_id, $symbol, $table) {

//	$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));
//	if ( ! $data = $this->cache->get('foo'))
//	{
        $this->load->database('default', TRUE, TRUE);
        $this->db->cache_on();
        $this->db->select('price');
        $this->db->from($table);
        $this->db->where('game_id', $game_id);
        $this->db->where('symbol', $symbol);
        $this->db->order_by('id DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        $this->db->cache_off();
        $data = $res->result_array();
//  }
        return $data[0]['price'];
    }

    private function how_many_times_logged($user_id) {
        $count = 0;
        $this->load->database('default', TRUE, TRUE);
        $this->db->from('login_log');
        $this->db->where('user_id', $user_id);
        $count = $this->db->count_all_results();
        return $count;
    }

    private function how_many_times_logged_month($user_id) {
        $count = 0;
        $date = date('Y-m');
        $this->db->from('login_log');
        $this->db->where('user_id', $user_id);
        $this->db->like('last_login', $date);
        $count = $this->db->count_all_results();
        return $count;
    }

    private function is_start_final_equal($s_price, $f_price, $strategy) {
        $result = 0;
        if ($s_price == $f_price) {
            if ($strategy == 'call' || $strategy == 'put') {
                $result = 1;
            }
        }
        return $result;
    }

    public function getCountPostedThisWeekByAllUsers($date_from = NULL) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $date_from = isset($date_from) ? $date_from : date('Y-m-d 23:59:59', strtotime("last Wednesday"));
        $count = $this->db->from('game')->where('is_post', 1)->where('created_at >', $date_from)->count_all_results();
        return $count;
    }

    public function getCountTradesThisWeekByAllUsers($date_from = NULL) {
        $this->db = $this->load->database('default', TRUE, TRUE);
        $date_from = isset($date_from) ? $date_from : date('Y-m-d 23:59:59', strtotime("last Wednesday"));
        $count = $this->db->from('game')->where('created_at >', $date_from)->count_all_results();
        return $count;
    }

    public function getCountTradesThisWeekByUsers($user_ids, $date_from = NULL) {
        if (empty($user_ids))
            return 0;
        $this->db = $this->load->database('default', TRUE, TRUE);
        $date_from = isset($date_from) ? $date_from : date('Y-m-d 23:59:59', strtotime("last Wednesday"));
        $count = $this->db->from('game')->where_in('user_id', $user_ids)->where('created_at >', $date_from)->count_all_results();
        return $count;
    }

    public function get_user_info_for_forum($userId) {

        $data['winTradesRate'] = $this->getWinnTradesRate('user', $userId);
        $data['LooseTradeRate'] = $this->getLooseTradesRate('user', $userId);
        $data['best_asset'] = $this->get_best_asset($userId);
        $data['PerformanceData'] = $this->getPerformanceData($userId);
        $data['best_strategy'] = $this->get_best_strategy($userId);
        $data['CountWinTrades'] = $this->getCountWinTrades($userId);

        return $data;
    }

    public function get_user_all_strategy($user_id) {
        $best_strategy = '';

        $this->load->database('default', TRUE, TRUE);
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('user_id', $user_id);
        $this->db->where('expiry_name !=', "60 seconds");
        $this->db->where('game_result', 1);
        $res = $this->db->get();
        $data = $res->result_array();
        $count = count($data);
        $count_call = 0;
        foreach ($data as $key => $val) {

            if ($val['strategy'])
                $count_call++;
        }


        return $data;
    }

    private function get_strategy_for_timperiod($type, $timePeriodArray, $userId) {

        $this->load->database('default', TRUE, TRUE);
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('strategy', $type);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['dayPeriod']['startDay'] . "' AND '" . $timePeriodArray['dayPeriod']['endDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $day = $result->result_array();
        $dayCount = count($day);

        /* Week result */
        $this->db->select();
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('strategy', $type);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['weekPeriod']['weekStartDay'] . "' AND '" . $timePeriodArray['weekPeriod']['weekEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $week = $result->result_array();
        $weekCount = count($week);

        /* Month result */
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('strategy', $type);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['monthPeriod']['monthStartDay'] . "' AND '" . $timePeriodArray['monthPeriod']['monthEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $month = $result->result_array();
        $monthCount = count($month);

        /* Year result */
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('strategy', $type);
        $dateRange = "expired_at BETWEEN '" . $timePeriodArray['yearPeriod']['yearStartDay'] . "' AND '" . $timePeriodArray['yearPeriod']['yearEndDay'] . "'";
        $this->db->where($dateRange);
        $result = $this->db->get();
        $year = $result->result_array();
        $yearCount = count($year);

        /* All time result */
        $this->db->select('strategy');
        $this->db->from('game');
        $this->db->where('user_id', $userId);
        $this->db->where('strategy', $type);
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

    public function success_rate_of_strategy($id) {

        $timePeriodArray = $this->getTimePeriodArray();
        $strategy_call = $this->get_strategy_for_timperiod('call', $timePeriodArray, $id);
        $strategy_put = $this->get_strategy_for_timperiod('put', $timePeriodArray, $id);
        $strategy_touch = $this->get_strategy_for_timperiod('touch', $timePeriodArray, $id);
        $strategy_no_touch = $this->get_strategy_for_timperiod('no_touch', $timePeriodArray, $id);
        $strategy_boundary_inside = $this->get_strategy_for_timperiod('boundary_inside', $timePeriodArray, $id);
        $strategy_boundary_out = $this->get_strategy_for_timperiod('boundary_out', $timePeriodArray, $id);

        /*         * *****Day Strategy count in procent***** */
        $data_count_day = $strategy_call['dataCounted']['dayResult'] +
                $strategy_put['dataCounted']['dayResult'] +
                $strategy_touch['dataCounted']['dayResult'] +
                $strategy_no_touch['dataCounted']['dayResult'] +
                $strategy_boundary_inside['dataCounted']['dayResult'] +
                $strategy_boundary_out['dataCounted']['dayResult'];
        if ($data_count_day != 0) {
            $call_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
            $put_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
            $touch_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
            $no_touch_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
            $boundary_inside_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
            $boundary_out_count_procent_day = ($strategy_call['dataCounted']['dayResult'] / $data_count_day) / 100;
        } else {
            $call_count_procent_day = 0;
            $put_count_procent_day = 0;
            $touch_count_procent_day = 0;
            $no_touch_count_procent_day = 0;
            $boundary_inside_count_procent_day = 0;
            $boundary_out_count_procent_day = 0;
        }

        $day = array(
            'day_call' => round($call_count_procent_day, 4) . '%',
            'day_put' => round($put_count_procent_day, 4) . '%',
            'day_touch' => round($touch_count_procent_day, 4) . '%',
            'day_no_touch' => round($no_touch_count_procent_day, 4) . '%',
            'day_boundary_inside' => round($boundary_inside_count_procent_day, 4) . '%',
            'day_boundary_out' => round($boundary_out_count_procent_day, 4) . '%'
        );

        /*         * *****Week Strategy count in procent***** */

        $data_count_week = $strategy_call['dataCounted']['weekResult'] +
                $strategy_put['dataCounted']['weekResult'] +
                $strategy_touch['dataCounted']['weekResult'] +
                $strategy_no_touch['dataCounted']['weekResult'] +
                $strategy_boundary_inside['dataCounted']['weekResult'] +
                $strategy_boundary_out['dataCounted']['weekResult'];

        if ($data_count_week != 0) {
            $call_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
            $put_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
            $touch_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
            $no_touch_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
            $boundary_inside_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
            $boundary_out_count_procent_week = ($strategy_call['dataCounted']['weekResult'] / $data_count_week) / 100;
        } else {
            $call_count_procent_week = 0;
            $put_count_procent_week = 0;
            $touch_count_procent_week = 0;
            $no_touch_count_procent_week = 0;
            $boundary_inside_count_procent_week = 0;
            $boundary_out_count_procent_week = 0;
        }

        $week = array(
            'week_call' => round($call_count_procent_week, 4) . '%',
            'week_put' => round($put_count_procent_week, 4) . '%',
            'week_touch' => round($touch_count_procent_week, 4) . '%',
            'week_no_touch' => round($no_touch_count_procent_week, 4) . '%',
            'week_boundary_inside' => round($boundary_inside_count_procent_week, 4) . '%',
            'week_boundary_out' => round($boundary_out_count_procent_week, 4) . '%'
        );

        /*         * *****Month Strategy count in procent***** */

        $data_count_month = $strategy_call['dataCounted']['monthResult'] +
                $strategy_put['dataCounted']['monthResult'] +
                $strategy_touch['dataCounted']['monthResult'] +
                $strategy_no_touch['dataCounted']['monthResult'] +
                $strategy_boundary_inside['dataCounted']['monthResult'] +
                $strategy_boundary_out['dataCounted']['monthResult'];

        if ($data_count_month != 0) {
            $call_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
            $put_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
            $touch_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
            $no_touch_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
            $boundary_inside_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
            $boundary_out_count_procent_month = ($strategy_call['dataCounted']['monthResult'] / $data_count_month) / 100;
        } else {
            $call_count_procent_month = 0;
            $put_count_procent_month = 0;
            $touch_count_procent_month = 0;
            $no_touch_count_procent_month = 0;
            $boundary_inside_count_procent_month = 0;
            $boundary_out_count_procent_month = 0;
        }
        $month = array(
            'month_call' => round($call_count_procent_month, 4) . '%',
            'month_put' => round($put_count_procent_month, 4) . '%',
            'month_touch' => round($touch_count_procent_month, 4) . '%',
            'month_no_touch' => round($no_touch_count_procent_month, 4) . '%',
            'month_boundary_inside' => round($boundary_inside_count_procent_month, 4) . '%',
            'month_boundary_out' => round($boundary_out_count_procent_month, 4) . '%'
        );

        /*         * *****Year Strategy count in procent***** */

        $data_count_year = $strategy_call['dataCounted']['yearResult'] +
                $strategy_put['dataCounted']['yearResult'] +
                $strategy_touch['dataCounted']['yearResult'] +
                $strategy_no_touch['dataCounted']['yearResult'] +
                $strategy_boundary_inside['dataCounted']['yearResult'] +
                $strategy_boundary_out['dataCounted']['yearResult'];

        if ($data_count_year != 0) {
            $call_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
            $put_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
            $touch_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
            $no_touch_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
            $boundary_inside_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
            $boundary_out_count_procent_year = ($strategy_call['dataCounted']['yearResult'] / $data_count_year) / 100;
        } else {
            $call_count_procent_year = 0;
            $put_count_procent_year = 0;
            $touch_count_procent_year = 0;
            $no_touch_count_procent_year = 0;
            $boundary_inside_count_procent_year = 0;
            $boundary_out_count_procent_year = 0;
        }

        $year = array(
            'year_call' => round($call_count_procent_year, 4) . '%',
            'year_put' => round($put_count_procent_year, 4) . '%',
            'year_touch' => round($touch_count_procent_year, 4) . '%',
            'year_no_touch' => round($no_touch_count_procent_year, 4) . '%',
            'year_boundary_inside' => round($boundary_inside_count_procent_year, 4) . '%',
            'year_boundary_out' => round($boundary_out_count_procent_year, 4) . '%'
        );

        /*         * *****All Time Period Strategy count in procent***** */

        $data_count_all = $strategy_call['dataCounted']['allTimePeriod'] +
                $strategy_put['dataCounted']['allTimePeriod'] +
                $strategy_touch['dataCounted']['allTimePeriod'] +
                $strategy_no_touch['dataCounted']['allTimePeriod'] +
                $strategy_boundary_inside['dataCounted']['allTimePeriod'] +
                $strategy_boundary_out['dataCounted']['allTimePeriod'];


        if ($data_count_all != 0) {
            $call_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
            $put_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
            $touch_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
            $no_touch_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
            $boundary_inside_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
            $boundary_out_count_procent_all_time = ($strategy_call['dataCounted']['allTimePeriod'] / $data_count_all) / 100;
        } else {
            $call_count_procent_all_time = 0;
            $put_count_procent_all_time = 0;
            $touch_count_procent_all_time = 0;
            $no_touch_count_procent_all_time = 0;
            $boundary_inside_count_procent_all_time = 0;
            $boundary_out_count_procent_all_time = 0;
        }

        $all_time = array(
            'alltime_call' => round($call_count_procent_all_time, 4) . '%',
            'alltime_put' => round($put_count_procent_all_time, 4) . '%',
            'alltime_touch' => round($touch_count_procent_all_time, 4) . '%',
            'alltime_no_touch' => round($no_touch_count_procent_all_time, 4) . '%',
            'alltime_boundary_inside' => round($boundary_inside_count_procent_all_time, 4) . '%',
            'alltime_boundary_out' => round($boundary_out_count_procent_all_time, 4) . '%'
        );


        $data_strategy = array(
            'day' => $day,
            'week' => $week,
            'month' => $month,
            'year' => $year,
            'all_time' => $all_time
        );

        return $data_strategy;
    }

    public function user_follow($store_data) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $insert = $this->db->insert('dbtech_follow_follow', $store_data);
        return $insert;
    }

    public function user_unfollow($store_data) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->where('followeeid', $store_data['followeeid']);
        $this->db->where('followerid', $store_data['followerid']);
        $delete = $this->db->delete('dbtech_follow_follow', $store_data);
        return $delete;
    }

    public function is_follow($followeeid, $followerid) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('dbtech_follow_follow');
        $this->db->where('followeeid', $followeeid);
        $this->db->where('followerid', $followerid);
        //	$this->db->where('looked !=', 2);
        $arry = $this->db->get();
        $data = $arry->result_array();
        if (count($data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*     * ****************** Function for get followers and following users ************************************************* */

    public function get_follow_users($user_id, $looked = false, $following = true, $now_time = false) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('follow.*,user.*');
        $this->db->from('dbtech_follow_follow as follow');
        if (!$following) { //Get Followers user
            $this->db->where('follow.followeeid', $user_id);
            $this->db->join('user', 'follow.followerid = user.userid');
        } else {

            $this->db->where('follow.followerid', $user_id);
            $this->db->join('user', 'follow.followeeid = user.userid');
        }

        if ($looked) { //For CT page,..if logged user don't see followers user yet
            $this->db->where('follow.looked', 0);
        }

        if ($now_time) { //For ajax call between two time
            $start = $now_time - 6000;
            $dateRange = "follow.dateline  BETWEEN '" . $start . "' AND '" . $now_time . "'";
            $this->db->where($dateRange);
        }
        $this->db->order_by('follow.dateline', 'desc');
        $arry = $this->db->get();
        $data = $arry->result_array();
        $users_info = array();
        if ($following) {
            foreach ($data as $key => $val) {
                $users_info[$val['followeeid']]['followusername'] = $this->getUserName($val['followeeid']);
                $users_info[$val['followeeid']][] = $val;
                $users_info[$val['followeeid']]['img'] = $this->get_user_data($val['followeeid']);
            }
        } else {

            foreach ($data as $key => $val) {
                $users_info[$val['followerid']]['followusername'] = $this->getUserName($val['followerid']);
                $users_info[$val['followerid']][] = $val;
                $users_info[$val['followerid']]['img'] = $this->get_user_data($val['followerid']);
            }
        }
        return $users_info;
    }

    /* public function get_following_users($user_id,$now_time)
      {
      $this->db = $this->load->database('offpista', TRUE, TRUE);
      $this->db->select('follow.*,user.*');
      $this->db->from('dbtech_follow_follow as follow');
      $this->db->where('follow.followeeid', $user_id);
      $this->db->join('user', 'follow.followerid = user.userid');
      $this->db->where('follow.looked', 0);


      $this->db->order_by('follow.dateline','desc');
      $arry = $this->db->get();
      $data = $arry->result_array();
      $users_info = array();
      foreach($data as $key=>$val){
      $users_info[] = $val;
      $users_info[]['followusername'] = $this->getUserName($val['followeeid']);

      $users_info[]['img'] = $this->get_user_data($val['followeeid']);
      }

      return $users_info;
      } */

    public function user_follow_count($user_id) {
        $this->db = $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('dbtech_follow_follow as follow');
        $this->db->where('follow.followeeid', $user_id);
        $this->db->where('follow.looked', 0);
        $count = $this->db->count_all_results();
        return $count;
    }

    public function send_notification($data) {
        $this->load->database('default', TRUE, TRUE);
        $insert = $this->db->insert('user_game_likes', $data);
        return $insert;
    }

    public function get_likes_and_unlike_count($game_id = 0,$like_or_unlike = true,$user_id = false) {
        $this->load->database('default', TRUE, TRUE);
		if($like_or_unlike){
			$this->db->select('likes_user_id');
		}else{
			$this->db->select('unlikes_user_id');
			$this->db->where('unlikes_user_id IS NOT NULL');
		}
		if($user_id)
		{
			$this->db->where('likes_user_id',$user_id);
		}
		if($game_id > 0)
		{
			$this->db->where('game_id', $game_id);
		}
        $this->db->from('user_game_likes');
        
        $count = $this->db->count_all_results();
        return $count;
    }

    public function chek_like_and_unlike($like_user_id, $game_id,$like_and_unlike = true) {
        $this->load->database('default', TRUE, TRUE);
        $this->db->select();
        $this->db->from('user_game_likes');
		if($like_and_unlike){
			$this->db->where('likes_user_id', $like_user_id);
		}else{
		
			$this->db->where('unlikes_user_id', $like_user_id);
		}
        $this->db->where('game_id', $game_id);
        $res = $this->db->get();
        $data = $res->result_array();
        if (count($data) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function chek_notification($user_id, $looked = 0) {
        $this->load->database('default', TRUE, TRUE);
        $this->db->select('user_game_likes.*,user_money.username as name');
        $this->db->from('user_game_likes');
        $this->db->where('user_game_likes.user_id', $user_id);
        $this->db->where('user_game_likes.looked', $looked);
        $this->db->join('user_money', 'user_money.user_id = user_game_likes.likes_user_id');
        $res = $this->db->get();
        $data = $res->result_array();
        $users_info = array();
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                $users_info[$key] = $this->get_user_data($val['likes_user_id']);
                $users_info[$key]['info'] = $val;
            }
        }
        return $users_info;
    }

    public function looked_like($game_id, $user_id, $likes_user_id) {
        $data = array('looked' => 1);
        $this->load->database('default', TRUE, TRUE);
        $this->db->where('game_id', $game_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('likes_user_id', $likes_user_id);
        $this->db->update('user_game_likes', $data);
    }

    public function looked_follow($followerid, $followeeid) {
        $data = array('looked' => 1);
        $this->load->database('offpista', TRUE, TRUE);
        $this->db->where('followerid', $followerid);
        $this->db->where('followeeid', $followeeid);
        $this->db->update('dbtech_follow_follow', $data);
    }

    public function get_post_notification($user_id) {
        $this->load->database('offpista', TRUE, TRUE);
        $this->db->select();
        $this->db->from('pm');
        $this->db->join('pmtext', 'pm.pmtextid=pmtext.pmtextid');
        $this->db->where('pm.userid', $user_id);
        $this->db->where('pm.messageread', 0);
        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    public function get_follow_users_trade($user_id) {
        $this->load->database('default', TRUE, TRUE);
        $follow_users = $this->get_follow_users($user_id, true);

        $this->load->model('gamemodel');
        $game_expire = array();
        foreach ($follow_users as $key => $val) {
            $game_expire[] = $this->gamemodel->get_game_expire($val[0]['followeeid']);
        }
        return $game_expire;
    }

    public function get_follow_user_active_game($user_id) {
        $this->load->database('default', TRUE, TRUE);
        $this->load->model('gamemodel');
        $follow_users = $this->get_follow_users($user_id);
        $currentTrades = array();
        foreach ($follow_users as $key => $val) {

            $data_active_game = $this->statistic_model->getActiveGame($val[0]['followeeid']);
            if (!empty($data_active_game)) {
                $user_info = $val;
                $not_expire_game = array();
                foreach ($data_active_game as $key_game => $val_game) {
                    if (!$this->gamemodel->is_game_expire($val_game['id'])) {
                        $not_expire_game[] = $val_game;
                    }
                }
                $currentTrades[] = array(
                    'user_info' => $user_info,
                    'active_game' => $not_expire_game
                );
            }
        }


        return $currentTrades;
    }

    /*     * ******POST THREAD ID******************** */

    public function get_post_thread_id($user_id) {
        $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('postid,threadid');
        $this->db->from('post');
        $this->db->where('post.userid', $user_id);

        $res = $this->db->get();
        $data = $res->result_array();
        return $data;
    }

    public function get_post_comment_notification($user_id, $parentid, $thread_id, $looked = NULL, $time = NULL) {
        $this->load->database('offpista', TRUE, TRUE);
        $this->db->select('post.*,user.*,thread.*');
        $this->db->from('post');
        $this->db->join('user', 'post.userid = user.userid');
        $this->db->join('thread', 'thread.threadid = post.threadid');
        $this->db->where('post.userid !=', $user_id);
        $this->db->where('post.threadid', $thread_id);
        $this->db->where('post.parentid', $parentid);
        if (is_numeric($looked) && is_numeric($time)) {
            $this->db->where('post.looked', $looked);
            $this->db->where('post.dateline', $time);
        }
        $res = $this->db->get();
        $data = $res->result_array();
        foreach ($data as $key => $val) {
            $data[$key]['img'] = $this->get_user_data($val['userid']);
        }
        return $data;
    }

    /* public function get_regulyar_post($timePeriodArrayStart,$timePeriodArrayEnd)
      {
      $this->load->database('offpista', TRUE, TRUE);
      $this->db->select('thread.*,user.*');
      $this->db->from('subscribethread AS subscribethread');
      $this->db->join('thread','thread.threadid = subscribethread.threadid','left');
      $this->db->join('user','user.userid = subscribethread.userid');
      //$dateRange = "thread.dateline BETWEEN '" . $timePeriodArrayStart . "' AND '" . $timePeriodArrayEnd . "'";
      // $this->db->where($dateRange);

      //$this->db->join('customavatar','customavatar.userid = thread.postuserid','left');
      $this->db->order_by("thread.lastpost", "ASC");
      $this->db->limit(2);
      $res  = $this->db->get();
      $data = $res->result_array();
      foreach($data  as $key=>$val)
      {
      $data[$key]['img'] = $this->get_user_data($val['postuserid']);
      }
      return $data;


      } */
}
