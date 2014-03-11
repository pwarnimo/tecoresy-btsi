$(document).ready(function() {
    var bodyHeight = $("body").height();
    var vwptHeight = $(window).height();
    if (vwptHeight > bodyHeight) {
        $("footer#colophon").css("position","absolute").css("bottom",0);
    }

    $("#help-wrapper").hide();

    $("#btnHelp").click(function() {
        $("#help-wrapper").slideToggle("fast", function() {
            if ($("#help-wrapper").is(":visible")) {
                $("#btnHelp").removeClass("btn-default");
                $("#btnHelp").addClass("btn-primary");
                $("#btnHelp").addClass("active");
            }
            else {
                $("#btnHelp").removeClass("btn-primary");
                $("#btnHelp").addClass("btn-default");
                $("#btnHelp").removeClass("active");
            }
        });
    });

    /*$(".sidebar-nav li").click(function() {
        $(".sidebar-nav li").removeClass("linkact");
        $(this).addClass("linkact");
    });*/
});