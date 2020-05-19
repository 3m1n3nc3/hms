<?php

class Reservation_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
 
    function get_available_rooms_inline($data, $array = FALSE)
    {
        $room_type = $data['room_type'];
        $checkin_date = date('Y-m-d H:i:s', strtotime($data['checkin_date']));
        $checkout_date = date('Y-m-d H:i:s', strtotime($data['checkout_date']));
        $adults = $data['adults'];
        $children = $data['children'];
  
        $this->db->select('*, room.room_id, (SELECT status FROM reservation WHERE `reservation`.`room_id` = `room`.`room_id` AND `reservation`.`reservation_id` != NULL) AS status, (SELECT checkin_date FROM reservation WHERE `reservation`.`room_id` = `room`.`room_id` AND `reservation`.`reservation_id` != NULL) AS checkin_date')->from('room')->join('room_type', '`room`.`room_type` = `room_type`.`room_type`', 'LEFT') ;
        $this->db->where('room.room_type', $room_type); 
        $this->db->where('room_type.max_adults >=', $adults); 
        $this->db->where('room_type.max_kids >=', $children); 
        $query = $this->db->where('
            NOT EXISTS (
                SELECT room_id FROM reservation WHERE reservation.room_id=room.room_id AND date(checkout_date) >= date(\''.$checkin_date.'\') AND date(checkin_date) <= date(\''.$checkout_date.'\') 
                UNION ALL
                SELECT room_id FROM room_sales WHERE room_sales.room_id=room.room_id AND date(checkout_date) >= date(\''.$checkin_date.'\') AND date(checkin_date) <= date(\''.$checkout_date.'\')
            )', NULL, FALSE
        )->get();
        
        $data = array();

        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        if(count($data))
            return $data;
        return false;
    } 

    public function add_reservation($data)
    {
        if (isset($data['reservation_id'])) 
        { 
            $this->db->where('reservation_id', $data['reservation_id']);
            $this->db->update('reservation', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('reservation', $data);
            return $this->db->insert_id();
        }
    }

    public function fetch_reservation($data = array())
    {
        if (isset($data['id']))
        {
            $this->db->where('reservation_id', $data['id']);
        }
        
        if (isset($data['reservation_ref']))
        {
            $this->db->where('reservation_ref', $data['reservation_ref']);
        }

        $this->db->select('*')->from('reservation');
 
        $this->db->order_by('checkin_date', 'ASC');
        $query = $this->db->get();

        if (isset($data['id']) || isset($data['reservation_ref']))
        {
            return $query->row_array();
        }

        return $query->result_array();
    }

    public function reserved_rooms($data = array(), $row = null)
    {   
        $date = date('Y-m-d H:i:s');

        if (isset($data['room'])) 
        {
            $this->db->where('reservation.room_id', $data['room']);
        } 

        if (isset($data['customer'])) 
        { 
            $this->db->where('reservation.customer_id', $data['customer']);
        } 

        if (!isset($data['uncheck']) && !isset($data['overstay'])) 
        {
            $this->db->group_start();
            $this->db->where('checkout_date >=', $date);
            $this->db->or_where('reservation.status', 1);
            $this->db->group_end();
        }

        if (isset($data['overstay'])) 
        {
            $this->db->where('checkout_date <', $date);
            $this->db->where('reservation.status', 1);
        }
        
        if (isset($data['from']))
        {
            $this->db->where('reservation_date >=', $data['from']);  
        } 
        
        if (isset($data['to']))
        {
            $this->db->where('reservation_date <=', $data['to']);  
        } 

        $this->db->select("*, reservation.checkin_date, reservation.checkout_date, CONCAT_WS(' ', customer_firstname, customer_lastname) AS customer_name")->from('reservation');
        $this->db->join('customer', "customer.customer_id=reservation.customer_id", "LEFT");
        $this->db->join('room', "room.room_id=reservation.room_id", "LEFT");
        // $this->db->join('room_type', "room_type.room_type=room.room_type", "LEFT");
         
        if (isset($data['page']) && !$row)
        {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }
 
        $this->db->order_by('checkin_date', 'DESC'); 

        if ($row) 
        {
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result();
    }

    public function overstayed_room($data = array(), $row = null)
    { 
        if (isset($data['customer'])) 
        { 
            $this->db->where('reservation.customer_id', $data['customer']);
        } 

        if (isset($data['room'])) 
        { 
            $this->db->where('reservation.room_id', $data['room']);
        } 

        $this->db->where('reservation.checkout_date < CURDATE()');
        $this->db->where('reservation.checkin_date < CURDATE()');
        $this->db->where('reservation.status', '1'); 
 
        $this->db->select("DATEDIFF(CURDATE(), reservation.checkout_date) AS overstay_days, customer.customer_id, CONCAT_WS(' ', customer_firstname, customer_lastname) AS customer_name, reservation.room_id, reservation.checkout_date, reservation.checkout_date, reservation.employee_id, reservation.reservation_date, reservation.reservation_price,, reservation.reservation_id, room_type.room_price, (SELECT room_type.room_price*overstay_days) AS overdue_cost")->from('reservation'); 

        $this->db->join('customer', "customer.customer_id=reservation.customer_id", "INNER");
        $this->db->join('room', "room.room_id=reservation.room_id", "INNER");
        $this->db->join('room_type', "room_type.room_type=room.room_type", "INNER");
        if (isset($data['customer'])) 
        {
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

    function deleteReservation($id = '')
    {
        $this->db->where('reservation_id', $id);
        $this->db->delete('reservation');
        return $this->db->affected_rows();
    }

    function deleteRoomSale($id = '')
    {
        $this->db->where('reservation_id', $id);
        $this->db->delete('room_sales');
        return $this->db->affected_rows();
    }
}
