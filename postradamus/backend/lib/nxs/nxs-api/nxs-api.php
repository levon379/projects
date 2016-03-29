<?php
if (!defined('NXSAPIVER')) define('NXSAPIVER', '2.15.69');

if (file_exists(dirname(__FILE__) . '/nxs-http.php')) include_once dirname(__FILE__) . '/nxs-http.php';
//## Code - General Functions
if (!function_exists("CutFromTo")) {
    function CutFromTo($string, $from, $to)
    {
        $fstart = stripos($string, $from);
        $tmp = substr($string, $fstart + strlen($from));
        $flen = stripos($tmp, $to);
        return substr($tmp, 0, $flen);
    }
}
if (!function_exists("getUqID")) {
    function getUqID()
    {
        return mt_rand(0, 9999999);
    }
}
if (!function_exists("build_http_query")) {
    function build_http_query($query)
    {
        $query_array = array();
        foreach ($query as $key => $key_value) {
            $query_array[] = $key . '=' . urlencode($key_value);
        }
        return implode('&', $query_array);
    }
}
if (!function_exists("rndString")) {
    function rndString($lngth)
    {
        $str = '';
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $lngth; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }
}
if (!function_exists("prcGSON")) {
    function prcGSON($gson)
    {
        $json = substr($gson, 5);
        $json = str_replace(',{', ',{"', $json);
        $json = str_replace(':[', '":[', $json);
        $json = str_replace(',{""', ',{"', $json);
        $json = str_replace('"":[', '":[', $json);
        $json = str_replace('[,', '["",', $json);
        $json = str_replace(',,', ',"",', $json);
        $json = str_replace(',,', ',"",', $json);
        return $json;
    }
}
if (!function_exists("nxsCheckSSLCurl")) {
    function nxsCheckSSLCurl($url)
    {
        $ch = curl_init($url);
        $headers = array();
        $headers[] = 'Accept: text/html, application/xhtml+xml, */*';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Accept-Language: en-us';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)");
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        if ($err != 0) return array('errNo' => $err, 'errMsg' => $errmsg); else return false;
    }
}
if (!function_exists("cookArrToStr")) {
    function cookArrToStr($cArr)
    {
        $cs = '';
        if (!is_array($cArr)) return '';
        foreach ($cArr as $cName => $cVal) {
            $cs .= $cName . '=' . $cVal . '; ';
        }
        return $cs;
    }
}
if (!function_exists("getCurlPageMC")) {
    function getCurlPageMC($ch, $ref = '', $ctOnly = false, $fields = '', $dbg = false, $advSettings = '')
    {
        $ccURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        if ($dbg) echo '<br/><b style="font-size:16px;color:green;">#### START CURL:' . $ccURL . '</b><br/>';
        static $curl_loops = 0;
        static $curl_max_loops = 20;
        global $nxs_gCookiesArr, $nxs_gCookiesArrBD;
        $cookies = cookArrToStr($nxs_gCookiesArr);
        if ($dbg) {
            echo '<br/><b style="color:#005800;">## Request Cookies:</b><br/>';
            prr($cookies);
        }
        if ($curl_loops++ >= $curl_max_loops) {
            $curl_loops = 0;
            return false;
        }
        $headers = array();
        $headers[] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Cache-Control: no-cache';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Accept-Language: en-US,en;q=0.8';// $headers[] = 'Accept-Encoding: gzip, deflate';   

        if (isset($advSettings['Content-Type'])) $headers[] = 'Content-Type: ' . $advSettings['Content-Type']; else
            if ($fields != '') {
                if ((stripos($ccURL, 'www.blogger.com/blogger_rpc') !== false)) $headers[] = 'Content-Type: application/javascript; charset=UTF-8'; else $headers[] = 'Content-Type: application/x-www-form-urlencoded;charset=utf-8';
            }
        if (stripos($ccURL, 'www.blogger.com/blogger_rpc') !== false) {
            $headers[] = 'X-GWT-Permutation: 0408F3763409DF91729BBA5B25869425';
            $headers[] = 'X-GWT-Module-Base: https://www.blogger.com/static/v1/gwt/';
        }
        if (isset($advSettings['liXMLHttpRequest'])) $headers[] = 'X-Requested-With: XMLHttpRequest';
        if (isset($advSettings['Origin'])) $headers[] = 'Origin: ' . $advSettings['Origin'];
        if (stripos($ccURL, 'blogger.com') !== false && (isset($advSettings['cdomain']) && $advSettings['cdomain'] == 'google.com')) $advSettings['cdomain'] = 'blogger.com';
        if (isset($advSettings['noSSLSec'])) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        if (isset($advSettings['proxy']) && $advSettings['proxy']['host'] != '' && $advSettings['proxy']['port'] !== '') {
            if ($dbg) {
                echo '<br/><b style="color:#005800;">## Using Proxy:</b><br/>'; /*prr($advSettings); */
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXY, $advSettings['proxy']['host']);
            curl_setopt($ch, CURLOPT_PROXYPORT, $advSettings['proxy']['port']);
            if (isset($advSettings['proxy']['up']) && $advSettings['proxy']['up'] != '') {
                curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $advSettings['proxy']['up']);
            }
        }
        if (isset($advSettings['headers'])) {
            $headers = array_merge($headers, $advSettings['headers']);
        }  // prr($advSettings);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // prr($headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if (is_string($ref) && $ref != '') curl_setopt($ch, CURLOPT_REFERER, $ref);
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, ((isset($advSettings['UA']) && $advSettings['UA'] != '') ? $advSettings['UA'] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36"));
        if ($fields != '') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        } else {
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '');
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        $content = curl_exec($ch); //prr($content);  
        $errmsg = curl_error($ch);
        if (isset($errmsg) && stripos($errmsg, 'SSL') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $content = curl_exec($ch);
        }
        if (strpos($content, "\n\n") != false && strpos($content, "\n\n") < 100) $content = substr_replace($content, "\n", strpos($content, "\n\n"), strlen("\n\n"));
        if (strpos($content, "\r\n\r\n") != false && strpos($content, "\r\n\r\n") < 100) $content = substr_replace($content, "\r\n", strpos($content, "\r\n\r\n"), strlen("\r\n\r\n"));
        $ndel = strpos($content, "\n\n");
        $rndel = strpos($content, "\r\n\r\n");
        if ($ndel == false) $ndel = 1000000;
        if ($rndel == false) $rndel = 1000000;
        $rrDel = $rndel < $ndel ? "\r\n\r\n" : "\n\n";
        @list($header, $content) = explode($rrDel, $content, 2);
        if ($ctOnly !== true) {
            $nsheader = curl_getinfo($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $nsheader['errno'] = $err;
            $nsheader['errmsg'] = $errmsg;
            $nsheader['headers'] = $header;
            $nsheader['content'] = $content;
        }
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = curl_getinfo($ch);
        if ($dbg) {
            echo '<br/><b style="color:#005800;">## Headers:</b><br/>';
            prr($headers);
            prr($header);
        }
        if (empty($headers['request_header'])) $headers['request_header'] = 'Host: None' . "\n";
        $results = array();
        preg_match_all('|Host: (.*)\n|U', $headers['request_header'], $results);
        $ckDomain = str_replace('.', '_', $results[1][0]);
        $ckDomain = str_replace("\r", "", $ckDomain);
        $ckDomain = str_replace("\n", "", $ckDomain);
        if ($dbg) {
            echo '<br/><b style="color:#005800;">## Domain:</b><br/>';
            prr($ckDomain);
        }

        $results = array();
        $cookies = '';
        preg_match_all('|Set-Cookie: (.*);|U', $header, $results);
        $carTmp = $results[1]; //$nxs_gCookiesArr = array_merge($nxs_gCookiesArr, $ret['cookies']); 
        preg_match_all('/Set-Cookie: (.*)\b/', $header, $xck);
        $xck = $xck[1];
        if ($dbg) {
            echo "Full Resp Cookies";
            prr($xck);
            echo "Plain Resp Cookies";
            prr($carTmp);
        }
        //$clCook = array();
        if (isset($advSettings['cdomain']) && $advSettings['cdomain'] != '') {
            foreach ($carTmp as $iii => $cTmp) if (stripos($xck[$iii], 'Domain=') === false || stripos($xck[$iii], 'Domain=.' . $advSettings['cdomain'] . ';') !== false) {
                $ttt = explode('=', $cTmp, 2);
                $nxs_gCookiesArr[$ttt[0]] = $ttt[1];
            }
        } else {
            foreach ($carTmp as $cTmp) {
                $ttt = explode('=', $cTmp, 2);
                $nxs_gCookiesArr[$ttt[0]] = $ttt[1];
            }
        }
        foreach ($carTmp as $cTmp) {
            $ttt = explode('=', $cTmp, 2);
            $nxs_gCookiesArrBD[$ckDomain][$ttt[0]] = $ttt[1];
        }
        if ($dbg) {
            echo '<br/><b style="color:#005800;">## Common/Response Cookies:</b><br/>';
            prr($nxs_gCookiesArr);
            echo "\r\n\r\n<br/>" . $ckDomain . "\r\n\r\n";
            prr($nxs_gCookiesArrBD);
        }
        if ($dbg && $http_code == 200) {
            $contentH = htmlentities($content);
            prr($contentH);
        }
        $rURL = '';

        if ($http_code == 200 && stripos($content, 'http-equiv="refresh" content="0; url=&#39;') !== false) {
            $http_code = 301;
            $rURL = CutFromTo($content, 'http-equiv="refresh" content="0; url=&#39;', '&#39;"');
            if (stripos($rURL, 'blogger.com') === false) $nxs_gCookiesArr = array();
        } elseif ($http_code == 200 && stripos($content, 'location.replace') !== false) {
            $http_code = 301;
            $rURL = CutFromTo($content, 'location.replace("', '"');
        }// echo "~~~~~~~~~~~~~~~~~~~~~~".$rURL."|".$http_code;
        if ($http_code == 301 || $http_code == 302 || $http_code == 303) {
            if ($rURL != '') {
                $rURL = str_replace('\x3d', '=', $rURL);
                $rURL = str_replace('\x26', '&', $rURL);
                $url = @parse_url($rURL);
            } else {
                $matches = array();
                preg_match('/Location:(.*?)\n/', $header, $matches);
                $url = @parse_url(trim(array_pop($matches)));
            }
            $rURL = ''; //echo "#######"; prr($url);
            if (!$url) {
                $curl_loops = 0;
                return ($ctOnly === true) ? $content : $nsheader;
            }
            $last_urlX = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $last_url = @parse_url($last_urlX);
            if (!isset($url['scheme'])) $url['scheme'] = $last_url['scheme'];
            if (!isset($url['host'])) $url['host'] = $last_url['host'];
            if (!empty($url['path'])) $url['path'] = $last_url['path'];
            if (!isset($url['query'])) $url['query'] = '';
            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query'] ? '?' . $url['query'] : '');
            curl_setopt($ch, CURLOPT_URL, $new_url);
            if ($dbg) echo '<br/><b style="color:#005800;">Redirecting to:</b>' . $new_url . "<br/>";
            return getCurlPageMC($ch, $last_urlX, $ctOnly, '', $dbg, $advSettings);
        } else {
            $curl_loops = 0;
            return ($ctOnly === true) ? $content : $nsheader;
        }
    }
}
if (!function_exists("getCurlPageX")) {
    function getCurlPageX($url, $ref = '', $ctOnly = false, $fields = '', $dbg = false, $advSettings = '')
    {
        if ($dbg) echo '<br/><b style="font-size:16px;color:green;">#### GSTART URL:' . $url . '</b><br/>';
        $ch = curl_init($url);
        $contents = getCurlPageMC($ch, $ref, $ctOnly, $fields, $dbg, $advSettings);
        curl_close($ch);
        return $contents;
    }
}
if (!function_exists("nxs_clFN")) {
    function nxs_clFN($fn)
    {
        $sch = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
        return trim(preg_replace('/[\s-]+/', '-', str_replace($sch, '', $fn)), '.-_');
    }
}
if (!function_exists("nxs_mkImgNm")) {
    function nxs_mkImgNm($fn, $cType)
    {
        $iex = array(".png", ".jpg", ".gif", ".jpeg");
        $map = array('image/gif' => '.gif', 'image/jpeg' => '.jpg', 'image/png' => '.png');
        $fn = str_replace($iex, '', $fn);
        if (isset($map[$cType])) {
            return $fn . $map[$cType];
        } else return $fn . ".jpg";
    }
}
//## Compatibility Functions
if (!function_exists('nxs_remote_get') && !function_exists('wp_remote_get')) die('No nxs_remote_get function');
if (!function_exists('wp_remote_request')) {
    function wp_remote_request($url, $args = array())
    {
        return nxs_remote_request($url, $args);
    }
}
if (!function_exists('wp_remote_get')) {
    function wp_remote_get($url, $args = array())
    {
        return nxs_remote_get($url, $args);
    }
}
if (!function_exists('wp_remote_post')) {
    function wp_remote_post($url, $args = array())
    {
        return nxs_remote_post($url, $args);
    }
}
if (!function_exists('wp_remote_head')) {
    function wp_remote_head($url, $args = array())
    {
        return nxs_remote_head($url, $args);
    }
}
if (!function_exists('is_wp_error')) {
    function is_wp_error($thing)
    {
        return is_nxs_error($thing);
    }
}
if (!function_exists('wp_parse_args')) {
    function wp_parse_args($args, $defaults = '')
    {
        return nxs_parse_args($args, $defaults);
    }
}

if (!function_exists('nxs_remote_request')) {
    function nxs_remote_request($url, $args = array())
    {
        return wp_remote_request($url, $args);
    }
}
if (!function_exists('nxs_remote_get')) {
    function nxs_remote_get($url, $args = array())
    {
        return wp_remote_get($url, $args);
    }
}
if (!function_exists('nxs_remote_post')) {
    function nxs_remote_post($url, $args = array())
    {
        return wp_remote_post($url, $args);
    }
}
if (!function_exists('nxs_remote_head')) {
    function nxs_remote_head($url, $args = array())
    {
        return wp_remote_head($url, $args);
    }
}
if (!function_exists('is_nxs_error')) {
    function is_nxs_error($thing)
    {
        return is_wp_error($thing);
    }
}
if (!function_exists('nxs_parse_args')) {
    function nxs_parse_args($args, $defaults = '')
    {
        return wp_parse_args($args, $defaults);
    }
}

//## Google
// Back Version 1.x Compatibility
if (!function_exists("doConnectToGooglePlus")) {
    function doConnectToGooglePlus($connectID, $email, $pass)
    {
        return doConnectToGooglePlus2($email, $pass);
    }
}
if (!function_exists("doGetGoogleUrlInfo")) {
    function doGetGoogleUrlInfo($connectID, $url)
    {
        return doGetGoogleUrlInfo2($url);
    }
}
if (!function_exists("doPostToGooglePlus")) {
    function doPostToGooglePlus($connectID, $msg, $lnk = '', $pageID = '')
    {
        return doPostToGooglePlus2($msg, $lnk, $pageID);
    }
}
// Back Version 2.x Compatibility
if (!function_exists("doConnectToGooglePlus2")) {
    function doConnectToGooglePlus2($email, $pass, $srv = 'GP', $iidb = 0)
    {
        global $nxs_plurl, $nxs_gCookiesArr, $plgn_NS_SNAutoPoster;
        if (isset($plgn_NS_SNAutoPoster)) {
            $options = $plgn_NS_SNAutoPoster->nxs_options;
            if (isset($options['gp'][$iidb]['ck'])) $ck = maybe_unserialize($options['gp'][$iidb]['ck']);
        } else $ck = array();
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($ck)) $nt->ck = $ck;
        $loginErr = $nt->connect($email, $pass, $srv);
        $nxs_gCookiesArr = $nt->ck;
        if (isset($plgn_NS_SNAutoPoster) && !empty($options)) {
            if (!$loginErr) {
                $options['gp'][$iidb]['ck'] = $nt->ck;
                if (is_array($options)) {
                    update_option('NS_SNAutoPoster', $options);
                    $plgn_NS_SNAutoPoster->nxs_options = $options;
                }
            }
        }
        return $loginErr;
    }
}
if (!function_exists("doGetGoogleUrlInfo2")) {
    function doGetGoogleUrlInfo2($url)
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) $nt->ck = $nxs_gCookiesArr;
        return $nt->urlInfo($url);
    }
}
if (!function_exists("doGetCCatsFromGooglePlus")) {
    function doGetCCatsFromGooglePlus($commPageID)
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) $nt->ck = $nxs_gCookiesArr;
        return $nt->getCCatsGP($commPageID);
    }
}
if (!function_exists("doPostToGooglePlus2")) {
    function doPostToGooglePlus2($msg, $lnk = '', $pageID = '', $commPageID = '', $commPageCatID = '')
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) $nt->ck = $nxs_gCookiesArr;
        $ret = $nt->postGP($msg, $lnk, $pageID, $commPageID, $commPageCatID);
        if (is_array($ret) && !empty($ret['isPosted'])) return array("code" => "OK", "post_id" => $ret['postID'], "post_url" => $ret['postURL']); else return $ret;
    }
}

if (!function_exists("doConnectToBlogger")) {
    function doConnectToBlogger($email, $pass)
    {
        return doConnectToGooglePlus2($email, $pass, 'BG');
    }
}
if (!function_exists("doPostToBlogger")) {
    function doPostToBlogger($blogID, $title, $msg, $tags = '')
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) $nt->ck = $nxs_gCookiesArr;
        $ret = $nt->postBG($blogID, $title, $msg, $tags);
        if (is_array($ret) && !empty($ret['isPosted'])) return array("code" => "OK", "post_id" => $ret['postID'], "post_url" => $ret['postURL']); else return $ret;
    }
}
if (!function_exists("doPostToYouTube")) {
    function doPostToYouTube($msg, $ytUrl, $vURL = '', $ytGPPageID = '')
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_GP();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) $nt->ck = $nxs_gCookiesArr;
        $ret = $nt->postYT($msg, $ytUrl, $vURL, $ytGPPageID);
        if (is_array($ret) && !empty($ret['isPosted'])) return array("code" => "OK", "post_id" => $ret['postID'], "post_url" => $ret['postURL']); else return $ret;
    }
}
//================================GOOGLE===========================================
if (!class_exists('nxsAPI_GP')) {
    class nxsAPI_GP
    {
        var $ck = array();
        var $debug = false;

        function headers($ref, $org = '', $type = 'GET', $aj = false)
        {
            $hdrsArr = array();
            $hdrsArr['Cache-Control'] = 'max-age=0';
            $hdrsArr['Connection'] = 'keep-alive';
            $hdrsArr['Referer'] = $ref;
            $hdrsArr['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.22 Safari/537.36';
            if ($type == 'JSON') $hdrsArr['Content-Type'] = 'application/json;charset=UTF-8'; elseif ($type == 'POST') $hdrsArr['Content-Type'] = 'application/x-www-form-urlencoded';
            elseif ($type == 'JS') $hdrsArr['Content-Type'] = 'application/javascript; charset=UTF-8';
            elseif ($type == 'PUT') $hdrsArr['Content-Type'] = 'application/octet-stream';
            if ($aj === true) $hdrsArr['X-Requested-With'] = 'XMLHttpRequest';
            if ($org != '') $hdrsArr['Origin'] = $org;
            if ($type == 'GET') $hdrsArr['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'; else $hdrsArr['Accept'] = '*/*';
            if (function_exists('gzdeflate')) $hdrsArr['Accept-Encoding'] = 'deflate,sdch';
            $hdrsArr['Accept-Language'] = 'en-US,en;q=0.8';
            return $hdrsArr;
        }

        function check()
        {
            $ck = $this->ck;
            if (!empty($ck) && is_array($ck)) {
            }
            return false;
        }

        function connect($u, $p, $srv = 'GP')
        {
            $sslverify = true;
            if ($this->debug) echo "[" . $srv . "] L to: " . $srv . "<br/>\r\n";
            $err = nxsCheckSSLCurl('https://www.google.com');
            if ($err !== false && $err['errNo'] == '60') $sslverify = false;
            if ($srv == 'GP') $lpURL = 'https://accounts.google.com/ServiceLogin?service=oz&continue=https://plus.google.com/?gpsrc%3Dogpy0%26tab%3DwX%26gpcaz%3Dc7578f19&hl=en-US';
            if ($srv == 'YT') $lpURL = 'https://accounts.google.com/ServiceLogin?service=oz&checkedDomains=youtube&checkConnection=youtube%3A271%3A1%2Cyoutube%3A69%3A1&continue=https://www.youtube.com/&hl=en-US';
            if ($srv == 'BG') $lpURL = 'https://accounts.google.com/ServiceLogin?service=blogger&passive=1209600&continue=https://www.blogger.com/home&followup=https://www.blogger.com/home&ltmpl=start';
            $hdrsArr = $this->headers('https://accounts.google.com/');
            $rep = nxs_remote_get($lpURL, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'sslverify' => $sslverify));
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR X =";
                return $badOut;
            }
            $ck = $rep['cookies'];
            $contents = $rep['body']; //if ($this->debug) prr($contents); 
            //## GET HIDDEN FIELDS
            $md = array();
            $flds = array();
            while (stripos($contents, '<input') !== false) {
                $inpField = trim(CutFromTo($contents, '<input', '>'));
                $name = trim(CutFromTo($inpField, 'name="', '"'));
                if (stripos($inpField, '"hidden"') !== false && $name != '' && !in_array($name, $md)) {
                    $md[] = $name;
                    $val = trim(CutFromTo($inpField, 'value="', '"'));
                    $flds[$name] = $val;
                }
                $contents = substr($contents, stripos($contents, '<input') + 8);
            }
            $flds['Email'] = $u;
            $flds['Passwd'] = $p;
            $flds['signIn'] = 'Sign%20in';
            $flds['PersistentCookie'] = 'yes';
            $flds['rmShown'] = '1';
            $flds['pstMsg'] = '1'; // $flds['bgresponse'] = $bg;
            //if ($srv == 'GP' || $srv == 'BG') $advSettings['cdomain']='google.com';
            //## ACTUAL LOGIN    
            $hdrsArr = $this->headers($lpURL, 'https://accounts.google.com', 'POST');
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds, 'sslverify' => $sslverify);// prr($advSet);
            $rep = nxs_remote_post('https://accounts.google.com/ServiceLoginAuth', $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR 3=";
                return $badOut;
            }
            $ck = $rep['cookies']; //prr($rep);
            $unlockCaptchaMsg = "Your Google+ account is locked for the new applications to connect. Please follow this instructions to unlock it: <a href='http://www.nextscripts.com/support-faq/#q21' target='_blank'>http://www.nextscripts.com/support-faq/#q21</a> - Question #2.1.";
            if ($rep['response']['code'] == '200' && !empty($rep['body'])) {
                $rep['body'] = str_ireplace('\'CREATE_CHANNEL_DIALOG_TITLE_IDV_CHALLENGE\': "Verify your identity"', "", $rep['body']);
                if (stripos($rep['body'], 'class="error-msg"') !== false) return strip_tags(CutFromTo(CutFromTo($rep['body'], 'class="error-msg"', '/span>'), '>', '<'));
                if (stripos($rep['body'], 'class="captcha-box"') !== false || stripos($rep['body'], 'is that really you') !== false || stripos($rep['body'], 'Verify your identity') !== false) return $unlockCaptchaMsg;
            }
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location']) && stripos($rep['headers']['location'], 'ServiceLoginAuth') !== false) return 'Incorrect Username/Password ';
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location']) && stripos($rep['headers']['location'], 'LoginVerification') !== false) return $unlockCaptchaMsg;
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location']) && (stripos($rep['headers']['location'], '/SmsAuth') !== false || stripos($rep['headers']['location'], '/SecondFactor') !== false)) return '<b style="color:#800000;">2-step verification is on.</b> <br/><br/> 2-step verification is not compatible with auto-posting. <br/><br/>Please see more here:<br/> <a href="http://www.nextscripts.com/blog/google-2-step-verification-and-auto-posting" target="_blank">Google+, 2-step verification and auto-posting</a><br/>';
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location'])) {
                if ($srv == 'BG') $rep['headers']['location'] = 'https://accounts.google.com/CheckCookie?checkedDomains=youtube&checkConnection=youtube%3A170%3A1&pstMsg=1&chtml=LoginDoneHtml&service=blogger&continue=https%3A%2F%2Fwww.blogger.com%2Fhome&gidl=CAA';
                if ($srv == 'YT') $rep['headers']['location'] = 'https://accounts.google.com/CheckCookie?hl=en-US&checkedDomains=youtube&checkConnection=youtube%3A271%3A1%2Cyoutube%3A69%3A1&pstMsg=1&chtml=LoginDoneHtml&service=oz&continue=https%3A%2F%2Fwww.youtube.com%2F&gidl=CAA';
                if ($srv == 'GP') $rep['headers']['location'] = 'https://accounts.google.com/CheckCookie?hl=en-US&checkedDomains=youtube&checkConnection=youtube%3A179%3A1&pstMsg=1&chtml=LoginDoneHtml&service=oz&continue=https%3A%2F%2Fplus.google.com%2F%3Fgpsrc%3Dogpy0%26tab%3DwX%26gpcaz%3Dc7578f19&gidl=CAA';
                if ($this->debug) echo "[" . $srv . "] R to: " . $rep['headers']['location'] . "<br/>\r\n";
                $hdrsArr = $this->headers($lpURL, 'https://accounts.google.com');
                $repLoc = $rep['headers']['location'];
                $rep = nxs_remote_get($repLoc, array('headers' => $hdrsArr, 'redirection' => 0, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                if (!is_nxs_error($rep) && $srv == 'YT' && $rep['response']['code'] == '302' && !empty($rep['headers']['location'])) {
                    $repLoc = $rep['headers']['location'];
                    $rep = nxs_remote_get($repLoc, array('headers' => $hdrsArr, 'redirection' => 0, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                    $ck = $rep['cookies'];
                }
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR 4=";
                    return $badOut;
                }
                $contents = $rep['body'];
                $rep['body'] = '';
                //## BG Auth redirect          
                if ($srv != 'GP' && stripos($contents, 'meta http-equiv="refresh"') !== false) {
                    $rURL = htmlspecialchars_decode(CutFromTo($contents, ';url=', '"'));
                    if ($this->debug) echo "[" . $srv . "] R to: " . $rURL . "<br/>\r\n";
                    $hdrsArr = $this->headers($repLoc);// prr($hdrsArr);
                    $rep = nxs_remote_get($rURL, array('headers' => $hdrsArr, 'redirection' => 0, 'httpversion' => '1.1', 'sslverify' => $sslverify));//  prr($rep);
                    if (is_nxs_error($rep)) {
                        $badOut = print_r($rep, true) . " - ERROR 5=";
                        return $badOut;
                    }
                    $ck = $rep['cookies'];
                    if (!empty($rep['headers']['location'])) {
                        $rURL = $rep['headers']['location'];
                        $rep = nxs_remote_get($rURL, array('headers' => $hdrsArr, 'redirection' => 0, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                        if (is_nxs_error($rep)) {
                            $badOut = print_r($rep, true) . " - ERROR 6=";
                            return $badOut;
                        }
                        if (!empty($rep['headers']['location'])) {
                            $rURL = $rep['headers']['location'];
                            $rep = nxs_remote_get($rURL, array('headers' => $hdrsArr, 'redirection' => 0, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                            if (is_nxs_error($rep)) {
                                $badOut = print_r($rep, true) . " - ERROR 7=";
                                return $badOut;
                            }
                        }
                        if (!empty($rep['headers']['location'])) $ck = $rep['cookies']; else $rep['cookies'] = $ck;
                    }
                    $ck = $rep['cookies'];
                }
                $this->ck = $ck;
                return false;
            }
            return 'Unexpected Error, Please contact support';
        }

        function urlInfo($url)
        {
            $rnds = rndString(13);
            $url = urlencode($url); /* NXSIDX2 */
            $sslverify = false;
            $ck = $this->ck;
            $hdrsArr = $this->headers('https://plus.google.com/');
            $rep = nxs_remote_get('https://plus.google.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
            if (is_nxs_error($rep)) return false; /* if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
            $contents = $rep['body'];
            $at = CutFromTo($contents, 'csi.gstatic.com/csi","', '",');
            $spar = 'f.req=%5B%22' . $url . '%22%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Ctrue%5D&at=' . $at . "&";
            $gurl = 'https://plus.google.com/u/0/_/sharebox/linkpreview/?soc-app=1&cid=0&soc-platform=1&hl=en&rt=j';
            $hdrsArr = $this->headers('https://plus.google.com/', 'https://plus.google.com', 'POST', true);
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $spar, 'sslverify' => $sslverify);//  prr($advSet);    
            $rep = nxs_remote_post($gurl, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $contents = $rep['body'];
            $json = prcGSON($contents);
            if (version_compare(phpversion(), '5.4.0', '>=')) $arr = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
            else {
                $arr = json_decode($json, true);
                if (!is_array($arr)) return;
                array_walk_recursive($arr, "nxs_jsonFix");
            }
            if (!is_array($arr)) return;  //   prr($contents); die();
            if (!isset($arr[0]) || !is_array($arr[0])) return;
            if (!empty($arr[0][1][2]) && is_array($arr[0][1][2])) $arr = $arr[0][1]; elseif (!empty($arr[0][0][2]) && is_array($arr[0][0][2])) $arr = $arr[0][0];
            if (!isset($arr[4]) || !is_array($arr[4])) return;
            if (!isset($arr[4][0]) || !is_array($arr[4][0])) return;
            $out['link'] = $arr[4][0][1];
            $out['title'] = $arr[4][0][3];
            $out['domain'] = $arr[4][0][4];
            $out['txt'] = $arr[4][0][7];
            if (isset($arr[4][0][2]) && trim($arr[4][0][2]) != '') $out['fav'] = $arr[4][0][2]; else $out['fav'] = 'https://s2.googleusercontent.com/s2/favicons?domain=' . $out['domain'];
            if (isset($arr[4][0][6][0])) {
                $out['img'] = $arr[4][0][6][0][8];
                $out['imgType'] = $arr[4][0][6][0][1];
            } else {
                if (isset($arr[2][1][24][3])) $out['imgType'] = $arr[2][1][24][3];
                if (isset($arr[2][1][41][0])) $out['img'] = $arr[2][1][41][0][1]; elseif (isset($arr[2][1][41][1])) $out['img'] = $arr[2][1][41][1][1];
            }
            $out['title'] = str_replace('&#39;', "'", $out['title']);
            $out['txt'] = str_replace('&#39;', "'", $out['txt']);
            $out['txt'] = html_entity_decode($out['txt'], ENT_COMPAT, 'UTF-8');
            $out['title'] = html_entity_decode($out['title'], ENT_COMPAT, 'UTF-8'); //  prr($arr);
            if (isset($arr[5][0]) && isset($arr[5][0][6]) && isset($arr[5][0][6][7])) $arr[5][0][6][7] = '';
            if (isset($arr[5][0]) && is_array($arr[5][0])) {
                $out['arr'] = $arr[5][0];
            }
            $out['arr'][6][0] = (int)$out['arr'][6][0];
            $out['arr'][6][4][0] = "ZZZZIYYYIZZZ";
            $out['arr'][6][7] = "ZZZZIYYYIZZZ";
            if (isset($out['arr'][7])) {
                $liar = $out['arr'][7];
                reset($liar);
                $liarOne = (int)key($liar);// var_dump($liarOne);
                if (!empty($liarOne)) {
                    $out['arr'][7][$liarOne][7] = array();
                }
            } // prr($out['arr']);
            return $out;
        }

        function getCCatsGP($commPageID)
        {
            $items = '';
            $sslverify = false;
            $ck = $this->ck;
            $hdrsArr = $this->headers('https://plus.google.com/');
            $rep = nxs_remote_get('https://plus.google.com/communities/' . $commPageID, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
            if (is_nxs_error($rep)) return false;
            if (!empty($rep['cookies'])) $ck = $rep['cookies'];
            $contents = $rep['body'];
            $commPageID2 = '[["' . stripslashes(str_replace('\n', '', CutFromTo($contents, ',,[[["', "]\n]\n]")));
            if (substr($commPageID2, -1) == '"') $commPageID2 .= "]]"; else $commPageID2 .= "]]]";
            $commPageID2 = str_replace('\u0026', '&', $commPageID2);
            $commPageID2 = json_decode($commPageID2);
            if (is_array($commPageID2)) foreach ($commPageID2 as $cpiItem) if (is_array($cpiItem)) {
                $val = $cpiItem[0];
                $name = $cpiItem[1];
                $items .= '<option value="' . $val . '">' . $name . '</option>';
            }
            return $items;
        }

        function postGP($msg, $lnk = '', $pageID = '', $commPageID = '', $commPageCatID = '')
        {
            $rnds = rndString(13);
            $sslverify = false;
            $ck = $this->ck;
            $hdrsArr = $this->headers('');
            $pageID = trim($pageID);
            $commPageID = trim($commPageID);
            $ownerID = '';
            $bigCode = '';
            $isPostToPage = $pageID != '';
            $isPostToComm = $commPageID != '';
            if (function_exists('nxs_decodeEntitiesFull')) $msg = nxs_decodeEntitiesFull($msg);
            if (function_exists('nxs_html_to_utf8')) $msg = nxs_html_to_utf8($msg);
            $msg = str_replace('<br>', "_NXSZZNXS_5Cn", $msg);
            $msg = str_replace('<br/>', "_NXSZZNXS_5Cn", $msg);
            $msg = str_replace('<br />', "_NXSZZNXS_5Cn", $msg);
            $msg = str_replace("\r\n", "\n", $msg);
            $msg = str_replace("\n\r", "\n", $msg);
            $msg = str_replace("\r", "\n", $msg);
            $msg = str_replace("\n", "_NXSZZNXS_5Cn", $msg);
            $msg = str_replace('"', '\"', $msg);
            $msg = urlencode(strip_tags($msg));
            $msg = str_replace("_NXSZZNXS_5Cn", "%5Cn", $msg);
            $msg = str_replace('+', '%20', $msg);
            $msg = str_replace('%0A%0A', '%20', $msg);
            $msg = str_replace('%0A', '', $msg);
            $msg = str_replace('%0D', '%5C', $msg);
            if (!empty($lnk) && !is_array($lnk)) $lnk = $this->urlInfo($lnk);
            if ($lnk == '') $lnk = array('img' => '', 'link' => '', 'fav' => '', 'domain' => '', 'title' => '', 'txt' => '');
            if (!isset($lnk['link']) && !empty($lnk['img'])) {
                $hdrsArr = $this->headers('');
                unset($hdrsArr['Connection']);
                $rep = nxs_remote_get($lnk['img'], array('headers' => $hdrsArr, 'httpversion' => '1.1', 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) $lnk['img'] = ''; elseif ($rep['response']['code'] == '200' && !empty($rep['headers']['content-type']) && stripos($rep['headers']['content-type'], 'text/html') === false) {
                    if (!empty($rep['headers']['content-length'])) $imgdSize = $rep['headers']['content-length'];
                    if ((empty($imgdSize) || $imgdSize == '-1') && !empty($rep['headers']['size_download'])) $imgdSize = $rep['headers']['size_download'];
                    if ((empty($imgdSize) || $imgdSize == '-1')) {
                        $ch = curl_init($lnk['img']);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                        curl_setopt($ch, CURLOPT_HEADER, TRUE);
                        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                        $data = curl_exec($ch);
                        $imgdSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                        curl_close($ch);
                    }
                    if ((empty($imgdSize) || $imgdSize == '-1')) $imgdSize = strlen($rep['body']);
                    $urlParced = pathinfo($lnk['img']);
                    $remImgURL = $lnk['img'];
                    $remImgURLFilename = nxs_mkImgNm(nxs_clFN($urlParced['basename']), $rep['headers']['content-type']);
                    $imgData = $rep['body'];
                } else $lnk['img'] = '';
            }
            if (isset($lnk['img'])) $lnk['img'] = urlencode($lnk['img']);
            if (isset($lnk['link'])) $lnk['link'] = urlencode($lnk['link']);
            if (isset($lnk['fav'])) $lnk['fav'] = urlencode($lnk['fav']);
            if (isset($lnk['domain'])) $lnk['domain'] = urlencode($lnk['domain']);
            if (isset($lnk['title'])) {
                $lnk['title'] = (str_replace(Array("\n", "\r"), ' ', $lnk['title']));
                $lnk['title'] = rawurlencode(addslashes($lnk['title']));
            }
            if (isset($lnk['txt'])) {
                $lnk['txt'] = (str_replace(Array("\n", "\r"), ' ', $lnk['txt']));
                $lnk['txt'] = rawurlencode(addslashes($lnk['txt']));
            }
            $refPage = 'https://plus.google.com/b/' . $pageID . '/';
            $rndReqID = rand(1203718, 647379);
            $rndSpamID = rand(4, 52);
            if ($commPageID != '') { //## Posting to Community      
                if ($pageID != '') $pgIDT = 'u/0/b/' . $pageID . '/'; else $pgIDT = '';
                $gpp = 'https://plus.google.com/' . $pgIDT . '_/sharebox/post/?spam=' . $rndSpamID . '&_reqid=' . $rndReqID . '&rt=j';
                $rep = nxs_remote_get('https://plus.google.com/communities/' . $commPageID, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR commPageID";
                    return $badOut;
                } /* if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
                $contents = $rep['body'];
                if (trim($commPageCatID) != '') $commPageID2 = $commPageCatID; else {
                    $commPageID2 = CutFromTo($contents, "AF_initDataCallback({key: '60',", '</script>');
                    $commPageID2 = CutFromTo($commPageID2, ',,[[["', '"');
                }
            } elseif ($pageID != '') { //## Posting to Page
                $gpp = 'https://plus.google.com/b/' . $pageID . '/_/sharebox/post/?spam=' . $rndSpamID . '&_reqid=' . $rndReqID . '&rt=j';
                $rep = nxs_remote_get($refPage, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR pageID";
                    return $badOut;
                } /* if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
                $contents = $rep['body'];
            } else { //## Posting to Profile      
                $gpp = 'https://plus.google.com/u/0/_/sharebox/post/?spam=' . $rndSpamID . '&soc-app=1&cid=0&soc-platform=1&hl=en&rt=j';
                $rep = nxs_remote_get('https://plus.google.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR Main Page";
                    return $badOut;
                } /* if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
                $contents = $rep['body'];
                $pageID = CutFromTo($contents, "key: '2'", "]"); /* $pageID = CutFromTo($pageID, 'https://plus.google.com/', '"'); */
                $pageID = CutFromTo($pageID, 'data:["', '"');
                $refPage = 'https://plus.google.com/';
                $refPage = 'https://plus.google.com/_/scs/apps-static/_/js/k=oz.home.en.JYkOx2--Oes.O';
                //unset($nxs_gCookiesArr['GAPS']); unset($nxs_gCookiesArr['GALX']); unset($nxs_gCookiesArr['RMME']); unset($nxs_gCookiesArr['LSID']);  // We migh still need it ?????
            } // echo $lnk['txt'];         
            if ($rep['response']['code'] == '400') return "Invalid Sharebox Page. Something is wrong, please contact support";
            if (stripos($contents, 'csi.gstatic.com/csi","') !== false) $at = CutFromTo($contents, 'csi.gstatic.com/csi","', '",'); else {
                $rep = nxs_remote_get('https://plus.google.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR CSI";
                    return $badOut;
                } /* if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
                $contents = $rep['body']; // prr($rep);
                if (stripos($contents, 'csi.gstatic.com/csi","') !== false) $at = CutFromTo($contents, 'csi.gstatic.com/csi","', '",'); else return "Error (NXS): Lost Login info. Please contact support";
            } // prr($lnk);
            //## URL     
            if (!isset($lnk['txt'])) $lnk['txt'] = '';
            $txttxt = $lnk['txt'];
            $txtStxt = str_replace('%5C', '%5C%5C%5C%5C%5C%5C%5C', $lnk['txt']);
            if ($isPostToComm) $proOrCommTxt = "%5B%22" . $commPageID . "%22%2C%22" . $commPageID2 . "%22%5D%5D%2C%5B%5B%5Bnull%2Cnull%2Cnull%2C%5B%22" . $commPageID . "%22%5D%5D%5D"; else $proOrCommTxt = "%5D%2C%5B%5B%5Bnull%2Cnull%2C1%5D%5D%2Cnull";
            if (!empty($lnk['link']) && isset($lnk['arr'])) {
                $urlInfo = urlencode(str_replace('\/', '/', str_replace('##-KXKZK-##', '\""', str_replace('""', 'null', str_replace('\""', '##-KXKZK-##', json_encode($lnk['arr']))))));
                $urlInfo = str_replace('ZZZZIYYYIZZZ', '', $urlInfo);
                $spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $pageID . "." . $rnds . ".0%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2C" . $urlInfo . "%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2C2%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%2Cnull%2Cnull%2Cnull%2C%5B%5D%2C%5B%5Btrue%5D%5D%2Cnull%2C%5B%5D%5D&at=" . $at . "&";

            }
            //## Video - was here, but now video works like link. So link could be used. 
            //## Image
            elseif (!empty($lnk['img']) && !empty($imgData)) {
                $pgAddFlds = '';
                //if($isPostToPage) $pgAddFlds = '{"inlined":{"name":"effective_id","content":"'.$pageID.'","contentType":"text/plain"}},{"inlined":{"name":"owner_name","content":"'.$pageID.'","contentType":"text/plain"}},'; else $pgAddFlds = '';
                if ($isPostToComm) $proOrCommTxt = "%5B%22" . $commPageID . "%22%2C%22" . $commPageID2 . "%22%5D%5D%2C%5B%5B%5Bnull%2Cnull%2Cnull%2C%5B%22" . $commPageID . "%22%5D%5D%5D"; else $proOrCommTxt = "%5D%2C%5B%5B%5Bnull%2Cnull%2C1%5D%5D%2Cnull";
                //if (!$isPostToComm) $pgAddFlds = '{"inlined":{"name":"effective_id","content":"'.$pageID.'","contentType":"text/plain"}},{"inlined":{"name":"owner_name","content":"'.$pageID.'","contentType":"text/plain"}},'; else $pgAddFlds = '';
                $iflds = '{"protocolVersion":"0.8","createSessionRequest":{"fields":[{"external":{"name":"file","filename":"' . $remImgURLFilename . '","put":{},"size":' . $imgdSize . '}},{"inlined":{"name":"use_upload_size_pref","content":"true","contentType":"text/plain"}},{"inlined":{"name":"batchid","content":"1389803229361","contentType":"text/plain"}},{"inlined":{"name":"client","content":"sharebox","contentType":"text/plain"}},{"inlined":{"name":"disable_asbe_notification","content":"true","contentType":"text/plain"}},{"inlined":{"name":"album_mode","content":"temporary","contentType":"text/plain"}},' . $pgAddFlds . '{"inlined":{"name":"album_abs_position","content":"0","contentType":"text/plain"}}]}}';

                $hdrsArr = $this->headers('', 'https://plus.google.com', 'POST', true);
                $hdrsArr['X-GUploader-Client-Info'] = 'mechanism=scotty xhr resumable; clientVersion=58505203';
                $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $iflds, 'sslverify' => $sslverify);// prr($advSet);
                $imgReqCnt = nxs_remote_post('https://plus.google.com/_/upload/photos/resumable?authuser=0', $advSet);
                if (is_nxs_error($imgReqCnt)) {
                    $badOut = print_r($imgReqCnt, true) . " - ERROR IMG";
                    return $badOut;
                } //prr($imgReqCnt);
                $gUplURL = str_replace('\u0026', '&', CutFromTo($imgReqCnt['body'], 'putInfo":{"url":"', '"'));
                $gUplID = CutFromTo($imgReqCnt['body'], 'upload_id":"', '"');

                $hdrsArr = $this->headers('', 'https://plus.google.com', 'PUT', true);
                $hdrsArr['X-GUploader-No-308'] = 'yes';
                $hdrsArr['X-HTTP-Method-Override'] = 'PUT';
                $hdrsArr['Expect'] = '';
                $hdrsArr['Content-Type'] = 'application/octet-stream';
                $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $imgData, 'sslverify' => $sslverify);// prr($advSet);
                $imgUplCnt = nxs_remote_post($gUplURL, $advSet);
                if (is_nxs_error($imgUplCnt)) {
                    $badOut = print_r($imgUplCnt, true) . " - ERROR IMG Upl (Upl URL: " . $gUplURL . ", IMG URL: " . urldecode($lnk['img']) . ", FileName: " . $remImgURLFilename . ", FIlesize: " . $imgdSize . ")";
                    return $badOut;
                }
                $imgUplCnt = json_decode($imgUplCnt['body'], true);
                if (empty($imgUplCnt)) return "Can't upload image: " . $remImgURL;
                if (is_array($imgUplCnt) && isset($imgUplCnt['errorMessage']) && is_array($imgUplCnt['errorMessage'])) return "Error (500): " . print_r($imgUplCnt['errorMessage'], true);
                $infoArray = $imgUplCnt['sessionStatus']['additionalInfo']['uploader_service.GoogleRupioAdditionalInfo']['completionInfo']['customerSpecificInfo'];
                $albumID = $infoArray['albumid'];
                $photoid = $infoArray['photoid']; // $albumID = "5969185467353784753";
                $imgUrl = urlencode($infoArray['url']);
                $imgTitie = $infoArray['title'];
                $imgUrlX = str_ireplace('https:', '', $infoArray['url']);
                $imgUrlX = str_ireplace('//lh4.', '//lh3.', $imgUrlX);
                $imgUrlX = urlencode(str_ireplace('http:', '', $imgUrlX));
                $width = $infoArray['width'];
                $height = $infoArray['height'];
                $userID = $infoArray['username'];
                $intID = $infoArray['albumPageUrl'];
                $intID = str_replace('https://picasaweb.google.com/', '', $intID);
                $intID = str_replace($userID, '', $intID);
                $intID = str_replace('/', '', $intID); // prr($infoArray);
                $spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $pageID . "." . $rnds . ".4%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5D%22%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5B344%2C339%2C338%2C336%2C335%5D%2Cnull%2Cnull%2Cnull%2C%5B%7B%2239387941%22%3A%5Btrue%2Cfalse%5D%7D%5D%2Cnull%2Cnull%2C%7B%2240655821%22%3A%5B%22https%3A%2F%2Fplus.google.com%2Fphotos%2F" . $userID . "%2Falbums%2F" . $albumID . "%2F" . $photoid . "%22%2C%22" . $imgUrlX . "%22%2C%22" . $imgTitie . "%22%2C%22%22%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22" . $width . "%22%2C%22" . $height . "%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22" . $userID . "%22%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%22" . $albumID . "%22%2C%22" . $photoid . "%22%2C%22albumid%3D" . $albumID . "%26photoid%3D" . $photoid . "%22%2C1%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B%5D%5D%7D%5D%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2C2%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%2Cnull%2Cnull%2Cnull%2C%5B%22updates%22%5D%2C%5B%5Btrue%5D%5D%2Cnull%2C%5B%5D%5D&at=" . $at . "&";
            } //## Just Message    
            else $spar = "f.req=%5B%22" . $msg . "%22%2C%22oz%3A" . $pageID . "." . $rnds . ".6%22%2Cnull%2Cnull%2Cnull%2Cnull%2C%22%5B%5D%22%2Cnull%2Cnull%2Ctrue%2C%5B%5D%2Cfalse%2Cnull%2Cnull%2C%5B%5D%2Cnull%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cfalse%2Cfalse%2Cfalse%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2Cnull%2C%5B" . $proOrCommTxt . "%5D%2Cnull%2Cnull%2C2%2Cnull%2Cnull%2Cnull%2C%22!" . $bigCode . "%22%2Cnull%2Cnull%2Cnull%2C%5B%5D%2C%5B%5Btrue%5D%5D%2Cnull%2C%5B%5D%5D&at=" . $at . "&";
            //## POST  prr(urldecode($spar));
            $spar = str_ireplace('+', '%20', $spar);
            $spar = str_ireplace(':', '%3A', $spar);
            $hdrsArr = $this->headers($refPage, 'https://plus.google.com', 'POST', true);
            $hdrsArr['X-Same-Domain'] = '1';
            //$ckt = $ck; $ck = array(); $no = array("LSID", "ACCOUNT_CHOOSER", "GoogleAccountsLocale_session", "GAPS", "GALX"); foreach ($ckt as $c) {if (!in_array($c->name, $no)) $ck[]=$c;}
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $spar, 'sslverify' => $sslverify);
            $rep = nxs_remote_post($gpp, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR POST";
                return $badOut;
            }
            $contents = $rep['body']; // prr($advSet);    prr($rep);        
            if ($rep['response']['code'] == '403') return "Error: You are not authorized to publish to this page. Are you sure this is even a page? (" . $pageID . ")";
            if ($rep['response']['code'] == '404') return "Error: Page you are posting is not found.<br/><br/> If you have entered your page ID as 117008619877691455570/117008619877691455570, please remove the second copy. It should be one number only - 117008619877691455570";
            if ($rep['response']['code'] == '400') return "Error (400): Something is wrong, please contact support";
            if ($rep['response']['code'] == '500') return "Error (500): Something is wrong, please contact support";
            if ($rep['response']['code'] == '200') {
                $ret = $rep['body'];
                $remTxt = CutFromTo($ret, '"{\"', '}"');
                $ret = str_replace($remTxt, '', $ret);
                $ret = prcGSON($ret);
                $ret = json_decode($ret, true);
                if (!empty($ret[0][1][1]) && is_array($ret[0][1][1]) && !empty($ret[0][1][1][0][0][21])) $ret = $ret[0][1][1][0][0][21];
                elseif (!empty($ret[0][0][1]) && is_array($ret[0][0][1]) && !empty($ret[0][0][1][0][0][21])) $ret = $ret[0][0][1][0][0][21];
                return array('isPosted' => '1', 'postID' => $ret, 'postURL' => 'https://plus.google.com/' . $ret, 'pDate' => date('Y-m-d H:i:s'));
            }
            return print_r($contents, true);
        }

        function postBG($blogID, $title, $msg, $tags = '')
        {
            $sslverify = false;
            $rnds = rndString(35);
            $blogID = trim($blogID);
            $ck = $this->ck;
            $gpp = "https://www.blogger.com/blogger.g?blogID=" . $blogID;
            $refPage = "https://www.blogger.com/home";
            $hdrsArr = $this->headers($refPage);
            $rep = nxs_remote_get($gpp, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify)); //prr($ck); prr($rep);// die();
            if (is_nxs_error($rep)) return false; /*if (!empty($rep['cookies'])) $ck = $rep['cookies']; */
            $contents = $rep['body'];
            if (stripos($contents, 'Error 404') !== false) return "Error: Invalid Blog ID - Blog with ID " . $blogID . " Not Found";
            $jjs = CutFromTo($contents, 'BloggerClientFlags=', '_layoutOnLoadHandler');
            $j69 = ''; // prr($jjs); //  prr($contents); echo "\r\n"; echo "\r\n";    
            for ($i = 54; $i <= 129; $i++) {
                if ($j69 == '' && strpos($jjs, $i . ':"') !== false) {
                    $j69 = CutFromTo($jjs, $i . ':"', '"');
                    if (strpos($j69, ':') === false || (strpos($j69, '/') !== false) || (strpos($j69, ' ') !== false) || (strpos($j69, '\\') !== false)) $j69 = '';
                }
            }
            $gpp = "https://www.blogger.com/blogger_rpc?blogID=" . $blogID;
            $refPage = "https://www.blogger.com/blogger.g?blogID=" . $blogID;
            $spar = '{"method":"editPost","params":{"1":1,"2":"","3":"","5":0,"6":0,"7":1,"8":3,"9":0,"10":2,"11":1,"13":0,"14":{"6":""},"15":"en","16":0,"17":{"1":' . date("Y") . ',"2":' . date("n") . ',"3":' . date("j") . ',"4":' . date("G") . ',"5":' . date("i") . '},"20":0,"21":"","22":{"1":1,"2":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0,"10":"0"}},"23":1},"xsrf":"' . $j69 . '"}';
            $hdrsArr = $this->headers($refPage, 'https://www.blogger.com', 'JS', false);
            $hdrsArr['X-GWT-Module-Base'] = 'https://www.blogger.com/static/v1/gwt/';
            $hdrsArr['X-GWT-Permutation'] = '906B796BACD31B64BA497BEE3824B344';
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $spar, 'sslverify' => $sslverify); // prr($advSet);    
            $rep = nxs_remote_post($gpp, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR BG";
                return $badOut;
            }
            $contents = $rep['body']; //  prr($rep);   
            $newpostID = CutFromTo($contents, '"result":[null,"', '"');
            if ($tags != '') $pTags = '["' . $tags . '"]'; else $pTags = '';
            $pTags = str_replace('!', '', $pTags);
            $pTags = str_replace('.', '', $pTags);
            if (class_exists('DOMDocument')) {
                $doc = new DOMDocument();
                @$doc->loadXML("<QAZX>" . $msg . "</QAZX>");
                $styles = $doc->getElementsByTagName('style');
                if ($styles->length > 0) {
                    foreach ($styles as $style) $style->nodeValue = str_ireplace("<br/>", "", $style->nodeValue);
                    $msg = $doc->saveXML($doc->documentElement, LIBXML_NOEMPTYTAG);
                    $msg = str_ireplace("<QAZX>", "", str_ireplace("</QAZX>", "", $msg));
                }
            }
            $msg = str_replace("'", '"', $msg);
            $msg = addslashes($msg);
            $msg = str_replace("\r\n", "\n", $msg);
            $msg = str_replace("\n\r", "\n", $msg);
            $msg = str_replace("\r", "\n", $msg);
            $msg = str_replace("\n", '\n', $msg);
            $title = strip_tags($title);
            $title = str_replace("'", '"', $title);
            $title = addslashes($title);
            $title = str_replace("\r\n", "\n", $title);
            $title = str_replace("\n\r", "\n", $title);
            $title = str_replace("\r", "\n", $title);
            $title = str_replace("\n", '\n', $title); //echo "~~~~~";  prr($title);
            $spar = '{"method":"editPost","params":{"1":1,"2":"' . $title . '","3":"' . $msg . '","4":"' . $newpostID . '","5":0,"6":0,"7":1,"8":3,"9":0,"10":2,"11":2,' . ($pTags != '' ? '"12":' . $pTags . ',' : '') . '"13":0,"14":{"6":""},"15":"en","16":0,"17":{"1":' . date("Y") . ',"2":' . date("n") . ',"3":' . date("j") . ',"4":' . date("G") . ',"5":' . date("i") . '},"20":0,"21":"","22":{"1":1,"2":{"1":0,"2":0,"3":0,"4":0,"5":0,"6":0,"7":0,"8":0,"9":0,"10":"0"}},"23":1},"xsrf":"' . $j69 . '"}';

            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $spar, 'sslverify' => $sslverify); //prr($advSet);    
            $rep = nxs_remote_post($gpp, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR BG2";
                return $badOut;
            }
            $contents = $rep['body'];

            $retJ = json_decode($contents, true);
            if (is_array($retJ) && !empty($retJ['result']) && is_array($retJ['result'])) $postID = $retJ['result'][6]; else $postID = '';
            if (stripos($contents, '"error":') !== false) {
                return "Error: " . print_r($contents, true);
            }
            if ($rep['response']['code'] == '200') return array('isPosted' => '1', 'postID' => $postID, 'postURL' => $postID, 'pDate' => date('Y-m-d H:i:s')); else return print_r($contents, true);
        }

        function postYT($msg, $ytUrl, $vURL = '', $ytGPPageID = '')
        {
            $ck = $this->ck;
            $sslverify = false;
            $ytUrl = str_ireplace('/feed', '', $ytUrl);
            if (substr($ytUrl, -1) == '/') $ytUrl = substr($ytUrl, 0, -1);
            $ytUrl .= '/feed';
            $hdrsArr = $this->headers('http://www.youtube.com/');
            if ($ytGPPageID != '') {
                $pgURL = 'https://www.youtube.com/signin?authuser=0&action_handle_signin=true&pageid=' . $ytGPPageID;
                if ($this->debug) echo "[YT] G SW to page: " . $ytGPPageID . "<br/>\r\n";
                $rep = nxs_remote_get($pgURL, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'redirection' => 0, 'cookies' => $ck, 'sslverify' => $sslverify));
                if (is_nxs_error($rep)) return "ERROR: " . print_r($rep, true);
                if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                    $fdn = false;
                    foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                        $fdn = true;
                        $ck[$ci] = $ccN;
                    }
                    if (!$fdn) $ck[] = $ccN;
                }
            }
            $rep = nxs_remote_get($ytUrl, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'redirection' => 0, 'cookies' => $ck, 'sslverify' => $sslverify));
            if (is_nxs_error($rep)) return "ERROR: " . print_r($rep, true);
            //## Merge CK
            if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                $fdn = false;
                foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                    $fdn = true;
                    $ck[$ci] = $ccN;
                }
                if (!$fdn) $ck[] = $ccN;
            }
            $contents = $rep['body'];
            $gpPageMsg = "Either BAD YouTube USER/PASS or you are trying to post from the wrong account/page. Make sure you have Google+ page ID if your YouTube account belongs to the page.";
            $actFormCode = 'channel_ajax';
            if (stripos($contents, 'action="/c4_feed_ajax?') !== false) $actFormCode = 'c4_feed_ajax';
            if (stripos($contents, 'action="/' . $actFormCode . '?')) $frmData = CutFromTo($contents, 'action="/' . $actFormCode . '?', '</form>'); else {
                if (stripos($contents, 'property="og:url"')) {
                    $ytUrl = CutFromTo($contents, 'property="og:url" content="', '"') . '/feed';
                    $rep = nxs_remote_get($ytUrl, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck, 'sslverify' => $sslverify));
                    if (is_nxs_error($rep)) return "ERROR: " . print_r($rep, true);
                    if (!empty($rep['cookies'])) $ck = $rep['cookies'];
                    $contents = $rep['body'];
                    if (stripos($contents, 'action="/' . $actFormCode . '?')) $frmData = CutFromTo($contents, 'action="/' . $actFormCode . '?', '</form>'); else return 'OG - Form not found. - ' . $gpPageMsg;
                } else {
                    $eMsg = "No Form/No OG - " . $gpPageMsg;
                    return $eMsg;
                }
            }
            $md = array();
            $flds = array();
            if ($vURL != '' && stripos($vURL, 'http') === false) $vURL = 'https://www.youtube.com/watch?v=' . $vURL;
            $msg = strip_tags($msg);
            $msg = nsTrnc($msg, 500);
            while (stripos($frmData, '"hidden"') !== false) {
                $frmData = substr($frmData, stripos($frmData, '"hidden"') + 8);
                $name = trim(CutFromTo($frmData, 'name="', '"'));
                if (!in_array($name, $md)) {
                    $md[] = $name;
                    $val = trim(CutFromTo($frmData, 'value="', '"'));
                    $flds[$name] = $val;
                }
            }
            $flds['message'] = $msg;
            $flds['video_url'] = $vURL; // prr($flds);
            $ytGPPageID = 'https://www.youtube.com/channel/' . $ytGPPageID;
            $hdrsArr = $this->headers($ytGPPageID, 'https://www.youtube.com/', 'POST', false);
            $hdrsArr['X-YouTube-Page-CL'] = '67741289';
            $hdrsArr['X-YouTube-Page-Timestamp'] = date("D M j H:i:s Y", time() - 54000) . " (" . time() . ")"; //'Thu May 22 00:31:51 2014 (1400743911)';
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds, 'sslverify' => $sslverify); //prr($advSet);
            $rep = nxs_remote_post('https://www.youtube.com/' . $actFormCode . '?action_add_bulletin=1', $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR YT";
                return $badOut;
            }
            $contents = $rep['body'];// prr('https://www.youtube.com/'.$actFormCode.'?action_add_bulletin=1'); prr($rep);

            if ($rep['response']['code'] == '200' && $contents = '{"code": "SUCCESS"}') return array("isPosted" => "1", "postID" => '', 'postURL' => '', 'pDate' => date('Y-m-d H:i:s')); else return $rep['response']['code'] . "|" . $contents;
        }
    }
}
//================================Pinterest===========================================
//## Check current  Pinterest session
if (!function_exists("doConnectToPinterest")) {
    function doConnectToPinterest($email, $pass, $iidb = -1)
    {
        global $nxs_plurl, $nxs_gCookiesArr, $plgn_NS_SNAutoPoster;
        if (!empty($nxs_gCookiesArr)) $ck = $nxs_gCookiesArr; else {
            if ($iidb == -1 && !empty($_POST['ii'])) $iidb = $_POST['ii'];
            if ($iidb == -1 && !empty($_POST['nid'])) $iidb = $_POST['nid'];
            if ($iidb != -1 && isset($plgn_NS_SNAutoPoster)) {
                $options = $plgn_NS_SNAutoPoster->nxs_options;
                if (isset($options['pn'][$iidb]['ck'])) $ck = maybe_unserialize($options['pn'][$iidb]['ck']);
            } else $ck = array();
        }
        $nt = new nxsAPI_PN();
        $nt->debug = false;
        if (!empty($ck)) $nt->ck = $ck;
        $loginErr = $nt->connect($email, $pass);
        if (!$loginErr) {
            $nxs_gCookiesArr = $nt->ck;
            $nxs_gCookiesArr['chkPnt3'] = '1';
        }
        return $loginErr;
    }
}
if (!function_exists("doCheckPinterest")) {
    function doCheckPinterest()
    {
        global $nxs_gCookiesArr;
        if (!empty($nxs_gCookiesArr) && empty($nxs_gCookiesArr['chkPnt3'])) {
            $nxs_gCookiesArr = array();
            return "No";
        }
        $nt = new nxsAPI_PN();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) {
            $nt->ck = $nxs_gCookiesArr;
            if (!empty($nt->ck['chkPnt3'])) unset($nt->ck['chkPnt3']);
        }
        return !$nt->check();
    }
}
if (!function_exists("doGetBoardsFromPinterest")) {
    function doGetBoardsFromPinterest()
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_PN();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) {
            if (!empty($nxs_gCookiesArr) && empty($nxs_gCookiesArr['chkPnt3'])) {
                $nxs_gCookiesArr = array();
            }
            $nt->ck = $nxs_gCookiesArr;
            if (!empty($nt->ck['chkPnt3'])) unset($nt->ck['chkPnt3']);
        }
        $boards = $nt->getBoards();
        return $boards;
    }
}
if (!function_exists("doPostToPinterest")) {
    function doPostToPinterest($msg, $imgURL, $lnk, $boardID, $title = '', $price = '', $via = '')
    {
        global $nxs_gCookiesArr;
        $nt = new nxsAPI_PN();
        $nt->debug = false;
        if (!empty($nxs_gCookiesArr)) {
            $nt->ck = $nxs_gCookiesArr;
            if (!empty($nt->ck['chkPnt3'])) unset($nt->ck['chkPnt3']);
        }
        $ret = $nt->post($msg, $imgURL, $lnk, $boardID, $title, $price, $via); // prr($ret);
        if (is_array($ret) && !empty($ret['isPosted'])) return array("code" => "OK", "post_id" => $ret['postID'], "post_url" => $ret['postURL']); else return $ret;
    }
}
if (!class_exists('nxsAPI_PN')) {
    class nxsAPI_PN
    {
        var $ck = array();
        var $tk = '';
        var $boards = '';
        var $apVer = '';
        var $u = '';
        var $debug = false;

        function headers($ref, $org = '', $type = 'GET', $aj = false)
        {
            $hdrsArr = array();
            $hdrsArr['Cache-Control'] = 'max-age=0';
            $hdrsArr['Connection'] = 'keep-alive';
            $hdrsArr['Referer'] = $ref;
            $hdrsArr['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.22 Safari/537.36';
            if ($type == 'JSON') $hdrsArr['Content-Type'] = 'application/json;charset=UTF-8'; elseif ($type == 'POST') $hdrsArr['Content-Type'] = 'application/x-www-form-urlencoded';
            if ($aj === true) $hdrsArr['X-Requested-With'] = 'XMLHttpRequest';
            if ($org != '') $hdrsArr['Origin'] = $org;
            if ($type == 'GET') $hdrsArr['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'; else $hdrsArr['Accept'] = '*/*';
            if (function_exists('gzdeflate')) $hdrsArr['Accept-Encoding'] = 'deflate,sdch';
            $hdrsArr['Accept-Language'] = 'en-US,en;q=0.8';
            return $hdrsArr;
        }

        function check($u = '')
        {
            $ck = $this->ck;
            if (!empty($ck) && is_array($ck)) {
                $hdrsArr = $this->headers('https://www.pinterest.com/settings/');
                if ($this->debug) echo "[PN] Checking....;<br/>\r\n";
                $rep = nxs_remote_get('https://www.pinterest.com/settings/', array('headers' => $hdrsArr, 'timeout' => 45, 'httpversion' => '1.1', 'cookies' => $ck));
                if (is_nxs_error($rep)) return false;
                $ck = $rep['cookies'];
                $contents = $rep['body']; //if ($this->debug) prr($contents);
                $ret = stripos($contents, 'href="#accountBasics"') !== false;
                $usr = CutFromTo($contents, '"email": "', '"');
                if ($ret & $this->debug) echo "[PN] Logged as:" . $usr . "<br/>\r\n";
                $apVer = trim(CutFromTo($contents, '"app_version": "', '"'));
                $this->apVer = $apVer;
                if (empty($u) || $u == $usr) return $ret; else return false;
            } else return false;
        }

        function connect($u, $p)
        {
            $badOut = 'Error: '; // $this->debug = true;
            //## Check if alrady IN
            if (!$this->check($u)) {
                if ($this->debug) echo "[PN] NO Saved Data; Logging in...<br/>\r\n";
                $hdrsArr = $this->headers('https://www.pinterest.com/login/');
                $rep = nxs_remote_get('https://www.pinterest.com/login/', array('headers' => $hdrsArr, 'timeout' => 45, 'httpversion' => '1.1'));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR -01-";
                    return $badOut;
                }
                $ck = $rep['cookies'];
                $contents = $rep['body'];
                prr($contents);
                $apVer = trim(CutFromTo($contents, '"app_version": "', '"'));
                $fldsTxt = 'data=%7B%22options%22%3A%7B%22username_or_email%22%3A%22' . urlencode($u) . '%22%2C%22password%22%3A%22' . str_replace('%5C', '%5C%5C', urlencode($p)) . '%22%7D%2C%22context%22%3A%7B%22app_version%22%3A%22' . $apVer .
                    '%22%7D%7D&source_url=%2Flogin%2F&module_path=App()%3ELoginPage()%3ELogin()%3EButton(class_name%3Dprimary%2C+text%3DLog+in%2C+type%3Dsubmit%2C+tagName%3Dbutton%2C+size%3Dlarge)';
                foreach ($ck as $c) if ($c->name == 'csrftoken') $xftkn = $c->value;
                //## ACTUAL LOGIN 
                $hdrsArr = $this->headers('https://www.pinterest.com/login/', 'https://www.pinterest.com', 'POST', true);
                $hdrsArr['X-NEW-APP'] = '1';
                $hdrsArr['X-APP-VERSION'] = $apVer;
                $hdrsArr['X-CSRFToken'] = $xftkn;
                $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $fldsTxt); // prr($advSet);
                $rep = nxs_remote_post('https://www.pinterest.com/resource/UserSessionResource/create/', $advSet);
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR -02-";
                    return $badOut;
                }
                if (!empty($rep['body'])) {
                    $contents = $rep['body'];
                    $resp = json_decode($contents, true);
                } else {
                    $badOut = print_r($rep, true) . " - ERROR -03-";
                    return $badOut;
                }
                if (is_array($resp) && empty($resp['resource_response']['error'])) {
                    $ck = $rep['cookies'];
                    foreach ($ck as $ci => $cc) $ck[$ci]->value = str_replace(' ', '+', $cc->value);
                    $hdrsArr = $this->headers('https://www.pinterest.com/login');
                    $rep = nxs_remote_get('https://www.pinterest.com/', array('headers' => $hdrsArr, 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'httpversion' => '1.1'));
                    if (is_nxs_error($rep)) {
                        $badOut = print_r($rep, true) . " - ERROR -02.1-";
                        return $badOut;
                    }
                    if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                        $fdn = false;
                        foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                            $fdn = true;
                            $ck[$ci] = $ccN;
                        }
                        if (!$fdn) $ck[] = $ccN;
                    }
                    foreach ($ck as $ci => $cc) $ck[$ci]->value = str_replace(' ', '+', $cc->value);
                    $this->tk = $xftkn;
                    $this->ck = $ck;
                    $this->apVer = $apVer;
                    if ($this->debug) echo "[PN] You are IN;<br/>\r\n";
                    return false; // echo "You are IN";                                       
                } elseif (is_array($resp) && isset($resp['resource_response']['error'])) return "ERROR -04-: " . $resp['resource_response']['error']['http_status'] . " | " . $resp['resource_response']['error']['message'];
                elseif (stripos($contents, 'CSRF verification failed') !== false) {
                    $retText = trim(str_replace(array("\r\n", "\r", "\n"), " | ", strip_tags(CutFromTo($contents, '</head>', '</body>'))));
                    return "CSRF verification failed - Please contact NextScripts Support | Pinterest Message:" . $retText;
                } elseif (stripos($contents, 'IP because of suspicious activity') !== false) return 'Pinterest blocked logins from this IP because of suspicious activity';
                elseif (stripos($contents, 've detected a bot!') !== false) return 'Pinterest has your IP (' . CutFromTo($contents, 'ess: <b>', '<') . ') blocked. Please <a target="_blank" class="link" href="//help.pinterest.com/entries/22914692">Contact Pinterest</a> and ask them to unblock your IP. ';
                elseif (stripos($contents, 'bot running on your network') !== false) return 'Pinterest has your IP (' . CutFromTo($contents, 'Your IP is:', '<') . ') blocked. Please <a target="_blank" class="link" href="//help.pinterest.com/entries/22914692">Contact Pinterest</a> and ask them to unblock your IP. ';
                else return 'Pinterest login failed. Unknown Error. Please contact support.';
                return 'Pinterest login failed. Unknown Error #2. Please contact support.';
            } else {
                if ($this->debug) echo "[PN] Saved Data is OK;<br/>\r\n";
                return false;
            }
        }

        function getBoardsOLD()
        {
            if (!$this->check()) {
                if ($this->debug) echo "[PN] NO Saved Data;<br/>\r\n";
                return 'Not logged IN';
            }
            $boards = '';
            $ck = $this->ck;
            $apVer = $this->apVer;
            $brdsArr = array();
            $iu = 'http://memory.loc.gov/award/ndfa/ndfahult/c200/c240r.jpg';
            $su = '/pin/find/?url=' . urlencode($iu);
            $hdrsArr = $this->headers('http://www.pinterest.com/pin/find/?url=' . urlencode($iu), '', 'JSON', true);
            $hdrsArr['X-NEW-APP'] = '1';
            $hdrsArr['X-APP-VERSION'] = $apVer;
            $hdrsArr['Accept'] = 'application/json, text/javascript, */*; q=0.01';
            $dt = '{"options":{},"context":{},"module":{"name":"PinCreate","options":{"image_url":"' . $iu . '","action":"create","method":"scraped","link":"' . $iu . '","transparent_modal":false}},"append":false,"error_strategy":0}';
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck);
            $rep = nxs_remote_get('http://www.pinterest.com/resource/NoopResource/get/?source_url=' . urlencode($su) . '&data=' . urlencode($dt), $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $ck = $rep['cookies'];
            $contents = $rep['body'];
            $k = json_decode($contents, true);
            if (!empty($k['module']['tree']) && !empty($k['module']['tree']['children'][0]) && !empty($k['module']['tree']['children'][0]['children'])) $brdsA = $k['module']['tree']['children'][0]['children'];
            if(is_array($brdsA))
            {
                foreach ($brdsA as $ab) {
                    if (!empty($ab) && !empty($ab['data']['all_boards'])) {
                        $ba = $ab['data']['all_boards'];
                        foreach ($ba as $kh) {
                            $boards .= '<option value="' . $kh['id'] . '">' . $kh['name'] . '</option>';
                            $brdsArr[] = array('id' => $kh['id'], 'n' => $kh['name']);
                        }
                        $this->boards = $brdsArr;
                        return $boards;
                    }
                    $khtml = CutFromTo($k['module']['html'], "boardPickerInnerWrapper", "</ul>");
                    $khA = explode('<li', $khtml);
                }
                foreach ($khA as $kh) if (stripos($kh, 'data-id') !== false) {
                    $bid = CutFromTo($kh, 'data-id="', '"');
                    $bname = trim(CutFromTo($kh, '</div>', '</li>'));
                    if (isset($bid)) {
                        $boards .= '<option value="' . $bid . '">' . trim($bname) . '</option>';
                        $brdsArr[] = array('id' => $bid, 'n' => trim($bname));
                    }
                }
                $this->boards = $brdsArr;
                return $boards;
            }
            return false;
        }

        function getBoards()
        {
            if (!$this->check()) {
                if ($this->debug) echo "[PN] NO Saved Data;<br/>\r\n";
                return 'Not logged IN';
            }
            $boards = '';
            $ck = $this->ck;
            $apVer = $this->apVer;
            $brdsArr = array();
            $iu = 'http://memory.loc.gov/award/ndfa/ndfahult/c200/c240r.jpg';
            $su = '/pin/find/?url=' . urlencode($iu);
            $iuu = urlencode($iu);
            $hdrsArr = $this->headers('http://www.pinterest.com/', '', 'JSON', true);
            $hdrsArr['X-NEW-APP'] = '1';
            $hdrsArr['X-APP-VERSION'] = $apVer;
            $hdrsArr['X-Pinterest-AppState'] = 'active';
            $hdrsArr['Accept'] = 'application/json, text/javascript, */*; q=0.01';
            $brdURL = 'https://www.pinterest.com/resource/BoardPickerBoardsResource/get/?source_url=%2Fpin%2Ffind%2F%3Furl%' . $iuu . '&data=%7B%22options%22%3A%7B%22filter%22%3A%22all%22%2C%22field_set_key%22%3A%22board_picker%22%7D%2C%22context%22%3A%7B%7D%7D&module_path=App()%3EImagesFeedPage(resource%3DFindPinImagesResource(url%' . $iuu . '))%3EGrid()%3EGridItems()%3EPinnable()%3EShowModalButton(module%3DPinCreate)';
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck);
            $rep = nxs_remote_get($brdURL, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $ck = $rep['cookies'];
            $contents = $rep['body'];
            $k = json_decode($contents, true);
            if (!empty($k['resource_data_cache'])) {
                $brdsA = $k['resource_data_cache'];
                foreach ($brdsA as $ab) if (!empty($ab) && !empty($ab['data']['all_boards'])) {
                    $ba = $ab['data']['all_boards'];
                    foreach ($ba as $kh) {
                        $boards .= '<option value="' . $kh['id'] . '">' . $kh['name'] . '</option>';
                        $brdsArr[] = array('id' => $kh['id'], 'n' => $kh['name']);
                    }
                    $this->boards = $brdsArr;
                    return $boards;
                }
            }
            return $this->getBoardsOLD(); //## Remove it in couple months
        }

        function post($msg, $imgURL, $lnk, $boardID, $title = '', $price = '', $via = '')
        {
            $tk = $this->tk;
            $ck = $this->ck;
            $apVer = $this->apVer;
            if ($this->debug) echo "[PN] Posting to ..." . $boardID . "<br/>\r\n";
            foreach ($ck as $c) if (is_object($c) && $c->name == 'csrftoken') $tk = $c->value;
            $msg = strip_tags($msg);
            $msg = substr($msg, 0, 480);
            $tgs = '';
            $this->tk = $tk;
            if ($msg == '') $msg = '&nbsp;';
            if (trim($boardID) == '') return "Board is not Set";
            if (trim($imgURL) == '') return "Image is not Set";
            $msg = str_ireplace(array("\r\n", "\n", "\r"), " ", $msg);
            $msg = strip_tags($msg);
            if (function_exists('nxs_decodeEntitiesFull')) $msg = nxs_decodeEntitiesFull($msg, ENT_QUOTES);
            $mgsOut = urlencode($msg);
            $mgsOut = str_ireplace(array('%28', '%29', '%27', '%21', '%22', '%09'), array("(", ")", "'", "!", "%5C%22", '%5Ct'), $mgsOut);
            $fldsTxt = 'source_url=%2Fpin%2Ffind%2F%3Furl%3D' . urlencode(urlencode($lnk)) . '&data=%7B%22options%22%3A%7B%22board_id%22%3A%22' . $boardID . '%22%2C%22description%22%3A%22' . $mgsOut . '%22%2C%22link%22%3A%22' . urlencode($lnk) . '%22%2C%22share_twitter%22%3Afalse%2C%22image_url%22%3A%22' . urlencode($imgURL) . '%22%2C%22method%22%3A%22scraped%22%7D%2C%22context%22%3A%7B%7D%7D';
            $hdrsArr = $this->headers('https://www.pinterest.com/resource/PinResource/create/ ', 'https://www.pinterest.com', 'POST', true);
            $hdrsArr['X-NEW-APP'] = '1';
            $hdrsArr['X-APP-VERSION'] = $apVer;
            $hdrsArr['X-CSRFToken'] = $tk;
            $hdrsArr['X-Pinterest-AppState'] = 'active';
            $hdrsArr['Accept'] = 'application/json, text/javascript, */*; q=0.01';
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $fldsTxt);
            $rep = nxs_remote_post('https://www.pinterest.com/resource/PinResource/create/', $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $contents = $rep['body'];
            $resp = json_decode($contents, true); //  prr($advSet);  prr($resp);   prr($fldsTxt); // prr($contents);    
            if (is_array($resp)) {
                if (isset($resp['resource_response']) && isset($resp['resource_response']['error']) && $resp['resource_response']['error'] != '') return print_r($resp['resource_response']['error'], true);
                elseif (isset($resp['resource_response']) && isset($resp['resource_response']['data']) && $resp['resource_response']['data']['id'] != '') { // gor JSON
                    if (isset($resp['resource_response']) && isset($resp['resource_response']['error']) && $resp['resource_response']['error'] != '') return print_r($resp['resource_response']['error'], true);
                    else return array("isPosted" => "1", "postID" => $resp['resource_response']['data']['id'], 'pDate' => date('Y-m-d H:i:s'), "postURL" => "http://www.pinterest.com/pin/" . $resp['resource_response']['data']['id']);
                }
            } elseif (stripos($contents, 'blocked this') !== false) {
                $retText = trim(str_replace(array("\r\n", "\r", "\n"), " | ", strip_tags(CutFromTo($contents, '</head>', '</body>'))));
                return "Pinterest ERROR: 'The Source is blocked'. Please see https://support.pinterest.com/entries/21436306-why-is-my-pin-or-site-blocked-for-spam-or-inappropriate-content/ for more info | Pinterest Message:" . $retText;
            } elseif (stripos($contents, 'image you tried to pin is too small') !== false) {
                $retText = trim(str_replace(array("\r\n", "\r", "\n"), " | ", strip_tags(CutFromTo($contents, '</head>', '</body>'))));
                return "Image you tried to pin is too small | Pinterest Message:" . $retText;
            } elseif (stripos($contents, 'CSRF verification failed') !== false) {
                $retText = trim(str_replace(array("\r\n", "\r", "\n"), " | ", strip_tags(CutFromTo($contents, '</head>', '</body>'))));
                return "CSRF verification failed - Please contact NextScripts Support | Pinterest Message:" . $retText;
            } elseif (stripos($contents, 'Oops') !== false && stripos($contents, '<body>') !== false) return 'Pinterest ERROR MESSAGE : ' . trim(str_replace(array("\r\n", "\r", "\n"), " | ", strip_tags(CutFromTo($contents, '</head>', '</body>'))));
            else return "Somethig is Wrong - Pinterest Returned Error 502";
        }
    }
}


//================================LinkedIn===========================================
if (!class_exists('nxsAPI_LI')) {
    class nxsAPI_LI
    {
        var $ck = array();
        var $debug = false;

        function headers($ref, $org = '', $type = 'GET', $aj = false)
        {
            $hdrsArr = array();
            $hdrsArr['Cache-Control'] = 'max-age=0';
            $hdrsArr['Connection'] = 'keep-alive';
            $hdrsArr['Referer'] = $ref;
            $hdrsArr['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.22 Safari/537.36';
            if ($type == 'JSON') $hdrsArr['Content-Type'] = 'application/json;charset=UTF-8'; elseif ($type == 'POST') $hdrsArr['Content-Type'] = 'application/x-www-form-urlencoded';
            if ($aj === true) $hdrsArr['X-Requested-With'] = 'XMLHttpRequest';
            if ($org != '') $hdrsArr['Origin'] = $org;
            if ($type == 'GET') $hdrsArr['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'; else $hdrsArr['Accept'] = '*/*';
            if (function_exists('gzdeflate')) $hdrsArr['Accept-Encoding'] = 'deflate,sdch';
            $hdrsArr['Accept-Language'] = 'en-US,en;q=0.8';
            return $hdrsArr;
        }

        function check()
        {
            $ck = $this->ck;
            if (!empty($ck) && is_array($ck)) {
                $hdrsArr = $this->headers('https://www.linkedin.com');
                if ($this->debug) echo "[LI] Checking....;<br/>\r\n";
                $rep = nxs_remote_get('http://www.linkedin.com/profile/edit?trk=tab_pro', array('headers' => $hdrsArr, 'timeout' => 45, 'httpversion' => '1.1', 'cookies' => $ck));
                if (is_nxs_error($rep)) return false;
                $ck = $rep['cookies'];
                $contents = $rep['body']; //if ($this->debug) prr($contents);
                return stripos($contents, 'href="/profile/edit?trk=nav_responsive_sub_nav_edit_profile"') !== false;
            } else return false;
        }

        function connect($u, $p)
        {
            $badOut = 'Error: ';
            //## Check if alrady IN
            if (!$this->check()) {
                if ($this->debug) echo "[LI] NO Saved Data;<br/>\r\n";
                $hdrsArr = $this->headers('https://www.linkedin.com');
                $rep = nxs_remote_get('https://www.linkedin.com/uas/login?goback=&trk=hb_signin', array('headers' => $hdrsArr, 'httpversion' => '1.1'));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR";
                    return $badOut;
                }
                $ck = $rep['cookies'];
                $contents = $rep['body'];
                //## GET HIDDEN FIELDS
                $md = array();
                $flds = array();
                $treeID = trim(CutFromTo($contents, 'name="treeID" content="', '"'));
                while (stripos($contents, '<input') !== false) {
                    $inpField = trim(CutFromTo($contents, '<input', '>'));
                    $name = trim(CutFromTo($inpField, 'name="', '"'));
                    if (stripos($inpField, '"hidden"') !== false && $name != '' && !in_array($name, $md)) {
                        $md[] = $name;
                        $val = trim(CutFromTo($inpField, 'value="', '"'));
                        $flds[$name] = $val;
                    }
                    $contents = substr($contents, stripos($contents, '<input') + 8);
                }
                $flds['session_key'] = $u;
                $flds['session_password'] = $p;
                $flds['signin'] = 'Sign%20In'; //$fldsTxt = build_http_query($flds); 
                //## ACTUAL LOGIN 
                $hdrsArr = $this->headers('https://www.linkedin.com/uas/login?goback=&trk=hb_signin', 'https://www.linkedin.com', 'POST', true);
                $hdrsArr['X-IsAJAXForm'] = '1';
                $hdrsArr['X-LinkedIn-traceDataContext'] = 'X-LI-ORIGIN-UUID=' . $treeID;
                $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds); // prr($advSet);
                $rep = nxs_remote_post('https://www.linkedin.com/uas/login-submit', $advSet);
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR";
                    return $badOut;
                }
                if ($rep['response']['code'] == '200') {
                    $content = $rep['body'];
                    if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                        $fdn = false;
                        foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                            $fdn = true;
                            $ck[$ci] = $ccN;
                        }
                        if (!$fdn) $ck[] = $ccN;
                    }
                    if (stripos($content, '"status":"ok"') !== false) {
                        if (stripos($content, 'redirectUrl') !== false) {
                            if ($this->debug) echo "[LI] Login REDIR;<br/>\r\n";
                            $content = str_ireplace('/uas/', 'https://www.linkedin.com/uas/', $content);
                            $rJson = json_decode($content, true);
                            if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                                $fdn = false;
                                foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                                    $fdn = true;
                                    $ck[$ci] = $ccN;
                                }
                                if (!$fdn) $ck[] = $ccN;
                            }
                            $hdrsArr = $this->headers('https://www.linkedin.com/uas/login-submit');
                            $rep = nxs_remote_get($rJson['redirectUrl'], array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
                            $content = $rep['body'];
                        } else {
                            if ($this->debug) echo "[LI] Login was OK;<br/>\r\n";
                            $this->ck = $ck;
                            return false;
                        }
                    }
                    if (stripos($content, 'ou have exceeded the maximum number of code requests') !== false) {
                        return "You have exceeded the maximum number of code requests. Please try again later.";
                    }
                    if (stripos($content, '"submitRequired":true') !== false) {
                        unset($hdrsArr['X-IsAJAXForm']);
                        unset($hdrsArr['X-LinkedIn-traceDataContext']);
                        unset($hdrsArr['X-Requested-With']);
                        $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds);
                        $rep = nxs_remote_post('https://www.linkedin.com/uas/login-submit', $advSet);
                        if (is_nxs_error($rep)) {
                            $badOut = print_r($rep, true) . " - ERROR";
                            return $badOut;
                        }
                        $content = $rep['body'];
                    }
                    if (stripos($content, 'name="PinVerificationForm_pinParam"') !== false) { //## Code             
                        $text = CutFromTo($content, '<div id="uas-consumer-ato-pin-challenge" class="two-step-verification">', '<script id="') . '</li></ul></form></div></div>';
                        $formcode = '<form ' . CutFromTo($content, '<div id="uas-consumer-ato-pin-challenge" class="two-step-verification">', '</form>');
                        while (stripos($formcode, '"hidden"') !== false) {
                            $formcode = substr($formcode, stripos($formcode, '"hidden"') + 8);
                            $name = trim(CutFromTo($formcode, 'name="', '"'));
                            if (!in_array($name, $md)) {
                                $md[] = $name;
                                $val = trim(CutFromTo($formcode, 'value="', '"'));
                                $flds[$name] = $val;
                            }
                        }
                        $flds['session_key'] = $u;
                        $flds['session_password'] = $p;
                        $flds['signin'] = 'Sign%20In'; // prr($flds); prr($nxs_gCookiesArr);               
                        $ser = array();
                        $ser['c'] = $ck;
                        $ser['f'] = $flds;
                        $seForDB = serialize($ser);
                        return array('out' => $text, 'ser' => $seForDB);
                    }
                    if (stripos($content, 'captcha recaptcha') !== false) {//## Captcha
                        $ca = nxs_remote_get('https://www.google.com/recaptcha/api/noscript?k=6LcnacMSAAAAADoIuYvLUHSNLXdgUcq-jjqjBo5n');
                        if (is_nxs_error($rep)) {
                            $badOut = print_r($rep, true) . " - [captcha] ERROR";
                            return $badOut;
                        }
                        $img = CutFromTo($ca['body'], 'src="image?c=', '"');
                        $formcode = '<form ' . CutFromTo($content, '<form action="https://www.linkedin.com/uas/captcha-submit" ', '</form>');
                        $formcode = str_ireplace('</iframe>', '', $formcode);
                        $formcode = str_ireplace('<iframe src="https://www.google.com/recaptcha/api/noscript?k=6LcnacMSAAAAADoIuYvLUHSNLXdgUcq-jjqjBo5n" height="300" width="500" frameborder="0">', $ca['body'], $formcode);
                        return array('cimg' => $img, 'ck' => $ck, 'formcode' => $formcode);
                    }
                    if (stripos($content, '"status":"fail"') !== false) {
                        if ($this->debug) echo "[LI] Login failed;<br/>\r\n";
                        $content = str_ireplace('href="/uas/', 'href="https://www.linkedin.com/uas/', $content);
                        $rJson = json_decode($content, true);
                        $badOut = "LOGIN ERROR: " . print_r($rJson, true);
                        return $badOut;
                    }
                    if (stripos($content, 'textarea name="postText"') !== false) {
                        if ($this->debug) echo "[LI] Login OK; Got Form; <br/>\r\n";
                        $this->ck = $ck;
                        return false;
                    }
                }
                return $badOut . print_r($rep, true);
            } else {
                if ($this->debug) echo "[LI] Saved Data is OK;<br/>\r\n";
                return false;
            }
        }

        function post($msg, $lnkArr, $to)
        {
            global $nxs_plurl;
            $postFormType = 0;
            $isGrp = false;
            $ck = $this->ck;
            $to = utf8_encode($to);
            $parts = parse_url($to);
            $to = $parts['scheme'] . '://' . $parts['host'] . str_replace('%2F', '/', urlencode($parts['path'])) . ((isset($parts['query']) && $parts['query'] != '') ? '?' . $parts['query'] : '');
            $to = str_replace('%25', '%', $to);
            $hdrsArr = $this->headers('https://www.linkedin.com/company/home?trk=nav_responsive_sub_nav_companies');
            $rep = nxs_remote_get($to, array('headers' => $hdrsArr, 'timeout' => 30, 'httpversion' => '1.1', 'cookies' => $ck));
            if ($this->debug) echo "[LI] Posting to: " . $to . "<br/>\r\n"; // prr($rep);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            if (!empty($rep['cookies'])) foreach ($rep['cookies'] as $ccN) {
                $fdn = false;
                foreach ($ck as $ci => $cc) if ($ccN->name == $cc->name) {
                    $fdn = true;
                    $ck[$ci] = $ccN;
                }
                if (!$fdn) $ck[] = $ccN;
            }
            $contents = $rep['body'];
            $contents = str_ireplace('https://www.linkedin.com', '', str_ireplace('http://www.linkedin.com', '', $contents));
            if (stripos($contents, '<form action="/share?submitPost="') !== false) $contents = CutFromTo($contents, '<form action="/share?submitPost="', '</form>');
            elseif (stripos($contents, '<form action="/nhome/submit-post"') !== false) {
                $contents = CutFromTo($contents, '<form action="/nhome/submit-post"', '</form>');
                $postFormType = 1;
            } elseif (stripos($contents, '<form action="/groups"') !== false) {
                $contents = CutFromTo($contents, '<form action="/groups"', '</form>');
                $postFormType = 2;
                $isGrp = true;
            } else {
                return "Error: No From. Not Logged In or No Posting Priviliges ";
            }
            //## GET HIDDEN FIELDS
            $md = array();
            $flds = array();
            while (stripos($contents, '<input') !== false) {
                $inpField = trim(CutFromTo($contents, '<input', '>'));
                $name = trim(CutFromTo($inpField, 'name="', '"'));
                if (stripos($inpField, '"hidden"') !== false && $name != '' && !in_array($name, $md)) {
                    $md[] = $name;
                    $val = trim(CutFromTo($inpField, 'value="', '"'));
                    $flds[$name] = $val;
                }
                $contents = substr($contents, stripos($contents, '<input') + 8);
            } //prr();
            $flds['contentImageCount'] = '2';
            $flds['contentImageIndex'] = '0';
            $flds['contentEntityID'] = ($postFormType > 0 ? 'ARTC_' : '') . '5681815750';
            $flds['ajax'] = 'true';
            $flds['postVisibility'] = 'EVERYONE';
            if (isset($lnkArr['img']) && $lnkArr['img'] != '') {
                $flds['contentImageIncluded'] = 'true';
                $flds['contentImage'] = $lnkArr['img'];
            }
            $flds['contentUrl'] = isset($lnkArr['url']) ? $lnkArr['url'] : '';
            $flds['contentTitle'] = isset($lnkArr['title']) ? strip_tags($lnkArr['title']) : '';
            $flds['contentSummary'] = isset($lnkArr['url']) ? $lnkArr['desc'] : '';
            $flds['postText'] = strip_tags($msg);
            if ($isGrp) $flds['postTitle'] = strip_tags($lnkArr['postTitle']);// prr($flds); die();
            if ($flds['csrfToken'] == 'delete me') {
                foreach ($ck as $c) if ($c->name == 'JSESSIONID') $flds['csrfToken'] = substr($c->value, 1, -1);
            }
            if ($postFormType == 0) $pURL = 'http://www.linkedin.com/share?submitPost='; elseif ($postFormType == 1) $pURL = 'http://www.linkedin.com/nhome/submit-post';
            else $pURL = 'http://www.linkedin.com/groups';
            //## POST
            $hdrsArr = $this->headers($to, 'http://www.linkedin.com', 'POST', true); // $hdrsArr['X-IsAJAXForm']='1'; 
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds); // prr($advSet);
            $rep = nxs_remote_post($pURL, $advSet);
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $contents = $rep['body']; //prr($rep);
            sleep(1);
            if ((!empty($rep['headers']['location']) && stripos($rep['headers']['location'], 'success=') !== false)) return array('isPosted' => '1', 'postID' => '', 'postURL' => $to, 'pDate' => date('Y-m-d H:i:s'));;
            if ((!empty($rep['headers']['location']) && stripos($rep['headers']['location'], 'failure=') !== false) || stripos($contents, 'formErrors') !== false) {
                return "Post Failure: " . CutFromTo($contents, '<formErrors>', '</formErrors>');
            }
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location'])) {
                $hdrsArr = $this->headers($pURL);
                $rep = nxs_remote_get($rep['headers']['location'], array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
                if (is_nxs_error($rep)) {
                    $badOut = print_r($rep, true) . " - ERROR";
                    return $badOut;
                } /* $ck = $rep['cookies']; */
                $contents = $rep['body'];
                sleep(1); // prr($rep);
            }
            if ($this->debug) prr($rep);
            if (stripos($contents, '<responseInfo>SUCCESS</responseInfo>') !== false) {
                $outURL = json_decode(str_replace('&quot;', '"', CutFromTo($contents, '<jsonPayLoad>', '</jsonPayLoad>')), true);
                if (!empty($outURL['isPremoderated']) && $outURL['isPremoderated'] == 'true') return array('isPosted' => '1', 'postID' => 'closedGroupNoID', 'postURL' => 'closedGroupNoURL', 'pDate' => date('Y-m-d H:i:s'));
                $outURL = $outURL['sharingUpdateUrl'];
                if (stripos($outURL, '_internal/mappers/shareUscpActivity') !== false && stripos($outURL, 'companyId') !== false && stripos($outURL, 'updateId') !== false) {
                    $hdrsArr = $this->headers('https://www.linkedin.com');
                    $outURL = str_replace('&amp;', '&', $outURL);
                    $repJS = nxs_remote_get($outURL, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck));
                    if (is_nxs_error($repJS)) {
                        $badOut = print_r($rep, true) . " - ERROR";
                        return $badOut;
                    }
                    $contents = $repJS['body'];
                    if (stripos($contents, '"link_permalink_url":"') !== false) $outURL = "https://www.linkedin.com" . CutFromTo($contents, '"link_permalink_url":"', '&goback=');
                }
                if ($outURL != '') return array('isPosted' => '1', 'postID' => $outURL, 'postURL' => $outURL, 'pDate' => date('Y-m-d H:i:s'));
            }
            if (stripos($contents, 'Request Error') !== false) {
                return "Post Failure: Request Error";
            }
            if (stripos($contents, '<responseInfo>FAILURE</responseInfo>') !== false) {
                return "Post Failure: " . CutFromTo($contents, '<responseMsg>', '</responseMsg>');
            }
            if (stripos($contents, '<responseInfo>') !== false) {
                return "Post Problem: " . CutFromTo($contents, '<responseMsg>', '</responseMsg>');
            }
            return false;
        }

    }
}
if (!function_exists("doConnectToLinkedIn")) {
    function doConnectToLinkedIn($email, $pass, $iidb)
    {
        global $nxs_plurl, $nxs_gCookiesArr, $plgn_NS_SNAutoPoster;
        if (isset($plgn_NS_SNAutoPoster)) {
            $options = $plgn_NS_SNAutoPoster->nxs_options;
            if (isset($options['li'][$iidb]['ck'])) $ck = maybe_unserialize($options['li'][$iidb]['ck']);
        }
        $li = new nxsAPI_LI();
        $li->debug = false;
        if (!empty($ck)) $li->ck = $ck;
        $li->iidb = $iidb;
        $loginErr = $li->connect($email, $pass);

        if (is_array($loginErr) && !empty($loginErr['out'])) {
            update_option('nxs_li_ctp_save', $loginErr['ser']);
            $text = $loginErr['out'];
            echo "LinkedIn asked you to enter verification code. Please check your email, enter the code and click \"Continue\"";
            $text = str_ireplace('This login attempt seems suspicious. ', '', $text);
            echo $text;
            echo '<br/><input type="hidden" id="nxsLiNum" name="nxsLiNum" value="' . $iidb . '" /><input type="button" value="Continue" onclick="doCtpSave(); return false;" id="results_ok_button" name="nxs_go" class="button" /><br/><br/>';
            ?>
            <script type="text/javascript"> function doCtpSave() {
                    var u = jQuery('#verification-code').val();
                    var ii = jQuery('#nxsLiNum').val(); //alert(ii);       
                    var style = "position: fixed; display: none; z-index: 1000; top: 50%; left: 50%; background-color: #E8E8E8; border: 1px solid #555; padding: 15px; width: 350px; min-height: 80px; margin-left: -175px; margin-top: -40px; text-align: center; vertical-align: middle;";
                    jQuery('body').append("<div id='test_results' style='" + style + "'></div>");
                    jQuery.post(ajaxurl, {
                        s: u,
                        i: ii,
                        action: 'nxsCptCheck',
                        id: 0,
                        _wpnonce: jQuery('input#getBoards_wpnonce').val()
                    }, function (j) {
                        jQuery('#test_results').html('<p> ' + j + '</p>' + '<input type="button" class="button" onclick="jQuery(\'#test_results\').hide();" name="results_ok_button" id="results_ok_button" value="OK" />');
                        jQuery('#test_results').show();
                    }, "html")
                }</script> <?php return '<br/>LinkedIn asked you to enter verification code<br/>';
        }
        if (is_array($loginErr) && !empty($loginErr['cimg'])) {
            $img = $loginErr['cimg'];
            $formcode = $loginErr['formcode'];
            $ck = $loginErr['ck'];
            $img = '<img style="display:block;" alt="reCAPTCHA challenge image" height="57" width="300" src="' . $nxs_plurl . 'inc-cl/li.php?ca=' . $img . '"/>';
            echo "LinkedIn asked you to enter Captcha. Please type the two words separated by a space (not case sensitive) and click \"Continue\"";
            echo $img;
            echo '<br/><input value="" style="width: 30%;" id="nxs_cpt_val" name="nxs_cpt" /><input type="hidden" id="nxsLiNum" name="nxsLiNum" value="' . $iidb . '" /><input type="button" value="Continue" onclick="doCtpSave(); return false;" id="results_ok_button" name="nxs_go" class="button" />'; ?>
            <script type="text/javascript">
                function doCtpSave() {
                    var u = jQuery('#nxs_cpt_val').val();
                    var ii = jQuery('#nxsLiNum').val(); //alert(ii);       
                    var style = "position: fixed; display: none; z-index: 1000; top: 50%; left: 50%; background-color: #E8E8E8; border: 1px solid #555; padding: 15px; width: 350px; min-height: 80px; margin-left: -175px; margin-top: -40px; text-align: center; vertical-align: middle;";
                    jQuery('body').append("<div id='test_results' style='" + style + "'></div>");
                    jQuery.post(ajaxurl, {
                        c: u,
                        i: ii,
                        action: 'nxsCptCheck',
                        id: 0,
                        _wpnonce: jQuery('input#getBoards_wpnonce').val()
                    }, function (j) {
                        jQuery('#test_results').html('<p> ' + j + '</p>' + '<input type="button" class="button" onclick="jQuery(\'#test_results\').hide();" name="results_ok_button" id="results_ok_button" value="OK" />');
                        jQuery('#test_results').show();
                    }, "html")
                }</script> <?php
            while (stripos($formcode, '"hidden"') !== false) {
                $formcode = substr($formcode, stripos($formcode, '"hidden"') + 8);
                $name = trim(CutFromTo($formcode, 'name="', '"'));
                $md = array();
                if (!in_array($name, $md)) {
                    $md[] = $name;
                    $val = trim(CutFromTo($formcode, 'value="', '"'));
                    $flds[$name] = $val;
                    $mids .= "&" . $name . "=" . $val;
                }
            } //$flds['session_key'] = $email; $flds['session_password'] = $pass;  $flds['signin'] = 'Sign%20In'; 
            $flds['session_key'] = $email;
            $flds['session_password'] = $pass;
            $flds['signin'] = 'Sign%20In'; // prr($flds); prr($nxs_gCookiesArr);
            $ser = array();
            $ser['c'] = $ck;
            $ser['f'] = $flds;
            $seForDB = serialize($ser);
            update_option('nxs_li_ctp_save', $seForDB);
            return '<br/>LinkedIn asked you to enter Captcha<br/>';
        }
        if (!$loginErr) {
            $nxs_gCookiesArr = $li->ck;
            if (!empty($options) && is_array($options)) {
                $options['li'][$iidb]['ck'] = $li->ck;
                update_option('NS_SNAutoPoster', $options);
                $plgn_NS_SNAutoPoster->nxs_options = $options;
            }
        }
        return $loginErr;
    }
}
if (!function_exists("doPostToLinkedIn")) {
    function doPostToLinkedIn($msg, $lnkArr, $to)
    {
        global $nxs_gCookiesArr;
        $li = new nxsAPI_LI();
        $li->debug = false;
        if (!empty($nxs_gCookiesArr)) $li->ck = $nxs_gCookiesArr;
        $ret = $li->post($msg, $lnkArr, $to); // prr($ret);
        if (is_array($ret) && !empty($ret['isPosted'])) return '<update-url>' . $ret['postURL'] . '</update-url>'; else return $ret;
    }
}
//================================vKontakte===========================================
if (!function_exists("nxs_doCheckVK")) {
    function nxs_doCheckVK()
    {
        global $nxs_vkCkArray;
        $hdrsArr = nxs_getVKHeaders('https://vk.com/login.php');
        $ckArr = $nxs_vkCkArray;
        $response = wp_remote_get('https://vk.com/settings', array('method' => 'GET', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
        if (isset($response['headers']['location']) && stripos($response['headers']['location'], 'login.php') !== false) return 'Bad Saved Login';
        if ($response['response']['code'] == '200' && stripos($response['body'], 'settings_new_pwd') !== false) {
            /*echo "You are IN"; */
            return false;
        } else return 'No Saved Login';
        return false;
    }
}
if (!function_exists("nxs_doConnectToVK")) {
    function nxs_doConnectToVK($u, $p, $ph = '')
    {
        global $nxs_vkCkArray;
        $hdrsArr = nxs_getVKHeaders('http://vk.com/login.php');
        $mids = ''; //echo "LOG=";
        $response = wp_remote_get('http://vk.com/login.php', array('method' => 'POST', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr));
        if (is_nxs_error($response)) {
            $badOut = "Connection Error 1: " . print_r($response, true);
            return $badOut;
        }
        $contents = $response['body'];
        $ckArr = $response['cookies'];
        $hdrsArr = nxs_getVKHeaders('http://vk.com/login.php', true);
        $frmTxt = CutFromTo($contents, 'action="https://login.vk.com/', '</form>');
        $md = array();
        $flds = array();
        while (stripos($frmTxt, '<input') !== false) {
            $inpField = trim(CutFromTo($frmTxt, '<input', '>'));
            $name = trim(CutFromTo($inpField, 'name="', '"'));
            if (stripos($inpField, '"hidden"') !== false && $name != '' && !in_array($name, $md)) {
                $md[] = $name;
                $val = trim(CutFromTo($inpField, 'value="', '"'));
                $flds[$name] = $val;
                $mids .= "&" . $name . "=" . $val;
            }
            $frmTxt = substr($frmTxt, stripos($frmTxt, '<input') + 8);
        }
        $flds['email'] = $u;
        $flds['pass'] = $p;
        $r2 = wp_remote_post('https://login.vk.com/', array('method' => 'POST', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'body' => $flds, 'cookies' => $ckArr));
        if (is_nxs_error($r2)) {
            $badOut = "Connection Error 2: " . print_r($r2, true);
            return $badOut;
        }
        $ckArr = nxsMergeArraysOV($ckArr, $r2['cookies']);
        if ($r2['response']['code'] == '302' && $r2['headers']['location'] != '') $response = wp_remote_get($r2['headers']['location'], array('timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
        if (is_nxs_error($response)) {
            $badOut = "Connection Error 3: " . print_r($response, true);
            return $badOut;
        }
        if ($response['response']['code'] == '200' && $response['body'] != '' && stripos($response['body'], 'message_text"') !== false) {
            $txt = CutFromTo($response['body'], 'message_text"', '<ul');
            return trim(strip_tags($txt));
        }
        if ($response['response']['code'] == '302' && $response['headers']['location'] == '/') {
            $ckArr = nxsMergeArraysOV($ckArr, $response['cookies']);
            $nxs_vkCkArray = $ckArr;
            $hdrsArr = nxs_getVKHeaders('http://vk.com/');
            $response = wp_remote_get('http://vk.com/', array('redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
            if (is_nxs_error($response)) {
                $badOut = "Connection Error 4: " . print_r($response, true);
                return $badOut;
            }
            if ($response['response']['code'] == '302' && $response['headers']['location'] == '/login.php?act=security_check&to=&al_page=3') { //## PH Ver
                $hdrsArr = nxs_getVKHeaders('http://vk.com/');
                $response = wp_remote_get('http://vk.com/login.php?act=security_check&to=&al_page=3', array('redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
                if (is_nxs_error($response)) {
                    $badOut = "Connection Error 5: " . print_r($response, true);
                    return $badOut;
                }
                $txt = $response['body'];
                if ($ph == '') {
                    $txtF = CutFromTo($txt, 'form_table', '</tr>');
                    $ph1 = trim(CutFromTo($txtF, 'label ta_r">', '</div>'));
                    $ph2 = trim(CutFromTo($txtF, 'phone_postfix">', '</span>'));
                    return "Phone verification required: " . $ph1 . " ... " . $ph2;
                } else {
                    $hash = CutFromTo($txt, "al_page: '3', hash: '", "'");
                    $flds = array('act' => 'security_check', 'code' => $ph, 'to' => '', 'al' => '1', 'al_page' => '3', 'hash' => $hash);
                    $hdrsArr = nxs_getVKHeaders('http://vk.com/login.php?act=security_check&to=&al_page=3', true, true);
                    $response = wp_remote_post('http://vk.com/login.php', array('redirection' => 0, 'body' => $flds, 'headers' => $hdrsArr, 'cookies' => $ckArr));
                    if (is_nxs_error($response)) {
                        $badOut = "Connection Error 6: " . print_r($response, true);
                        return $badOut;
                    }
                    if ($response['response']['code'] == '200' && $response['body'] != '' && stripos($response['body'], '4 hours') !== false) return "Invalid Phone verification number. You can try again in 4 hours";
                    if ($response['response']['code'] == '200' && $response['body'] != '' && stripos($response['body'], 'incorrect') !== false) return "Invalid Phone verification number.";
                    $hdrsArr = nxs_getVKHeaders('http://vk.com/');
                    $response = wp_remote_get('http://vk.com/', array('redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
                    if (is_nxs_error($response)) {
                        $badOut = "Connection Error 7: " . print_r($response, true);
                        return $badOut;
                    }
                    if ($response['response']['code'] == '302' && $response['headers']['location'] == '/login.php?act=security_check&to=&al_page=3') return "Invalid verification number"; else {
                        $ckArr = nxsMergeArraysOV($ckArr, $response['cookies']);
                        $nxs_vkCkArray = $ckArr;
                        return false;
                    }
                }
            } else return false;
        } elseif (isset($response['_reason'])) {
            return $response['_reason'];
        } else return "UNKNOWN ERROR. Please contact support." . print_r($response, true);
    }
}
if (!function_exists("nxs_doPostToVK")) {
    function nxs_doPostToVK($msg, $where, $msgOpts)
    {
        global $nxs_vkCkArray;
        $hdrsArr = nxs_getVKHeaders($where);
        $ckArr = $nxs_vkCkArray;
        $response = wp_remote_get($where, array('method' => 'GET', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr));
        $ckArr2 = nxs_MergeCookieArr($ckArr, $response['cookies']);
        $contents = $response['body'];
        if (stripos($contents, '"post_hash":"') !== false) $hash = CutFromTo($contents, '"post_hash":"', '"');
        if (stripos($contents, '"timehash":"') !== false) $timeHash = CutFromTo($contents, '"timehash":"', '"');
        if (stripos($contents, '"rhash":"') !== false) $rHash = CutFromTo($contents, '"rhash":"', '"');
        if (stripos($contents, '"public_id":') !== false) {
            $postTo = '-' . CutFromTo($contents, '"public_id":', ',');
            $type = 'all';
        }
        if (stripos($contents, '"user_id":') !== false) {
            $postTo = CutFromTo($contents, '"user_id":', ',');
            $type = 'own';
        }
        if (stripos($contents, '"group_id":') !== false) {
            $postTo = '-' . CutFromTo($contents, '"group_id":', ',');
            $type = 'all';
        }
        if (stripos($contents, '"id":') !== false) $uid = CutFromTo($contents, '"id":', ',');
        $flds = array('Message' => strip_tags($msg), 'act' => 'post', 'al' => 1, 'facebook_export' => '', 'fixed' => '', 'friends_only' => '', 'from' => '', 'hash' => $hash, 'official' => '', 'signed' => '', 'status_export' => '', 'to_id' => $postTo, 'type' => $type);
        if ($msgOpts['type'] == 'A' && $msgOpts['url'] != '') {
            $flds2 = array();
            $flds2['url'] = $msgOpts['url'];
            $flds2['act'] = 'a_photo';
            $flds2['image'] = $msgOpts['imgURL'];
            if (empty($msgOpts['vID'])) {
                $flds2['index'] = '4';
                $flds2['extra'] = '0';
            } else {
                $flds['extra'] = '21';
                $flds['extra_data'] = $msgOpts['vID'];
                $flds2['extra'] = '21';
                $flds2['index'] = '1';
            }
            $hdrsArrP = nxs_getVKHeaders($where, true); //    prr($hdrsArrP); prr($flds2); //  prr($ckArr);
            $r3 = wp_remote_post('http://vk.com/share.php', array('method' => 'POST', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArrP, 'body' => $flds2, 'cookies' => $ckArr));
            $errMsg = utf8_encode(strip_tags($r3['body'])); //prr($r3);
            if ((stripos($r3['body'], 'photo_id:') !== false)) {
                $attchID = trim(CutFromTo($r3['body'], 'user_id:', ',')) . "_" . trim(CutFromTo($r3['body'], 'photo_id:', '}'));
            } else {
                if (($r3['response']['code'] == '302' || $r3['response']['code'] == '303') && $r3['headers']['location'] != '') $r4 = wp_remote_get($r3['headers']['location'], array('timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ckArr2)); else return "ERROR: R3" . print_r($r3, true);
                $hdrsArr2 = nxs_getVKHeaders($r3['headers']['location']);
                $ckArr2 = nxs_MergeCookieArr($ckArr, $r4['cookies']);
                if (($r4['response']['code'] == '302' | $r4['response']['code'] == '303') && $r4['headers']['location'] != '') $r5 = wp_remote_get($r4['headers']['location'], array('timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr2, 'cookies' => $ckArr2)); else return "ERROR: R4" . print_r($r3, true);
                if (stripos($r5['body'], '"photo_id"') !== false) {
                    $attchID = trim(CutFromTo($r5['body'], '"user_id":', ',')) . "_" . trim(CutFromTo($r5['body'], '"photo_id":', '}'));
                }
            }   // prr($r5);
            $flds['attach1'] = $attchID;
            $flds['attach1_type'] = 'share';
            $flds['description'] = $msgOpts['urlDesc'];
            $flds['photo_url'] = ($msgOpts['imgURL']);
            $flds['title'] = $msgOpts['urlTitle'];
            $flds['url'] = $msgOpts['url'];
            $flds['official'] = 1;
        }
        $hdrsArr = nxs_getVKHeaders($where, true, true); // prr($hdrsArr);    prr($flds);
        $r2 = wp_remote_post('http://vk.com/al_wall.php', array('method' => 'POST', 'timeout' => 45, 'httpversion' => '1.1', 'redirection' => 0, 'headers' => $hdrsArr, 'body' => $flds, 'cookies' => $ckArr));
        if (stripos($r2['body'], 'page_wall_count_own') !== false && stripos($r2['body'], 'div id="post') !== false) {
            $pid = CutFromTo($r2['body'], 'div id="post', '"');
            return array("code" => "OK", "post_id" => $pid);
        } else {
            $errMsg = utf8_encode(strip_tags($r2['body']));
            return "ERROR: " . print_r($errMsg, true);
        }
    }
}
//================================Reddit===========================================
if (!function_exists("doConnectToRD")) {
    function doConnectToRD($unm, $pass)
    {
        $url = "http://www.reddit.com/api/login/" . $unm;
        $hdrsArr = '';
        global $nxs_gRDSubreddits;
        $flds = array('api_type' => 'json', 'user' => $unm, 'passwd' => $pass);
        $response = wp_remote_post($url, array('method' => 'POST', 'timeout' => 45, 'redirection' => 0, 'headers' => $hdrsArr, 'body' => $flds));
        if (is_wp_error($response)) {
            $badOut = print_r($response, true) . " - ERROR";
            return $badOut;
        }
        $ck = $response['cookies'];
        $response = json_decode($response['body'], true); // prr($response);
        if (is_array($response['json']['errors']) && count($response['json']['errors']) > 0) {
            $badOut = print_r($response, true) . " - ERROR";
            return $badOut;
        }
        $data = $response['json']['data'];
        $mh = $data['modhash'];
        $response = wp_remote_get('http://www.reddit.com/subreddits/mine/moderator/', array('redirection' => 0, 'headers' => $hdrsArr, 'cookies' => $ck));
        $cnt = $response['body'];
        $cnt = CutFromTo($cnt, '<div id="siteTable"', '<div class="footer-parent">');
        $srds = '';
        $cntArr = explode('<p class="titlerow">', $cnt);
        foreach ($cntArr as $txt) if (stripos($txt, 'class="title"') !== false) {
            $bid = CutFromTo($txt, 'href="http://www.reddit.com/r/', '/"');
            $bname = trim(CutFromTo($txt, 'class="title" >', '</a>'));
            if (isset($bid)) $srds .= '<option value="' . $bid . '">' . trim($bname) . '</option>';
        }
        $nxs_gRDSubreddits = $srds;
        return array('mh' => $mh, 'ck' => $ck);
    }
}
if (!function_exists("doGetSubredditsFromRD")) {
    function doGetSubredditsFromRD()
    {
        global $nxs_gRDSubreddits;
        return $nxs_gRDSubreddits;
    }
}
//================================Flipboard===========================================
if (!function_exists("doCheckFlipboard")) {
    function doCheckFlipboard($ck)
    {
        $hdrsArr = nxs_getFPHeaders('https://editor.flipboard.com/');
        $rep = wp_remote_get('https://editor.flipboard.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
        if (is_wp_error($rep)) return false;
        if (stripos($rep['body'], '<a href="/account">') !== false) {
            $mh = trim(strip_tags(CutFromTo($rep['body'], '<a href="/account">', '</a>')));
            return $mh;
        } else return false;
    }
}
if (!function_exists("doConnectToFlipboard")) {
    function doConnectToFlipboard($unm, $pass)
    {
        $url = "https://editor.flipboard.com/u/login/";
        $hdrsArr = nxs_getFPHeaders('https://editor.flipboard.com/u/login');
        $rep = wp_remote_get($url, array('headers' => $hdrsArr, 'httpversion' => '1.1'));
        if (is_wp_error($rep)) {
            $badOut = print_r($rep, true) . " - =1= ERROR";
            return $badOut;
        }
        $ck = $rep['cookies'];
        $rTok = CutFromTo($rep['body'], 'name="_csrf" value="', '"');
        $rTok = str_replace('&#x2f;', '/', $rTok);
        $hdrsArr = nxs_getFPHeaders('https://editor.flipboard.com/u/login?done=%2F', '', true);
        $flds = array('username' => $unm, 'password' => $pass, 'done' => '/', '_csrf' => $rTok);
        $response = wp_remote_post($url, array('method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'headers' => $hdrsArr, 'body' => $flds));
        if (is_wp_error($response)) {
            $badOut = print_r($response, true) . " - ERROR";
            return $badOut;
        }
        $ck = $response['cookies'];
        if (!empty($response['body']) && stripos($response['body'], 'id="errormessage"') !== false) {
            $errMsg = CutFromTo($response['body'], 'id="errormessage"', '/p>');
            $errMsg = CutFromTo($errMsg, '>', '<');
            return $errMsg;
        }
        if (isset($response['headers']['location']) && ($response['headers']['location'] == 'https://editor.flipboard.com/' || $response['headers']['location'] == '/')) {
            $hdrsArr = nxs_getFPHeaders('https://editor.flipboard.com/');
            $rep = wp_remote_get('https://editor.flipboard.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
            if (is_wp_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $mh = trim(strip_tags(CutFromTo($rep['body'], '<a href="/account">', '</a>')));
            return array('mh' => $mh, 'ck' => $ck);
        } else  $badOut = print_r($response, true) . " - ERROR";
        return $badOut;
    }
}
if (!function_exists("doPostToFlipboard")) {
    function doPostToFlipboard($ck, $post)
    {
        $hdrsArr = nxs_getFPHeaders('https://editor.flipboard.com/');
        $badOut = array();
        $rep = wp_remote_get('https://share.flipboard.com/bookmarklet/popout?v=2&title=&url=' . urlencode($post['url']) . '&t=', array('headers' => $hdrsArr, 'cookies' => $ck, 'httpversion' => '1.1'));
        if (is_wp_error($rep)) {
            $badOut = print_r($rep, true) . " - ERROR";
            return $badOut;
        }
        $rTok = CutFromTo($rep['body'], 'id="fl-csrf">&quot;', '&quot;');
        $rTok = str_replace('&#x2f;', '/', $rTok);
        if (empty($rTok)) return "Error: " . strip_tags($rep['body']);
        $flds = array("url" => $post['url'], "_csrf" => $rTok);
        $flds = json_encode($flds);
        $hdrsArr = nxs_getFPHeaders('https://share.flipboard.com/bookmarklet/popout', 'https://share.flipboard.com', 'j');
        $response = wp_remote_post('https://share.flipboard.com/bookmarklet/flip', array('method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'headers' => $hdrsArr, 'body' => $flds));
        if (is_wp_error($rep)) {
            $badOut = print_r($rep, true) . " - ERROR";
            return $badOut;
        }
        if (stripos($response['body'], '"success":true') !== false) {
            $txtArr = json_decode($response['body'], true);
            $mgzURL = $post['mgzURL'];
            $mgzURL = 'flipboard/mag-' . str_replace('-', '%252D', urldecode(CutFromTo($mgzURL . "|||", 'magazine%252F', '|||')));
            $sccID = $post['mgzURL'];
            $sccID = urldecode(CutFromTo($sccID . "|||", 'section?sections=', '|||'));
            $flds = array("url" => $post['url'], "sig" => $txtArr['sig'], "image" => $post['imgURL'], "price" => null, "currency" => '$', "title" => '', "text" => $post['text'], "target" => $mgzURL, "services" => "", "_csrf" => $rTok); // prr($flds);
            $flds = json_encode($flds);
            $flds = str_replace('\/', '/', $flds);
            $hdrsArr = nxs_getFPHeaders('https://share.flipboard.com/bookmarklet/popout', 'https://share.flipboard.com', 'j');
            $response = wp_remote_post('https://share.flipboard.com/bookmarklet/save', array('method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'headers' => $hdrsArr, 'body' => $flds));
            if (stripos($response['body'], '"success":true') !== false) {
                $flds = array("sectionid" => $sccID, "title" => '', "imageURL" => $post['imgURL'], "_csrf" => $rTok);
                $flds = json_encode($flds);
                $flds = str_replace('\/', '/', $flds);
                $resp2 = wp_remote_post('https://share.flipboard.com/v1/social/shortenSection', array('method' => 'POST', 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'headers' => $hdrsArr, 'body' => $flds));
                $respLink = json_decode($resp2['body'], true);
                $respLink = $respLink['result'];
                $respID = str_replace('http://flip.it/', '', $respLink);
                return array('postID' => $respID, 'isPosted' => 1, 'postURL' => $respLink, 'pDate' => date('Y-m-d H:i:s'), 'ck' => $ck);
            } else {
                $badOut['Error'] .= print_r($response, true);
                return $badOut;
            }
        } else return "Error: " . strip_tags($response['body']);
    }
}
?>