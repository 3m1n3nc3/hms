<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Admin_Controller 
{ 
    public function __construct()
    {
        parent::__construct();    
    }
 
    /**
     * This method will allow you to add or update customers
     * @param  string   $ref    Probably the id or username of the customer if updating
     * @return null             Does not return anything but uses code igniter's view() method to render the page
     */
	public function add($ref="", $action = "create")
	{
        error_redirect(has_privilege('customers'), '401');
 
		$data = $this->input->post(NULL, TRUE);

		if ($action === 'update') 
		{
			$customer = $this->customer_model->get_customer(['id' => $ref]); 
		}

		if ($data) 
		{
			$u_email = (($customer['customer_email'] ?? '') !== $data['customer_email'] ? '|is_unique[customer.customer_email]' : '');
			$u_tel = (($customer['customer_telephone'] ?? '') !== $data['customer_telephone'] ? '|is_unique[customer.customer_telephone]' : '');
			$u_TCn = (($customer['customer_TCno'] ?? '') !== $data['customer_TCno'] ? '|is_unique[customer.customer_TCno]' : '');

			if($data["customer_TCno"])
			{
        		$this->form_validation->set_error_delimiters('<small class="text-danger pt-0">', '</small>');
				$this->form_validation->set_rules('customer_TCno', lang('customer_id_code'), 'trim|required' . $u_TCn); 
				$this->form_validation->set_rules('customer_firstname', lang('firstname'), 'trim|required|alpha'); 
				$this->form_validation->set_rules('customer_lastname', lang('lastname'), 'trim|required|alpha'); 
				$this->form_validation->set_rules('customer_email', lang('email_address'), 'trim|valid_email' . $u_email); 
				$this->form_validation->set_rules('customer_telephone', lang('phone'), 'trim|required|numeric' . $u_tel); 
				$this->form_validation->set_rules('customer_address', lang('address'), 'trim|required'); 
				$this->form_validation->set_rules('customer_city', lang('city'), 'trim|required'); 
				$this->form_validation->set_rules('customer_state', lang('state'), 'trim|required'); 
				$this->form_validation->set_rules('customer_country', lang('country'), 'trim|required'); 

		        if ($this->form_validation->run() !== FALSE) 
		        {
					$msg = lang('new_customer_added');
		        	if ($action === 'update') 
					{
						$msg = lang('customer_updated');
						$data['cid'] = $customer['customer_id'];
					}
					
                    $customer_id = $this->customer_model->add_customer($data);

                    // Notify Admins of the addition
                    $re_data = array( 
                        'type' => 'added_new_customer', 
                        'url'  => site_url('customer/data/'.$customer_id) 
                    );

                    $this->notifications->notifyPrivilegedMods($re_data); 

					$this->session->set_flashdata('message', alert_notice($msg, 'success')); 
					redirect("customer/add/$ref/$action");
				} 
			}
		}

		if ($action === 'update') 
		{  
			$page_title = lang('update_customer') . " ({$customer['customer_firstname']})";
			$data = array(
				'title' => $page_title . ' - ' . my_config('site_name'), 
				'page' => 'customers', 
				'action_title' => $page_title,
				'action' => $action === 'update' ? 'Update' : 'Add'
			); 

			$this->load->view($this->h_theme.'/header', $data);

			$viewdata = array('reference' => $customer['customer_id']);
			$viewdata['customer'] = $customer;
			$viewdata['ref_token'] = $customer['customer_TCno'];
			$this->load->view($this->h_theme.'/customer/edit',$viewdata);
		}
		else
		{
			$page_title = "Add Customer";
			$data = array(
				'title' => $page_title . ' - ' . my_config('site_name'), 
				'page' => 'customers',
        		'sub_page_title' => $page_title, 
				'action_title' => $page_title,
				'action' => $action === 'update' ? 'Update' : 'Add'
        	); 

			$this->load->view($this->h_theme.'/header', $data);

			$viewdata = array('reference' => 'reservation');
			$viewdata['ref_token'] = $this->enc_lib->generateToken(rand(6,7), 1, 'CIC-');  
			$this->load->view($this->h_theme.'/customer/add',$viewdata);
		}
		$this->load->view($this->h_theme.'/footer');
	} 


    /**
     * This methods allow viewing of a customer's profile
     * @param  string   $id   	Id of the customer records to retrieve 
     * @return null             Does not return anything but uses code igniter's view() method to render the page
     */ 
	public function data($id = "", $set_view = 'home')
	{	
        error_redirect(has_privilege('customers'), '401');

        $id = trim(urldecode($id));

		if (!$customer   = $this->customer_model->get_customer(['customer_TCno' => $id]))
             $customer   = $this->customer_model->get_customer(['customer_id' => $id]);
        
        $pconfig['base_url']   = site_url('customer/data/'.$id.'/'.$set_view);
        $pconfig['total_rows'] = count($this->customer_model->purchases(['customer_id' => $customer['customer_id']])); 

        $this->pagination->initialize($pconfig);
        $ppage = $this->uri->segment(5, 0);

        $purchases   = $this->customer_model->purchases(['customer_id' => $customer['customer_id'], 'page' => $ppage]);

    	$statistics = $this->accounting_model->statistics(['customer' => $customer['customer_id']]);

		$viewdata = array(
            'customer' => $customer, 
            'purchases' => $purchases, 
            'statistics' => $statistics,
            'set_view' => $set_view
        );  
        $viewdata['pagination'] = $this->pagination->create_links();
 
		$post = $this->input->post(NULL, TRUE);
		if ($post) 
		{
			$unique_email = ($customer['customer_email'] !== $post['customer_email'] ? '|is_unique[customer.customer_email]' : '');
			$unique_tel = ($customer['customer_telephone'] !== $post['customer_telephone'] ? '|is_unique[customer.customer_telephone]' : ''); 

			$this->form_validation->set_rules('customer_firstname', lang('firstname'), 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_lastname', lang('lastname'), 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_email', lang('email_address'), 'trim|valid_email' . $unique_email); 
			$this->form_validation->set_rules('customer_telephone', lang('phone'), 'trim|required|numeric' . $unique_tel); 
			$this->form_validation->set_rules('customer_address', lang('address'), 'trim|required'); 
			$this->form_validation->set_rules('customer_city', lang('city'), 'trim|required'); 
			$this->form_validation->set_rules('customer_state', lang('state'), 'trim|required'); 
			$this->form_validation->set_rules('customer_country', lang('country'), 'trim|required'); 

	        if ($this->form_validation->run() !== FALSE) 
	        {	
	        	unset($post['update_profile']);
	        	$post['cid'] = $customer['customer_id'];

				$this->customer_model->add_customer($post);
				$this->session->set_flashdata(array('update_profile'=> TRUE, 'message' => alert_notice(lang('profile_updated'), 'success'))); 
				redirect('customer/data/'.$customer['customer_id']);
			}  
		}
        
		$data = array('title' => 'Customer ('.$customer['customer_firstname'].' '.$customer['customer_lastname'].') - ' . my_config('site_name'), 'page' => 'customer');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/customer/view',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 


    /**
     * View a detailed report on the customer
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function report($customer_id = '')
    {  
        $filter_from = $this->input->get('from');
        $filter_to   = $this->input->get('to');
        if ($filter_from) 
        {
            $query_data['from'] = $filter_from;
        }
        if ($filter_to) 
        {
            $query_data['to'] = $filter_to;
        }

        $query_data['customer_id'] = $query_data['customer'] = $customer_id;
        $query_data['uncheck']     = true;
        $query_data['type']        = 'ALL';

        $min_max_dates = $this->accounting_model->customer_report_dates(['customer_id' => $customer_id]);

        $viewdata = array(
            'reservations' => $this->reservation_model->reserved_rooms($query_data),  
            'payments'     => $this->payment_model->get_payments($query_data),   
            'purchases'    => $this->services_model->service_orders($query_data),   
            'statistics'   => $this->accounting_model->statistics($query_data),
            'customer'     => $this->customer_model->get_customer($query_data),
            'date_from'    => $min_max_dates['min_date'],
            'date_to'      => $min_max_dates['max_date'],
            'from'         => $filter_from,
            'to'           => $filter_to,
            'filter_query' => ''
        ); 

        $data = array('title' => 'Customer Report - ' . my_config('site_name'), 'page' => 'customer_report');
        $this->load->view($this->h_theme.'/customer/customer_report',array_merge($data, $viewdata));
    }


    /**
     * This methods lists all the available customers 
     * @return null             Does not return anything but uses code igniter's view() method to render the page
     */
	public function list()
	{	
        error_redirect(has_privilege('customers'), '401');

		$config['base_url']   = site_url('customer/list/');
        $config['total_rows'] = count($this->customer_model->list_customers()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(3, 0);

		$customers = $this->customer_model->list_customers(['page' => $_page]); 
		$viewdata  = array('customers' => $customers); 
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Customers - ' . my_config('site_name'), 'page' => 'customers');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/customer/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	} 


    /**
     * Delete a customer
     * @param  string   $customer_id   Id of customer to delete  
     * @return null     Redirects to the customer list
     */
	function delete($customer_id)
	{
        error_redirect(has_privilege('customers'), '401');
        $customer_id = urldecode($customer_id);

		$this->session->set_flashdata(array('message' => alert_notice(lang('customer_deleted'), 'success'))); 
		$this->customer_model->delete_customer($customer_id);
		redirect("customer/list");
	}


    /**
     * Sets the id number of the customer as flash data and redirects to the reservation
     * @param  string   $customer_id    Id of the customer to set 
     * @return null     Redirects to the reservation page
     */
    function reserve($customer_id)
    {
        error_redirect(has_privilege('customers'), '401');
        $customer_id = urldecode($customer_id);

        $this->session->set_flashdata('customer_TCno', $customer_id);
        redirect("reservation");
    }

    /**
     * Updates the customer's debt status for a purchase
     * @param  string   $action    Action being taken
     * @return null     Redirects to the reservation page
     */
    function update_debt($action = '') 
    {
        $resp['message']         = alert_notice('Permission Denied', 'danger');
        $resp['reservation_ref'] = $this->enc_lib->generateToken(12, 1, 'HRSPR-', TRUE);

        $nm_prop = $am_prop = $pd_prop = $id_prop = $append_item = null;

        if (has_privilege('customers')) {
            $data = $this->input->post(NULL, TRUE);

            $done = 'updated';

            $amount_note = $this->cr_symbol.number_format($data['amount'], 2);

            $update_debt_records = false;
            if ($action == 'update' || $action == 'clear') 
            {
                $item      = $this->customer_model->purchases(['item_id' => $data['item_id']]);
                $debt_note = $this->cr_symbol.number_format($item['order_price']-$item['paid'], 2);
                
                if ($action == 'clear')
                {
                    $done           = 'cleared';
                    $data['amount'] = $item['order_price']-$item['paid'];
                }

                $debt_data['payment_table'] = 'sales_service_orders';
                $append_item                = ' Purchase';
                $amt_prop                   = 'order_price';
                $success_message            = "Debt has been $done, $amount_note was paid.";
                $debt_data['description']   = "$amount_note Was paid off for a debt of $debt_note";
                if ($data['amount'] > $item['order_price'] || $data['amount'] <= 0) 
                {
                    $resp['message'] = alert_notice("Amount cannot be 0 and cannot be greater than $debt_note");
                } 
                else 
                {
                    $upd_debt_record = $this->customer_model->update_debt($data);
                }
            }
            elseif ($action == 'pay_overstay') 
            {

                $resvn = $this->reservation_model->fetch_reservation(['id' => $data['item_id']]);
                $item  = $this->reservation_model->overstayed_room(['customer' => $resvn['customer_id'], 'room' => $resvn['room_id']]); 

                $debt_note = $this->cr_symbol.number_format(($item['overdue_cost']), 2);

                $debt_data['payment_table'] = 'reservation';
                $append_item                = ' Room ' . $resvn['room_id'];
                $am_prop                    = $pd_prop = 'reservation_price';
                $nm_prop                    = 'reservation_ref';
                $id_prop                    = 'reservation_id';
                $success_message            = "Over stay debt of $amount_note was paid. You may need to refresh this page!";
                $debt_data['description']   = "$amount_note Was paid off for an overstay debt of $debt_note";
                $new_checkout_date = strtotime("{$item['checkout_date']} + {$data['p_days']} days");
                $upt_resvn = array(
                    'reservation_id' => $resvn['reservation_id'],
                    'checkout_date'  => date('Y-m-d H:i:s', $new_checkout_date)
                );
                $resp['total_debt'] = $debt_note;
                $resp['paid']    = $amount_note;
                $resp['debt']    = $this->cr_symbol.number_format($item['overdue_cost']-$data['amount'], 2);
                $upd_debt_record = $this->reservation_model->add_reservation($upt_resvn);
            } 
            
            if ($upd_debt_record)
            {
                // Add a new payment record
                $add_payment_record = array(
                    'customer_id'  => $resvn['customer_id'],
                    'payment_type' => 'debt_payments',
                    'reference'    => $resp['reservation_ref'],
                    'invoice'      => $resp['reservation_ref'],
                    'amount'       => $data['amount'],
                    'description'  => $debt_data['description']
                );
                $this->payment_model->add_payments($add_payment_record);

                $debt_data['amount']        = $data['amount'];
                $debt_data['payment_id']    = $data['item_id'];
                $ins = $this->payment_model->add_debt_payment($debt_data);

                $resp['message'] = alert_notice($success_message, 'success');

                $paid_info = $this->payment_model->get_debt_payments(
                    ['table' => $debt_data['payment_table'], 'am_prop' => $am_prop, 'id_prop' => $id_prop, 'pd_prop' => $pd_prop, 'nm_prop' => $nm_prop, 'id' => $ins]
                );

                $invoice   = array(
                    'invoice_id' => $paid_info['id'],
                    'date' => date('d M Y', strtotime($paid_info['date'])),
                    'customer_name' => $paid_info['customer_name'],
                    'customer_addr' => $paid_info['customer_address'],
                    'customer_id' => $paid_info['customer_id'],
                    'qty' => 1,
                    'item' => $paid_info['item_name'] . $append_item,
                    'reference' => $paid_info['payment_id'],
                    'description' => $paid_info['description'],
                    'amount' => $paid_info['amount'],
                    'action' => 'homepage/generic_invoice/' . $paid_info['id'] . '/-post',
                    'vat' => 0,
                    'variables' => ['invoice_type' => 'debt_payment', 'width' => 11, 'post' => [], 'room' => [], 'customer' => []] 
                );

                // Send notifications
                $re_data = array( 
                    'type' => 'cleared_a_debt',
                    'url'  => site_url('generate/invoice/' . $paid_info['id'] . '/debt_payment')
                );
                $this->CI->notifications->notifyPrivilegedMods($re_data);  

                $resp['message'] .= $this->load->view($this->h_theme.'/extra_layout/generic_invoice', $invoice, true);
            }

            $statistics['debt'] = $update['paid'] = $update['order_price'] = 0;
            if ($action == 'update' || $action == 'clear') 
            {
                $update         = $this->customer_model->purchases(['item_id' => $data['item_id']]);
                $statistics     = $this->accounting_model->statistics(['customer' => $item['customer_id']]);
                $resp['total_debt'] = $this->cr_symbol.number_format($statistics['debt'], 2);
                $resp['paid']       = $this->cr_symbol.number_format($update['paid'], 2);
                $resp['debt']       = $this->cr_symbol.number_format($update['order_price']-$update['paid'], 2);
            }
        } 

        header('Content-type: application/json'); 
        echo json_encode($resp);
    }
} 
