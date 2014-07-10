<?php

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
require_once '../library/Semite.php';

// This snippet (and some of the curl code) due to the Facebook SDK.
if (!function_exists('curl_init')) {
    throw new Exception('Stripe needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
    throw new Exception('Stripe needs the JSON PHP extension.');
}
if (!function_exists('mb_detect_encoding')) {
    throw new Exception('Stripe needs the Multibyte String PHP extension.');
}

// Semite API Resources
require('../library/Semite/Users.php');

class Api extends Semite {

    private $function;
    

    public function __construct() {
        parent::__construct();    // Init parent contructor
        
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rq'])));
        if ((int) method_exists($this, $func) > 0) {

            if (isset($_GET['route']) && ($this->get_request_method() == "GET" || $this->get_request_method() == "DELETE")) {

                $arg = $_GET;
                $this->$func($arg);
            } else {
                $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
            }

            if ($this->get_request_method() == "POST") {

                $arg = $_POST;
                $this->$func($arg);
            } else {
                $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
            }
        } else {
            $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
        }
    }

    private function _requestAPI($arg) {

        $getRoute = explode('/', $arg['route']);

        require_once '../library/' . ucfirst($getRoute[0]) . '/' . ucfirst($getRoute[1]) . '.php';

        $class = ucfirst($getRoute[1]);

        $method = $getRoute[2];

        $object = new $class();

        $object->$method($arg);
    }

}

// Initiiate Library

$api = new API;
$api->processApi();

/*
 * Sample GET Request : http://api.semitepayment.com/v1/_requestAPI?route=semite/users/getUsers&id=12
 */


