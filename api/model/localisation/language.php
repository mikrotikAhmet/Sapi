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
 * Description of language Class
 *
 * @author ahmet
 */
class ModelLocalisationLanguage extends Model{
    
    public function getLanguageByCode($language_code) {
        
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "language WHERE `code` = '" . $this->db->escape($language_code) . "'");

        return $query->row;
    }
}
