$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#settings").addClass("linkact");

    $("#btnAdd").html("Sauvegarder");
    $("#btnEdit").attr("disabled", "disabled");
    $("#btnDelete").attr("disabled", "disabled");

    $("#btnAdd").click(function() {

    });

    console.log("PAGE LOADED!");
});

function checkForUpdates() {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=checkUpdate",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {

        }
    });
};