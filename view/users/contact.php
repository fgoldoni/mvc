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
<div id="">
		<ul class="">
			<li class=''style="margin-top:10px;margin-bottom: -13px; margin-right: 20px;"> <?php echo $this->Session->flash();  ?>  </li>
			
		</ul>
</div>
<div id="main" class="clearfix">
		<div class="register">
				<div class="title">
					<div class="wrap">
					<h2 class="first"><img style="margin-top:-5px;" src="<?php echo Router::webroot('img/contact.png');?>"></h2>
                                       <h2>Nos Contacts</h2>
					</div>
				</div>
				<div class="bloc">
					<div class="wrap">
						<div class="customer">						

                                               <form action="<?php echo Router::url('users/contact/');?>" method="post">
                                                   <?= $this->Form->text('login', 'Pseudo'); ?>
                                                   <?= $this->Form->email('email', 'From:'); ?>
                                                   <?= $this->Form->select('service', 'Service', ['Boutique', 'Dépanage', 'Heimerdinger']); ?>
                                                   <?= $this->Form->textarea('message', 'Votre message'); ?>
                                                   <?= $this->Form->submit('Envoyer'); ?> 
						</form>

						</div>

						<div class="login">
							
						</div>
					</div>
				</div>
		</div>

	</div>
