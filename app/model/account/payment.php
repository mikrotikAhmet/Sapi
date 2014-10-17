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
    
    public function makeDeposit($data){
        
        $invoice_no = $this->_key->generate(8);
        
        $this->db->query("INSERT INTO ".DB_PREFIX."transaction_order SET invoice_no = '".(int) $invoice_no."', invoice_prefix = '".$this->config->get('config_invoice_prefix')."',customer_id = '".(int) $data['customer_id']."', total = '".(float) $data['total']."', commission = '".(float) $data['commission']."',commission_net = '".(float) $data['comm_net']."', language_id = '".(int) $data['language_id']."', currency_id = '".(int) $data['currency_id']."', currency_code = '".$this->db->escape($data['currency_code'])."', currency_value = '".(float) $data['currency_value']."', conversion_value = '".(float) $data['conversion_value']."',service_type='".$this->db->escape($data['service_type'])."',action_type='".$this->db->escape($data['action_type'])."',description='".$this->db->escape($data['description'])."',ip = '".$this->db->escape($data['ip'])."',forwarded_ip = '".$this->db->escape($data['forwarded_ip'])."',user_agent = '".$this->db->escape($data['user_agent'])."',accept_language = '".$this->db->escape($data['accept_language'])."', date_added = NOW(),status = '".(int) $this->config->get('config_complete_status_id')."'");
        
        $transaction_order_id = $this->db->getLastId();
        
        $this->db->query("INSERT INTO ".DB_PREFIX."customer_transaction SET customer_id = '".(int) $data['customer_id']."',transaction_order_id = '".(int) $transaction_order_id."', amount = '".(float) $data['amount']."', date_added = NOW()");
    }

	public function makeRefund($data){

		$this->db->query("UPDATE ".DB_PREFIX."transaction_order SET status = '".(int) $data['transaction_status']."' WHERE transaction_order_id = '".(int) $data['transaction']."'");
	}
    
}


