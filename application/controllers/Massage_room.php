<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Massage_room extends Admin_Controller {

	public function index()
	{
		$massageRooms = $this->massage_room_model->get_massageRooms();
		$customers = $this->customer_model->get_active_customers();

		$viewdata = array('massageRooms' => $massageRooms, 'customers' => $customers);

		$data = array('title' => 'Massage Room - DB Hotel Management System', 'page' => 'massage_room');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/massage_room/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
		
		if($this->input->post("massageroomOpenTime"))
		{
			$massageroomOpenTime = $this->input->post("massageroomOpenTime");
			$massageroomCloseTime = $this->input->post("massageroomCloseTime");
			$massageroomDetails = $this->input->post("massageroomDetails");
			
			$this->massage_room_model->addMassageroom($massageroomOpenTime, $massageroomCloseTime, $massageroomDetails);
    		$this->session->set_flashdata('message', alert_notice('Massage room added', 'success'));
			redirect("massage_room");
		}

		$data = array('title' => 'Add Massage Room - DB Hotel Management System', 'page' => 'massage_room');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/massage_room/add');
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($massageroom_id)
	{
		$this->massage_room_model->deleteMassageroom($massageroom_id);
    	$this->session->set_flashdata('message', alert_notice('Massage room deleted', 'success'));
		redirect("massage_room");
	}

	public function edit($massageroom_id)
	{
		if($this->input->post("massageroomOpenTime"))
		{
			$massageroom_open_time = $this->input->post("massageroomOpenTime");
			$massageroom_close_time = $this->input->post("massageroomCloseTime");
			$massageroom_details = $this->input->post("massageroomDetails");
			
			$this->massage_room_model->editMassageroom($massageroom_id, $massageroom_open_time, $massageroom_close_time, $massageroom_details);
    		$this->session->set_flashdata('message', alert_notice('Massage room updated', 'success'));
			redirect("massage_room");
		}
		$data = array('title' => 'Edit Massage Room - DB Hotel Management System', 'page' => 'massage_room');
		$this->load->view($this->h_theme.'/header', $data);
		$Massagerooms = $this->massage_room_model->get_massageroom($massageroom_id);
		$viewdata = array('massage_room'  => $Massagerooms[0]);
		$this->load->view($this->h_theme.'/massage_room/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer'); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
