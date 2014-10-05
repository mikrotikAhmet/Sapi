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
    
    private $error = array();

    public function pay() {
               
        $this->load->model('account/payment');
        
        $params = $this->request->get;
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            
            $params['card'] = $this->request->post['card'];
            $params['amount'] = $this->request->post['amount'];
            
            $this->model_account_payment->makeDeposit($params);
            
            $this->_api->processApi($params, 202);
        }
    }

}
