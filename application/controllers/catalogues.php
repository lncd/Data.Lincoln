<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogues extends CI_Controller {

	public function view($slug)
	{
	
		$header['page'] = 'catalogue';
		
		if ($catalogue = $this->catalogue_model->from_slug($slug))
		{
		
			$this->load->model('dataset_model');
			
			$data['catalogue'] = $catalogue;
			$data['datasets'] = $this->dataset_model->in_catalogue($catalogue->id);
	
			$this->load->view('inc/head', $header);
			$this->load->view('catalogue', $data);
			$this->load->view('inc/foot');
			
		}
		else
		{
			show_404();
		}
		
	}
}