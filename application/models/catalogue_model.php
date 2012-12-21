<?php

class Catalogue_model extends CI_Model {
    
    function all()
    {
        $query = $this->db->order_by('name')->get('catalogues');
        return $query->result();
    }
    
    function from_slug($slug)
    {
        $query = $this->db->where('slug', $slug)->get('catalogues');
        if ($query->num_rows() == 1)
        {
	        return $query->row();
        }
        else
        {
	        return FALSE;
        }
    }

}