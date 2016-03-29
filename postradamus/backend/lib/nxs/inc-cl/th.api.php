<?php
//## NextScripts Flipboard Connection Class

/* 
1. Options

nName - Nickname of the account [Optional] (Presentation purposes only - No affect on functionality)
rdUName - Reddit User Name
rdPass - Reddit User Passord
rdSubReddit - Name of the Sub-Reddit
postType - A or T - "Attached link" or "Text"

rdTitleFormat
rdTextFormat

2. Post Info

url
title - [up to 300 characters long] - title of the submission
text

*/
$nxs_snapAPINts[] = array('code' => 'TH', 'lcode' => 'th', 'name' => 'Thoughts');

if (!function_exists("nxs_getTHHeaders")) {
    function nxs_getTHHeaders($ref, $org = '', $post = false, $aj = false)
    {
        $hdrsArr = array();
        $hdrsArr['Cache-Control'] = 'max-age=0';
        $hdrsArr['Connection'] = 'keep-alive';
        $hdrsArr['Referer'] = $ref;
        $hdrsArr['User-Agent'] = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.22 Safari/537.36';
        if ($post === 'j') $hdrsArr['Content-Type'] = 'application/json;charset=UTF-8'; elseif ($post === true) $hdrsArr['Content-Type'] = 'application/x-www-form-urlencoded';
        if ($aj === true) $hdrsArr['X-Requested-With'] = 'XMLHttpRequest';
        if ($org != '') $hdrsArr['Origin'] = $org;
        $hdrsArr['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';// $hdrsArr['DNT']='1';
        if (function_exists('gzdeflate')) $hdrsArr['Accept-Encoding'] = 'gzip,deflate,sdch';
        $hdrsArr['Accept-Language'] = 'en-US,en;q=0.8';
        return $hdrsArr;
    }
}

if (!function_exists("doPostToThoughts")) {
    function doPostToThoughts()
    {
    }
}

if (!class_exists('nxsAPI_TH')) {
    class nxsAPI_TH
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
            if (function_exists('gzdeflate')) $hdrsArr['Accept-Encoding'] = 'gzip,deflate,sdch';
            $hdrsArr['Accept-Language'] = 'en-US,en;q=0.8';
            return $hdrsArr;
        }

        function check()
        {
            $ck = $this->ck;
            if (!empty($ck) && is_array($ck)) {
                $hdrsArr = $this->headers('https://thoughts.com');
                if ($this->debug) echo "[TH] Checking....;<br/>\r\n";
                $rep = nxs_remote_get('http://thoughts.com/dashboard/myprofile', array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
                if (is_nxs_error($rep)) return false;
                $ck = $rep['cookies'];
                $contents = $rep['body']; //if ($this->debug) prr($contents);
                return stripos($contents, 'id="logOut"') !== false;
            } else return false;
        }

        function connect($u, $p)
        {
            $badOut = 'Error: ';
            //## Check if alrady IN
            if (!$this->check()) {
                if ($this->debug) echo "[TH] NO Saved Data;<br/>\r\n";
                $hdrsArr = $this->headers('http://thoughts.com/');
                $rep = nxs_remote_get('http://thoughts.com/', array('headers' => $hdrsArr, 'httpversion' => '1.1'));
                if (is_nxs_error($rep)) {
                    $badOut = "ERROR (Login Form): " . print_r($rep, true);
                    return $badOut;
                }
                if ($rep['response']['code'] != '200') {
                    $badOut = "ERROR (Login Form): " . print_r($rep, true);
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
                $flds['user[login]'] = $u;
                $flds['user[password]'] = $p;
                $flds['commit'] = 'Sign+in'; //$fldsTxt = build_http_query($flds);
                //## ACTUAL LOGIN
                $hdrsArr = $this->headers('http://thoughts.com', 'http://thoughts.com', 'POST');
                $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds);
                prr($advSet);
                $rep = nxs_remote_post('http://thoughts.com/users/sign_in', $advSet);
                if (is_nxs_error($rep)) {
                    $badOut = "ERROR (Login Submit): " . print_r($rep, true);
                    return $badOut;
                }
                if ($rep['response']['code'] == '302' && !empty($rep['headers']['location']) && $rep['headers']['location'] == 'http://thoughts.com/dashboard') {
                    if ($this->debug) echo "[LI] Login was OK;<br/>\r\n";
                    $ck = $rep['cookies'];
                    $this->ck = $ck;
                    return false;
                }
                if ($rep['response']['code'] == '200') {
                    $content = $rep['body'];
                    if (stripos($content, 'data-dismiss="alert">�</') !== false) $msg = trim(CutFromTo($contents, 'data-dismiss="alert">�</a>', '</div'));
                    return $msg;
                }
                return "ERROR (Login): " . $badOut . print_r($rep, true);
            } else {
                if ($this->debug) echo "[TH] Saved Data is OK;<br/>\r\n";
                return false;
            }
        }

        function post($post)
        {
            $ck = $this->ck;
            $postType = $post['postType'];
            $pURL = 'http://' . $post['toURL'] . '.thoughts.com/post/';
            switch ($postType) {
                case 'I':
                    $pURL .= 'photo';
                    $bpt = 'i';
                    break;
                case 'A':
                    $pURL .= 'link';
                    $bpt = 'l';
                    break;
                default:
                    $pURL .= 'text';
                    $bpt = 't';
            }
            $hdrsArr = $this->headers('http://' . $post['toURL'] . '.thoughts.com');
            $rep = nxs_remote_get($pURL, array('headers' => $hdrsArr, 'httpversion' => '1.1', 'cookies' => $ck));
            if ($this->debug) echo "[TH] Posting to: " . $pURL . "<br/>\r\n";
            if (is_nxs_error($rep)) {
                $badOut = print_r($rep, true) . " - ERROR";
                return $badOut;
            }
            $ck = $rep['cookies'];
            $contents = $rep['body'];
            if (stripos($contents, '<div class="editor-wrap') !== false) $contents = CutFromTo($contents, '<div class="editor-wrap', '</form>'); else {
                return "Error: No From. Not Logged In or No Posting Priviliges ";
            }
            //## GET HIDDEN FIELDS
            $md = array();
            $flds = array();
            $inpTime = trim(CutFromTo($contents, '<select id="post-publish-time"', '</select>'));
            $inpTime = trim(CutFromTo($inpTime, '<option value="', '"'));
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
            $flds['post[title]'] = $post['title'];
            $flds['post[body]'] = $post['text'];
            $flds['post[topic_list]'] = $post['tags'];
            $flds['post[publish_time]'] = $inpTime;
            $flds['post[blog_id]'] = $flds['blog_id'];
            $flds['post[privacy]'] = 'o';
            $flds['post[allow_repost]'] = 'true';
            $flds['post[post_type]'] = $bpt;
            $flds['subdomain'] = $post['toURL'];
            //## POST
            $hdrsArr = $this->headers($pURL, 'http://' . $post['toURL'] . '.thoughts.com', 'POST');
            $advSet = array('headers' => $hdrsArr, 'httpversion' => '1.1', 'timeout' => 45, 'redirection' => 0, 'cookies' => $ck, 'body' => $flds);
            prr($advSet);
            $rep = nxs_remote_post('http://' . $post['toURL'] . '.thoughts.com/posts/create', $advSet);
            if (is_nxs_error($rep)) {
                $badOut = "ERROR (Post Post):" . print_r($rep, true);
                return $badOut;
            }
            $contents = $rep['body'];
            if ($rep['response']['code'] == '302' && !empty($rep['headers']['location'])) {
                return array("code" => "OK", "post_id" => trim(CutFromTo('thoughts.com/posts/', '||||', $rep['headers']['location'] . "||||")), "post_url" => $rep['headers']['location']);
            }
            return 'Error: ' . print_r($rep, true);
        }
    }
}

if (!class_exists("nxs_class_SNAP_TH")) {
    class nxs_class_SNAP_TH
    {

        var $ntCode = 'TH';
        var $ntLCode = 'th';

        function createFile($imgURL)
        {
            $remImgURL = urldecode($imgURL);
            $urlParced = pathinfo($remImgURL);
            $remImgURLFilename = $urlParced['basename'];
            $imgData = wp_remote_get($remImgURL);
            if (is_wp_error($imgData)) {
                $badOut['Error'] = print_r($imgData, true) . " - ERROR";
                return $badOut;
            }
            $imgData = $imgData['body'];
            $tmp = array_search('uri', @array_flip(stream_get_meta_data($GLOBALS[mt_rand()] = tmpfile())));
            if (!is_writable($tmp)) return "Your temporary folder or file (file - " . $tmp . ") is not witable. Can't upload images to Flickr";
            rename($tmp, $tmp .= '.png');
            register_shutdown_function(create_function('', "unlink('{$tmp}');"));
            file_put_contents($tmp, $imgData);
            if (!$tmp) return 'You must specify a path to a file';
            if (!file_exists($tmp)) return 'File path specified does not exist';
            if (!is_readable($tmp)) return 'File path specified is not readable';
            //  $data['name'] = basename($tmp);
            return "@$tmp";

        }

        function doPost($options, $message)
        {
            if (!is_array($options)) return false;
            $out = array(); // return false;
            foreach ($options as $ii => $ntOpts) $out[$ii] = $this->doPostToNT($ntOpts, $message);
            return $out;
        }

        function doPostToNT($options, $message)
        {
            global $nxs_urlLen;
            $badOut = array('pgID' => '', 'isPosted' => 0, 'pDate' => date('Y-m-d H:i:s'), 'Error' => '');
            //## Check settings
            if (!is_array($options)) {
                $badOut['Error'] = 'No Options';
                return $badOut;
            }
            if (!isset($options['uPass']) || trim($options['uPass']) == '') {
                $badOut['Error'] = 'Not Authorized';
                return $badOut;
            }
            if (empty($options['imgSize'])) $options['imgSize'] = '';
            //## Format Post
            if (!empty($message['pText'])) $text = $message['pText']; else $text = nxs_doFormatMsg($options['msgFrmt'], $message);
            if (!empty($message['pTitle'])) $msgT = $message['pTitle']; else $msgT = nxs_doFormatMsg($options['msgTFrmt'], $message);
            //## Make Post
            if (isset($message['imageURL'])) $imgURL = trim(nxs_getImgfrOpt($message['imageURL'], $options['imgSize'])); else $imgURL = '';
            //## Make Post
            if (!empty($options['ck'])) $ck = maybe_unserialize($options['ck']);
            $pass = substr($options['uPass'], 0, 5) == 'n5g9a' ? nsx_doDecode(substr($options['uPass'], 5)) : $options['uPass'];
            $nt = new nxsAPI_TH();
            $nt->debug = true;
            if (!empty($ck)) $nt->ck = $ck;
            $loginErr = $nt->connect($options['uName'], $pass);
            if (!$loginErr) {
                $post = array('url' => $message['url'], 'toURL' => $options['mgzURL'], 'imgURL' => $imgURL, 'title' => $msgT, 'text' => $text, 'postType' => $options['postType']);
                $ret = $nt->post($post);
                if (is_array($ret)) {
                    $ret['ck'] = $nt->ck;
                    return $ret;
                } else return print_r($ret, true);
            } else return print_r($loginErr, true);
        }
    }
}
?>