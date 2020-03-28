<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Room_type extends Admin_Controller 
{  

	public function add()
	{
		
		$viewdata = array();

		if($this->input->post("type") && $this->input->post("price") /*&& $this->input->post("quantity")*/)
		{
			$save['room_type']  = $this->input->post("type");
			$save['room_price'] = $this->input->post("price");
			$save['room_details']  = $this->input->post("details");
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

		$data = array('title' => 'Add Room Type - ' . HOTEL_NAME, 'page' => 'room_type');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room-type/add', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($room_type)
	{
		$this->room_model->deleteRoomType($room_type);
		redirect("/room-type");
	}

	public function edit($room_type)
	{
		if($this->input->post("type") && $this->input->post("price") /*&& $this->input->post("quantity")*/)
		{
			$save['room_type']  = $this->input->post("type");
			$save['room_price'] = $this->input->post("price");
			$save['room_details']  = $this->input->post("details");
			$save['room_quantity'] = $this->input->post("quantity");
			$save['max_adults'] = $this->input->post("max_adults");
			$save['max_kids']   = $this->input->post("max_kids");
			$save['wifi'] = $this->input->post("wifi");
			$save['pool'] = $this->input->post("pool");
			$save['pool'] = $this->input->post("pool");
			$save['room_service'] = $this->input->post("service");

			$this->session->set_flashdata(
				'message', 
				alert_notice('Room type updated', 'success')
			); 
			$this->room_model->editRoomType($save);
			redirect("room-type");
		}
		
		$data = array('title' => 'Edit Room Type - ' . HOTEL_NAME, 'page' => 'room_type');
		$this->load->view($this->h_theme.'/header', $data);

		$room_type = $this->room_model->getRoomType($room_type);
		
		$viewdata = array('room_type'  => $room_type[0]);
		$this->load->view($this->h_theme.'/room-type/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer');
	}

	public function index()
	{
		$room_types = $this->room_model->get_room_types();

		$viewdata = array('room_types' => $room_types);

		$data = array('title' => 'Rooms - ' . HOTEL_NAME, 'page' => 'room_type');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/room-type/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
