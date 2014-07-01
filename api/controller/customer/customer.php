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
class ControllerCustomerCustomer extends Controller {

    public function customer() {

        $json = array();

        if ($this->_api->get_request_method() != "GET" || !isset($this->request->get['cid'])) {
            $this->_api->response('', 406);
        }
        
        $customer_id = $this->request->get['cid'];
        
        $this->load->model('account/customer');

        $results = $this->model_account_customer->getCustomer($customer_id);

        if (!$results) {
            $this->_api->response('', 204);
        } else {
            $this->_api->response(json_encode($results), 200);
        }
    }
    
    public function customerCards() {

        $json = array();

        if ($this->_api->get_request_method() != "GET" || !isset($this->request->get['cid'])) {
            $this->_api->response('', 406);
        }
        
        $customer_id = $this->request->get['cid'];
        
        $this->load->model('account/customer');

        $results = $this->model_account_customer->getCustomerCards($customer_id);

        if (!$results) {
            $this->_api->response('', 204);
        } else {
            $this->_api->response(json_encode($results), 200);
        }
    }
    
    public function customerBanks() {

        $json = array();

        if ($this->_api->get_request_method() != "GET" || !isset($this->request->get['cid'])) {
            $this->_api->response('', 406);
        }
        
        $customer_id = $this->request->get['cid'];
        
        $this->load->model('account/customer');

        $results = $this->model_account_customer->getCustomerBanks($customer_id);

        if (!$results) {
            $this->_api->response('', 204);
        } else {
            $this->_api->response(json_encode($results), 200);
        }
    }

}
