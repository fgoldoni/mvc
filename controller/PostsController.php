<?php

class PostsController extends Controller{
    
    function index(){
        $perPage=3;

        $this->loadModel('Post'); 
        $condition=array('online'=>1,'type'=>'post');
   
        $d['posts']=$this->Post->find(array(
                'conditions'=>$condition,
                'order'=>'id DESC',
                'limit'=> ($perPage*($this->request->page-1)).','.$perPage
            ));
        
        $d['total']=  $this->Post->findCount($condition);
        $d['page']= ceil($d['total']/$perPage);
        $this->set($d);
    }
   
    
    function  view($id){
        
        if(is_numeric($id)){$id= $id[0];}
         else{$id= $id['id'];}
         // ajouter par moi mm
            
            $this->loadModel('Post');
            $d['post']=$this->Post->findFirst(array(
                'fields' => 'id,slug,content,name',
                'conditions'=>array('id'=>$id,'online'=>1,'type'=>'post')
            ));            
        if(empty($d['post'])){
                $this->e404('Page Introuvable/ requete avec aucune conditions');
        }  
        $this->set($d);
    }
    /**
     * Permet de recuperer les pages pour le menu
     */
    function admin_index(){
        $perPage=10;
        $this->loadModel('Post'); 
        $condition=array('type'=>'post');
   
        $d['posts']=$this->Post->find(array(
                'fields' => 'id,name,online',
                'order'=>'id DESC',
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
            ));   
           
        $d['total']=  $this->Post->findCount($condition);
        $d['page']= ceil($d['total']/$perPage);
        $this->set($d);
    }
    /**
     * Delete
     */
    function  admin_delete($id){
       
        $this->loadModel('Post');
        $this->Post->delete($id);
        $this->Session->setFlash('Le contenu a bien ete suprimer');
        $this->redirect('admin/posts/index');
    }
    /**
     * 
     * @param type $id
     */
    function admin_edit($id=null){ 
        if(!is_numeric($id)&&!empty($id))$id=  intval($id[0]);        
        $this->loadModel('Post');
        if(empty($id)){            
            $post=$this->Post->findFirst(array(
                'conditions' => array('online' => -1)
            ));
            if(!empty($post)){
                $id=$post->id;
            }else{
                $this->Post->save(array(
                'online'=>-1,
            ));
            $id=  $this->Post->id;
            }
            
        }
         $d['id']=$id;
        if($this->request->data){
            //$this->request->data->id=  intval($this->request->data->id); 
            if($this->Post->validates($this->request->data)){
                $this->request->data->type='post';
                $this->request->data->created= date("Y-m-d H:i:s");
                $this->Post->save($this->request->data);
                $this->Session->setFlash('Le contenu a bien ete modifier');
                $id=  $this->Post->id;
                $this->redirect('admin/posts/index');
            }else{
                
                $this->Session->setFlash('Merci de corriger vous informations','error');
            }
            
            
        }
        else{                    
            $this->request->data=  $this->Post->findFirst(array(
            'conditions'=>array('id'=>$id)    
            ));
           
        }
       $this->set($d);
    }
    /**
     * 
     */
    function admin_tinymce(){
     $this->loadModel('Post');
     $this->layout='modal';
     $d['posts']=$this->Post->find();
     $this->set($d);
     }

    function getMenu(){
        $this->loadModel('Post');
        return $this->Post->find(array(
            'fields'=>'category',
            'order'=>'category ASC',
            'conditions' =>array('online'=>1,'type'=>'products')
        ),'DISTINCT');
    }
    function getSubMenu($category){
        $this->loadModel('Post');
        return $this->Post->find(array(
            'fields'=>'subCategory',
            'order'=>'category ASC',
            'conditions' =>array('online'=>1,'type'=>'products','category'=>$category)
        ),'DISTINCT');
    }
    public function shop()
    {
       
    }
}
