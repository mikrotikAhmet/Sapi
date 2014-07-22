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
 * Description of request Class
 *
 * @author ahmet
 */
class Request {

    public $get = array();
    public $post = array();
    public $put = array();
    public $cookie = array();
    public $files = array();
    public $server = array();

    public function __construct() {
        $_GET = $this->clean($_GET);
        $_POST = $this->clean($_POST);
        $_REQUEST = $this->clean($_REQUEST);
        $_COOKIE = $this->clean($_COOKIE);
        $_FILES = $this->clean($_FILES);
        $_SERVER = $this->clean($_SERVER);

        $this->get = $_GET;
        $this->post = $_POST;
        $this->put = $_POST;
        $this->request = $_REQUEST;
        $this->cookie = $_COOKIE;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        
    }

    public function clean($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                unset($data[$key]);

                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }

}
