<?php

class Employee_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
    
    function get_employees($data = array())
    {
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $this->db->order_by('employee_id DESC');
        $query = $this->db->from('employee')->join('department', 'department.department_id=employee.department_id')->get();
        $data = array();

        foreach (@$query->result() as $row)
        {
            $data[] = $row; 
        }
        if(count($data))
            return $data;
        return false;
    } 

    function addEditEmployee($data)
    {       
        if (isset($data['employee_id'])) 
        { 
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->update('employee', $data); 
            return $this->db->affected_rows();
        }
        else
        {
            $this->db->insert('employee', $data);
            return $this->db->insert_id();
        }
    } 

    function deleteEmployee($employee_id)
    {
        $this->db->delete('employee', array('employee_id' => $employee_id));
        return $this->db->affected_rows();
    } 

    function getEmployee($employee_id, $get_array = null)
    {
        $query = $this->db->get_where('employee', array('employee_id' => $employee_id));
        if ($get_array) {
            return $query->row_array();
        }
        return $query->result();
    }

    function employee_department($employee_id)
    {
        $this->db->where('department_id', $employee_id);
        $query = $this->db->from('department')->get(); 
        return $query->row_array();
    }

    function getDepartments()
    {
        $query = $this->db->from('department')->get();
        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row;
            // $row->customer_id
            // $row->customer_username
            // $data[0]->customer_id
        }
        if(count($data))
            return $data;
        return false;
    }   
}
