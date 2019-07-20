<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('genetic');
		$this->load->model('Model_Genetic');
		$this->load->model('Model_Product');
	}

	function index()
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

		$section_data = array(
			'principal_products' => $this->Model_Product->return_principal_products()
		);

		$footer_data = array(
			'scripts' => array(
				'js/components/mainPage.js'
			)
		);

		$this->load->view('pages/layout/header', $header_data);
		$this->load->view('pages/main',$section_data);
		$this->load->view('pages/layout/footer', $footer_data);
	}
}
