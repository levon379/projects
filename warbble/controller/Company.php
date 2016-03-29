<?php

class Company extends Controller
{
    public function  __construct()
    {
        parent::__construct();
        $this->load->model('Company_Model');
        $this->current_user = Users_Model::get_current_user();

        $this->_js = array(
            array(
                'type' => 'admin',
                'file' => 'angular/core/angular.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'url' => 'https://checkout.stripe.com/checkout.js',
                'location' => 'outside_footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/core/angular-chosen.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/core/angular-ui-router.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/core/angular-sanitize.min.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/core/ui-bootstrap-tpls-0.14.3.min.js',
                'location' => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'angular/modules/company.module.js',
                'location'  => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/directives/gridpagin.js',
                'location' => 'footer',
            ),
            array(
                'type' => 'admin',
                'file' => 'angular/filters/company.filter.js',
                'location' => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'angular/services/Company.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'angular/controllers/company.controller.js',
                'location'  => 'footer',
            ),
            array(
                'type'      => 'admin',
                'file'      => 'angular/config/company.config.js',
                'location'  => 'footer',
            ),
        );

        $this->_css = array(
            array(
                'type'      => 'admin',
                'file'      => 'bootstrap-chosen.css',
            ),
        );

        $this->set_filters(array(
            'index'         => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'create'        => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'update'        => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            '_list'         => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'delete'        => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
            'payment'       => array(Roles_Model::TYPE_LEVEL_LOGGED_IN),
        ));

    }

    public function index()
    {
        $this->layout('admin', 'company/index', array());
    }

    public function _list()
    {
        if (!$this->current_user) {
            $this->__response(array(
                'errors'   => array(
                    sprintf('Please <a href="%s">login.</a>', base_url('login')),
                ),
            ), 403);
        }
        $limit = 10;
        $offset = isset($_GET['page'])? ($_GET['page'] - 1) * $limit: 0;
        $companies = $this->current_user->get_company_data($limit, $offset);
        $response['models'] = array();
        if (!empty($companies['companies'])) {
            $response['models'] = array_map(function($item){
                return $item->attributes();
            }, $companies['companies']['items']);
        }
       $response['total'] = $companies['total']['companies'];
       $response['limit'] = $limit;
        $this->__response($response);
    }

    public function create()
    {
        if (!$this->__is_allow()) {
            $this->__response(array(
                'errors'   => array(
                    sprintf('Please update your package until <a href="#/payment/gold">Gold</a> or <a href="#/payment/platinum">Platinum</a>  version.'),
                ),
            ), 403);
        }

        if ($post = $this->__get_ajax_data()) {
            $company_users = $post['users'];
            unset($post['users']);
            $company = new Company_Model($post);
            $company->admin_id = $this->current_user->user_id;
            $company->date = time();
            if (!$status = $company->save()) {
                $response['errors'] = $company->errors->full_messages();
            } else {
                $company->add_users($company_users);
                if ($company->admin->package->pack == 'gold') {
                    $company->admin->package->info->is_spent = true;
                }
                $company->admin->package->info->save();
            }
            $response['status'] = $status;
        } else {
            $response['package'] = $this->current_user->package->pack;
            $response['companies'] = array_map(function($item){
                return $item->attributes();
            }, Company_Model::all(array('admin_id' => $this->current_user->user_id)));
            $response['users'] = array_map(function($item){
                return array(
                    'user_id' => $item->user_id,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'email' => $item->email,
                );
            }, Users_Model::all());
        }
        $this->__response($response);
    }

    public function payment($package)
    {
        if (!$this->current_user) {
            $this->__response(array(
                'errors'   => array(
                    sprintf('Please <a href="%s">login.</a>', base_url('login')),
                ),
            ), 403);
        }

        if ($post = $this->__get_ajax_data()) {
            $result = $this->current_user->update_package($post['id'], $package);
            $response['status'] = $result['status'];
        } else {
            $response['stripe'] = $this->__stripe_data($package);
        }
        $this->__response($response);
    }

    public function update($id)
    {
        $company = Company_Model::find($id);
        if ($post = $this->__get_ajax_data()) {
            $company_users = $post['users'];
            unset($post['users']);
            $company->set_attributes($post);
            $company->admin_id = $this->current_user->user_id;
            if (!$status = $company->save()) {
                $response['errors'] = $company->errors->full_messages();
            } else {
                $company->delete_users();
                $company->add_users($company_users);
            }
            $response['status'] = $status;
        } else {
            $response['role'] = $this->__company_role($id);
            $response['package'] = $this->current_user->package->pack;
            $response['companies'] = array_map(function($item){
                return $item->attributes();
            }, Company_Model::all(array('admin_id' => $this->current_user->user_id)));
            $response['model'] = $company->attributes();
            $response['status'] = true;
            $response['users'] = array_map(function($item){
                return array(
                    'user_id' => $item->user_id,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'email' => $item->email,
                );
            }, Users_Model::all());
            $response['admin'] = $company->get_admin()? $company->get_admin()->user_id: false;
            $response['employees'] = array_map(function($item){
                return $item->user_id;
            }, $company->get_employees());
        }
        $this->__response($response);
    }

    public function delete()
    {
        $response = array();
        if ($post = $this->__get_ajax_data()) {
            if ($company = Company_Model::find($post['id'])) {
                if ($company->admin_id != $this->current_user->user_id) {
                    $this->__response(array(
                        'errors'   => array(
                            sprintf("You don't have permissions for this action."),
                        ),
                    ), 403);
                } else {
                    $company->delete_cascade();
                    $response['status'] = true;
                    $response['total'] = Company_Model::count(array('admin_id' => $this->current_user->user_id));
                }
            }
        }
        $this->__response($response);
    }

    private function __company_role($company_id)
    {
        $my_companies = $this->current_user->my_companies;
        foreach ($my_companies as $company) {
            if ($company->id == $company_id)
                return 'superadmin';
        }
        $admin_companies = $this->current_user->get_company_data();
        if (!empty($admin_companies['companies'])) {
            foreach ($admin_companies['companies']['items'] as $company) {
                if ($company->id == $company_id)
                    return 'admin';
            }
        }

        return false;
    }

    private function __is_allow()
    {
        $info = $this->current_user->package->info;
        if (!$info) return false;
        if ($this->current_user->package->pack == 'platinum') {
            return true;
        }

        return
            (
                $this->current_user->package->pack == 'gold' ||
                (
                    $this->current_user->package->pack == 'gold' && date('Y-m-d', $info->end_date) > date('Y-m-d')
                )
            ) && $info->is_spent == false
        ;
    }

    private function __stripe_data($pack = 'gold')
    {
        $package = Users_Package_Model::GetStripeUserData();
        $config = get_config('stripe');
        $response = array();
        $currency = Users_Package_Model::GetCurrency();
        $plan = \Stripe\Plan::retrieve($config[$currency["currency_code"]][$pack]);
        $response['key'] = $config['publishable_key'];
        $response['email'] = $this->current_user->email;
        $response['name'] = $plan->name;
        $response['amount'] = $plan->amount;
        $response['currency'] = $currency['currency_code'];
        $response['description'] = sprintf('%s package (%s%d.00)', $package['package'], $currency['currency_symbol'], $plan->amount / 100);
        return $response;
    }
    
    
    public function __get_ajax_data()
    {
        if ($postdata = file_get_contents("php://input")) {
            return json_decode($postdata, TRUE);
        } else {
            return false;
        }
    }

    private function __response($data, $status = 200)
    {
        $this->ajax_response($data, $status);
    }
}