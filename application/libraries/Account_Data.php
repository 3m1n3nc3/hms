<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_Data {

    public $CI;

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    /*
    this checks to see if the admin is logged in
    we can provide a link to redirect to, and for the login page, we have $default_redirect,
    this way we can check if they are already logged in, but we won't get stuck in an infinite loop if it returns false.
     */

    public function logged_in()
    {    
        return (bool) $this->CI->session->userdata('username') or get_cookie('username');
    }  

    public function customer_logged_in()
    {    
        return (bool) $this->CI->session->userdata('cusername') or get_cookie('cusername');
    }    

    public function is_logged_in()
    {

        if ($this->CI->session->has_userdata('username') or get_cookie('username')) 
        {
            $_user = ($this->CI->session->userdata('username') ?? get_cookie('username'));
            $user = $this->fetch($_user);
            if (!$user) 
            {
                redirect('login');
            } 
            else 
            {
                return true;
            }
        } 
        else 
        {
            $this->CI->session->set_userdata('redirect_to', current_url());
            redirect('login');
        }
    }

    public function is_customer_logged_in($redirect = FALSE)
    {
        if ($this->CI->session->has_userdata('cusername') or get_cookie('cusername')) 
        {
            $_user = ($this->CI->session->userdata('cusername') ?? get_cookie('cusername'));
            $user = $this->fetch($_user, 1);
            if (!$user) 
            { 
                if ($redirect) redirect("account/login");
                return FALSE;
            } 
            else 
            {
                return TRUE;
            }
        } 
        else 
        {
            $this->CI->session->set_userdata('redirect_customer_to', current_url());
            redirect('account/login');
        }
    }

    public function user_redirect()
    {
        if ($this->CI->session->has_userdata('username') OR get_cookie('username')) 
        {
            $_user = ($this->CI->session->userdata('username') ?? get_cookie('username'));
            $user = $this->fetch($_user); 
            if ($user) 
            {
                redirect('dashboard');   
            } 
            else 
            {
                redirect('login');
            }
        } 
        else 
        {
            redirect('login');
        }
    }

    public function customer_redirect()
    {
        if ($this->CI->session->has_userdata('cusername') OR get_cookie('cusername')) 
        {
            $_user = ($this->CI->session->userdata('cusername') ?? get_cookie('cusername'));
            $user = $this->fetch($_user, 1); 
            if ($user) 
            {
                redirect('account');   
            } 
            else 
            {
                redirect('account/login');
            }
        } 
        else 
        {
            redirect('account/login');
        }
    }

    public function fetch($id = null, $customer = 0)
    {   
        if ($customer === 1) 
        {
            $data = $this->CI->customer_model->get_customer(['id' => $id]); 

            if ($data['customer_firstname'] && $data['customer_lastname']) 
            {
                $data['name'] = $data['customer_firstname'] . ' ' . $data['customer_lastname'];
            } 
            elseif ($data['customer_firstname']) 
            {
                $data['name'] = $data['customer_firstname'];
            } 
            elseif ($data['customer_lastname']) 
            {
                $data['name'] = $data['customer_lastname'];
            } 
            elseif ($data) 
            {
                $data['name'] = $data['customer_username'];
            }  
        } 
        else 
        {
            $data = $this->CI->employee_model->getEmployee($id, 1);  

            if ($data['employee_firstname'] && $data['employee_lastname']) 
            {
                $data['name'] = $data['employee_firstname'] . ' ' . $data['employee_lastname'];
            } 
            elseif ($data['employee_firstname']) 
            {
                $data['name'] = $data['employee_firstname'];
            } 
            elseif ($data['employee_lastname']) 
            {
                $data['name'] = $data['employee_lastname'];
            } 
            elseif ($data) 
            {
                $data['name'] = $data['employee_username'];
            }  
        }

        $data['name'] = $data['name'] ?? NULL;
        return $data;
    }

    public function user_logout()
    {   
        delete_cookie('username');
        $this->CI->session->unset_userdata(['uid', 'username', 'fullname', 'department_name']);
        $this->CI->session->sess_destroy();
    }

    public function customer_logout()
    {   
        delete_cookie('cusername');
        $this->CI->session->unset_userdata(['cuid', 'cusername', 'cemail']); 
        $this->CI->session->sess_destroy();
    }

    public function employee_login($user)
    {   
        $data = $this->CI->user_model->fetch_user($user['employee_id']);
        $dept = $this->CI->services_model->getService($data['department_id']);

        $space = $data['employee_firstname'] && $data['employee_lastname'] ? ' ' : '';
        $fullname = ($data['employee_firstname'] || $data['employee_lastname'] ? ($data['employee_firstname'] ?? '') . $space . ($data['employee_lastname'] ?? '') : $data['employee_username']);

        $data = array(
            'uid' => $data['employee_id'],
            'username' => $data['employee_username'],
            'fullname' => $fullname,
            'department_name' => $dept[0]->service_name
        ); 
        $this->CI->session->set_userdata($data);
    }

    public function customer_login($data)
    {     
        $data = array(
            'cuid' => $data['customer_id'],
            'cemail' => $data['customer_email'], 
            'cusername' => $data['customer_username']
        );
        $this->CI->session->set_userdata($data);
    }

    public function days_diff($far_date = NULL, $close_date = NULL)
    {   
        $far_date = $far_date ? $far_date : date('Y-m-d', strtotime('tomorrow'));
        $close_date = $close_date ? $close_date : date('Y-m-d', strtotime('NOW'));

        $far_date = new DateTime($far_date ? $far_date : date('Y-m-d', strtotime('tomorrow')));
        $close_date = new DateTime($close_date ? $close_date : date('Y-m-d', strtotime('NOW')));        

        if ($far_date > $close_date) {
            return true;
        }
        return false; 
    }

}
