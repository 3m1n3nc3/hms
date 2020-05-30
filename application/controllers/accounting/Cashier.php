<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashier extends Admin_Controller 
{

    /**
     * Manages the hotels cashier reporting 
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{ 
        // Check if the user has permission to access this method
        error_redirect(has_privilege('cashier-report'), '401');

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
			'date_from' => $this->accounting_model->min_max(),
			'date_to' => $this->accounting_model->min_max(1),
			'from' => $filter_from,
			'to' => $filter_to,
			'filter_query' => $filter_query,
			'use_table' => TRUE, 
			'table_method' => 'cashier_report'.($filter_query)
		); 

		$data = array('title' => 'Cashiers Report - ' . my_config('site_name'), 'page' => 'cashier-report');

		if ($this->input->post('print')) 
		{	
			$viewdata['table_method'] = 'cashier_report/0'.($filter_query);
			$this->load->view($this->h_theme.'/accounting/cashier_report',array_merge($data, $viewdata));
		}
		else
		{
			$this->load->view($this->h_theme.'/header', $data);
			$this->load->view($this->h_theme.'/accounting/cashier',$viewdata);
			$this->load->view($this->h_theme.'/footer');
		}
	} 


    /**
     * Manages the hotels online payments records 
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	public function payments()
	{ 
        // Check if the user has permission to access this method
        error_redirect(has_privilege('payments'), '401');

		$filter_from = $this->input->get('from');
		$filter_to   = $this->input->get('to');
		$filter      = array();
		if ($filter_from) 
		{
			$filter['from'] = $filter_from;
		}
		if ($filter_to) 
		{
			$filter['to'] = $filter_to;
		}
        
        $filter['type'] = 'ALL';
		
		$filter_query = ($filter_from && $filter_to ? '?from='.$filter_from.'&to='.$filter_to : ($filter_from ? '?from='.$filter_from : ($filter_to ? '?to='.$filter_to : null)));

		$viewdata = array(
			'payments' => $this->payment_model->get_payments($filter),  
			'date_from' => $this->payment_model->min_max(),
			'date_to' => $this->payment_model->min_max(1),
			'from' => $filter_from,
			'to' => $filter_to,
			'filter_query' => $filter_query,
			'use_table' => TRUE, 
			'table_method' => 'payment_report'.($filter_query)
		); 

		$data = array('title' => 'Sales Report - ' . my_config('site_name'), 'page' => 'sales_report');

		if ($this->input->post('print')) 
		{	
			$viewdata['table_method'] = 'payment_report/0'.($filter_query);
			$this->load->view($this->h_theme.'/accounting/payment_report',array_merge($data, $viewdata));
		}
		else
		{
			$this->load->view($this->h_theme.'/header', $data);
			$this->load->view($this->h_theme.'/accounting/payments',$viewdata);
			$this->load->view($this->h_theme.'/footer');
		}
	} 


    /**
     * Manages the hotels room sale records
     * Record filters are dates specifying the record date 
     * ranges to fetch, the request is made through get queries
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	public function room_sales()
	{ 
        // Check if the user has permission to access this method
        error_redirect(has_privilege('room-sales'), '401');

		$filter_from = $this->input->get('from', TRUE);
		$filter_to = $this->input->get('to', TRUE);
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
			'room_sales' => $this->room_model->room_sales($filter),  
			'date_from' => $this->room_model->min_max(),
			'date_to' => $this->room_model->min_max(1),
			'from' => $filter_from,
			'to' => $filter_to,
			'filter_query' => $filter_query,
			'use_table' => TRUE, 
			'table_method' => 'room_sales_report'.($filter_query)
		); 

		$data = array('title' => 'Room Sale - ' . my_config('site_name'), 'page' => 'room_sales');

		if ($this->input->post('print')) 
		{	
			$viewdata['table_method'] = 'cashier_report/0'.($filter_query);
			$this->load->view($this->h_theme.'/accounting/room_sales_report',array_merge($data, $viewdata));
		}
		else
		{
			$this->load->view($this->h_theme.'/header', $data);
			$this->load->view($this->h_theme.'/accounting/room_sales',$viewdata);
			$this->load->view($this->h_theme.'/footer');
		}
	} 


    /**
     * Manages the hotels expense register
     * @param  string $record_id	This specified for a particular record to be returned
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	public function expenses_register($record_id = '')
	{
        // Check if the user has permission to access this method
        error_redirect(has_privilege('expense-register'), '401');

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

		$data = array('title' => 'Expense Register - ' . my_config('site_name'), 'page' => 'expenses-register');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/accounting/expenses_register',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 


    /**
     * Deletes an expense record
     * @param  string $id     The id of the record to be deleted
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	function delete_expenses($record_id)
	{
        // Check if the user has permission to access this method
        error_redirect(has_privilege('expense-register'), '401');

		$this->session->set_flashdata(array('message' => alert_notice('Expense record Deleted', 'success'))); 
		$this->accounting_model->delete_expense($record_id);
		redirect("accounting/cashier");
	}


    /**
     * Deletes a payment record
     * @param  string $id     The id of the record to be deleted
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	function delete_payment($record_id)
	{
        // Check if the user has permission to access this method
        error_redirect(has_privilege('payments'), '401');

		$this->session->set_flashdata(array('message' => alert_notice('Payment record Deleted', 'success'))); 
		$payment = $this->payment_model->get_payments(['id' => $record_id]);
		$reservation = $this->reservation_model->fetch_reservation(['reservation_ref' => $payment['reference']]); 

		$this->reservation_model->deleteRoomSale($reservation['reservation_id']);
		$this->reservation_model->deleteReservation($reservation['reservation_id']);
		$this->payment_model->remove_payments($record_id);
		redirect("accounting/cashier/payments");
	}


    /**
     * Deletes a room sale record
     * @param  string $id     The id of the record to be deleted
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
	function delete_room_sale($record_id)
	{
        // Check if the user has permission to access this method
        error_redirect(has_privilege('room-sales'), '401');

		$this->session->set_flashdata(array('message' => alert_notice('Sales record Deleted', 'success'))); 
		$reservation = $this->reservation_model->fetch_reservation(['id' => $record_id]); 
		$payment = $this->payment_model->get_payments(['reference' => $reservation['reservation_ref']], TRUE); 

		$this->payment_model->remove_payments($payment['id']);
		$this->reservation_model->deleteRoomSale($reservation['reservation_id']);
		$this->reservation_model->deleteReservation($reservation['reservation_id']);
		redirect("accounting/cashier/room_sales");
	}
} 
