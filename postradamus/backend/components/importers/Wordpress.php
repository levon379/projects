<?php

class WordpressImport extends Import {
    private $handle = 'wordpress';

    public function posts_added_by_user( $wp_user_id ) {
        return parent::posts_added_by_user( $this->handle, $wp_user_id );
    }

    /* Searches a wordpress blog for photos */
    public function search($search_params)
    {
        if($search_params['search_keywords'])
        {
            $search_sql = " AND post_title LIKE '%" . addslashes($search_params['search_keywords']) . "%'";
        }
        //rss feed or personal blog only (use plugin?)
        $sql = "
            SELECT *
            FROM  `{$GLOBALS['wpdb']->prefix}posts`
            WHERE  `post_type` LIKE  'attachment' AND (post_mime_type = 'image/jpeg' OR post_mime_type = 'image/gif' OR post_mime_type = 'image/png')$search_sql
            LIMIT 100
        ";
        $results = $GLOBALS['wpdb']->get_results(
            $sql
        );

        if(empty($results))
        {
            $this->message->set_message('No results found. Please try different keywords.', Message::MSG_TYPE_WARNING);
            return array();
        }

        return $results;
    }

    /* Helpers */
    public function get_post_id($v)
    {
        return $v->id;
    }

    public function get_post_message($v)
    {
        return $v->post_title;

    }

    public function get_post_image_src($v)
    {
        return $v->guid;
    }

    public function get_post_image_link($v)
    {
        return $v->guid;
    }

    public function get_post_title($v)
    {
        return $v->post_title;
    }

    public function get_post_created_time($v)
    {
        return strtotime($v->post_modified_gmt);
    }

}