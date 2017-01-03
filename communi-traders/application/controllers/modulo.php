<?php
// php5-gmp needed
function getTableName($symbol) {
        $num_tables = 26; // 26 letters in eng alphavite
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
        $mod = gmp_mod($sum, $num_tables);
        $result = "game_data_" . gmp_strval($mod);
        return $result;
    }

$symbol = 'AAP';
$tablename = getTableName($symbol);
echo $tablename;
?>