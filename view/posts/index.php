<div class="page-header">
    <h1> Mon BLOG</h1>       
    
</div>
<div class="card-panel author-box hoverable">

    <div class="row center-on-small-only">
        <h5 class="text-center">About author</h5>
        <hr>
        <!--Avatar-->
        <div class="col-sm-3 ">
            <img src="http://brandflow.pl/wp-content/uploads/2015/03/michal.png" class="img-responsive">
        </div>
        <!--/.Avatar-->

        <!--Content-->
        <div class="col-sm-9">
            <h5 class="author-name">Michal Szymanski</h5>

            <div class="personal-sm">
                <a class="icons-sm email-ic"><i class="fa fa-home"> </i></a>
                <a class="icons-sm fb-ic"><i class="fa fa-facebook"> </i></a>
                <a class="icons-sm tw-ic"><i class="fa fa-twitter"> </i></a>
                <a class="icons-sm gplus-ic"><i class="fa fa-google-plus"> </i></a>
                <a class="icons-sm li-ic"><i class="fa fa-linkedin"> </i></a>
                <a class="icons-sm email-ic"><i class="fa fa-envelope-o"> </i></a>
            </div>
            <br>
            <!--Description-->
            <p class="author-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam deleniti explicabo mollitia, saepe dolore. Modi maiores dolore, officia, eos dolores eum aliquid laudantium earum maxime cumque provident, et vitae veritatis.</p>
            <!--/.Description-->
        </div>
        <!--Content-->
    </div>
</div>
<!--/.Author box-->
<?php foreach ($posts as $k => $v): ?>
<div class="card-panel author-box hoverable">
    <div class="row center-on-small-only">
        <h4 class="h4-responsive text-center"><?php echo $v->name; ?></h4>
        <hr>
        <div class="text-justify">
            <?php echo $v->content; ?>
         </div>
    <p><a href="<?php echo Router::url("posts/view/id:{$v->id}/slug:$v->slug"); ?>">Lire la suite &rarr;</a></p>
    </div>
    
</div>
<?php endforeach; ?>


    <ul class="pagination pag-circle">
        <li><a href="#!"><i class="material-icons">chevron_left</i></a></li>
        <?php for($i=1;$i<=$page;$i++): ?>
        <li <?php if($i==$this->request->page) echo 'class=active'; ?> ><a href='?page=<?php echo $i;?>'><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <li><a href="#!"><i class="material-icons">chevron_right</i></a></li>
    </ul>   


