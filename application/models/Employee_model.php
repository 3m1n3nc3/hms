<?php

class Employee_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_employees()
    {
        $query = $this->db->from('employee')->join('department', 'department.department_id=employee.department_id')->get();
        $data = array();

        foreach (@$query->result() as $row)
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

    function addEditEmployee($data)
    {
        $save = array(
            'employee_username' => $data['username'], 
            'employee_password' => $data['password'], 
            'employee_firstname' => $data['firstname'], 
            'employee_lastname' => $data['lastname'], 
            'employee_telephone' => $data['telephone'], 
            'employee_email' => $data['email'], 
            'department_id' => $data['department_id'], 
            'employee_type' => $data['type'], 
            'employee_salary' => $data['salary'], 
            'employee_hiring_date' => $data['hiring_date']
        ); 
        
        if (isset($data['employee_id'])) 
        { 
            $this->db->where('employee_id', $data['employee_id']);
            $this->db->update('employee', $save); 
        }
        else
        {
            $this->db->insert('employee', $save);
            return $this->db->affected_rows();
        }
    } 

    function deleteEmployee($employee_id)
    {
        $this->db->delete('employee', array('employee_id' => $employee_id));
        return $this->db->affected_rows();
    } 

    function getEmployee($employee_id)
    {
        $query = $this->db->get_where('employee', array('employee_id' => $employee_id));
        return $query->result();
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
