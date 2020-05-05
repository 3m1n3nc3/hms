<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends Admin_Controller 
{ 

  /**
   * This method saves and processes orders placed from the point method
   * @return null             redirects to the point method
   */
  public function order()
  { 
    error_redirect(has_privilege('service-point') || has_privilege('sales-services') || service_point_access_session(TRUE), '401');

    $service = $this->input->post("service");
    $customer = $this->input->post("customer");
    $date = $this->input->post("date"); 
    $price = $this->input->post("price");

    $data = array(
      'service_name' => $service,
      'customer_id' => $customer,
      'order_date' => $date, 
      'ordered_datetime' => date('Y-m-d H:i:s'), 
      'order_price' => $price
    );

    if ($this->input->post()) {
      $this->restaurant_model->add_service($data);
      $this->session->set_flashdata('message', alert_notice('Service request placed', 'success'));
      redirect('services');
    } 
  } 

  /**
   * This method allows employees with applicable permission to sell available services
   * @param  string $service_id this is the id of the service point
   * @return null             uses codeigniters view method to display a page
   */
  public function point($service_id = '')
  {   
    $service_id = urldecode($service_id); 

    $inventory = $this->services_model->get_stock();  
    $list_services = $this->services_model->get_service();
    $service = $this->services_model->getService($service_id);
    $customers = $this->customer_model->get_active_customers(); 

    // Check if the user has permission to access this module and redirect to 401 if not
    error_redirect(has_privilege('service-point') OR service_point_access($service[0]->id), '401'); 

    $data = array(
      'page' => 'service-point', 
      'active_page' => $service_id,
      'title' => 'Service Point - ' . my_config('site_name'),
      'sub_page_title' => $service[0]->service_name
    );

    $viewdata = array(
      'inventory' => $inventory, 
      'list_services' => $list_services, 
      'service' => $service[0] ?? [], 
      'customers' => $customers,  
    );  
 
    $this->load->view($this->h_theme.'/header', $data);
    $this->load->view($this->h_theme.'/services/service_point', $viewdata);
    $this->load->view($this->h_theme.'/footer');
  }
} 
