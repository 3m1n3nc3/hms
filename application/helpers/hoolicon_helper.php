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
        $CI = & get_instance(); 
 
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

    
if ( ! function_exists('service_point_access_session'))
{ 
    /** 
     *
     * Checks if a user has any privileges
     *
     * @param   mixed      $check   TRUE: Check, FALSE: Set Session, Anything Else: Clear Session   
     * @return  boolen
     */
    function service_point_access_session($check = FALSE)
    {
        $CI = & get_instance(); 

        if ($check === TRUE) 
        { 
            if (isset($_SESSION['service_point_access'])) 
            {
                return TRUE;
            } 
        }
        elseif ($check === FALSE) 
        { 
            $list_services = $CI->services_model->get_service();
            if ($list_services)
            {              
                $service_point_access = [];
                foreach ($list_services AS $service)
                { 
                    if (service_point_access($service->id))
                    {
                        $service_point_access[] .= $service->id; 
                    }
                }

                if ($service_point_access && !isset($_SESSION['service_point_access'])) 
                    $CI->session->set_userdata('service_point_access', $service_point_access);
            }
        }
        else
        {   
            if (isset($_SESSION['service_point_access'])) 
            {
                $CI->session->unset_userdata('service_point_access');
            }
        }
    }
}


if ( ! function_exists('showBBcodes'))
{ 

    /** 
    * A simple PHP BBCode Parser function
    *
    * @author Afsal Rahim
    * @link http://digitcodes.com/create-simple-php-bbcode-parser-function/
    * Extended by passtech
    * 
    **/

    //BBCode Parser function

    function showBBcodes($text, $class = '') {
        // BBcode array
        $find = array(
            '~\[b\](.*?)\[/b\]~s',
            '~\[i\](.*?)\[/i\]~s',
            '~\[u\](.*?)\[/u\]~s',
            '~\[quote\](.*?)\[/quote\]~s',
            '~\[size=(.*?)\](.*?)\[/size\]~s',
            '~\[color=(.*?)\](.*?)\[/color\]~s',
            '~\[link=(.*?)\](.*?)\[/link\]~s',
            '~\[url\]((?:ftp|https?)://.*?)\[/url\]~s',
            '~\[img\](https?://.*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s'
        );

        $class = ($class ? ' class="' . $class .'" ' : '');

        // HTML tags to replace BBcode
        $replace = array(
            '<'.$class.'b>$1</b>',
            '<'.$class.'i>$1</i>',
            '<'.$class.'span style="text-decoration:underline;">$1</span>',
            '<'.$class.'pre>$1</'.'pre>',
            '<span'.$class.' style="font-size:$1px;">$2</span>',
            '<span'.$class.' style="color:$1;">$2</span>',
            '<a'.$class.' href="$1">$2</a>',
            '<a'.$class.' href="$1">$1</a>',
            '<img'.$class.' src="$1" alt="" />'
        );

        // Replacing the BBcodes with corresponding HTML tags
        return preg_replace($find,$replace,$text);
    }

    // How to use the above function:

    // $bbtext = "This is [b]bold[/b] and this is [u]underlined[/u] and this is in [i]italics[/i] with a [color=red] red color[/color]";
    // $htmltext = showBBcodes($bbtext);
    // echo $htmltext; 
}

if ( ! function_exists('social_link_fix') ) 
{
    function social_link_fix($link = '')
    {
        $match = preg_match(
            '|(https?://)?(www\.)?([a-z0-9]*.[a-z0-9]*)?\/(#!/)?@?([^/]*)|', $link, $matches
        );

        if ($matches) 
        {
            return ($matches[1] ?? '') . ($matches[3] ?? '') . '/'. ($matches[5] ?? '');
        }

        return $link;
    }
}


if ( ! function_exists('social_link') ) 
{
    function social_link($link = '', $site = '')
    {
        $link = social_link_fix($link);

        if ( ! $link ) 
        { 
            return 'https://' . $site . '.com/' . $link; 
        }

        return $link;
    }
}
