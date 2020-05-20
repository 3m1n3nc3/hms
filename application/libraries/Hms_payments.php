<?php

class Hms_payments {  

    private $CI;
    private $post;
    private $customer;
    private $room_type_info;

    function __construct() {
        $this->CI = & get_instance(); 

        $this->CI->load->model('customer_model'); 
        $this->CI->load->model('room_model'); 
        $this->CI->load->model('payment_model'); 
        $this->CI->load->model('reservation_model'); 

        $this->cuid           = $this->CI->session->userdata('cuid');

        $this->post           = $this->CI->session->userdata('reservation');
        $this->customer       = $this->CI->account_data->fetch(($this->cuid??''), 1); 
        $this->room_type_info = $this->CI->room_model->getRoomType($this->post['room_type']); 
    }

    function paystack($customer = array()) 
    {
        $container_holder = '<div class="container mt-5">%s</div>';

        // Prepare the data for insert
        $booked_days         = dateDifference($this->post['checkin_date'], $this->post['checkout_date']);
        $post['booked_days'] = $booked_days > 0 ? $booked_days : 1;
        $amount              = ($room_type_info[0]->room_price ?? 0)*$post['booked_days']; 

        $sessioned = array();
        $sessioned['customer_id']       = $this->customer['customer_id'];
        $sessioned['room_id']           = $this->post['room_id'];
        $sessioned['checkin_date']      = $this->post['checkin_date'];
        $sessioned['checkout_date']     = $this->post['checkout_date'];
        $sessioned['reservation_ref']   = $this->post['payment_ref']; 
        $sessioned['adults']            = $this->post['adults']; 
        $sessioned['children']          = $this->post['children']; 
        $sessioned['reservation_date']  = date('Y-m-d H:i:s');
        $sessioned['reservation_price'] = $amount;
        $sessioned['employee_id']       = 0;
        $sessioned['status']            = 1; 

        $date = date('Y-m-d');

        // Verify the payment
        $this->CI->load->library('paystack');
        $verify_pay = $this->CI->paystack->pay($this->post['payment_ref']);
        
        if ($verify_pay->data->status === 'success') 
        {
            if (!$this->CI->payment_model->get_payments(['reference' => $this->post['payment_ref']])) 
            { 
                $save['reference']    = $this->post['payment_ref']; 
                $save['invoice']      = $this->post['invoice']; 
                $save['customer_id']  = $this->customer['customer_id']; 
                $save['payment_type'] = 'reservation'; 
                $save['amount']       = $sessioned['reservation_price']; 
                $save['description']  = sprintlang('reservation_invoice_desc', [$this->post['room_type'],$this->post['room_id'],$booked_days]); 
                $data['payment_id']   = $this->CI->payment_model->add_payments($save);    

                if ($data['payment_id']) 
                {
                    // Add the reservation and set the reservation_id to a variable
                    $reservation_id = $this->CI->reservation_model->add_reservation($sessioned);

                    unset($sessioned['reservation_date'], $sessioned['reservation_price'], $sessioned['reservation_ref'], $sessioned['children'], $sessioned['adults']);

                    $sessioned['reservation_id']   = $reservation_id;
                    $sessioned['room_sales_price'] = $sessioned['reservation_price'];
                    
                    // Add the room sale
                    $this->CI->room_model->add_room_sale($sessioned); 
                    $this->CI->session->unset_userdata('reservation');

                    $this->post['invoice_id']  = $reservation_id;
                    $this->post['description'] = $save['description']; 
                    $this->post['date']        = date('Y-m-d', strtotime('NOW'));

                    $customer_id = $save['customer_id'];
                    $room_id     = $sessioned['room_id'];

                    $re_data = array( 
                        'type'          => 'customer_paid_reservation',
                        'notifier_type' => 'customer',
                        'user_id'       => $save['customer_id'],
                        'url'           => site_url('room/reserved_room/'. $room_id .'/'. $customer_id)
                    );
                    $this->notifications->notifyPrivilegedMods($re_data); 

                    $reserve_room = sprintf($container_holder, alert_notice(lang('reservation_made'), 'success'));
                    $reserve_room .= $this->CI->hms_parser->show_invoice(
                        ['post' => $this->post, 'customer' => $this->customer, 'room' => $this->room_type_info]
                    );
                    return $reserve_room;
                }
            }
            else
            {
                // Notice the user if this payment has already been processed
                return sprintf($container_holder, alert_notice(lang('payment_already_done'), 'success')); 
            }
        } 
        else 
        {
            // If there is an error from paystack
            return sprintf($container_holder, alert_notice('<b>'.$verify_pay->data->message.'</b>'.$verify_pay->message, 'danger'));  
        }
    }

    function payment_processor_loader($processor = '', $data = array())
    {
        return $this->CI->load->view($this->CI->h_theme.'/payment_inline/' .$processor. '_inline', $data, TRUE);
    } 
}
