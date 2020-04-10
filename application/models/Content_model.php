<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Content_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->CI = get_instance();
        $this->CI->config->load('pagination');
    }

    /**
     * This function will return the content from the db
     * If key is not provided, then it will fetch all the records form the table.
     * @param string $key
     * @return mixed
     */
    public function get($data = null, $row = 0) 
    {
        $this->db->select('*')->from('content');

        if (isset($data['safelink'])) 
        {
            $this->db->where('safelink', $data['safelink']); 
        }

        if (isset($data['or_id'])) 
        {
            $this->db->or_where('id', $data['or_id']); 
        }

        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']); 
        }

        if (isset($data['or_safelink'])) 
        {
            $this->db->or_where('safelink', $data['or_safelink']); 
        }

        if (isset($data['priority'])) 
        {
            $this->db->where('priority', $data['priority']); 
        }

        if (isset($data['section'])) 
        {
            $this->db->where('section', $data['section']); 
        }

        if (isset($data['in']) || isset($data['not_in'])) 
        {
            $in = isset($data['in']) ? '1' : '0';
            $where = isset($data['in']) ? 'in' : 'not_in';

            $this->db->where('in_'.$data[$where], $in); 
        }

        if (isset($data['parent'])) 
        {
            if ($data['parent'] == 'non' || $data['parent'] == 'null') 
            {
                $this->db->where('parent IS NULL'); 
                $this->db->or_where('parent', '0'); 
                $this->db->or_where('parent', ''); 
            }
            elseif ($data['parent'] == 'set' || $data['parent'] == 'not_null') 
            {
                $this->db->where('parent IS NOT NULL'); 
                $this->db->where('parent !=', '0'); 
                $this->db->where('parent !=', ''); 
            }
            else
            {
                $this->db->where('parent', $data['parent']); 
            }
        }            

        if (isset($data['page'])) 
        {
            $this->db->limit($this->config->item('per_page'), $data['page']);
        }

        if (!isset($data['safelink']) && !isset($data['id'])) 
        {
            if (isset($data['order_field']))  
            {
                $this->db->order_by('FIELD(`'.$data["order_field"]["name"].'`, "'.$data["order_field"]["id"].'") DESC'); 
            }
            else
            {
                $this->db->order_by('priority ASC');
            }
        }
 
        $query = $this->db->get();
        if (isset($data['safelink']) || isset($data['id']) || $row) 
        {
            return $query->row_array();
        } 
        else 
        {
            return $query->result_array();
        }
    }


    public function get_parent($data = null, $row = 0) 
    {
        $this->db->select('parent')->from('content'); 

        if (isset($data['parent']) && !empty($data['parent'])) 
        {
            $this->db->where('parent', $data['parent']); 
            $this->db->where('parent NOT NUL'); 
        } 

        $this->db->group_by('parent');
        $this->db->order_by('parent DESC');
 
        $query = $this->db->get();
        if (isset($data['safelink']) || isset($data['id'])) 
        {
            return $query->row_array();
        } 
        else 
        {
            return $query->result_array();
        }
    }


    /**
     * This function will take the post data passed from the controller
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('content', $data);
            return $this->db->affected_rows();
        } else {
            $this->db->insert('content', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }   


    /**
     * This function will update the parent for all content when the parent item is updated
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function update_parent($data) 
    {
        if (isset($data['parent'])) {
            $this->db->where('parent', $data['safelink']);
            $this->db->update('content', array('parent' => $data['parent']));
            return $this->db->affected_rows(); 
        }
    }  

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove($data) { 
        if (isset($data['parent'])) {
            $this->db->where('parent', $data['parent']); 
        }

        if (!is_array($data)) {
            $this->db->where('id', $data); 
        }
        $this->db->delete('content');
        return $this->db->affected_rows();
    } 


    /**
     * This function fetch data from the facilities table
     * @param $id
     */
    public function get_facilities($data = null) 
    {
        $this->db->select('*')->from('facilities'); 

        if (isset($data['id'])) 
        {
            $this->db->where('id', $data['id']);  
        } 
 
        $this->db->order_by('id DESC');
 
        $query = $this->db->get();
        if (isset($data['id'])) 
        {
            return $query->row_array();
        } 
        else 
        {
            return $query->result_array();
        }
    }


    /**
     * This function will add new records to the facilities table
     * If id is present, then it will do an update
     * else an insert. One function doing both add and edit.
     * @param $data
     */
    public function add_facility($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('facilities', $data);
            return $this->db->affected_rows();
        } else {
            $this->db->insert('facilities', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }  

    /**
     * This function will delete the record based on the id
     * @param $id
     */
    public function remove_facility($id) {  
        $this->db->where('id', $id);  
        $this->db->delete('facilities');
        return $this->db->affected_rows();
    } 
}
