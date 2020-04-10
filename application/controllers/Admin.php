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
        
        $data = array('title' => my_config('site_name'), 'page' => 'dashboard', 'has_calendar' => TRUE);
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

    public function configuration($step = 'main')
    { 
        // Check if the user has permission to access this module and redirect to 401 if not        
        error_redirect(has_privilege('manage-configuration'), '401'); 

        // $data['profile']       = $this->passcontest->basic_profile($data['id']); 

        $data = array(
            'title' => 'Site Configuration - ' . my_config('site_name'), 
            // 'sub_page_title' => lang('manage_pages'),
            'page' => 'configuration',
            'step' => $this->input->post('step') ? $this->input->post('step') : $step,
            'enable_steps' => 1
        ); 

        $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>'); 
 
        if (!$data['enable_steps'] || $data['step'] == 'main') 
        { 
            $this->form_validation->set_rules('value[site_name]', 'Site Name', 'trim|required|alpha_numeric_spaces'); 
        }

        if (!$data['enable_steps'] || $data['step'] == 'payment')
        { 
            $this->form_validation->set_rules('value[site_currency]', 'Site Currency', 'trim|alpha|required|max_length[3]'); 
            $this->form_validation->set_rules('value[currency_symbol]', 'Currency Symbol', 'trim');  
            $this->form_validation->set_rules('value[payment_ref_pref]', 'Reference Prefix', 'trim|alpha_dash'); 
            $this->form_validation->set_rules('value[paystack_public]', 'Paystack Public Key', 'trim|alpha_dash'); 
            $this->form_validation->set_rules('value[paystack_secret]', 'Paystack Secret Key', 'trim|alpha_dash'); 
            $this->form_validation->set_rules('value[checkout_info]', 'Checkout Info', 'trim'); 
        }

        if (!$data['enable_steps'] || $data['step'] == 'contact') 
        { 
            $this->form_validation->set_rules('value[contact_email]', lang('contact').' '.lang('email_address'), 'trim|valid_emails'); 
            $this->form_validation->set_rules('value[contact_phone]', lang('contact').' '.lang('phone'), 'trim'); 
            $this->form_validation->set_rules('value[contact_days]', lang('contact').' ' .lang('days'), 'trim'); 
            $this->form_validation->set_rules('value[contact_facebook]', lang('site').' ' .lang('facebook'), 'trim'); 
            $this->form_validation->set_rules('value[contact_twitter]', lang('site').' ' .lang('twitter'), 'trim'); 
            $this->form_validation->set_rules('value[contact_instagram]', lang('site').' ' .lang('instagram'), 'trim'); 
            $this->form_validation->set_rules('value[contact_address]', lang('contact').' '.lang('address'), 'trim'); 
        }    

        if ($this->form_validation->run() === FALSE) 
        {
            if ($this->input->post('value')) 
            {
                $this->session->set_flashdata('message', alert_notice(lang('input_has_errors'), 'danger'));
            }
        } 
        else 
        { 
            unset($_POST['step']);
            $resize = ['width' => 150, 'height' => 150];
            $x_resize = ['width' => 30, 'height' => 30];
            $b_resize = ['width' => 800, 'height' => 800]; 
            $this->creative_lib->upload('features_banner', my_config('features_banner'), 'features_banner', NULL, $b_resize, ['value' => 'features_banner']);
            $this->creative_lib->upload('breadcrumb_banner', my_config('breadcrumb_banner'), 'breadcrumb_banner', NULL, $b_resize, ['value' => 'breadcrumb_banner']);
            $this->creative_lib->upload('site_logo', my_config('site_logo'), 'site_logo', NULL, $resize, ['value' => 'site_logo']);
            $this->creative_lib->upload('favicon', my_config('favicon'), 'favicon', NULL, $x_resize, ['value' => 'favicon']);

            if ($this->creative_lib->upload_errors() === FALSE)
            {
                $save = $this->input->post('value'); 
                $this->setting_model->save_settings($save);
                $this->session->set_flashdata('message', $this->my_config->alert(lang('configuration_saved'), 'success'));
                redirect('admin/configuration/'.$step); 
            }

            $process_complete = TRUE;
        }   

        $this->load->view($this->h_theme.'/header', $data);       
        $this->load->view($this->h_theme.'/dashboard/admin_configuration', $data);       
        $this->load->view($this->h_theme.'/footer', $data);  
    }


    /**
     * Manages the hotels features and facilities
     * @param  string $action This specified action for this method (edit is implemented)
     * @param  string $id     The id of the content to edit if action is set
     * @return null           Does not return anything but uses code igniter's view() method to render the page
     */
    public function facilities($action = 'add', $id = '')
    {
        // Check of employee has permission to take this action
        error_redirect(has_privilege('manage-configuration'), '401'); 
 
        $data = array(
            'title' => 'Hotel Facilities - ' . my_config('site_name'), 
            'page' => 'facilities',
            'action' => $action,
            'sub_page_title' => lang($action . '_facilities')
        );
        $this->load->view($this->h_theme.'/header', $data);

        $query = ($action === 'edit' || $action === 'add') ? ['id' => $id] : '';
        $facilities = $this->content_model->get_facilities($query); 

        $viewdata = array('facilities' => $facilities); 

        if ($action === 'delete') 
        {
            $this->content_model->remove_facility($id); 
            $this->session->set_flashdata('message', $this->my_config->alert(lang('facility'). ' ' .lang('deleted'), 'success'));
            redirect('admin/facilities/list');
        }
        elseif ($action === 'list') 
        {
            $this->load->view($this->h_theme.'/dashboard/list_facilities',$viewdata);
        }
        else
        {

            $this->form_validation->set_error_delimiters('<div class="text-danger form-text text-muted">', '</div>'); 
            $post = $this->input->post(NULL, TRUE);
            if ($this->input->post('save_facility')) 
            {
                unset($post['save_facility']);
                $this->form_validation->set_rules('title', 'Name', 'trim|required|alpha_numeric_spaces'); 
                $this->form_validation->set_rules('icon', 'Icon', 'trim|required'); 
                $this->form_validation->set_rules('details', 'Details', 'trim|required'); 

                if ($this->form_validation->run() !== FALSE)
                {   $msg = lang('facility') . ' ' . lang('created');
                    if ($id) 
                    {
                        $msg = lang('facility') . ' ' . lang('updated');
                        $post['id'] = $id;
                    }
                    $this->session->set_flashdata('message', alert_notice($msg, 'success'));
                    $insert = $this->content_model->add_facility($post);
                    redirect('admin/facilities/edit/' . ($post['id'] ?? $insert));
                } 
            }

            if ($this->input->post('save_home')) 
            {
                $this->form_validation->set_rules('value[facilities_title]', lang('title'), 'trim|required'); 
                $this->form_validation->set_rules('value[facilities_content]', lang('content'), 'trim|required'); 

                if ($this->form_validation->run() !== FALSE) 
                {
                    $save = $this->input->post('value'); 
                    unset($save['save_home']);
                    $this->setting_model->save_settings($save);
                    $this->session->set_flashdata('message', $this->my_config->alert(lang('configuration_saved'), 'success'));

                    redirect('admin/facilities/' . $action);
                } 
            }

            $this->load->view($this->h_theme.'/dashboard/facilities', $viewdata);
        }

        $this->load->view($this->h_theme.'/footer');
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
			'title' => 'Manage Pages - ' . my_config('site_name'), 
			'sub_page_title' => lang('manage_pages'),
			'page' => 'pages'
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
                $this->session->set_flashdata('message', alert_notice(lang('submission_has_errors'), 'danger'));
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
            $this->session->set_flashdata('message', alert_notice($msg, 'success'));
            redirect('admin/create_page/edit/'.($content['id'] ?? $saved_id)); 
        }

		$viewdata = array( 
			'content' => $content,
			'children' => $this->content_model->get(['parent' => $parent]),
            'parent' => $content['parent'],
			'children_title' => $item_id ? 'Page Content' : 'Pages'
		);  

		$data = array(
			'title' => lang('create_page') . ' - ' . my_config('site_name'), 
			'sub_page_title' => $item_id == '' ? lang('create_page') : lang('update_page'),
			'page' => 'create_page'
		);

        $this->load->view($this->h_theme.'/header', $data);       
        $this->load->view($this->h_theme.'/dashboard/create_page', $viewdata);       
        $this->load->view($this->h_theme.'/footer', $data);  
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
