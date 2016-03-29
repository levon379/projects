<?php

namespace backend\components;

class Common {

    public static function seconds_to_human($secs)
    {
        $units = array(
            "week"   => 7*24*3600,
            "day"    =>   24*3600,
            "hour"   =>      3600,
            "minute" =>        60
        );

        // specifically handle zero
        if ( $secs == 0 ) return "0 seconds";

        $s = "";

        foreach ( $units as $name => $divisor ) {
            if ( $quot = intval($secs / $divisor) ) {
                $s .= "$quot $name";
                $s .= (abs($quot) > 1 ? "s" : "") . ", ";
                $secs -= $quot * $divisor;
            }
        }

        return substr($s, 0, -2);
    }

    public static function generatePassword()
    {
        $alpha = "abcdefghijklmnopqrstuvwxyz";
        $alpha_upper = strtoupper($alpha);
        $numeric = "0123456789";
        $special = ".-+=_,!@$#*%<>[]{}";
        $chars = "";

        if (isset($_POST['length'])){
            // if you want a form like above
            if (isset($_POST['alpha']) && $_POST['alpha'] == 'on')
                $chars .= $alpha;

            if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on')
                $chars .= $alpha_upper;

            if (isset($_POST['numeric']) && $_POST['numeric'] == 'on')
                $chars .= $numeric;

            if (isset($_POST['special']) && $_POST['special'] == 'on')
                $chars .= $special;

            $length = $_POST['length'];
        }else{
            // default [a-zA-Z0-9]{9}
            $chars = $alpha . $alpha_upper . $numeric;
            $length = 9;
        }

        $len = strlen($chars);
        $pw = '';

        for ($i=0;$i<$length;$i++)
            $pw .= substr($chars, rand(0, $len-1), 1);

// the finished password
        $pw = str_shuffle($pw);
        return $pw;
    }

    public static function human_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));

        // is this a number?
        if(!is_numeric($n)) return false;

        // now filter it;
        if($n>1000000000000) return round(($n/1000000000000),0).'T';
        else if($n>1000000000) return round(($n/1000000000),0).'B';
        else if($n>1000000) return round(($n/1000000),0).'M';
        else if($n>1000) return round(($n/1000),0).'K';

        return number_format($n);
    }

    public static function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    public static function base64_decode($input) {
        $keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        $chr1 = $chr2 = $chr3 = "";
        $enc1 = $enc2 = $enc3 = $enc4 = "";
        $i = 0;
        $output = "";

        // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
        $input = preg_replace("[^A-Za-z0-9\+\/\=]", "", $input);

        do {
            $enc1 = strpos($keyStr, substr($input, $i++, 1));
            $enc2 = strpos($keyStr, substr($input, $i++, 1));
            $enc3 = strpos($keyStr, substr($input, $i++, 1));
            $enc4 = strpos($keyStr, substr($input, $i++, 1));
            $chr1 = ($enc1 << 2) | ($enc2 >> 4);
            $chr2 = (($enc2 & 15) << 4) | ($enc3 >> 2);
            $chr3 = (($enc3 & 3) << 6) | $enc4;
            $output = $output . chr((int) $chr1);
            if ($enc3 != 64) {
                $output = $output . chr((int) $chr2);
            }
            if ($enc4 != 64) {
                $output = $output . chr((int) $chr3);
            }
            $chr1 = $chr2 = $chr3 = "";
            $enc1 = $enc2 = $enc3 = $enc4 = "";
        } while ($i < strlen($input));
        return urldecode($output);
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

    public static function sort_array_of_objects_by_key($array_of_objects, $field, $direction = 'asc')
    {
        if(!is_array($array_of_objects))
        {
            $array_of_objects = [];
        }
        usort($array_of_objects, function($a, $b) {
            if($a->talking_about_count >= $b->talking_about_count)
            {
                return -1;
            }
            if($a->talking_about_count <= $b->talking_about_count)
            {
                return 1;
            }
            return 0;
        });
        return $array_of_objects;
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

    public function facebook($user_id = '')
    {
        if(!$this->facebook[$user_id])
        {
            //cache it! TODO
            if($user_id != '' && $setting = cConnectionFacebook::find()->where(['user_id' => $user_id])->one())
            {
                $params = array(
                    'appId' => $setting->facebook_app_id,
                    'secret' => $setting->facebook_app_secret
                );
            }
            else
            {
                $params = array(
                    'appId' => Yii::app()->params['facebook']['app_id'],
                    'secret' => Yii::app()->params['facebook']['app_secret']
                );
            }
            $this->facebook[$user_id] = new NateFacebook(new \Facebook($params));
            return $this->facebook[$user_id];
            return false;
        }
        else
        {
            return $this->facebook[$user_id];
        }
    }

	static function removeDir($path) {
		if(is_file($path)){
			return unlink($path);
		}
		
		// Normalise $path.
		$path = rtrim($path, '/') . '/';
		// Remove all child files and directories.
		$items = glob($path . '*');
		foreach($items as $item) {
			is_dir($item) ? self::removeDir($item) : unlink($item);
		}
		// Remove directory.
		return rmdir($path);
	}
}