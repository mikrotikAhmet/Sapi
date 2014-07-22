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
 * @package     EGC Services Ltd
 * @version     $Id: index.php Jul 17, 2014 ahmet
 * @copyright   Copyright (c) 2014 EGC Services Ltd .
 * @license     http://www.egamingc.com/license/
 */
/**
 * Description of index.php
 *
 * @author ahmet
 */

// Constants
define('_ENGINE_R_BASE', dirname($_SERVER['SCRIPT_NAME']));
define('_ENGINE_R_FILE', $_SERVER['SCRIPT_NAME']);
define('_ENGINE_R_REL', 'app');
define('_ENGINE_R_TARG', 'index.php');

// Main
include dirname(__FILE__) . DIRECTORY_SEPARATOR
  . _ENGINE_R_REL . DIRECTORY_SEPARATOR
  . _ENGINE_R_TARG;