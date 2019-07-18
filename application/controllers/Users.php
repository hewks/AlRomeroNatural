<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    protected $user_id = null;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Customers');

        $user_data = $this->session->userdata();
        $this->user_id = (isset($user_data['login'])) ? $user_data['id'] : 9999;
    }

    function index($page = 'login')
    {
        $fecha = date('Y-m-d H:i:s');
        $user_data = $this->session->userdata();
        if (isset($user_data['login'])) {
            if ($user_data['login'] == true) {
                if ($user_data['logout_date'] - strtotime($fecha) <= 0) {
                    $array_items = array('id', 'username', 'email', 'name', 'lastname', 'login_date', 'login', 'logout_date');
                    $this->session->unset_userdata($array_items);
                    redirect(base_url() . 'Users');
                }
            }
        }

        if ($page == 'Register') {
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

        $footer_data = array(
            'scripts' => array(
                'vendor/md5.js',
                'js/components/usersForms.js',
            )
        );

        $this->load->view('pages/layout/header', $header_data);
        $this->load->view('pages/users', $section_data);
        $this->load->view('pages/layout/footer', $footer_data);
    }

    function profile()
    {
        $fecha = date('Y-m-d H:i:s');
        $user_data = $this->session->userdata();
        if (isset($user_data['login'])) {
            if ($user_data['login'] == true) {
                if ($user_data['logout_date'] - strtotime($fecha) <= 0) {
                    $array_items = array('id', 'username', 'email', 'name', 'lastname', 'login_date', 'login', 'logout_date');
                    $this->session->unset_userdata($array_items);
                    redirect(base_url() . 'Users');
                }
            }
        }

        $header_data = array(
            'title' => $this->session->userdata('username') . ' | Al Romero Natural',
            'keywords' => '',
            'description' => '',
            'author' => '',
            'links' => array(),
            'options' => array(
                'google_analitics' => false
            )
        );

        $_search = array(
            'search' => 'id',
            'output' => 'id,name,lastname,username,avatar_url',
            'value' => $this->session->userdata('id')
        );
        $user_data = (array) $this->Model_Customers->search_with_in($_search);

        $section_data = array(
            'fullname' => $user_data['name'] . ' ' . $user_data['lastname'],
            'avatar_image' => $user_data['avatar_url'],
            'name' => $user_data['name'],
            'lastname' => $user_data['lastname'],
            'username' => $user_data['username'],
            'id' => $user_data['id'],
        );

        $footer_data = array(
            'scripts' => array(
                'vendor/md5.js',
                'js/components/profileForms.js',
            )
        );

        $this->load->view('pages/layout/header', $header_data);
        $this->load->view('pages/profile', $section_data);
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
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            $_search = array(
                'search' => 'email',
                'output' => 'id',
                'value' => $login_data['email']
            );
            if (!$this->Model_Customers->bool_search_with($_search)) {
                $error = $this->errors->return_error('100002');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                if (!$this->Model_Customers->email_login($login_data)) {
                    $error = $this->errors->return_error('100003');
                    $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                    $output[] = array(
                        'status' => false,
                        'response' => $error['error_text']
                    );
                } else {
                    $success = $this->errors->return_error('200001');
                    $this->Model_Errors->create($this->errors->create_error_data($success['error_num'], $this->user_id));
                    $output[] = array(
                        'status' => true,
                        'response' => $success['error_text']
                    );
                    $_search = array(
                        'search' => 'email',
                        'output' => 'email,username,name,lastname,id,genre,avatar_url',
                        'value' => $login_data['email']
                    );
                    $user = (array) $this->Model_Customers->search_with_in($_search);
                    $fecha = date('Y-m-d H:i:s');
                    $array_items = array('id', 'username', 'email', 'name', 'lastname', 'login_date', 'login', 'logout_date', 'avatar_url', 'genre');
                    $this->session->unset_userdata($array_items);
                    $user['login_date'] = strtotime($fecha);
                    $user['logout_date'] = strtotime('+1 hour', strtotime($fecha));
                    $user['login'] = true;
                    $user['session_code'] = 'Customer';
                    $this->session->set_userdata((array) $user);
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

        $genre = $this->input->post('genre');
        switch ($genre) {
            case '1':
                $avatar = base_url() . 'assets/images/avatars/user-icon.png';
                break;
            case '2':
                $avatar = base_url() . 'assets/images/avatars/user-icon-2.png';
                break;
            case '3':
                $avatar = base_url() . 'assets/images/avatars/user-icon-2.png';
                break;
        }

        $register_data = array(
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'name' => $this->input->post('name'),
            'lastname' => $this->input->post('lastname'),
            'genre' => $genre,
            'avatar_url' => $avatar,
            'created_at' => $fecha,
        );

        if (!$this->genetic->validate_array($register_data)) {
            $error = $this->errors->return_error('100001');
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            $_search = array(
                'search' => 'email',
                'output' => 'id',
                'value' => $register_data['email']
            );
            if ($this->Model_Customers->bool_search_with($_search)) {
                $error = $this->errors->return_error('100004');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                if (!$this->Model_Customers->create($register_data)) {
                    $error = $this->errors->return_error('100005');
                    $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                    $output[] = array(
                        'status' => false,
                        'response' => $error['error_text']
                    );
                } else {
                    $success = $this->errors->return_error('200002');
                    $this->Model_Errors->create($this->errors->create_error_data($success['error_num'], $this->user_id));
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

    function user_exit()
    {
        header('Content-Type: application/json');
        $output = array();
        $error = $this->errors->return_error('200003');
        $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
        $array_items = array('id', 'username', 'email', 'name', 'lastname', 'login_date', 'login', 'logout_date');
        $this->session->unset_userdata($array_items);
        $output[] = array(
            'status' => true,
            'response' => 'Hasta Luego. :)'
        );
        echo json_encode($output);
        exit();
    }

    function edit_user()
    {
        header('Content-Type: application/json');
        $output = array();
        $fecha = date('Y-m-d H:i:s');

        $edit_data = array(
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'lastname' => $this->input->post('lastname'),
            'username' => $this->input->post('username'),
            'updated_at' => $fecha,
        );

        if (!$this->genetic->validate_array($edit_data)) {
            $error = $this->errors->return_error('100001');
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            if (!$this->Model_Customers->update_with_id($edit_data)) {
                $error = $this->errors->return_error('100006');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                $error = $this->errors->return_error('200004');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => true,
                    'response' => $error['error_text']
                );
            }
        }

        echo json_encode($output);
        exit();
    }

    function change_password()
    {
        header('Content-Type: application/json');
        $output = array();
        $fecha = date('Y-m-d H:i:s');

        $edit_data = array(
            'password' => $this->input->post('password'),
            'updated_at' => $fecha,
            'id' => $this->input->post('id'),
        );

        if (!$this->genetic->validate_array($edit_data)) {
            $error = $this->errors->return_error('100001');
            $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
            $output[] = array(
                'status' => false,
                'response' => $error['error_text']
            );
        } else {
            if (!$this->Model_Customers->update_with_id($edit_data)) {
                $error = $this->errors->return_error('100007');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => false,
                    'response' => $error['error_text']
                );
            } else {
                $error = $this->errors->return_error('200005');
                $this->Model_Errors->create($this->errors->create_error_data($error['error_num'], $this->user_id));
                $output[] = array(
                    'status' => true,
                    'response' => $error['error_text']
                );
            }
        }

        echo json_encode($output);
        exit();
    }
}
