<?php
 class Controller{
     public  $request;
     private $vars =array();
     public $layout='default';
     private  $rendered=false;
             
     function __construct($request=null) {
         if($request){
        $this->Session=new Session();
        $this->Form=new Form($this);
        $this->request=$request;
        require ROOT.DS.'config'.DS.'hook.php';
     }
     }


     public function  render($view){
         if($this->rendered){return false;}
         
         extract($this->vars);
         if(strpos($view,'/')===0){
             $view=ROOT.DS.'view'.$view.'.php';
         }
        else {
             $view=ROOT.DS.'view'.DS.$this->request->controller.DS.$view.'.php';
        }
         
         ob_start();
         require($view);
         $content_for_layout =  ob_get_clean();
         require ROOT.DS.'view'.DS.'layout'.DS.$this->layout.'.php';
         $this->rendered=true;
        
         
     }
      public function  set($key,$value=null){
          
          if(is_array($key)){
              $this->vars +=$key;
          }else{
              $this->vars[$key]=$value;
          }         
          
      }
      
      /**
       * Permet de charger un model
       */
      function  loadModel($name){
          $file=ROOT.DS.'model'.DS.$name.'.php';
          require_once($file);
          if(!isset($this->$name)){
              $this->$name=new $name();
              if(isset($this->Form)){
              $this->$name->Form=  $this->Form;
              }
          }
          
   
      }
      /**
       * Permet de gerer les erreurs 404
       */
      function e404($message){
        header("HTTP/1.0 404 not Found");
        $this->set('message',$message);
        $this->render('/errors/404');
           
        die();
      }
      /**
       * Permet dappeller un controller depuis un vue
       */
      function request($controller,$action){
          $controller .='Controller';
          require_once ROOT.DS.'controller'.DS.$controller.'.php';
          $c=new $controller();
          return $c->$action();
      }
      /**
       * Redirect
       */
      function redirect($url,$code=null){
          if($code == 301){
              header("HTTP/1.1 301 Moved Permanently");
              exit();
          }
          header("Location: ".Router::url($url));
          exit();
      }
      public function verify($param) {
          if(!empty($param)){
                if($param->login=='' || !preg_match('/^[a-zA-Z0-9]+$/', $param->login)){
                  $this->Session->setFlash('Votre pseudo n\'est pas valide','error');
                  return false;
                } else {
                    $condition=array('login'=>$param->login);
                    $user=$this->User->findFirst(array(
                        'conditions'=>$condition));               
                    if($user){
                        $this->Session->setFlash('Ce pseudo est déjà pris');
                         return false;
                    }
                }            
                if(empty($param->email)|| !filter_var($param->email,FILTER_VALIDATE_EMAIL) ){
                    $this->Session->setFlash("Votre email n'est pas valide",'error');
                    return false;
                } else {
                    $condition=array('email'=>$param->email);
                    $user=$this->User->findFirst(array(
                        'conditions'=>$condition));                     
                    if($user){
                        $this->Session->setFlash('Cet email est déjà utilisé pour un autre compte','error');
                        return false;
                    }
                }
                if(empty($param->password)|| ($param->password!==$param->password_confirm)){
                    $this->Session->setFlash('Votre Mot de passe n\'est pas valide','error');
                    return false;
                }
                return true;

            }
      }
      function str_random($length){
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
        }
        function reconnect_from_cookie(){
            $this->loadModel('User');
            if(isset($_COOKIE['remember']) && $this->Session->isLogged() ){
                
                $remember_token = $_COOKIE['remember'];
                $parts = explode('==', $remember_token);
                $user_id = $parts[0];
                $user=$this->User->findFirst(array(
                'conditions'=> array('id'=>$user_id)
                ) );                
                if($user){
                   
                    $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');
                    if($expected == $remember_token){                       
                        $this->Session->write('User',$user);
                        setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
                        if($this->Session->user('role')=='admin'){
                            $this->redirect('goldo/posts');
                            exit();
                        }else{
                             $this->redirect('products/index');
                             exit();
                        }
                    } else{
                        setcookie('remember', null, -1);
                    }
                }else{
                    setcookie('remember', null, -1);
                }
            }
}
    public function validator($name, $rule, $data,$options = false){
        $validator = "validate_$rule";
        if(!$this->$validator($name,$data, $options)){
            return true;           
        }
        return false;   
    }
     public function validate_required($name,$data){
        return array_key_exists($name, get_object_vars($data)) && $data->$name != '';
    }

    public function validate_email($name,$data){
        return array_key_exists($name, get_object_vars($data)) && filter_var($data->$name, FILTER_VALIDATE_EMAIL);
    }

    public function validate_in($name,$data ,$values){
        return array_key_exists($name, get_object_vars($data)) && in_array($data->$name, $values);
    }
    public function message($products) {
        $som=0;
        $html="<br/><table style=\"border-collapse: collapse; width:100%; text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.8); \">
                <tr style=\"background-color: rgba(15,115,67,0.6);\">
                  <th style=\"border: 1px solid black;text-align: left;\">Nom</th>
                  <th style=\"border: 1px solid black;text-align: left;\">Prix</th> 
                  <th style=\"border: 1px solid black;text-align: left;\">Qte</th>
                </tr>
                ";
        foreach ($products as $k=>$product){
         $html.="<tr> <td style=\"border-color: rgb(255,0,0);text-align: left;\">$product->name</td>
                  <td style=\"border-color: rgb(255,0,0);text-align: left;\">$product->price</td> 
                  <td style=\"border-color: rgb(255,0,0);text-align: left;\">";
        $html.=    $_SESSION["panier"][$product->id]."</td>
                </tr>";
        $som+=$product->price*$_SESSION["panier"][$product->id];
       
        }
        $html.="<tr><td style=\"border-color: rgb(255,0,0);text-align: right ;\">Total</td>"
                . "<td colspan=\"3\" style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">$som Euro</td></tr></table>";
        return $html;
    }
    public function address($address) {
        $buyerNamen=$address['buyerNamen'];
        $buyerStrasse=$address['buyerStrasse'];
        $buyerPLZ=$address['buyerPLZ'];
        $buyercity=$address['buyercity'];
        $buyerCountry=$address['buyerCountry'];
        $buyerWarung=$address['buyerWarung'];
        $buyerTravel=$address['buyerTravel'];
        $buyerEmail=$address['buyerEmail'];
       $html="<br/>Payeur:";
        
         $html.="<br/><table  style=\"border-collapse: collapse;width:100%; text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.8); \">
             <tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Noms</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerNamen</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Rue</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerStrasse</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);background-color:rgba(20,163,95,0.6);text-align: left;\">Code Postale</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerPLZ $buyercity</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Pays</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerCountry</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Device</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerWarung</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Frais denvoie</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerTravel</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Email</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$buyerEmail</td> 
                </tr></table>";
       
        return $html;
     
    }
    public function buyer() {
        $user=$_SESSION['User'];
        $html="<br/>Client: <br/> <table style=\"border-collapse: collapse; width:100%; text-shadow: 1px 1px 0px rgba(255, 255, 255, 0.8);\">";
        $html.="<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);background-color:rgba(20,163,95,0.6);text-align: left;\">id</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$user->id</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);background-color:rgba(20,163,95,0.6);text-align: left;\">login</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$user->login</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);background-color:rgba(20,163,95,0.6);text-align: left;\">Email</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$user->email</td> 
                </tr>"
                ."<tr> 
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;background-color:rgba(20,163,95,0.6);\">Date d\'inscription</td>
                    <td style=\"border: 1px solid rgba(20,163,95,0.2);text-align: left;\">$user->confirmation_at</td> 
                </tr></table>";
       
       return $html;
    }
    public function msg($sms,$file_name,$boundary) {
        // Message
                        $msg = 'Texte affiché par des clients mail ne supportant pas le type MIME.'."\r\n\r\n";
 
                        // Message HTML
                        $msg .= '--'.$boundary."\r\n";
                        $msg .= 'Content-type: text/html; charset=utf-8'."\r\n\r\n";
                        $msg .= '
                            <div style="padding:50px;  ">
                            <div>
                                <h2 style="color:#274E9C; text-decoration:underline">Merci de votre fidelite :</h2>
                                <ul>
                                        <li><a href='.Lien.'/Tuto/products/index>Goldoni GmbH</a></li>
                                                <li><a href="#">Votre Commande</a></li>
                                </ul>
                            </div>'.$sms.'
                            
                        </div>'."\r\n";
                        if (file_exists($file_name))
                        {
                                $file_type = filetype($file_name);
                                $file_size = filesize($file_name);   
                                $handle = fopen($file_name, 'r') or die('File '.$file_name.'can t be open');
                                $content = fread($handle, $file_size);
                                $content = chunk_split(base64_encode($content));
                                $f = fclose($handle);

                                $msg .= '--'.$boundary."\r\n";
                                $msg .= 'Content-type:'.$file_type.';name='.$file_name."\r\n";
                                $msg .= 'Content-transfer-encoding:base64'."\r\n\r\n";
                                $msg .= $content."\r\n";
                        }
                        // Fin
                        $msg .= '--'.$boundary."\r\n";
                        return $msg;
        
    }
 }