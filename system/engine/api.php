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
 * Description of api Class
 *
 * @author ahmet
 */
class Api extends REST {
    

    public function __construct($registry) {
        $this->db = $registry->get('db');
        $this->load = $registry->get('load');

        $this->load->model('account/customer');
        
        $this->customer = new ModelAccountCustomer($registry);
    }

    public function processApi($data, $status) {

        $check_customer = $this->customer->checkCustomer($data['customer_id'],$data['merchant_id'],$data['api_key']);

        $data = $this->clearData($data);
        
        if ($check_customer){
            $key = true;
        } else {
            $key = false;
        }

        if (!$key) {
            
            $status = 401;
            
            $auth['code'] = $status;
            $auth['status'] = $this->getStatusMessage($status);

            $this->response($this->json($auth), $status);
        }
        if (isset($data) && !empty($data)) {

            $data['code'] = $status;
            $data['status'] = $this->getStatusMessage($status);

            $this->response($this->json($data), $status);
            
        } else {
            
            $error['code'] = $status;
            $error['status'] = $this->getStatusMessage($status);

            $this->response($this->json($error), $status);
        }
    }

    public function getStatusMessage($code) {

        $status = array(
            90 => 'Success',
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Merchant ID not found',
            507 => 'API key is invalid',
            );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

	public function clearData($data){

		unset(
			$data['api_key'],
			$data['merchant_id'],
			$data['customer_id'],
			$data['route']
		);

		return $data;
	}

    private function json($data) {

        if (is_array($data)) {
            return json_encode($data);
        }
    }

}
