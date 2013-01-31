<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Publish extends CI_Controller {

	public function index()
	{
	
		$header['page'] = 'publish';
	
		$this->load->view('inc/head', $header);
		$this->load->view('publish');
		$this->load->view('inc/foot');
		
	}
}