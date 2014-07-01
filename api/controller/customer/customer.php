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
 * Description of customer Class
 *
 * @author ahmet
 */
class ControllerCustomerCustomer extends Controller{
    
    
    public function customers(){
        
        $json = array();
        
        $this->load->model('account/customer');
        
        $results = $this->model_account_customer->getCustomers();

        $this->data['data'] = json_encode($results);
        
        $this->template = 'proxy/rest.tpl';

        $this->response->setOutput($this->render());
    }
}
