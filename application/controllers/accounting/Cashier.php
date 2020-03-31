<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashier extends Admin_Controller {

	public function index()
	{ 
		$filter_from = $this->input->get('from');
		$filter_to = $this->input->get('to');
		$filter = array();
		if ($filter_from) 
		{
			$filter['from'] = $filter_from;
		}
		if ($filter_to) 
		{
			$filter['to'] = $filter_to;
		}
		
		$filter_query = ($filter_from && $filter_to ? '?from='.$filter_from.'&to='.$filter_to : ($filter_from ? '?from='.$filter_from : ($filter_to ? '?to='.$filter_to : null)));

		$viewdata = array(
			'expenses' => $this->accounting_model->get_expense($filter),  
			'use_table' => TRUE, 
			'table_method' => 'cashier_report'.($filter_query)
		); 

		$data = array('title' => 'Cashiers Report - ' . HOTEL_NAME, 'page' => 'cashier-report');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/accounting/cashier',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 

	public function expenses_register($record_id = '')
	{
		if ($this->input->post()) {
	        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
	        $this->form_validation->set_rules('date', 'Date', 'trim|required');
	        $this->form_validation->set_rules('subject', 'Subject', 'trim|alpha_numeric_spaces|required');
	        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
	        $this->form_validation->set_rules('remark', 'Remark', 'trim|required');

	        if ($this->form_validation->run() !== FALSE) 
	        {
	        	$post = $this->input->post();
	        	$post['employee_id'] = $this->uid;
	        	$post['date_added'] = date('Y-m-d H:i:s');
	        	if ($record_id) 
	        	{
	        		$post['id'] = $record_id;
	        	}
	        	$this->accounting_model->addExpense($post);
                $this->session->set_flashdata('message', alert_notice('New expense record added', 'success'));
                redirect('accounting/cashier');
	        }
		}

		$viewdata = $this->accounting_model->get_expense(['id' => $record_id]); 
		$viewdata['record_id'] = $record_id; 

		$data = array('title' => 'Expense Register - ' . HOTEL_NAME, 'page' => 'expenses-register');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/accounting/expenses_register',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 

	function delete_expenses($record_id)
	{
		$this->session->set_flashdata(array('message' => alert_notice('Expense record Deleted', 'success'))); 
		$this->accounting_model->delete_expense($record_id);
		redirect("accounting/cashier");
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
