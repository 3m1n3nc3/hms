<?php

class Reservation_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
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
        $query = $this->db->insert('reservation', $data);
        // return $query->affected_rows();
    }

    public function fetch_reservation()
    {
        $this->db->select('*')->from('reservation');
 
        $this->db->order_by('checkin_date', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }
}
