//var oTable;

var currentTerrain = 1;

var weekday=new Array(7);

weekday[0]="DIM-1";
weekday[1]="LUN-2";
weekday[2]="MAR-3";
weekday[3]="MER-4";
weekday[4]="JEU-5";
weekday[5]="VEN-6";
weekday[6]="SAM-7";

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- New reservation --

$("#dlgAddReservation").hide();

function DlgAddReservation(datetime) {
    this.datetime = datetime;
};

DlgAddReservation.prototype.showDialog = function() {
    var currId = this.datetime;
    var dateID = currId.substr(0,10);

    currId = currId.substring(11);

    var hourID = currId.substring(0, currId.indexOf("-"));
    var dayID = currId.substring(currId.indexOf("-") +1);

    $("#dlgAddReservation").dialog({
        resizable: false,
        height: 280,
        width: 400,
        modal: true,
        buttons: {
            Ajouter: function() {
                console.log("N-RES> Dt" + dateID + " He" + hourID + " De" + dayID + " P1" + this.player1 + " P2" + this.player2);

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=addReservation",
                    data       : {
                        date    : dateID,
                        day     : dayID,
                        hour    : hourID,
                        terrain : currentTerrain,
                        player1 : $("#lsbPlayer1").val(),
                        player2 : $("#lsbPlayer2").val()
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        var result = JSON.parse(data);

                        console.log(result);

                        getReservationsForTerrain(currentTerrain);
                    }
                });

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

$("#dlgEditReservation").hide();

// -- De/Activate reservation --

$("#dlgResStatus").hide();

function DlgResStatus(id, status) {
    this.id = id;
    this.status = status;
}

DlgResStatus.prototype.showDialog = function() {
    var status = this.status;
    var currId = this.id;
    var dateID = currId.substr(0,10);

    currId = currId.substring(11);

    var hourID = currId.substring(0, currId.indexOf("-"));
    var dayID = currId.substring(currId.indexOf("-") +1);

    $("#dlgResStatus").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log("BLOCK-->DA=" + dateID + " DY=" + dayID + " HO=" + hourID + " TR=" + currentTerrain + " ST=" + status);

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=blockReservation",
                    data       : {
                        date    : dateID,
                        day     : dayID,
                        hour    : hourID,
                        terrain : currentTerrain,
                        status  : status
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        var result = JSON.parse(data);

                        console.log(result);

                        getBlockedReservationsForTerrain(currentTerrain);
                    }
                });

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

$("#dlgTerrainStatus").hide();

function DlgTerrainStatus(id, status) {
    this.id = id;
    this.status = status;
}

DlgTerrainStatus.prototype.showDialog = function() {
    var status = this.status;
    var id = this.id;

    console.log("Changing status of " + id + " to " + status);

    $("#dlgResStatus").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=blockTerrain",
                    data       : {
                        id     : id,
                        status : status
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        var result = JSON.parse(data);

                        console.log(result);

                        getBlockedReservationsForTerrain(currentTerrain);
                    }
                });

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
        if ($(this).hasClass("terrains")) {
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
        }
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
        "<li><img src=\"images/expired.jpg\"> La reservation est expiré.</li>" +
        "<li><span class=\"badge\">42</span> Indique le numéro des reservations sur le terrain.</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    $("#blockterrain").click(function() {
        console.log("Blocking terrain " + currentTerrain);

        $.ajax({
            type       : "POST",
            url        : "inc/actionswitcher.inc.php?action=getTerrainStatus",
            async      : false,
            data       : {
                id : currentTerrain
            },
            statusCode : {
                404: function() {
                    console.log("action.inc.php not found!");
                }
            },
            success    : function(data) {
                var result = JSON.parse(data);

                console.log(result[0].dtIsActive);

                var dlg0 = new DlgTerrainStatus(currentTerrain, result[0].dtIsActive);

                dlg0.showDialog();
            }
        });

        var dlg0 = new DlgTerrainStatus();

        dlg0.showDialog();
    });

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

                var currDay = weekday[d.getDay()];

                tHtml += "<th>" + currDay.substring(0,3) + " (" + result[i]["idDate"] + ")</th>";
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

                var n = weekday[dateTS.getDay()];

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
                    tHtml += "<td class=\"cal\" id=\"" + dates[j-1] + "-" + (i+8) + "-" + n.substring(4) + "\"><span class=\"icons\"></span><span class=\"controls\"><span style=\"color: #d9534f;\" class=\"glyphicon glyphicon-remove-circle btnContResStatus\"></span><span class=\"glyphicon glyphicon-plus btnContAdd\"></span><span class=\"glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon-trash\"></span></span></td>";
                }
            }
        }
        tHtml += "</tr>";
    }

    $("#dataTerrains tbody").html(tHtml);

    getReservationsForTerrain(currentTerrain);
    getBlockedReservationsForTerrain(currentTerrain);

    $(".btnContAdd").click(function() {
        dlg0 = new DlgAddReservation($(this).parent().parent().attr("id"));

        $("#edtTimestamp").val($(this).parent().parent().attr("id"));

        dlg0.showDialog();
    });

    $(".btnContResStatus").click(function() {
        if ($(this).parent().parent().hasClass("blocked")) {
            var status = "No";
        }
        else {
            var status = "Yes";
        }

        console.log("1>" + status);

        dlg0 = new DlgResStatus($(this).parent().parent().attr("id"), status);
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
                var dateTS = new Date(result[i]["fiDate"]);

                var n = weekday[dateTS.getDay()];

                var cellid = result[i]["fiDate"] + "-" + result[i]["fiHour"] + "-" + n.substring(4);

                console.log("RES" + i + " CellID = " + cellid);

                $("#" + cellid).addClass("reserved");
                $("#" + cellid + " .btnContAdd").remove();
                $("#" + cellid + " .controls span:first-child").after("<span class=\"glyphicon glyphicon-zoom-in details\"></span>");
                /*$("#" + cellid).find(".icons").html("<span class=\"glyphicon glyphicon-user\"></span>&nbsp;<span class=\"glyphicon glyphicon-user\"></span>");*/

                $(".details").click(function() {

                });

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

            $("#dataTerrains tbody td").removeClass("blocked");

            var result = JSON.parse(data);

            for (var i = 0; i < result.length; i++) {
                var dateTS = new Date(result[i]["fiDate"]);

                var n = weekday[dateTS.getDay()];

                var cellid = "#" + result[i]["fiDate"] + "-" + result[i]["fiHour"] + "-" + n.substring(4);

                $(cellid).addClass("blocked");
                $(cellid + " .btnContResStatus").removeClass("glyphicon-remove-circle");
                $(cellid + " .btnContResStatus").addClass("glyphicon-ok-circle");
                $(cellid + " .btnContResStatus").css("color", "#5cb85c");
            }
        }
    });
};