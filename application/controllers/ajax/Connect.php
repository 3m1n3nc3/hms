<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Connect extends MY_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}  


    /**
     * Handles ajax image uploads
     * @param  string 	$endpoint_id	Specifies the id of the content receiving the image record
     * @param  string 	$endpoint		Specifies the type of content receiving the image record
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
	public function upload_image($endpoint_id = '', $endpoint = 0)
	{ 	 
		if ($endpoint === 'customer') 
		{ 
			$user_id  = $endpoint_id ? $endpoint_id : $this->session->userdata('cusername');
			$data     = $this->account_data->fetch($user_id, 1); 
	        $sub_folder = $data['customer_username'] . '/';  
		}
		elseif ($endpoint === 'employee') 
		{ 
			$user_id  = $endpoint_id ? $endpoint_id : $this->session->userdata('username');
			$data     = $this->account_data->fetch($user_id); 
	        $sub_folder  = $data['employee_username'] . '/'; 	 
		}
		else 
		{  
			// page, room
	        $page = $this->content_model->get(array('id' => $endpoint_id));
	        // $room = $this->room_model->getRoom(array('id' => $endpoint_id));
	        // $roomType = $this->room_model->getRoomType($endpoint_id/*$room['room_type']*/, 1);
	        if ($endpoint === 'page') 
	        {
	        	$data = $this->content_model->get(array('id' => $endpoint_id));
	        }
	        else 
	        {
	        	$data = $this->room_model->getRoomType($endpoint_id, 1);
	        }
	        $sub_folder  = $endpoint . '/';
		} 

		$table_index = ($endpoint === 'page') ? 'banner' : 'image'; 

		$upload_type 	 = $this->input->post('set_type');
		if ($upload_type == 'cover') 
		{
			$folder 	 = 'covers/';
		} 
		else 
		{
			$folder 	 = 'avatars/'; 
		}

		// Set the upload directory
	    $_config['upload_path'] = './uploads/' . $folder . $sub_folder; 

		if (isset($data)) { 

			// Check if this upload is ajax
			$file = $this->input->post('ajax_image');
			if ($file) 
			{
			  	$ajax_image_ = explode(';', $file);
			  	$ajax_image_ = isset($ajax_image_[1]) ? $ajax_image_[1] : null; 
			}

			if (isset($ajax_image_))
			{ 
				list($type, $file) = explode(';', $file);
				list(, $file) = explode(',', $file);
				$image = base64_decode($file);
				$new_image = mt_rand().'_'.mt_rand().'_'.mt_rand().'_p.png';

			  	// Save the new image to the upload directory              
			  	if ($image)
			  	{
	                if ( ! $this->creative_lib->create_dir($_config['upload_path']))
	                {
	                    $data['error'] = $this->my_config->alert('The upload destination folder does not appear to be writable.', 'danger'); 
	                }
	                else
	                {
	                    $this->creative_lib->delete_file('./' . $data[$table_index]);

		                if ( ! file_put_contents($_config['upload_path'] . $new_image, $image) )
		                {
		                    $data['error'] = $this->my_config->alert('The file could not be written to disk.', 'danger'); 
		                }
		                else
		                {
		                    $data_img = 'uploads/' . $folder . $sub_folder . $new_image;

							if ($endpoint === 'customer') 
							{
								$this->customer_model->add_customer(['cid' => $data['customer_id'], $table_index => $data_img]);
							}
							elseif ($endpoint === 'employee') 
							{ 	 
								$this->employee_model->addEditEmployee(['employee_id' => $data['employee_id'], $table_index => $data_img]);
							} 
					        if ($endpoint === 'page') 
					        { 
								$this->content_model->add(['id' => $data['id'], $table_index => $data_img]);
					        }
					        if ($endpoint === 'room')
					        { 
								$this->room_model->editRoomType(['room_type' => $data['room_type'], $table_index => $data_img]);
					        }  

		                    chmod($_config['upload_path'].'/'.$new_image, 0777); 
		                    $data['success'] = $this->my_config->alert('Your upload was completed successfully.', 'success');
		                }
	                }
	            } 
			} 
			elseif (empty($ajax_image_)) 
			{
	            $data['error'] = $this->my_config->alert('We were unable to process this upload, maybe you did not select a file.', 'danger'); 
			}
		} 
		else 
		{
            $data['error'] = $this->my_config->alert('Unable to find parent content, please contact your server admin', 'danger'); 
		}

		echo json_encode($data, JSON_FORCE_OBJECT);
		return;
	}


    /**
     * Receives a request from ajax and saves the current order of the items 
     * @return null     Does not return anything but echoes a JSON Object with a response
     */
	public function sortable()
	{	
		$items = $this->input->post(NULL, TRUE);
		$i = 1;
		foreach ($items['item'] AS $item) 
		{
			$this->content_model->add(['id' => $item, 'priority' => $i]);
			$i++;
		}
		echo json_encode(array('response' => TRUE));
	} 


    /**
     * Deletes items from the database, request is sent from ajax
     * @param  string 	$endpoint_id	Specifies the id of the content receiving the image record
     * @param  string 	$endpoint		Specifies the type of content receiving the image record
     * @return null     Does not return anything but echoes a JSON Object with the current status of the upload
     */
	public function deleteItem()
	{
		$type = $this->input->post('type');
		$data['id']     = $this->input->post('id'); 
		$data['action'] = $this->input->post('action');
		$data['init'] 	= $this->input->post('init');
 		
 		if ($type == 'page') 
 		{
 			$query = array('id' => $data['id']);
        	$page = $this->content_model->get($query);

        	// Delete the images associated with this item
 			$this->creative_lib->delete_file($page['banner']);

 			// Delete all records associated with this item
 			if (!$page['parent']) {
 				$this->content_model->remove(['parent' => $page['safelink']]); 
 			}
 			$this->content_model->remove($data['id']);
 		}
        echo json_encode(array('response' => true, 'msg' => '', 'status' => 1), JSON_FORCE_OBJECT);
        return;
	}


    /**
     * Receives ajax request for country, state, and cities worldwide
     * @param  string   $local      specifies the local to return [countries|states|cities]
     * @param  string   $parent_id  If set will return the local for the set parent
     * @return NULL     Echoes a json string containing the data presented by the relevant helper
     */
    public function fetch_locale($locale = '', $parent_id = '')
    {
        if ($locale == 'countries') 
        {
            $data['response'] = select_countries();
        }
        elseif ($locale == 'states') 
        {
            $data['response'] = select_states($parent_id);
        }
        elseif ($locale == 'cities') 
        {
            $data['response'] = select_cities($parent_id);
        }

        echo json_encode($data, JSON_FORCE_OBJECT);
    }


    /**
     * Fetches notifications for the currently logged in user 
     * @return NULL     Echoes a json string containing the notifications
     */
    public function fetch_notifications()
    {
        header('Content-type: application/json'); 

        try 
        {
            $param              = ['recipient_id' => $this->logged_user['employee_id'], 'type' => 'all'];
            $notif_list         = $this->notifications->getNotifications($param);
            $data['notif_list'] = o2Array($notif_list);

            $response['status'] = 200;
            $response['html']   = $this->load->view($this->h_theme. '/extra_layout/notifications', $data, TRUE);
        }
        catch(Exception $e)
        {
            $response['status']  = 304;
            $response['message'] = $e;
        }

        echo json_encode($response);
    }


    /**
     * Fetches and updates status of notifications, requests and messages
     * @return NULL     Echoes a json string containing the notifications
     */
    public function update_data()
    {
        header('Content-type: application/json'); 

        $features = $this->input->get(NULL, TRUE);

        try 
        {
            $response['notif'] =
            $response['new_messages'] =
            $response['chats'] =
            $response['requests'] = FALSE;

            $param                    = ['recipient_id' => $this->logged_user['employee_id'], 'type' => 'new'];
            $notifications            = $this->notifications->getNotifications($param);
            if ($notifications) {
                $response['notif']    = $notifications;
            }
            $response['requests']     = 0;
            $response['new_messages'] = 0;

            $response['status']       = 200; 
        }
        catch(Exception $e)
        {
            $response['status']  = 304;
            $response['message'] = $e;
        }

        echo json_encode($response);
    }


    /**
     * For the status of the selected room
     * @return NULL     Echoes a json string containing the notifications
     */
    public function checkroom()
    {
        header('Content-type: application/json');   
        $response['available']  = true;

        $room_id = $this->input->post('room_id', TRUE);
        $room    = $this->reservation_model->reserved_rooms(['room' => $room_id, 'overstay' => TRUE], 1);
        if ($room) {
            $response['message'] = alert_notice(sprintf(lang('customer_overstaying'), 'ddd'), 'warning'); 
            $response['available']  = false;
        }

        echo json_encode($response);
    }
}
