<div class ="page-header">
    <h1> Editer un Products</h1>
    
</div>
<form  method="post" action="<?php echo Router::url('admin/products/edit/'.$id);?>" enctype="multipart/form-data">
<?php 
       if(isset($this->request->data->id)){
           $pagesMedia=$this->request('Medias','getMedia');
       }
       if($pagesMedia!=null){
?>
           <table><tr>
<?php
            foreach ($pagesMedia as $p ){
                
                if(($p->post_id==$this->request->data->id) && ($p->fileMin!=null)){
 ?> 
                   
                       <td> <img src="<?php echo Router::webroot('img/'.$p->fileMin);?>">
                       <a onclick="return confirm('Voulez vous vraiment supprimer ce contenu');"
                       href="<?php echo Router::url('admin/medias/del/'.$p->id);?>">[X]</a> 
                       <input type="radio" name="front" value="<?php echo $p->id;?>" <?php if($p->front==1) echo 'checked="checked"';?> /> 
                       
                       </td>                       
                  
 <?php                  
 
                }
                
             }
?> 
            </tr></table>
       
<?php }?>                
                                                                        
                                       
               





    <?php echo $this->Form->input('name','Titre');?>
    <?php echo $this->Form->input('id','hidden','hidden');?>  
    <?php echo $this->Form->input('slug','url');?>
    <?php echo $this->Form->input('description','Description');?>
    <?php echo $this->Form->input('category','Categorie');?>
    <?php echo $this->Form->input('quantity','Qte');?> 
    <?php echo $this->Form->input('price','Prix');?> 
    <?php echo $this->Form->input('file','Image','file');?> 
    <input type="checkbox" name="fr" value='1' />
    <?php echo $this->Form->input('content','Contenu','textarea',"8","60");?>
    <?php echo $this->Form->input('online','Metre en ligne','checkbox');?>
    <input class="btn btn-primary" type="submit" value="Ajouter"/>


</form>
<script type="text/javascript" src="<?php echo Router::webroot('js/tinymce/tiny_mce.js');?>"></script>

<script type="text/javascript">
tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
                relative_urls: false,
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,|,insertdate,inserttime,|,forecolor,backcolor",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},
                file_browser_callback : 'myFileBrowser'
	});
function myFileBrowser (field_name, url, type, win) {
    if(type=='file'){
        var explorer = '<?php echo Router::url('admin/posts/tinymce');?>';
    }else{
        var explorer = '<?php echo Router::url('admin/medias/index/'.$id);?>';
    }
 
    tinyMCE.activeEditor.windowManager.open({
        file : explorer,
        title : 'Galerie',
        width : 820,  
        height : 600,
        resizable : "yes",
        inline : "yes",  
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;
  }
</script>