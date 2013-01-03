<?php

class Dataset_model extends CI_Model {
    
    function in_catalogue($catalogue_id)
    {
        $query = $this->db
        	->where('catalogue_id', $catalogue_id)
        	->select('datasets.id as dataset_id')
        	->select('datasets.name as dataset_name')
        	->select('datasets.blurb as dataset_blurb')
        	->select('datasets.corrections_name as corrections_name')
        	->select('datasets.corrections_email as corrections_email')
        	->select('licences.name as licence_name')
        	->select('licences.url as licence_url')
        	->select('licences.statement as licence_statement')
        	->join('licences', 'licences.id = datasets.licence_id')
        	->order_by('datasets.name')
        	->get('datasets');
        return $query->result();
    }

}