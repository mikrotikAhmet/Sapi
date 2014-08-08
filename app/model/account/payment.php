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
 * Description of payment Class
 *
 * @author ahmet
 */
class ModelAccountPayment extends Model{
    
    public function pay($data){
        
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer_account WHERE v_card_number = '".  FormatCreditCard($data['ACCT'])."'");
        
        return $query->row;
    }
}
