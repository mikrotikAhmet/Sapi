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

// Version
define('_ENGINE_VER','1.5.5.1');

// Basic setup

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('PS') || define('PS', PATH_SEPARATOR);


defined('_ENGINE') || define('_ENGINE', true);
defined('_ENGINE_REQUEST_START') ||
        define('_ENGINE_REQUEST_START', microtime(true));
defined('APPLICATION_PATH_COR') ||
        define('APPLICATION_PATH_COR', realpath(dirname(__DIR__)) . '/');

// Configuration
if (file_exists ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . 'system/config/app.php')){
    require_once ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'system/config/app.php');
} else {
    trigger_error('Configuration file could not be located!');
}

// Startup
if (file_exists ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR . 'system/startup.php')){
    require_once ($_SERVER['DOCUMENT_ROOT']. DIRECTORY_SEPARATOR .'system/startup.php');
} else {
    trigger_error('Start Up file could not be located!');
}

// Registry
$registry = new Registry();


// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

// Application Settings

// Url
$url = new Url(HTTP_SERVER, $config->get('config_secure') ? HTTPS_SERVER : HTTP_SERVER);	
$registry->set('url', $url);

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response); 

// RestFull API Response
$api = new Api($registry);
$registry->set('_api', $api);

// Cache
$cache = new Cache();
$registry->set('cache', $cache); 

// Session
$session = new Session();
$registry->set('session', $session); 

// Front Controller
$controller = new Front($registry);

// Router
if (isset($request->get['route'])) {
	$action = new Action($request->get['route']);
} else {
	$action = new Action('vi');
}
//
//// Dispatch
$controller->dispatch($action, new Action('error/not_found'));


// Output
$response->output();

