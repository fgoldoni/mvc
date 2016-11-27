<?php
require ROOT.DS.'vendor/autoload.php';
use Intervention\Image\ImageManager;

class ProductsController extends Controller{
    var $count=0;
    var $total=0;
    
    public function index($category=null){
        $perPage=6;
        $d['total']=0;
        $d['count'] =0;         
        $this->layout='shop';        
        $this->loadModel('Post');
        $this->loadModel('Media');
        if(!empty($category)&&  is_array($category))$category=$category[0];
        if($category==null){
            $condition=array(
            'type'=>'products',
            'online'=>1
            );
        }else{
            $condition=array(
            'type'=>'products', 
            'category'=>$category,
            'online'=>1
            );
         }
        if(isset($this->request->data->search)||isset($this->request->repeat_search)){
            $search=isset($this->request->repeat_search)?explode(' ', $this->request->repeat_search): explode(' ', $this->request->data->search);
            $d['products']=$this->Post->find(array(
                'fields' => 'id,name,online,price,category',
                'order'=>'id DESC',
                'LIKE'=>$search,
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
            ));
            $d['search']=$this->Post->findCount($condition,$search);
            $d['repeat_search']=  implode(' ', $search);
        }else{
            $d['products']=$this->Post->find(array(
                'fields' => 'id,name,online,price,category',
                'order'=>'id DESC',
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
            ));
        }
        $d['medias']=$this->Media->find(array(            
             'conditions'=>array('front'=>1)
         ));
        $d['total']=$this->Post->total();       
        $d['count'] +=$this->Session->count();
        if(isset($search)){
            $d['Total']=  $this->Post->findCount($condition,$search);
        }else{
           $d['Total']=  $this->Post->findCount($condition); 
        }    
        $d['page']= ceil($d['Total']/$perPage);
        $this->set($d);
        
    }
    public function panier($id=null) {
        if(isset($id[1])){
            $category=$id[1];
            
        }
        
        $perPage=20;
        $this->loadModel('Post');
        $this->loadModel('Media');
        $this->layout='shop';        
        $d['total']=0;
        $d['Total']=0;
        $d['count'] =0;
        
        if($id!=null){
        if(is_array($id)||(!empty($id))){$id= intval($id[0]);}
        if(!isset($category)){
            $condition=array(
            'id'=>$id,
            'type'=>'products',
            'online'=>1
            );
        }else{
            $condition=array(
            'id'=>$id,
            'type'=>'products', 
            'category'=>$category,
            'online'=>1
            );
         }
        $product=$this->Post->findFirst(array(
                'fields' => 'id,name',
                'conditions'=>$condition
            )
        );
        if(empty($product)){
            $this->Session->setFlash("Ce produit n'existe pas");          
        }else{
            $this->Session->add($product->id);
            $this->Session->setFlash("Produit  [".$product->name."] ajouter!!");
            
        }
        }
        $ids=  array_keys($_SESSION['panier']);
         if(empty($ids)){
         $d['products']=array();
         }  else {
         $condition=array(
            'type'=>'products',
             'online'=>1
            );
         $d['products']=$this->Post->find(array(
                'fields' => 'id,name,online,price,description,user_id,category',
                'order'=>'id DESC',
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage,
                'in'=>'id IN('.implode(',', $ids).')'
        ));
        $_SESSION['products']=$d['products'];
         foreach ($d['products'] as $product) {
            $d['total'] +=$product->price*$_SESSION['panier'][$product->id];
           
        }               
        }
        $d['medias']=$this->Media->find(array(            
             'conditions'=>array('front'=>1)
         ));
        
        $d['count'] +=$this->Session->count();
        $d['total']=  $this->Post->total();
        $_SESSION['total']=$d['total'];
        $_SESSION['count']=$d['count'];
        if(isset($condition))$d['Total']=  $this->Post->findCount($condition);
        $d['page']= ceil($d['Total']/$perPage);        
        $this->set($d);  
        if($id!=null){
            
            $this->redirect('products/index/'.$category);
        }
        
       
    }
    public function del($id) {
        var_dump($id=  intval($id[0]));
        $this->Session->del($id);
        $this->redirect('products/panier');
    }
    public function admin_index($id=null){
        $perPage=10;
        $this->loadModel('Post'); 
        $this->layout='adminProducts';
        $condition=!empty($id)?array('type'=>'products','category'=>$id[0]):array('type'=>'products');
        if(isset($this->request->data->search)||isset($this->request->repeat_search)){
            $search=isset($this->request->repeat_search)?explode(' ', $this->request->repeat_search): explode(' ', $this->request->data->search);
            $d['products']=$this->Post->find(array(
                'fields' => 'id,name,online,quantity,description,price',
                'order'=>'id DESC',
                'LIKE'=>$search,
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
            ));
            $d['search']=$this->Post->findCount($condition,$search);
            $d['repeat_search']=  implode(' ', $search);
            $d['total']=  $this->Post->findCount($condition,$search);
        }  else {
           $d['products']=$this->Post->find(array(
                'fields' => 'id,name,online,quantity,description,price,category',
                'order'=>'id DESC',
                'conditions'=>$condition,
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
            )); 
           $d['total']=  $this->Post->findCount($condition);
        }
        
        $d['page']= ceil($d['total']/$perPage);
        $this->set($d); 
        
    }
    public function admin_delete($id) {
        var_dump($_POST);
        var_dump($this->request->data);die();
        $this->loadModel('Post');
        $this->Post->delete($id);
        $this->loadModel('Media');
         if (is_array($id))$id=  intval($id[0]);
         $media=$this->Media->find(array(
             'conditions'=>array('post_id'=>$id)
         ));
         foreach ($media as $k) {
          if(file_exists(WEBROOT.DS.'img'.DS.$k->file)){
           unlink(WEBROOT.DS.'img'.DS.$k->file); 
           unlink(WEBROOT.DS.'img'.DS.$k->fileMin);
           unlink(WEBROOT.DS.'img'.DS.$k->fileBig);
           $this->Media->delete($k->id);
          }
         }
        $this->Session->setFlash('Le Product a bien ete suprimer','error');
        $this->redirect('admin/products/index');
        
    }
    public function admin_edit($id=null) {
        $p=$id[0];
        if(!is_numeric($id)&&!empty($id)){$category=isset($id[1])?$id[1]:'';$id=  intval($id[0]);}
        $this->loadModel('Post');
        $this->loadModel('Media');
        $fr=0;
        if(empty($id)){            
            $post=$this->Post->findFirst(array(
                'conditions' => array('online' => -1)
            ));
            if(!empty($post)){
                $id=$post->id;
                $post->category=$p;
            }else{
                $this->Post->save(array(
                'online'=>-1,
                'category'=>$p,
            ));
            $id=  $this->Post->id;
            }
        }
        $d['id']=$id;
        if($this->request->data){            
            //$this->request->data->id=  intval($this->request->data->id);
            if(isset($this->request->data->front)){
                $fr=$this->request->data->front;
                                
                $req=$this->Media->find(array(
                    'conditions'=>array('post_id' => $id)
                ));
                foreach ($req as $v) {
                  if(($v->front==1) && ($v->id!=$this->request->data->front)){
                    $front= $v->id;
                  }  
                }
                
                if(isset($front)){
                    $this->Media->Update(0,$front);                  
                }
                $this->Media->Update(1,$this->request->data->front);
                unset($this->request->data->front);
            }
            if($this->Post->validates($this->request->data)){
                $this->request->data->type='products';
                $this->request->data->created= date("Y-m-d H:i:s");
                if(!empty($_FILES['file']['name'])){
                if(strpos($_FILES['file']['type'],'image')!==false){
                $dir=WEBROOT.DS.'img'.DS.date('Y-m');
                $dir_min=WEBROOT.DS.'img'.DS.date('Y-m').'/min';
                $dir_big=WEBROOT.DS.'img'.DS.date('Y-m').'/big';
                if(!file_exists($dir))mkdir($dir,0777);
                if(!file_exists($dir_min))mkdir($dir_min,0777);
                if(!file_exists($dir_big))mkdir($dir_big,0777);
                $manager = new ImageManager();
                $manager_min = new ImageManager();
                $manager_big = new ImageManager();
                $manager
                ->make($_FILES['file']['tmp_name'])
                ->fit(261, 255)
                ->interlace(true)
                ->save($dir.DS.$_FILES['file']['name'])                
                ; 
                $manager_min
                ->make($_FILES['file']['tmp_name'])
                ->fit(66,53)
                ->interlace(true)
                ->save($dir_min.DS.$_FILES['file']['name']);
                $manager_big
                ->make($_FILES['file']['tmp_name'])
                ->orientate()
                ->resize(500, null, function($constraint){
                $constraint->aspectRatio();
                })
                ->interlace(true)
                ->save($dir_big.DS.$_FILES['file']['name']);
                if(isset($this->request->data->fr)){
                    $this->Media->save(array(
                    'name'=>  $this->request->data->name,
                    'file'=>date('Y-m').'/'.$_FILES['file']['name'],
                    'fileMin'=>date('Y-m').'/min/'.$_FILES['file']['name'],
                    'fileBig'=>date('Y-m').'/big/'.$_FILES['file']['name'],
                    'post_id'=>$id,
                    'front'=>$this->request->data->fr,
                    'type'=>'img'
                  ));
                  if(isset($fr)){
                    $this->Media->Update(0,$fr);                  
                 }  
                 unset($this->request->data->fr);
                }  else {
                    $this->Media->save(array(
                    'name'=>  $this->request->data->name,
                    'file'=>date('Y-m').'/'.$_FILES['file']['name'],
                    'fileMin'=>date('Y-m').'/min/'.$_FILES['file']['name'],
                    'fileBig'=>date('Y-m').'/big/'.$_FILES['file']['name'],
                    'post_id'=>$id,
                    'type'=>'img'
                  ));
                    
                }
                  
                   
                  $this->Session->setFlash("L'image a bien ete uplode",'success');
                }else{
                 $this->Session->setFlash('Merci de mettre une image','error');
                }
            }

              $this->request->data->id= $d['id'];  
              $this->Post->save($this->request->data);
              $id=  $this->Post->id;
              $this->Session->setFlash('Le contenu a bien ete modifier');
              
              $this->redirect('admin/products/index/');
                
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
    function getMenu(){
        $this->loadModel('Post');
        return $this->Post->find(array(
            'fields'=>'category',
            'order'=>'category ASC',
            'conditions' =>array('online'=>1,'type'=>'products')
        ),'DISTINCT');        
    }
    function view($id) {
        $perPage=6;
        $this->loadModel('Post');
        $this->loadModel('Media');
        $d['total']=0;
        $d['count'] =0;
        $this->layout='products';
        
        
        if(!isset($category)){
            $condition=array(
            'type'=>'products',
            'online'=>1
            );
        }else{
            $condition=array(
            'type'=>'products', 
            'category'=>$category,
            'online'=>1
            );
         }
        
        
        $d['medias']= $this->Media->find(array(
            'conditions' =>array('post_id'=>$id[0])
        ) );
        $d['products']= $this->Post->find(array(
            'conditions' =>array('id'=>$id[0])
        ) );
        
        $d['count'] +=$this->Session->count();
        $d['total']=  $this->Post->total();
        $d['Total']=  $this->Post->findCount($condition);
        $d['page']= ceil($d['Total']/$perPage);        
        $this->set($d);
    }
    
    
    
    
    
}
