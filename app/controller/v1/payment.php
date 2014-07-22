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
 * Description of payment Class
 *
 * @author ahmet
 */
class ControllerV1Payment extends Controller {

    public function pay() {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $results = array(
                'data'=>$_POST
            );

            if ($results) {
                $this->_api->processApi($results, 200);
            } else {
                $this->_api->processApi('', 204);
            }
        } else {
            $this->_api->processApi('', 400);
        }
            
    }

}
