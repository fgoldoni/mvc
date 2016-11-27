<?php

class MediasController extends Controller{
    function admin_index($id){
        if (is_array($id))$id=  intval($id[0]);
        $this->loadModel('Media');
        if($this->request->data && !empty($_FILES['file']['name'])){
            if(strpos($_FILES['file']['type'],'image')!==false){
                $dir=WEBROOT.DS.'img'.DS.date('Y-m');
                if(!file_exists($dir))mkdir($dir,0777);
                  move_uploaded_file($_FILES['file']['tmp_name'], $dir.DS.$_FILES['file']['name']);
                  $this->Media->save(array(
                    'name'=>  $this->request->data->name,
                     'file'=>date('Y-m').'/'.$_FILES['file']['name'],
                      'post_id'=>$id,
                      'type'=>'img'
                  ));
                  $this->Session->setFlash("L'image a bien ete uplode",'success');
            }else{
                 $this->Session->setFlash('Merci de mettre une image','error');
            }
        }
        $this->layout='modal';
        $d['images']=  $this->Media->find(array(
            'conditions'=>array('post_id' => $id)
        ));
        $d['post_id']=$id;
        $this->set($d);
    }
    function  admin_delete($id){
         $this->loadModel('Media');
         if (is_array($id))$id=  intval($id[0]);
         $media=$this->Media->findFirst(array(
             'conditions'=>array('id'=>$id)
         ));
         unlink(WEBROOT.DS.'img'.DS.$media->file);
         $this->Media->delete($id);
       
         $this->Session->setFlash('Le fichier a bien ete supprimer');
         $this->redirect('admin/medias/index/'.$media->post_id);
    }
    function getMedia(){
        $this->loadModel('Media');
        return $this->Media->find();
    }
    function admin_del($id) {
        $this->loadModel('Media');
         if (is_array($id))$id=  intval($id[0]);
         $media=$this->Media->findFirst(array(
             'conditions'=>array('id'=>$id)
         ));
         if(file_exists(WEBROOT.DS.'img'.DS.$media->file)){
         unlink(WEBROOT.DS.'img'.DS.$media->file);
         unlink(WEBROOT.DS.'img'.DS.$media->fileMin);
         }
         $this->Media->delete($id);
       
         $this->Session->setFlash('Le fichier a bien ete supprimer');
         $this->redirect('admin/products/edit/'.$media->post_id);
    }
        
    
}
