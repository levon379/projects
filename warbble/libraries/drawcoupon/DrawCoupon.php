<?php

class DrawCoupon
{
    private $instance = false;

    private $user = false;

    private $upload_dir = array();

    private $config = array(
        'background'    => '#fff',
        'border'        => 17,
        'border_radius' => 1,
        'facebook'      => array(
            'width'     => 489,
            'height'    => 537,
            'logo'      => array(
                'width'  => 170,
                'height' => 96,
            ),
        ),
        'twitter'       => array(
            'width'     => 476,
            'height'    => 289,
            'logo'      => array(
                'width'  => 170,
                'height' => 96,
            ),
        ),
        'blogger'      => array(
            'width'     => 489,
            'height'    => 537,
            'logo'      => array(
                'width'  => 170,
                'height' => 96,
            ),
        ),
        'instagram'     => array(
            'width'     => 489,
            'height'    => 478,
            'logo'      => array(
                'width'  => 170,
                'height' => 96,
            ),
        ),
    );

    public function __construct($config = array())
    {
        $this->instance = Controller::get_instance();
        if (!is_array($config)) {
            throw new Exception('$config must be array');
        }
        $this->user = Users_Model::get_current_user();
        if (!$this->user) {
            throw new Exception('User not found');
        }
        $this->upload_dir['facebook']   = ABSPATH . "uploads/coupon/{$this->user->user_id}/facebook/";
        $this->upload_dir['twitter']    = ABSPATH . "uploads/coupon/{$this->user->user_id}/twitter/";
        $this->upload_dir['blogger']  = ABSPATH . "uploads/coupon/{$this->user->user_id}/blogger/";
        $this->upload_dir['instagram']  = ABSPATH . "uploads/coupon/{$this->user->user_id}/instagram/";

        foreach ($this->upload_dir as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
        $this->config = array_replace_recursive($this->config, $config);
    }

    public function renderFacebook($coupon = false, $is_save = true)
    {
        if (!$coupon) {
            throw new Exception('$config is null');
        }
        $filename = "facebook_coupon_" . time() . ".png";
        $fullpath = $this->upload_dir['facebook'] . $filename;

        // canvas
        $canvas = new Imagick();
        $canvas->newImage($this->config['facebook']['width'], $this->config['facebook']['height'], new ImagickPixel($this->config['background']));
        $canvas->roundCorners($this->config['border_radius'], $this->config['border_radius']);

        // logo
        $logo = new Imagick();
        $logo->readImage(ABSPATH . $coupon->logo->uri);
        $logo->scaleImage($this->config['facebook']['logo']['width'], $this->config['facebook']['logo']['height'], true);

        // merge images
        $canvas->compositeImage($logo, $logo->getImageCompose(),  $this->config['border'],  $this->config['border']);

        // company name
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(700);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_name);
        $draw->annotation( $this->config['facebook']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'], $coupon->company_name);
        $canvas->drawImage($draw);

        // company website
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#07bde3');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_url);
        $draw->annotation( $this->config['facebook']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 2), $coupon->company_url);
        $canvas->drawImage($draw);

        // company address
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_addr);
        $draw->annotation( $this->config['facebook']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 4), $coupon->company_addr);
        $canvas->drawImage($draw);

        // company phone
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_phone);
        $draw->annotation( $this->config['facebook']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 6), $coupon->company_phone);
        $canvas->drawImage($draw);

        // title
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->title);
        $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 150, $coupon->title);
        $canvas->drawImage($draw);


        // text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->text);
        if ($text_settings['textWidth'] < $this->config['facebook']['width']) {
            $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 204, $coupon->text);
            $canvas->drawImage($draw);
        } else {
            $text = wordwrap($coupon->text, 50,"\r\n");
            $text_array = explode("\r\n",$text);
            foreach ($text_array as $index => $line) {
                $draw = new ImagickDraw();
                $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
                $draw->setFontSize(11);
                $draw->setFillColor('#3f5666');
                $draw->setFontWeight(400);
                $text_settings = $canvas->queryFontMetrics($draw, $line);
                $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , ($this->config['border'] + 204) + (11 * $index), $line);
                $canvas->drawImage($draw);
            }
        }

        // discount image
        $discount = new Imagick();
        $discount->readImage(ABSPATH . 'libraries/drawcoupon/assets/stamp-blue.png');
        $discount->scaleImage(130, 124, true);

        // merge images
        $canvas->compositeImage($discount, $discount->getImageCompose(),  80,  270);

        // discount text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->discount);
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 11, $coupon->discount);
        $canvas->drawImage($draw);

        // discount const text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, 'discount');
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 2 + (11 * 2), 'discount');
        $canvas->drawImage($draw);

        // barcode image
        if(!empty($_POST['coupon']['codechoice'])) {
            $code = new Imagick();
            if ($_POST['coupon']['codechoice'] == "barcode" && !empty($coupon->code->uri)) {
                $code->readImage(ABSPATH . $coupon->code->uri);
            } elseif($_POST['coupon']['codechoice'] == "qrcode") {

                $intoCode = $coupon->company_url . "\n";
                $intoCode .= $this->user->email . "\n";
                if ($this->user->get_twitter_tokens()) {
                    $intoCode .= "http://twitter.com/" . $this->user->get_usermeta('twitter_user_name')->meta_value . "\n";
                }
                if ($this->user->get_fb_token()) {
                    $intoCode .= "http://facebook.com/" . $this->user->get_usermeta('facebook_user_id')->meta_value . "\n";
                }
                if ($this->user->get_blogger_token()) {
                    $intoCode .= "http://plus.google.com/" . $this->user->get_usermeta('google_user_id')->meta_value;
                }
                $modelCoupon = new Coupon_Model();
                $qrCode = $modelCoupon->getQRCode($intoCode);
                $code->readImageBlob($qrCode);
            }
            $code->scaleImage(105, 105, true);

            // merge images
            $canvas->compositeImage($code, $code->getImageCompose(), 292, 283);
        }

        // date text
        $text = sprintf('Faild From: %s To: %s', date('d.m.Y', $coupon->from_date), date('d.m.Y', $coupon->to_date));
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $text);
        $draw->annotation(($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , 439, $text);
        $canvas->drawImage($draw);

        // footer text
        $texts = array(
            'No Cash Value. No rain checks. No cash back. Coupon not valid on prior purchases, online',
            'purchases or gift cards. Must present coupon at time of purchase to redeem. Cannot be',
            'combined with any other offer, coupon, or Employee or Friends & Family discount.'
        );

        foreach ($texts as $index => $text) {
            $draw = new ImagickDraw();
            $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
            $draw->setFontSize(10);
            $draw->setFillColor('#abb2b8');
            $draw->setFontWeight(900);
            $text_settings = $canvas->queryFontMetrics($draw, $text);
            $draw->annotation(($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , 470 + (10 * $index), $text);
            $canvas->drawImage($draw);
        }


        // SAVE COUPON IMAGE
        if ($is_save) {
            $canvas->writeImage($fullpath);
        } else {
            $canvas->setImageFormat("png");
            return array(
                'filename'      => $filename,
                'filetype'  => 'image/png',
                'data'      => "data:image/png;base64," . base64_encode($canvas->getImageBlob()),
            );
        }

    }

    public function renderTwitter($coupon = false, $is_save = true)
    {
        if (!$coupon) {
            throw new Exception('$config is null');
        }
        $filename = "twitter_coupon_" . time() . ".png";
        $fullpath = $this->upload_dir['twitter'] . $filename;

        // canvas
        $canvas = new Imagick();
        $canvas->newImage($this->config['twitter']['width'], $this->config['twitter']['height'], new ImagickPixel($this->config['background']));
        $canvas->roundCorners($this->config['border_radius'], $this->config['border_radius']);

        // logo
        $logo = new Imagick();
        $logo->readImage(ABSPATH . $coupon->logo->uri);
        $logo->scaleImage($this->config['twitter']['logo']['width'], $this->config['twitter']['logo']['height'], true);

        // merge images
        $canvas->compositeImage($logo, $logo->getImageCompose(),  $this->config['border'],  $this->config['border']);

        // company name
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(700);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_name);
        $draw->annotation( $this->config['twitter']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'], $coupon->company_name);
        $canvas->drawImage($draw);

        // company website
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#07bde3');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_url);
        $draw->annotation( $this->config['twitter']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 2), $coupon->company_url);
        $canvas->drawImage($draw);

        // company address
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_addr);
        $draw->annotation( $this->config['twitter']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 4), $coupon->company_addr);
        $canvas->drawImage($draw);

        // company phone
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_phone);
        $draw->annotation( $this->config['twitter']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 6), $coupon->company_phone);
        $canvas->drawImage($draw);

        // discount image
        $discount = new Imagick();
        $discount->readImage(ABSPATH . 'libraries/drawcoupon/assets/stamp-blue.png');
        $discount->scaleImage(130, 124, true);

        // merge images
        $canvas->compositeImage($discount, $discount->getImageCompose(),  77,  138);

        // discount text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->discount);
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 181 + 11, $coupon->discount);
        $canvas->drawImage($draw);

        // discount const text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, 'discount');
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 181 + 2 + (11 * 2), 'discount');
        $canvas->drawImage($draw);

        // barcode image
        if(!empty($_POST['coupon']['codechoice'])) {
            $code = new Imagick();
            if ($_POST['coupon']['codechoice'] == "barcode" && !empty($coupon->code->uri)) {
                $code->readImage(ABSPATH . $coupon->code->uri);
            } elseif($_POST['coupon']['codechoice'] == "qrcode") {

                $intoCode = $coupon->company_url . "\n";
                $intoCode .= $this->user->email . "\n";
                if ($this->user->get_twitter_tokens()) {
                    $intoCode .= "http://twitter.com/" . $this->user->get_usermeta('twitter_user_name')->meta_value . "\n";
                }
                if ($this->user->get_fb_token()) {
                    $intoCode .= "http://facebook.com/" . $this->user->get_usermeta('facebook_user_id')->meta_value . "\n";
                }
                if ($this->user->get_blogger_token()) {
                    $intoCode .= "http://plus.google.com/" . $this->user->get_usermeta('google_user_id')->meta_value;
                }
                $modelCoupon = new Coupon_Model();
                $qrCode = $modelCoupon->getQRCode($intoCode);
                $code->readImageBlob($qrCode);
            }
            $code->scaleImage(105, 105, true);

            // merge images
            $canvas->compositeImage($code, $code->getImageCompose(), 289, 149);
        }

        // SAVE COUPON IMAGE
        if ($is_save) {
            $canvas->writeImage($fullpath);
        } else {
            $canvas->setImageFormat("png");
            return array(
                'filename'      => $filename,
                'filetype'  => 'image/png',
                'data'      => "data:image/png;base64," . base64_encode($canvas->getImageBlob()),
            );
        }

    }

    public function renderInstagram($coupon = false, $is_save = true)
    {
        if (!$coupon) {
            throw new Exception('$config is null');
        }
        $filename = "instagram_coupon_" . time() . ".png";
        $fullpath = $this->upload_dir['instagram'] . $filename;

        // canvas
        $canvas = new Imagick();
        $canvas->newImage($this->config['instagram']['width'], $this->config['instagram']['height'], new ImagickPixel($this->config['background']));
        $canvas->roundCorners($this->config['border_radius'], $this->config['border_radius']);

        // logo
        $logo = new Imagick();
        $logo->readImage(ABSPATH . $coupon->logo->uri);
        $logo->scaleImage($this->config['instagram']['logo']['width'], $this->config['instagram']['logo']['height'], true);

        // merge images
        $canvas->compositeImage($logo, $logo->getImageCompose(),  $this->config['border'],  $this->config['border']);

        // company name
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(700);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_name);
        $draw->annotation( $this->config['instagram']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'], $coupon->company_name);
        $canvas->drawImage($draw);

        // company website
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#07bde3');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_url);
        $draw->annotation( $this->config['instagram']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 2), $coupon->company_url);
        $canvas->drawImage($draw);

        // company address
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_addr);
        $draw->annotation( $this->config['instagram']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 4), $coupon->company_addr);
        $canvas->drawImage($draw);

        // company phone
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_phone);
        $draw->annotation( $this->config['instagram']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 6), $coupon->company_phone);
        $canvas->drawImage($draw);

        // title
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->title);
        $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 150, $coupon->title);
        $canvas->drawImage($draw);


        // text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->text);
        if ($text_settings['textWidth'] < $this->config['facebook']['width']) {
            $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 204, $coupon->text);
            $canvas->drawImage($draw);
        } else {
            $text = wordwrap($coupon->text, 50,"\r\n");
            $text_array = explode("\r\n",$text);
            foreach ($text_array as $index => $line) {
                $draw = new ImagickDraw();
                $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
                $draw->setFontSize(11);
                $draw->setFillColor('#3f5666');
                $draw->setFontWeight(400);
                $text_settings = $canvas->queryFontMetrics($draw, $line);
                $draw->annotation( ($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , ($this->config['border'] + 204) + (11 * $index), $line);
                $canvas->drawImage($draw);
            }
        }

        // discount image
        $discount = new Imagick();
        $discount->readImage(ABSPATH . 'libraries/drawcoupon/assets/stamp-blue.png');
        $discount->scaleImage(130, 124, true);

        // merge images
        $canvas->compositeImage($discount, $discount->getImageCompose(),  80,  270);

        // discount text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->discount);
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 11, $coupon->discount);
        $canvas->drawImage($draw);

        // discount const text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, 'discount');
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 2 + (11 * 2), 'discount');
        $canvas->drawImage($draw);

        // barcode image
        if(!empty($_POST['coupon']['codechoice'])) {
            $code = new Imagick();
            if ($_POST['coupon']['codechoice'] == "barcode" && !empty($coupon->code->uri)) {
                $code->readImage(ABSPATH . $coupon->code->uri);
            } elseif($_POST['coupon']['codechoice'] == "qrcode") {

                $intoCode = $coupon->company_url . "\n";
                $intoCode .= $this->user->email . "\n";
                if ($this->user->get_twitter_tokens()) {
                    $intoCode .= "http://twitter.com/" . $this->user->get_usermeta('twitter_user_name')->meta_value . "\n";
                }
                if ($this->user->get_fb_token()) {
                    $intoCode .= "http://facebook.com/" . $this->user->get_usermeta('facebook_user_id')->meta_value . "\n";
                }
                if ($this->user->get_blogger_token()) {
                    $intoCode .= "http://plus.google.com/" . $this->user->get_usermeta('google_user_id')->meta_value;
                }
                $modelCoupon = new Coupon_Model();
                $qrCode = $modelCoupon->getQRCode($intoCode);
                $code->readImageBlob($qrCode);
            }
            $code->scaleImage(105, 105, true);

            // merge images
            $canvas->compositeImage($code, $code->getImageCompose(), 292, 283);
        }

        // date text
        $text = sprintf('Faild From: %s To: %s', date('d.m.Y', $coupon->from_date), date('d.m.Y', $coupon->to_date));
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $text);
        $draw->annotation(($this->config['facebook']['width'] - $text_settings['textWidth']) / 2 , 439, $text);
        $canvas->drawImage($draw);

        // SAVE COUPON IMAGE
        if ($is_save) {
            $canvas->writeImage($fullpath);
        } else {
            $canvas->setImageFormat("png");
            return array(
                'filename'      => $filename,
                'filetype'  => 'image/png',
                'data'      => "data:image/png;base64," . base64_encode($canvas->getImageBlob()),
            );
        }

    }

    public function renderBlogger($coupon = false, $is_save = true)
    {
        if (!$coupon) {
            throw new Exception('$config is null');
        }
        $filename = "blogger_coupon_" . time() . ".png";
        $fullpath = $this->upload_dir['blogger'] . $filename;

        // canvas
        $canvas = new Imagick();
        $canvas->newImage($this->config['blogger']['width'], $this->config['blogger']['height'], new ImagickPixel($this->config['background']));
        $canvas->roundCorners($this->config['border_radius'], $this->config['border_radius']);

        // logo
        $logo = new Imagick();
        $logo->readImage(ABSPATH . $coupon->logo->uri);
        $logo->scaleImage($this->config['blogger']['logo']['width'], $this->config['blogger']['logo']['height'], true);

        // merge images
        $canvas->compositeImage($logo, $logo->getImageCompose(),  $this->config['border'],  $this->config['border']);

        // company name
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(700);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_name);
        $draw->annotation( $this->config['blogger']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'], $coupon->company_name);
        $canvas->drawImage($draw);

        // company website
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#07bde3');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_url);
        $draw->annotation( $this->config['blogger']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 2), $coupon->company_url);
        $canvas->drawImage($draw);

        // company address
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_addr);
        $draw->annotation( $this->config['blogger']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 4), $coupon->company_addr);
        $canvas->drawImage($draw);

        // company phone
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(10);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->company_phone);
        $draw->annotation( $this->config['blogger']['width'] - ($text_settings['textWidth'] + $this->config['border']) , $this->config['border'] + (10 * 6), $coupon->company_phone);
        $canvas->drawImage($draw);

        // title
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->title);
        $draw->annotation( ($this->config['blogger']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 150, $coupon->title);
        $canvas->drawImage($draw);


        // text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(400);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->text);
        if ($text_settings['textWidth'] < $this->config['facebook']['width']) {
            $draw->annotation( ($this->config['blogger']['width'] - $text_settings['textWidth']) / 2 , $this->config['border'] + 204, $coupon->text);
            $canvas->drawImage($draw);
        } else {
            $text = wordwrap($coupon->text, 50,"\r\n");
            $text_array = explode("\r\n",$text);
            foreach ($text_array as $index => $line) {
                $draw = new ImagickDraw();
                $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
                $draw->setFontSize(11);
                $draw->setFillColor('#3f5666');
                $draw->setFontWeight(400);
                $text_settings = $canvas->queryFontMetrics($draw, $line);
                $draw->annotation( ($this->config['blogger']['width'] - $text_settings['textWidth']) / 2 , ($this->config['border'] + 204) + (11 * $index), $line);
                $canvas->drawImage($draw);
            }
        }

        // discount image
        $discount = new Imagick();
        $discount->readImage(ABSPATH . 'libraries/drawcoupon/assets/stamp-blue.png');
        $discount->scaleImage(130, 124, true);

        // merge images
        $canvas->compositeImage($discount, $discount->getImageCompose(),  80,  270);

        // discount text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(18);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $coupon->discount);
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 11, $coupon->discount);
        $canvas->drawImage($draw);

        // discount const text
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#fff');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, 'discount');
        $draw->annotation(((80 - $text_settings['textWidth'])/2) + 80 + 25, 315 + 2 + (11 * 2), 'discount');
        $canvas->drawImage($draw);

        // barcode image
        if(!empty($_POST['coupon']['codechoice'])) {
            $code = new Imagick();
            if ($_POST['coupon']['codechoice'] == "barcode" && !empty($coupon->code->uri)) {
                $code->readImage(ABSPATH . $coupon->code->uri);
            } elseif($_POST['coupon']['codechoice'] == "qrcode") {

                $intoCode = $coupon->company_url . "\n";
                $intoCode .= $this->user->email . "\n";
                if ($this->user->get_twitter_tokens()) {
                    $intoCode .= "http://twitter.com/" . $this->user->get_usermeta('twitter_user_name')->meta_value . "\n";
                }
                if ($this->user->get_fb_token()) {
                    $intoCode .= "http://facebook.com/" . $this->user->get_usermeta('facebook_user_id')->meta_value . "\n";
                }
                if ($this->user->get_blogger_token()) {
                    $intoCode .= "http://plus.google.com/" . $this->user->get_usermeta('google_user_id')->meta_value;
                }
                $modelCoupon = new Coupon_Model();
                $qrCode = $modelCoupon->getQRCode($intoCode);
                $code->readImageBlob($qrCode);
            }
            $code->scaleImage(105, 105, true);

            // merge images
            $canvas->compositeImage($code, $code->getImageCompose(), 292, 283);
        }

        // date text
        $text = sprintf('Faild From: %s To: %s', date('d.m.Y', $coupon->from_date), date('d.m.Y', $coupon->to_date));
        $draw = new ImagickDraw();
        $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
        $draw->setFontSize(11);
        $draw->setFillColor('#3f5666');
        $draw->setFontWeight(900);
        $text_settings = $canvas->queryFontMetrics($draw, $text);
        $draw->annotation(($this->config['blogger']['width'] - $text_settings['textWidth']) / 2 , 439, $text);
        $canvas->drawImage($draw);

        // footer text
        $texts = array(
            'No Cash Value. No rain checks. No cash back. Coupon not valid on prior purchases, online',
            'purchases or gift cards. Must present coupon at time of purchase to redeem. Cannot be',
            'combined with any other offer, coupon, or Employee or Friends & Family discount.'
        );

        foreach ($texts as $index => $text) {
            $draw = new ImagickDraw();
            $draw->setFont(ABSPATH . 'assets/font/opensans.ttf');
            $draw->setFontSize(10);
            $draw->setFillColor('#abb2b8');
            $draw->setFontWeight(900);
            $text_settings = $canvas->queryFontMetrics($draw, $text);
            $draw->annotation(($this->config['blogger']['width'] - $text_settings['textWidth']) / 2 , 470 + (10 * $index), $text);
            $canvas->drawImage($draw);
        }


        // SAVE COUPON IMAGE
        if ($is_save) {
            $canvas->writeImage($fullpath);
        } else {
            $canvas->setImageFormat("png");
            return array(
                'filename'      => $filename,
                'filetype'  => 'image/png',
                'data'      => "data:image/png;base64," . base64_encode($canvas->getImageBlob()),
            );
        }

    }
}