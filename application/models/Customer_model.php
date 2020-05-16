<?php

class Customer_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }
    

    /**
     * This function will fetch return the a specified customer from the customers table
     * @param array $data
     * @return mixed    Depending on available parameters it will either return an object or an array
     */
    function get_customer($data)
    {
        if (isset($data['id']) || isset($data['email']) || isset($data['username']) || isset($data['customer_id']) || isset($data['customer_TCno'])) 
        {
            $this->db->select('customer_id, customer_username, customer_firstname, customer_lastname, image, customer_TCno, customer_address, customer_state, customer_city, customer_country, customer_telephone,  customer_email')->from('customer');
        
            if (isset($data['username'])) 
            {
                $this->db->where('customer_username', $data['username']);
            }

            if (isset($data['email'])) 
            {
                $this->db->where('customer_email', $data['email']);
            }

            if (isset($data['id'])) 
            {
                $this->db->where('customer_id', $data['id']); 
                $this->db->or_where('customer_TCno', $data['id']);
            }

            if (isset($data['customer_id'])) 
            {
                $this->db->where('customer_id', $data['customer_id']); 
            }

            if (isset($data['customer_TCno'])) 
            { 
                $this->db->where('customer_TCno', $data['customer_TCno']);
            }

            $query = $this->db->get();
            return $query->row_array();
        }
        else
        {
            $query = $this->db->get_where('customer', array('customer_TCno' => $data)); 
        }

        if($query) {
            return $query->result();
        } else {
            return $query;
        }
    } 
    /**
     * This function will fetch return the a specified customer from the customers table
     * @param array $data
     * @return mixed    Depending on available parameters it will either return an object or an array
     */
    function purchases($data)
    { 
        $this->db->select('*')->from("sales_service_orders"); 

        if (isset($data['customer_id'])) 
        {
            $this->db->where('customer_id', $data['customer_id']); 
        }

        if (isset($data['employee_id'])) 
        { 
            $this->db->where('employee_id', $data['employee_id']);
        }

        if (isset($data['item_id'])) 
        { 
            $this->db->where('id', $data['item_id']);
        }
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get();

        if (isset($data['item_id'])) 
        { 
            return $query->row_array(); 
        }
        return $query->result_array(); 
    } 


    /**
     * This function will fetch return all available customers from the customer table
     * @param array $data
     * @return object    Returns a standard object
     */
    function list_customers($data = '')
    {
        $this->db->select('customer_id, customer_firstname, customer_lastname, customer_TCno, customer_address, customer_state, customer_city, customer_country, customer_telephone,  customer_email')->from('customer'); 
        $this->db->select("(SELECT SUM(`order_price`) FROM sales_service_orders WHERE `customer_id` = `customer`.`customer_id`) AS orders");
        $this->db->select("(SELECT SUM(`paid`) FROM sales_service_orders WHERE `customer_id` = `customer`.`customer_id`) AS paid");
        $this->db->select("(SELECT SUM(`orders`-`paid`)) AS debt");
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get(); 
        return $query->result();
    }


    /**
     * This function will add a new customer to the customer table
     * @param array $data
     * @return object    Returns a standard object
     */
    function add_customer($data)
    {
        if (isset($data['cid'])) 
        {
            $data['customer_id'] = $data['cid'];
            unset($data['cid']);

            $this->db->where('customer_id', $data['customer_id']);
            $this->db->update('customer', $data);
            return $this->db->affected_rows();
        }
        else
        {
            $this->db->insert('customer', $data);
            return $this->db->insert_id();
        }
    } 

    /**
     * This function will fetch return data of all active customers currently logged 
     * @return object    Returns a standard object
     */
    function get_active_customers()
    {
        $date = date('Y-m-d');  
        $this->db->select("*")->from("room_sales");
        $this->db->where("checkout_date >=", "$date");
        $this->db->where("checkin_date <=", "$date");
        $this->db->join("customer", "room_sales.customer_id=customer.customer_id");
        $q = $this->db->get(); 
        return $q->result();
    }


    /**
     * This function will delete the data of the specified customer from the customers table
     * @return integer    Returns the count of records updated by the query
     */
    function delete_customer($customer_id)
    {
        $this->db->delete('room_sales', array('customer_id' => $customer_id));
        $this->db->delete('reservation', array('customer_id' => $customer_id));
        $this->db->delete('customer', array('customer_id' => $customer_id));
        return $this->db->affected_rows();
    }


    /**
     * This function will update an items debt info
     * @return integer    Returns the count of records updated by the query
     */
    function update_debt($data)
    {
        $this->db->where("id", $data['item_id']);
        db_inc('paid',$data['amount']);
        $this->db->update('sales_service_orders'); 
        return $this->db->affected_rows();
    }

}
