<?php

class Reservation_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
    
    function get_available_rooms($data)
    {
        $room_type = $data['room_type'];
        $checkin_date = $data['checkin_date'];
        $checkout_date = $data['checkout_date'];
        $adults = $data['adults'];
        $children = $data['children'];

        $query = $this->db->query(
            "CALL get_available_rooms(
                '$room_type', '$checkin_date', '$checkout_date', '$adults', '$children'
            )"
        );
        
        $this->db->reconnect();
        $data = array();

        foreach (@$query->result() as $row)
        {
            $data[] = $row;
        }
        if(count($data))
            return $data;
        return false;
    }

    public function add_reservation($data, $date=NULL)
    {
        $this->db->insert('reservation', $data);
        return $this->db->insert_id();
    }

    public function fetch_reservation($data = array())
    {
        if (isset($data['id']))
        {
            $this->db->where('reservation_id', $data['id']);
        }

        $this->db->select('*')->from('reservation');
 
        $this->db->order_by('checkin_date', 'ASC');
        $query = $this->db->get();

        if (isset($data['id']))
        {
            return $query->row_array();
        }

        return $query->result_array();
    }

    public function reserved_rooms($data = array(), $row = null)
    {   
        $date = date('Y-m-d');
         
        if (isset($data['room'])) 
        {
            $this->db->where('reservation.room_id', $data['room']);
        } 

        if (isset($data['customer'])) 
        { 
            $this->db->where('reservation.customer_id', $data['customer']);
        } 

        if (!isset($data['uncheck'])) 
        {
            $this->db->where('checkout_date >=', $date);
        }

        $this->db->select('*')->from('reservation');
        $this->db->join('customer', "reservation.customer_id=customer.customer_id", "LEFT");
        $this->db->join('room', "room.room_id=reservation.room_id", "LEFT");
         
        if (isset($data['page']) && !$row) 
        {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }
 
        $this->db->order_by('checkin_date', 'ASC'); 

        if ($row) 
        {
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result();
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
