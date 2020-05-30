<?php

class Employee_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');

        $this->uid         = $this->CI->session->userdata('uid');
        $this->logged_user = $this->getEmployeeRole(($this->uid ?? ''), 1);
        $this->this_role   = $this->logged_user['role'];
    }
    
    function get_employees($data = array())
    {        
        if (!isset($data['bypass_role']) && isset($this->this_role))
        {
            $this->db->where('employee.role <=', $this->this_role);
        }

        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $this->db->order_by('employee_id DESC');
        $query = $this->db->from('employee')->join('sales_services', 'sales_services.id=employee.department_id')->get();
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
        if (!isset($data['bypass_role']) && isset($this->this_role))
        {
            $this->db->where('employee.role <=', $this->this_role);
        }

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
        if (!isset($employee_id['bypass_role']))
        {
            $this->db->where('employee.role <=', $this->this_role);
        }

        if (isset($employee_id['id'])) 
        {
            $employee_id = $employee_id['id'];
        }

        $this->db->delete('employee', array('employee_id' => $employee_id));
        return $this->db->affected_rows();
    } 

    function getEmployeeRole($employee_id)
    {   
        return $this->db->where('employee_id', $employee_id)->select('role, role_id')->from('employee')->get()->row_array(); 
    }

    function getEmployee($employee_id, $get_array = null)
    {   
        if (!isset($employee_id['bypass_role']))
        {
            $this->db->where('employee.role <=', $this->this_role);
        }

        if (isset($employee_id['id'])) 
        {
            $employee_id = $employee_id['id'];
        }

        $query = $this->db->get_where('employee', array('employee_id' => $employee_id));
        if ($get_array) 
        {
            return $query->row_array();
        }
        return $query->result();
    }

    function employee_department($department_id)
    {
        $this->db->where('id', $employee_id);
        $query = $this->db->from('sales_services')->get(); 
        return $query->row_array();
    }  
}
