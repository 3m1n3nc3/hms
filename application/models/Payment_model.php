<?php

class Payment_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    } 

    /**
     * This function takes the data array as a parameter and will fetch the specified record.
     * If the data array is not provided, then it will fetch all the records form the table.
     * @param array $data
     * @param bool  $row
     * @return array
     */
    public function get_payments($data = null, $row = false) 
    {
        $this->db->select('*')->from('payments');
        if (is_array($data)) 
        {
            if (isset($data['reference'])) 
            {
                $this->db->where('reference', $data['reference']); 
            } 

            if (isset($data['customer_id'])) 
            {
                $this->db->where('customer_id', $data['customer_id']); 
            }  

            if (isset($data['id'])) 
            {
                $this->db->where('id', $data); 
            }
         
            if (isset($data['page'])) 
            {
                $this->db->limit($this->config->item('per_page'), $data['page']);
            }
        } 
        else 
        {
            $this->db->order_by('id');
        }

        $query = $this->db->get();

        if ($data != null && !isset($data['customer_id']) || $row === true) 
        {
            return $query->row_array();
        } 
        else 
        {
            return $query->result_array();
        }
    }


    /**
     * This function takes id as a parameter and will count the specified record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param integer $id 
     * @return array
     */
    public function count_payment($id = null) 
    {
        $this->db->select('COUNT(id) AS sold, SUM(amount) AS total')->from('payments');
        if ($id != null) 
        {
            $this->db->where('product_id', $id); 
        }

        $query = $this->db->get();
        return $query->row_array();
    }


    /**
     * This function takes the data array as a parameter and will delete the specified record. 
     * @param array $data 
     * @return array
     */
    public function remove_payments($data) 
    {
        if (isset($data['customer_id'])) 
        {
            $this->db->where('customer_id', $data['customer_id']);
        } 
        else 
        {
            $this->db->where('id', $data);
        }
        $this->db->delete('payments');
        return $this->db->affected_rows();
    } 


    /**
     * This function takes the data array as a parameter and will update the specified record.
     * If the data array is not provided, then it will insert a new record.
     * @param array $data
     * @param bool  $row
     * @return array
     */
    public function add_payments($data) 
    {
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('payments', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('payments', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }  
}
