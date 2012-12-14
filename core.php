<?php
defined('SYSPATH') OR die('No direct access allowed.');

/**
 * @package    Core
 * @author     Jorge Meireles
 * @copyright  (c) 2011-2012 Jorge Meireles
 * @license    Le Free to Use 
 */
Class Core_Controller extends Controller {
    
    protected $facebook;
    protected $model;
    
    public function __construct(){
        parent::__construct();
        
        $this->facebook = new Facebook_Core();
        $this->model = new Facebook_Model;
    }
  
    
    public function facebook_request(){
       
        $data = array(
            'redirect_uri' => url::site('core/handle_facebook_login', 'http'),
            'scope' => 'email'
        );
        
        url::redirect($this->facebook->getLoginUrl($data));
    }
    
    public function handle_facebook_login() {

        if ($this->facebook->getUser()) {
            
            // Check if user exists / Register if don't
            if ($this->model->is_member($this->facebook->getUser())) {
                $this->model->login($this->facebook->getUser());
            } else {
                $this->model->facebook_register($this->facebook->getUser());
            }
            
        } else {
            echo 'Problem handle';
            exit;
        }
    }
    
    public function logout(){
        Auth::instance()->logout();
        url::redirect('/');
    }
    
}
