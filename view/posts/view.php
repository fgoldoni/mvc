<?php $title_for_layout= $post->name;?>
<div class="card-panel author-box hoverable">
    <div class="row center-on-small-only">
        <h4 class="h4-responsive text-center"><?php echo $post->name; ?></h4>
        <hr>
        <div class="text-justify">
        <?php echo $post->content; ?>
        </div>
    </div>
    <div class="text-center ">
    <!--Social Counter-->
    <div class="hidden-xs center-on-small-only">
        <a class="btn-sm-full fb-bg rectangle waves-effect waves-light"><i class="fa fa-facebook"> </i> <span>Facebook</span> </a><span class="badge social-counter">5</span>
        <a class="btn-sm-full tw-bg rectangle waves-effect waves-light"><i class="fa fa-twitter"> </i> <span>Twitter</span></a><span class="badge social-counter">5</span>
        <a class="btn-sm-full gplus-bg rectangle waves-effect waves-light"><i class="fa fa-google-plus"> </i> <span>Google +</span></a><span class="badge social-counter">5</span>
        <a class="btn-sm-full comm-bg rectangle waves-effect waves-light"><i class="fa fa-comments"> </i> <span>Comments</span></a><span class="badge social-counter">5</span>
    </div>
    <!--/.Social Counter-->
        <!--Social Counters for mobile-->
        <div class="visible-xs">
                <span class="counter-wrapper">
                <a class="btn-sm fb-bg rectangle waves-effect waves-light">
                    <i class="fa fa-facebook"> </i>
                </a>
                <span class="badge social-counter">5</span>
                </span>

                <span class="counter-wrapper">
                <a class="btn-sm tw-bg rectangle waves-effect waves-light">
                    <i class="fa fa-twitter"> </i>
                </a>
                <span class="badge social-counter">5</span>
                </span>

                <span class="counter-wrapper">
                <a class="btn-sm gplus-bg rectangle waves-effect waves-light">
                    <i class="fa fa-google-plus"> </i>
                </a>
                <span class="badge social-counter">5</span>
                </span>
                <span class="counter-wrapper">
                <a class="btn-sm comm-bg rectangle waves-effect waves-light">
                    <i class="fa fa-comments"> </i>
                </a>
                <span class="badge social-counter">5</span>
                </span>
        </div>
        <!--/.Social Counters for mobile-->
    </div>
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


<!--Multi-item panel-->
<div class="card-panel horizontal-listing no-padding comments-section">
    <h5 class="text-center title">Comments <span class="label">3</span></h5>
    <hr>
    <div class="container-fluid">

        <!--First row-->
        <div class="row hoverable">
            <div class="col-sm-2">
                <img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-1.jpg" class="img-responsive img-circle z-depth-">
            </div>
            <div class="col-sm-10">
                <a href="#"><h5 class="title">John Sulivan <i class="fa fa-reply"> Reply</i></h5></a>
                <i class="fa fa-clock-o"> 05/10/2015</i>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores illum impedit dolor possimus architecto labore.</p>
            </div>
        </div>
        <!--/.First row-->

        <!--Second row-->
        <div class="row hoverable">
            <div class="col-sm-2">
                <img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-2.jpg" class="img-responsive img-circle z-depth-">
            </div>
            <div class="col-sm-10">
                <a href="#"><h5 class="title">Anna Maria <i class="fa fa-reply"> Reply</i></h5></a>
                <i class="fa fa-clock-o"> 05/10/2015</i>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores illum impedit dolor possimus architecto labore.</p>
            </div>
        </div>
        <!--/.Second row-->

        <!--Third row-->
        <div class="row hoverable">
            <div class="col-sm-2">
                <img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-3.jpg" class="img-responsive img-circle z-depth-">
            </div>
            <div class="col-sm-10">
                <a href="#"><h5 class="title">Sara Romano <i class="fa fa-reply"> Reply</i></h5></a>
                <i class="fa fa-clock-o"> 05/10/2015</i>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores illum impedit dolor possimus architecto labore.</p>
            </div>
        </div>
        <!--/.Third row-->

    </div>
</div>
<!--/.Multi-item panel-->

<!--Reply Form-->
<div class="card-panel reply-section hoverable">
    <div class="row">
        <h5 class="text-center">Leave a comment</h5>
        <hr>
        <form class="col-md-12">
            <div class="input-field">
                <i class="material-icons prefix">account_circle</i>
                <input id="reply-name" type="text" class="validate">
                <label for="reply-name">Your name</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">mail</i>
                <input id="reply-mail" type="email" class="validate">
                <label for="reply-mail">Your email</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">home</i>
                <input id="reply-www" type="text" class="validate">
                <label for="reply-www">Your website</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">mode_edit</i>
                <textarea id="reply-text" class="materialize-textarea"></textarea>
                <label for="reply-text">Your message</label>
            </div>
        </form>
        <div class="text-center">
            <button type="button" class="btn btn-primary waves-effect waves-light">Submit</button>
        </div>

    </div>
    <!--./Main row-->
</div>
<!--Reply section-->
