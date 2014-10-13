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

    public function processPayment() {
        
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
            
            $customer_info = $this->model_account_customer->getCustomer($params['customer_id']);
            
            $params['conversion_value'] = $this->currency->getValueById($customer_info['currency_id']);
            
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
            
            $commisionIn = $this->request->post['amount'] / 100 * $params['commission'];
        
            $params['total'] = $this->request->post['amount'] + $commisionIn;
            $params['comm_net'] = $commisionIn;

            $this->model_account_payment->makeDeposit($params);
            
            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');							
            $mail->setTo("ahmet.gudenoglu@semitepayment.com");
            $mail->setFrom("ahmet.gudenoglu@semitepayment.com");
            $mail->setSender("Semite LLC");
            $mail->setSubject(html_entity_decode("Depost Success!", ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode("Thank you man!", ENT_QUOTES, 'UTF-8'));
            $mail->send();

            $this->_api->processApi($params, 202);
        } else {
            $this->_api->processApi($params, 405);
        }
    }
    
        public function processRefund(){}

}
