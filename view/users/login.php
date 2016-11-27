<div class ="page-header">
    <h1> Zone reserve </h1>
    
</div>
<form class="form-signin" method="post" action="<?php echo Router::url('users/login');?>">

    <?php echo $this->Form->input('login','Identifiant');?>
    <?php echo $this->Form->input('password','Mot de passe','password');?>     
    <input type="submit" class="btn btn-large btn-primary" value="Se connecter"/>


</form>

