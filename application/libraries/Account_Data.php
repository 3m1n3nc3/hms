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
        return (bool) $this->CI->session->userdata('admin') or get_cookie('admin');
    }

    public function user_logged_in()
    { 
        return (bool) $this->CI->session->userdata('username') or get_cookie('username');
    }    

    public function is_logged_in($default_redirect = false)
    {
        $admin = ($this->CI->session->userdata('admin') ? $this->CI->session->userdata('admin') : get_cookie('admin'));

        if (!$admin) {

            $_SESSION['redirect_to'] = current_url();
            redirect('access/login/admin');

            return false;
        } else {

            if ($default_redirect) {

                redirect('admin/admin/dashboard');
            }
            return true;
        }
    }

    public function is_logged_in_user($role = false)
    {

        if ($this->CI->session->has_userdata('username') or get_cookie('username')) {
            $_user = ($this->CI->session->userdata('username') ? $this->CI->session->userdata('username') : get_cookie('username'));
            $user = $this->fetch($_user);
            if (!$role) {
                redirect('access/login');
            } else {
                if ($user['role'] == $role) {
                    return true;
                } else {
                    redirect($user['role'] . '/unauthorized');
                }
            }
        } else {
            $_SESSION['redirect_to_user'] = current_url();
            redirect('access/login');
        }
    }

    public function user_redirect()
    {
        if ($this->CI->session->has_userdata('username')) {
            $_user = ($this->CI->session->userdata('username') ? $this->CI->session->userdata('username') : get_cookie('username'));
            $user = $this->fetch($_user);
            $role = $user['role'];
            if ($role == "user") {
                redirect('users/account');   
            } else {
                redirect('access/login');
            }
        } else {
            redirect('access/login');
        }
    }

    public function fetch($id = null, $admin = 0)
    {   
        if ($admin === 0) {
            $data = $this->CI->user_model->get($id); 
        } else {
            $data = $this->CI->admin_model->get($id); 
        }

        if ($data['fname'] && $data['fname']) {
            $data['name'] = $data['fname'] . ' ' . $data['lname'];
        } elseif ($data['fname']) {
            $data['name'] = $data['fname'];
        } elseif ($data['lname']) {
            $data['name'] = $data['lname'];
        } elseif ($data) {
            $data['name'] = $data['username'];
        } else {
            $data['name'] = '';
        }
        return $data;
    }

    public function user_logout()
    {   
        delete_cookie('username');
        $this->CI->session->unset_userdata(['uid', 'username', 'fullname', 'department_name']);
        $this->CI->session->sess_destroy();
    }

    public function admin_logout()
    {   
        delete_cookie('admin');
        $this->CI->session->unset_userdata('admin');
        $this->CI->session->sess_destroy();
    }

    public function employee_login($user)
    {   
        $data = $this->CI->user_model->fetch_user($user['employee_id']);
        $dept = $this->CI->departments_model->getDepartment($data['department_id']);

        $space = $data['employee_firstname'] && $data['employee_lastname'] ? ' ' : '';
        $fullname = ($data['employee_firstname'] || $data['employee_lastname'] ? ($data['employee_firstname'] ?? '') . $space . ($data['employee_lastname'] ?? '') : $data['employee_username']);

        $data = array(
            'uid' => $data['employee_id'],
            'username' => $data['employee_username'],
            'fullname' => $fullname,
            'department_name' => $dept[0]->department_name
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
