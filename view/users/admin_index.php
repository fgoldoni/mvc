<form style="float:right;" method="post" action="<?php echo Router::url('admin/users/index/');?>" class="navbar-search" >
    <input type="Search" name="search" class="form-control" placeholder="Search">
</form>
<span style="float:right;margin-top: 10px;"class="label label-info"><?=  isset($search)?$search.' Resultat(s)':''?></span>
<div class="page-header">
    <h1><?php echo $total.' Utilisateurs'; ?></h1>
    
                
</div>

<table border="2" class="table table-bordered table-striped tablesorter" id="myTable" >
   <thead class="alert alert-success">
      <label><th ><input type="checkbox" id="selectAll" onchange="selectAll(this,'check')" > Tous</label></th>
      <th><span class="glyphicon glyphicon-filter"> ID</th>
      <th><span class="glyphicon glyphicon-filter"> Login </th>
      <th><span class="glyphicon glyphicon-filter"> Email</th>
      <th><span class="glyphicon glyphicon-filter"> Date d'Inscription</th>
      <th>role</th>
      <th>Activer</th>
      <th ><span class="glyphicon glyphicon-cog"></span> Actions</th>

   </thead>
   <tbody>
    
      <?php foreach ($users as $k => $v):  ?>
      <?php
            $id=$v->id;
            $login=$v->login;
            $email=$v->email;
            $role=$v->role;
            $confirmation_at=$v->confirmation_at;
      ?>
      <tr><td> <input type="checkbox" class="check" id="<?php echo $id;?>" ></td>
      <td> <?php echo $v->id; ?></td>
      <td> <span class="glyphicon glyphicon-user"></span><?php echo " ".$login; ?></td>
      <td> <span class="glyphicon glyphicon-envelope "></span><?php echo " ".$email; ?></td>
      <td> <?php echo $confirmation_at; ?></td>
      <td> <?php echo $role; ?></td>
      <td> <span class="label<?php echo ($v->confirmation_at!=null)?' label-success':''; ?>"><?php echo ($confirmation_at!=null)?'Activer':'Pas Activer'; ?></span></td>
      <td>
          <a class="btn btn-warning" href="<?php echo Router::url('admin/users/edit/'.$id);?>"><span class="glyphicon glyphicon-pencil"></span> Editer</a>
          <a class="btn btn-danger" onclick="return confirm('Voulez vous vraiment supprimer ce contenu');"
          href="<?php echo Router::url('admin/users/delete/'.$id);?>"><span class="glyphicon glyphicon-trash"></span> Suprimer</a>
      </td>
      </tr>

   
    <?php endforeach; ?>
   
   <tbody>    
</table>
<a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Spprimer </a>
<nav>
    <ul class="pagination">
        <li><a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a></li>
            <?php for($i=1;$i<=$page;$i++): ?>
            <li <?php if($i==$this->request->page) echo 'class=active'; ?> ><a href='?page=<?php echo $i;?>'><?php echo $i; ?></a></li>
            <?php endfor; ?>
        <li><a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a></li>

    </ul>

</nav>
<p><a class="btn btn-primary btn-large" href="<?php echo Router::url('admin/users/edit/');?>">Ajouter un utilisateur</a></p>
