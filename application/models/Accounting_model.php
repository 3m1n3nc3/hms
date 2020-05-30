<?php

class Accounting_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    } 

    function addExpense($data = array())
    { 
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('expenses', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('expenses', $data);
            return $this->db->insert_id();
        }
    } 

    function get_expense($data = array())
    {   
        $x_query = 'WHERE 1=1'; 
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']); 
            $x_query .= " AND id = '{$data['id']}'";
        }
        
        if (isset($data['employee_id'])) 
        {
            $this->db->where('employee_id', $data['employee_id']); 
            $x_query .= " AND employee_id = '{$data['employee_id']}'";
        } 
        
        if (isset($data['from'])) 
        {
            $this->db->where('date >=', $data['from']); 
            $x_query .= " AND date >= '{$data['from']}'";
        } 
        
        if (isset($data['to'])) 
        {
            $this->db->where('date <=', $data['to']); 
            $x_query .= " AND date <= '{$data['to']}'";
        } 
        
        $this->db->select('*')->from('expenses');
        $this->db->select('
            (SELECT SUM(amount) FROM expenses '.$x_query.') AS total,
            (SELECT COUNT(id) FROM expenses '.$x_query.') AS entries');

        $this->db->order_by('date');
         
        if (isset($data['page'])) {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $query = $this->db->get();
        if (isset($data['id']))
        {
            return $query->row_array();
        }
        else
        { 
            return $query->result_array(); 
        }
    }

    function delete_expense($id = array())
    {   
        $this->db->where('id', $id); 
        $this->db->delete('expenses'); 
        return $this->db->affected_rows(); 
    } 

    function min_max($min_max = 0)
    {   
        $order = $min_max ? 'DESC' : 'ASC';
        $this->db->limit('1'); 
        $this->db->order_by('date '.$order); 
        $query = $this->db->select('date')->from('expenses')->get();
        return $query->row_array()['date'];
    } 

    /**
     * This function will return the the usage and functionality statistics of the site 
     * for the specific customer
     * @param array $data
     * @return mixed
     */
    function statistics($data = null)
    {   
        if (isset($data)) 
        { 
            if (isset($data['service'])) 
            { 
                $query = $this->db->select('(SELECT SUM(order_price) FROM sales_service_orders WHERE service_name = \''.$data['service'].'\') AS sales')->get();
            } 

            if (isset($data['customer'])) 
            { 
                $query = $this->db->select(
                    '(SELECT COALESCE(SUM(amount), 0) FROM payments WHERE customer_id = \''.$data['customer'].'\') AS payments, 
                    (SELECT COALESCE(SUM(order_price), 0) FROM sales_service_orders WHERE customer_id = \''.$data['customer'].'\') AS service_orders,
                    (SELECT COUNT(customer_id) FROM room_sales WHERE customer_id = \''.$data['customer'].'\') AS checkins,
                    (SELECT COALESCE(SUM(room_sales_price), 0) FROM room_sales WHERE customer_id = \''.$data['customer'].'\') AS room_sales,
                    (SELECT COALESCE(SUM(GREATEST(room_type.room_price, 0)), 0) FROM reservation JOIN room ON room.room_id = reservation.room_id JOIN room_type ON room_type.room_type = room.room_type  WHERE checkout_date < CURDATE() AND checkin_date < CURDATE() AND status = 1 AND customer_id = \''.$data['customer'].'\') AS pre_overstay_debt,
                    (SELECT COALESCE(SUM(DATEDIFF(CURDATE(), reservation.checkout_date)), 0) FROM reservation WHERE checkout_date < CURDATE() AND checkin_date < CURDATE() AND status = 1 AND customer_id = \''.$data['customer'].'\') AS overstay_days,
                    (SELECT COALESCE(SUM(room_sales_price), 0) FROM room_sales WHERE reservation_id !=NULL AND reservation_id NOT IN (
                        SELECT reservation.reservation_id FROM reservation JOIN payments ON reservation.reservation_ref = payments.reference
                        WHERE room_sales.customer_id = \''.$data['customer'].'\'
                    )) AS customer_room_sales,
                    (SELECT COALESCE(SUM(`paid`), 0) FROM sales_service_orders WHERE `customer_id` = \''.$data['customer'].'\') AS paid,
                    (SELECT SUM(`service_orders`-`paid`)) AS service_debt,
                    (SELECT pre_overstay_debt * overstay_days) AS overstay_debt,
                    (SELECT SUM(`service_debt`+`overstay_debt`)) AS debt,
                    (SELECT SUM(payments+service_orders+customer_room_sales)) AS total_expenses, 
                    (SELECT SUM(total_expenses-service_debt)) AS expenses,  
                    '.$data['customer'].' AS customer_id'
                )->get();
            } 
        }
        else
        {
            $query = $this->db->select('(SELECT SUM(amount) FROM payments) AS payments, (SELECT SUM(order_price) FROM sales_service_orders) AS sales, (SELECT SUM(room_sales_price) FROM room_sales) AS room_sales, (SELECT COUNT(customer_id) FROM customer) AS customers')->get();
        } 
        return $query->row_array();
    } 

    function sumOrderQty($year = null)
    {  
        if (!empty($year)) 
        {
            $this->db->where('YEAR(order_date)', $year);
        }
        $query = $this->db->select('order_quantity')
        ->get("sales_service_orders")
        ->result_array(); 
        $total = 0;
        foreach ($query as $data) {
            $exp    = explode(',',$data['order_quantity']);
            $total += array_sum($exp);
        }
        return $total; 
    }
    /**
     * This function will return the the usage and functionality statistics of the site 
     * @param array $data
     * @return mixed
     */
    function site_statistics($data = array(), $row = FALSE)
    { 
        $getOrderQty = $this->sumOrderQty($data['year']??null);

        if (isset($data['monthly'])) 
        {
            $where  = $swhere = $owhere = $rwhere = "WHERE 1";  

            if (!empty($data['year'])) 
            {
                $this->db->where('YEAR(date)', $data['year']);
                $where  .= " AND YEAR(date) = {$data['year']}";
                $swhere .= " AND YEAR(item_add_date) = {$data['year']}";
                $owhere .= " AND YEAR(order_date) = {$data['year']}";
                $rwhere .= " AND YEAR(reservation_date) = {$data['year']}";
            }
            $query = $this->db->select('MONTH(date) month, SUM(amount) amount') 
            ->select("(SELECT DATE(MIN(date)) FROM payments $where) fr") 
            ->select("(SELECT DATE(MAX(date)) FROM payments $where) `to`") 
            ->select("(SELECT SUM(item_quantity) FROM sales_service_stock $swhere) stock") 
            ->select("(SELECT $getOrderQty) stock_orders") 
            ->select("(SELECT COUNT(room_id) FROM room) rooms") 
            ->select("(SELECT COUNT(reservation_id) FROM reservation $rwhere) reservation") 
            ->select("(SELECT SUM(stock+rooms)) goal") 
            ->select("(SELECT SUM(stock_orders+reservation)) goal_complete") 
            ->order_by("month ASC") 
            ->group_by('month')->from('payments')->get();

            if ($row) {
                return $query->row_array();
            }

            return $query->result_array();
        } 

        return $this->db->select(
            '(SELECT COALESCE(SUM(amount), 0) FROM payments) AS payments, 
            (SELECT COALESCE(SUM(item_price), 0)*COALESCE(SUM(item_quantity), 0) FROM sales_service_stock) AS service_stock,
            (SELECT COALESCE(SUM(order_price), 0) FROM sales_service_orders) AS service_orders,
            (SELECT COUNT(customer_id) FROM room_sales) AS checkins,
            (SELECT COALESCE(SUM(room_sales_price), 0) FROM room_sales) AS room_sales,
            (SELECT COALESCE(SUM(GREATEST(room_type.room_price, 0)), 0) FROM reservation JOIN room ON room.room_id = reservation.room_id JOIN room_type ON room_type.room_type = room.room_type  WHERE checkout_date < CURDATE() AND checkin_date < CURDATE() AND status = 1
            ) AS pre_overstay_debt,
            (SELECT COALESCE(SUM(DATEDIFF(CURDATE(), reservation.checkout_date)), 0) FROM reservation WHERE checkout_date < CURDATE() AND checkin_date < CURDATE() AND status = 1
            ) AS overstay_days,
            (SELECT COALESCE(SUM(room_sales_price), 0) FROM room_sales WHERE reservation_id !=NULL AND reservation_id NOT IN (
                SELECT reservation.reservation_id FROM reservation JOIN payments ON reservation.reservation_ref = payments.reference)
            ) AS customer_room_sales,
            (SELECT COALESCE(SUM(amount), 0) FROM expenses) AS expenses,
            (SELECT COALESCE(SUM(`paid`), 0) FROM sales_service_orders) AS paid,
            (SELECT SUM(`service_orders`-`paid`)) AS service_debt,
            (SELECT pre_overstay_debt * overstay_days) AS overstay_debt,
            (SELECT SUM(`service_debt`+`overstay_debt`)) AS debt,
            (SELECT SUM(payments+service_orders+customer_room_sales)) AS revenue, 
            (SELECT SUM(revenue-debt)) AS profit,
            (SELECT SUM(expenses+service_stock)) AS cost,
            (SELECT SUM(revenue+cost)) AS total_revenue, 
            (SELECT profit-cost) AS total_profit'
        )->get()->row_array();  
    } 

    /**
     * This function will return the the usage and functionality statistics of the site 
     * @param array $data
     * @return mixed
     */
    function customer_report_dates($data = null)
    {  
        $x_query = 'WHERE 1'; 
        if (isset($data['customer_id'])) 
        { 
            $x_query .= " AND customer_id = '{$data['customer_id']}'";
        } 
        // $x_query = $this->db->escape_like_str($x_query);

        $query = $this->db->query(
        "SELECT MAX(max_date) as max_date, MIN(min_date) as min_date FROM
        (
            SELECT MAX(reservation_date) as max_date, MIN(reservation_date) as min_date 
                FROM reservation $x_query UNION ALL
            SELECT MAX(ordered_datetime) as max_date, MIN(ordered_datetime) as min_date 
                FROM sales_service_orders $x_query UNION ALL
            SELECT MAX(`date`) as max_date, MIN(`date`) as min_date 
                FROM payments $x_query
        ) as subQuery");

        return $query->row_array();
    }
}
