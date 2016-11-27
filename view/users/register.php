 
<div id="">
		<ul class="">
			<li class=''style="margin-top:10px;margin-bottom: -13px; margin-right: 20px;"> <?php echo $this->Session->flash();  ?>  </li>
			
		</ul>
</div>
<div>

</div>
<div id="subheader">
	<div class="wrap">
		
	</div>
</div>
<div id="main" class="clearfix">
		<div class="register">
				<div class="title">
					<div class="wrap">
					<h2 class="first"><img style="margin-top:-5px;" src="<?php echo Router::webroot('img/d_membre.png');?>"></h2>
                                        <h2 ><img style="margin-top:0px;" src="<?php echo Router::webroot('img/membre.png');?>"></h2>
					</div>
				</div>
				<div class="bloc">
					<div class="wrap">
						<div class="customer">						

                                                    <form action="<?php echo Router::url('users/register/');?>" method="post">

						<?= $this->Form->text('login', 'Pseudo'); ?>
                                                <?= $this->Form->email('email', 'Votre Email'); ?>
                                                <?= $this->Form->password('password', 'Password :'); ?>
                                                <?= $this->Form->password('password_confirm', 'Password Confirm:'); ?>
                                                <?= $this->Form->submit('Creer un Compte'); ?> 
						</form>
                                                

						</div>

						<div class="login">
							<form action="<?php echo Router::url('users/login/');?>" method="post">


							<?= $this->Form->text('login', 'Email ou Pseudo :'); ?>
							<?= $this->Form->password('password', 'Password :'); ?>
                                                        <div class="field">
                                                        <a href="<?php echo Router::url('users/forget');?>">(J'ai oublier mon mot de passe)</a>
							</div>
                                                        <div class="field">
                                                        <label for="test" class="checkbox rounded-checkbox">
                                                            <input  value="1" type="checkbox" id="test" class="checkbox" name="remember">
                                                            <span class="check"><span></span></span>
                                                            Se souvenir de moi
                                                        </label>
                                                        </div>
							<div >
                                                        <?= $this->Form->submit('Se Connecter'); ?> 
							</div>

							</form>
						</div>
					</div>
				</div>
		</div>

	</div>