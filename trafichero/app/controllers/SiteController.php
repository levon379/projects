<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SiteController extends BaseController {

    public function updateSiteById($id) {

        $validator = Validator::make(
                        array(
                    'name' => Input::get('name'),
                    'main_url' => Input::get('main_url')
                        ), array(
                    'name' => 'required|min:2|max:55|unique:piwik_site,name,' . $id . ',idsite',
                    'main_url' => 'required|min:2|max:85|url|unique:piwik_site,main_url,' . $id . ',idsite'
                        )
        );
        if ($validator->fails()) {
            return Redirect::route('sitelist')->withErrors($validator)->withInput()->with('editable', $id);
        } else {
            $data = Input::all();
            unset($data["_token"]);
            $edited_site = Sites::updateSiteById($id, $data);
            if ($edited_site) {
                return Redirect::route('sitelist');
            } else {
                return Redirect::route('sitelist');
            }
        }
    }

    public function deleteSiteById($id) {
        Sites::deleteSiteById($id);
        return Redirect::route('sitelist');
    }

    public function getData($site_id = 0,$post = false) {
        $data = Input::all();
        if (isset($data['site_id'])) {
            $site_id = $data['site_id'];
        }
        $return_data = array();
        $data = SiteSettings::getDataLastDay($site_id);
        $count = count($data['result']) / 24;
        if ($count > 20) {
            $return_data = $data['result'];
        } else {
            $return_data = SiteSettings::getDataAll($site_id);
        }
        $return_data = array_slice($return_data, 0, 200);
        // print_r($return_data);die;
        $cur_ts = microtime(true);
        for ($i = 0; $i < count($return_data); $i ++) {
            $return_data[$i]['url'] = urldecode($return_data[$i]['url']);
            $return_data[$i]['action_name'] = urldecode($return_data[$i]['action_name']);
            $return_data[$i]['urlref'] = urldecode($return_data[$i]['urlref']);
            $return_data[$i]['link'] = urldecode($return_data[$i]['link']);
            $return_data[$i]['date_in'] = date("Y-m-d H:i:s", (int)$return_data[$i]['_viewts']);
            $browser = $this->getBrowser($return_data[$i]['ua']);
            $return_data[$i]['sity'] = $return_data[$i]['city'];
            $return_data[$i]['browser'] = $browser;

            $just_url = explode('?', $return_data[$i]['url']);
            $just_url = $just_url[0];
            $return_data[$i]['just_url'] = $just_url;

            $view_ts = (int) $return_data[$i]['_viewts'];
            $srv_time = (int) $return_data[$i]['srv_time'];
            if (($cur_ts - $srv_time) < 30) {
                $activity = "active";
            } elseif ((($cur_ts - $srv_time) >= 30) && (($cur_ts - $srv_time) < 300)) {
                $activity = "inactive";
            } elseif (($cur_ts - $srv_time) >= 300) {
                $activity = "out";
            }
            $return_data[$i]['activity'] = $activity;

            $country = $return_data[$i]['country'];
            $country = $this->getCountry($country);
            $return_data[$i]['country'] = $country;
        }
       
        $array = array();
        
        if($post)
        {
            //map data
            foreach ($return_data as $value) {
                $array[$value['country']]['name'] = $value['country'];
                $array[$value['country']]['year'] = date("Y-m-d H:i:s",$value['_viewts']);
                $array[$value['country']]['value'] = count($array);
              
            }
             
        }else{
            foreach ($return_data as $value) {
                $array['results'][] = $value;
            }
           
        }
         echo json_encode($array);
            die;
        
    }
    
    public function dataForMap()
    {
        $return_data = $this->getData(17,true);
        echo $return_data;exit; 
    }

    private function getBrowser($user_agen) {
        $u_agent = $user_agen;
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";
        $ub = "";
        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'Netscape';
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public function getTestData() {
        $data = SiteSettings::getLastWeekData();

        echo "<pre>";
        var_dump($data);
        die;
        echo "<pre>";
        var_dump(urldecode($data[0]['action_name']));
        die;
//        $array = array();
//        foreach ($data as $value) {
//            $array['results'][] = $value;
//        }
//        echo json_encode($array);
//        die;
    }

    public function insertData() {
        $path = public_path('data_ip_2.json');
        $data = file_get_contents($path);
        $json_data = json_decode($data);
        foreach ($json_data as $key => $val) {
            SiteSettings::insertData((array) $val);
        }
    }

    private function getCountry($country) {
        $countries = array(
            'AD' => 'Andorra',
            'AE' => 'United Arab Emirates',
            'AF' => 'Afghanistan',
            'AG' => 'Antigua and Barbuda',
            'AI' => 'Anguilla',
            'AL' => 'Albania',
            'AM' => 'Armenia',
            'AN' => 'Netherlands Antilles',
            'AO' => 'Angola',
            'AQ' => 'Antarctica',
            'AR' => 'Argentina',
            'AS' => 'American Samoa',
            'AT' => 'Austria',
            'AU' => 'Australia',
            'AW' => 'Aruba',
            'AX' => 'Åland Islands',
            'AZ' => 'Azerbaijan',
            'BA' => 'Bosnia and Herzegovina',
            'BB' => 'Barbados',
            'BD' => 'Bangladesh',
            'BE' => 'Belgium',
            'BF' => 'Burkina Faso',
            'BG' => 'Bulgaria',
            'BH' => 'Bahrain',
            'BI' => 'Burundi',
            'BJ' => 'Benin',
            'BL' => 'Saint Barthélemy',
            'BM' => 'Bermuda',
            'BN' => 'Brunei',
            'BO' => 'Bolivia',
            'BQ' => 'British Antarctic Territory',
            'BR' => 'Brazil',
            'BS' => 'Bahamas',
            'BT' => 'Bhutan',
            'BV' => 'Bouvet Island',
            'BW' => 'Botswana',
            'BY' => 'Belarus',
            'BZ' => 'Belize',
            'CA' => 'Canada',
            'CC' => 'Cocos [Keeling] Islands',
            'CD' => 'Congo - Kinshasa',
            'CF' => 'Central African Republic',
            'CG' => 'Congo - Brazzaville',
            'CH' => 'Switzerland',
            'CI' => 'Côte d’Ivoire',
            'CK' => 'Cook Islands',
            'CL' => 'Chile',
            'CM' => 'Cameroon',
            'CN' => 'China',
            'CO' => 'Colombia',
            'CR' => 'Costa Rica',
            'CS' => 'Serbia and Montenegro',
            'CT' => 'Canton and Enderbury Islands',
            'CU' => 'Cuba',
            'CV' => 'Cape Verde',
            'CX' => 'Christmas Island',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DD' => 'East Germany',
            'DE' => 'Germany',
            'DJ' => 'Djibouti',
            'DK' => 'Denmark',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'DZ' => 'Algeria',
            'EC' => 'Ecuador',
            'EE' => 'Estonia',
            'EG' => 'Egypt',
            'EH' => 'Western Sahara',
            'ER' => 'Eritrea',
            'ES' => 'Spain',
            'ET' => 'Ethiopia',
            'FI' => 'Finland',
            'FJ' => 'Fiji',
            'FK' => 'Falkland Islands',
            'FM' => 'Micronesia',
            'FO' => 'Faroe Islands',
            'FQ' => 'French Southern and Antarctic Territories',
            'FR' => 'France',
            'FX' => 'Metropolitan France',
            'GA' => 'Gabon',
            'GB' => 'United Kingdom',
            'GD' => 'Grenada',
            'GE' => 'Georgia',
            'GF' => 'French Guiana',
            'GG' => 'Guernsey',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GL' => 'Greenland',
            'GM' => 'Gambia',
            'GN' => 'Guinea',
            'GP' => 'Guadeloupe',
            'GQ' => 'Equatorial Guinea',
            'GR' => 'Greece',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'GT' => 'Guatemala',
            'GU' => 'Guam',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HK' => 'Hong Kong SAR China',
            'HM' => 'Heard Island and McDonald Islands',
            'HN' => 'Honduras',
            'HR' => 'Croatia',
            'HT' => 'Haiti',
            'HU' => 'Hungary',
            'ID' => 'Indonesia',
            'IE' => 'Ireland',
            'IL' => 'Israel',
            'IM' => 'Isle of Man',
            'IN' => 'India',
            'IO' => 'British Indian Ocean Territory',
            'IQ' => 'Iraq',
            'IR' => 'Iran',
            'IS' => 'Iceland',
            'IT' => 'Italy',
            'JE' => 'Jersey',
            'JM' => 'Jamaica',
            'JO' => 'Jordan',
            'JP' => 'Japan',
            'JT' => 'Johnston Island',
            'KE' => 'Kenya',
            'KG' => 'Kyrgyzstan',
            'KH' => 'Cambodia',
            'KI' => 'Kiribati',
            'KM' => 'Comoros',
            'KN' => 'Saint Kitts and Nevis',
            'KP' => 'North Korea',
            'KR' => 'South Korea',
            'KW' => 'Kuwait',
            'KY' => 'Cayman Islands',
            'KZ' => 'Kazakhstan',
            'LA' => 'Laos',
            'LB' => 'Lebanon',
            'LC' => 'Saint Lucia',
            'LI' => 'Liechtenstein',
            'LK' => 'Sri Lanka',
            'LR' => 'Liberia',
            'LS' => 'Lesotho',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'LV' => 'Latvia',
            'LY' => 'Libya',
            'MA' => 'Morocco',
            'MC' => 'Monaco',
            'MD' => 'Moldova',
            'ME' => 'Montenegro',
            'MF' => 'Saint Martin',
            'MG' => 'Madagascar',
            'MH' => 'Marshall Islands',
            'MI' => 'Midway Islands',
            'MK' => 'Macedonia',
            'ML' => 'Mali',
            'MM' => 'Myanmar [Burma]',
            'MN' => 'Mongolia',
            'MO' => 'Macau SAR China',
            'MP' => 'Northern Mariana Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MS' => 'Montserrat',
            'MT' => 'Malta',
            'MU' => 'Mauritius',
            'MV' => 'Maldives',
            'MW' => 'Malawi',
            'MX' => 'Mexico',
            'MY' => 'Malaysia',
            'MZ' => 'Mozambique',
            'NA' => 'Namibia',
            'NC' => 'New Caledonia',
            'NE' => 'Niger',
            'NF' => 'Norfolk Island',
            'NG' => 'Nigeria',
            'NI' => 'Nicaragua',
            'NL' => 'Netherlands',
            'NO' => 'Norway',
            'NP' => 'Nepal',
            'NQ' => 'Dronning Maud Land',
            'NR' => 'Nauru',
            'NT' => 'Neutral Zone',
            'NU' => 'Niue',
            'NZ' => 'New Zealand',
            'OM' => 'Oman',
            'PA' => 'Panama',
            'PC' => 'Pacific Islands Trust Territory',
            'PE' => 'Peru',
            'PF' => 'French Polynesia',
            'PG' => 'Papua New Guinea',
            'PH' => 'Philippines',
            'PK' => 'Pakistan',
            'PL' => 'Poland',
            'PM' => 'Saint Pierre and Miquelon',
            'PN' => 'Pitcairn Islands',
            'PR' => 'Puerto Rico',
            'PS' => 'Palestinian Territories',
            'PT' => 'Portugal',
            'PU' => 'U.S. Miscellaneous Pacific Islands',
            'PW' => 'Palau',
            'PY' => 'Paraguay',
            'PZ' => 'Panama Canal Zone',
            'QA' => 'Qatar',
            'RE' => 'Réunion',
            'RO' => 'Romania',
            'RS' => 'Serbia',
            'RU' => 'Russia',
            'RW' => 'Rwanda',
            'SA' => 'Saudi Arabia',
            'SB' => 'Solomon Islands',
            'SC' => 'Seychelles',
            'SD' => 'Sudan',
            'SE' => 'Sweden',
            'SG' => 'Singapore',
            'SH' => 'Saint Helena',
            'SI' => 'Slovenia',
            'SJ' => 'Svalbard and Jan Mayen',
            'SK' => 'Slovakia',
            'SL' => 'Sierra Leone',
            'SM' => 'San Marino',
            'SN' => 'Senegal',
            'SO' => 'Somalia',
            'SR' => 'Suriname',
            'ST' => 'São Tomé and Príncipe',
            'SU' => 'Union of Soviet Socialist Republics',
            'SV' => 'El Salvador',
            'SY' => 'Syria',
            'SZ' => 'Swaziland',
            'TC' => 'Turks and Caicos Islands',
            'TD' => 'Chad',
            'TF' => 'French Southern Territories',
            'TG' => 'Togo',
            'TH' => 'Thailand',
            'TJ' => 'Tajikistan',
            'TK' => 'Tokelau',
            'TL' => 'Timor-Leste',
            'TM' => 'Turkmenistan',
            'TN' => 'Tunisia',
            'TO' => 'Tonga',
            'TR' => 'Turkey',
            'TT' => 'Trinidad and Tobago',
            'TV' => 'Tuvalu',
            'TW' => 'Taiwan',
            'TZ' => 'Tanzania',
            'UA' => 'Ukraine',
            'UG' => 'Uganda',
            'UM' => 'U.S. Minor Outlying Islands',
            'US' => 'United States',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VA' => 'Vatican City',
            'VC' => 'Saint Vincent and the Grenadines',
            'VD' => 'North Vietnam',
            'VE' => 'Venezuela',
            'VG' => 'British Virgin Islands',
            'VI' => 'U.S. Virgin Islands',
            'VN' => 'Vietnam',
            'VU' => 'Vanuatu',
            'WF' => 'Wallis and Futuna',
            'WK' => 'Wake Island',
            'WS' => 'Samoa',
            'YD' => 'People\'s Democratic Republic of Yemen',
            'YE' => 'Yemen',
            'YT' => 'Mayotte',
            'ZA' => 'South Africa',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
            'ZZ' => 'Unknown or Invalid Region',
        );
        if (isset($countries[$country])) {
            return $countries[$country];
        }
        return "Undefined Country";
    }

}
