<div class="container">
<div class ="page-header">
    <h1> Editer un utilisateur</h1>
    
</div>
<div class="col-lg-8"
<form  method="post" action="<?php echo Router::url('admin/users/edit/');?>" class="form-group">

    <?php echo $this->Form->input('id','id');?>
    <?php echo $this->Form->input('id','hidden','hidden');?>  
    <?php echo $this->Form->input('login','Login');?>  
    <?php echo $this->Form->input('email','email');?>  
    <?php echo $this->Form->input('confirmation_at','Date d\'Inscription','date');?>
    <input class="btn btn-primary" type="submit" value="Ajouter"/>


</form>
    
#
