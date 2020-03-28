<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creative_lib {

    function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->helper('date');
    }

    public function resize_image($src = '', $_config = '')
	{	

		$config['image_library'] 	= isset($_config['image_library']) ? $_config['image_library'] : 'gd2';
		$config['maintain_ratio'] 	= isset($_config['maintain_ratio']) ? $_config['maintain_ratio'] : TRUE;
		$config['width'] 			= isset($_config['width']) ? $_config['width'] : 450;
		$config['height'] 			= isset($_config['height'])? $_config['height'] : 450;
		$config['source_image'] 	= $src;  

		$this->CI->load->library('image_lib', $config);

		if ( ! $this->CI->image_lib->resize())
		{
		    return $this->CI->image_lib->display_errors();
		} 
		else 
		{	
			chmod($config['source_image'],0777);
			return TRUE;
		}

	} 

	public function create_dir($path = '', $error = null) 
	{ 
		if (file_exists($path)) {
			
			if(is_writable($path)) 
			{	
				return TRUE;
			} 
			else 
			{
				return FALSE;
			}
			chmod($path, 0777);
			
		}
		elseif (!$error) 
		{	
			$mkdir = mkdir($path, 0777, TRUE); 
			return $mkdir;
		}
		
		return FALSE;
	}

	public function delete_file($path = '')
	{
		if (file_exists($path) && is_file($path)) {
			chmod($path, 0777);
			return unlink($path);
		}
		return FALSE;
	}

	public function fetch_image($src = '', $type = 1)
	{	  
		if ($src && file_exists('./'.$src)) {
			return base_url().$src;
		} else {
			return base_url().'backend/images/avatar'.$type.'.png';
		}
	}

	public function get_section($name = '', $key = '')
	{
		$section = $this->CI->content_model->get_sections(['name' => $name], true);
		if ($section) {
			if ($key) {
				if (isset($section[$key])) {
					$data = $section[$key];
				} else {
					$data = ucwords($name);
				}
			} else {
				$data = $section;
			}
		} else {
			$data = ucwords($name);
		}
		return $data;
	}

	public function yearly_sales($year = '')
	{

        $year_data = [];
        $years = $this->CI->dashboard_model->sales_stats_year();
        
        if ($years) { 
            foreach ($years as $yd) { 
            	$last_year_stats = $stats_month1 = [];
            	$this_year_stats = $stats_month2 = [];
            	$last_year = $this->CI->dashboard_model->sales_stats(['year' => $yd['last_year']]); 
                $this_year = $this->CI->dashboard_model->sales_stats(['year' => $yd['this_year']]); 
    
            	foreach ($last_year as $lastm) { 
            		$last_year_stats[] .= $lastm['sales'];
            		$stats_month1[] .= '\''.$this->int_to_month($lastm['month']).'\'';
            	}
            	foreach ($this_year as $thism) { 
            		$this_year_stats[] .= $thism['sales'];
            		$stats_month2[] .= '\''.$this->int_to_month($thism['month']).'\'';
            	}
            }
            
            $labels = array_unique(array_merge($stats_month1, $stats_month2));
            $labels = $this->month_rearray($labels);
            $stats_data = 
    	    'data: {
    	        labels: ['.implode(', ',$labels).'],
    	        datasets: [ 
    	        	{     		
    			        backgroundColor: \'#ced4da\',
    			        borderColor    : \'#ced4da\',  
    	        		data: ['.implode(', ', $last_year_stats).']
    	        	},
    	        	{
    			        backgroundColor: \'#007bff\',
    			        borderColor    : \'#007bff\',   
    					data: ['.implode(', ', $this_year_stats).']
    	        	}
    	        ]
    	    }';
    	    
            return $stats_data;
        }
        return;
	}

	public function month_rearray($months = array(), $lt = "'", $rt = "'")
	{	
		$keys = array_values($months);

		if ( in_array( $lt . 'January' . $rt, $keys) or in_array( $lt . 'Jan' . $rt, $keys) ) {
			$key_data[1] 	= $lt . 'January' . $rt;
		}
		if ( in_array( $lt . 'February' . $rt, $keys) or in_array( $lt . 'Feb' . $rt, $keys)  ) {
			$key_data[2] 	= $lt . 'February'.$rt;
		}
		if ( in_array( $lt . 'March' . $rt, $keys)  or in_array( $lt . 'Mar' . $rt, $keys) ) {
			$key_data[3] 	= $lt . 'March'.$rt;
		}
		if ( in_array( $lt . 'April' . $rt, $keys)  or in_array( $lt . 'Apr' . $rt, $keys) ) {
			$key_data[4] 	= $lt . 'April'.$rt;
		}
		if ( in_array( $lt . 'May' . $rt, $keys)  or in_array( $lt . 'May' . $rt, $keys) ) {
			$key_data[5] 	= $lt . 'May'.$rt;
		}
		if ( in_array( $lt . 'June' . $rt, $keys)  or in_array( $lt . 'Jun' . $rt, $keys) ) {
			$key_data[6] 	= $lt . 'June'.$rt;
		}
		if ( in_array( $lt . 'July' . $rt, $keys)  or in_array( $lt . 'Jul' . $rt, $keys) ) {
			$key_data[7] 	= $lt . 'July'.$rt;
		}
		if ( in_array( $lt . 'August' . $rt, $keys)  or in_array( $lt . 'Aug' . $rt, $keys) ) {
			$key_data[8] 	= $lt . 'August'.$rt;
		}
		if ( in_array( $lt . 'September' . $rt, $keys)  or in_array( $lt . 'Sept' . $rt, $keys) ) {
			$key_data[9] 	= $lt . 'September'.$rt;
		}
		if ( in_array( $lt . 'October' . $rt, $keys)  or in_array( $lt . 'Oct' . $rt, $keys) ) {
			$key_data[10] 	= $lt . 'October'.$rt;
		}
		if ( in_array( $lt . 'November' . $rt, $keys)  or in_array( $lt . 'Nov' . $rt, $keys) ) {
			$key_data[11] 	= $lt . 'November'.$rt;
		}
		if ( in_array( $lt . 'December' . $rt, $keys)  or in_array( $lt . 'Dec' . $rt, $keys) ) {
			$key_data[12] 	= $lt . 'December'.$rt;
		}

    	return array_values($key_data);
		
	}

	public function int_to_month($int = 1, $short = False) 
	{
		switch ($int) {
			case 1:
				$month = 'January';
				break;
			case 2:
				$month = 'February';
				break;
			case 3:
				$month = 'March';
				break;
			case 4:
				$month = 'April';
				break;
			case 5:
				$month = 'May';
				break;
			case 6:
				$month = 'June';
				break;
			case 7:
				$month = 'July';
				break;
			case 8:
				$month = 'August';
				break;
			case 9:
				$month = 'September';
				break;
			case 10:
				$month = 'October';
				break;
			case 11:
				$month = 'November';
				break;
			
			default:
				$month = 'December';
				break;
		}

		if ($short) {
			return date('M', strtotime($month));
		}
		return $month;
	}

}
