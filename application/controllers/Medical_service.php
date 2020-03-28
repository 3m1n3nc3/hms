<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medical_service extends Admin_Controller {

	public function index()
	{
		$medicalServices = $this->medical_service_model->get_medicalServices();
		$customers = $this->customer_model->get_active_customers();


		$viewdata = array('medicalServices' => $medicalServices, 'customers' => $customers);

		$data = array('title' => 'Medical Service - ' . HOTEL_NAME, 'page' => 'medical_service');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/medical_service/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
		
		if($this->input->post("medicalserviceOpenTime"))
		{
			$medicalserviceOpenTime = $this->input->post("medicalserviceOpenTime");
			$medicalserviceCloseTime = $this->input->post("medicalserviceCloseTime");
			$medicalserviceDetails = $this->input->post("medicalserviceDetails");
			
			$this->medical_service_model->addMedicalservice($medicalserviceOpenTime, $medicalserviceCloseTime, $medicalserviceDetails);
			$this->session->set_flashdata('message', alert_notice('New medical Service added', 'success'));
			redirect("medical_service");
		}

		$data = array('title' => 'Add Medical Service - ' . HOTEL_NAME, 'page' => 'medical_service');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/medical_service/add');
		$this->load->view($this->h_theme.'/footer');
	}

	function delete($medicalservice_id)
	{
		$this->medical_service_model->deleteMedicalservice($medicalservice_id);
		$this->session->set_flashdata('message', alert_notice('Medical Service Deleted', 'success'));
		redirect("medical_service");
	}

	public function edit($medicalservice_id)
	{
		if($this->input->post("medicalserviceOpenTime"))
		{
			$medicalservice_open_time = $this->input->post("medicalserviceOpenTime");
			$medicalservice_close_time = $this->input->post("medicalserviceCloseTime");
			$medicalservice_details = $this->input->post("medicalserviceDetails");
			
			$this->medical_service_model->editMedicalservice($medicalservice_id, $medicalservice_open_time, $medicalservice_close_time, $medicalservice_details);
			$this->session->set_flashdata('message', alert_notice('Medical Service Updated', 'success'));
			redirect("medical_service");
		}
		$data = array('title' => 'Edit Medical Service - ' . HOTEL_NAME, 'page' => 'medical_service');
		$this->load->view($this->h_theme.'/header', $data);
		$medicalService = $this->medical_service_model->get_medicalservice($medicalservice_id);
		$viewdata = array('medical_service'  => $medicalService[0]);
		$this->load->view($this->h_theme.'/medical_service/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer'); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
