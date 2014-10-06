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
        
        $this->load->model('account/customer');
        $this->load->model('account/payment');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $params['card'] = $this->request->post['card'];
            $params['amount'] = $this->request->post['amount'];

            $params['language_id'] = $this->config->get('config_language_id');
            $params['currency_id'] = $this->currency->getId();
            $params['currency_code'] = $this->currency->getCode();
            $params['currency_value'] = $this->currency->getValue($this->currency->getCode());
            $params['ip'] = $this->request->server['REMOTE_ADDR'];

            if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                $params['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                $params['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
            } else {
                $params['forwarded_ip'] = '';
            }

            if (isset($this->request->server['HTTP_USER_AGENT'])) {
                $params['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
            } else {
                $params['user_agent'] = '';
            }

            if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                $params['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
            } else {
                $params['accept_language'] = '';
            }
            
            $params['service_type'] = $this->language->get('text_transaction');
            $params['action_type'] = $this->language->get('text_deposit');
            
            if (isset($params['card']) || $params['card']){
                $customer_card = $this->model_account_customer->getCustomerCard($this->request->post['card']);
                
                $params['description'] = sprintf($this->language->get('text_deposit_card_description'),$customer_card['card_number']);
            }
            
            // Get Card Commission
            $params['commission'] = $this->model_account_customer->getCardCommission($this->request->post['card']);

            $this->model_account_payment->makeDeposit($params);

            $this->_api->processApi($params, 202);
        }
    }

}
