<?php

class Conf{
    static $debug=1;
    static  $databases=array(
        'default'=>array(
        'host'=>'localhost',
        'database'=>'tuto',
        'login'=>'root',
        'password'=>''
        )
    );
    
    
    
    
}
Router::prefix('goldo','admin');
Router::connect('/','posts/index');

Router::connect('post/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');


//Router::connect('post/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
    
