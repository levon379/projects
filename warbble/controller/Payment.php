<?php

class Payment extends Controller{
    public $config = array();
    public $user_package = object;
    public $stripe_user = object;
    
    public function __construct()
    {
        parent::__construct();
        $this->config = get_config('stripe');
        $this->user_package = Users_Package_Model::GetPackage();
        $this->stripe_user = Users_Package_Model::GetStripeUser($this->user_package);
    }
    
    public function ChangePack($pack_id) {
        if ($pack_id){
            $currency = Users_Package_Model::GetCurrency();
            $package = Users_Package_Model::GetStripeUserData();
            $this->stripe_user->plan = $pack_id;
            $this->stripe_user->save();
            $pack = array_search($pack_id, $this->config[$currency['currency_code']]);
            if (!$pack){
                $pack = array_search($pack_id, $this->config["quarterly_".$currency['currency_code']]);
            }
            $this->user_package->pack = $pack;
            $this->user_package->pack_id = $pack_id;
            $this->user_package->save();

            if (!$package_info = Users_package_info_Model::first(array(
                'id' => $this->user_package->stripe_id
            ))) {
                $package_info = new Users_package_info_Model();
                $package_info->id = $this->user_package->stripe_id;
            }
            $package_info->set_attributes(array(
                'name' => $package['package'],
                'status' => $package['status'],
                'package_id' => $package['package_id'],
                'start_date' => isset($package['package_start'])? strtotime($package['package_start']): strtotime($package['trial_start']),
                'end_date' => isset($package['package_end'])? strtotime($package['package_end']): strtotime($package['trial_end']),
                'is_spent' => false,
            ));
            $package_info->save();
            redirect(BASE_URL.'Users/upgrade');
        }
        else {
            redirect(BASE_URL);
        }
    }
   
    public function ChangeCardDefault($card_id = false) {
        if ($card_id){
            $this->stripe_user->default_source = $card_id;
            $this->stripe_user->save();  
            redirect(BASE_URL.'Users/upgrade');
        }
        else redirect(BASE_URL);
    }
    
    public function DeleteCard($card_id = false) {
        if ($card_id){
            try {
                $this->stripe_user->sources->retrieve($card_id)->delete();
            } catch (Exception $e) {
                redirect(BASE_URL.'Users/upgrade');
                echo $e->getMessage();
            }
            redirect(BASE_URL.'Users/upgrade');
        }
        else redirect(BASE_URL);
    }
    
    public function AddCard($pack_id = NULL, $token = NULL) {
        if (!$token){
            $token = $_REQUEST['stripeToken'];
        }
        if ($token){
            $this->stripe_user->sources->create(array("source" => $token));
            if ($pack_id){
                self::ChangePack($pack_id);
            }
            if($this->is_ajax()){
                $cards = Users_Package_Model::GetStripeUserData();
                $card = array ('brand'    => $cards['cards'][0]->brand,
                               'last4'    => $cards['cards'][0]->last4,
                               );
                echo json_encode($card);
            }
            else {
                redirect(BASE_URL.'Users/upgrade');
            }
        }
        else redirect(BASE_URL);
    }
    
    public function GetPrice($package_id) {
        if($this->is_ajax()){
           $plan = \Stripe\Plan::retrieve($package_id);
           if ($package_id > 16){
               $quartely = " per month";
           } else {
               $quartely = "";
           }
           $result = array ('amount'    => $plan->amount,
                            'name'      => $plan->name,
                            'quartely'  => $quartely
                           );
           echo json_encode($result);
        } 
    }

    public function PaymentConfirmation ($amount, $pack_id) {
        $dis = array();
        $currency = Users_Package_Model::GetCurrency();
        $dis['currency'] = $currency["currency_symbol"];
        $dis['token'] = $_REQUEST['stripeToken'];
        $dis['pack_id'] = $pack_id;
        $dis['amount'] = $amount;
        $dis['view'] = 'users/confirm';
        $this->view_front( $dis );
    }
}