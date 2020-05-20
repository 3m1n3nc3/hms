<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends Admin_Controller 
{ 

    /**
     * This methods list all the rooms 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{
		// Check of employee has permission to take this action
        error_redirect(has_privilege('rooms'), '401');

		$rooms = $this->room_model->get_rooms();

		$viewdata = array('rooms' => $rooms);

		$data = array('title' => 'Rooms - ' . my_config('site_name'), 'page' => 'room');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * Displays all reserved rooms 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function reserved()
	{
		// Check of employee has permission to take this action
        error_redirect(has_privilege('rooms') OR has_privilege('room-sales'), '401');

		$config['base_url']   = site_url('room/reserved/'); 
        $config['total_rows'] = count($this->reservation_model->reserved_rooms()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0); 

		$rooms = $this->reservation_model->reserved_rooms(['page' => $_page]);

		$viewdata = array('rooms' => $rooms);
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Rooms - ' . my_config('site_name'), 'page' => 'reserved');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room/reserved',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * Fetch information about a reserved room
     * @param  string   $room_id    	Id of the room to retrieve
     * @param  string   $customer_id  	Id of the customer with reservation to this room to check
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function reserved_room($room_id = '', $customer_id = '', $pg = 1)
	{   
        $room_id     = urldecode($room_id);
        $customer_id = urldecode($customer_id);
		// Check of employee has permission to take this action
        error_redirect(has_privilege('rooms'), '401');

		$reservation = $this->reservation_model->reserved_rooms(['room' => $room_id, 'customer' => $customer_id, 'uncheck' => TRUE], 1); 

        $config['uri_segment']  = 5;
        $config['base_url']     = site_url('room/reserved_room/'.$room_id.'/'.$customer_id.'/');
        $config['total_rows']   = count($this->reservation_model->reserved_rooms(['room' => $room_id, 'uncheck' => TRUE])); 
        $this->pagination->initialize($config);

        $_page    = $this->uri->segment(5, 0); 

		$rooms    = $this->reservation_model->reserved_rooms(['room' => $room_id, 'uncheck' => TRUE, 'page' => $pg]);
        $payment  = $this->payment_model->get_payments(['reference' => $reservation['reservation_id']]);

		$viewdata = array(
            'reservation'   => $reservation, 
            'customer'      => $reservation, 
            'rooms'         => $rooms,
            'pagination'    => $this->pagination->create_links(),
            'checkin_date'  => date('Y-m-d', strtotime($reservation['checkin_date'])),
            'checkout_date' => date('Y-m-d', strtotime($reservation['checkout_date'])),
            'statistics'    => array(),
            'overstay'      => array(),
            'print_invoice' => anchor_popup('generate/invoice/'.$reservation['reservation_id'].'/reservation', '<i class="fa fa-print"></i> Print Invoice', ['class'=>'btn btn-success btn-block text-white font-weight-bold mt-1']),
            'customer_link' =>  anchor('customer/data/'.$reservation['customer_id'], $reservation['customer_name'], ['class'=>'font-weight-bold mt-1'])
        );    
         
        if ($reservation['customer_id']) 
        {
            $viewdata['statistics'] = $this->accounting_model->statistics(['customer' => $reservation['customer_id']]);
            $viewdata['overstay']   = $this->reservation_model->overstayed_room(['customer' => $reservation['customer_id'], 'room' => $room_id]); 
            
            // Notify Admins of room overstay
            if ($viewdata['overstay']['overstay_days']>0) {
                $re_data = array( 
                    'type'          => 'overstayed_reservation',
                    'notifier_type' => 'customer',
                    'user_id'       => $reservation['customer_id'],
                    'url'           => site_url('room/reserved_room/'.$room_id.'/'.$reservation['customer_id']) 
                );
                $this->notifications->notifyPrivilegedMods($re_data); 
            }
        }

		$data = array('title' => 'Reserved Room - ' . my_config('site_name'), 'sub_page_title' => $reservation['room_type'].' Room '.$room_id, 'page' => 'reserved');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room/reserved_room',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods allows for adding new rooms 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function add()
	{
		// Check of employee has permission to take this action
        error_redirect(has_privilege('rooms'), '401');

		$viewdata = array();
		if($this->input->post("room_type") && $this->input->post("min_id") && $this->input->post("max_id"))
		{
			$new_room_type = $this->input->post("room_type");
			$new_min_id = intval($this->input->post("min_id"));
			$new_max_id = intval($this->input->post("max_id"));

			$rooms_avail = count($this->room_model->getRoomRange($new_room_type, $new_min_id, $new_max_id));

			if($new_min_id>$new_max_id) {
				$this->session->set_flashdata('message', alert_notice('Range is not valid ' .$new_min_id. ', '. $new_max_id, 'info'));  
			} else if($rooms_avail!==0) {
				$this->session->set_flashdata('message', alert_notice('Range is not available ' .$new_min_id. ', '. $new_max_id, 'info'));  
			} else {
				$this->session->set_flashdata('message', alert_notice($new_room_type. ' rooms numbered from '. $new_min_id.' to '.$new_max_id.' have been added', 'success')); 
				$this->room_model->addRoomRange($new_room_type, $new_min_id, $new_max_id);
				redirect("room");
			}
		}
		$data = array(
			'title' => 'Add Rooms - ' . my_config('site_name'), 
			'page' => 'room',
        	'sub_page_title' => 'Add Rooms'
        );
		$this->load->view($this->h_theme.'/header', $data);

		$room_types = $this->room_model->get_room_types();
		$viewdata['room_types'] = $room_types;
		$this->load->view($this->h_theme.'/room/add',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * Delete the rooms withing the selected min/max range
     * @param  string   $min_id     Id where to start deleting
     * @param  string   $max_id     Id where to end deleting
     * @return null                 Redirects to the rooms listing page
     */
    function delete($min_id, $max_id)
    {
        $min_id = urldecode($min_id);
        $max_id = urldecode($max_id);
        // Check of employee has permission to take this action
        error_redirect(has_privilege('rooms'), '401');

        $this->session->set_flashdata('message', alert_notice('All rooms numbered from '. $min_id.' to '.$max_id.' have been deleted')); 
        $this->room_model->deleteRoomRange($min_id, $max_id);
        redirect("room");
    }


    /**
     * Checkout the current customer from the current reserved room
     * @param  string   $reservation_id     Id Of the reservation to checkout 
     * @return null                 Redirects to the users reservation for the current room page
     */
    function checkout($reservation_id)
    {
        $reservation_id = urldecode($reservation_id); 
        // Check of employee has permission to take this action
        error_redirect(has_privilege('reservation'), '401');

        $res = $this->reservation_model->fetch_reservation(['id' => $reservation_id]);
        $usr = $this->account_data->fetch($res['customer_id'], 1); 

        $this->session->set_flashdata('message', alert_notice($usr['name'].' has been checked out from room '.$res['room_id']));

        $checkout['reservation_id'] = $reservation_id;
        $checkout['status']         = '0';
        $checkout['checkout_date']  = date('Y-m-d H:i:s', strtotime('NOW-1 Minute')); 

        $this->room_model->checkoutCustomer($checkout);
        redirect("room/reserved_room/".$res['room_id']);
    }


    /**
     * Delete the the room reservation with the specified id
     * @param  string   $reservation_id     Id of the reservation to delete 
     * @return null                 		Redirects to the reserved rooms listing page
     */
	function delete_reservation($reservation_id = '')
	{
        $reservation_id = urldecode($reservation_id);
		// Check of employee has permission to take this action
        error_redirect(has_privilege('reservation'), '401');

		$this->session->set_flashdata('message', alert_notice('Reservation Deleted')); 
		$this->reservation_model->deleteReservation($reservation_id);
		redirect("room/reserved");
	}


    /**
     * Allows for the editing of the rooms withing the specified min/max range
     * @param  string   $room_type     	The room type these rooms belong to
     * @param  string   $min_id        	Id where to start editing
     * @param  string   $max_id     	Id where to end editing 
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function edit($room_type, $min_id, $max_id)
	{
        $room_type = urldecode($room_type);
		// Check of employee has permission to take this action
        error_redirect(has_privilege('rooms'), '401');

		$viewdata = array();
		if($this->input->post("room_type") && $this->input->post("min_id") && $this->input->post("max_id"))
		{
			$new_room_type = $this->input->post("room_type");
			$new_min_id = intval($this->input->post("min_id"));
			$new_max_id = intval($this->input->post("max_id"));

			$rooms_avail = count($this->room_model->isAvailRange($room_type, $new_min_id, $new_max_id));

			if($new_min_id>$new_max_id) 
			{
				$this->session->set_flashdata('message', alert_notice('Range is not valid '. $new_min_id.' to '.$new_max_id, 'info')); 
			} 
			elseif($rooms_avail!==0) 
			{
				$this->session->set_flashdata('message', alert_notice('Range is not valid '. $new_min_id.' to '.$new_max_id, 'info')); 
			} 
			else 
			{
				$this->session->set_flashdata('message', alert_notice($new_room_type. ' rooms numbered from '. $new_min_id.' to '.$new_max_id.' have been updated', 'success')); 
				$this->room_model->deleteRoomRange($min_id, $max_id);
				$this->room_model->addRoomRange($new_room_type, $new_min_id, $new_max_id);
				redirect("/room");
			}
		}

		$data = array('title' => 'Edit Rooms - ' . my_config('site_name'), 'page' => 'room');
		$this->load->view($this->h_theme.'/header', $data);

		$room_types = $this->room_model->get_room_types();

		$room_range = new stdClass();
		$room_range->room_type = $room_type;
		$room_range->min_id = $min_id;
		$room_range->max_id = $max_id;
		$viewdata['room_range'] = $room_range;
		$viewdata['room_types'] = $room_types;
		$this->load->view($this->h_theme.'/room/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}
} 
