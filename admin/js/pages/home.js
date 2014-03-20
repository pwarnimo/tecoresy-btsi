$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#main").addClass("linkact");

    $("#btnAdd").attr("disabled", "disabled");
    $("#btnEdit").attr("disabled", "disabled");
    $("#btnDelete").attr("disabled", "disabled");

    $("#messagebox").hide();

    $("#btnShowMsgBox").click(function() {
        $("#messagebox").slideToggle("fast", function() {
            // Animation complete.
        });
    });

    console.log("PAGE LOADED!");
});

function postMessage(message) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=postMessage",
        data       : {
            message : message
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {

        }
    });
};

function loadMessages() {

};