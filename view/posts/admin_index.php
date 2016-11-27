<div class="page-header">
    <h1><?php echo $total.' Articles'; ?></h1>
</div>

<table border="2" class="table table-bordered" >
   <thead>
      <th>ID</th>
      <th>En ligne ?</th>
      <th>Titre</th>
      <th>Actions</th>
   </thead>
   <tbody>
    
        <?php foreach ($posts as $k => $v):  ?>
   <tr>
      
      <td> <?php echo $v->id; ?></td>
      <td> <span class="label<?php echo ($v->online==1)?' label-success':''; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span></td>
      <td><?php echo $v->name; ?></td>
      <td>
          <a class="btn btn-warning" href="<?php echo Router::url('admin/posts/edit/'.$v->id);?>">Editer</a>
          <a class="btn btn-danger" onclick="return confirm('Voulez vous vraiment supprimer ce contenu');"
          href="<?php echo Router::url('admin/posts/delete/'.$v->id);?>">Suprimer</a>
      </td>
      
   </tr>
   
    <?php endforeach; ?>
   <tbody>
</table>
<p><a class="btn btn-primary btn-large" href="<?php echo Router::url('admin/posts/edit/');?>">Ajouter un Article</a></p>