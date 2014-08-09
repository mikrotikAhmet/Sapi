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
    
    public function makeTransaction($data, $transaction_id){
        
        $customer_id = $this->getCustomerByCardNumber($data['ACCT']);
        $merchant = $this->checkMerchant($data);
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int) $customer_id . "', transaction_id = '" . (int) $transaction_id . "', `type` = '".$this->db->escape($data['PAYMENTACTION'])."',description = 'REF :" . $this->db->escape($data['CUSTREF']) . "', amount = '-" . (float) $data['AMT'] . "',status = '".(int) $data['PAYMENTSTATUS']."', date_added = NOW()");
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int) $merchant->row['customer_id'] . "', transaction_id = '" . (int) $transaction_id . "',`type` = '".$this->db->escape($data['PAYMENTACTION'])."', description = 'Recieve Payment', amount = '" . (float) $data['AMT'] . "', status = '".(int) $data['PAYMENTSTATUS']."',date_added = NOW()");
        
        return array('status'=>'Success');
    }
    
    public function getCustomerByCardNumber($cc){
        
        $query = $this->db->query("SELECT (customer_id) AS customer FROM ".DB_PREFIX."customer_account WHERE v_card_number = '".  FormatCreditCard($cc)."'");
        
        return $query->row['customer'];
    }
    
    public function pay($data){
        
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer_account WHERE v_card_number = '".  FormatCreditCard($data['ACCT'])."'");
        
        return $query->row;
    }
    
    public function checkMerchant($data){
        
        $merchant_total = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($data['USER'])) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($data['PWD']) . "'))))) OR password = '" . $this->db->escape(md5($data['PWD'])) . "') AND status = '1'");
    
        return $merchant_total;
    }
    
    public function checkKey($merchat,$key){
        
        if ($merchat['approved']){
            $type = 'live';
        } else {
            $type = 'test';
        }
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."customer_account WHERE ".strtolower($type)."_public_key = '".  $this->db->escape($key)."'");
        
        return $query->row['total'];
    }
}


