<?php

class Post extends Model{
   var $h=1;
    public $validate= array(
        'name'=>array(
            'rule'=>'notEmpty',
            'message'=>'Vous devez preciser un titre'
        ),
        'slug'=>array(
            'rule'=>'([a-z0-9\-]+)',
            'message'=> "L'url n'est pas valide"
        )
    );
    function  validates($data){
        $errors=array();
        foreach ($this->validate as $k=>$v){
            if(!isset($data->$k)){               
                $errors[$k]=$v['message'];var_dump($errors);
            }  else {                
                if($v['rule']=='notEmpty' && empty($data->$k)){
                    $errors[$k]=$v['message'];   
            
                }elseif (!preg_match('/^'.$v['rule'].'$/', $data->$k) && ($v['rule']!='notEmpty')) {
                    $errors[$k]=$v['message'];   
                }
            }
        }
        $this->errors=$errors;
        if(isset($this->Form)){
            $this->Form->errors=$errors;
        }
        if(empty($errors)){
            return true;
        }  else {
            return false;
        }            
        
    }
}
