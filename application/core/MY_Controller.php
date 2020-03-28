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
        $this->department_name = $this->CI->session->userdata('department_name');
        $this->show_guide      = !$this->CI->session->userdata('show_guide');
    }

    function check_login()
    {
        if(!$this->uid)
            redirect("login");
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
