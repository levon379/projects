<?php

class Blogger extends Controller
{
    private $keys = false;

    public function __construct()
    {
        parent::__construct();
        $this->blogger = new BloggerAPI();
        $this->_js = array(
            array(
                'type' => 'admin',
                'file' => 'highcharts.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'moment.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'daterangepicker.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'media.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'oblogger.js',
                'location' => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'daterangepicker.css',
            ),
            array(
                'type' => 'admin',
                'file' => 'media.css',
            ),
        );

        $this->set_filters(array(
            'index'                 => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'tab_activity'          => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }


    function index()
    {
    }

    public function reply()
    {
        if (!$current_user = Users_Model::get_current_user()) exit;

        if ($this->is_ajax() && isset($_POST['Reply'])) {
            $response = $this->blogger->create_comment($_POST['Reply']['blog_id'], $_POST['Reply']['post_id'], $_POST['Reply']['user_id'], $_POST['Reply']['message'], $current_user->user_id);
            if (!isset($response->errors)) {
                echo json_encode(array('status' => true));
            } else {
                echo json_encode(array('status' => false, 'errors' => $response->errors));
            }
        }
        exit;
    }

    function fetch_info()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user->get_blogger_token()) {
                echo json_encode(array(
                    'status' => false,
                ));
                exit;
            }

            if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
                $date_start = $date_first = $_POST['startDate'];
                $date_end = $_POST['endDate'];
            }
            $comments = $this->blogger->get_comments_by_date($date_start, $date_end);
            $counts = array(
                'comments' => 0,
            );

            while ($date_start <= $date_end) {
                $index = date('d.m', $date_start);
                $chart['comments']['data'][$index] = array(
                    'y' => 0,
                    'users' => array(),
                    'type' => 'comments',
                );

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        if (date('Y-m-d', strtotime($comment->published)) == date('Y-m-d', $date_start)) {
                            $chart['comments']['data'][$index]['y']++;
                            $chart['comments']['data'][$index]['users'][$comment->author['id']] = array(
                                'id' => $comment->author['id'],
                                'name' => $comment->author['displayName'],
                                'url' => $comment->author['url'],
                                'image' => sprintf('%s:%s', $_SERVER['REQUEST_SCHEME'], $comment->author['image']['url']),
                                'blog_id' => $comment->blog['id'],
                                'post_id' => $comment->post['id'],
                            );
                            $counts['comments']++;
                        }
                    }
                }
                $date_start = strtotime('+1 day', $date_start);
            }
            $categories = array_keys($chart['comments']['data']);
            $chart['comments']['data'] = array_values($chart['comments']['data']);

            echo json_encode(array(
                'status' => true,
                'series' => array($chart['comments']),
                'categories' => $categories,
                'comments_chart' => $chart['comments'],
                'comments_count' => $counts['comments'],
            ));

        }
        exit;
    }

    function login()
    {
        if ($this->blogger->login()) {
            redirect(base_url('Posts/index'));
        }
    }


    public function delete_account()
    {
        if(!empty($_POST['action-delete'])) {
            if ($_POST['action-delete'] === "delete") {
                $response = $this->blogger->delete_blogger_account();
                switch ($response['status']) {
                    case "redirect":
                    case "redirect_error":
                    case "success":
                        redirect($response['url']);
                        break;
                    case "error":
                        $dis['message'] = '<p class="error">' . $response['message'] . '</p>';
                        break;
                }
            } else {
                redirect(base_url('Posts/index'));
            }
        } else {
            $this->layout('admin', 'users/delete_social', array("socialType" => "Blogger",
                "type" => get_config('social_types')->type_blogger));
        }
    }

    function tab_activity()
    {
        if (!$current_user = Users_Model::get_current_user()) redirect(base_url('login'));

        $date_start = $date_first = strtotime('-7 DAYS');
        $date_end = time();
        if (!$current_user->get_blogger_token()) {
            $this->layout('admin', 'blogger/_add_account', array());
            exit;
        }
        $comments_chart = array(
            'name' => 'Comments',
            'data' => array(),
            'color' => '#59c2e6',
            'marker' => array(
                'fillColor' => '#fff',
                'lineColor' => '#59c2e6',
                'lineWidth' => 2,
                'states' => array(
                    'hover' => array(
                        'fillColor' => '#59c2e6',
                    ),
                ),
            ),
        );
        $comments_count = 0;
        while ($date_start <= $date_end) {
            $index = date('d.m', $date_start);
            $comments_chart['data'][$index] = array(
                'y' => 0,
                'users' => array(),
                'type' => 'favourite',
            );
            $date_start = strtotime('+1 day', $date_start);
        }
        $categories = array_keys($comments_chart['data']);
        $comments_chart['data'] = array_values($comments_chart['data']);

        $this->layout('admin', 'blogger/blogger', array(
            '_tab' => 'blogger/_tab_activity',
            'tab_data' => array(
                'current_user' => $current_user,
                'comments_chart' => $comments_chart,
                'chart_categories' => $categories,
                'startDate' => date('d/m/y', $date_first),
                'endDate' => date('d/m/y', $date_end),
                'comments_count' => $comments_count,
            ),
            'post'=>true,
        ));
    }

    public function get_comments($return = false)
    {
        if ($this->is_ajax()) {
            if ($current_user = Users_Model::get_current_user()) {
                if ($current_user->get_blogger_token()) {
                    $return = array();
                    $comments = $this->blogger->get_all_comments();
                    if (!empty($comments)) {
                        foreach ($comments as $comment) {
                            $return[] = array(
                                'id' => $comment->id,
                                'authorid' => $comment->author['id'],
                                'name' => $comment->author['displayName'],
                                'url' => $comment->author['url'],
                                'image' => sprintf('%s:%s', $_SERVER['REQUEST_SCHEME'], $comment->author['image']['url']),
                                'blog_id' => $comment->blog['id'],
                                'post_id' => $comment->post['id'],
                                'content' => $comment->content,
                                'date' => date('h:i:s A \on d/m/y', strtotime($comment->updated))
                            );
                        }
                    }
                    if (!$return) {
                        echo json_encode(array(
                            "status" => true,
                            "comments" => $return));
                        exit;
                    } else {
                        return $return;
                    }
                }
            }
        }
        exit;
    }

    public function  get_comments_html()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user || !$current_user->get_blogger_token()) {
                echo json_encode(array(
                    'status' => false,
                ));
                exit;
            }
            $return = array();
            $comments = $this->get_comments(true);
            //limit of 4 comments output on page
            if (!empty($_POST['limit_comments']) && is_numeric($_POST['limit_comments'])) {
                $comments = array_slice($comments, 0, 4);
            }
            foreach ($comments as $comment) {
                $return[] = $this->load->view('blogger/single_comment', array('comment' => $comment), TRUE);
            }
            echo json_encode(array(
                "status" => true,
                "comments" => $return));
            exit;
        }
    }

    function comment_show_more()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user) {
                echo json_encode(array('status' => false));
                exit;
            }

            $return = "";
            $comments = $this->get_comments(true);
            //limit of 4 comments output on page
            if (!empty($_POST['limit_comments']) && is_numeric($_POST['limit_comments'])) {
                $comments = array_slice($comments, 0, 4);
            }
            foreach ($comments as $comment) {
                $return .= $this->load->view('blogger/single_comment', array('comment' => $comment), TRUE);
            }
            echo json_encode(array('status' => true, 'html' => $return));
        }
        exit;
    }

    function remove_comment()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user) {
                echo json_encode(array('status' => false));
                exit;
            }
            $return = "";
            $return = $this->blogger->remove_comment($_POST['blog_id'], $_POST['post_id'], $_POST['comment_id']);
            echo json_encode(array('status' => true, 'result' => $return));
            exit;
        }
    }

    function mark_spam_comment()
    {
        if ($this->is_ajax()) {
            $current_user = Users_Model::get_current_user();
            if (!$current_user) {
                echo json_encode(array('status' => false));
                exit;
            }
            $return = "";
            $return = $this->blogger->mark_spam_comment($_POST['blog_id'], $_POST['post_id'], $_POST['comment_id']);
            echo json_encode(array('status' => true, 'result' => $return));
            exit;
        }
    }

}