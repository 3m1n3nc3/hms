<?php

class Hms_data { 

    public $CI;

    function __construct() {
        $this->CI = & get_instance(); 
    }

    function customer_validation($customer = array()) 
    {
        $post = $this->CI->input->post(NULL, TRUE);

        if ($post) 
        {  
            $unique_username = (($customer['customer_username'] ?? '') !== $post['customer_username'] ? '|is_unique[customer.customer_username]' : '');
            $unique_email = (($customer['customer_email'] ?? '') !== $post['customer_email'] ? '|is_unique[customer.customer_email]' : '');
            $unique_tel = (($customer['customer_telephone'] ?? '') !== $post['customer_telephone'] ? '|is_unique[customer.customer_telephone]' : '');

            $this->CI->form_validation->set_error_delimiters('<small class="text-danger pt-0">', '</small>'); 
            $this->CI->form_validation->set_rules('customer_username', lang('username'), 'trim|required|alpha_dash'.$unique_username); 
            $this->CI->form_validation->set_rules('customer_password', lang('password'), 'trim|required'); 
            $this->CI->form_validation->set_rules('customer_firstname', lang('firstname'), 'trim|required|alpha'); 
            $this->CI->form_validation->set_rules('customer_lastname', lang('lastname'), 'trim|required|alpha'); 
            $this->CI->form_validation->set_rules('customer_email', lang('email_address'), 'trim|valid_email'.$unique_email); 
            $this->CI->form_validation->set_rules('customer_telephone', lang('phone'), 'trim|required|numeric'.$unique_tel); 
            $this->CI->form_validation->set_rules('customer_address', lang('address'), 'trim|required'); 
            $this->CI->form_validation->set_rules('customer_city', lang('city'), 'trim|required|alpha_dash'); 
            $this->CI->form_validation->set_rules('customer_state', lang('state'), 'trim|required|alpha_dash'); 
            $this->CI->form_validation->set_rules('customer_country', lang('country'), 'trim|required|alpha_dash'); 
        }
    }

    function customer_register($login = FALSE, $redirect = FALSE) 
    {
        $post = $this->CI->input->post(NULL, TRUE);

        if ($post) 
        {  
            $this->customer_validation();

            if ($this->CI->form_validation->run() !== FALSE) 
            {
                unset($post['update_profile'], $post['login_form'], $post['remember']);

                if (isset($customer['customer_id'])) 
                {
                    $post['cid'] = $customer['customer_id'];
                }
                
                // Encrypt the password    
                $post['customer_password'] = MD5($this->CI->input->post("customer_password"));

                // Insert the entered data to database
                $new_customer_id = $this->CI->customer_model->add_customer($post);

                // Check if the account was created successfully
                if ($new_customer_id && $login)
                {       
                    $login_data['username'] = $this->CI->input->post("customer_username"); 
                    $login_data['password'] = $this->CI->input->post("customer_password");
                    
                    // Log the new user in
                    if($user = $this->CI->user_model->customer_login($login_data)) 
                    {
                        $this->CI->account_data->customer_login($user); 
                    } 
                }

                $this->CI->session->set_flashdata(
                    array('create_account'=> TRUE, 'message' => alert_notice(lang('account_created'), 'success'))
                );
                
                if ($redirect === TRUE) 
                {
                    redirect('account');
                }
                elseif ($redirect) 
                {
                    redirect($redirect);
                }
            }  
            else
            {
                $this->CI->session->set_flashdata(
                    array('create_account'=> FALSE, 'message' => alert_notice(lang('input_has_errors'), 'error'))
                );
                return validation_errors();
            }
        }
    }
}
