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
        $this->db->select('employee_id, employee_username, employee_password');
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
}


// SELECT * FROM employee WHERE employee_username = '$username' AND employee_password = '$password'

// $username = admin\' or 1=1--
// $password = 12345

// SELECT * FROM employee WHERE employee_username = 'admin' or 1=1--' AND employee_password = '12345'

// $restoran_name = "Cihad'in Yeri"

// SELECT * FROM restorans WHERE restoran_name = '$restoran_name'
// SELECT * FROM restorans WHERE restoran_name = 'Cihad'in Yeri'
