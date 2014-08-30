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
        
        $customer = $this->getCustomerByCardNumber($data['ACCT']);
        $merchant = $this->checkMerchant($data);
        
        
        if ($this->config->get('config_transaction_autocapture')){
            $capture = $this->config->get('config_complete_transaction_status_id');
        } else {
            $capture = $this->config->get('config_transaction_status_id');
        }
        
//        if ($merchant['approved']){
            $mode = true;
//        } else {
//            $mode = false;
//        }
        
        if($mode){
        
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int) $customer->row['customer_id'] . "',card_type='semitecard', card_number = '".$this->db->escape(MaskCreditCard($data['ACCT']))."',transaction_id = '" . (int) $transaction_id . "', `type` = '".$this->db->escape($data['PAYMENTACTION'])."',description = 'PY_REF :" . $this->db->escape($data['CUSTREF']) . "/n/PY_ACC : ".$customer->row['account_number']."/n/ST_URL : ".$this->db->escape($data['STRURL'])."/n/STR : ".$this->db->escape($data['STR'])."', amount = '-" . (float) $data['AMT'] . "',status = '".(int) $capture."', date_added = NOW()");
        
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int) $merchant->row['customer_id'] . "',card_type='semitecard', card_number = '".$this->db->escape(MaskCreditCard($data['ACCT']))."',transaction_id = '" . (int) $transaction_id . "',`type` = '".$this->db->escape($data['PAYMENTACTION'])."', description = 'PY_REF :" . $this->db->escape($data['CUSTREF']) . "/n/PY_ACC : ".$merchant->row['account_number']."/n/ST_URL : ".$this->db->escape($data['STRURL'])."/n/STR : ".$this->db->escape($data['STR'])."', amount = '" . (float) $data['AMT'] . "', status = '".(int) $capture."',date_added = NOW()");
        
            return array('status'=>'Success');
        } else {
        
            return array('status'=>'Test');
        }
    }
    
    public function getCustomerByCardNumber($cc){
        
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer_account WHERE v_card_number = '".  FormatCreditCard($cc)."'");
        
        return $query;
    }
    
    public function pay($data){
        
        $query = $this->db->query("SELECT * FROM ".DB_PREFIX."customer_account WHERE v_card_number = '".  FormatCreditCard($data['ACCT'])."'");
        
        return $query->row;
    }
    
    public function checkMerchant($data){
        
        $merchant_total = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN ".DB_PREFIX."customer_account ca ON(c.customer_id = ca.customer_id) WHERE LOWER(c.email) = '" . $this->db->escape(utf8_strtolower($data['USER'])) . "' AND (c.password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($data['PWD']) . "'))))) OR c.password = '" . $this->db->escape(md5($data['PWD'])) . "') AND c.status = '1'");
    
        return $merchant_total;
    }
    
    public function checkKey($merchant,$key){
        
//        if ($merchant['approved']){
//            $type = 'live';
//        } else {
//            $type = 'test';
//        }
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM ".DB_PREFIX."customer_account WHERE live_public_key = '".  $this->db->escape($key)."'");
        
        return $query->row['total'];
    }
}


