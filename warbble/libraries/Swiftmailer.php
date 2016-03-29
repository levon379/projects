<?php

class Swiftmailer
{
    private $config = false;

    function __construct()
    {
        require_once ABSPATH . "includes/plugins/swiftmailer/swift_required.php";
        $this->config = include (ABSPATH . "config/swiftmailer.php");
    }

    public function mail($subject = '', $from = array('title' => 'Support', 'email' => 'support@warbble.com'), $to = '', $message = '', $data = NULL)
    {
        $response = array();
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= sprintf('From: %s <%s>' . "\r\n", $from['title'], $from['email']);
        if (is_array($to)) {
            $to = implode(', ', $to);
        }
        $response['status'] = mail($to, $subject, $message, $headers);
        return $response;
    }

    public function send($subject = '', $from = array(), $to = '', $message = '', $data = NULL)
    {
        try{
            // Create the message
            $message = Swift_Message::newInstance()
                // Give the message a subject
                ->setSubject($subject)
                // Set the From address with an associative array
                ->setFrom(array($from['email'] => $from['title']))
                // Set the To addresses with an associative array
                ->setTo($to)
                // Give it a body
                // And optionally an alternative body
                ->addPart($message, "text/html");

            if ($data!==NULL) {
                $message->attach(Swift_Attachment::fromPath($data));
            }

            $transport = Swift_SmtpTransport::newInstance($this->config['hostname'], $this->config['port'], $this->config['encryption'])
                ->setUsername($this->config['username'])
                ->setPassword($this->config['password']);

            $data = Swift_Mailer::newInstance($transport)->send($message, $failures);
            if (!$data)
            {
                return array(
                    'status' => false,
                    'errors' => array('Unknown error'),
                    'data' => $data
                );
            }
            else
                return array(
                    'status' => true,
                    'errors' => array(),
                    'data' => $data
                );
        }catch(Exception $e){
            return array(
                'status' => false,
                'errors' => $e->getMessage(),
            );
        }

    }

    public function get_html_custom_message($view, $data = array(), $abspath = ABSPATH)
    {
        if (file_exists($abspath . "views/emails/$view.php")) {
            extract($data);
            ob_start();
            require_once $abspath . "views/emails/$view.php";
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
        return '';
    }

    public function get_html_tweet_message($tweet, $abspath = ABSPATH)
    {
        if (file_exists($abspath . "views/emails/tweet.php")) {
            ob_start();
            require_once $abspath . "views/emails/tweet.php";
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
        return '';
    }

    public function get_html_fb_post_message($post, $abspath = ABSPATH)
    {
        if (file_exists($abspath . "views/emails/fb_post.php")) {
            ob_start();
            require_once $abspath . "views/emails/fb_post.php";
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
        return '';
    }

    public function get_html_post_message($post)
    {
        if (file_exists(ABSPATH . "views/emails/post.php")) {
            ob_start();
            require_once ABSPATH . "views/emails/post.php";
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
        return '';
    }
}
