/**
 * Created by Henry Bravo cel 973772738.
 */
var cargando="<i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i><span class='sr-only'>Loading...</span>";
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    $.fn.select2.defaults.set("width", "100%");
})

var home = "";

$(document).ready(function () {
    home = $("#baseUrl").val();
    var href=window.location.href;
    var array=href.split("?");
    if(array[1]==='sinmarcos'){
        $(".sinmarcos").hide();
        $(".container-fluid").css("margin-top","-1em");
        $(".side-body").css("margin-left","0px").css("margin-right","0px");
       // document.body.style.overflowY = "hidden";
    }
    else {
        $("#cabecera").css("margin-top","0");
    }
    if(array[2]==='sinoverflow'){
         document.body.style.overflowY = "hidden";
    }
});
