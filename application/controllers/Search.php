<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Admin_Controller 
{ 


    /**
     * Search the users data base 
     * @return null                 	Does not return anything but uses code igniter's view() method to render the page
     */
	public function index()
	{ 
		$word = trim($this->input->post("customer"));

		$result = $this->report_model->search_customers($word);
		
		$data = array('title' => 'Search - ' . my_config('site_name'), 'page' => 'dashboard');
		$this->load->view($this->h_theme.'/header', $data);

		$vdata = array(
			'query' => $word,
			'result' => $result
		);
		
		$this->load->view($this->h_theme.'/search', $vdata);
		$this->load->view($this->h_theme.'/footer');
	}
} 
