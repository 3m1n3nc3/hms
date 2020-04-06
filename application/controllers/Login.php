<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller { 

	public function index()
	{ 
		$viewdata = array();

        // Validate Input
        $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>'); 
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->input->post())
		{
			if($this->form_validation->run() !== FALSE)
			{
				$login_data['username'] = $this->input->post("username");
				$login_data['email'] 	= $this->input->post("email");
				$login_data['password'] = $this->input->post("password");

				if($user = $this->user_model->check_login($login_data)) 
				{
					$this->account_data->employee_login($user); 
					redirect("admin/dashboard");
				}
				else
				{
					$this->session->set_flashdata('message', alert_notice('Invalid Username or Password', 'error', FALSE, 'FLAT')); 
				}
			}
			else 
			{
				$this->session->set_flashdata('message', alert_notice(validation_errors(), 'error', FALSE, 'FLAT')); 
			}
		}

		$data = array('title' => 'Login - ' . HOTEL_NAME, 'page' => 'login');
		// $this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/login', array_merge($viewdata, $data));
		// $this->load->view($this->h_theme.'/footer');
	}

	public function logout()
	{
		$this->account_data->user_logout();
		redirect("/");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
