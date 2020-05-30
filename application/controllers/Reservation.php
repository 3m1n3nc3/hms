<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends Admin_Controller 
{ 


    /**
     * This methods allows for adding reservations 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{ 
        error_redirect(has_privilege('reservation'), '401');
        
		$room_types = $this->room_model->get_room_types();
		$viewdata = array('room_types' => $room_types);
		$data = array(
			'title' => 'Reception - ' . my_config('site_name'), 
			'page' => 'reception', 
			'has_calendar' => TRUE
		);

		if ($this->input->post('change_booking') && !isset($_SESSION['change_booking'])) 
		{
			$this->session->set_userdata('change_booking', $this->input->post('change_booking'));
		}

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/reservation/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods checks the current reservations 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function check() 
	{
        error_redirect(has_privilege('reservation'), '401');

		$viewdata = $rooms = [];

		$post = $this->input->post();

		$this->form_validation->set_rules('customer_TCno', lang('customer_id_code'), 'trim|required');
		$this->form_validation->set_rules('adults', lang('adults'), 'trim|required');
		$this->form_validation->set_rules('children', lang('children'), 'trim|required');
		$this->form_validation->set_rules('checkin_date', lang('checkin'), 'trim|required');
		$this->form_validation->set_rules('checkout_date', lang('checkout'), 'trim|required');
        if ($post && $this->form_validation->run() !== FALSE) 
        {
			$customer = $this->customer_model->get_customer($post['customer_TCno']);

			if(!$customer) 
			{ 
				$this->session->set_flashdata('message', alert_notice('Customer does not exist', 'info')); 
			} 
			else 
			{
				$rooms = $this->reservation_model->get_available_rooms_inline($post);
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

		$data = array('title' => 'Add Customer - ' . my_config('site_name'), 'page' => 'reservation');
		$this->load->view($this->h_theme.'/header', $data);

		if(isset($viewdata['error']))
		{
			$room_types             = $this->room_model->get_room_types();
			$viewdata['room_types'] = $room_types;
			$this->load->view($this->h_theme.'/reservation/add',$viewdata);
		} 
		else 
		{
			$viewdata['rooms']         = $rooms;
			$viewdata['customer_TCno'] = $post['customer_TCno'] ?? '';
			$viewdata['checkin_date']  = $post['checkin_date'] ?? '';
			$viewdata['checkout_date'] = $post['checkout_date'] ?? '';
			$viewdata['room_type']     = $post['room_type'] ?? ''; 
			$this->load->view($this->h_theme.'/reservation/list',$viewdata);
		} 

		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods save the customer room reservation 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function make()
	{
        error_redirect(has_privilege('reservation'), '401');
        
		$post = $this->input->post();
		
		$this->form_validation->set_rules('customer_TCno', lang('customer_id_code'), 'trim|required');
		$this->form_validation->set_rules('adults', lang('adults'), 'trim|required');
		$this->form_validation->set_rules('children', lang('children'), 'trim|required');
		$this->form_validation->set_rules('checkin_date', lang('checkin'), 'trim|required');
		$this->form_validation->set_rules('checkout_date', lang('checkout'), 'trim|required');
        if ($post && $this->form_validation->run() !== FALSE) 
        {
			$customer       = $this->customer_model->get_customer($post['customer_TCno']);
			$room_type_info = $this->room_model->getRoomType($post['room_type'])[0];
			$customer       = $customer[0];
			$viewdata       = array();
			$data           = array();

            $booked_days    = dateDifference($post['checkin_date'], $post['checkout_date']); 
            $booked_days    = $booked_days > 0 ? $booked_days : 1;
            $amount         = ($room_type_info->room_price ?? 0)*$booked_days;

        	$data['reservation_ref'] = $this->enc_lib->generateToken(12, 1, 'HRSPR-', TRUE);
			$data['customer_id']     = $customer->customer_id;
            $data['employee_id']     = UID;
            $data['status']          = 1;
            $data['room_id']         = $post['room_id'];
            $data['coming_from']     = $post['from'];
            $data['adults']          = $post['adults'];
            $data['children']        = $post['children'];
			$data['destination'] 	 = $post['destination'];
			$data['checkin_date']    = date('Y-m-d H:i:s', strtotime($post['checkin_date']));
			$data['checkout_date']   = date('Y-m-d H:i:s', strtotime($post['checkout_date']));
			$data['reservation_date']  = date('Y-m-d H:i:s', strtotime("NOW"));
			$data['reservation_price'] = $amount;
 
			$date_s = date('Y-m-d H:i:s', strtotime("NOW"));
			if($date_s > $data['checkin_date']) 
			{
				$this->session->set_flashdata('message', alert_notice('Check in date or time is past and can\'t be before today', 'error'));   
			} 
			else 
			{
				// If you're changing the reservation information, delete the reservation and room sale
				if (isset($_SESSION['change_booking']))
				{
					$change = $this->reservation_model->fetch_reservation(['id' => $_SESSION['change_booking']]);
					$this->reservation_model->deleteReservation($change['reservation_id']);
					$this->reservation_model->deleteRoomSale($change['reservation_id']);
					unset($_SESSION['change_booking']);
				}

                // Add a new payment record
                $add_payment_record = array(
                    'customer_id'  => $data['customer_id'],
                    'payment_type' => 'admin_room_sale',
                    'reference'    => $data['reservation_ref'],
                    'invoice'      => $data['reservation_ref'],
                    'amount'       => $amount,
                    'description'  => 
                        sprintlang('reservation_invoice_desc', [$room_type_info->room_type,$data['room_id'],$booked_days])
                ); 
                $this->payment_model->add_payments($add_payment_record);

                // Add the reservation and set the reservation_id to a variable
				$reservation_id = $this->reservation_model->add_reservation($data);

				unset($data['reservation_date'], $data['reservation_price'], $data['reservation_ref'], $data['coming_from'], $data['destination'], $data['adults'], $data['children']);

                // Add the room sale
				$data['reservation_id']   = $reservation_id;
                $data['room_sales_price'] = $amount;
				$this->room_model->add_room_sale($data);

                // Send notifications
                $re_data = array( 
                    'type' => 'made_reservation', 
                    'url'  => site_url('room/reserved_room/'.$data['room_id'].'/'.$data['customer_id'])
                );
                $this->notifications->notifyPrivilegedMods($re_data);  

                $print_invoice = anchor_popup('generate/invoice/'.$reservation_id.'/reservation', '<i class="fa fa-print"></i> Print Invoice', ['class'=>'text-white font-weight-bold btn btn-success mb-3']);
                set_snashdata('message',alert_notice('Reservation successfully made!', 'success') . $print_invoice);   
				redirect(current_url(), 'refresh');
			}
		}
		else 
		{
			$this->session->set_flashdata('message', alert_notice(validation_errors(), 'error')); 
		}

		$room_types = $this->room_model->get_room_types();
		$viewdata['room_types'] = $room_types;

		$data = array(
			'title' => 'Reservation - ' . my_config('site_name'), 
			'page' => 'reservation',
			'has_calendar' => TRUE
		);

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/reservation/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

    /**
     * Renders the invoice
     * @param  string   $id   id of the invoice item to read
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function invoice($reference = '')
    {
        $reference = urldecode($reference);
        
        error_redirect(has_privilege('cashier-report'), '401'); 

        $post = $this->reservation_model->fetch_reservation(['id' => $reference]); 

        error_redirect($post); 

        $customer = $this->account_data->fetch($post['customer_id'] ?? '', 1); 
        $room     = $this->room_model->getRoom(['id' => $post['room_id'] ?? $invoice['room_id']]);  
        $room_type_info = $this->room_model->getRoomType($room['room_type']); 
        $room_info      = (array)($room_type_info[0] ?? []);   

        $post['amount']      = $post['reservation_price']; 
        $post['room_type']   = $room_info['room_type'];
        $post['room_id']     = $room['room_id'];
        $post['invoice']     = $post['room_id'].date('ymdHm', strtotime($post['reservation_date']));
        $post['date']        = date('Y-m-d', strtotime($post['reservation_date'])); 
        $post['payment_ref'] = $post['invoice_id'] = $post['reservation_ref'];
        $post['description'] = 'Payment for reservation of ' . $post['room_type'] . ' Room ' . $post['room_id'];

        $viewdata = [
        	'title'       => $post['description'] . ' Invoice',
        	'show_footer' => TRUE,
        	'post'        => $post, 
        	'customer'    => $customer, 
        	'room'        => $room_type_info,
        	'p_page'	  => 'reservation'
        ];
         
        $this->load->view($this->h_theme.'/header_plain', $viewdata);  
        $this->load->view($this->h_theme.'/homepage/invoice_inline', $viewdata);
    }
} 
