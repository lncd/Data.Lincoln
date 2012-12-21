<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{

		$header['page'] = 'home';
	
		$data['catalogues'] = $this->catalogue_model->all();
	
		$this->load->view('inc/head', $header);
		$this->load->view('home', $data);
		$this->load->view('inc/foot');
		
	}
}