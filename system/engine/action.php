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
 * Description of action Class
 *
 * @author ahmet
 */
final class Action {

    protected $file;
    protected $class;
    protected $method;
    protected $args = array();

    public function __construct($route, $args = array()) {
        $path = '';

        $parts = explode('/', str_replace('../', '', (string) $route));

        foreach ($parts as $part) {
            $path .= $part;

            if (is_dir(DIR_APPLICATION . 'controller/' . $path)) {
                $path .= '/';

                array_shift($parts);

                continue;
            }

            if (is_file(DIR_APPLICATION . 'controller/' . str_replace(array('../', '..\\', '..'), '', $path) . '.php')) {
                $this->file = DIR_APPLICATION . 'controller/' . str_replace(array('../', '..\\', '..'), '', $path) . '.php';

                $this->class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $path);

                array_shift($parts);

                break;
            }
        }

        if ($args) {
            $this->args = $args;
        }

        $method = array_shift($parts);

        if ($method) {
            $this->method = $method;
        } else {
            $this->method = 'index';
        }
    }

    public function getFile() {
        return $this->file;
    }

    public function getClass() {
        return $this->class;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getArgs() {
        return $this->args;
    }

}
