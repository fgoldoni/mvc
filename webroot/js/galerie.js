$(document).ready(function(){
$("#galerie_big img").hide();
$("#galerie_big .voir").show();
    $("#galerie a").click(function(){
    if ($("#" + this.rel ).is(":hidden"))
        {
        $("#galerie_big img").hide();
        $("#" + this.rel ).show();
        }
    });
});
