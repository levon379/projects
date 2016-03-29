<?php


class Gridview
{
    public $instance    = false;
    private $config = array(
        'table_name'    => false,
        'model_name'    => false,
        'conditions'    => array(),
        'custom_data'   => false,
        'select'        => '*',
        'order'         => '',
        'from'          => false,
        'pagination' => array(
            'per_page'      => 10,
            'total'         => 0,
            'total_pages'   => 0,
            'current_page'  => 1,
        ),
    );

    public function __construct($config = array())
    {
        $this->instance = Controller::get_instance();
        $this->instance->_js = array_merge(
            array(
                array(
                    'type'      => 'admin',
                    'file'      => 'bootstrap-paginator.min.js',
                    'location'  => 'footer',
                ),
                array(
                    'type'      => 'admin',
                    'url'       => BASE_URL . "libraries/Gridview/assets/gridview.js",
                    'location'  => 'outside_footer',
                ),
            ),
            $this->instance->_js
        );

        $this->config = array_replace_recursive($this->config, $config);
        $this->config['css_class'] = "gridview-table-".preg_replace('/\s/', '_', strtolower(trim($this->config['model_name'])));
        if (empty($this->config['model_name'])) return;
        $Model = $this->config['model_name'];
        $conditions = array(
            'limit'     => $this->config['pagination']['per_page'],
            'offset'    => isset($_POST['Gridview']['page'])? (($_POST['Gridview']['page'] - 1) * $this->config['pagination']['per_page']): 0,
        );
        if ($this->config['from']) {
            $new_conditions = array('from' => $this->config['from'],'order' => $this->config['order'], 'joins' => $this->config['joins'], 'conditions' => $this->config['conditions']);
        } else {
            $new_conditions = array('order' => $this->config['order'], 'joins' => $this->config['joins'], 'conditions' => $this->config['conditions']);
        }

        if (!$this->config['custom_data']) {

            // from sql query
            $count_conditions = array_replace_recursive(array('select' => 'COUNT(*) as __total_qty__'), $new_conditions);
            $this->config['pagination']['total'] = $Model::first($count_conditions)->__total_qty__;
            $this->config['pagination']['current_page'] = isset($_POST['Gridview']['page'])? $_POST['Gridview']['page']: 1;
            $this->config['pagination']['total_pages'] = ceil($this->config['pagination']['total'] / $this->config['pagination']['per_page']);
            if ($this->config['from']) {
                $new_conditions = array('from' => $this->config['from'], 'select'=> $this->config['select'], 'order' => $this->config['order'], 'joins' => $this->config['joins'], 'conditions' => $this->config['conditions']);
            } else {
                $new_conditions = array('select'=> $this->config['select'], 'order' => $this->config['order'], 'joins' => $this->config['joins'], 'conditions' => $this->config['conditions']);
            }
            $conditions = array_replace_recursive($conditions, $new_conditions);
            $this->config['models'] = $Model::all($conditions);
        } else {
            $this->config['pagination']['total'] = count($this->config['custom_data']);
            $this->config['pagination']['current_page'] = isset($_POST['Gridview']['page'])? $_POST['Gridview']['page']: 1;
            $this->config['pagination']['total_pages'] = ceil($this->config['pagination']['total'] / $this->config['pagination']['per_page']);
            // from custom data
            $this->config['models'] = $this->config['custom_data'];
            if ($this->config['pagination']['total_pages'] > 1) {
                $this->config['models'] = array_slice($this->config['models'], $conditions['offset'], $conditions['limit']);
            }
        }

        if ($this->instance->is_ajax() && isset($_POST['Gridview']['page']) && isset($_POST['Gridview']['action']) && $_POST['Gridview']['action'] === "ajax_{$this->config['model_name']}") {
            echo json_encode(array(
                'status'        => true,
                'target'        => $this->config['css_class'],
                'html'          => $this->view('_table', $this->config, TRUE),
            ));
            exit;
        }
    }

    public function render($param = false)
    {
        if(!$param){
            echo $this->view('index', $this->config);
        }else{
            echo $this->view('changed-view/index', $this->config);
        }
    }

    public function view($view='', $dis = array(), $return = false )
    {
        if (!file_exists(ABSPATH . "libraries/Gridview/views/{$view}.php")) return;

        extract($dis);
        ob_start();
        include(ABSPATH . "libraries/Gridview/views/{$view}.php");
        $html = ob_get_contents();
        ob_end_clean();

        if (!$return) {
            echo $html;
        } else {
            return $html;
        }

    }
}