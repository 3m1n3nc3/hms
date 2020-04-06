<?php

class Locale_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct(); 
    } 


    /**
     * This function will fetch and return data from the countries table
     * @param string $key
     * @return mixed
     */
    function fetch_countries($data = array())
    { 
        if ($data) 
        {   
            if (isset($data['id'])) 
            {
                $this->db->where('id', $data['id']);
            }

            if (isset($data['sortname'])) 
            {
                $this->db->where('sortname', $data['sortname']);
            }

            if (isset($data['name'])) 
            {
                $this->db->where('name', $data['name']);
            }

            if (isset($data['phonecode'])) 
            {
                $this->db->where('phonecode', $data['phonecode']);
            }

            $query = $this->db->select('*')->from('countries')->get();
            return $query->row_array();
        } 
        else 
        {
            $query = $this->db->select('*')->from('countries')->get();
            return $query->result_array();
        }
    } 


    function fetch_states($data = array())
    { 
        if ($data) 
        {
            if (isset($data['id'])) 
            {
                $this->db->where('id', $data['id']);
            }

            if (isset($data['name'])) 
            {
                $this->db->where('name', $data['name']);
            }

            if (isset($data['country_id'])) 
            {
                $this->db->where('country_id', $data['country_id']);
            }

            $query = $this->db->select('*')->from('states')->get();

            if (isset($data['id']) || isset($data['name'])) 
            {
                return $query->row_array();
            }
  
            return $query->result_array(); 
        }
    }  


    function fetch_cities($data = array())
    { 
        if ($data) 
        {
            if (isset($data['id'])) 
            {
                $this->db->where('id', $data['id']);
            }

            if (isset($data['name'])) 
            {
                $this->db->where('name', $data['name']);
            }

            if (isset($data['state_id'])) 
            {
                $this->db->where('state_id', $data['state_id']);
            }

            $query = $this->db->select('*')->from('cities')->get(); 
            
            if (isset($data['id']) || isset($data['name'])) 
            {
                return $query->row_array();
            } 

            return $query->result_array();
        }
    }  
}
