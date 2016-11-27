<?php $pagesMenu=$this->request('Products','getMenu');?>
<div id="menu">
		<ul class="wrap">
			<li> <a href="<?php echo Router::url('admin/products/index/');?>">All Categories</a> </li>			
                        <?php foreach ($pagesMenu as $p ):?>
			<li>
                         <a href="<?php echo Router::url('admin/products/index/'.$p->category);?>"
                         title=" <?php echo $p->category;?>"> <?php echo $p->category;?> </a>                                                   
                        </li>
                        <?php endforeach; ?>
                        <form style="float:right;" method="post" action="<?php echo Router::url('admin/products/index/');?>" class="navbar-search" >
                        <input type="Search" name="search" class="form-control" placeholder="Search">
                        </form>
                        <span style="float:right;margin-top: 10px;"class="label label-info"><?=  isset($search)?$search.' Resultat(s)':''?></span>

		</ul>
</div>
<div class="page-header">
    <h1><?php echo $total.' Products'; ?></h1>
</div>
<table border="2" class="table table-bordered table-striped tablesorter" id="myTable" >
   <thead class="alert alert-success">
      <label><th ><input type="checkbox" id="selectAll" onchange="selectAll(this,'check')" > Tous</label></th>
      <th><span class="glyphicon glyphicon-filter"> ID</th>
      <th>En ligne ?</th>
      <th><span class="glyphicon glyphicon-filter"> Titre</th>
      <th><span class="glyphicon glyphicon-filter"> Prix</th>
      <th><span class="glyphicon glyphicon-filter"> Qte</th>
      <th><span class="glyphicon glyphicon-filter"> Description</th>
      <th ><span class="glyphicon glyphicon-cog"></span> Actions</th>
   </thead>
   <tbody>
       
    
        <?php foreach ($products as $k => $v):  ?>
      <tr><td> <input type="checkbox" class="check" id="<?php echo $v->id;?>" ></td>
      <td> <?php echo $v->id; ?></td>
      <td> <span class="label<?php echo ($v->online==1)?' label-success':''; ?>"><?php echo ($v->online==1)?'En ligne':'Hors ligne'; ?></span></td>
      <td><?php echo $v->name; ?></td>
      <td><?php echo $v->price; ?></td>
      <td><?php echo $v->quantity; ?></td>
      <td><?php echo substr($v->description,0,40); ?></td>
      <td>
          <a class="btn btn-warning" href="<?php echo Router::url('admin/products/edit/'.$v->id.'/'.$v->category);?>"><span class="glyphicon glyphicon-pencil"></span> Editer</a>
          <a class="btn btn-danger" onclick="return confirm('Voulez vous vraiment supprimer ce contenu');"
          href="<?php echo Router::url('admin/products/delete/'.$v->id);?>"><span class="glyphicon glyphicon-trash"></span> Suprimer</a>
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
<p><a class="btn btn-primary btn-large" href="<?php echo Router::url('admin/products/edit/'.$products[0]->category);?>">Ajouter une Page</a></p>
