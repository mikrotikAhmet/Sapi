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
class ControllerV1Customer extends Controller {

    private $api_data = array();

    public function getLastTransactions() {
        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'GET')) {

            $transactions = $this->model_account_customer->getLastTransactions($params['customer_id']);

            $params['data'] = $transactions;

            $this->_api->processApi($params, 200);
        } else {
            $this->_api->processApi($params, 405);
        }
    }

    public function getAllTransactions() {
        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $transactions = $this->model_account_customer->getAllTransactions($params);
            
            $params['data'] = $transactions;

            $this->_api->processApi($params, 200);
        } else {
            $this->_api->processApi($params, 405);
        }
    }

    public function getCards() {

        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'GET')) {

            $cards = $this->model_account_customer->getCards($params['customer_id']);

            $params['data'] = $cards;

            $this->_api->processApi($params, 200);
        } else {
            $this->_api->processApi($params, 405);
        }
    }

    public function addCard() {

        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $this->_card->Validate($this->request->post['card_number']);

            $card_info = $this->_card->GetCardInfo();

            if ($card_info['status'] == 'invalid') {

                $this->_api->processApi($params, 203);
            } else {

                $customer_info = $this->model_account_customer->getCustomer($params['customer_id']);

                $card_info['cardholder'] = $customer_info['firstname'] . ' ' . strtoupper($customer_info['lastname']);
                $card_info['cvv'] = $this->request->post['cvv'];
                $card_info['expiryDate'] = $this->request->post['year'] . '-' . $this->request->post['month'];
                $card_info['reference'] = $params['customer_id'];
                $card_info['hex'] = $this->encryption->encrypt($this->request->post['card_number']);

                $this->model_account_customer->addCard($card_info);
                $this->_api->processApi($params, 200);
            }
        } else {
            $this->_api->processApi($params, 405);
        }
    }

    public function getBalance() {

        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'GET')) {

            $balance = $this->model_account_customer->getBalance($params['customer_id']);

            $params['data'] = $balance;

            $this->_api->processApi($params, 200);
        } else {
            $this->_api->processApi($params, 405);
        }
    }

}
