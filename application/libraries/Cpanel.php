<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
include_once APPPATH . '/third_party/cpanel-UAPI-php-class/cpaneluapi.class.php';

class Cpanel {

    function __construct() 
    {
        $this->CI = & get_instance();
        
        $hostname = $this->CI->my_config->item('cpanel_host');
        $username = $this->CI->my_config->item('cpanel_username');
        $password = $this->CI->my_config->item('cpanel_password');
        
        $this->cPanel = new cpanelAPI($username, $password, $hostname);   
    }

    /**
     * This function handles all mysql database processes for cpanel api
     * @param  string $data this is arguments to send to the api
     * @param  string $function this is the cpanel function to set for the Api Mysql object
     * |
     * | Basic Functions         |  Description                         |    Example Arguments 
     * |----------------------------------------------------------------------------------------------------------------------
     * | get_server_information         
     * | create_database         |  creates a MySQL® database.          |   ['name' => $cPanel->user.'_MyDatabase']
     * | create_user             |  creates a MySQL® database user.     |   ['name' => $cPanel->user.'_MyDatabase', 'password' => 1gA4&c@a']
     * |
     * @return array           containing the server response
     */
    public function mysql($data = array(), $function = 'get_server_information')
    {   
        $response = $this->cPanel->uapi->post->Mysql->$function($data);  
        
        return $response->data;
    }


    /**
     * This function handles all email processes for cpanel api
     * @param  string $data this is arguments to send to the api
     * @param  string $function this is the cpanel function to set for the Api Email object
     * |
     * | Basic Functions         |           Description              |           Example Arguments 
     * |----------------------------------------------------------------------------------------------------------------------
     * | add_pop                 | Creates a new email account        | ['email'=>'emailuser', 'password'=> '1gA4&c@a', 'domain'=>'example.com']
     * |
     * @return array           containing the server response
     */
    public function email($data = array(), $function = 'add_pop')
    {    
        $response = $this->cPanel->uapi->post->Email->$function($data);

        // return array(
        //     'status'    => $response->status, 
        //     'errors'    => $response->errors, 
        //     'data'      => $response->data, 
        //     'messages'  => $response->messages
        // );
        return $response;
    }


    /**
     * This function handles all subDomain processes for cpanel api
     * @param  string $data this is arguments to send to the api
     * @param  string $function this is the cpanel function to set for the Api SubDomain object
     * |
     * | Basic Functions    |           Description        |           Example Arguments 
     * |----------------------------------------------------------------------------------------------------------------------
     * | addsubdomain       | Creates a new subdomain      | ['domain'=>'subdomain', 'rootdomain'=> 'example.com', 'dir'=>'/public_html/directory_name']
     * |
     * @return array           containing the server response
     */
    public function subdomain($data = array(), $function = 'addsubdomain')
    {    
        $response = $this->cPanel->uapi->post->SubDomain->$function($data);
        return $response;
    }


}
