<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller { 

	public function dashboard()
	{ 
        // Check if the user has permission to access this module and redirect to 401 if not
        error_redirect(has_privilege('dashboard'), '401');
        
		$today_stats = $this->report_model->today_stats();
		$customer_pay_list = $this->report_model->get_customer_freq_list();
		$customer_most_paid = $this->report_model->get_customer_most_paid();
		$next_week_freq = $this->report_model->get_next_week_freq();
        $sales_stats = $this->accounting_model->statistics(/*['service' => 'Wine Bar']*/);
		
		$data = array('title' => HOTEL_NAME, 'page' => 'dashboard', 'has_calendar' => TRUE);
		$this->load->view($this->h_theme.'/header', $data);
 
		$viewdata = array(
			'today_stats' => $today_stats,
			'customer_pay_list' => $customer_pay_list,
			'customer_most_paid' => $customer_most_paid,
			'next_week_freq' => $next_week_freq,
            'sales_stats' => $sales_stats
		);
		$this->load->view($this->h_theme.'/welcome_message', $viewdata);
		$this->load->view($this->h_theme.'/footer', array("next_week_freq"=>$next_week_freq));
		$this->session->set_userdata('show_guide',true);
	}

    /**
     * Lists all created page content
     * @param  string $parent If this is set it will get the content for a specific page item 
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function pages($parent = '')
    {     
        error_redirect(has_privilege('manage-pages'), '401'); 

        $parent = $this->input->get('parent');  

        // configure and initialize the pagination
        $get_query = ($parent ? '?parent='.$parent : '');
        $set_parent = (!$parent ? 'null' : '');
        $config['suffix'] = $get_query;
        $config['base_url']   = site_url('manage/admin/pages/page');
        $config['total_rows'] = count($this->content_model->get(['parent' => $set_parent, 'manage' => TRUE])); 

        $this->pagination->initialize($config);
        $_page = $this->uri->segment(5, 0);

        $query = array('parent' => $set_parent, 'manage' => TRUE, 'page' => $_page);

		$viewdata = array(
			'pagination' => $this->pagination->create_links(),
			'contents' => $this->content_model->get($query)
		);  

		$data = array(
			'title' => 'Manage Pages - ' . HOTEL_NAME, 
			'sub_page_title' => lang('manage_pages'),
			'page' => 'dashboard'
		);

        $this->load->view($this->h_theme.'/header', $data);       
        $this->load->view($this->h_theme.'/dashboard/manage_pages', $viewdata);       
        $this->load->view($this->h_theme.'/footer', $data);  
    }

    /**
     * Manages page and page creation and updating
     * @param  string $action This specified action for this method (edit is implemented)
     * @param  string $id     The id of the content to edit if action is set
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function create_page($action = '', $id = '')
    {     
        error_redirect(has_privilege('manage-pages'), '401');  
        $item_id = $id;
        
        $query   = array('id' => $id);
        $content = $this->content_model->get($query, 1);
        $parent  = $id ? ($content['parent'] ? $content['parent'] : $content['safelink']) : 'non'; 

        $unique_safelink = $this->input->post('safelink') != $content['safelink'] ? '|is_unique[content.safelink]' : '';
        
        // Validate Input
        $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>');
        $this->form_validation->set_rules('title', 'Title', 'trim|required'.$unique_safelink);  
        $this->form_validation->set_rules('safelink', 'Safelink', 'trim|required|alpha_dash'); 
        $this->form_validation->set_rules('icon', 'Icon', 'trim'); 
        $this->form_validation->set_rules('color', 'Color', 'trim'); 
        $this->form_validation->set_rules('priority', 'Priority', 'trim|required|numeric|in_list[1,2,3]'); 
        $this->form_validation->set_rules('content', 'Content', 'trim|required'); 

        // The intro becomes required when the parent is not set
        if (!$this->input->post('parent')) 
        {
            $this->form_validation->set_rules('intro', 'Introductory Text', 'trim|required'); 
        }

        if ($this->form_validation->run() === FALSE) 
        { 
            if ($this->input->post()) 
            {
                $this->session->set_flashdata('msg', alert_notice(lang('submission_has_errors'), 'danger'));
            }
        } 
        else 
        { 
            $save = $this->input->post();
            $msg  = lang('page_created');

            $save['in_footer'] = (isset($save['in_footer']) && !$save['parent']) ? '1' : '0';
            if ($item_id) 
            {
                $msg = lang('page_updated');
                $save['id'] = $content['id']; 
            }

            $save['safelink'] = (!$save['safelink'] ? url_title($save['title'], '_', TRUE) : $save['safelink']);
            $save['safelink'] = ($content['safelink'] === 'homepage' ? $content['safelink'] : $save['safelink']);

            if (!$content['parent']) 
            {
                $this->content_model->update_parent(['safelink' => $content['safelink'], 'parent' => $save['safelink']]);
            }
            $saved_id = $this->content_model->add($save);
            $this->session->set_flashdata('msg', alert_notice($msg, 'success'));
            redirect('admin/create_page/edit/'.($content['id'] ?? $saved_id)); 
        }

		$viewdata = array( 
			'content' => $content,
			'children' => $this->content_model->get(['parent' => $parent]),
            'parent' => $content['parent'],
			'children_title' => $item_id ? 'Page Content' : 'Pages'
		);  

		$data = array(
			'title' => lang('create_page') . ' - ' . HOTEL_NAME, 
			'sub_page_title' => $item_id == '' ? lang('create_page') : lang('update_page'),
			'page' => 'dashboard'
		);

        $this->load->view($this->h_theme.'/header', $data);       
        $this->load->view($this->h_theme.'/dashboard/create_page', $viewdata);       
        $this->load->view($this->h_theme.'/footer', $data);  
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
