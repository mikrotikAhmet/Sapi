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
 * Description of autoloader Class
 *
 * @author ahmet
 */
class Autoloader {

    public function _loadFromArray($class = array()) {

        foreach ($class as $route=>$file){
            
            foreach ($file as $object){
                require_once (DIR_SYSTEM . $route . DS . $object .'.php');
            }
        }
    }
    
    public function _getDeclaredClasses(){
        
        semite_var_dump(get_declared_classes());
    }

}