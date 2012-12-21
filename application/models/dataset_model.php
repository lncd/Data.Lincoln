<?php

class Dataset_model extends CI_Model {
    
    function in_catalogue($catalogue_id)
    {
        $query = $this->db->where('catalogue_id', $catalogue_id)->order_by('name')->get('datasets');
        return $query->result();
    }

}