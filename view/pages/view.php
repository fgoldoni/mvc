<?php $title_for_layout= $page->name;?>
<h1></h1>

<div class="row">
    <div class="col-md-12 blog-column">
        <div class="view overlay hm-blue-slight z-depth-2">
            <a><img src="http://mdbootstrap.com/images/slides/slide%20(13).jpg" class="img-responsive">
                <div class="mask waves-effect waves-light "></div>
            </a>
        </div>

        <div class="card-panel bl-panel text-center hoverable">
            <a href=""><h3 class="black-text"><?php echo $page->name;?><i class="material-icons">chevron_right</i></h3></a>
            <h5>Written by <a href="#">Michal Szymanski</a> | 21.10.2015</h5>
            <!--Social Counter-->
            <div class="hidden-xs">
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
            <hr>
            <p class="text-left"><?php echo $page->content;?></p>
        </div>
    </div>
</div>
<!--/.Post row-->
