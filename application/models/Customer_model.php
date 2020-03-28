<?php

class Customer_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
    
    function get_customer($data)
    {
        if (isset($data['id'])) 
        {
            $this->db->select('customer_id, customer_firstname, customer_lastname, customer_TCno, customer_address, customer_state, customer_city, customer_country, customer_telephone,  customer_email')->from('customer');
            $this->db->where('customer_id', $data['id']);
            $this->db->or_where('customer_TCno', $data['id']);

            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            $query = $this->db->get_where('customer', array('customer_TCno' => $data));
        }

        if($query) {
            return $query->result();
        } else {
            return $query;
        }
    } 

    function list_customers($data = '')
    {
        $this->db->select('customer_id, customer_firstname, customer_lastname, customer_TCno, customer_address, customer_state, customer_city, customer_country, customer_telephone,  customer_email')->from('customer');
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    function add_customer($data)
    {
        $data['customer_id'] = $data['cid'];
        unset($data['cid']);
        if (isset($data['customer_id'])) 
        {
            $this->db->where('customer_id', $data['customer_id']);
            $this->db->update('customer', $data);
        }
        else
        {
            $this->db->insert('customer', $data);
        }
//        return $this->db->affected_rows();
    }

    function get_active_customers()
    {
        $date = date('Y-m-d');
        $q = $this->db->query("CALL get_customers('$date')");

        $data = array();
        foreach ($q->result() as $customer) {
            $data[] = $customer;
        }
        return $data;
    }

    function delete_customer($customer_id)
    {
        $this->db->delete('room_sales', array('customer_id' => $customer_id));
        $this->db->delete('reservation', array('customer_id' => $customer_id));
        $this->db->delete('customer', array('customer_id' => $customer_id));
        return $this->db->affected_rows();
    }

}
