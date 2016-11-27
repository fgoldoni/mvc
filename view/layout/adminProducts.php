<?php ?>

<!Doctype html>
<html>
<head>
   <meta charset="utf-8" />  
   <link rel="stylesheet" href="<?php  echo BASE_URL.'/css/bootstrap.css';?>" >
   <title><?php echo isset($title_for_layout)?$title_for_layout : 'Admin'?></title>
    <style>
        body {
            padding-top: 60px;
        }
    </style>
</head>
<body >
<body>

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
                <div class="btn-group" style="float: left;margin-top: 14px;">
                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo Router::url('users/logout');?>"><span class="glyphicon glyphicon-user"></span> Logout </a></li>
                    </ul>
                </div>
                <li><a href="<?php echo Router::url('products/index');?>">  Shop </a></li>
                <li> <a href="<?php echo Router::url('admin/products/index');?>" > Products </a></li>
                <li> <a href="<?php echo Router::url('admin/users/index');?>" >Users </a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

    <div class="container">
      <?php echo $this->Session->flash();  ?> 
       <?php echo $content_for_layout; ?> 

    </div>



</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php  echo BASE_URL.'/js/bootstrap.js';?>"></script>
<script type="text/javascript" src="<?php  echo BASE_URL.'/js/tablesorter.js';?>"></script>
<script type="text/javascript">
    jQuery(function ($) {
        $("#myTable").tablesorter({ sortList: [[0,0], [1,0]] });
    });

</script>


</html>
<?php ?>