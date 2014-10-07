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
        }
    }

    public function getAllTransactions() {
        $this->load->model('account/customer');

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'GET')) {

            $transactions = $this->model_account_customer->getAllTransactions($params['customer_id']);

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

        $params = $this->request->get;

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            $this->_card->Validate($params['card_number']);

            $card_info = $this->_card->GetCardInfo();

            if ($card_info['status'] == 'invalid') {
                
                $this->_api->processApi($params, 203);
                
            } else {

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
