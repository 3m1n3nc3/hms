<?php
    
if (!defined('BASEPATH'))
    exit('No direct script access allowed'); 

class Hms_parser 
{ 

    public function __construct() 
    { 
        $this->CI = & get_instance(); 
    }

    public function reservations()
    {
        $this->CI->load->model('reservation_model');
        $data = $this->CI->reservation_model->fetch_reservation();

        $reserved = [];
        foreach ($data as $reservations) 
        {
            $customer = $this->CI->customer_model->get_customer(['id' => $reservations['customer_id']]); 
            $room = $this->CI->room_model->getRoom(['id' => $reservations['room_id']]); 

            $sy = date('Y', strtotime($reservations['checkin_date']));
            $sm = date('m', strtotime($reservations['checkin_date']))-1;
            $sd = date('d', strtotime($reservations['checkin_date']));

            $ey = date('Y', strtotime($reservations['checkout_date']));
            $em = date('m', strtotime($reservations['checkout_date']))-1;
            $ed = date('d', strtotime($reservations['checkout_date']));

            $title = $room['room_type'].' Room '.$room['room_id'].' ('.$customer['customer_firstname']. ' ' .$customer['customer_lastname'].')';

            $reserved[] = 
            '{
                title          : \''.$title.'\',
                start          : new Date('.$sy.', '.$sm.', '.$sd.'),
                end            : new Date('.$ey.', '.$em.', '.$ed.'), 
                url            : \'http://google.com/\',
                backgroundColor: \'#00a65a\', //#f39c12-yellow
                borderColor    : \'#00a65a\', //yellow
                textColor      : \'#fff\' //yellow
            }';
        }
        $reservation = implode(',', $reserved);
        return $reservation;
    }


    public function update_stock($data = array())
    {
        foreach ($data as $key => $sid) 
        {
            $query = $this->CI->db->get_where('sales_service_stock', array('item_id' => $sid));
            $res = $query->row_array();

            $data['item_id'] = $sid;

            if ($res['item_quantity'] > 0) 
            {
                $new_quantity = ($res['item_quantity']-1);
                $data['item_quantity'] = $new_quantity;

                $this->CI->services_model->update_stock($data); 
            }
            else
            {
                $this->CI->services_model->delete_stock($data); 
            }
        }
    } 
}
