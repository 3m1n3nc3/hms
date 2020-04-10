<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Datatables extends MY_Controller {
    public function index()
    {
        // $this->load->view('datatable');
    } 
    
    public function inventory($id = null)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            0=>'item_name',
            1=>'item_quantity', 
            2=>'item_price', 
            3=>'item_service', 
            4=>'item_add_date' 
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);   
        $content = $this->db->select('*')->get("sales_service_stock");
        $data = array();
        foreach($content->result() as $rows)
        {  

            $employee = $this->employee_model->getEmployee($rows->employee_id); 

            $data[]= array(  
                $rows->item_name, 
                $rows->item_quantity, 
                $this->cr_symbol.number_format($rows->item_price, 2), 
                $rows->item_service, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A', 
                $rows->item_add_date,  
                '<a href="'.site_url('services/add_inventory/'.$rows->item_id).'" class="btn btn-sm btn-primary m-1" data-toggle="tooltip" title="Edit">
                    <i class="btn-icon-only fa fa-edit text-white fa-fw"></i>
                </a>
                <a href="javascript:void" onclick="return confirmDelete(\''.site_url('services/delete_record/inventory/'.$rows->item_id).'\', 1)" class="btn btn-danger btn-sm m-1" data-toggle="tooltip" title="Delete">
                    <i class="btn-icon-only fa fa-trash text-white fa-fw"></i>
                </a>',
                20 => 'tr_'.$rows->item_id
            );     
        }
        $total_content = $this->total_inventory($id);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_inventory($id = null)
    {      
        $query = $this->db->select("COUNT(item_id) as num")->get("sales_service_stock");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
    
    public function sales_records($id = null)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            0=>'order_items',
            1=>'order_quantity', 
            2=>'order_price',  
            4=>'service_name', 
            5=>'employee_id', 
            6=>'ordered_datetime' 
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);   
        $content = $this->db->select('*')->get("sales_service_orders");
        $data = array();
        foreach($content->result() as $rows)
        {  
            $item_name = [];
            foreach (explode(',', $rows->order_items) as $sid) {
                $items = $this->CI->services_model->get_stock(array('item_id' => $sid));
                $item_name[] = $items['item_name'];
            }

            $employee = $this->employee_model->getEmployee($rows->employee_id); 
            $customer = $this->account_data->fetch($rows->customer_id ?? '', 1); 

            $data[]= array(  
                implode(', ', $item_name), 
                $rows->order_quantity, 
                $this->cr_symbol.number_format($rows->order_price, 2), 
                $customer['name'], 
                $rows->service_name, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A',
                $rows->ordered_datetime,  
                '<a href="javascript:void(0)" onclick="return confirmDelete(\''.site_url('services/delete_record/sales_records/'.$rows->id).'\', 1)" class="btn btn-danger btn-sm m-1" data-toggle="tooltip" title="Delete">
                    <i class="btn-icon-only fa fa-trash text-white fa-fw"></i>
                </a>',
                20 => 'tr_'.$rows->id
            );     
        }
        $total_content = $this->total_sales_records($id);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_sales_records($id = null)
    {      
        $query = $this->db->select("COUNT(id) as num")->get("sales_service_orders");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
    
    public function cashier_report($show_btn = TRUE)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(
            0=>'date',
            1=>'subject', 
            2=>'amount', 
            3=>'remark', 
            4=>'employee_id',  
            5=>'date_added',  
        );

        $get_query = $this->input->get(NULL, TRUE);
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('date <=', $get_query['to']);  
            } 
        }

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);   
        $content = $this->db->select('*')->get("expenses");
        $data = array();
        foreach($content->result() as $rows)
        {   
            $employee = $this->employee_model->getEmployee($rows->employee_id); 

            $data[]= array(  
                $rows->subject,  
                $rows->date, 
                $this->cr_symbol.number_format($rows->amount, 2), 
                $rows->remark, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A',
                $rows->date_added,  
                $show_btn ? 
                    '<a href="'.site_url('accounting/cashier/expenses_register/'.$rows->id).'" class="btn btn-sm btn-primary m-1" data-toggle="tooltip" title="Edit">
                        <i class="btn-icon-only fa fa-edit text-white fa-fw"></i>
                    </a>
                    <a href="javascript:void(0)" onclick="return confirmDelete(\''.site_url('accounting/cashier/delete_expenses/'.$rows->id).'\', 1)" class="btn btn-danger btn-sm m-1" data-toggle="tooltip" title="Delete">
                        <i class="btn-icon-only fa fa-trash text-white fa-fw"></i>
                    </a>'
                : '',
                20 => 'tr_'.$rows->id
            );     
        }
        $total_content = $this->total_cashier_report($get_query);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_cashier_report($get_query)
    {       
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('date <=', $get_query['to']);  
            } 
        }

        $query = $this->db->select("COUNT(id) as num")->get("expenses");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
    
    public function payment_report($show_btn = TRUE)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(  
            0=>'customer_id', 
            1=>'amount', 
            2=>'reference', 
            3=>'description',  
            4=>'date',  
        );

        $get_query = $this->input->get(NULL, TRUE);
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('date <=', $get_query['to']);  
            } 
        }

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);   
        $content = $this->db->select('*')->get("payments");
        $data = array();
        foreach($content->result() as $rows)
        {   
            $customer = $this->account_data->fetch($rows->customer_id, 1); 

            $data[]= array(  
                $customer['name'], 
                $this->cr_symbol.number_format($rows->amount, 2), 
                $rows->reference, 
                $rows->description,  
                $rows->date, 
                $show_btn ?  '
                    <a href="javascript:void(0)" onclick="return confirmDelete(\''.site_url('accounting/cashier/delete_payment/'.$rows->id).'\', 1)" class="btn btn-danger btn-sm m-1" data-toggle="tooltip" title="Delete">
                        <i class="btn-icon-only fa fa-trash fa-fw text-white"></i>
                    </a>'
                : '',
                20 => 'tr_'.$rows->id
            );     
        }
        $total_content = $this->total_payment_report($get_query);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_payment_report($get_query)
    {       
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('date <=', $get_query['to']);  
            } 
        }

        $query = $this->db->select("COUNT(id) as num")->get("payments");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
    
    public function room_sales_report($show_btn = TRUE)
    {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }

        $valid_columns = array(  
            0=>'customer_id', 
            2=>'room_id', 
            1=>'room_sales_price', 
            3=>'reservation_ref',  
            4=>'reservation_date',  
        );

        $get_query = $this->input->get(NULL, TRUE);
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('reservation_date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('reservation_date <=', $get_query['to']);  
            } 
        }

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }

        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);   
        $this->db->select('room_sales.customer_id, room_sales.reservation_id, room_sales.room_id, room_sales_price, reservation_ref, reservation_date');
        $content = $this->db->join('reservation', 'room_sales.reservation_id = reservation.reservation_id', 'LEFT')->get("room_sales");
        $data = array();
        foreach($content->result() as $rows)
        {   
            $customer = $this->account_data->fetch($rows->customer_id, 1); 
            $room = $this->room_model->getRoom(['id' => $rows->room_id]);

            $data[]= array(   
                '<a href="'.site_url('customer/data/'.$rows->customer_id.'').'">
                    '.$customer['name'].'
                </a>', 
                '<a href="'.site_url('room/reserved_room/'.$rows->room_id.'/'.$rows->customer_id.'').'">
                    '.$room['room_type'] . ' ' . lang('room') .' ' . $rows->room_id.'
                </a>',  
                $this->cr_symbol.number_format($rows->room_sales_price, 2), 
                $rows->reservation_ref,  
                $rows->reservation_date, 
                $show_btn ?  '
                    <a href="javascript:void(0)" onclick="return confirmDelete(\''.site_url('accounting/cashier/delete_room_sale/'.$rows->reservation_id).'\', 1)" class="btn btn-danger btn-sm m-1" data-toggle="tooltip" title="Delete">
                        <i class="btn-icon-only fa fa-trash fa-fw text-white"></i>
                    </a>'
                : '',
                20 => 'tr_'.$rows->reservation_id
            );     
        }
        $total_content = $this->total_room_sales_report($get_query);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_room_sales_report($get_query)
    {       
        if ($get_query) 
        {
            if (isset($get_query['from'])) 
            {
                $this->db->where('reservation_date >=', $get_query['from']);  
            } 
            
            if (isset($get_query['to'])) 
            {
                $this->db->where('reservation_date <=', $get_query['to']);  
            } 
        }

        $this->db->select("COUNT(room_sales.reservation_id) as num");
        $query = $this->db->join('reservation', 'room_sales.reservation_id = reservation.reservation_id', 'LEFT')->get("room_sales");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
}
