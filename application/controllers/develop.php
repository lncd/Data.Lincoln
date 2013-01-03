<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Develop extends CI_Controller {

	public function index()
	{
	
		$header['page'] = 'develop';
	
		$this->load->view('inc/head', $header);
		$this->load->view('develop');
		$this->load->view('inc/foot');
		
	}
}