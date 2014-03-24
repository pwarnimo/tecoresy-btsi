//var oTable;

var currentTerrain = 1;

var weekday=new Array(7);

weekday[0]="DIM";
weekday[1]="LUN";
weekday[2]="MAR";
weekday[3]="MER";
weekday[4]="JEU";
weekday[5]="VEN";
weekday[6]="SAM";

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- New reservation --

$("#dlgAddReservation").hide();

function DlgAddReservation(date, time, player1, player2) {
    this.date = date;
    this.time = time;
    this.player1 = player1;
    this.player2 = player2;
};

DlgAddReservation.prototype.showDialog = function() {
    $("#dlgAddReservation").dialog({
        resizable: false,
        height: 280,
        width: 400,
        modal: true,
        buttons: {
            Ajouter: function() {

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });
};

// -- Edit reservation --

// -- De/Activate reservation --

$("#dlgResStatus").hide();

function DlgResStatus(status) {
    this.status = status;
}

DlgResStatus.prototype.showDialog = function() {
    var currId = this.status;

    console.log(">> - " + currId);

    var dateID = currId.substr(0,10);
    var hourID = "";

    $("#dlgResStatus").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log("BLOCK-->" + dateID);

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });
};

// -- Remove reservation --

// -- De/Block terrain --

// -- New terrain --

// -- Remove terrain --

/* ------------------------------------------------------------------------------------------------------------------ */

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    buildTable();

    getReservationCounts();

    $("#btnRefresh").click(function() {
        getReservationsForTerrain(currentTerrain);
    });

    $("#terrainSwitcher li").click(function() {
        console.log("Switching to terrain " + $(this).attr("id"));

        $(".icons").html("");

        $("#terrainSwitcher li").removeClass("active");
        $("#terrainSwitcher li a").removeClass("tabactive");

        //var tabstring = "Terrain " + $(this).find("a").html();

        //$(this).find("a").html(tabstring);
        $(this).addClass("active");
        $(this).find("a").addClass("tabactive");

        $("#dataTerrains tbody td").removeClass("reserved");
        $("#dataTerrains tbody td").removeClass("blocked");

        var tid = $(this).attr("id").substring(1);

        currentTerrain = tid;

        getReservationsForTerrain(tid);
        getBlockedReservationsForTerrain(tid)
    });

    $(".cal").hover(function() {
        $(this).find(".controls").show();
    },
    function() {
        $(this).find(".controls").hide();
    });

    $(".controls").hide();

    var helpHtml = "<ul><li><span class=\"glyphicon glyphicon-refresh\"></span> Actualiser les données sur les reservations/terrains.</li>" +
        "<li><span class=\"glyphicon glyphicon-plus-sign\"></span> Ajouter une nouvelle reservation/un nouveau terrain.</li>" +
        "<li><span class=\"glyphicon glyphicon-pencil\"></span> Modifier la reservation/le terrain selectioné.</li>" +
        "<li><span class=\"glyphicon glyphicon-trash\"></span> Supprimer un ou plusieurs reservations/terrains. Fonctionne aussi avec \"glisser-déposer\"</li>" +
        "<li><span class=\"glyphicon glyphicon-ok-circle\"></span>/<span class=\"glyphicon glyphicon-remove-circle\"></span> Bloquer / Debloquer le terrain.</li></ul>" +
        "<p>Status des reservations</p>" +
        "<ul><li><img src=\"images/reserved.jpg\"> Le terrain est reservé pour l'heure indiqué.</li>" +
        "<li><img src=\"images/blocked.jpg\"> Les utilisateurs ne peut pas fait une reservation pour l'heure indiqué sur le terrain.</li>" +
        "<li><img src=\"images/expired.jpg\"> La reservation est expiré.</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    console.log("PAGE LOADED!");
});

function buildTable() {
    var tHtml = "";
    var dates = new Array();

    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getDateSpan",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            var result = JSON.parse(data);

            tHtml += "<tr><th width=\"85px\">Heures</th>";

            for (var i = 0; i < result.length; i++) {
                var d = new Date(result[i]["idDate"]);

                dates.push(result[i]["idDate"]);

                tHtml += "<th>" + weekday[d.getDay()] + " (" + result[i]["idDate"] + ")</th>";
                console.log("AREQ2>" + result[i]["idDate"]);
            }

            tHtml += "</tr>";

            $("#dataTerrains thead").html(tHtml);
        },
        async      : false
    });

    tHtml = "";

    var times = [
        "08<span class=\"sup\">00</span> - 09<span class=\"sup\">00</span>",
        "09<span class=\"sup\">00</span> - 10<span class=\"sup\">00</span>",
        "10<span class=\"sup\">00</span> - 11<span class=\"sup\">00</span>",
        "11<span class=\"sup\">00</span> - 12<span class=\"sup\">00</span>",
        "12<span class=\"sup\">00</span> - 13<span class=\"sup\">00</span>",
        "13<span class=\"sup\">00</span> - 14<span class=\"sup\">00</span>",
        "14<span class=\"sup\">00</span> - 15<span class=\"sup\">00</span>",
        "15<span class=\"sup\">00</span> - 16<span class=\"sup\">00</span>",
        "16<span class=\"sup\">00</span> - 17<span class=\"sup\">00</span>",
        "17<span class=\"sup\">00</span> - 18<span class=\"sup\">00</span>",
        "18<span class=\"sup\">00</span> - 19<span class=\"sup\">00</span>",
        "19<span class=\"sup\">00</span> - 20<span class=\"sup\">00</span>",
        "20<span class=\"sup\">00</span> - 21<span class=\"sup\">00</span>",
        "21<span class=\"sup\">00</span> - 22<span class=\"sup\">00</span>"
    ]

    for (var i = 0; i < 14; i++) {
        tHtml += "<tr style=\"height: 40px;\">";
        for (var j = 0; j < 9; j++) {
            if (j == 0) {
                tHtml += "<td class=\"times\">" + times[i] + "</td>";
            }
            else {
                var tstamp = dates[j-1];

                var dateTS = new Date(tstamp);

                dateTS.setHours(i+8);
                var currentdate = new Date();

                //console.log(">>TS>A" + tstamp);
                //console.log(">>TS>B" + dateTS.toString() + " -- " + currentdate.toString());

                if (dateTS < currentdate) {
                    console.log("yy");
                    tHtml += "<td class=\"cal deactivated\" id=\"" + dates[j-1] + "-" + (i+8) + "\"></td>";
                }
                else {
                    console.log("xx");
                    tHtml += "<td class=\"cal\" id=\"" + dates[j-1] + "-" + (i+8) + "\"><span class=\"icons\"></span><span class=\"controls\"><span style=\"color: #d9534f;\" class=\"glyphicon glyphicon-remove-circle btnContResStatus\"></span><span class=\"glyphicon glyphicon-plus btnContAdd\"></span><span class=\"glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon-trash\"></span></span></td>";
                }
            }
        }
        tHtml += "</tr>";
    }

    $("#dataTerrains tbody").html(tHtml);

    getReservationsForTerrain(currentTerrain);
    getBlockedReservationsForTerrain(currentTerrain);

    $(".btnContAdd").click(function() {
        dlg0 = new DlgAddReservation("", "", "", "");
        dlg0.showDialog();
    });

    $(".btnContResStatus").click(function() {
        dlg0 = new DlgResStatus($(this).parent().parent().attr("id"));
        dlg0.showDialog();
    });
};

function getReservationsForTerrain(tid) {
    console.log(">Beginning with request...");

    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getReservationsForTerrain",
        data       : {
            tid : tid
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("AREQ3>" + data);

            var result = JSON.parse(data);

            for (var i = 0; i < result.length; i++) {
                var cellid = result[i]["fiDate"] + "-" + result[i]["fiHour"];

                console.log("RES" + i + " CellID = " + cellid);

                $("#" + cellid).addClass("reserved");
                $("#" + cellid + " .btnContAdd").remove();
                $("#" + cellid + " .controls span:first-child").after("<span class=\"glyphicon glyphicon-zoom-in\"></span>");
                /*$("#" + cellid).find(".icons").html("<span class=\"glyphicon glyphicon-user\"></span>&nbsp;<span class=\"glyphicon glyphicon-user\"></span>");*/

                console.log(">Done!");
            }
        }
    });
};

function getReservationCounts() {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getReservationCounts",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("AREQ4>" + data);

            var result = JSON.parse(data);

            for (var i = 0; i < result.length; i++) {
                $("#T" + result[i]["fiTerrain"] + " a").append("<span style=\"margin-left: 5px\" class=\"badge pull-right\">" + result[i]["qcfCount"] + "</span>");
            }
        }
    });
};

function getBlockedReservationsForTerrain(tid) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getBlockedReservationsForTerrain",
        data       : {
            tid : tid
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("AREQ5>" + data);

            var result = JSON.parse(data);

            for (var i = 0; i < result.length; i++) {
                var cellid = "#" + result[i]["fiDate"] + "-" + result[i]["fiHour"];

                $(cellid).addClass("blocked");
                $(cellid + " .btnContResStatus").removeClass("glyphicon-remove-circle");
                $(cellid + " .btnContResStatus").addClass("glyphicon-ok-circle");
                $(cellid + " .btnContResStatus").css("color", "#5cb85c");
            }
        }
    });
};