<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Frontsite_Controller { 

    function __construct() 
    { 
        parent::__construct();  
        $this->payment_ref = $this->enc_lib->generateToken(12, 1, 'HRSPR-', TRUE);
    } 


    /**
     * Renders the default publicly available static contents and 
     * parses a page where the page method has not been called
     * @param  string   $id   id or safelink of the parent content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function index()
    {
        // Get a default page to render here
        $id = 'homepage'; 
        $query = filter_var($id, FILTER_VALIDATE_INT) ? array('id' => $id, 'or_safelink' => $data['page']) : array('safelink' => $id);  

        $content = $this->content_model->get($query);

        $data = array(
        	'page' => $content['safelink'],
        	'page_title' => my_config('site_name') . ' - ' . $content['title'],
        	'content' => $content,
        	'has_banner' => $content['banner'] ? TRUE : FALSE 
        ); 
        // If the page does not exist or the content has a parent, show 404 page
        if (!$data['content']) 
        {
        	redirect('login');
        }

        error_redirect(!$data['content']['parent']); 
        error_redirect($data['content']);   
 
        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/home', $data);
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }


    /**
     * Renders the publicly available static contents and parses a page
     * @param  string   $id   id or safelink of the parent content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function page($id = '')
    {
        
        $query = array('id' => $id, 'or_safelink' => $id);
        //$query = filter_var($id, FILTER_VALIDATE_INT) ? array('id' => $id) : array('safelink' => $id); 
       
        $content = $this->content_model->get($query);

        $data = array(
        	'page' => $content['safelink'],
        	'page_title' => $content['title'] . ' - ' . my_config('site_name'),
        	'content' => $content,
        	'has_banner' => $content['banner'] ? TRUE : FALSE 
        );  
 
        // If the page does not exist or the content has a parent, show 404 page
        error_redirect(!$data['content']['parent']); 
        error_redirect($data['content']);   
        
        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/home', $data);
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }


    /**
     * Renders the publicly available static contents and parses a page
     * @param  string   $id   id or safelink of the parent content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function account($id = '', $set_view = 'home')
    { 
        $id = urldecode($id);
        $this->account_data->is_customer_logged_in(TRUE);

    	$customer   = $this->account_data->fetch($this->cuid, 1);
    	$statistics = $this->accounting_model->statistics(['customer' => $customer['customer_id']]);

        $pconfig['base_url']   = site_url('account/'.$customer['customer_id'].'/'.$set_view);
        $pconfig['total_rows'] = count($this->customer_model->purchases(['customer_id' => $customer['customer_id']])); 

        $this->pagination->initialize($pconfig);
        $ppage = $this->uri->segment(4, 0);

        $purchases  = $this->customer_model->purchases(['customer_id' => $customer['customer_id'], 'page' => $ppage]); 

        $data = array(
        	'page' => 'account',
        	'page_title' => $customer['name'] . ' Account' . ' - ' . my_config('site_name'),
        	'customer' => $customer,
            'purchases' => $purchases, 
        	'statistics' => $this->accounting_model->statistics(['customer' => $customer['customer_id']]),
        	'form_action' => 'account',
            'set_view' => $set_view,
            'view_link' => 'account/'.$customer['customer_id']
        );  
        $data['pagination'] = $this->pagination->create_links();
 
		$post = $this->input->post(NULL, TRUE);
		if ($post) 
		{ 
			$unique_email = ($customer['customer_email'] !== $post['customer_email'] ? '|is_unique[customer.customer_email]' : '');
			$unique_tel = ($customer['customer_telephone'] !== $post['customer_telephone'] ? '|is_unique[customer.customer_telephone]' : '');

        	$this->form_validation->set_error_delimiters('<small class="text-danger pt-0">', '</small>'); 
			$this->form_validation->set_rules('customer_firstname', 'First Name', 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_lastname', 'Last Name', 'trim|required|alpha'); 
			$this->form_validation->set_rules('customer_email', 'Email', 'trim|valid_email'.$unique_email); 
			$this->form_validation->set_rules('customer_telephone', 'Phone', 'trim|required|numeric'.$unique_tel); 
			$this->form_validation->set_rules('customer_address', 'Address', 'trim|required'); 
			$this->form_validation->set_rules('customer_city', 'City', 'trim|required'); 
			$this->form_validation->set_rules('customer_state', 'State', 'trim|required'); 
            $this->form_validation->set_rules('customer_country', 'Country', 'trim|required'); 
			$this->form_validation->set_rules('accept', 'Accept', 'trim|required',
                    array('required' => 'You are required to accept our terms and conditions')
                ); 
            if ($post['nationality'] && $post['nationality'] !== config_item('site_country')) {
                $this->form_validation->set_rules('customer_passport_no', 'Passport Number', 'trim|required',
                    array('required' => 'By setting your nationality, you are required to enter your passport number, this only happens for non '.config_item('site_country').' citizens')
                ); 
            }

            unset($post['update_profile'], $post['accept']); 
	        if ($this->form_validation->run() !== FALSE) 
	        {	
	        	$post['cid'] = $customer['customer_id'];

				$this->customer_model->add_customer($post);
				$this->session->set_flashdata(
					array('update_profile'=> TRUE, 'message' => alert_notice('Profile Updated', 'success'))
				); 
				redirect('account');
			}  
		}

		$data['account_data'] = $this->load->view($this->h_theme.'/customer/view', $data, TRUE);

        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/account_holder', $data);
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }


    /**
     * Renders the users reservations page
     * @param  string   $id   id or safelink of the parent content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function reservations($room_id = '', $page = '')
    {  
        $room_id = urldecode($room_id);
        $this->account_data->is_customer_logged_in(TRUE);
        $customer = $this->account_data->fetch($this->cuid, 1);

        $reservation = $this->reservation_model->reserved_rooms(['customer' => $customer['customer_id']], 1);

        $config['uri_segment']  = 3;
        $config['base_url']     = site_url('reservations/'.$room_id);
        $config['total_rows']   = count($this->reservation_model->reserved_rooms(['room' => $room_id, 'uncheck' => TRUE])); 

        $rooms = $this->reservation_model->reserved_rooms(['customer' => $customer['customer_id'], 'uncheck' => TRUE, 'page' => $page]);

        $data = array('title' => 'Rooms - ' . my_config('site_name'), 'page' => 'reserved'); 

        $customer   = $this->account_data->fetch($this->cuid, 1);
        $statistics = $this->accounting_model->statistics(['customer' => $customer['customer_id']]);

        $data = array(
            'page'          => 'account',
            'subpage'       => 'reservation',
            'space'         => 'person',
            'page_title'    => lang('my_reservations') . ' - ' . my_config('site_name'),
            'customer'      => $customer,
            'statistics'    => $statistics,
            'reservation'   => $reservation,
            'rooms'         => $rooms,
            'checkin_date'  => date('Y-m-d', strtotime($reservation['checkin_date'])),
            'checkout_date' => date('Y-m-d', strtotime($reservation['checkout_date']))
        );  
        $data['pagination']    = $this->pagination->create_links();
        $data['customer_link'] = anchor('account/', $customer['name'], ['class'=>'font-weight-bold mt-1']);

        $data['print_invoice'] = $reservation['reservation_id'] ? anchor_popup('generate/invoice/'.$reservation['reservation_id'].'/reservation', '<i class="fa fa-print"></i> Print Invoice', ['class'=>'btn btn-success btn-block text-white font-weight-bold mt-1']) : '';

        $data['account_data'] = $this->load->view($this->h_theme.'/room/reserved_room', $data, TRUE);

        $this->load->view($this->h_theme.'/homepage/header', $data);    
        $this->load->view($this->h_theme.'/homepage/account_holder', $data);  
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }
 
 
    /**
     * Renders the users payments page
     * @param  string   $id   id or safelink of the parent content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function payments($action = '')
    { 
        $action = urldecode($action);
        $this->account_data->is_customer_logged_in(TRUE);
        $customer = $this->account_data->fetch(($this->cuid), 1);
        $reservation = $this->reservation_model->reserved_rooms(['customer' => $customer['customer_id']], 1);  

        $data = array(
            'page'          => 'account',
            'subpage'       => 'payments',
            'space'         => 'person',
            'page_title'    => lang('my_payments') . ' - ' . my_config('site_name'),
            'title'         => lang('my_payments') . ' - ' . my_config('site_name'),
            'customer'      => $customer, 
            'reservation'   => $reservation, 
            'payments'      => $this->payment_model->get_payments(['customer_id' => $customer['customer_id']]),  
            'checkin_date'  => date('Y-m-d', strtotime($reservation['checkin_date'])),
            'checkout_date' => date('Y-m-d', strtotime($reservation['checkout_date']))
        );  

        // Print an invoice of the selected payment
        if ($action === 'print') 
        {
            $reference = $this->input->get('reference');

            $data['action']              = site_url('my-payments/print/?print=true&reference=' . $this->input->get('reference'));
            $data['show_footer']         = TRUE;

            $fetch_invoice               = $this->payment_model->get_payments(['reference' => $reference]); 
            $data['post']                = $this->reservation_model->fetch_reservation(['reservation_ref' => $reference]);   
            $data['post']['invoice_id']  = $fetch_invoice['id'];
            $data['post']['amount']      = $fetch_invoice['amount'];
            $data['post']['description'] = $fetch_invoice['description']; 
            $data['post']['payment_ref'] = $fetch_invoice['reference'];
            $data['post']['room_id']     = $fetch_invoice['room_id'];
            $data['post']['date']        = date('Y-m-d', strtotime($fetch_invoice['date'] ?? 'NOW'));
            
            $room                        = $this->room_model->getRoom(['id' => $fetch_invoice['room_id'] ?? '']); 
            $room_type_info              = $this->room_model->getRoomType($room['room_type']); 

            $data['room']                = $room_type_info; 
            $data['room']['room_type']   = $room['room_type'];  
            $data['post']['room_type']   = $room['room_type'];  
            $this->load->view($this->h_theme.'/header_plain', $data); 
            $this->load->view($this->h_theme.'/homepage/invoice_inline', $data); 
        }
        else
        {
            $data['account_data'] = $this->load->view($this->h_theme.'/homepage/my_payments', $data, TRUE);
            $this->load->view($this->h_theme.'/homepage/header', $data);    
            $this->load->view($this->h_theme.'/homepage/account_holder', $data);  
            $this->load->view($this->h_theme.'/homepage/footer', $data); 
        } 
    }


    /**
     * Renders the login and registration pages
     * @param  string   $action   whether to do a login, forget password or register
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function access($action = 'login')
    { 
        $action = urldecode($action);
        $data = array(
        	'page' => $action,
        	'page_title' => ucwords($action) . ' - ' . my_config('site_name'),
        	'login_box' => $action,
        	'login_action' => 'account/login'
        );  

        // Log the customer out
		if ($action == 'logout') 
		{
			$this->account_data->customer_logout();
		} 
		
		// If the user is already logged in redirect them 
		if ($this->account_data->customer_logged_in())
		{	
        	$this->account_data->customer_redirect();
		}

		$login_data['username'] = $this->input->post("username"); 
		$login_data['password'] = $this->input->post("password");

		// Try to log the customer in
		$post = $this->input->post(NULL, TRUE);

		if (isset($post['login_form'])) 
		{
	        $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>');
	        $uu = null; 
	        if ($action == 'register') 
	        {
	        	$uu = '|is_unique[customers.customer_username]|is_unique[employee.employee_username]|alpha_dash';
	        	$this->form_validation->set_rules('customer_email', lang('email_address'), 'trim|required|is_unique[customer.customer_email]|valid_email');
	        	$this->form_validation->set_rules('customer_telephone', lang('phone'), 'trim|required|is_unique[customer.customer_telephone]');  
	        }
	        $this->form_validation->set_rules('username', lang('username'), 'trim|required'.$uu);  
	        $this->form_validation->set_rules('password', lang('password'), 'trim|required');  

	        if ($this->form_validation->run() !== FALSE) 
	        { 
				if ($post['login_form'] == 1) 
				{
					if($user = $this->user_model->customer_login($login_data)) 
					{
						$this->account_data->customer_login($user);

                        // If the user was viewing a page the required login, redirect them to that page now
                        if (isset($_SESSION['redirect_customer_to'])) 
                        {
                            redirect($this->session->userdata('redirect_customer_to'));
                        }
                        else
                        {
						  redirect('account');
                        }
					}
					else
					{
						$this->session->set_flashdata('message', alert_notice(lang('invalid_username_password'), 'error', FALSE)); 
					}
				}
				else
				{
					$this->hms_data->customer_register('account');
				}
			}
			else
			{
				if ($action == 'login')
					$this->session->set_flashdata('message', alert_notice(validation_errors(), 'error', FALSE)); 
			}
		}  

		// Parse the login and registration view to an array
        if ($action !== 'register') 
        {
        	$data['login_box'] = 'login';
        }
		$data['account_data'] = $this->load->view($this->h_theme.'/homepage/login_box', $data, TRUE);

        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/account_holder', $data);
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }


    /**
     * Renders the invoice
     * @param  string   $id   id of the invoice item to read
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function invoice($reference = '')
    {
        $reference = urldecode($reference);
        error_redirect(has_privilege('cashier-report') OR $this->account_data->is_customer_logged_in(), '401');
    	$fetch_invoice = $this->payment_model->get_payments(['reference' => $reference]); 
    	if (!$fetch_invoice) 
    	{
    		$fetch_invoice = $this->session->userdata('reservation'); 
            error_redirect($fetch_invoice);

    		$cust = $this->customer_model->get_customer(['email' => $fetch_invoice['email']]);
    		$fetch_invoice['customer_id'] = $cust['customer_id'];
    		$fetch_invoice['description'] = 'Reservation payments for ' . $fetch_invoice['room_type'] . ' room ' . $fetch_invoice['room_id'];

    	}

        error_redirect($fetch_invoice);
        
    	$invoice = $fetch_invoice; 

        $customer = $this->account_data->fetch($invoice['customer_id'] ?? '', 1); 
        $post = $this->reservation_model->fetch_reservation(['reservation_ref' => $reference]); 
        $room = $this->room_model->getRoom(['id' => $post['room_id'] ?? $invoice['room_id']]);  
        $room_type_info = $this->room_model->getRoomType($room['room_type']); 
        $room_info = (array)($room_type_info[0] ?? []);   

        $post['invoice_id']  = $invoice['id'] ?? 'pending';
        $post['amount']      = $invoice['amount'] ?? $room_info['room_price'];
        $post['description'] = $invoice['description']; 
        $post['payment_ref'] = $invoice['reference'] ?? $invoice['payment_ref'];
        $post['room_type']   = $invoice['room_type'] ?? $room_info['room_type'];
        $post['room_id']     = $room['room_id'] ?? $invoice['room_id'];
        $post['invoice']     = $invoice['invoice'] ?? $post['room_id'].date('ymdHm');
        $post['date']        = date('Y-m-d', strtotime($fetch_invoice['date'] ?? 'NOW'));

        $viewdata = [
        	'title' => $post['description'] . ' Invoice',
        	'show_footer' => TRUE,
        	'post' => $post, 
        	'customer' => $customer, 
        	'room' => $room_type_info
        ];
         
        $this->load->view($this->h_theme.'/header_plain', $viewdata);  
        $this->load->view($this->h_theme.'/homepage/invoice_inline', $viewdata);
    }


    /**
     * Renders the invoice
     * @param  string   $id   id of the invoice item to read
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function generic_invoice($reference = '', $get_type = '')
    {
        $reference = urldecode($reference);
        $reference = ($reference == 'ALL') ? NULL : $reference;
        error_redirect(has_privilege('cashier-report') OR $this->account_data->is_customer_logged_in(), '401');

        $invoice_date  = 'NOW';
        $customer_name = $customer_address = $item_name = $description = $action = $type = $type_header = '';
        $customer_id   = $amount = $invoice_id = $quantity = $vat = 0;
        $variables     = array(); 

        // Debt payments Invoice
        $type_debt_payment = ($this->input->post('print') == 'debt_payment' || $this->input->get('print') == 'debt_payment' || $get_type == 'debt_payment');
        $type_reservation  = ($this->input->post('print') == 'reservation' || $this->input->get('print') == 'reservation' || $get_type == 'reservation');
        $type_payment      = ($this->input->post('print') == 'payment' || $this->input->get('print') == 'payment' || $get_type == 'payment');

        if ($type_debt_payment) 
        {  
            $paid_info = $this->payment_model->get_debt_payments(
                ['table' => 'sales_service_orders', 'am_prop' => 'order_price', 'id' => $reference]
            );      
            $invoice_id       = $reference;                          
            $type             = 'debt_payment';
            $type_header      = 'Debt Clearance';
            $invoice_id       = $paid_info['id'];
            $invoice_date     = $paid_info['date'];
            $customer_name    = $paid_info['customer_name'];
            $customer_address = $paid_info['customer_address'];
            $customer_id      = $paid_info['customer_id'];
            $quantity         = 1;
            $item_name        = $paid_info['item_name'] . ' Purchase';
            $reference        = $paid_info['payment_id'];
            $description      = $paid_info['description'];
            $amount           = $paid_info['amount'];  
            $action           = 'homepage/generic_invoice/' . $paid_info['id'] . '/-post';
            $variables        = ['invoice_type' => $type, 'margin' => 'mx-auto'];
            error_redirect(($this->cuid == $customer_id) OR has_privilege('payments'), '401');
        } 
        elseif ($type_reservation) 
        {
            // Reservation Invoice
            $finvoice = $this->payment_model->get_payments(['ref_reservation' => $reference]); 
            if (!$finvoice) 
            {
                $finvoice = $this->session->userdata('reservation');  

                if ($finvoice) {
                    $cust = $this->customer_model->get_customer(['email' => $finvoice['email']]);
                    $finvoice['customer_id'] = $cust['customer_id'];
                    $finvoice['description'] = 'Reservation payments for ' . $finvoice['room_type'] . ' room ' . $fetch_invoice['room_id'];
                }

            } 
            if ($finvoice) {
                $customer       = $this->account_data->fetch($finvoice['customer_id'] ?? '', 1); 
                $post           = $this->reservation_model->fetch_reservation(['reservation_ref' => $reference]); 
                $room           = $this->room_model->getRoom(['id' => $post['room_id'] ?? $finvoice['room_id']]);  
                $room_type_info = $this->room_model->getRoomType($room['room_type']); 
                $room_info      = o2Array($room_type_info[0] ?? []);  
                $room_id        = $room['room_id'] ?? $finvoice['room_id'];

                $invoice_id       = $finvoice['id'] ?? 'pending';
                $type             = 'reservation';
                $type_header      = 'Reservation';
                $amount           = $finvoice['amount'] ?? $room_info['room_price'];
                $description      = $finvoice['description'];  
                $invoice_date     = $finvoice['date'];  
                $vat              = $room_info['vat'];  
                $reference        = $post['payment_ref'] = ($finvoice['reference'] ?? $finvoice['payment_ref']);
                $item_name        = ($finvoice['room_type'] ?? $room_info['room_type']) . ' Room ' . $room_id;
                $invoice_no       = $finvoice['invoice'] ?? $post['room_id'].date('ymdHm');
                $customer_name    = $customer['customer_firstname'] . ' ' . $customer['customer_lastname'];
                $customer_address = $customer['customer_address'];
                $customer_id      = $customer['customer_id'];
                $quantity         = 1;    
                $action           = 'homepage/generic_invoice/' . $reference . '/-post';
                $variables        = ['invoice_type' => $type, 'margin' => 'mx-auto'];

                $variables        = [
                    'invoice_no' => $invoice_no, 'invoice_type' => $get_type, 'margin' => 'mx-auto', 'post' => $post, 'room' => $room_type_info, 
                'customer' => $customer];

                error_redirect(($this->cuid == $customer_id) OR has_privilege('payments'), '401');
            } else {
                error_redirect($finvoice);
            }
        }
        elseif ($type_payment) 
        {
            $finvoice = $this->payment_model->get_payments( ['reference' => $reference]); 
        } else {
            $finvoice = $this->payment_model->get_payments( ['reference' => $reference, 
                'type' => ['type' => $get_type, 'col' => 'invoice', 't_col' => 'id']]
            );
            $invoice_id       = $reference;                          
            $type             = $get_type;
            $type_header      = ucwords(str_ireplace('_', ' ', $get_type));
            $invoice_id       = $finvoice['id'];
            $invoice_date     = $finvoice['date'];
            $customer_name    = $finvoice['customer_name'];
            $customer_address = $finvoice['customer_address'];
            $customer_id      = $finvoice['customer_id'];
            $quantity         = 1;
            $item_name        = $type_header . ' Payment';
            $reference        = $finvoice['reference'];
            $description      = $finvoice['description'];
            $amount           = $finvoice['amount'];  
            $action           = 'homepage/generic_invoice/' . $finvoice['reference'] . '/' . $get_type . '/-post';
            $variables        = ['invoice_type' => $type, 'margin' => 'mx-auto'];
            
            error_redirect(($this->cuid == $customer_id) OR has_privilege('payments'), '401');
        }
        $invoice   = array(
            'invoice_id'    => $invoice_id,    'date'          => date('d M Y', strtotime($invoice_date)),
            'customer_name' => $customer_name, 'customer_addr' => $customer_address,
            'customer_id'   => $customer_id,   'qty'           => $quantity,    'item'      => $item_name, 
            'reference'     => $reference,     'description'   => $description, 'amount'    => $amount, 
            'action'        => $action,        'vat'           => $vat,         'variables' => $variables
        );
        $viewdata = [
            'title' => $type_header . ' Invoice',
            'show_footer' => TRUE 
        ];
        $this->load->view($this->h_theme.'/header_plain', $viewdata);  
        $this->load->view($this->h_theme.'/extra_layout/generic_invoice', $invoice);
    }


    /**
     * Renders the rooms info page
     * @param  string   $id   id of the room content to render
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function rooms($room_id = '', $action = '')
    { 
    	// If the user opens another room, remove the current room from the session
    	$changeable = $this->session->userdata('reservation');
    	if (isset($_SESSION['reservation']) && strtolower($room_id) !== strtolower($changeable['room_type'])) 
    	{
    		$this->session->unset_userdata('reservation');
    	}

        // Get a default page to render here 
        $room_id = urldecode($room_id); 
        $action  = urldecode($action);
        $query   = array('safelink' => 'homepage');  

        $content = $this->content_model->get($query);

        $data = array(
        	'page' => 'rooms',
        	'page_title' => my_config('site_name') . ' - ' . $content['title'],
        	'content' => $content,
        	'room' => $this->room_model->getRoomType($room_id)[0] ?? [],
        	'has_banner' => $content['banner'] ? TRUE : FALSE 
        ); 
        // If the page does not exist or the content has a parent, show 404 page
        if (!$data['content']) 
        {
        	redirect('login');
        }

        // Process the checkin request
        $post = $this->input->post(NULL, TRUE); 
        $customer = [];
        if (isset($post['email']) || isset($post['username'])) 
        {
        	$customer = $this->customer_model->get_customer(['email' => $post['email'] ?? $post['username']]);
        }

        if (isset($post['checkin_date'], $post['email']) && !isset($post['reserve_room'])) 
        {
        	if ($customer) 
        	{ 
        		$_POST['email'] = $post['email'];
        		$_POST['customer_TCno'] = $post['customer_TCno'] = $customer['customer_TCno'];
        		unset($post['email']);
        	} 	

    		// Fetch all available rooms for this room type
			$data['book_rooms'] = $this->reservation_model->get_available_rooms_inline($post);
        }

    	// If the user has requested to reserve a room or to login
    	if (isset($post['reserve_room']) || isset($post['login_form']))
    	{ 

    		// Set the selected room to session, so that we can retrieve it after user logs in
    		if (isset($post['reserve_room']) && !isset($_SESSION['reservation'])) 
    		{
    			// Set the payment reference
                $post['payment_ref'] = $this->payment_ref;
    			$post['invoice']     = $post['room_id'].date('ymdHm');

    			$this->session->set_userdata('reservation', $post); 

    			if ($this->account_data->customer_logged_in()) 
    			{
					redirect('page/rooms/book/' . $post['room_type']);
    			}
    		}

    		// Check if the customer is logged in
    		if (!$this->account_data->customer_logged_in()) 
    		{
	    		$login_session = $this->session->userdata('reservation');

	    		$data['login_box'] = $customer ? 'login' : 'register';
	    		$data['login_action'] = 'page/rooms/book/' . ($login_session['room_type'] ?? '');

				$pre_session = $this->session->userdata('reservation');

				$login_data['username'] = $this->input->post("username"); 
				$login_data['password'] = $this->input->post("password");

    			// Try to log the customer in
    			if (isset($post['login_form'])) 
    			{
    				if ($post['login_form'] == 1) 
    				{
						if($user = $this->user_model->customer_login($login_data)) 
						{
							$this->account_data->customer_login($user);
							redirect('page/rooms/book/' . $pre_session['room_type']);
						}
						else
						{
							$this->session->set_flashdata('message', alert_notice(lang('invalid_username_password'), 'error', FALSE, 'FLAT')); 
						}
	    			}
	    			else
	    			{
	    				$this->hms_data->customer_register('page/rooms/book/' . $pre_session['room_type']);
	    			}
    			}

	    		// Parse the login and registration view to an array
	    		$data['reserve_room'] = $this->load->view($this->h_theme.'/homepage/login_box', $data, TRUE);
    		}
    	}
 
    	// Reserve the room
    	if (isset($_SESSION['reservation']) && isset($this->logged_customer['customer_id']))
    	{
    		$post           = $this->session->userdata('reservation');
			$customer       = $this->account_data->fetch($this->logged_customer['customer_id'], 1);
			$room_type_info = $this->room_model->getRoomType($post['room_type']); 

			// Check if the customer and room types are set
			if ($customer && $room_type_info) 
			{
				// Prepare the data for insert
				$sessioned = array();
				$sessioned['customer_id']       = $customer['customer_id'];
				$sessioned['room_id'] 	        = $post['room_id'];
				$sessioned['checkin_date']      = $post['checkin_date'];
				$sessioned['checkout_date']     = $post['checkout_date'];
				$sessioned['reservation_date']  = date('Y-m-d');
				$sessioned['reservation_price'] = $room_type_info[0]->room_price ?? '';
				$sessioned['employee_id']       = 0;
	 
				$date = date('Y-m-d');
				if($date > $sessioned['checkin_date']) 
				{ 
					// If reservation date is in the past (show error)
					$data['reserve_room'] = '
					<div class="container mt-5">' . alert_notice(lang('checkin_date_past'), 'error') . '</div>';   
				}
				else
				{
					// If the payment has been processed
					if ($this->input->get('reference'))
					{
		            	// Process the payment
		                $data['reserve_room'] = $this->hms_payments->paystack();  
		        	}
		        	else
		        	{
        				$post['date']    	  = date('Y-m-d', strtotime('NOW'));
    					$post['invoice_id']   = 'pending';
    					$post['description']  = 'Reservation payments for '.$post['room_type'].' room '.$post['room_id']; 
		        		$data['reserve_room'] = $this->hms_parser->show_invoice(
		        			['post' => $post, 'customer' => $customer, 'room' => $room_type_info]
		        		);
		        	}
				}
			}
    	}

        error_redirect(!$data['content']['parent']); 
        error_redirect($data['content']);   
 
        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/room_info', $data); 
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }
} 
