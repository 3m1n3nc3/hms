<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends Admin_Controller { 

	public function index()
	{
		$config['base_url']   = site_url('employee/list/');
        $config['total_rows'] = count($this->employee_model->get_employees()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0);

		$employees = $this->employee_model->get_employees(['page' => $_page]); 
		$viewdata  = array('employees' => $employees); 
        $viewdata['pagination'] = $this->pagination->create_links(); 

		$data = array('title' => 'Employees - '. HOTEL_NAME, 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function list()
	{
		$config['base_url']   = site_url('employee/list/');
        $config['total_rows'] = count($this->employee_model->get_employees()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0);

		$employees = $this->employee_model->get_employees(['page' => $_page]); 
		$viewdata  = array('employees' => $employees); 
        $viewdata['pagination'] = $this->pagination->create_links(); 

		$data = array('title' => 'Employees - '. HOTEL_NAME, 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add($employee_id = '')
	{
		if ($employee_id == 'my_profile') {
			$employee_id = $this->uid;
		}
		$departments = $this->employee_model->getDepartments();
		$employee = $this->employee_model->getEmployee($employee_id, 1);
		$viewdata = array('departments' => $departments, 'employee' => $employee);
		$data = array('title' => 'Add Employee - '. HOTEL_NAME, 'page' => 'employee');

		if ($this->input->post()) {
            $up  = $this->input->post('telephone') != $employee['employee_telephone'] ? '|is_unique[employee.employee_telephone]' : '';
            $ue  = $this->input->post('email') != $employee['employee_email'] ? '|is_unique[employee.employee_email]' : '';
            $uus = $this->input->post('username') != $employee['employee_username'] ? '|is_unique[employee.employee_username]' : '';
            $require_pass = !$employee['employee_id'] ? '|required' : '';

	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
	        $this->form_validation->set_rules('username', 'Username', 'trim|alpha_dash|required'.$uus); 
	        $this->form_validation->set_rules('password', 'Password', 'trim'.$require_pass);
	        $this->form_validation->set_rules('email', 'Email', 'trim|required'.$ue);
            $this->form_validation->set_rules('telephone', 'Phone number', 'trim|numeric|required|min_length[6]|regex_match[/^[0-9]{11}$/]'.$up); 
	        $this->form_validation->set_rules('department_id', 'Department', 'trim|required');

	        if ($this->form_validation->run() !== FALSE) 
	        {   
				$save = array(
		            'employee_username' => strtolower($this->input->post("username")),  
		            'employee_firstname' => $this->input->post("firstname"), 
		            'employee_lastname' => $this->input->post("lastname"), 
		            'employee_telephone' => $this->input->post("telephone"), 
		            'employee_email' => $this->input->post("email"), 
		            'department_id' => $this->input->post("department_id"), 
		            'employee_type' => $this->input->post("type"), 
		            'employee_salary' => $this->input->post("salary"), 
		            'employee_address' => $this->input->post("address"), 
		            'employee_city' => $this->input->post("city"), 
		            'employee_state' => $this->input->post("state"), 
		            'employee_country' => $this->input->post("country"), 
		            'employee_hiring_date' => $this->input->post("hiring_date")
		        );
		        if ($this->input->post("password")) {
		        	$save['employee_password'] = MD5($this->input->post("password"));
		        }

	        	$msg = 'New employee added';
				if ($employee['employee_id']) 
				{
					$msg = $employee['employee_username'] . ' Has been Updated';
					$save['employee_id'] = $employee['employee_id'];
				} 

				$this->employee_model->addEditEmployee($save);
				$this->session->set_flashdata('message', alert_notice($msg, 'success'));
				redirect("employee");
			}
		}

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/add',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function profile($employee_id = '')
	{
		if ($employee_id == 'my_profile') {
			$employee_id = $this->uid;
		}

		$employee = $this->employee_model->getEmployee($employee_id, 1);
		$department = $this->employee_model->employee_department($employee['department_id']);
		$viewdata = array('department' => $department, 'employee' => $employee);
		$data = array('title' => $employee['employee_firstname'] . ' ' .$employee['employee_lastname'] .' - '. HOTEL_NAME, 'page' => 'employee');
 
		$post = $this->input->post();
		if ($post) 
		{ 
			$unique_email = ($employee['employee_email'] !== $post['employee_email'] ? '|is_unique[employee.employee_email]' : '');
			$unique_tel = ($employee['employee_telephone'] !== $post['employee_telephone'] ? '|is_unique[employee.employee_telephone]' : '');

	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');  
	        $this->form_validation->set_rules('employee_email', 'Email', 'trim|required'.$unique_email);
            $this->form_validation->set_rules('employee_telephone', 'Phone number', 'trim|numeric|required|min_length[6]|regex_match[/^[0-9]{11}$/]'.$unique_tel);  

	        if ($this->form_validation->run() !== FALSE) 
	        {   
				$save = $this->input->post();
				unset($save['update_profile']);

	        	$msg = 'New employee added';
				if ($employee['employee_id']) 
				{
					$msg = $employee['employee_id'] === $this->uid ? 'Your profile has been Updated' : 'Employee profile Updated';
					$save['employee_id'] = $employee['employee_id'];
				}  

				$this->employee_model->addEditEmployee($save);
				$this->session->set_flashdata(array('update_profile'=> TRUE, 'message' => alert_notice($msg, 'success')));
				// redirect("employee");
	        } 
		}

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/view',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($employee_id)
	{
		if ($this->employee_model->deleteEmployee($employee_id)) 
		{
			$this->session->set_flashdata('message', alert_notice('Employee Deleted', 'success'));
			redirect("employee");
		}
	}

	public function edit($employee_id)
	{
		if($this->input->post("username") && $this->input->post("password") && $this->input->post("email"))
		{
			$save['username']  = $this->input->post("username");
			$save['password']  = MD5($this->input->post("password"));
			$save['firstname'] = $this->input->post("firstname");
			$save['lastname']  = $this->input->post("lastname");
			$save['telephone'] = $this->input->post("telephone");
			$save['email']  = $this->input->post("email");
			$save['department_id'] = $this->input->post("department_id");
			$save['type']   = $this->input->post("type");
			$save['salary'] = $this->input->post("salary");
			$save['hiring_date'] = $this->input->post("hiring_date");
			$save['employee_id'] = $employee_id;
			
			$this->employee_model->addEditEmployee($save);
			$this->session->set_flashdata('message', alert_notice('Employee data has been updated', 'success'));
			redirect("employee");
		}
		
		$data = array('title' => 'Edit Employee - '. HOTEL_NAME, 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);

		$departments = $this->employee_model->getDepartments();
		$employee = $this->employee_model->getEmployee($employee_id);
		
		$viewdata = array('departments' => $departments, 'employee'  => $employee[0]);
		$this->load->view($this->h_theme.'/employee/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
