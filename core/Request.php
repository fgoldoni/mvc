<?php

class Request{
    
    var $url;
    var $page=1;
    public $data=false;
    public $prefix=false;
       function __construct() {

        $this->url=  isset($_SERVER['PATH_INFO'])? $_SERVER['PATH_INFO']: '/products';
        if(isset($_GET['page'])){
            if(is_numeric($_GET['page'])){
                if($_GET['page']>0){
                  $this->page=  round($_GET['page']);  
                }
                
            }
        }
        if(isset($_GET['search'])){
            if($_GET['search']){
                  $this->repeat_search=$_GET['search'];
                
            }
        }
        if (!empty($_POST)) {
            $this->data=  new stdClass();
            foreach ($_POST as $k => $v) {
                $this->data->$k=$v;
                
            }
            
        }
    }
    
    
    
}