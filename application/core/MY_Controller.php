<?php 

class MY_Controller extends CI_Controller
{ 
    public function __construct()
    {
        parent::__construct();   
        $this->config->load('config_');

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

        $this->uid      = $this->session->userdata('uid');
        $this->username = $this->session->userdata('username');
        $this->fullname = $this->session->userdata('fullname');
        $this->logged_user     = $this->employee_model->getEmployee($this->uid, 1);
        $this->show_guide      = !$this->session->userdata('show_guide');
        $this->department_name = $this->session->userdata('department_name');

        $this->cuid            = $this->session->userdata('cuid');
        $this->username        = $this->session->userdata('cusername');
        $this->logged_customer = $this->cuid ? $this->customer_model->get_customer(['id' => $this->cuid]) : [];

        $this->currency        = 'NGN';
        $this->cr_symbol       = $this->intl->currency(3, $this->currency);
    } 
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); 
        $this->account_data->is_logged_in();
        service_point_access_session(); 
    } 
} 

class Frontsite_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(); 
    } 
} 
