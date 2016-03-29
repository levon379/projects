<?php

class Product extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Product_Model');

        $this->_js = array(
            array(
                'type'      => 'admin',
                'file'      => 'bootstrap-paginator.min.js',
                'location'  => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'media.js',
                'location' => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'product.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type' => 'admin',
                'file' => 'media.css',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'product.css',
            ),
        );

        $this->set_filters(array(
            'index'         => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'        => array(Roles_Model::TYPE_LEVEL_ADMIN, Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function index()
    {
        $data = array();
        $data['gridview'] = new Gridview(array(
            'table_name'    => 'Product',
            'model_name'    => 'Product_Model',
            'conditions'    => array(),
            'columns'       => array(
                array(
                    'name'      => 'id',
                    'title'     => 'ID',
                ),
                array(
                    'title'     => 'Name',
                    'filter'     => function($model){
                        return sprintf('<a href="/Product/update/%s">%s</a>', $model->id, $model->name);
                    },
                ),
                array(
                    'title'     => 'Type',
                    'filter'     => function($model){
                        return $model->type == Product_Model::TYPE_TWITTER ? "Twitter design": "Facebook design";
                    },
                ),
                array(
                    'title'     => 'Price',
                    'filter'     => function($model){
                        return price_format($model->price);
                    },
                ),
                array(
                    'title'     => 'Actions',
                    'filter'     => function($model){
                        return sprintf('<a href="/Product/delete/%s"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>', $model->id);
                    },
                ),
            ),
            'pagination' => array(
                'per_page' => 10
            ),
        ));
        $this->layout('admin', 'product/index', $data);
    }

    public function create()
    {
        $data = array(
            'errors'        => array(),
            'status'        => false,
            'medialibrary'  => $this->medialibrary,
        );

        if (isset($_POST['Product'])) {
            $current_user = Users_Model::get_current_user();
            $product = new Product_Model($_POST['Product']);
            $product->hash = substr(md5(time() . $current_user->user_id), 0, 6);
            if (!$product->save()) {
                $data['errors'] = $product->errors->full_messages();
            } else {
                redirect(base_url('Product/index'));
            }
        }

        $this->layout('admin', 'product/create', $data);
    }

    public function update($id)
    {
        if (!$id) redirect(base_url('Product/index'));

        $data = array(
            'errors'        => array(),
            'status'        => false,
            'product'       => Product_Model::find($id),
            'medialibrary'  => $this->medialibrary,
        );

        if (!$data['product']) redirect(base_url('Product/index'));

        if (isset($_POST['Product'])) {
            $data['product']->set_attributes($_POST['Product']);
            if (!$data['product']->save()) {
                $data['errors'] = $data['product']->errors->full_messages();
            } else {
                redirect(base_url('Product/index'));
            }
        }

        $this->layout('admin', 'product/update', $data);
    }

    function attachment($hash)
    {
        $model = Product_Model::first(array(
            'hash' => $hash,
        ));
        if ($model) {
            $ext = pathinfo(ABSPATH . $model->path, PATHINFO_EXTENSION);
            header("Content-Type: image/$ext");
            if (file_exists(ABSPATH . $model->path)) {
                readfile(ABSPATH . $model->path);
                exit;
            }
        }
        echo BASE_URL . 'assets/admin/img/no_image.png';
    }

    function delete($id)
    {
        if ($product = Product_Model::first(array('id' => $id))) {
            $product->delete();
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}