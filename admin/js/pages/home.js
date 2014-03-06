$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#main").addClass("linkact");

    $("#btnAdd").attr("disabled", "disabled");
    $("#btnEdit").attr("disabled", "disabled");
    $("#btnDelete").attr("disabled", "disabled");

    console.log("PAGE LOADED!");
});