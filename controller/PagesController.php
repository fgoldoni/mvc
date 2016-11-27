<?php

class PagesController extends Controller{
    function index(){

    }
    
    function  view($id){
       
        if(is_numeric($id)||(!empty($id))){$id= $id[0];}
        if (!empty($id)) { // ajouter par moi mm
            $this->loadModel('Post');
            $d['page']=$this->Post->findFirst(array(
                'conditions'=>array('id'=>$id,'online'=>1,'type'=>'page')
            ));            
        }
        if(empty($d['page'])){
                $this->e404('Page Introuvable/ requete avec aucune conditions');
        }  
        $this->set($d);
    }
    /**
     * Permet de recuperer les pages pour le menu
     */
    function getMenu(){
        $this->loadModel('Post');
        return $this->Post->find(array(
            'conditions' =>array('online'=>1,'type'=>'page')
        ));
    }
            
    function admin_index(){
        $this->layout='admin';
    }
    
    
}
