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
                $rows->item_price, 
                $rows->item_service, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A', 
                $rows->item_add_date,  
                '<a href="'.site_url('services/add_inventory/'.$rows->item_id).'" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                    <i class="btn-icon-only fa fa-edit text-white"></i>
                </a>
                <a href="'.site_url('services/delete_inventory/'.$rows->item_id).'" onclick="return confirm(\'Are you sure ?\')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                    <i class="btn-icon-only fa fa-trash text-white"></i>
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
            3=>'service_name', 
            4=>'employee_id', 
            5=>'ordered_datetime' 
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

            $data[]= array(  
                implode(', ', $item_name), 
                $rows->order_quantity, 
                $rows->order_price, 
                $rows->service_name, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A',
                $rows->ordered_datetime,  
                '<a href="'.site_url('services/add_inventory/'.$rows->id).'" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                    <i class="btn-icon-only fa fa-edit text-white"></i>
                </a>
                <a href="'.site_url('services/delete_inventory/'.$rows->id).'" onclick="return confirm(\'Are you sure ?\')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                    <i class="btn-icon-only fa fa-trash text-white"></i>
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
    
    public function cashier_report($filter = null, $show_btn = TRUE)
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
                $rows->amount, 
                $rows->remark, 
                $employee ? $employee[0]->employee_firstname . ' ' . $employee[0]->employee_lastname : 'N/A',
                $rows->date_added,  
                $show_btn ? 
                    '<a href="'.site_url('accounting/cashier/expenses_register/'.$rows->id).'" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
                        <i class="btn-icon-only fa fa-edit text-white"></i>
                    </a>
                    <a href="'.site_url('accounting/cashier/delete_expenses/'.$rows->id).'" onclick="return confirm(\'Are you sure ?\')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete">
                        <i class="btn-icon-only fa fa-trash text-white"></i>
                    </a>'
                : '',
                20 => 'tr_'.$rows->id
            );     
        }
        $total_content = $this->total_cashier_report($filter);
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_content,
            "recordsFiltered" => $total_content,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function total_cashier_report($filter = null)
    {      
        $query = $this->db->select("COUNT(id) as num")->get("expenses");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }
}
