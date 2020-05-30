<?php

class Report_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    } 

    function search_customers($query)
    {
        $query = trim($query);
        $this->db->select("*"); 
        $this->db->select("(SELECT SUM(`order_price`) FROM sales_service_orders WHERE `customer_id` = `customer`.`customer_id`) AS orders");
        $this->db->select("(SELECT SUM(`paid`) FROM sales_service_orders WHERE `customer_id` = `customer`.`customer_id`) AS paid");
        $this->db->select("(SELECT SUM(`orders`-`paid`)) AS debt");
        $query = $this->db->from("customer") 
            ->like('customer_TCno', $query)
            ->or_like('customer_email', $query)
            ->or_like('customer_state', $query)
            ->or_like("CONCAT_WS(' ', customer_firstname, customer_lastname)", $query) 
        ->get();
        $data = array();
        foreach ($query->result() as $res) {
            $data[] = $res;
        } 
        return $data;
    }

    function get_customer_freq_list() {
        $this->db->reconnect();
        $query = $this->db->select("any_value(customer.customer_firstname) AS customer_firstname, any_value(customer.customer_lastname) AS customer_lastname, any_value(customer.customer_TCno) AS customer_TCno, SUM( `room_sales_price` +  `total_service_price` ) as total_paid, COUNT(*) as checkin_count")
                ->from("room_sales")->join("customer", "customer.customer_id = room_sales.customer_id")
                ->group_by("room_sales.customer_id")->order_by('checkin_count','DESC')->order_by('total_paid','DESC')->get();
        $data = array();
        foreach ($query->result() as $res) {
            $data[] = $res;
        }
        return $data;
    }

    function get_max_paid_for_customer_most_paid() {
        $query = $this->db->query("
            SELECT MAX( total_paid ) AS max_paid
            FROM (                
                SELECT customer_id, SUM(  `room_sales_price` +  `total_service_price` ) AS total_paid
                FROM room_sales
                GROUP BY  `customer_id`
            ) AS SRS
        ");
        return $query->row();
    }

    function get_customer_most_paid() {
        $total_paid = $this->get_max_paid_for_customer_most_paid()->max_paid;

        $this->db->select("any_value(customer.customer_firstname) AS customer_firstname, any_value(customer.customer_lastname) AS customer_lastname, any_value(customer.customer_TCno) AS customer_TCno, COUNT(*) as checkin_count, SUM(  `room_sales_price` +  `total_service_price` ) as total_paid")->from("room_sales"); 
        $this->db->join("customer", "customer.customer_id = room_sales.customer_id");
        $this->db->group_by("room_sales.customer_id")->having("total_paid = '$total_paid'");
        $query = $this->db->get();
        
        $data = array();
        if ($query) {
            foreach ($query->result() as $res) {
                $data[] = $res;
            } 
        }
        return $data;
    }

    function get_next_week_freq() {
        $dates = array();
        $freq_counts = array();
        for($day = 1; $day<=7; ++$day) {
            $date = date("Y-m-d",strtotime("+$day day"));
            $query = $this->db->query("SELECT COUNT(*) as count FROM reservation WHERE checkin_date <= '$date' AND checkout_date >= '$date'");
            $row = $query->row_array(0);
            $dates[] = $date;
            $freq_counts[] = intval($row['count']);
        }
        return array('dates' => $dates, 'freq_counts' => $freq_counts);

    }
}
