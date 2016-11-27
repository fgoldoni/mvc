<?php

class Session{
    public function __construct() {
        if(!isset($_SESSION['flash'])) session_start();
        if(!isset($_SESSION['panier'])){
            $_SESSION['panier']=array();
        }
    }
    public function setFlash($message,$type='success'){
        $_SESSION['flash']=array(
            'message'=>$message,
            'type' =>$type
        );
    }
    public function flash(){
        if(isset($_SESSION['flash'])&&!empty($_SESSION['flash']['message'])){
           $html= '<div class="alert  alert-'.$_SESSION['flash']['type'].'"><p>'.$_SESSION['flash']['message'].'</p></div>';
           $_SESSION['flash']=array();
           return $html;
            
        }
    }
    public function write($key,$value){
        $_SESSION[$key]=$value;
    }
    public function read($key=null){
        if($key){
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            }  else {
                return false;
            }
            
        }else{
            return $_SESSION;
        }
    }
    public function isLogged(){
        return isset($_SESSION['User']->role);
    }
    
    public function user($key){
        if(isset($this->read('User')->$key)){
            return $this->read('User')->$key;
        }  else {
            return false;    
        }
        return false;
    }
    public function add($product_id){
    if(isset($_SESSION['panier'][$product_id])){
        $_SESSION['panier'][$product_id]++;
    }  else {
        $_SESSION['panier'][$product_id]=1; 
    }
    }
    public function del($product_id) {       
    unset($_SESSION['panier'][$product_id]);
    }
    public function count() {        
        return array_sum($_SESSION['panier']); 
    }
    
    
   

}