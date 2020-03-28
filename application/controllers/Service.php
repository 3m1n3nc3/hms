<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends Admin_Controller { 

  public function order()
  { 
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
        $this->session->set_flashdata('message', alert_notice('New Restaurant Service added', 'success'));
        redirect('services');
    } 
  }

  public function massage_room()
  { 
    $massage = $this->input->post("massage");
    $customer = $this->input->post("customer");
    $date = $this->input->post("date");
    $details = $this->input->post("details");
    $price = $this->input->post("price");

    $this->massage_room_model->add_service($massage, $customer, $date, $details, $price);
    $this->session->set_flashdata('message', alert_notice('New Massage Service added', 'success'));

    $data = array('page' => 'massage_room', 'title' => 'Add Massage Service - ' . HOTEL_NAME);
    $vdata = array('type' => 'massage_room');
    $this->load->view($this->h_theme.'/header', $data);
    $this->load->view($this->h_theme.'/service_success', $vdata);
    $this->load->view($this->h_theme.'/footer');
  }

  public function sport_facility()
  { 
    $sport = $this->input->post("sport");
    $customer = $this->input->post("customer");
    $date = $this->input->post("date");
    $details = $this->input->post("details");
    $price = $this->input->post("price");

    $this->sport_facility_model->add_service($sport, $customer, $date, $details, $price);
    $this->session->set_flashdata('message', alert_notice('New Sport Facility Service Created', 'success'));

    $data = array('page' => 'sport_facility', 'title' => 'Add Sport Service - ' . HOTEL_NAME);
    $vdata = array('type' => 'sport_facility');
    $this->load->view($this->h_theme.'/header', $data);
    $this->load->view($this->h_theme.'/service_success', $vdata);
    $this->load->view($this->h_theme.'/footer');
  }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
