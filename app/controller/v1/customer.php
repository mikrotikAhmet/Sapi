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

    public function getAll() {

        $this->load->model('test/test');

        $results = $this->model_test_test->getList();

        if ($results) {
            $this->_api->processApi($results, 200);
        } else {
            $this->_api->processApi('', 204);
        }
    }

    public function getCustomer() {

        $this->load->model('test/test');

        if (isset($this->request->get['id'])) {
            $result = $this->model_test_test->getSingle($this->request->get['id']);

            if ($result) {
                $this->_api->processApi($result, 200);
            } else {
                $this->_api->processApi('', 404);
            }
        } else {
            $this->_api->processApi('', 400);
        }
    }

}
