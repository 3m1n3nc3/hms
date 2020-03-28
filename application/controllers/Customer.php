<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Admin_Controller 
{ 
	public function add($ref="", $action = "create")
	{
		// 	customer_id	customer_firstname	customer_lastname	customer_TCno	customer_city	customer_country	customer_telephone	customer_email
		$data = $this->input->post();
		if ($data) 
		{
			if($data["customer_TCno"])
			{
        		$this->form_validation->set_error_delimiters('<small class="text-danger pt-0">', '</small>');
				$this->form_validation->set_rules('customer_TCno', 'Customer Identity Code', 'trim|required|is_unique[customer.customer_TCno]'); 
				$this->form_validation->set_rules('customer_firstname', 'First Name', 'trim|required|alpha'); 
				$this->form_validation->set_rules('customer_lastname', 'Last Name', 'trim|required|alpha'); 
				$this->form_validation->set_rules('customer_email', 'Email', 'trim|valid_email|is_unique[customer.customer_email]'); 
				$this->form_validation->set_rules('customer_telephone', 'Phone', 'trim|required|numeric|is_unique[customer.customer_telephone]'); 
				$this->form_validation->set_rules('customer_address', 'Address', 'trim|required|alpha_dash'); 
				$this->form_validation->set_rules('customer_city', 'City', 'trim|required|alpha_dash'); 
				$this->form_validation->set_rules('customer_state', 'State', 'trim|required|alpha_dash'); 
				$this->form_validation->set_rules('customer_country', 'Country', 'trim|required|alpha_dash'); 

		        if ($this->form_validation->run() !== FALSE) 
		        {
					$this->customer_model->add_customer($data);
					$this->session->set_flashdata('message', alert_notice('New Customer added', 'success')); 
					redirect("$ref");
				} 
			}
		}

		if ($action === 'update') 
		{
			$customer = $this->customer_model->get_customer(['id' => $ref]); 
			$page_title = "Update Customer ({$customer['customer_firstname']})";
			$data = array('title' => $page_title . ' - ' . HOTEL_NAME, 'page' => 'reservation'); 

			$this->load->view($this->h_theme.'/header', $data);

			$viewdata = array('reference' => $customer['customer_id']);
			$viewdata['customer'] = $customer;
			$viewdata['ref_token'] = $customer['customer_TCno'];
			$this->load->view($this->h_theme.'/customer/edit',$viewdata);
		}
		else
		{
			$page_title = "Add Customer";
			$data = array('title' => $page_title . ' - ' . HOTEL_NAME, 'page' => 'reservation'); 

			$this->load->view($this->h_theme.'/header', $data);

			$viewdata = array('reference' => 'reservation');
			$viewdata['ref_token'] = $this->enc_lib->generateToken(rand(3,5), 1, 'HRSC-');  
			$this->load->view($this->h_theme.'/customer/add',$viewdata);
		}
		$this->load->view($this->h_theme.'/footer');
	} 

	public function data($id = "")
	{	
		$customer = $this->customer_model->get_customer(['id' => $id]); 
		$viewdata = array('customer' => $customer); 

		$post = $this->input->post();
		if ($post) 
		{ 
			$unique_email = ($customer['customer_email'] !== $post['customer_email'] ? '|is_unique[customer.customer_email]' : '');
			$unique_tel = ($customer['customer_telephone'] !== $post['customer_telephone'] ? '|is_unique[customer.customer_telephonecustomer_telephone]' : '');

        	$this->form_validation->set_error_delimiters('<small class="text-danger pt-0">', '</small>'); 
			$this->form_validation->set_rules('customer_firstname', 'First Name', 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_lastname', 'Last Name', 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_email', 'Email', 'trim|valid_email'.$unique_email); 
			$this->form_validation->set_rules('customer_telephone', 'Phone', 'trim|required|numeric'.$unique_tel); 
			$this->form_validation->set_rules('customer_address', 'Address', 'trim|required'); 
			$this->form_validation->set_rules('customer_city', 'City', 'trim|required|alpha_dash'); 
			$this->form_validation->set_rules('customer_state', 'State', 'trim|required|alpha_dash'); 
			$this->form_validation->set_rules('customer_country', 'Country', 'trim|required|alpha_dash'); 

	        if ($this->form_validation->run() !== FALSE) 
	        {	
	        	unset($post['update_profile']);
	        	$post['cid'] = $customer['customer_id'];

				$this->customer_model->add_customer($post);
				$this->session->set_flashdata(array('update_profile'=> TRUE, 'message' => alert_notice('Profile Updated', 'success'))); 
				redirect('customer/data/'.$customer['customer_id']);
			}  
		}

		$data = array('title' => 'Customer ('.$customer['customer_firstname'].' '.$customer['customer_lastname'].') - ' . HOTEL_NAME, 'page' => 'customer');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/customer/view',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 

	public function list($id = "")
	{	
		$config['base_url']   = site_url('customer/list/');
        $config['total_rows'] = count($this->customer_model->list_customers()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0);

		$customers = $this->customer_model->list_customers(['page' => $_page]); 
		$viewdata  = array('customers' => $customers); 
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Customers - ' . HOTEL_NAME, 'page' => 'customers');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/customer/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 

	function delete($customer_id)
	{
		$this->session->set_flashdata(array('message' => alert_notice('Customer Deleted', 'success'))); 
		$this->customer_model->delete_customer($customer_id);
		redirect("customer/list");
	}

	function reserve($customer_id)
	{ 
		$this->session->set_flashdata('customer_TCno', $customer_id);
		redirect("reservation");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
