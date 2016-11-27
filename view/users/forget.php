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
					<h2 class="first">Reinitiaser</h2>
					<h2>Mon mot de Passe</h2>
					</div>
				</div>
				<div class="bloc">
					<div class="wrap">
						

						<div class="login">
							<form class="form-horizontal" action="<?php echo Router::url('users/forget');?>" method="post">


							

							 <div class="field">
							<label for="email" class="field-label">Email</label>
							<input type="email" id="inputEmail" name="email" class="field-input" >
							</div>

							<div >
							<input class="btn btn-primary" type="submit" name="submit" value="Reinitialiser" id="submit" />
							</div>

							</form>
						</div>
					</div>
				</div>
		</div>

	</div>