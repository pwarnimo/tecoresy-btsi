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

    $("#btnRefresh").click(function() {
        loadNewestMessage("0");
    });

    $("#btnPost").click(function() {
        var values = new Array();
        $.each($("input[name='utypes[]']:checked"), function() {
            values.push($(this).val());
        });

        console.log(values);
        console.log("POSTING>" + $("#lsbState").val() + " : " + $("#edtMessageText").val());

        postMessage($("#edtMessageText").val(), $("#lsbState").val(), JSON.stringify(values));

        $("#edtMessageText").val("");

        loadNewestMessage("0")
    });

    $("#btnPgTerrains").click(function() {
        window.location = "main.php?page=terrainsv2";
    });

    $("#btnPgInvoices").click(function() {
        window.location = "main.php?page=invoices";
    });

    $("#btnPgUsers").click(function() {
        window.location = "main.php?page=usersv2";
    });

    var helpHtml = "<ul><li><span class=\"glyphicon glyphicon-refresh\"></span> Actualiser les données.</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    loadNewestMessage("0");

    console.log("PAGE LOADED!");
});

function postMessage(message, state, usertypes) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=postMessage",
        data       : {
            message : message,
            state   : state,
            utypes  : usertypes
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log(data);
        }
    });
};

function loadNewestMessage(usertype) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getLatestMessage",
        data       : {
            tuser : usertype
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("DATA>" + data);

            var result = JSON.parse(data)

            console.log("NEWEST_MSG>" + result[0]["dtMessageText"]);

            var msgIcon = "";

            switch (result[0]["fiMessageState"]) {
                case "1" :
                    msgIcon = "<span class=\"glyphicon glyphicon-info-sign\"></span>";
                    $("#message-text").addClass("text-info");

                    break;

                case "2" :
                    msgIcon = "<span class=\"glyphicon glyphicon-warning-sign\"></span>";
                    $("#message-text").addClass("text-warning");

                    break;

                case "3" :
                    msgIcon = "<span class=\"glyphicon glyphicon-exclamation-sign\"></span>";
                    $("#message-text").addClass("text-danger");

                    break;
            }

            $("#message-text").html(msgIcon + " " + result[0]["dtCreateTS"] + "> " + result[0]["dtMessageText"]);
        }
    });
};