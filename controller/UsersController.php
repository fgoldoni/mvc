<?php

class UsersController extends Controller{
    
    /**
     * 
     */
    function login(){
        $this->loadModel('User'); 
        $this->reconnect_from_cookie();
        if($this->request->data){
            $data=  $this->request->data;
            $data->password= sha1($data->password);
            
            $user=$this->User->findFirst(array(
                'conditions'=> array('login'=>$data->login,'password'=>$data->password)
            ) );           
           
            if(!empty($user)){
                if($user->confirmation_at!=null)$this->Session->write('User',$user);
                if(isset($data->remember)){                   
                    $remember_token = $this->str_random(250);
                    $this->User->db->prepare('UPDATE users SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
                    setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
              }
               
            }
            $this->request->data->password='';
            $this->request->data->password_confirm='';
        }
        if($this->Session->isLogged()){
            if($this->Session->user('role')=='admin'){
                 $this->redirect('goldo/products');
                 exit();
            }  elseif($this->Session->user('role')=='user' && $this->Session->user('confirmation_at')!=null) {    
                 $this->redirect('products/index');
                 exit();
            }  else {
                               
               if($this->Session->user('confirmation_at')==null){
                   $this->Session->setFlash('Vous n\'avez pas confimé l\'email envoyer');
                   $this->redirect('users/register');
                   exit();
               }
               unset($_SESSION['User']);
               $this->redirect('users/register');
               exit();
            }
           
        }
        if($this->request->data){            
            $this->Session->setFlash('login ou mot de passe incorrectes','error');
            $this->request->data->password='';
            $this->request->data->password_confirm='';
            $this->redirect('users/register');
            exit();
        }
    }
    /**
     * 
     */
    function logout(){
        unset($_SESSION['User']);
        setcookie('remember', NULL, -1);
        $this->redirect('products/index');
    }
    public function register() {
        $this->layout='shop';
        $this->loadModel('User');
        $headers = 'From: Goldo <fgoldonid1@fgoldoni.de>'."\r\n";
        $this->reconnect_from_cookie();
        
       if($this->verify($this->request->data)){
           $password =sha1($this->request->data->password);
           $token = $this->str_random(60);
           $this->User->save(array(
                'login'=>$this->request->data->login,
                'password'=>$password,
                'email'=>  $this->request->data->email,
                'confirmation_token'=>$token
           ));
                  
           $user_id = $this->User->id;           
           if(mail($this->request->data->email, 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n".Lien."/webroot/users/confirm/".$user_id."/".$token."",$headers))
           {
                   $this->Session->setFlash('Un email de confirmation vous a été envoyé pour valider votre compte');
           }  else {
               $this->User->delete($user_id );
           }
        }
       
    }
    public function confirm($param) {
        $this->loadModel('User');
        if(empty($param)|| count($param)!==2){
            $this->Session->setFlash('Validation Impossible','error');
            $this->redirect('users/register');
            exit();           
            
        }  else {
            $user_id = $param[0];
            $token = $param[1];
            $user=$this->User->findFirst(array('conditions'=> array('id'=>$user_id))); 
            if($user && $user->confirmation_token == $token ){
            $this->User->db->prepare('UPDATE users SET confirmation_token = NULL, confirmation_at = NOW() WHERE id = ?')->execute([$user_id]);
             $_SESSION['User'] = $user;
            $this->Session->setFlash('Votre compte a bien été validé');
            $this->redirect('products/index');
        }else{
            $this->Session->setFlash('Ce token n\'est plus valide','error');
            $this->redirect('users/register');
        }
        
        }
    
    }
    public function forget() {
        $this->layout='shop';
         $headers = 'From: Triple <fgoldonid1@fgoldoni.de>'."\r\n";
        $this->loadModel('User');
        if($this->request->data){            
        $user=$this->User->findFirst(array('conditions'=> array('email'=>$this->request->data->email)));
        if($user){
            $reset_token = $this->str_random(60);
            $this->User->db->prepare('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
                        
            for($i=0;$i<5;$i++){
            if(mail($this->request->data->email, 'Reinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\n".Lien."/webroot/users/reset/".$user->id."/".$reset_token."",$headers)){
                    $this->Session->setFlash('Les instructions du rappel de mot de passe vous ont été envoyées par emails');
                    break;
                    
            }elseif($i==4) {
                $this->Session->setFlash('Resaisissez votre mot de passe ','error');
                $this->redirect('users/forget');   
                }
            }
            $this->redirect('users/register');
            exit();
        }else{
            $this->Session->setFlash('Aucun compte ne correspond à cet adresse','error');
        }
        }
    }
    public function reset($param) {
        $this->layout='shop'; 
        $this->loadModel('User');
        
        
        if(empty($param)|| count($param)!==2){
            $this->Session->setFlash('Validation Impossible','error');            
            $this->redirect('users/register');
            exit();
        } else {
            $user_id = $param[0];
            $reset_token = $param[1];
            $req= $this->User->db->prepare('SELECT * FROM users WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
            $req->execute([$user_id, $reset_token]);
            $user = $req->fetchAll(PDO::FETCH_OBJ); 
            
            
            if($user){  
                $this->Session->write('User',$user[0]);               
                $this->redirect('users/account');
            }else{
                $this->Session->setFlash("Ce token n'est pas valide",'error');
                $this->redirect('users/register');
                exit();
            }
           }    
    }
    public function account(){
                    $this->loadModel('User');
                    $this->loadModel('Post');
                    $this->layout='shop';                    
                    if(!empty($this->request->data)&&($this->Session->isLogged())){
                    if(!empty($this->request->data->password) && $this->request->data->password === $this->request->data->password_confirm){
                        $password =sha1($this->request->data->password);
                        $this->User->db->prepare('UPDATE users SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?')->execute([$password, $this->Session->user('id')]);                       
                        $this->Session->setFlash('Votre mot de passe a bien été modifié');
                        $this->redirect('products/index');
                        exit();
                    }
                $this->Session->setFlash('Votre mot de passe est incorrect','error');
                }
                
                if(!$this->Session->isLogged())$this->redirect('users/register');
        $d['count'] =$this->Session->count();
        $d['total']=  $this->Post->total();
        $this->set($d);
    }
    public function contact() {
        $this->loadModel('User');
        $this->loadModel('Post');
        $this->layout='shop';
        $bool=false;
        if(!empty($this->request->data)){
            $data=$this->request->data;
            $emails = ['fgoldonid1@fgoldoni.de','triplea1191@gmail.com', 'goldoshow@yahoo.fr'];        
            if($this->validator('login', 'required',$data)){
                $bool=true;
                $this->Session->setFlash("Le champs login n'a pas été rempli correctement",'error');
            }elseif ($this->validator('email', 'required',$data)) {
                $bool=true;
                $this->Session->setFlash("Le champs email n'a pas été rempli correctement",'error');    
            }elseif ($this->validator('email', 'email',$data)) {
               $bool=true;
               $this->Session->setFlash("Le champs email n'a pas été rempli correctement",'error');  
            }elseif ($this->validator('message', 'required',$data)) {
                $bool=true;
                $this->Session->setFlash("Le champs message n'a pas été rempli correctement",'error');
            }elseif ($this->validator('service', 'in',$data ,array_keys($emails))) {
                $bool=true;
                $this->Session->setFlash("Le champs service n'a pas été rempli correctement",'error');
            }
        }
        if(!$bool){
            if(isset($data)){
                    $condition=array('email'=>$data->email,'login'=>$data->login);
                    $user=$this->User->findFirst(array(
                        'conditions'=>$condition));                     
                    if(!$user){
                        $this->Session->setFlash('Vous n\'avez pas encore creer de Compte','error');                        
                    }else{
                        $headers = 'FROM: ' . $data->email;
                       if(mail($emails[$data->service], 'Formaulaire de contact de ' . $data->login, $data->message, $headers))
                       $this->Session->setFlash('Votre message est bien envoyé');
                    }
                    
                }
                
               

            
        }
         
        $d['count'] =$this->Session->count();
        $d['total']=  $this->Post->total();
        $this->set($d);
       
        
    }
    public function admin_index() {
        $perPage=10;
        $this->loadModel('User');
        $this->loadModel('Post');
        if(isset($this->request->data->search)||isset($this->request->repeat_search)){
            $search=isset($this->request->repeat_search)?explode(' ', $this->request->repeat_search): explode(' ', $this->request->data->search);
            $d['users']=$this->User->find(array(
                'LIKE'=>$search,
                'User'=>1,
            ));
        $d['search']=  count($d['users']);
        }else{
        $d['users']=$this->User->find(array(
                'conditions'=>array('role'=>'user'),
                'limit' =>($perPage*($this->request->page-1)).','.$perPage
           ));
        }
        
        $d['total']= count($d['users']);
        $d['page']= ceil($d['total']/$perPage);
        $this->set($d); 
        
    }
    public function admin_edit($id=null) {
       if(!is_numeric($id)&&!empty($id))$id=  intval($id[0]);
       $this->loadModel('User');
       $this->loadModel('Post');
       $bool=false;
           if(!empty($this->request->data)){
            $data=$this->request->data;
            if($this->validator('login', 'required',$data)){
                $bool=true;
                $this->Session->setFlash("Le champs login n'a pas été rempli correctement",'error');
            }elseif ($this->validator('email', 'required',$data)) {
                $bool=true;
                $this->Session->setFlash("Le champs email n'a pas été rempli correctement",'error');    
            }elseif ($this->validator('email', 'email',$data)) {
               $bool=true;
               $this->Session->setFlash("Le champs email n'a pas été rempli correctement",'error');  
            }elseif ($this->validator('confirmation_at', 'required',$data)) {
                $bool=true;
                $this->Session->setFlash("Le champs date n'a pas été rempli correctement",'error');
            }
            $this->User->Updaten(array(
                'id'=>$data->id,
                'login'=>$data->login,
                'email'=>  $data->email,
                'confirmation_at'=>$data->confirmation_at
           ));
        $this->Session->setFlash("Données modifiées avec succes");    
        $this->redirect('goldo/users/index');    
        }
       if(!empty($id)){
       $this->request->data=  $this->User->findFirst(array(
            'conditions'=>array('id'=>$id)    
       )); 
    }
    
    }
    public function admin_delete($id) {
       $this->loadModel('User');
       var_dump($id);
       $this->User->delete($id);
       $this->Session->setFlash("Utilisateur Supprimer");    
       $this->redirect('goldo/users/index');  
    }
    function profil(){
        $this->loadModel('User');
        $this->layout='shop';
    }
    
}