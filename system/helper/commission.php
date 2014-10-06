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
 * Description of commission Class
 *
 * @author ahmet
 */
class Commission {
    
    private $type;
    private $cards = array();
    
    public function __construct($registry) {
        
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->language = $registry->get('language');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card");

        foreach ($query->rows as $result) {
            $this->cards[$result['shortname']] = array(
                'card_id'   => $result['card_id'],
                'name'         => $result['name'],
                'shortname'   => $result['shortname'],
                'image'  => $result['image'],
                'commission' => $result['commission'],
            );
        }
    }
    
    public function calculateIn($amount,$cardtype){
        $commission = $this->getCommissionValueByCardType($cardtype);
        
        $commisionIn = $amount / 100 * $commission;
        
        $total = $amount + $commisionIn;
        
        return $total;
    }


    public function getCommissionValueByCardType($cardtype){
        
        if (!$cardtype) {
            return $this->cards[$cardtype]['commission'];
        } elseif ($cardtype && isset($this->cards[$cardtype])) {
            return $this->cards[$cardtype]['commission'];
        } else {
            return 0;
        }
        
    }
}
