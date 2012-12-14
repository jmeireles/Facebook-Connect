<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Provides a driver-based interface for facebook data control.
 *
 * $Id: Facebook.php
 *
 * @package    Facebook
 * @author     Jorge Meireles ( Faianca )
 * @copyright  (c) 20011-2012 Jorge Meireles
 * @license    Open / Free to use :)
 */

// Facebook SDK 
include(APPPATH.'libraries/facebook/facebook.php');

class Facebook_Core extends Facebook{
    
    public $user = null;
    public $user_id = null;
    public $fb = false;
    public $fbSession = false;
    public $appkey = 0;
    public $model;
    
    public function __construct() {
        
        // Load Config 
        $config = faianca::config('facebook');
        parent::__construct($config);
        
        $this->model = new Facebook_Model;
        $this->user_id = $this->getUser();
        $me = null;
        
        if($this->user_id){
            try{
                $me = $this->api('/me');
                $this->user = $me;
            }catch(FacebookApiException $d){
                error_log($e);
            }
        }
    }
   
}