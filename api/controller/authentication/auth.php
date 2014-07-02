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
 * Description of auth Class
 *
 * @author ahmet
 */
class ControllerAuthenticationAuth extends Controller{
    
    public function user(){
        
        if ($this->_api->get_request_method() != "GET") {
            $this->_api->response('', 406);
        }
        
       
        $username = 'ahmet.gudenoglu@gmail.com';
        $password = '12344';
        
        $customer_info = array();
        
        $auth = $this->customer->login($username, '1234');
        
        if ($auth) {
            
            $customer_info = array(
                'customer_id'=>$this->customer->getId(),
                'firstname'=>$this->customer->getFirstName(),
                'lastname'=>$this->customer->getLastName(),
                'email'=>$this->customer->getEmail(),
                'telephone'=>$this->customer->getTelephone(),
                'fax'=>$this->customer->getFax(),
                'newsletter'=>$this->customer->getNewsletter(),
                'customer_group_id'=>$this->customer->getCustomerGroupId(),
                'address_id'=>$this->customer->getAddressId(),
                'balance'=>$this->currency->format($this->customer->getBalance(), $this->config->get('config_currency'))
            );
            
            $this->_api->response(json_encode($customer_info), 200);
        } else {
            $this->_api->response('No Auth', 503);
        }
    }
}
