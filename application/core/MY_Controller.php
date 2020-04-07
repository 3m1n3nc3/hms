<?php 

class MY_Controller extends CI_Controller
{ 
    public function __construct()
    {
        parent::__construct();  
        $this->CI =& get_instance();  

        // $CI->output->enable_profiler(TRUE);
        if ($this->input->get('set_theme')) 
        {
            $this->session->set_userdata('site_theme', $this->input->get('set_theme'));
        }

        if ($this->session->userdata('site_theme')) 
        {
            $this->h_theme = $this->session->userdata('site_theme');
        }
        else
        {
            $this->h_theme = 'modern';
        }

        $this->uid      = $this->CI->session->userdata('uid');
        $this->username = $this->CI->session->userdata('username');
        $this->fullname = $this->CI->session->userdata('fullname');
        $this->logged_user = $this->employee_model->getEmployee($this->uid, 1);
        $this->show_guide  = !$this->CI->session->userdata('show_guide');
        $this->department_name = $this->CI->session->userdata('department_name');

        $this->cuid     = $this->CI->session->userdata('cuid');
        $this->username = $this->CI->session->userdata('cusername');
        $this->logged_customer = $this->cuid ? $this->customer_model->get_customer(['id' => $this->cuid]) : [];

        $this->currency = 'NGN';
        $this->cr_symbol = $this->intl->currency(3, $this->currency);
    }

    function check_login()
    {
        $this->account_data->is_logged_in();
    } 
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); 
        $this->check_login();  
    } 
} 

class Frontsite_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->uri->segment(2, 0) !== 'login') 
        {
            $this->account_data->is_customer_logged_in();
        }
    } 
} 
