<?php

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
 * Description of user Class
 *
 * @author ahmet
 */
class ModelUsersUser extends Model{
    
    
    public function getUser($user_id){
        
        $result = $this->registry->get('db')->query("SELECT * FROM ".DB_PREFIX."user WHERE user_id = '".(int) $user_id."'");
        
        return $result->row;
    }
    
    
    public function getUsers(){
        
        $results = $this->registry->get('db')->query("SELECT * FROM ".DB_PREFIX."user");
        
        return $results->rows;
    }
}
