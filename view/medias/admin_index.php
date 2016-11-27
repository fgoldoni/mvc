<table border="1" class="table table-striped" >
   <thead>
      
      <th></th>
      <th>Titre</th>
      <th>Actions</th>
   </thead>
   <tbody>
    
        <?php foreach ($images as $k => $v):  ?>
   <tr>
      
      
       <td> 
           <a href="#" onclick="FileBrowserDialogue.sendURL('<?php echo Router::webroot('img/'.$v->file);?>')">
           <img src="<?php echo Router::webroot('img/'.$v->file);?>" height="100" width="120"/>
           </a>
       </td>
      <td><?php echo $v->name; ?></td>
      <td>         
          <a class="btn btn-danger" onclick="return confirm('Voulez vous vraiment supprimer ce contenu');"
          href="<?php echo Router::url('admin/medias/delete/'.$v->id);?>">Suprimer</a>
      </td>
      
   </tr>
   
    <?php endforeach; ?>
   <tbody>
</table>
<div id="div_header">	               
	<h3 class="btn btn-large btn-primary disabled">Ajouter une image</h3>				
</div>
<?php if (is_array($post_id))$post_id=  intval($post_id[0]);?>
<form  method="post" action="<?php echo Router::url('admin/medias/index/'.$post_id);?>" enctype="multipart/form-data">

    <?php echo $this->Form->input('file','Image','file');?>
    <?php echo $this->Form->input('name','Titre');?>     
    <input class="btn btn-primary" type="submit" value="Ajouter"/>


</form> 
<script type="text/javascript" src="<?php echo Router::webroot('js/tinymce/tiny_mce_popup.js');?>"></script>
<script type="text/javascript">
var FileBrowserDialogue = {
    init : function () {
        // Here goes your code for setting your custom things onLoad.
    },
    sendURL : function (URL) {
        
        var win = tinyMCEPopup.getWindowArg("window");

        // insert information now
        win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;

        // are we an image browser
        if (typeof(win.ImageDialog) != "undefined") {
            // we are, so update image dimensions...
            if (win.ImageDialog.getImageData)
                win.ImageDialog.getImageData();

            // ... and preview if necessary
            if (win.ImageDialog.showPreviewImage)
                win.ImageDialog.showPreviewImage(URL);
        }

        // close popup window
        tinyMCEPopup.close();
    }
}

tinyMCEPopup.onInit.add(FileBrowserDialogue.init, FileBrowserDialogue);
</script>