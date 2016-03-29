<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Login extends Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
    }

    public function index() {
        echo "Boris?";
        die;
    }

    public function login($social = NULL) {
        $dis = array();

        if ($social != NULL) {

            switch ($social) {

                case "facebook":
                    $response = users_model::create_facebook_account();
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
                    break;

                case "twitter":
                    $response = users_model::create_twitter_account(base_url('login/twitter'));
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
                    break;
            }
        }

        if ($this->input->post()) {
            $user = $this->users_model->getUser($this->input->post(), true);
            if (!empty($user)) {
                $newdata = array(
                    'first_name' => $user[0]['first_name'],
                    'last_name' => $user[0]['last_name'],
                    'email' => $user[0]['email'],
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($newdata);

                if ($user[0]['type'] == 1) {
                    redirect(base_url('Reseller'));
                } elseif ($user[0]['type'] == 0) {
                    redirect(base_url('Dashboard'));
                } else {
                    redirect(base_url('home'));
                }
            } else {
                $data['message'] = '<p class="error">The email or password do not match those on file. Or you have not activated your account.</p>';
            }
        }

        $data['view'] = "login";
        $data['user_name'] = "Boris";
        $this->view_front($data);
    }

    public function signup() {

        $dis = array();

        if ($this->input->post()) {
            $user = $this->users_model->getUser($this->input->post());
            if (!empty($user)) {
                $dis['mes'] = '<p class="error">The email was already used previously. Please use another email address.</p>';
            } else {

                $this->form_validation->set_rules('first_name', 'Last Name', 'required');
                $this->form_validation->set_rules('last_name', 'Firts Name', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|max_length[12]');
                $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|matches[password]');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
                if ($this->form_validation->run() != FALSE) {
                    $registration_data = $this->input->post();
                    $active = md5(now());
                    $registration_data['account_type'] = 1;
                    $registration_data['active'] = $active;
                    $user_id = $this->users_model->signUp($registration_data, true);
                    $body = "Thank you for registering izCMS page. An activation email has been sent to the email address you provided. Session you click the link to activate your account \n\n ";
                    $body .= base_url() . "users/active/" . str_replace("'", "", $active);
                    if (mail($_POST['email'], 'Activate account at izCMS', $body, 'FROM: localhost')) {
                        $message = "<p class='success'>Your account has been successfully registered. Email has been sent to your address. You must click the link to activate your account before using it.</p>";
                    } else {
                        $message = "<p class='error'>Can not send an email to you. We apologize for this inconvenience.</p>";
                    }
                    $data['mes'] = $message;
                }
            }
        }
        $data['view'] = "signup";
        $data['user_name'] = "Boris";
        $this->view_front($data);
    }

    public function logout() {
        $array_items = array('first_name','last_name', 'email','logged_in');
        $this->session->unset_userdata($array_items);
        redirect('/home');
    }

}
