<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sport_facility extends Admin_Controller {

	public function index()
	{
		$sportFacilities = $this->sport_facility_model->get_sportFacilities();
		$customers = $this->customer_model->get_active_customers();

		$viewdata = array('sportFacilities' => $sportFacilities, 'customers' => $customers);

		$data = array('title' => 'Sport Facility - ' . HOTEL_NAME, 'page' => 'sport_facility');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/sport_facility/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
		
		if($this->input->post("sportfacilityOpenTime"))
		{
			$sportfacilityOpenTime = $this->input->post("sportfacilityOpenTime");
			$sportfacilityCloseTime = $this->input->post("sportfacilityCloseTime");
			$sportfacilityDetails = $this->input->post("sportfacilityDetails");
			
			$this->sport_facility_model->addSportfacility($sportfacilityOpenTime, $sportfacilityCloseTime, $sportfacilityDetails);
			$this->session->set_flashdata('message', alert_notice('New Sport Facility added', 'success'));
			redirect("sport_facility");
		}

		$data = array('title' => 'Add Sport Facility - ' . HOTEL_NAME, 'page' => 'sport_facility');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/sport_facility/add');
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($sportfacility_id)
	{
		$this->sport_facility_model->deleteSportfacility($sportfacility_id);
			$this->session->set_flashdata('message', alert_notice('Sport Facility deleted', 'success'));
		redirect("sport_facility");
	}

	public function edit($sportfacility_id)
	{
		if($this->input->post("sportfacilityOpenTime"))
		{
			$sportfacility_open_time = $this->input->post("sportfacilityOpenTime");
			$sportfacility_close_time = $this->input->post("sportfacilityCloseTime");
			$sportfacility_details = $this->input->post("sportfacilityDetails");
			
			$this->sport_facility_model->editSportfacility($sportfacility_id, $sportfacility_open_time, $sportfacility_close_time, $sportfacility_details);
			$this->session->set_flashdata('message', alert_notice('Sport Facility updated', 'success'));
			redirect("sport_facility");
		}
		$data = array('title' => 'Edit Sport Facility - ' . HOTEL_NAME, 'page' => 'sport_facility');
		$this->load->view($this->h_theme.'/header', $data);
		$sportFacility = $this->sport_facility_model->get_sportfacility($sportfacility_id);
		$viewdata = array('sport_facility'  => $sportFacility[0]);
		$this->load->view($this->h_theme.'/sport_facility/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer'); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
