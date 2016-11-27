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

		<ul class="" style="margin-top:-9px;margin-bottom: -13px; float: right;">
			<li  > <a class='btn  btn-primary' href="<?php echo Router::url('payers/paypal');?>">PAYER</a> </li>
			
		</ul>
                 
                <?php
                 if(isset($_SESSION['span'])){
                ?>
                <span style=" float: right;margin-right:9px" class="btn btn-success"><?php
                    echo $_SESSION['span'];
                    unset($_SESSION['span']);
                }
                ?></span>
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


            <a href="<?php echo Router::url('users/register/');?>">S'inscrire</a> or <a href="<?php echo Router::url('users/register/');?>">Creer um compte</a></h2>
        <?php }?>
    </div>



</div>

	<div id="main" class="clearfix">
		<div class="checkout">
			<div class="title">
				<div class="wrap">
				<h2 class="first">Votre Panier <?php echo $this->Session->flash();?></h2>
				</div>
			</div>
                    <form method="post" action="<?php echo Router::url('products/panier/');?>">                   
			<div class="table">
				<div class="wrap">

					<div class="rowtitle">
						<span class="name">Product name</span>
						<span class="price">Price</span>
						<span class="quantity">Quantity</span>
						<span class="subtotal">Subtotal</span>
						<span class="action">Actions</span>
					</div>
                                        <?php foreach ($products as $product):?> 
                                        <?php foreach ($medias as $media){
                                        if($product->id==$media->post_id){
                                        $img= Router::webroot('img/'.$media->fileMin);  
                                        }
                                        } ?>                                   
					<div class="row">
						<a href="#" class="img"> <img src="<?php  echo $img;?>"></a>
                                                <span class="name"><?=$product->name;?></span>
						<span class="price"><?= number_format($product->price,2,',',' ');?> €</span>
						<span class="quantity"><input type="text" name="panier[quantity][<?php echo $product->id;?>]" value="<?= $_SESSION['panier'][$product->id];?>"></span>
						<span class="subtotal"><?= number_format($product->price*$_SESSION['panier'][$product->id],2,',',' ');?> €</span>
						<span class="action">
							<a href="<?php echo Router::url('products/del/'.$product->id);?>" class="del"><img src="<?php  echo BASE_URL.'/img/del.png';?>"></a>
						</span>
					</div>
                                        <?php endforeach;?>
                                        <input class="input" type="submit" value="Recalculer" >
				<div class="rowtotal">
						Grand Total : <span class="total"><?= number_format($total,2,',',' ');?> €</span>
					</div>
				</div>
			</div>
                        </form>
		</div>

	</div>
        <div id="pagination">
	<ul class="wrap">
	<?php for($i=1;$i<=$page;$i++): ?>
        <li class='page'<?php if($i==$this->request->page) echo 'class=active'; ?> ><a href='?page=<?php echo $i;?>'><?php echo $i; ?></a></li>
        <?php endfor; ?>
	</ul>
        </div>
