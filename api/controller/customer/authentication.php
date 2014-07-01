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
 * Description of authentication Class
 *
 * @author ahmet
 */
class ControllerCustomerAuthentication extends Controller{
    
    
    public function index(){
        
        $json = array();
        
        if (isset($this->request->get['status']) && $this->request->get['status'] == 1){
            $json[] = array(
                'status'=>'OK'
             );
        }
        
        $json[] = array(
            'id'=>1,
            'name'=>'Ahmet'
        );
        
        $this->data['data'] = json_encode($json);
        
        $this->template = 'proxy/rest.tpl';

        $this->response->setOutput($this->render());
    }
}
