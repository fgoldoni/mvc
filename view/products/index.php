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
        <a href="#" class="" style="float: right;"><span class="glyphicon glyphicon-list"></span> Profil</a>
            </h2></div>
	</div>

      
	<div id="main" class="clearfix">
		<div class="home">
			<div class="row">
				<div class="wrap">
                                    <?php foreach ($products as $product):?>
                                    <?php foreach ($medias as $media){
                                     if($product->id==$media->post_id){
                                      $img= Router::webroot('img/'.$media->file);  
                                     }
                                     }
                                     if(!isset($img))$img= Router::webroot('img/image.png');
                                     ?>
					<div class="box">
						<div class="product full">
							<a href="<?php echo Router::url('products/view/'.$product->id.'/'.$product->category);?>">
                                                            <img src="<?php  echo $img; ?>" alt="">
							</a>
							<div class="description">
								<?= $product->name;?>
								<a href="#" class="price"><?= number_format($product->price,2,',',' ');?> €</a>
							</div>
							<a href="<?php
                                                        if($this->Session->isLogged()) echo Router::url('products/panier/'.$product->id.'/'.$product->category);?>"<?php if(!$this->Session->isLogged())echo "title= 'Connetez vous pour acceder au panier !'";?>class="gift addPanier">
								Gift
							</a>
							<div class="rating">
								<span>Rating :</span>
								<ul>
									<li><a href="#">1</a></li>
									<li><a href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">4</a></li>
									<li><a href="#" class="off">5</a></li>
								</ul>
							</div>
							<a class="add addPanier" href="<?php 
                                                        if($this->Session->isLogged())echo Router::url('products/panier/'.$product->id.'/'.$product->category);
                                                       
                                                        ?>"<?php if(!$this->Session->isLogged())echo "title= 'Connetez vous pour acceder au panier !'";?>>
								add
							</a>
						</div>
					</div>
                                    <?php endforeach;?>
					
				</div>
			</div>
			
		</div>		
	</div> 
<div id="pagination">
	<ul class="wrap">
	<?php for($i=1;$i<=$page;$i++): ?>
            <li class='page'<?php if($i==$this->request->page) echo 'class=active'; ?> ><a href='?page=<?php echo $i;?>&search=<?php if(isset($repeat_search))echo $repeat_search;?>'><?php echo $i; ?></a></li>
        <?php endfor; ?>
	</ul>
</div>
