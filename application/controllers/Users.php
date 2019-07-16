<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
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
}
