<?php

class Accounting_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    } 

    function addExpense($data = array())
    { 
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('expenses', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('expenses', $data);
            return $this->db->insert_id();
        }
    } 

    function get_expense($data = array())
    {
        $this->db->select('*')->from('expenses');

        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']); 
        }
        
        if (isset($data['employee_id'])) 
        {
            $this->db->where('employee_id', $data['employee_id']); 
        } 
        
        if (isset($data['from'])) 
        {
            $this->db->where('date >=', $data['from']); 
        } 
        
        if (isset($data['to'])) 
        {
            $this->db->where('date <=', $data['to']); 
        } 
        
        $this->db->order_by('date');
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get();
        if (isset($data['id']))
        {
            return $query->row_array();
        }
        else
        {
            return $query->result_array(); 
        }
    }

    function delete_expense($id = array())
    {   
        $this->db->where('id', $id); 
        $this->db->delete('expenses'); 
        return $this->db->affected_rows(); 
    } 

    function min_max($min_max = 0)
    {   
        $order = $min_max ? 'DESC' : 'ASC';
        $this->db->limit('1'); 
        $this->db->order_by('date '.$order); 
        $query = $this->db->select('date')->from('expenses')->get();
        return $query->row_array();
    } 

    function statistics($data = null)
    {   
        if (isset($data)) 
        { 
            if (isset($data['service'])) 
            { 
                $query = $this->db->select('(SELECT SUM(order_price) FROM sales_service_orders WHERE service_name = \''.$data['service'].'\') AS sales')->get();
            }
        }
        else
        {
            $query = $this->db->select('(SELECT SUM(amount) FROM payments) AS payments, (SELECT SUM(order_price) FROM sales_service_orders) AS sales, (SELECT SUM(room_sales_price) FROM room_sales) AS room_sales, (SELECT COUNT(customer_id) FROM customer) AS customers')->get();
        }
        return $query->row_array();
    } 
}
