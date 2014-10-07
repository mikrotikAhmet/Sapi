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
 * @version     $Id: customer.php Oct 5, 2014 ahmet
 */

/**
 * OGCA - Open Gateway Core Application
 * Description of customer  Class
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

class ModelAccountCustomer extends Model{
    
    public function checkCustomer($customer_id,$merchat_id, $api_key){
        
        $customer = $this->db->query("SELECT (customer_id) AS total FROM ".DB_PREFIX."customer WHERE customer_id = '".(int) $customer_id."' AND merchant_id = '".(int) $merchat_id."' AND api_key = '".$this->db->escape($api_key)."'");
        
        return $customer->row['total'];
        
    }
    
    public function getCustomer($customer_id){
        $result = $this->db->query("SELECT * FROM ".DB_PREFIX."customer WHERE customer_id = '".(int) $customer_id."'");
        
        return $result->row;
    }
    
    public function getAllTransactions($customer_id){
        $sql = "SELECT *  FROM ".DB_PREFIX."customer_transaction ct LEFT JOIN ".DB_PREFIX."transaction_order to ON(ct.transaction_order_id = to.transaction_order_id) WHERE ct.customer_id = '".(int) $customer_id."' ORDER BY ct.date_added DESC";
        
        $transactions = $this->db->query($sql);
        
        return $transactions->rows;
    }
    
    public function getCards($customer_id){
        $sql = "SELECT * FROM " . DB_PREFIX . "customer_card cd LEFT JOIN ".DB_PREFIX."card c ON(cd.`type` = c.shortname) WHERE cd.customer_id = '" . (int) $customer_id . "' AND verified = '1'";
        
        $cards = $this->db->query($sql);
        
        return $cards->rows;
    }
    
    public function getLastTransactions($customer_id){
        $sql = "SELECT * FROM ".DB_PREFIX."customer_transaction ct LEFT JOIN ".DB_PREFIX."transaction_order `to` ON(ct.transaction_order_id = `to`.transaction_order_id) WHERE ct.customer_id = '".(int) $customer_id."' ORDER BY ct.date_added DESC LIMIT 0,10";
        
        $transactions = $this->db->query($sql);
        
        return $transactions->rows;
    }
    
    public function getBalance($cutomer_id){
        
        $balance = $this->db->query("SELECT SUM(amount) AS balance FROM ".DB_PREFIX."customer_transaction WHERE customer_id = '".(int) $cutomer_id."'");
        
        return $balance->row;
    }
    
    public function getCardCommission($card_id){
        $result = $this->db->query("SELECT (c.commission) AS commission FROM ".DB_PREFIX."customer_card cd LEFT JOIN ".DB_PREFIX."card c ON(cd.`type` = c.shortname) WHERE cd.customer_card_id = '".(int) $card_id."'");
        
        return $result->row['commission'];
    }
    
    public function getCustomerCard($customer_card_id){
        $result = $this->db->query("SELECT * FROM ".DB_PREFIX."customer_card WHERE customer_card_id = '".(int) $customer_card_id."'");
        
        return $result->row;
    }
    
    public function addCard($data = array()){
        
        $this->db->query("INSERT INTO ".DB_PREFIX."customer_card SET cardholder = '".$this->db->escape($data['cardholder'])."', card_number = '".$this->db->escape($data['substring'])."', hex = '".$this->db->escape($data['hex'])."', expiry_date = '".$this->db->escape($data['expiryDate'])."', cvv = '".(int) $data['cvv']."', `type` = '".$this->db->escape($data['type'])."', customer_id = '".(int) $data['reference']."'");
    }
}

