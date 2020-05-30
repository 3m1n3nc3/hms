<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_type extends Admin_Controller 
{  


    /**
     * This methods list all the available room types
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{
        // Check if employee has permission to take this action
        error_redirect(has_privilege('room-types'), '401');
        
		$room_types = $this->room_model->get_room_types();

		$viewdata = array('room_types' => $room_types);

		$data = array('title' => 'Rooms - ' . my_config('site_name'), 'page' => 'room_type');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room-type/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods adds a new room type
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function add()
	{
        // Check if employee has permission to take this action
        error_redirect(has_privilege('room-types'), '401');

		$viewdata = array();

		if($this->input->post("type") && $this->input->post("price") /*&& $this->input->post("quantity")*/)
		{
			$save['room_type']  = $this->input->post("type");
			$save['room_price'] = $this->input->post("price");
			$save['room_details']  = encode_html($this->input->post("details"));
			$save['room_quantity'] = $this->input->post("quantity");
			$save['max_adults'] = $this->input->post("max_adults") ?? 0;
			$save['max_kids']   = $this->input->post("max_kids") ?? 0;
			$save['wifi'] = $this->input->post("wifi") ?? 0;
			$save['pool'] = $this->input->post("pool") ?? 0; 
			$save['room_service'] = $this->input->post("service") ?? 0;

			if(count($this->room_model->getRoomType($save['room_type']))==0)
			{
				$this->session->set_flashdata('message', alert_notice('New room type created', 'success')); 
				$this->room_model->addRoomType($save);
				redirect("room-type");
			}
			else 
			{
				$this->session->set_flashdata('message', alert_notice('Room type already exists', 'error'));  
			}
		}

		$data = array(
			'title' => 'Add Room Type - ' . my_config('site_name'), 
			'page' => 'room_type',
        	'sub_page_title' => 'Add Room Type'
        );
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room-type/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($room_type)
	{
        $room_type = urldecode($room_type);
        // Check if employee has permission to take this action
        error_redirect(has_privilege('room-types'), '401');

		$this->room_model->deleteRoomType($room_type);
		redirect("room-type");
	}


    /**
     * This methods edits the specified room type
     * @param string 	$room_type 		Id of the room type to edit
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function edit($room_type)
	{
        $room_type = urldecode($room_type);
        // Check if employee has permission to take this action
        error_redirect(has_privilege('room-types'), '401');

        $room_type = $this->room_model->getRoomType($room_type, TRUE);

		if($this->input->post("type") && $this->input->post("price") /*&& $this->input->post("quantity")*/)
		{
            $save['id']            = $room_type['id'];
			$save['room_type']     = $this->input->post("type");
			$save['room_price']    = $this->input->post("price");
			$save['room_details']  = encode_html($this->input->post("details"));
			$save['room_quantity'] = $this->input->post("quantity");
			$save['max_adults']    = $this->input->post("max_adults");
			$save['max_kids']      = $this->input->post("max_kids");
			$save['wifi']          = $this->input->post("wifi");
			$save['pool']          = $this->input->post("pool");
			$save['pool']          = $this->input->post("pool");
			$save['room_service']  = $this->input->post("service");

			$this->room_model->editRoomType($save);
            $this->session->set_flashdata(
                'message', 
                alert_notice('Room type updated', 'success')
            ); 
			redirect("room-type/edit/".$room_type['id']);
		}
		
		$data = array('title' => 'Edit Room Type - ' . my_config('site_name'), 'page' => 'room_type');
		$this->load->view($this->h_theme.'/header', $data);
		
		$viewdata = array('room_type'  => $room_type);
		$this->load->view($this->h_theme.'/room-type/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}
} 
