<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends Admin_Controller { 


    /**
     * This methods lists all the available services 
     * @return null                 Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{
        error_redirect(has_privilege('sales-services'), '401');

		$services = $this->services_model->get_service();
		$customers = $this->customer_model->get_active_customers();  

		$viewdata = array('services' => $services, 'customers' => $customers);

		$data = array('title' => 'Sales Services - ' . my_config('site_name'), 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods lists all room sales records
     * @param string 	$set_service 	The service with the records to list
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function sales_records($set_service = '')
	{  
        error_redirect(has_privilege('sales-records'), '401');

		$services = $this->services_model->get_service();
		$customers = $this->customer_model->get_active_customers(); 

		$config['base_url']   = site_url('services/inventory/');
        $config['total_rows'] = count($this->services_model->get_stock()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment($set_service ? 3 : 4, 0);

		$inventory = $this->services_model->get_stock(['page' => $_page]);

		$viewdata = array(
			'inventory' => $inventory, 
			'services' => $services, 
			'customers' => $customers, 
			'use_table' => TRUE, 
			'table_method' => 'sales_records'
		);  
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Sales Records - ' . my_config('site_name'), 'page' => 'sales-records');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/sales_records',$viewdata);
		$this->load->view($this->h_theme.'/footer', $viewdata);
	}


    /**
     * This methods lists all inventory records
     * @param string 	$set_service 	The service with the records to list
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function inventory($set_service = '')
	{
        error_redirect(has_privilege('inventory'), '401');

		$inventory = $this->services_model->get_stock();  

		$config['base_url']   = site_url('services/inventory/');
        $config['total_rows'] = count($this->services_model->get_stock()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment($set_service ? 3 : 4, 0);

		$inventory = $this->services_model->get_stock(['page' => $_page]);

		$viewdata = array('inventory' => $inventory, 'use_table' => TRUE, 'table_method' => 'inventory');  
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Inventory - ' . my_config('site_name'), 'page' => 'inventory');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/inventory',$viewdata);
		$this->load->view($this->h_theme.'/footer', $viewdata);
	}


    /**
     * This methods allows for adding or updating new items to the inventory
     * @param string 	$set_item_id 	The Id of the item to edit if updating
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function add_inventory($set_item_id = '')
	{
        error_redirect(has_privilege('inventory'), '401');

		$services = $this->services_model->get_service();
		$inventory_item = $this->services_model->get_stock(['item_id' => $set_item_id]);  

		if($this->input->post("item_name"))
		{
			$item_name = $this->input->post("item_name");
			$item_details = $this->input->post("item_details");
			$item_quantity = $this->input->post("item_quantity");
			$item_price = $this->input->post("item_price");
			$item_service = $this->input->post("item_service");
	        
	        $save = array(
	            'item_name' => $item_name,
	            'item_details' => $item_details,
	            'item_quantity' => $item_quantity,
	            'item_price' => $item_price,
	            'item_service' => $item_service,
		        'employee_id' => $this->uid,
	            'item_add_date' => date('Y-m-d H:m:s')
	        );
	        if ($set_item_id) 
	        {
	        	$save['item_id'] = $set_item_id;
	        }
				
			$this->services_model->add_stock($save);
			$mit = $inventory_item ? 'updated' : 'added';
			$this->session->set_flashdata('message', alert_notice('Inventory Item '.$mit, 'success')); 
			redirect("services/inventory");
		}

		$tl = $inventory_item ? 'Update' : '';
		$viewdata = array(
			'services' => $services, 
			'item_id' => $set_item_id, 
			'inventory' => $inventory_item, 
			'tl' => $tl
		);  

		$data = array('title' => $tl.' Inventory - ' . my_config('site_name'), 'page' => 'inventory');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/add_inventory', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods allows for adding new sales services (Department) 
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function add()
	{
        error_redirect(has_privilege('sales-services'), '401');

		if($this->input->post("ServiceName"))
		{
			$service_name = $this->input->post("ServiceName");
			$service_open_time = $this->input->post("ServiceOpenTime");
			$service_close_time = $this->input->post("ServiceCloseTime");
			$service_details = $this->input->post("ServiceDetails");
			$table_count = $this->input->post("tableCount");
	        
	        $save = array(
	            'service_name' => $service_name,
	            'service_open_time' => $service_open_time,
	            'service_close_time' => $service_close_time,
	            'service_details' => $service_details,
	            'table_count' => $table_count
	        );
				
			$this->services_model->addService($save);
			$this->session->set_flashdata('message', alert_notice('New Sales Service added', 'success')); 
			redirect("services");
		}

		$data = array('title' => 'Add Service - ' . my_config('site_name'), 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/add');
		$this->load->view($this->h_theme.'/footer');
	}


    /**
     * This methods allows for selling services 
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function sale()
	{
        error_redirect(has_privilege('service-point') || has_privilege('inventory') || has_privilege('sales-services') || service_point_access_session(TRUE), '401');

		$post = $this->input->post();

		if(!$this->input->post("stock_item"))
		{
			$this->session->set_flashdata('message', alert_notice(' Order not placed, No items where selected', 'error')); 
		}
		else
		{ 
			$items_array = $this->input->post('stock_item');
			$items = implode(',', $items_array);

			$quantity_array = $this->input->post('stock_qty');
			$quantity = implode(',', $quantity_array);

			$stock_item_name = $this->input->post('stock_item_name');

			$errors = []; $sum_qty = 0;
	        foreach ($items_array as $key => $sid) 
	        {
	            $res = $this->CI->services_model->get_stock(array('item_id' => $sid)); 

	            if ($res)
            	{	
            		$real_quantity = ($quantity_array ? $quantity_array[$key] : 1);

            		if ($real_quantity == 0) 
            		{
            			$errors[] .= 'You can\'t make a request for 0 '.$stock_item_name[$key];
            		}
            		elseif ($res['item_quantity'] < $real_quantity) 
	            	{
	            		$errors[] .= 'There are less than '.$real_quantity.' '.$stock_item_name[$key].' in stock';
	            	} 

            		$sum_qty += $real_quantity;
            	}
	            else
	            {
            		$errors[] .= $stock_item_name[$key].' is no longer available in stock';
            	}
	        }

	        if (empty($errors)) { 
		        $save = array(
		            'service_name' => $post['service'],
		            'customer_id' => $post['customer'],
		            'order_items' => $items,
		            'order_quantity' => $quantity,
		            'order_price' => $post['price'],
		            'order_date' => $post['date'],
		            'employee_id' => $this->uid,
		            'ordered_datetime' => date('Y-m-d H:m:s')
		        );

				$this->hms_parser->update_stock($items_array, $quantity_array);
				$this->services_model->order_service($save);
				$this->session->set_flashdata('message', alert_notice($sum_qty.' Items Sold', 'success'));
			}
			else
			{ 
				for ($i = 0; $i < count($errors); $i++) {
					$this->session->set_flashdata('message', alert_notice($errors[$i], 'error')); 
				}

			}
		} 
		redirect("services");
	}


    /**
     * Delete a service
     * @param string 	$service_name 	The service with the records to delete
     * @return null                 	redirect to services
     */
	function delete($service_name)
	{
        error_redirect(has_privilege('sales-services'), '401');

		$service_name = urldecode($service_name);
		$this->session->set_flashdata('message', alert_notice('Sales Service Item deleted', 'success')); 
		$this->services_model->deleteService($service_name);
		redirect("services");
	}


    /**
     * Delete a service record
     * @param string 	$type 	The type of service record to delete {inventory} or {sales_records} item
     * @param string 	$item 	The id of the service record to delete  
     * @return null             Redirect to service/inventory or services/sales_records methods
     */
	function delete_record($type = '', $item = '')
	{
        error_redirect(has_privilege('inventory'), '401');
 		if ($type === 'inventory') 
 		{
			$this->session->set_flashdata('message', alert_notice('Inventory Item deleted', 'success')); 
			$this->services_model->delete_stock(['item_id' => $item]);
			redirect("services/inventory");
 		}
 		elseif ($type === 'sales_records') 
 		{
			$this->session->set_flashdata('message', alert_notice('Sales record deleted', 'success')); 
			$this->services_model->delete_order(['id' => $item]);
			redirect("services/sales_records");
 		}
	}


    /**
     * This methods allows for editing services 
     * @param string	$get_service_name	The name of the service to edit 
     * @return null                 		Does not return anything but uses code igniter's view() method to render the page
     */
	public function edit($get_service_name)
	{
        error_redirect(has_privilege('sales-services'), '401');

		$get_service_name = urldecode($get_service_name);
		if($this->input->post("serviceName"))
		{
			$service_name = $this->input->post("serviceName");
			$service_open_time = $this->input->post("ServiceOpenTime");
			$service_close_time = $this->input->post("ServiceCloseTime");
			$service_details = $this->input->post("ServiceDetails");
			$table_count = $this->input->post("tableCount");
	        
	        $save = array(
	            'service_id' => $get_service_name, 
	            'service_name' => $service_name, 
	            'service_open_time' => $service_open_time, 
	            'service_close_time' => $service_close_time, 
	            'service_details' => $service_details, 
	            'table_count' => $table_count
	        ); 
			
			$this->services_model->AddService($save);
			redirect("services");
		}
		$data = array('title' => 'Edit Sales Service - ' . my_config('site_name'), 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$service = $this->services_model->getService($get_service_name); 
		$viewdata = array('service'  => $service[0]);
		$this->load->view($this->h_theme.'/services/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer'); 
	}


    /**
     * This methods lists service stocks for sale
     * @param string	$service	The name of the service with stock to edit 
     * @return null     			Does not return anything but echoes a JSON Object with a response
     */
	public function list_stock($service = "")
	{         
		$get_service_name = urldecode($service);
		$stock_list = $this->services_model->get_stock(['item_service' => $get_service_name]);

		$stock_item_array = array();
		$av_qty = 0;

		if ($stock_list) 
		{ 
			foreach ($stock_list as $stock_item) 
			{ 
				$av_qty += $stock_item['item_quantity'];

				if ($stock_item['item_quantity'] > 0) 
				{ 
					$stock_item_array[] = '
					<input type="hidden" name="stock_item_name[]" value="'.$stock_item['item_name'].'">
					<input type="hidden" id="mult_'.$stock_item['item_id'].'" value="1">
					<input type="hidden" id="prev_'.$stock_item['item_id'].'" value="1">
					<div class="col-4">
						<div class="info-box">
							<span class="info-box-icon bg-danger"><i class="fas fa-utensils"></i></span>
							<div class="info-box-content">
								<div class="form-group clearfix info-box-text">
									<div class="icheck-primary d-inline">
										<input type="checkbox" id="'.$stock_item['item_name'].'" name="stock_item[]" value="'.$stock_item['item_id'].'" data-price="'.$stock_item['item_price'].'" data-id="'.$stock_item['item_id'].'" onchange="update_price(this, '.$stock_item['item_price'].')">
										<label for="'.$stock_item['item_name'].'">
											'.$stock_item['item_name'].'
										</label>
									</div>  
								</div> 
								<span class="info-box-number" id="price_'.$stock_item['item_name'].'">
									'.$stock_item['item_price'].'
								</span>
							</div> 
						</div> 
						<div class="form-group row">
							<label for="qty_'.$stock_item['item_name'].'" class="col-sm-2 col-form-label">
								Qty
							</label>
							<input type="number" min="1" max="'.$stock_item['item_quantity'].'" data-name="'.$stock_item['item_name'].'" id="qty_'.$stock_item['item_id'].'" name="stock_qty[]" class="form-control form-control-sm col-sm-3" value="1" onkeyup="price_calculator(this, '.$stock_item['item_price'].')" onchange="price_calculator(this, '.$stock_item['item_price'].')">
							<label class="text-info ml-2"> '.$stock_item['item_quantity'].' Available</label>
						</div> 
					</div>';
				} 
			} 
		}
		
		if ($av_qty < 1) 
			{
			$stock_item_array[] = '<div class="col-12">'.alert_notice('This store has no items on stock', 'error', FALSE, FALSE).'</div>';
		}
		
		$script = '
		<script> 
			$(\'input[name="stock_qty[]"]\').change(function() {
				var quantity = $(this).val();
			});
		</script>';

		$stock_item = implode('', $stock_item_array);
		if (has_privilege('inventory') || has_privilege('service-point') || has_privilege('sales-services') || service_point_access_session(TRUE)) 
		{
			$stock_item_blocks = array_merge($stock_list, array('stock_item' => $stock_item.$script));
		}
		else
		{
			$stock_item_blocks = array_merge([], array('stock_item' => 'Error 401: Access Denied'.$script));
		}
		echo json_encode($stock_item_blocks, JSON_FORCE_OBJECT); 
	}
} 
