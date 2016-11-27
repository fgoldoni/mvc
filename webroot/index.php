<?php
 $debut= microtime(true);
    define('WEBROOT',  dirname(__FILE__));
    define('ROOT',  dirname(WEBROOT));
    define('DS',DIRECTORY_SEPARATOR);
    define('CORE',ROOT.DS.'core');
    define('Lien','http://www.fgoldoni.de');
    define('BASE_URL',dirname(dirname($_SERVER['SCRIPT_NAME'])));
    define('IMAGE',dirname(__FILE__).DS.'img');
    require_once CORE.DS.'includes.php';
    new Dispatcher();
    

