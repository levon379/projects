<?php

class Orders extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Orders_Model');

        $this->_css = array(
            array(
                'type'      => 'admin',
                'file'      => 'orders.css',
            ),
        );

        $this->_js = array(

            array(
                'type'      => 'admin',
                'file'      => 'moment.min.js',
                'location'  => 'footer',
            ),

        );

        $this->set_filters(array(
            'view_all'      => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'detail'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'my_orders'     => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'view'          => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'finish'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_DESIGNER, Roles_Model::TYPE_LEVEL_USER, Roles_Model::TYPE_LEVEL_CUSTOMER, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));
    }

    public function view_all()
    {
        $data = array();
        $data['gridview'] = new Gridview(array(
            'table_name'    => 'Orders',
            'model_name'    => 'Orders_Model',
            'conditions'    => array(),
            'columns'       => array(
                array(
                    'name'      => 'id',
                    'title'     => 'ID',
                ),
                array(
                    'title'     => 'User',
                    'filter'     => function($model){
                        return $model->user->get_name();
                    },
                ),
                array(
                    'title'     => 'Status',
                    'filter'     => function($model){
                        return $model->get_status_name();
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="/Orders/detail/%s"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 10
            ),
        ));
        $this->layout('admin', 'orders/view_all', $data);
    }

    public function my_orders()
    {
        $data = array();
        $current_user = Users_Model::get_current_user();
        $data['gridview'] = new Gridview(array(
            'table_name'    => 'My Orders',
            'model_name'    => 'Orders_Model',
            'conditions'    => array(
                'user_id' => $current_user->user_id,
            ),
            'columns'       => array(
                array(
                    'name'      => 'id',
                    'title'     => 'ID',
                ),
                array(
                    'title'     => 'Status',
                    'filter'     => function($model){
                        return $model->get_status_name();
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="/Orders/view/%s"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 10
            ),
        ));
        $this->layout('admin', 'orders/my_orders', $data);
    }

    public function detail($id)
    {
        if (!$id) redirect(base_url('Orders/view_all'));

        $data = array(
            'order' => Orders_Model::first(array('id' => $id)),
        );

        if (!$data['order']) redirect(base_url('Orders/view_all'));

        $this->layout('admin', 'orders/detail', $data);

    }

    public function view($id)
    {
        if (!$id) redirect(base_url('Orders/my_orders'));

        $data = array(
            'order' => Orders_Model::first(array('id' => $id)),
        );

        if (!$data['order']) redirect(base_url('Orders/my_orders'));

        $this->layout('admin', 'orders/view', $data);

    }

    public function create()
    {
        if ($this->is_ajax()) {
//            if (isset($_POST['product_id']) && isset($_POST['token'])) {
            if (isset($_POST['product_id'])) {    
                $order = new Orders_Model(array(
                    'product_id'        => $_POST['product_id'],
                    'date'              => time(),
                    'status'            => Orders_Model::STATUS_PENDING,
//                    'token'             => $_POST['token'],
                    'token'             => 0,
                    'page_info_id'      => $_POST['page_info_id'],
                ));
                $current_user = Users_Model::get_current_user();

                if (!$current_user) {
                    echo json_encode(array('status' => false, 'errors' => array(
                        'Invalid response (user is no logged in)'
                    )));
                    exit;
                }

                $product = Product_Model::first(array('id' => $_POST['product_id']));

                if (!$product) {
                    echo json_encode(array('status' => false, 'errors' => array(
                        'Invalid response (no product)'
                    )));
                    exit;
                }
                $config = get_config('stripe');
                $setupProductData = Users_Package_Model::GetProductData($config[$product->type]["setup"]);
                $designProductData = Users_Package_Model::GetProductData($config[$product->type]["design"]);
                $order->user_id = $current_user->user_id;
                //$order->total = Orders_Model::CREATE_ACCOUNT_COST + $product->price;
                $order->total = ($setupProductData->price + $designProductData->price)/100;
                $stripeOrder = Users_Package_Model::CreateStripeOrder($product);
                if ($order->save() and $stripeOrder) {
                    
                    $html = $this->load->view('dashboard/index/_complete', array(
                        'order'     => $order,
                    ), TRUE);
                    echo json_encode(array('status' => true, 'html' => $html, 'order_id' => $order->id, 'stripe_order_id' => $stripeOrder->id));
                } else {
                    $errors = $order->errors->full_messages();
                    echo json_encode(array('status' => false, 'errors' => $errors));
                }
            }
        }
        exit;
    }

    public function finish()
    {
        if ($this->is_ajax() && isset($_POST['id'])) {
            $order = Orders_Model::find($_POST['id']);
            $current_user = Users_Model::get_current_user();

            if ($current_user->user_id != $order->user_id) {
                $this->ajax_response(array(
                    'status' => false,
                    'errors' => "Permission denied"
                ), 403);
            }

            if ($order->status != Orders_Model::STATUS_PENDING && $order->status != Orders_Model::STATUS_TRIAL) {
                $this->ajax_response(array(
                    'status' => false,
                    'errors' => "Error order status"
                ), 403);
            }

            if ($order->status == Orders_Model::STATUS_PENDING) {
                $payment = Users_Package_Model::PayStripeOrder($_POST['stripe_order_id']);
                if (!$payment) {
                    $this->ajax_response(array(
                        'status' => false,
                        'errors' => "Failed to pay"
                    ), 403);
                }
                $order->status = Orders_Model::STATUS_COMPLETE;
                $order->save();
            }

            $message = 'We will be in contact soon to finish the design';
            $mailer = new Swiftmailer();
            $mailer->mail('Warbble notification', array(
                'email' => 'support@warbble.com',
                'title' => 'Support',
            ), array($current_user->email), $mailer->get_html_custom_message('finish_order', array(
                'message'   => $message,
                'order'     => $order,
            )));

            //create notification
            $type = Notification_Model::TYPE_ORDER_COMPLETE;
            $notif = new Notification_Model();
            $notif->type = $type;
            $notif->date = time();
            $notif->user_id = $current_user->user_id;
            $notif->status = Notification_Model::STATE_NOTREAD;
            $notif->message = Notification_Model::$messages[$type];
            $notif->uri = Notification_Model::$redirect_url[$type];
            $result = $notif->save();
            $this->ajax_response(array(
                'status' => true,
                'url' => base_url('Dashboard'),
                'message' => $message
            ));
        }
        exit;
    }
}