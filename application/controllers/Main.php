<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
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

		$footer_data = array(
			'scripts' => array(
				'js/components/simpleSlider.js'
			)
		);

		$this->load->view('pages/layout/header', $header_data);
		$this->load->view('pages/main');
		$this->load->view('pages/layout/footer', $footer_data);
	}
}
