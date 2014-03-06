var oTable;

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    $("#dlgAddTerrain").hide();
    $("#dlgChangeState").hide();
    $("#dlgDeleteTerrain").hide();

    console.log("PAGE LOADED!");
});