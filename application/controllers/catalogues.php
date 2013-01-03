<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogues extends CI_Controller {

	public function view($slug)
	{
	
		$header['page'] = 'catalogue';
		
		if ($catalogue = $this->catalogue_model->from_slug($slug))
		{
		
			$this->load->model('dataset_model');
			$this->load->model('resource_model');
			$this->load->helper('text');
			
			$data['catalogue'] = $catalogue;
			$data['datasets'] = $this->dataset_model->in_catalogue($catalogue->id);
			
			foreach($data['datasets'] as $dataset)
			{
				$data['resources'][$dataset->dataset_id] = $this->resource_model->in_dataset($dataset->dataset_id);
			}
	
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