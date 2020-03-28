<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room extends Admin_Controller { 

	public function index()
	{
		$rooms = $this->room_model->get_rooms();

		$viewdata = array('rooms' => $rooms);

		$data = array('title' => 'Rooms - ' . HOTEL_NAME, 'page' => 'room');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
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
		$data = array('title' => 'Add Rooms - ' . HOTEL_NAME, 'page' => 'room');
		$this->load->view($this->h_theme.'/header', $data);

		$room_types = $this->room_model->get_room_types();
		$viewdata['room_types'] = $room_types;
		$this->load->view($this->h_theme.'/room/add',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}

	function delete($min_id, $max_id)
	{
		$this->session->set_flashdata('message', alert_notice('All rooms numbered from '. $min_id.' to '.$max_id.' have been deleted')); 
		$this->room_model->deleteRoomRange($min_id, $max_id);
		redirect("room");
	}

	public function edit($room_type, $min_id, $max_id)
	{
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

		$data = array('title' => 'Edit Rooms - ' . HOTEL_NAME, 'page' => 'room');
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
