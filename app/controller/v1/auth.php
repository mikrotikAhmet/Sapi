<?php

if (!defined('DIR_APPLICATION'))
    exit('No direct script access allowed');

/**
 * OGCA
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		Open Gateway Core Application
 * @author		Semite LLC Team
 * @copyright	Copyright (c) 2013 - 10/3/14, Semite LLC..
 * @license		http://www.semiteproject.com/user_guide/license.html
 * @link		http://www.semiteproject.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * @package     Semite LLC
 * @version     $Id: auth.php Oct 4, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of auth  Class
 *
 * @author ahmet
 */
/*
 * Copyright (C) 2014 ahmet
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class ControllerV1Auth extends Controller {

    private $error = array();

    public function getAuthenticated() {

        $json = array();
        
        $data = $this->request->post;
        
        if (isset($this->error['warning'] )) {
            $json['error'] = $this->error;
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
           
           $json['data'] = array(
               'customer_id'=>12,
               'firstname'=>'Ahmet',
               'lastname'=>'Goudenoglu'
           );
           
           $this->_api->processApi($json, 202);
           
        } else {
            $this->error['warning'] = $this->_api->processApi('', 400);
        }
    }

    protected function validateForm() {

        if (!isset($this->request->post['username']) || !isset($this->request->post['password']) || !$this->user->login($this->request->post['username'], $this->request->post['password'])) {
            $this->error['warning'] = $this->_api->processApi('', 203);
        }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}

