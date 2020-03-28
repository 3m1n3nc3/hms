<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departments extends Admin_Controller {

	public function index()
	{
		$departments = $this->departments_model->get_departments();

		$viewdata = array('departments' => $departments);

		$data = array('title' => 'Departments - ' . HOTEL_NAME, 'page' => 'departments');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/departments/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
		
		if($this->input->post("departmentName"))
		{
			$departmentName = $this->input->post("departmentName");
			$departmentBudget = $this->input->post("departmentBudget");
			
			$this->departments_model->addDepartment($departmentName, $departmentBudget);
			$this->session->set_flashdata('message', alert_notice('New Department Created', 'success'));
			redirect("departments");
		}

		$data = array('title' => 'Add Department - ' . HOTEL_NAME, 'page' => 'departments');
		$this->load->view($this->h_theme.'/header', $data);
		$departments = $this->departments_model->get_departments();
		$viewdata = array('departments' => $departments);
		$this->load->view($this->h_theme.'/departments/add',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($department_id)
	{
		$this->departments_model->deleteDepartment($department_id);
		redirect("/departments");
	}

	public function edit($department_id)
	{
		if($this->input->post("departmentName"))
		{
			$departmenName = $this->input->post("departmentName");
			$departmentBudget = $this->input->post("departmentBudget");
			
			$this->departments_model->editEmployee($department_id, $departmenName, $departmentBudget);
			$this->session->set_flashdata('message', alert_notice('Department Updated', 'success'));
			redirect("departments");
		}
		
		$data = array('title' => 'Edit Department - ' . HOTEL_NAME, 'page' => 'departments');
		$this->load->view($this->h_theme.'/header', $data);

		$department = $this->departments_model->getDepartment($department_id);
		
		$viewdata = array('department'  => $department[0]);

		$this->load->view($this->h_theme.'/departments/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
