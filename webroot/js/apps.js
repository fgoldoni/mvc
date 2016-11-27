
jQuery(function($) {
  $('.field-input').focus(function(){
    $(this).parent().addClass('is-focused has-label');
  });

  $('.field-input').each(function(){
    if($(this).val() != ''){
      $(this).parent().addClass('has-label');
    }
  });

  $('.field-input').blur(function(){
    $parent = $(this).parent();
    if($(this).val() == ''){
      $parent.removeClass('has-label');
    }
    $parent.removeClass('is-focused');
  });
  var popupCenter= function (url,titre,width,height) {
    var popupWidth = width ||640;
    var popupHeight = height || 320;
    var windowLeft=window.screenLeft || window.screenX;
    var windowTop=window.screenTop || window.screenY;
    var windowWidth=window.innerWidth || document.documentElement.clientWidth;
    var windowHeight=window.innerHeight || document.documentElement.clientHeight;

    var popupLeft = windowLeft + windowWidth / 2 - popupWidth / 2;
    var popupTop = windowTop + windowHeight / 2 - popupHeight / 2;
    var popup = window.open(url,titre,'scrollbars=yes, width='+ popupWidth +',height='+ popupHeight +',top='+ popupTop +',left='+ popupLeft +'');
     popup.focus();
    return true;
  };
  document.querySelector('.icoTwitter').addEventListener('click',function (e) {
    e.preventDefault();
    var url=this.getAttribute('data-url');
    var shareUrl='http://twitter.com/share?text='+ document.title +
        '&via=Goldoni'+
        '&url='+ encodeURIComponent(url);
    popupCenter(shareUrl,'Partager sur Twitter');
  });
  document.querySelector('.icoFacebook').addEventListener('click',function (e) {
    e.preventDefault();
    var url=this.getAttribute('data-url');
    var shareUrl='https://www.facebook.com/sharer/sharer.php?u='+ encodeURIComponent(url);
    popupCenter(shareUrl,'Partager sur facebook');
  });
  document.querySelector('.icoGoogle').addEventListener('click',function (e) {
    e.preventDefault();
    var url=this.getAttribute('data-url');
    var shareUrl='https://plus.google.com/share?url='+ encodeURIComponent(url);
    popupCenter(shareUrl,'Partager sur Google +');
  });
  document.querySelector('.icoLinkedin').addEventListener('click',function (e) {
    e.preventDefault();
    var url=this.getAttribute('data-url');
    var shareUrl='https://www.linkedin.com/shareArticle?url='+ encodeURIComponent(url);
    popupCenter(shareUrl,'Partager sur Linkedin');
  });
})
