<?php ?>

<!Doctype html>
<html>
<head>
   <meta charset="utf-8" />  
   <link rel="stylesheet" href="<?php  echo BASE_URL.'/css/bootstrap.css';?>" >    
   <title><?php echo isset($title_for_layout)?$title_for_layout : 'Mon Site'?></title> 
   <style>
      body {
        padding-top: 60px;
      }
    </style>
</head>

<body >


<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
               <li><a href="<?php echo Router::url('users/login');?>"><span class="glyphicon glyphicon-user"></span> Login </a></li>
                <?php $pagesMenu=$this->request('Pages','getMenu');?>
                <?php foreach ($pagesMenu as $p ):?>
                 <li>
                     <a href="<?php echo BASE_URL.'/pages/view/'.$p->id;?>"
                      title=" <?php echo $p->name;?>"> <?php echo $p->name;?> </a>
                </li>
                <?php endforeach; ?>
                <li><a href="<?php echo BASE_URL.'/posts/';?>"> Actualites</a></li>
                <li><a href="<?php echo BASE_URL.'/products/index';?>"> Shop</a></li>

              <li><a href="#">Contact</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

    <div class="container">
      <?php echo $this->Session->flash();  ?> 
       <?php echo $content_for_layout; ?> 

    </div> 
    

  
</body>

</html>
<?php ?>