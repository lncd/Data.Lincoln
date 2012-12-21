<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Share extends CI_Controller {

	public function index()
	{
	
		$header['page'] = 'share';
	
		$this->load->view('inc/head', $header);
		$this->load->view('share');
		$this->load->view('inc/foot');
		
	}
}