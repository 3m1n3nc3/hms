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
        	'page_title' => HOTEL_NAME . ' - ' . $content['title'],
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
        	'page_title' => $content['title'] . ' - ' . HOTEL_NAME,
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
    public function account($id = '')
    { 
    	$customer = $this->account_data->fetch($this->cuid, 1);
        $data = array(
        	'page' => 'account',
        	'page_title' => $customer['name'] . ' Account' . ' - ' . HOTEL_NAME,
        	'customer' => $customer,
        	'form_action' => 'account'
        );  

		$data['account_data'] = $this->load->view($this->h_theme.'/customer/view', $data, TRUE);

        $this->load->view($this->h_theme.'/homepage/header', $data);    		
        $this->load->view($this->h_theme.'/homepage/account_holder', $data);
        $this->load->view($this->h_theme.'/homepage/footer', $data);  
    }


    /**
     * Renders the login and registration pages
     * @param  string   $action   whether to do a login, forget password or register
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function access($action = 'login')
    { 
        $data = array(
        	'page' => $action,
        	'page_title' => ucwords($action) . ' - ' . HOTEL_NAME,
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
	        	$uu = '|is_unique[customers.customer_username]|alpha_dash';
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
						redirect('account/');
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
    	$fetch_invoice = $this->payment_model->get_payments(['reference' => $reference]); 
    	if (!$fetch_invoice) 
    	{
    		$fetch_invoice = $this->session->userdata('reservation'); 
    		$cust = $this->customer_model->get_customer(['email' => $fetch_invoice['email']]);
    		$fetch_invoice['customer_id'] = $cust['customer_id'];
    		$fetch_invoice['description'] = 'Reservation payments for ' . $fetch_invoice['room_type'] . ' room ' . $fetch_invoice['room_id'];

    	}
    	$invoice = $fetch_invoice;

        $customer = $this->account_data->fetch($invoice['customer_id'] ?? '', 1); 
        $post = $this->reservation_model->fetch_reservation(['reservation_ref' => $reference]); 
        $room = $this->room_model->getRoom(['id' => $post['room_id'] ?? $invoice['room_id']]);  
        $room_type_info = $this->room_model->getRoomType($room['room_type']); 
        $room_info = (array)($room_type_info[0] ?? []);

        error_redirect($invoice);    

        $post['invoice_id']  = $invoice['id'] ?? 'pending';
        $post['amount']      = $invoice['amount'] ?? $room_info['room_price'];
        $post['description'] = $invoice['description']; 
        $post['payment_ref'] = $invoice['reference'] ?? $invoice['payment_ref'];
        $post['room_type']   = $invoice['room_type'] ?? $room_info['room_type'];
        $post['room_id']     = $room['room_id'] ?? $invoice['room_id'];
        $post['date']    = date('Y-m-d', strtotime($fetch_invoice['date'] ?? 'NOW'));

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
        $query = array('safelink' => 'homepage');  

        $content = $this->content_model->get($query);

        $data = array(
        	'page' => 'rooms',
        	'page_title' => HOTEL_NAME . ' - ' . $content['title'],
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

    			$this->session->set_userdata('reservation', $post); 

    			if ($this->account_data->customer_logged_in()) 
    			{
					redirect('page/rooms/book/' . $post['room_type']);
    			}
    		}

    		// Check if the customer is logged in
    		if (!$this->account_data->customer_logged_in()) 
    		{
	    		$data['login_box'] = $customer ? 'login' : 'register';
	    		$data['login_action'] = 'page/rooms/book/' . $room->room_type;

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
    	if (isset($_SESSION['reservation']) && $this->account_data->customer_logged_in())
    	{
    		$post = $this->session->userdata('reservation');
			$customer = $this->account_data->fetch($this->cuid, 1);
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


    /**
     * Fetch data from the locale model and helpers
     * @param  string   $local   	specifies the local to return [countries|states|cities]
     * @param  string   $parent_id  If set will return the local for the set parent
     * @return NULL     Echoes a json string containing the data presented by the relevant helper
     */
    public function fetch_locale($locale = '', $parent_id = '')
    {
    	if ($locale == 'countries') 
    	{
    		$data['response'] = select_countries();
    	}
    	elseif ($locale == 'states') 
    	{
    		$data['response'] = select_states($parent_id);
    	}
    	elseif ($locale == 'cities') 
    	{
    		$data['response'] = select_cities($parent_id);
    	}

    	echo json_encode($data, JSON_FORCE_OBJECT);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
