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
class ControllerV1Payment extends Controller {
    
    private $error = array();

    public function pay() {
               
        
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validatePayment()) {
            
            $digits = 7;
            $transaction_id = rand(pow(10, $digits-1), pow(10, $digits)-1);
            
            $this->load->model('account/payment');
            
          $this->model_account_payment->makeTransaction($this->request->post,$transaction_id);
            
                $this->_api->processApi('', 90);
        } else {
            
            $this->_api->processApi('', 400);
        }
            
    }
    
    protected function validatePayment(){
        
        $this->load->model('account/payment');
        
        if (empty($this->request->post['ACCT'])){
            $this->_api->processApi('', 900);
        }
        
        if (empty($this->request->post['CVV2'])){
            $this->_api->processApi('', 901);
        }
        
        if (empty($this->request->post['EXPDATE'])){
            $this->_api->processApi('', 902);
        }
        
        $results = $this->model_account_payment->pay($this->request->post);
        
        if ($results){
                
                $key = $this->model_account_payment->checkKey($results, $this->request->post['SIGNATURE']);
                
                if (!$key){
                    $this->_api->processApi('', 903);
                }
                
                $merchant = $this->model_account_payment->checkMerchant($this->request->post);
                
                
                if (!$merchant->num_rows){
                    $this->_api->processApi('',904);
                }
                
                if ($this->request->post['CVV2'] != $results['v_card_ccv']){
                    $this->_api->processApi('',901);
                }
                
                $exp_date_trim = explode('-', $results['date_expire']);
                $expdt = $exp_date_trim[1].$exp_date_trim[0];
                
                if ($this->request->post['EXPDATE'] != $expdt){
                    $this->_api->processApi('',906);
                }
                
                if ($results['balance'] < $this->request->post['AMT']){
                    $this->_api->processApi('',905);
                }
                
            } else {
                $this->_api->processApi('',406 );
            }
        
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

}
