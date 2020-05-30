<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends Admin_Controller 
{ 

    /**
     * This will list all employees 
     * @return null             Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{
        // Check if the user has permission to access this module and redirect to 401 if not
        error_redirect(has_privilege('manage-employee'), '401'); 

		$config['base_url']   = site_url('employee/list/');
        $config['total_rows'] = count($this->employee_model->get_employees()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0); 

		$employees = $this->employee_model->get_employees(['page' => $_page]); 
		$viewdata  = array('employees' => $employees); 
        $viewdata['pagination'] = $this->pagination->create_links(); 

		$data = array('title' => 'Employees - '. my_config('site_name'), 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * An alias of the index 
     * @return null             Does not return anything but uses code igniter's view() method to render the page
     */
	public function list()
	{
        // Check if the user has permission to access this module and redirect to 401 if not
        error_redirect(has_privilege('manage-employee'), '401'); 

		$config['base_url']   = site_url('employee/list/');
        $config['total_rows'] = count($this->employee_model->get_employees()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0);

		$employees = $this->employee_model->get_employees(['page' => $_page]); 
		$viewdata  = array('employees' => $employees); 
        $viewdata['pagination'] = $this->pagination->create_links(); 

		$data = array('title' => 'Employees - '. my_config('site_name'), 'page' => 'employee');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/employee/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods allow for adding and updating employees
     * @param  string   $employee_id    Id of the employee records to retrieve if updating
     * @return null                     Does not return anything but uses code igniter's view() method to render the page
     */
	public function add($employee_id = '')
	{
        if ($employee_id == 'my_profile') 
        {
            $employee_id = $this->uid;
        } 
        else
        {
            // Check if the user has permission to access this module and redirect to 401 if not
            error_redirect(has_privilege('manage-employee'), '401'); 
        }
		$departments = $this->services_model->get_service(); 
		$employee = $this->employee_model->getEmployee($employee_id, 1);
		$viewdata = array('departments' => $departments, 'employee' => $employee);
		$data = array('title' => 'Add Employee - '. my_config('site_name'), 'page' => 'employee');

		if ($this->input->post()) {
            $up  = $this->input->post('telephone') != $employee['employee_telephone'] ? '|is_unique[employee.employee_telephone]' : '';
            $ue  = $this->input->post('email') != $employee['employee_email'] ? '|is_unique[employee.employee_email]' : '';
            $uus = $this->input->post('username') != $employee['employee_username'] ? '|is_unique[employee.employee_username]' : '';
            $require_pass = !$employee['employee_id'] ? '|required' : '';

	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
	        $this->form_validation->set_rules('username', lang('username'), 'trim|alpha_dash|required'.$uus); 
	        $this->form_validation->set_rules('password', lang('password'), 'trim'.$require_pass);
	        $this->form_validation->set_rules('email', lang('email_address'), 'trim|required'.$ue);
            $this->form_validation->set_rules('telephone', lang('phone'), 'trim|numeric|required|min_length[6]|regex_match[/^[0-9]{11}$/]'.$up); 
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
					$msg = $employee['employee_username'] . lang('has_been_updated');
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


    /**
     * This methods allow viewing of a employee's profile
     * @param  string   $employee_id    Id of the employee records to retrieve 
     * @return null                     Does not return anything but uses code igniter's view() method to render the page
     */
	public function profile($employee_id = '')
	{
		if ($employee_id == 'my_profile') 
        {
			$employee_id = $this->uid;
		} 
        else
        {
            // Check if the user has permission to access this module and redirect to 401 if not
            error_redirect(has_privilege('manage-employee'), '401'); 
        }

		$employee = $this->employee_model->getEmployee($employee_id, 1);
		$department = $this->services_model->getService($employee['department_id'], 1);
		$viewdata = array('department' => $department, 'employee' => $employee);
		$data = array('title' => $employee['employee_firstname'] . ' ' .$employee['employee_lastname'] .' - '. my_config('site_name'), 'page' => 'employee');
 
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
					$msg = $employee['employee_id'] === $this->uid ? lang('your_profile_updated') : lang('employee_updated');
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


    /**
     * Deletes an employee record
     * @param  string   $employee_id    Id of the employee to delete
     * @return null                     Redirects to the employee list
     */
	function delete($employee_id = '')
	{
        // Check if the user has permission to access this module and redirect to 401 if not
        error_redirect(has_privilege('manage-employee'), '401'); 

		if ($this->employee_model->deleteEmployee($employee_id)) 
		{
			$this->session->set_flashdata('message', alert_notice(lang('employee_deleted'), 'success'));
			redirect("employee");
		}
	} 


    /**
     * This methods allows for assigning permissions and privileges to employees
     * @param  string   $action     Specifies if you are to {create} and update or {assign} privileges
     * @param  string   $action_id  Id of the customer to assign privilege or privilege to update
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function permissions($action = 'create', $action_id = '')
	{
        // Check if the user has permission to access this module and redirect to 401 if not
        error_redirect(has_privilege('manage-privilege'), '401');  

        $data = $this->account_data->fetch($action_id);

        $data['privileges']  = $this->privilege_model->get($action == 'create' ? $action_id : '');
        $data['action_id']   = $action_id;
        $data['action'] = $action;

        if ($action == 'assign') 
        {
            $u = $this->account_data->fetch($action_id);
            error_redirect(has_privilege('super') || !has_privilege('super', o2Array($u)), '401'); 
        }

        // Generate or assign privileges  
        if ($this->input->post('action')) 
        {
            $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>'); 
            if ($action == 'assign') 
            {
                $this->form_validation->set_rules('id', lang('employee_id'), 'trim|numeric|required'); 
            }
            elseif ($action == 'create') 
            {
                $this->form_validation->set_rules('title', lang('title'), 'trim|required'); 
                $this->form_validation->set_rules('permissions', lang('permission'), 'trim|required'); 
                $this->form_validation->set_rules('info', lang('description'), 'trim'); 
            } 

            if ($this->form_validation->run() !== FALSE) 
            { 
                $save = $this->input->post();
                if ($action == 'assign') 
                { 
                    $p = $this->privilege_model->get($save['role_id']);
                    $u = $this->account_data->fetch($save['id']); 
                    $msg = sprintf(lang('user_granted_privilege'), $u['name'], $p['title']);

                    $save['employee_id'] = $u['employee_id'];
 
                    unset($save['action'], $save['id']);
                    $this->employee_model->addEditEmployee($save);
                    $this->session->set_flashdata('message', alert_notice($msg, 'info'));
                } 
                elseif ($action == 'create') 
                {
                    $msg = lang('new_privilege_created');

                    if ($data['privileges']['id']) 
                    {
                        $save['id'] = $data['privileges']['id'];
                        $msg = lang('privilege_updated');
                    }
                    $save['permissions'] = encode_privilege(str_ireplace(', ', ',', $save['permissions']));
                    
                    unset($save['action']);
                    $this->privilege_model->add($save);
                    $this->session->set_flashdata('message', alert_notice($msg, 'info'));
                } 
                redirect(uri_string());
            }
        }
        elseif ($action == 'delete') 
        {
            $this->privilege_model->remove($action_id);
            $this->session->set_flashdata('message', alert_notice(lang('privilege').' '.lang('deleted'), 'info'));
            redirect(site_url('employee/permissions/create'));
        }
 
		$head_data = array(
			'title' => 'Privileges - '. my_config('site_name'), 
			'page' => 'privilege', 
			'sub_page_title' => lang('privileges')
		);

		$this->load->view($this->h_theme.'/header', $head_data);
		$this->load->view($this->h_theme.'/employee/permissions',$data);
		$this->load->view($this->h_theme.'/footer');
	}
} 
