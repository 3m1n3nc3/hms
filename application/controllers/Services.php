<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends Admin_Controller { 

	public function index()
	{
		$services = $this->services_model->get_restaurants();
		$customers = $this->customer_model->get_active_customers();  

		$viewdata = array('services' => $services, 'customers' => $customers);

		$data = array('title' => 'Sales Services - ' . HOTEL_NAME, 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/list',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function inventory($set_service = '')
	{
		$inventory = $this->services_model->get_stock();  

		$config['base_url']   = site_url('services/inventory/');
        $config['total_rows'] = count($this->services_model->get_stock()); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment($set_service ? 3 : 4, 0);

		$inventory = $this->services_model->get_stock(['page' => $_page]);

		$viewdata = array('inventory' => $inventory);  
        $viewdata['pagination'] = $this->pagination->create_links();

		$data = array('title' => 'Sales Services - ' . HOTEL_NAME, 'page' => 'inventory');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/inventory',$viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add_inventory($id = '')
	{
		$services = $this->services_model->get_restaurants();

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
	            'item_add_date' => date('Y-m-d H:m:s')
	        );
				
			$this->services_model->add_stock($save);
			$this->session->set_flashdata('message', alert_notice('New Inventory Item added', 'success')); 
			redirect("services/inventory");
		}

		$viewdata = array('services' => $services);  

		$data = array('title' => 'Add Restaurant - ' . HOTEL_NAME, 'page' => 'inventory');

		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/add_inventory', $viewdata);
		$this->load->view($this->h_theme.'/footer');
	}

	public function add()
	{
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

		$data = array('title' => 'Add Service - ' . HOTEL_NAME, 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$this->load->view($this->h_theme.'/services/add');
		$this->load->view($this->h_theme.'/footer');
	}

	public function sale()
	{
		$post = $this->input->post();
		$items_array = $this->input->post('stock_item');
		$items = implode(',', $items_array);

        $save = array(
            'service_name' => $post['service'],
            'customer_id' => $post['customer'],
            'order_items' => $items,
            'order_price' => $post['price'],
            'order_date' => $post['date'],
            'ordered_datetime' => date('Y-m-d H:m:s')
        );

		if($this->input->post("stock_item"))
		{
			$this->hms_parser->update_stock($items_array);
			$this->services_model->order_service($save);
			$this->session->set_flashdata('message', alert_notice(count($items_array).' Items Sold', 'success')); 
			redirect("services");
		} 
	}

	function delete($service_name)
	{
		$service_name = urldecode($service_name);
		$this->services_model->deleteService($service_name);
		redirect("services");
	}

	function deleteinventory($item)
	{
		$service_name = urldecode($service_name);
		$this->services_model->deleteService($service_name);
		redirect("services");
	}

	public function edit($get_service_name)
	{
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
		$data = array('title' => 'Edit Sales Service - ' . HOTEL_NAME, 'page' => 'sales-services');
		$this->load->view($this->h_theme.'/header', $data);
		$restaurant = $this->services_model->getService($get_service_name); 
		$viewdata = array('service'  => $restaurant[0]);
		$this->load->view($this->h_theme.'/services/edit',$viewdata);

		$this->load->view($this->h_theme.'/footer'); 
	}

	public function list_stock($service = "")
	{
		$get_service_name = urldecode($service);
		$stock_list = $this->services_model->get_stock(['item_service' => $get_service_name]);

		$stock_item_array = array();
		if ($stock_list) 
		{ 
			foreach ($stock_list as $stock_item) 
			{ 
				$stock_item_array[] = '
				<div class="col-4">
					<div class="info-box">
						<span class="info-box-icon bg-danger"><i class="fas fa-utensils"></i></span>
						<div class="info-box-content">
							<div class="form-group clearfix info-box-text">
								<div class="icheck-primary d-inline">
									<input type="checkbox" id="'.$stock_item['item_name'].'" name="stock_item[]" value="'.$stock_item['item_id'].'" data-price="'.$stock_item['item_price'].'" onchange="update_price(this, '.$stock_item['item_price'].')">
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
				</div>';
			}
		}
		else
		{
			$stock_item_array[] = '<div class="col-12">'.alert_notice('This store has no items on stock', 'error', FALSE, FALSE).'</div>';
		}
		$script = '
		<script> 
			$(\'input[type="checkbox"]\').click(function() {
				var checked_box = $(this);
				if (checked_box.prop("checked") == true) {  
				}
			});
		</script>';

		$stock_item = implode('', $stock_item_array);
		$stock_item_blocks = array_merge($stock_list, array('stock_item' => $stock_item.$script));
		echo json_encode($stock_item_blocks, JSON_FORCE_OBJECT); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
