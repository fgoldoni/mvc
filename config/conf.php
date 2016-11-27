<?php

class Conf{
    static $debug=1;
    static  $databases=array(
        'default'=>array(
        'host'=>'localhost',
        'database'=>'tuto',
        'login'=>'root',
        'password'=>''
        ),
        'goldo'=>array(
        'host'=>'sql108.hebergratuit.net',
        'database'=>'heber_17319369_tuto',
        'login'=>'heber_17319369',
        'password'=>'Lemessi91'
        ),
        'gold'=>array(
        'host'=>'localhost:3306',
        'database'=>'fgoldonid1_tuto',
        'login'=>'fgoldonid1',
        'password'=>'Lemessi91'
        )
    );
    
    
    
    
}
Router::prefix('goldo','admin');
Router::connect('/','posts/index');

Router::connect('post/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');


//Router::connect('post/:slug-:id','posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
    
