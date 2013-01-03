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
			'Parent Location'
		));
		
		foreach ($locations->results as $location)
		{
			fputcsv($fp, array(
				$location->estates_code,
				$location->name,
				$location->parent_location !== NULL ? $location->parent_location->estates_code : NULL
			));
		}
		
		fclose($fp);
		
	}
	
	public function buildings_csv()
	{
	
		echo 'Buildings CSV' . PHP_EOL;
		
		$buildings = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));
		
		$fp = fopen('data/buildings.csv', 'w');
		
		fputcsv($fp, array(
			'Estates Code',
			'Name',
			'Location',
			'Location Code',
			'Build Year',
			'Latitude',
			'Longitude',
			'OSM Way ID'
		));
		
		foreach ($buildings->results as $building)
		{
		
			$building_data = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings/id/' . $building->id . '?access_token=' . $_SERVER['NUCLEUS_TOKEN']));
		
			fputcsv($fp, array(
				$building_data->result->estates_code,
				$building_data->result->name,
				$building_data->result->location !== NULL ? $building_data->result->location->name : NULL,
				$building_data->result->location !== NULL ? $building_data->result->location->estates_code : NULL,
				$building_data->result->build_year !== NULL ? $building_data->result->build_year : NULL,
				$building_data->result->latitude !== NULL ? $building_data->result->latitude : NULL,
				$building_data->result->longitude !== NULL ? $building_data->result->longitude : NULL,
				$building_data->result->osm_way_id !== NULL ? $building_data->result->osm_way_id : NULL
			));
		}
		
		fclose($fp);
		
	}
}