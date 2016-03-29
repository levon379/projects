<?php

namespace common\components;

class JvzooIpn {

    const SECRET_KEY = 'hUp43xMa';

    public function verifyIpn() {
        $pop = "";
        $ipnFields = array();
        foreach ($_POST AS $key => $value) {
            if ($key == "cverify") {
                continue;
            }
            $ipnFields[] = $key;
        }
        sort($ipnFields);
        foreach ($ipnFields as $field) {
            // if Magic Quotes are enabled $_POST[$field] will need to be
            // un-escaped before being appended to $pop
            $pop = $pop . $_POST[$field] . "|";
        }
        $pop = $pop . self::SECRET_KEY;
        if ('UTF-8' != mb_detect_encoding($pop))
        {
            $pop = mb_convert_encoding($pop, "UTF-8");
        }
        $calcedVerify = sha1($pop);
        $calcedVerify = strtoupper(substr($calcedVerify,0,8));
        return $calcedVerify == (isset($_POST['cverify']) ? $_POST["cverify"] : '');
    }

}