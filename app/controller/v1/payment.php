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

            $data = $this->request->post;
            
            $this->load->model('account/payment');
            
            $result = $this->model_account_payment->pay($data);
                        
            $result['M_SK'] = $data['M_SK'];
            
            if ($result) {
                $this->_api->processApi($result, 200);
            } else {
                $this->_api->processApi('', 204);
            }
        } else {
            $this->_api->processApi('', 400);
        }
            
    }

}
