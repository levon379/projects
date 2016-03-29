<?php

class Common extends Component {

    public static function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    public static function current_page_full_url()
    {
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
        $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    }

    public static function array_key_multi_sort ($array, $index, $order='asc', $natsort=FALSE, $case_sensitive=FALSE) {
        if(is_array($array) && count($array)>0) {
            foreach(array_keys($array) as $key)
                $temp[$key]=$array[$key][$index];
            if(!$natsort)
                ($order=='asc')? asort($temp) : arsort($temp);
            else
            {
                ($case_sensitive)? natsort($temp) : natcasesort($temp);
                if($order!='asc')
                    $temp=array_reverse($temp,TRUE);
            }
            foreach(array_keys($temp) as $key)
                (is_numeric($key))? $sorted[]=$array[$key] : $sorted[$key]=$array[$key];
            return $sorted;
        }
        return $array;
    }

    public static function print_p($arr)
    {
        print("<pre>");
        print_r($arr);
        print("</pre>");
    }

    public static function substr_ellipse($str, $length)
    {
        if(strlen($str) > $length)
        {
            return substr($str, 0, $length) . '...';
        }
        return $str;
    }

}