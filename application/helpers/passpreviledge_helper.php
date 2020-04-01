<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

$CI = & get_instance();  

// --------------------------------------------------------------------

if ( ! function_exists('has_privilege'))
{
	/** 
	 *
	 * Checks if a user has the specified privilege
	 *
	 * @param	string		$role   
	 * @return	boolen
	 */
    function has_privilege($role = '')
    {
    	global $CI; 
 
        if ($CI->logged_user['role'] == 2)
        {
            return true;
        }

        if ($CI->logged_user['role_id'] > 0) 
        { 
            $privilege =  $CI->privilege_model->get($CI->logged_user['role_id']);
            if ($privilege) 
            {
                $privilege = perfect_privilege($privilege['permissions']);
                return (in_array($role, $privilege) OR in_array('default', $privilege));
            } 
        } 
        return false; 
    } 
}


if ( ! function_exists('encode_privilege'))
{
    /** 
     *
     * Converts a comma separated string into an array then encodes it
     *
     * @param   string      $string   
     * @return  boolen
     */
    function encode_privilege($string = '')
    {
        $string = explode(',', $string); 
        $string = json_encode($string, JSON_FORCE_OBJECT);
      
        return base64_encode($string);
    }
}


if ( ! function_exists('decode_privilege'))
{
    /** 
     *
     * Decodes the privilege string
     *
     * @param   string      $string   
     * @return  string
     */
    function decode_privilege($string = '')
    {
        if(base64_decode($string, true) == true) 
        {
            return base64_decode($string);
        } 
        else 
        {
            return $string;
        }
    }
}


if ( ! function_exists('perfect_privilege'))
{
    /** 
     *
     * Performs a json decode on the json encoded string
     * first checks if it is an object then forces it into an array
     *
     * @param   string      $string   
     * @return  string
     */
    function perfect_privilege($string = '')
    {
        $string = decode_privilege($string);

        if (json_decode($string, JSON_OBJECT_AS_ARRAY)) 
        {
            return json_decode($string, JSON_OBJECT_AS_ARRAY);
        }
        else
        {
            return json_decode($string); 
        }
    }
}


if ( ! function_exists('list_permissions'))
{
    function list_permissions($permissions = '')
    {   
        $privilege = decode_privilege($permissions);
        $array     = perfect_privilege($privilege);
        if ($array) {
            return implode(',', $array );
        }
    }
}
