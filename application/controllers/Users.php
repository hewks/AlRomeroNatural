<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Customers');
    }

    function index()
    {
        $header_data = array(
            'title' => 'Usuarios | Al Romero Natural',
            'keywords' => '',
            'description' => '',
            'author' => '',
            'links' => array(),
            'options' => array(
                'google_analitics' => false
            )
        );

        if ($this->input->get('register') != '') {
            $section_data = array(
                'register' => 'hw-active-form',
                'register_btn' => 'hw-active-selector',
                'login' => '',
                'login_btn' => ''
            );
        } else {
            $section_data = array(
                'register' => '',
                'register_btn' => '',
                'login' => 'hw-active-form',
                'login_btn' => 'hw-active-selector'
            );
        }

        $footer_data = array(
            'scripts' => array(
                'js/components/usersForms.js'
            )
        );

        $this->load->view('pages/layout/header', $header_data);
        $this->load->view('pages/users', $section_data);
        $this->load->view('pages/layout/footer', $footer_data);
    }

    function email_login()
    {
        header('Content-Type: application/json');
        $output = array();

        $login_data = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password')
        );

        if (!$this->genetic->validate_array($login_data)) {
            $error = $this->errors->return_error('100001');
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            $search = array(
                'search' => 'email',
                'output' => 'id',
                'value' => $login_data['email']
            );
            if (!$this->Model_Customers->bool_search_with($search)) {
                $error = $this->errors->return_error('100002');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                if (!$this->Model_Customers->email_login($login_data)) {
                    $error = $this->errors->return_error('100003');
                    $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
                    $output[] = array(
                        'status' => false,
                        'response' => $error['error_text']
                    );
                } else {
                    $success = $this->errors->return_error('200001');
                    $this->Model_Errors->create($this->errors->create_error_data($success['error_num']));
                    $output[] = array(
                        'status' => true,
                        'response' => $success['error_text']
                    );
                }
            }
        }

        echo json_encode($output);
        exit();
    }

    function email_register()
    {
        header('Content-Type: application/json');
        $output = array();
        $fecha = date('Y-m-d H:i:s');

        $register_data = array(
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'name' => $this->input->post('name'),
            'lastname' => $this->input->post('lastname'),
            'created_at' => $fecha,
        );

        if (!$this->genetic->validate_array($register_data)) {
            $error = $this->errors->return_error('100001');
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            $search = array(
                'search' => 'email',
                'output' => 'id',
                'value' => $register_data['email']
            );
            if ($this->Model_Customers->bool_search_with($search)) {
                $error = $this->errors->return_error('100004');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                if (!$this->Model_Customers->create($register_data)) {
                    $error = $this->errors->return_error('100005');
                    $this->Model_Errors->create($this->errors->create_error_data($error['error_num']));
                    $output[] = array(
                        'status' => false,
                        'response' => $error['error_text']
                    );
                } else {
                    $success = $this->errors->return_error('200002');
                    $this->Model_Errors->create($this->errors->create_error_data($success['error_num']));
                    $output[] = array(
                        'status' => true,
                        'response' => $success['error_text']
                    );
                }
            }
        }

        echo json_encode($output);
        exit();
    }
}
