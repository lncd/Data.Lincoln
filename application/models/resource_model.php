<?php

class Resource_model extends CI_Model {
    
    function in_dataset($dataset_id)
    {
        $query = $this->db
        	->where('dataset_id', $dataset_id)
        	->select('resources.id as resource_id')
        	->select('resources.uri as resource_uri')
        	->select('formats.name as format_name')
        	->join('formats', 'formats.id = resources.format_id')
        	->order_by('formats.name')
        	->get('resources');
        return $query->result();
    }

}