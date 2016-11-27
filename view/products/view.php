<?php $pagesMenu=$this->request('Products','getMenu');?>
<div id="menu">
    <ul class="wrap">
        <li> <a href="<?php echo BASE_URL.'/products/index/'?>">All Categories</a> </li>
        <?php foreach ($pagesMenu as $p ):?>
            <li>
                <a href="<?php echo BASE_URL.'/products/index/'.$p->category;?>"
                   title=" <?php echo $p->category;?>"> <?php echo $p->category;?> </a>
            </li>
        <?php endforeach; ?>
        <li> <a href="<?php echo BASE_URL.'/users/contact/'?>">Contact</a> </li>
    </ul>
    <span class="label label-info"><?=  isset($search)?$search.' Resultat(s)':''?></span>
    <form method="post" action="<?php echo BASE_URL.'/products/index/'?>" class="navbar-search">
        <input type="Search" name="search" class="search-query" placeholder="Search">
    </form>
</div>
<div id="subheader">
    <div class="wrap">
        <h2 style="color:red;">
            <?php
            if($this->Session->isLogged()){
                echo "<span class='glyphicon glyphicon-user'></span> ".$this->Session->user('login')."( ".$this->Session->user('id')." )<span class='glyphicon glyphicon-play'></span>";?>
                <a href="<?php echo Router::url('users/logout');?> "> <span class="glyphicon glyphicon-off"> Deconnecter</a>

            <?php }  else {
                echo "Bienvenue ";?>


                <a href="<?php echo Router::url('users/register/');?>">S'inscrire</a> or <a href="<?php echo Router::url('users/register/');?>">Creer um compte</a>
            <?php }?>
            <a href="<?php echo Router::url('users/profil/');?> " class="" style="float: right;"><span class="glyphicon glyphicon-list"></span> Profil</a>
        </h2></div>
</div>
<div class="container">
    <div class="row">
        <div class=" span7 ">
        <div class="tabbable tabs-left "id="galerie">
        
        <ul class="nav nav-tabs" id="galerie_nav" >
            
                <?php foreach ($medias as $media):?> 
                <li>
                    <a rel="<?php echo $media->id;?>" href="#"><img src="<?php echo Router::webroot('img/'.$media->fileMin);?>" /></a>
                </li>
                 <?php endforeach;?> 
            
        </ul>
        <div class="tab-content" id="galerie_big">
            <?php $i=0;foreach ($medias as $media):?> 
            <img id="<?php echo $media->id;?>" class="<?php if($i==0){echo 'voir';$i++;}?>" src="<?php echo Router::webroot('img/'.$media->fileBig);?>" />
            <?php endforeach;?>
           
        </div>
        </div> 

 

        </div>
        <div class=" span5 " >
            <div class="col-xs-12">
            <?php if(isset($products[0]->name))echo '<h4 class=""> '.$products[0]->name.'</h4>';?>
            <?php  if(isset($products[0]->description))echo '<p class=""> '.$products[0]->description.'</p>';?>
            <?php if(isset($products[0]->quantity))echo  '<p style="color:red;"  class=""> '.$products[0]->quantity.' Restant(s)</p>';?>    
            <?php if(isset($products[0]->price))echo  '<p style="color:green;"  class=""> Prix: '.$products[0]->price.'€</p>';?>
                <form method="post" class="form-inline" action="<?php if($this->Session->isLogged()){ echo Router::url('products/panier/'.$products[0]->id);}  else {echo "#";}?>">
                   <label class="control-label">Qte</label>
                   <input name="panier[quantity][<?php echo $products[0]->id;?>]" type="number" class="input-small" value="1" min="1" max="<?php if(isset($products[0]->quantity))echo  $products[0]->quantity;?>">
                   <label class="control-label">Couleur</label>
                    <select name="color" class="input-small">
                            <optgroup >
                            <option value="Blanc">Blanc</option>
                            <option value="Blanc">Noir</option>
                            <option value="Blanc">Vert</option>
                            </optgroup>
                    </select>
            <div class="input" style="margin-top:20px;">
                <div class="input-large">
                <input type="image" src="<?php echo Router::webroot('img/panier.png');?>">
                </div>
            </div>
            </form>
            
        
        
        </div>
        </div>
        <div class=" span7 " style="text-align: justify;margin-top: 20px;padding-bottom: 10px;">
            <?php if(isset($products[0]->content))echo  '<blockquote> '.$products[0]->content.'</blockquote>';?>

            <address style="text-align: right;">
                <strong>Goldoni, Inc.</strong><br>
                22143 hamburg, Suite 600<br>
                Sieker landstraße, CA 94107<br>
                <abbr title="Phone">P:</abbr> (123) 456-7890
            </address>
            <address style="text-align: right;">
                <strong>Full Name</strong><br>
                <a href="mailto:#">first.last@example.com</a>
            </address>
        </div>

        <div class="col-md-12">
            <ul class="social-network social-circle">
                <li><a href="#" class="icoFacebook" title="Facebook" data-url="http://www.fgoldoni.de"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" class="icoTwitter" title="Twitter" data-url="http://www.fgoldoni.de"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" class="icoGoogle" title="Google +" data-url="http://www.fgoldoni.de"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#" class="icoLinkedin" title="Linkedin" data-url="http://www.fgoldoni.de"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
        </div>
</div>
        

       

<style>
#galerie img {
border: none;
}
#galerie_nav {
text-align: center;
}
#galerie_big {
overflow: hidden;
margin:0 auto;
}

#galerie_big img {
display: block;
margin-top: 10px;
}

</style>

