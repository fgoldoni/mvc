<?php ?>

<!Doctype html>
<html>
<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" href="<?php  echo BASE_URL.'/css/style.css';?>" >  
   <link rel="stylesheet" href="<?php  echo BASE_URL.'/css/bootstrap.css';?>" >    
   <title><?php echo isset($title_for_layout)?$title_for_layout : 'Admin'?></title> 
   <style>
      body {
        padding-top: 100px;
      }
    </style>
</head>
<body >
    
	</header>
		<div id="body">
			
                    <div class="admin">
			
                       
                        
                       
                       <?php echo $this->Session->flash();  ?>
                       <?php echo $content_for_layout; ?>                           

                        
			
			</div>
		</div>
	
	</div>
</body>

<?php ?>