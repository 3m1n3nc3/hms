<?php   

if ( ! function_exists('alert_notice'))
{
    function alert_notice($msg = '', $type = 'info', $echo = FALSE, $dismissible = TRUE)
    {   
        $icon = $dismissible_alert = $dismiss_btn = '';
        if ($type == 'danger' || $type == 'error') 
        {
            $title = 'Error!';
            $icon = 'ban';
            $type = 'danger';
        } 
        elseif ($type == 'warning') 
        {
            $title = 'Warning!';
            $icon = 'exclamation-triangle';
        } 
        elseif ($type == 'info') 
        {
            $title = 'Notice';
            $icon = 'info';
        } 
        elseif ($type == 'success') 
        {
            $title = 'Success';
            $icon = 'check';
        }

        if ($dismissible === TRUE) 
        {
            $dismissible_alert = ' alert-dismissible';
            $dismiss_btn = ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        }

        if ($msg != '') 
        {
            if ($dismissible !== 'FLAT') 
            {
                $alert = 
                '<div class="alert alert-'.$type.$dismissible_alert.'">
                    '.$dismiss_btn.'
                    <h6><i class="icon fa fa-'.$icon.'"></i> '.$title.'</h6>
                    '.str_ireplace('.', '.', $msg).'
                </div>';
            } else {
                $alert  = 
                '<div class="alert alert-'.$type.$dismissible_alert.'">
                    '.$dismiss_btn.'
                    <i class="icon fa fa-'.$icon.'"></i>
                    '.$msg.'.
                </div>';
            }
            if ($echo) 
            {
                echo $alert;
                return;
            }
            return $alert;
        }
        return;
    }
}

if ( ! function_exists('check_login'))
{
    function check_login()
    {
        if(!UID)
            redirect("login");
    } 
}

if ( ! function_exists('supr_replace'))
{
    function supr_replace($string = '', $caps = '', $predef = '')
    {
        if (!$predef) 
        {
            $string = str_ireplace('_', ' ', $string);
            $string = str_ireplace('-', ' ', $string);
        }
        if ($caps) 
        {
            return ucwords($string);   
        }
        return $string;
    } 
}

if ( ! function_exists('service_point_access'))
{
    /** 
     *
     * Checks if a user has the specified privilege
     *
     * @param   string      $role   
     * @return  boolen
     */
    function service_point_access($department_id = '')
    {
        global $CI; 
 
        if ($CI->logged_user['role'] == 2)
        {
            return true;
        }

        if ($CI->logged_user['department_id'] === $department_id) 
        {   
            return true; 
        } 

        return false; 
    } 
}
