<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Facebook Model.
 *
 * $Id: Model/Facebook.php
 *
 * @package    Facebook_Model
 * @author     Jorge Meireles ( Faianca )
 * @copyright  (c) 20011-2012 Jorge Meireles
 * @license    Open / Free to use :)
 */

class Facebook_Model extends Model {

    protected $db;
    protected $auth;
    
    public function __construct() {
        parent::__construct();
        $this->auth = Auth::instance();
    }
    
    public function is_member($user){
        
        $user =  ORM::factory('user')->where('email', $user['email'])->find();
        
        if($user->loaded == true){
            return true;
        }else{
            return false;
        }
    }
    
    public function facebook_register($fbuser){
       
        
        $location = (isset($fbuser['location']['name'])) ? $fbuser['location']['name'] : '';
        $hometown = (isset($fbuser['hometown']['name'])) ? $fbuser['hometown']['name'] : '';
        
        $user = ORM::factory('user');
        $user->username = $fbuser['username'];
        $user->email = $fbuser['email'];
        $user->first_name = $fbuser['first_name'];
        $user->last_name = $fbuser['last_name'];
        $user->hometown = $hometown;
        $user->location = $location;
        $user->gender = $fbuser['gender'];
        $user->facebook_id = $fbuser['id'];
        $user->facebook_link = $fbuser['link'];
        $password = '';// GENERATE PASSWORD HERE ;
        $user->password = $this->auth->hash_password($password);
        
        if ($user->add(ORM::factory('role', 'login')) AND $user->save()) {

            // login using the collected data
            $this->auth->login($fbuser['username'], $fbuser['id']);
            url::redirect('');
        } 
        
    }
    
    public function login($user){
        
        $this->auth->login($user['username'], $user['id'], TRUE);
        url::redirect('');
    }
    
}