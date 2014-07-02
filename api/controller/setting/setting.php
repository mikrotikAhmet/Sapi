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
 * Description of setting Class
 *
 * @author ahmet
 */
class ControllerSettingSetting extends Controller {

    public function getApplicationSettings() {

        // Cross validation if the request method is GET else it will return "Not Acceptable" status
        if ($this->_api->get_request_method() != "GET") {
            $this->_api->response('', 406);
        }

        $this->load->model('setting/setting');

        $settings = $this->model_setting_setting->getSetting('config');

        /*
         * Check if settings are exist or not
         */
        if ($settings) {

            // If success everythig is good send header as "OK" and return list of users in JSON format
            $this->_api->response(json_encode($settings), 200);
        } else {
            
            $this->_api->response('',204);	// If no records "No Content" status
        }
    }
    
    public function getLanguageByCode(){
        
        // Cross validation if the request method is GET else it will return "Not Acceptable" status
        if ($this->_api->get_request_method() != "GET") {
            $this->_api->response('', 406);
        }
        
        $language_code = $this->config->get('config_admin_language');
        
        $this->load->model('localisation/language');
        
        $language_info = $this->model_localisation_language->getLanguageByCode($language_code);
        
        /*
         * Check if Language is exist or not
         */
        if ($language_info) {

            // If success everythig is good send header as "OK" and return list of users in JSON format
            $this->_api->response(json_encode($language_info), 200);
        } else {
            
            $this->_api->response('',204);	// If no records "No Content" status
        }
    }

}
