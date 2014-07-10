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
 * Description of Users Class
 *
 * @author ahmet
 */


class Users extends Semite{
    
    public function getUsers($arg) {
        
       // Cross validation if the request method is GET else it will return "Not Acceptable" status
        if($this->get_request_method() != "GET"){
                $this->response('',406);
        }
        
        $result = $arg;
                        
        if($result){


                // If success everythig is good send header as "OK" and return list of users in JSON format
                $this->response($this->json($result), 200);
        }
        $this->response('',204);	// If no records "No Content" status
    }
}
