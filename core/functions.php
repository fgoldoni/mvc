<?php
function debug($var){
    
    $debug = debug_backtrace();
    echo '<p>&nbsp;</p>
    <p><a href="#" style=margin-top:300px;">
    <strong>'.$debug[0]['file'].'</strong> l.'.$debug[0]['line'].'</a></p>';
    echo '<ol style="color:blue;overflow: scroll;width:350px;margin-top:10px;">';
   
    foreach ($debug as $k=>$v){if($k>0){
        echo '<li><strong>'.$v['file'].'</strong> l.'.$v['line'].'</li>';
    }
    }
    echo "</ol>";
     echo "<pre style='overflow: scroll;width:350px;margin-top:20px;'>";
	print_r($var);
    echo "</pre>";


}
