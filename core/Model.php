<?php

class Model{
    public $conf='default';
    static $connections=array();
    public $table=false;
    public $db;
    public $id;
    public $errors=array();
    public $primaryKey='id';
    public $form;   
    public function __construct() {
        
        if($this->table===false){
            $this->table=  strtolower(get_class($this)).'s';
        }
        // je me connete a ma base de donne
        $conf=  Conf::$databases[$this->conf];
        if (isset(Model::$connections[$this->conf])) {
            $this->db=  Model::$connections[$this->conf];
            return true;
        }
        try {
            $pdo=new PDO(
                    'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
                    $conf['login'],
                    $conf['password'],
                    array(PDO::MYSQL_ATTR_INIT_COMMAND=> 'SET NAMES utf8')
                    );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            Model::$connections[$this->conf]=$pdo;
            $this->db=$pdo;
            
        } catch (PDOException $e) {
            if (Conf::$debug>=1) {
               die($e->getMessage()); 
            }
            else{
                die('Impossible de se connter a la base de donnees');
            }
         
        }
        // J initialise quelque variables 
        if(isset($_POST['panier']['quantity'])){
        $this->recalc();
        }
     }
     public function recalc(){
        foreach ($_SESSION['panier'] as $product_id => $quantity) {
           if(isset($_POST['panier']['quantity'][$product_id])){
             $_SESSION['panier'][$product_id]=$_POST['panier']['quantity'][$product_id];  
           }
       }
    }
    public function find($req=null,$distint=''){
      $order="id ASC";
      $sql='SELECT '.$distint.' ';
      //construction de la condition
       if(isset($req['fields'])){          
           if(is_array($req['fields'])){
               $sql .= implode(',',$$req['fields']);       
           }
           else { $sql .=$req['fields']; }           
       }
       else { $sql .=' *';}
       $sql.=' FROM '.$this->table.' as '.get_class($this).' ';           
       if(isset($req['conditions'])){
       $sql.= ' WHERE ';  
       if(!is_array($req['conditions'])){
         $sql.=$req['conditions'];
        }else{
           $cond = array();
           foreach ($req['conditions'] as $k=>$v){
           if(!is_numeric($v)){                     
                $v=$this->db->quote($v);
           }
           $cond[]= "$k=$v";
           }
           $sql .=implode(' AND ',$cond);
        }
      }
      if(isset($req['in'])){
          $in=$req['in'];
          $sql.='  AND '.$in;
      }
      if(isset($req['LIKE'])){
          $i=0;
          if(isset($req['User']))$sql .=" WHERE ";
          foreach ($req['LIKE'] as $k=>$mot) {
              if(strlen($mot)>3||(isset($req['User'])))
              {
                  if($i==0){$sql .=isset($req['User'])?"":' AND';$i++;}
                  $mot=isset($req['User'])?" id LIKE'%$mot%'":" name LIKE'%$mot%'";
                  $search[]= $mot;
              }
          }
          if(isset($search))$sql .=implode(' OR ',$search);
          foreach ($req['LIKE'] as $k=>$mot) {
              if(strlen($mot)>3||(isset($req['User'])))
              {
                  $mot=isset($req['User'])?" login LIKE'%$mot%'":" content LIKE'%$mot%'";
                  $search[]= $mot;
              }
          }
          
          if(isset($search))
          {
              $sql .=" OR ";
              $sql .=implode(' OR ',$search);
          }
         
         if($i==0)$sql .=isset($req['User'])?" login LIKE ' '":" AND name LIKE ' '";
      }
      if(isset($req['order'])){ $order=$req['order'];}
      $sql .= ' ORDER BY '.$order;
      if(isset($req['limit'])) $sql .= ' LIMIT '.$req['limit'];
      $pre=  $this->db->prepare($sql);
      $pre->execute();
      return $pre->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function findFirst($req){        
      return current($this->find($req));
    }   
    public function findCount($conditions,$search=null){
        $res=$this->findFirst(array(
        'conditions'=> $conditions,
        'LIKE'=>$search,
        'fields' =>'COUNT('.$this->primaryKey.') as count'
        )); 
         return $res->count;
    }
    public function delete($id){
         if (is_array($id))$id=  intval($id[0]);
        $sql="DELETE FROM {$this->table} WHERE {$this->primaryKey}=$id";        
        $this->db->query($sql);
    }
    /**
     * 
     */
    function  save($data) {
      $key=  $this->primaryKey;
      $fields=array();
      $d=array();
      foreach ($data as $k => $v) {
          $fields[] ="$k=:$k";
          $d["$k"]=$v;
      }
      if (isset($data->$key)&& !empty($data->$key)) {
           $sql='UPDATE '.$this->table.' SET '.implode(',', $fields).' WHERE '.$key.' =:'.$key; 
           $this->id=$data->$key;
           $action='update';
      }else{
           $sql='INSERT INTO '.$this->table.' SET '.implode(',', $fields); 
           $action='insert';
      }  
      $pre=$this->db->prepare($sql);
      $pre->execute($d);
      if($action=='insert'){
      $this->id=  $this->db->lastInsertId();
      }
     
      
    }
    function Update($front,$id) {
       $sql='UPDATE '.$this->table.' SET front= '.$front.' WHERE id = '.$id;
       $pre=$this->db->query($sql);
        
    }
    function Updaten($req) {
       $key=$req['id'];
       $fields=array();
       $d=array();
       foreach ($req as $k => $v) {
          $fields[] ="$k=:$k";
          $d["$k"]=$v;
       }
       $sql='UPDATE '.$this->table.' SET '.implode(',', $fields).' WHERE id =:id AND login =:login'; 
       $pre=$this->db->prepare($sql);
       $pre->execute($d);        
    }
     public function total() {
    $total=0;
    $ids=  array_keys($_SESSION['panier']);
    if(empty($ids)){
    $products=array();
    }  else {
        $condition=array(
            'type'=>'products',
             'online'=>1
            );
        $products=$this->find(array(
                'fields' => 'id,name,online,price,category',
                'order'=>'id DESC',
                'conditions'=>$condition,
                'in'=>'id IN('.implode(',', $ids).')'
        ));
    }                      
    foreach ($products as $product) {
        $total +=$product->price*$_SESSION['panier'][$product->id];
    }
    return $total;
    }
    
}
