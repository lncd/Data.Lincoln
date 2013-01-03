<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Render extends CI_Controller {

	public function index()
	{
	
		echo 'Renderer Ready' . PHP_EOL;
		
	}
	
	public function locations_csv()
	{
	
		echo 'Locations CSV' . PHP_EOL;
		
		$locations = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'locations?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));
		
		$fp = fopen('data/locations.csv', 'w');
		
		fputcsv($fp, array(
			'Estates Code',
			'Name',
			'Parent Location',
			'X'
		));
		
		foreach ($locations->results as $location)
		{
			fputcsv($fp, array(
				$location->estates_code,
				$location->name,
				$location->parent_location !== NULL ? $location->parent_location->estates_code : NULL,
				'X'
			));
		}
		
		fclose($fp);
		
	}
}