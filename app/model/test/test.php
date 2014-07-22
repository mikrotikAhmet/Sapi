<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Description of test Class
 *
 * @author ahmet
 */
class ModelTestTest extends Model{
    
    public function getSingle($id){
        
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer WHERE customer_id = '".(int) $id."'");
        
        return $query->row;
    }
    
    public function getList(){
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer");
        
        return $query->rows;
    }
    
}
