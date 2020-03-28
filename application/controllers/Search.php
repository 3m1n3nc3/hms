<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Admin_Controller { 

	public function index()
	{ 
		$word = $this->input->post("customer");

		$result = $this->report_model->search_customers($word);
		
		$data = array('title' => 'Search - ' . HOTEL_NAME, 'page' => 'dashboard');
		$this->load->view($this->h_theme.'/header', $data);

		$vdata = array(
			'query' => $word,
			'result' => $result
		);
		$this->load->view($this->h_theme.'/search', $vdata);
		$this->load->view($this->h_theme.'/footer');
	}
}

/* End of file search.php */
/* Location: ./application/controllers/search.php */
