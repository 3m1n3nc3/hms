<?php

class Services_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
    
    function get_restaurants()
    {
        $query = $this->db->from('sales_services')->get();
        $data = array();

        foreach (@$query->result() as $row)
        {
            $data[] = $row;
        }
        if(count($data))
            return $data;
        return false;
    }  

    function addService($data)
    {  
        if (isset($data['service_id'])) 
        {
            $this->db->where('service_name', $data['service_id']);
            $this->db->or_where('id', $data['service_id']);
            unset($data['service_id']);
            $this->db->update('sales_services', $data); 
        }
        else
        {
            $this->db->insert('sales_services', $data);
        }
        return $this->db->affected_rows();
    }

    function deleteService($service_name)
    {
        $this->db->delete('sales_services', array('service_name' => $service_name));
        return $this->db->affected_rows();
    }

    function getService($service_name)
    {
        $query = $this->db->get_where('sales_services', array('service_name' => $service_name));
        return $query->result();
    }

    function order_service($data = array())
    {
        $this->db->insert('sales_service_orders', $data);
    }

    function get_stock($data = array())
    {
        $this->db->select('item_id, item_name, item_details, item_quantity, item_price, item_service, item_add_date')->from('sales_service_stock');

        if (isset($data['item_id'])) 
        {
            $this->db->where('item_id', $data['item_id']);
            $this->db->or_where('item_name', $data['item_id']);
        }
        elseif (isset($data['item_service'])) 
        {
            $this->db->where('item_service', $data['item_service']); 
        } 
        else
        {
            $this->db->order_by('item_add_date DESC');
        }
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get();
        if (isset($data['item_id']))
        {
            return $query->row_array();
        }
        else
        {
            return $query->result_array(); 
        }
    }

    function add_stock($data = array())
    {  
        $this->db->insert('sales_service_stock', $data);  
    }

    function update_stock($data = array())
    { 
        $this->db->where('item_id', $data['item_id']); 
        $this->db->update('sales_service_stock', array('item_quantity' => $data['item_quantity']));  
    }

    function delete_stock($data = array())
    { 
        $this->db->where('item_id', $data['item_id']); 
        $this->db->delete('sales_service_stock'); 
    }

    function getSalesEntry($service_name)
    {
        $query = $this->db->get_where('sales_services', array('service_name' => $service_name));
        return $query->result();
    }
}
