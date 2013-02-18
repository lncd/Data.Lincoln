<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Render extends CI_Controller {

	public function setupNS()
	{
		EasyRdf_Namespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
		EasyRdf_Namespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
		EasyRdf_Namespace::set('ospc', 'http://data.ordnancesurvey.co.uk/ontology/postcode/');
		EasyRdf_Namespace::set('vcard', 'http://www.w3.org/2006/vcard/ns#');
		EasyRdf_Namespace::set('oo', 'http://purl.org/openorg/');
		EasyRdf_Namespace::set('org', 'http://www.w3.org/ns/org#');
		EasyRdf_Namespace::set('cv', 'http://purl.org/captsolo/resume-rdf/0.2/cv');
		EasyRdf_Namespace::set('unilincoln', 'http://id.lincoln.ac.uk/ns/unilincoln#');
		EasyRdf_Namespace::set('bio', 'http://purl.org/vocab/bio/0.1');
		EasyRdf_Namespace::set('dcterms', 'http://dublincore.org/documents/2010/10/11/dcmi-terms/');
		EasyRdf_Namespace::set('dc', 'http://purl.org/dc/elements/1.1/');
		EasyRdf_Namespace::set('ov', 'http://open.vocab.org/terms/');
		EasyRdf_Namespace::set('res', 'http://www.medsci.ox.ac.uk/vocab/researchers/0.1/');
		EasyRdf_Namespace::set('rooms', 'http://vocab.deri.ie/rooms');
		EasyRdf_Namespace::set('spatialrelations', 'http://data.ordnancesurvey.co.uk/ontology/spatialrelations/');
	}

	public function index()
	{
		echo 'Renderer Ready' . PHP_EOL;
	}

	public function buildings_csv()
	{

		echo 'Buildings CSV' . PHP_EOL;

		$buildings = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		$fp = fopen('data/buildings.csv', 'w');

		fputcsv($fp, array(
			'Unique ID',
			'URI',
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
				$building_data->result->id,
				'http://id.lincoln.ac.uk/building/' . $building_data->result->id,
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

	public function buildings_kml()
	{

		echo 'Buildings KML' . PHP_EOL;

		$fp = fopen('data/buildings.kml', 'w');

		fwrite($fp, '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' . "\n");

		$data = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings?limit=200&access_token=' . $_SERVER['NUCLEUS_TOKEN']));

		fwrite($fp, '<kml xmlns="http://www.opengis.net/kml/2.2">' . "\n");
		fwrite($fp, '<Document>' . "\n");
		fwrite($fp, '<name>University of Lincoln</name>' . "\n");

		foreach ($data->results as $building)
		{

			if ($building->latitude !== NULL AND $building->longitude != NULL)
			{

				if ($building->osm_way_id !== NULL)
				{

					$osm = simplexml_load_file('http://openstreetmap.org/api/0.6/way/' . $building->osm_way_id);

					$building_data = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings/id/' . $building->id . '?access_token=' . $_SERVER['NUCLEUS_TOKEN']));

					$building_nodes = array();

					foreach($osm->way->nd as $node)
					{
						$attributes = $node->attributes();
						$node_data = simplexml_load_file('http://openstreetmap.org/api/0.6/node/' . $attributes->ref);
						unset($attributes);
						$node_attributes = $node_data->node->attributes();
						$building_nodes[] = array(
							'lat' => $node_attributes->lat,
							'lon' => $node_attributes->lon
						);
						unset($node_data);
					}

					unset($osm);

					$building->height = max(4, 4 * count($building_data->result->components));

					$building->edge_nodes = $building_nodes;
					unset($building_nodes);

				}

				fwrite($fp, '<Placemark>' . "\n");
				fwrite($fp, '<name>' . htmlspecialchars($building->name) . '</name>' . "\n");

				if (count($building->edge_nodes) > 0)
				{

					fwrite($fp, '<Polygon>' . "\n");
					fwrite($fp, '<extrude>1</extrude>' . "\n");
					fwrite($fp, '<altitudeMode>relativeToGround</altitudeMode>' . "\n");
					fwrite($fp, '<outerBoundaryIs>' . "\n");
					fwrite($fp, '<LinearRing>' . "\n");
					fwrite($fp, '<coordinates>');

					foreach ($building->edge_nodes as $edge_node)
					{
						fwrite($fp, "\n" . $edge_node['lon'] . ',' . $edge_node['lat'] . ',' . $building->height);
					}

					fwrite($fp, "\n" . '</coordinates>' . "\n");
					fwrite($fp, '</LinearRing>' . "\n");
					fwrite($fp, '</outerBoundaryIs>' . "\n");
					fwrite($fp, '</Polygon>' . "\n");
				}
				else
				{
					fwrite($fp, '<Point>' . "\n");
					fwrite($fp, '<coordinates>' . $building->longitude . ',' . $building->latitude . ',0</coordinates>' . "\n");
					fwrite($fp, '</Point>' . "\n");
				}

				fwrite($fp, '</Placemark>' . "\n");

			}
		}

		fwrite($fp, '</Document>' . "\n");
		fwrite($fp, '</kml>');

		fclose($fp);

	}

	public function catalogue_json()
	{
		echo 'Catalogue JSON' . PHP_EOL;

		$resources = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'resources?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=400000'));

		$json = array(
			'metadata' => array(
				'description' => 'The University of Lincoln\'s Library catalogue.'
			)
		);

		foreach ($resources->results as $resource)
		{

			var_dump($resource);

			$resource_object = array(
				'_id' => $resource->bib_id,
				'type' => 'book'
			);
			if (isset($resource->title))
			{
				$resource_object['title'] = $resource->title;
			}
			$json['resources'][] = $resource_object;
			unset($resource_object);
		}

		$fp = fopen('data/library-catalogue.json', 'w');

		fputs($fp, json_encode($json));

		fclose($fp);
	}

	public function colleges_csv()
	{

		echo 'Colleges CSV' . PHP_EOL;

		$colleges = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'colleges?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		$fp = fopen('data/colleges.csv', 'w');

		fputcsv($fp, array(
			'Unique ID',
			'URI',
			'Code',
			'Name'
		));

		foreach ($colleges->results as $college)
		{
			fputcsv($fp, array(
				$college->id,
				$college->uri,
				$college->code,
				$college->title
			));
		}

		fclose($fp);

	}

	public function faculties_csv()
	{

		echo 'Faculties CSV' . PHP_EOL;

		$faculties = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'faculties?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		$fp = fopen('data/faculties.csv', 'w');

		fputcsv($fp, array(
			'Unique ID',
			'URI',
			'Code',
			'Name',
			'College'
		));

		foreach ($faculties->results as $faculty)
		{
			fputcsv($fp, array(
				$faculty->id,
				'http://id.lincoln.ac.uk/faculty/' . $location->id,
				$faculty->code,
				$faculty->title,
				$faculty->college !== NULL ? $faculty->college->code : NULL
			));
		}

		fclose($fp);

	}

	public function locations_csv()
	{

		echo 'Locations CSV' . PHP_EOL;

		$locations = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'locations?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		$fp = fopen('data/locations.csv', 'w');

		fputcsv($fp, array(
			'Unique ID',
			'URI',
			'Estates Code',
			'Name',
			'Parent Location'
		));

		foreach ($locations->results as $location)
		{
			fputcsv($fp, array(
				$location->id,
				'http://id.lincoln.ac.uk/location/' . $location->id,
				$location->estates_code,
				$location->name,
				$location->parent_location !== NULL ? $location->parent_location->estates_code : NULL
			));
		}

		fclose($fp);

	}

	public function schools_csv()
	{

		echo 'Schools CSV' . PHP_EOL;

		$schools = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'schools?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		$fp = fopen('data/schools.csv', 'w');

		fputcsv($fp, array(
			'Unique ID',
			'URI',
			'Code',
			'Name',
			'College'
		));

		foreach ($schools->results as $school)
		{
			fputcsv($fp, array(
				$school->id,
				$school->uri,
				$school->code,
				$school->title,
				$school->faculty !== NULL ? $school->faculty->code : NULL
			));
		}

		fclose($fp);

	}

	public function buildings_rdf($format = 'rdfxml')
	{
		$this->setupNS();

		$graph = new EasyRdf_Graph();

		$description = $graph->resource('http://data.lincoln.ac.uk/data/buildings.'.$format, 'rdf:Description');
		$description->set('dcterms:title', 'University of Lincoln Buildings');
		$corrections = $graph->resource('mailto:ost@lincoln.ac.uk');
		$description->set('oo:corrections', $corrections);
		$license = $graph->resource('http://www.nationalarchives.gov.uk/doc/open-government-licence/');
		$description->set('dcterms:license', $license);

		$unilincoln = $graph->resource('http://lincoln.ac.uk');
		$description->set('dcterms:publisher', $unilincoln);
		$unilincoln_graph = $graph->resource('http://lincoln.ac.uk/', 'org:Organization');
		$unilincoln_graph->set('rdfs:label', 'University of Lincoln');
		$unilincoln_graph->set('foaf:name', 'University of Lincoln');

		$buildings = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'buildings?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		foreach ($buildings->results as $building)
		{
			$building_graph = $graph->resource('http://id.lincoln.ac.uk/building/' . $building->id, 'rdf:Description');
			$type_graph = $graph->resource('http://vocab.deri.ie/rooms/Building');
			$building_graph->set('rdf:Type', $type_graph);
			$building_graph->set('rdfs:label', $building->name);
			$building_graph->set('oo:formalOrganisation', $unilincoln);
			$building_graph->set('skos:notation', $building->id);
			$building_graph->set('unilincoln:nucleusId', $building->id);
			$building_graph->set('unilincoln:estatesCode', $building->estates_code);
			$building_graph->set('ns0:osmWayId', $building->osm_way_id);
			$building_graph->set('ns0:buildYear', $building->build_year);
			$building_graph->set('geo:lat', $building->latitude);
			$building_graph->set('geo:long', $building->longitude);
			$location_graph = $graph->resource('http://id.lincoln.ac.uk/location/'.$building->location->id);
			$building_graph->set('spatialrelations:within', $location_graph);
			$building_graph->set('org:hasPrimarySite', $location_graph);
			$building_graph->set('dcterms:isPartOf', $location_graph);
		}

		$data = $graph->serialise($format);
		if (!is_scalar($data)) {
			$data = var_export($data, true);
		}
		print "<pre>".htmlspecialchars($data)."</pre>";

		$fp = fopen('data/buildings.'.$format, 'w');
		fputs($fp, $data);
		fclose($fp);
	}

	public function locations_rdf($format = 'rdfxml')
	{
		$this->setupNS();

		$graph = new EasyRdf_Graph();

		$description = $graph->resource('http://data.lincoln.ac.uk/data/buildings.'.$format, 'rdf:Description');
		$description->set('dcterms:title', 'University of Lincoln Locations');
		$corrections = $graph->resource('mailto:ost@lincoln.ac.uk');
		$description->set('oo:corrections', $corrections);
		$license = $graph->resource('http://www.nationalarchives.gov.uk/doc/open-government-licence/');
		$description->set('dcterms:license', $license);

		$unilincoln = $graph->resource('http://lincoln.ac.uk');
		$description->set('dcterms:publisher', $unilincoln);
		$unilincoln_graph = $graph->resource('http://lincoln.ac.uk/', 'org:Organization');
		$unilincoln_graph->set('rdfs:label', 'University of Lincoln');
		$unilincoln_graph->set('foaf:name', 'University of Lincoln');

		$locations = json_decode(file_get_contents($_SERVER['NUCLEUS_BASE_URI'] . 'locations?access_token=' . $_SERVER['NUCLEUS_TOKEN'] . '&limit=10000'));

		foreach ($locations->results as $location)
		{
			$location_graph = $graph->resource('http://id.lincoln.ac.uk/building/' . $location->id, 'rdf:Description');
			$type_graph = $graph->resource('http://vocab.deri.ie/rooms/Site');
			$location_graph->set('rdf:Type', $type_graph);
			$location_graph->set('rdfs:label', $location->name);
			$location_graph->set('oo:formalOrganisation', $unilincoln);
			$location_graph->set('skos:notation', $location->id);
			$location_graph->set('unilincoln:nucleusId', $location->id);
			$location_graph->set('unilincoln:estatesCode', $location->estates_code);

			if (isset($location->parent_location))
			{
				$plocation_graph = $graph->resource('http://id.lincoln.ac.uk/location/'.$location->parent_location->id);
				$location_graph->set('spatialrelations:within', $plocation_graph);
				$location_graph->set('org:hasPrimarySite', $plocation_graph);
				$location_graph->set('dcterms:isPartOf', $plocation_graph);
			}
		}

		$data = $graph->serialise($format);
		if (!is_scalar($data)) {
			$data = var_export($data, true);
		}
		print "<pre>".htmlspecialchars($data)."</pre>";

		$fp = fopen('data/locations.'.$format, 'w');
		fputs($fp, $data);
		fclose($fp);
	}
}