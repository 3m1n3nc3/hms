<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends Admin_Controller { 

	public function index()
	{
		$this->check_login();

		$room_types = $this->room_model->get_room_types();
		$viewdata = array('room_types' => $room_types);
		$data = array(
			'title' => 'Reservation - ' . HOTEL_NAME, 
			'page' => 'reservation', 
			'has_calendar' => TRUE
		);
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/reservation/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function check($ref="") {
		$viewdata = $rooms = [];

		$post = $this->input->post();

		$this->form_validation->set_rules('customer_TCno', 'Customer Identity Code', 'trim|required');
		$this->form_validation->set_rules('adults', 'Number of Adults', 'trim|required');
		$this->form_validation->set_rules('children', 'Number of Children', 'trim|required');
        if ($post && $this->form_validation->run() !== FALSE) 
        {
			$customer = $this->customer_model->get_customer($post['customer_TCno']);

			if(!$customer) 
			{ 
				$this->session->set_flashdata('message', alert_notice('Customer does not exist', 'info')); 
			} 
			else 
			{
				$rooms = $this->reservation_model->get_available_rooms($post);
				if(!$rooms) {
					$this->session->set_flashdata('message', alert_notice('No available rooms', 'info')); 
				}
			}
		}
		else 
		{
			$this->session->set_flashdata('message', alert_notice(validation_errors(), 'error')); 
		}
		
		$viewdata = array();

		$data = array('title' => 'Add Customer - ' . HOTEL_NAME, 'page' => 'reservation');
		$this->load->view($this->h_theme.'/header', $data);

		if(isset($viewdata['error']))
		{
			$room_types = $this->room_model->get_room_types();
			$viewdata['room_types'] = $room_types;
			$this->load->view($this->h_theme.'/reservation/add',$viewdata);
		} 
		else 
		{
			$viewdata['rooms'] = $rooms;
			$viewdata['customer_TCno'] = $post['customer_TCno'] ?? '';
			$viewdata['checkin_date'] = $post['checkin_date'] ?? '';
			$viewdata['checkout_date'] = $post['checkout_date'] ?? '';
			$viewdata['room_type'] = $post['room_type'] ?? '';
//			echo "<pre>";
//			var_dump($viewdata);return;echo "</pre>";
			$this->load->view($this->h_theme.'/reservation/list',$viewdata);
		}

		$this->load->view($this->h_theme.'/footer');

	}
	
	public function make()
	{
		$post = $this->input->post();
		
		$this->form_validation->set_rules('customer_TCno', 'Customer Identity Code', 'trim|required');
		$this->form_validation->set_rules('adults', 'Number of Adults', 'trim|required');
		$this->form_validation->set_rules('children', 'Number of Children', 'trim|required');
        if ($post && $this->form_validation->run() !== FALSE) 
        {
			$customer = $this->customer_model->get_customer($post['customer_TCno']);
			$room_type_info = $this->room_model->getRoomType($post['room_type'])[0];
			$customer = $customer[0];
			$viewdata = array();
			$data = array();
			$data['customer_id']   = $customer->customer_id;
			$data['room_id'] 	   = $post['room_id'];
			$data['checkin_date']  = $post['checkin_date'];
			$data['checkout_date'] = $post['checkout_date'];
			$data['reservation_date']  = date('Y-m-d');
			$data['reservation_price'] = $room_type_info->room_price;
			$data['employee_id']   = UID;

			$date = new DateTime();
			$date_s = $date->format('Y-m-d');
			if($date_s>$data['checkin_date']) 
			{
				$this->session->set_flashdata('message', alert_notice('Check in date is past and can\'t be before today', 'error'));   
			} 
			else 
			{
				$this->reservation_model->add_reservation($data);

				unset($data['reservation_date'], $data['reservation_price']);
				$this->room_model->add_room_sale($data);
				$this->session->set_flashdata('message', alert_notice('Reservation successfully made', 'success'));  
			}
		}
		else 
		{
			$this->session->set_flashdata('message', alert_notice(validation_errors(), 'error')); 
		}

		$room_types = $this->room_model->get_room_types();
		$viewdata['room_types'] = $room_types;

		$data = array(
			'title' => 'Reservation - ' . HOTEL_NAME, 
			'page' => 'reservation', 
			'has_calendar' => TRUE
		);
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/reservation/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
