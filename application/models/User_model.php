<?php

class User_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * This function takes id as a parameter and will fetch the record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param int $id
     * @return mixed
     */
    public function fetch_user($id = null) {
        $this->db->select('*')->from('employee');
        if ($id != null) 
        {
            $this->db->where('employee_id', $id);
            $this->db->or_where('employee_username', $id);
            $this->db->or_where('employee_email', $id); 
        } 
        else
        {
            $this->db->order_by('employee_id');
        }

        $query = $this->db->get();
        if ($id != null)
        {
            return $query->row_array();
        } 
        else
        {
            return $query->result_array();
        }
    }

    public function check_login($data) 
    {
        $this->db->select('employee_id, employee_username, employee_password, employee_email');
        $this->db->from('employee');
        $this->db->where('employee_email', $data['username']);
        $this->db->or_where('employee_username', $data['username']);
        $this->db->where('employee_password', MD5($data['password']));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) 
        {
            return $query->row_array();
        } 
        else 
        {
            return false;
        }
    }

    public function customer_login($data) 
    {
        $this->db->select('customer_id, customer_username, customer_password, customer_email');
        $this->db->from('customer');
        $this->db->where('customer_email', $data['username']);
        $this->db->or_where('customer_username', $data['username']);
        $this->db->where('customer_password', MD5($data['password']));
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) 
        {
            return $query->row_array();
        } 
        else 
        {
            return false;
        }
    }
} 
