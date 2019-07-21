<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('genetic');
        $this->load->model('Model_Genetic');
        $this->load->model('Model_Product');
    }

    function product()
    {
        $header_data = array(
            'title' => 'Al Romero Natural',
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
                'js/components/mainPage.js'
            )
        );

        $this->load->view('pages/layout/header', $header_data);

        $product = $this->Model_Product->search_one_product($this->uri->segment(3));
        if ($product) {
            $product_data = array(
                'product' => $product
            );
            $this->load->view('pages/components/product_view', $product_data);
        } else {
            $this->load->view('pages/errors/product_view_error.html');
            $products_data = array(
                'principal_products' => $this->Model_Product->return_principal_products()
            );
            $this->load->view('pages/components/best_products', $products_data);
        }

        $this->load->view('pages/layout/footer', $footer_data);
    }
}
