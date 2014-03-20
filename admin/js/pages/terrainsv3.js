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

        var tid = $(this).attr("id").substring(1);

        currentTerrain = tid;

        getReservationsForTerrain(tid);
    });

    /*$(".cal").hover(function() {
        $(this).find(".controls").show();
    },
    function() {
        $(this).find(".controls").hide();
    });*/

    $(".cal").bind("contextmenu",function(e) {
        alert("test");
    });

    $(".controls").hide();

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
        for (var j = 0; j < 8; j++) {
            if (j == 0) {
                tHtml += "<td class=\"times\">" + times[i] + "</td>";
            }
            else {
                tHtml += "<td class=\"cal\" id=\"" + dates[j-1] + "-" + (i+8) + "\"><span class=\"icons\"></span><span class=\"pull-right controls\"><span style=\"color: #d9534f;\" class=\"glyphicon glyphicon-remove-circle\"></span><span class=\"glyphicon glyphicon-plus\"></span><span class=\"glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon-trash\"></span></span></td>";
            }
        }
        tHtml += "</tr>";
    }

    $("#dataTerrains tbody").html(tHtml);

    getReservationsForTerrain(currentTerrain);
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
                $("#" + cellid).find(".icons").html("<span class=\"glyphicon glyphicon-user\"></span>&nbsp;<span class=\"glyphicon glyphicon-user\"></span>");

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
}