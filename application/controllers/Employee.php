<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends Admin_Controller { 

	public function add()
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

			$this->employee_model->addEditEmployee($save);
			$this->session->set_flashdata('message', alert_notice('New employee added', 'success'));
			redirect("employee");
		}

		$data = array('title' => 'Add Employee - '. HOTEL_NAME, 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$departments = $this->employee_model->getDepartments();
		$viewdata = array('departments' => $departments);
		$this->load->view($this->h_theme.'/employee/add',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($employee_id)
	{
		$this->employee_model->deleteEmployee($employee_id);

		if ($this->employee_model->addEditEmployee($save)) 
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

	public function index()
	{
		$employees = $this->employee_model->get_employees();

		$viewdata = array('employees' => $employees);

		$data = array('title' => 'Employees - '. HOTEL_NAME, 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
