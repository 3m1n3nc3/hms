<?php

class Payment_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    } 

    /**
     * This function takes the data array as a parameter and will fetch the specified record.
     * If the data array is not provided, then it will fetch all the records form the table.
     * @param array $data
     * @param bool  $row
     * @return array
     */
    public function get_payments($data = null, $row = false) 
    { 
        $x_query = " WHERE 1";
        
        if (isset($data['reference']))
        {
            $this->db->where('reference', $data['reference']); 
            $x_query .= " AND reference = '{$data['reference']}'";
        } 

        if (isset($data['ref_reservation']))
        {
            $this->db->group_start()
                ->where('reference', $data['ref_reservation'])
                ->or_where('reservation_id', $data['ref_reservation'])
            ->group_end(); 

            $x_query .= " AND (`reference` = '{$data['ref_reservation']}' OR `reservation_id` = '{$data['ref_reservation']}')";

        } 

        if (isset($data['customer_id']))
        {
            $this->db->where('payments.customer_id', $data['customer_id']); 
            $x_query .= " AND payments.customer_id = '{$data['customer_id']}'";
        }  

        if (isset($data['id']))
        {
            $this->db->where('id', $data['id']); 
            $x_query .= " AND id = '{$data['id']}'";
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
        
        if (isset($data['type']) && $data['type'] != 'admin_room_sale' && $data['type'] !== 'ALL')
        { 
            $join_table     = $payment_type = $data['type']['type'];
            $join_col       = $data['type']['col'];
            $join_table_col = $data['type']['t_col']; 
        } 
        else
        {
            $join_table       = $payment_type = ($data['type']??'') !== 'ALL' ? 'reservation' : '';
            if (isset($data['type']) && $data['type'] == 'admin_room_sale') {
                $payment_type = 'admin_room_sale';
            }
            $join_col         = 'reference';
            $join_table_col   = 'reservation_ref';

        }
            
        if (!isset($data['type'])) $this->db->group_start(); 

        if ($payment_type) {
            $this->db->where('payment_type', $payment_type);
        }

        if (!isset($data['type'])) $this->db->or_where('payment_type', 'admin_room_sale');

        if (!isset($data['type'])) $this->db->group_end(); 

        $this->db->select('*')->from('payments');
        $this->db->select("CONCAT_WS(' ', customer_firstname, customer_lastname) AS customer_name");
        $this->db->select('
            (SELECT SUM(amount) FROM payments '.$x_query.') AS total,
            (SELECT COUNT(id) FROM payments '.$x_query.') AS entries');


        if (!isset($data['type']) || $data['type'] !== 'ALL')
        { 
            if (!empty($join_table)) 
            {
                $this->db->join($join_table, "{$join_table}.{$join_table_col} = payments.{$join_col}");
            }
        }
        $this->db->join('customer', "customer.customer_id = payments.customer_id"); 

        if (isset($data['page'])) 
        {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $this->db->order_by('payments.date');

        $query = $this->db->get();

        if (isset($data['id']) || isset($data['reference']) || isset($data['ref_reservation']) || $row === TRUE) 
        {
            return $query->row_array();
        } 
        else 
        {
            return $query->result_array();
        }
    }

    /**
     * This function takes the data array as a parameter and will fetch the specified record.
     * If the data array is not provided, then it will fetch all the records form the table.
     * @param array     $data   [am_prop] The Amount field from the payments table
     *                          [pd_prop] The Paid field from the payments table
     *                          [payment_id] Id of the payment on the payments table whose debt is being paid
     *                          [table] Name of table whose debt is being paid
     *                          [id] Id of the debt payment record 
     * @return array
     */
    public function get_debt_payments($data = null) 
    {  
        $total_amount  = '';
        $id_prop       = $data['id_prop'] ?? 'id'; //The ID field from the payments table
        $amount_prop   = $data['am_prop'] ?? 'amount'; //The Amount field from the payments table
        $paid_prop     = $data['pd_prop'] ?? 'paid'; //The Paid field from the payments table
        $name_prop     = $data['nm_prop'] ?? 'service_name'; //Field that specifies the item name from the payments table
        
        if (isset($data['id'])) 
        {
            $this->db->where('debt_payments.id', $data['id']);  
        }

        if (isset($data['payment_id'])) 
        {
            $this->db->where('payment_id', $data['payment_id']);  
        }

        if (isset($data['payment_ids'])) 
        {
            $this->db->where('payment_ids', $data['payment_ids']);  
        }

        if (isset($data['table'])) 
        {
            $this->db->where('payment_table', $data['table']);
            $table = $data['table'];
            $total_amount = " ,{$table}.{$amount_prop} AS total_cost, {$table}.{$name_prop} AS item_name, {$table}.{$paid_prop} AS total_paid, {$table}.customer_id, CONCAT_WS(' ', customer.customer_firstname, customer.customer_lastname) AS customer_name, customer.customer_address, (SELECT total_cost-{$paid_prop}) AS balance"; 
        }

        $this->db->select("debt_payments.*$total_amount")->from('debt_payments'); 

        if (isset($data['table'])) 
        {
            $this->db->join($table, "{$table}.{$id_prop} = debt_payments.payment_id"); 
            $this->db->join('customer', "customer.customer_id = {$table}.customer_id"); 
        }  
         
        if (isset($data['page'])) 
        {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        $this->db->order_by('debt_payments.id');

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

    function min_max($min_max = 0)
    {   
        $order = $min_max ? 'DESC' : 'ASC';
        $this->db->limit('1'); 
        $this->db->order_by('date '.$order); 
        $query = $this->db->select('date')->from('payments')->get();
        return $query->row_array()['date'];
    } 


    /**
     * This function takes id as a parameter and will count the specified record.
     * If id is not provided, then it will fetch all the records form the table.
     * @param integer $id 
     * @return array
     */
    public function count_payment($id = null) 
    {
        $this->db->select('COUNT(id) AS sold, SUM(amount) AS total')->from('payments');
        if ($id != null) 
        {
            $this->db->where('product_id', $id); 
        }

        $query = $this->db->get();
        return $query->row_array();
    }


    /**
     * This function takes the data array as a parameter and will delete the specified record. 
     * @param array $data 
     * @return array
     */
    public function remove_payments($data) 
    {
        if (isset($data['customer_id'])) 
        {
            $this->db->where('customer_id', $data['customer_id']);
        } 
        else 
        {
            $this->db->where('id', $data);
        }
        $this->db->delete('payments');
        return $this->db->affected_rows();
    } 


    /**
     * This function takes the data array as a parameter and will update the specified record.
     * If the data array is not provided, then it will insert a new record.
     * @param array $data
     * @param bool  $row
     * @return array
     */
    public function add_payments($data) 
    {
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('payments', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('payments', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }  

    
    /**
     * This function takes the data array as a parameter and will update the specified record.
     * If the data array is not provided, then it will insert a new record.
     * @param array $data
     * @param bool  $row
     * @return array
     */
    public function add_debt_payment($data)
    {
        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);
            $this->db->update('debt_payments', $data);
            return $this->db->affected_rows();
        } 
        else 
        {
            $this->db->insert('debt_payments', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }
}
