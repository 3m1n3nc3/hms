<?php

class Room_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    function get_room_types()
    {
        $query = $this->db->get('room_type');
        $data = array();

        if($query)
            foreach ($query->result() as $row)
            {
                $data[] = $row;
            }
        if(count($data))
            return $data;
        return false;
    } 

    function get_rooms()
    {
        $query = $this->db->order_by('room_id')->get('room');
        $data = array();

        $i=-1;
        if ($query) 
        { 
            foreach ($query->result() as $row)
            {
                if($i==-1 || $data[$i]->room_type != $row->room_type || $data[$i]->max_id+1!=$row->room_id) 
                {
                    $i++;
                    $data[$i] = new stdClass();
                    $data[$i]->room_type = $row->room_type;
                    $data[$i]->min_id = intval($row->room_id);
                    $data[$i]->max_id = intval($row->room_id);
                } 
                else 
                {
                    $data[$i]->max_id ++;
                }
            }
            if(count($data))
                return $data;
        }
        return false;
    }

    public function room_sales($data = array())
    {
        $x_query = " WHERE 1=1";
        if (isset($data['reservation_id']))
        {
            $this->db->where('room_sales.reservation_id', $data['reservation_id']);
        }
        
        if (isset($data['reservation_ref']))
        {
            $this->db->where('reservation.reservation_ref', $data['reservation_ref']);
        }
        
        if (isset($data['from'])) 
        {
            $this->db->where('reservation.reservation_date >=', $data['from']); 
            $x_query .= " AND reservation.reservation_date >= '{$data['from']}'";
        } 
        
        if (isset($data['to'])) 
        {
            $this->db->where('reservation.reservation_date <=', $data['to']); 
            $x_query .= " AND reservation.reservation_date <= '{$data['to']}'";
        } 

        $this->db->select('*')->from('room_sales');
        $this->db->select('
            (SELECT SUM(room_sales_price) FROM room_sales '.$x_query.') AS total,
            (SELECT COUNT(reservation_id) FROM room_sales '.$x_query.') AS entries');
        $this->db->join('reservation', 'room_sales.reservation_id = reservation.reservation_id', 'LEFT');
 
        $this->db->order_by('room_sales.checkin_date', 'ASC');
        $query = $this->db->get();

        if (isset($data['reservation_id']) || isset($data['reservation_ref']))
        {
            return $query->row_array();
        }

        return $query->result_array();
    }

    function min_max($min_max = 0)
    {   
        $order = $min_max ? 'DESC' : 'ASC';
        $this->db->limit('1'); 
        $this->db->order_by('reservation_date '.$order); 
        $this->db->select('reservation.reservation_date AS date')->from('room_sales');
        $query = $this->db->join('reservation', 'room_sales.reservation_id = reservation.reservation_id', 'LEFT')->get();
        return $query->row_array();
    } 

    function addRoomType($data)
    { 
        $this->db->insert('room_type', $data);
        return $this->db->affected_rows();
    }

    function deleteRoomType($room_type)
    {
        $this->db->delete('room_type', array('room_type' => $room_type));
        return $this->db->affected_rows();
    }

    function getRoomType($room_type, $array = FALSE)
    {
        $query = $this->db->get_where('room_type', array('room_type' => $room_type));

        if ($array) 
        { 
            return $query->row_array();
        }
        return $query->result();
    }

    function editRoomType($data)
    { 
        $this->db->where('room_type', $data['room_type']);
        $this->db->update('room_type', $data); 
    }

    function getRoom($room_type)
    {
        if (isset($room_type['id'])) 
        {
            $this->db->where('room_id', $room_type['id']); 
            $this->db->select('room_id, room_type')->from('room');

            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            $query = $this->db->get_where('room', array('room_type' => $room_type));
            return $query->result();
        }
    }

    function isAvailRange($room_type, $min_id, $max_id) {
        $query = $this->db->get_where('room', array('room_type !=' => $room_type, 'room_id >=' => $min_id, 'room_id <=' => $max_id));
        return $query->result();
    }
    function getRoomRange($room_type, $min_id, $max_id) {
        $query = $this->db->get_where('room', array('room_id >=' => $min_id, 'room_id <=' => $max_id));
        return $query->result();
    }
    function deleteRoomRange($min_id, $max_id) {
        $this->db->delete('room', array('room_id >=' => $min_id, 'room_id <=' => $max_id));
        return $this->db->affected_rows();
    }

    function addRoomRange($room_type, $min_id, $max_id) {
        $data = array();
        for($i = $min_id; $i<=$max_id; ++$i) {
            $data[] = array('room_type' => $room_type, 'room_id' => $i);
        }
        $this->db->insert_batch('room', $data);
        return $this->db->affected_rows();
    }

    function add_room_sale($data) {
        $query = $this->db->join("room_type","room_type.room_type = room.room_type", "left")->get_where("room", array('room_id' => $data['room_id']));
        if(!$query || $query->num_rows() == 0) {
            return false;
        }
        $price = $query->result();
        $data['room_sales_price'] = $price[0]->room_price;
        $data['total_service_price'] = 0;
        $this->db->insert('room_sales', $data);
    }
}
