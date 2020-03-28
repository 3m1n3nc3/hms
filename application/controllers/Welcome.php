<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Admin_Controller { 

	public function index()
	{ 
		$today_stats = $this->report_model->today_stats();
		$customer_pay_list = $this->report_model->get_customer_freq_list();
		$customer_most_paid = $this->report_model->get_customer_most_paid();
		$next_week_freq = $this->report_model->get_next_week_freq();
		
		$data = array('title' => HOTEL_NAME, 'page' => 'dashboard', 'has_calendar' => TRUE);
		$this->load->view($this->h_theme.'/header', $data);

		$viewdata = array(
			'today_stats' => $today_stats,
			'customer_pay_list' => $customer_pay_list,
			'customer_most_paid' => $customer_most_paid,
			'next_week_freq' => $next_week_freq
		);
		$this->load->view($this->h_theme.'/welcome_message', $viewdata);
		$this->load->view($this->h_theme.'/footer', array("next_week_freq"=>$next_week_freq));
		$this->session->set_userdata('show_guide',true);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
